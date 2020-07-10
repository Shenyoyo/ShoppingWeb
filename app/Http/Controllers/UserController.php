<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Cashback;
use App\Level;
use App\User;
use App\Dollor;
use App\DollorLog;
use App\Order;
use App\Refund;
use Illuminate\Http\Request;
use Auth;
use Boolfalse\LaravelShoppingCart\Facades\Cart;

class UserController extends Controller
{
    public function getSignup()
    {
        return view('user.signup');
    }

    public function postSignup(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:users',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:6|confirmed|regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
        ], [
            'name.unique' => '使用者名稱已被使用',
            'email.email' => '不是正確的電子信箱',
            'email.unique' => '信箱已重複',
            'password.min' => '密碼長度至少6碼',
            'password.confirmed' => '確認密碼不相同',
            'password.regex' => '密碼必須包含大小寫字母與整數' 
        ]);


        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'password' => bcrypt(($request->input('password'))),
            'active' => 1,//預設啟用
            'role_id' => 1,//角色使用者
            'level_level' => 0,//預設等級0級
            'total_cost' => 0,//預設總消費0
        ]);
        $user->save();

        $dollor = new Dollor();
        $dollor->user_id = $user->id;
        $dollor->dollor = 0;
        $dollor->save();

        $dollorLog = new DollorLog();
        $dollorLog->user_id = $user->id; 
        $dollorLog->sub_total = 0; 
        $dollorLog->save();


        Auth::login($user);

        return redirect()->route('user.profile');
    }

    public function getSignin()
    {
        return view('user.signin');
    }
    public function PostSignin(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|min:6',
            'captcha'  => 'required|captcha'
        ], [
            'email.email' => '不是正確的電子信箱',
            'password.min' => '密碼長度至少6碼',
            'captcha.required' => '驗證碼，不能為空',
            'captcha.captcha' => '請輸入正确的驗證碼',
        ]);
        $user = User::where('email',$request->input('email'))->first();
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'active' => '1'])) {
            Cart::restore(Auth::user()->name);
            return redirect()->intended('/');
        } elseif(($user->active ?? '') == '2') {
            return redirect()->back()->withErrors(['此帳號已被停權，請聯絡我們！'])->withInput();
        } else {
            return redirect()->back()->withErrors(['帳號/密碼錯誤，請重新輸入！'])->withInput();
        }
        
        
    }

    public function getProfile()
    {

        $user = Auth::user();
        $nextLevel = Level::find($user->level_level +1);
        return view('user.profile', ['user' => $user ,'nextLevel' => $nextLevel]);
    }
    public function getProfileEdit()
    {
        $user = Auth::user();
        $nextLevel = Level::find($user->level_level +1);
        return view('user.profileEdit', ['user' => $user ,'nextLevel' => $nextLevel]);
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->name =$request->input('name');
        $user->email =$request->input('email');
        $user->phone =$request->input('phone');
        $user->address = $request->input('address');
        $user->save();
        return redirect()->route('user.profile');
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed|regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
        ], [
            'password.min' => '密碼長度至少6碼',
            'password.confirmed' => '確認密碼不相同',
            'password.regex' => '密碼必須包含大小寫字母與整數' 
        ]);
        $user = Auth::user();
        $user->password = bcrypt(($request->input('password')));
        $user->save();
        return redirect()->route('user.profile')->withSuccessMessage('修改密碼成功');
    }
    public function getOrder()
    {
        $orders = Auth::user()->order()->orderBy('id', 'desc')->paginate(10);
        
        return view('user.order')->with([
            'orders' => $orders,
        ]);
    }
    public function getOrderDetail($id)
    {
        $order = Order::find($id);
        $user = Auth::user()->find($order->user_id);
        return view('user.show', ['order' => $order,'user' => $user]);
    }
    public function getDollor()
    {
        $startDate = Carbon::now()->toDateString();
        $endDate = Carbon::tomorrow()->toDateString();
        return view('user.dollor',['startDate' => $startDate , 'endDate' => $endDate] );   
    }
    public function searchDollor(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $user_id = Auth::user()->id;
        $dollorlogs = DollorLog::whereBetween('created_at',[$startDate, $endDate ])
        ->Where('user_id', $user_id)
        ->orderBy('id','desc')
        ->paginate(15);
       
        return view('user.dollor', [
            'dollorlogs' => $dollorlogs,
            'startDate' => $startDate ,
            'endDate' => $endDate
            ]);
    } 

    public function confirmOrder($id)
    {
        // step.1 更改商品狀態
        $order = Order::find($id);
        $order->status = '3';//已簽收
        $order->save();
        // step.2 虛擬幣回饋與滿額送現金
        $user = Auth::user();
        $cashback_yn = $user->level->offer->cashback_yn ?? 'N';
        $cashbackAbove = $user->level->offer->cashback->above ?? '0';
        if ($cashback_yn == 'Y' && $order->total >= $cashbackAbove) {
            $cashbackPercent = $user->level->offer->cashback->percent;
            $cashbackDollor = round($order->total * $cashbackPercent);
            $userDollor = $user->dollor;
            $userDollor->dollor = $userDollor->dollor + $cashbackDollor ; //給予虛擬幣回饋
             //紀錄回饋
            setDollorLog(Auth::user()->id,'4',$cashbackDollor,$userDollor->dollor,$order->id,'');
            $userDollor->save();
        }
        $rebate_yn = $user->level->offer->rebate_yn ?? 'N';
        $rebateAbove = $user->level->offer->rebate->above ?? '0';
        if ($rebate_yn == 'Y' && $order->total >= $rebateAbove) {
            $cashbackDollor = $user->level->offer->rebate->rebate;
            $userDollor = $user->dollor;
            $userDollor->dollor = $userDollor->dollor + $cashbackDollor ; //給予滿額送現金
            setDollorLog(Auth::user()->id,'5',$cashbackDollor,$userDollor->dollor,$order->id,'');
            $userDollor->save();
        }
        
        // step.3 累計用戶消費總額
        $user->total_cost = $user->total_cost + $order->total;
        $user->save();
        // setp.4 會員晉升
        $nextLevel = $user->level_level+1;
        $nextLevelUpgrade = Level::find($nextLevel)->upgrade ?? "";
        //有設定才會升等
        if (!empty($nextLevelUpgrade)) {
            if ($user->total_cost >= $nextLevelUpgrade) {
                //不能跳級
                $user->level_level = $nextLevel;
                $user->save();
            }
        }
        return redirect()->route('user.order');
    }
    public function refund(Request $request)
    {
        // step.1 更改商品狀態
        $order = Order::find($request->orderId);
        $order->status = '4';//申請退款
        $order->save();
        // step.2 紀錄退款理由
        $refund = new Refund;
        $refund->order_id = $order->id;
        $refund->message = $request->refundMessage;
        $refund->save();
        return redirect()->back()->withSuccessMessage('退款已申請成功，請稍候審核');
    }

    public function getLogout()
    {
        //清除購物車
        Cart::destroy();
        Auth::logout();
        return redirect()->back();
    }
}
