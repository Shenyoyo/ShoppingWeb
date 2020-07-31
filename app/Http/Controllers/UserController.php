<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Cashback;
use App\Contact;
use App\Level;
use App\User;
use App\Dollor;
use App\DollorLog;
use App\Order;
use App\Refund;
use App\ContactDetail;
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
            'name' => 'required|max:255|unique:users,name|regex:/^((?![~!@#$%^&*()_+-?><,.]).)*$/',
            'email' => 'email|required|unique:users,email',
            'password' => 'required|min:6|confirmed|regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
            'phone' => 'required|digits_between:10,12|numeric'
        ], [
            'name.regex' => __('shop.nameregex'),
            'name.unique' => __('shop.nameunique'),
            'email.email' => __('shop.emailvalidation'),
            'email.unique' => __('shop.emailunique'),
            'password.min' => __('shop.passwordmin'),
            'password.confirmed' => __('shop.passowrdcomfirmed'),
            'password.regex' => __('shop.passwordregex')
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
            'email.email' => __('shop.emailvalidation'),
            'password.min' => __('shop.passwordmin'),
            'captcha.required' => __('shop.captcharequired'),
            'captcha.captcha' => __('shop.captchavalidation'),
        ]);
        $user = User::where('email',$request->input('email'))->first();
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'active' => '1'])) {
            Cart::restore(Auth::user()->name);
            return redirect()->intended('/');
        } elseif(($user->active ?? '') == '2') {
            return redirect()->back()->withErrors([__('shop.suspended')])->withInput();
        } else {
            return redirect()->back()->withErrors([__('shop.accountpassworderror')])->withInput();
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
        $this->validate($request, [
            'name' => 'required|max:255|regex:/^((?![~!@#$%^&*()_+-?><,.]).)*$/|unique:users,name,'.$user->id,
            'email' => 'email|required|unique:users,email,'.$user->id,
            'phone' => 'required|digits_between:10,12|numeric'
        ], [
            'name.regex' => __('shop.nameregex'),
            'name.unique' => __('shop.nameunique'),
            'email.email' => __('shop.emailvalidation'),
            'email.unique' => __('shop.emailunique'),
        ]);
        
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
            'password.min' => __('shop.passwordmin'),
            'password.confirmed' => __('shop.passowrdcomfirmed'),
            'password.regex' => __('shop.passwordregex')
        ]);
        $user = Auth::user();
        $user->password = bcrypt(($request->input('password')));
        $user->save();
        return redirect()->route('user.profile')->withSuccessMessage(__('shop.reset'));
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
        $optimunCashbackFlag =getOptimun($user->level->offer->optimun_yn ?? 'N','cashback',$user->level->offer,$order->original_total);
        $optimunRebateFlag =getOptimun($user->level->offer->optimun_yn ?? 'N','rebate',$user->level->offer,$order->original_total);
        //歷史
        $preOptimunCashbackFlag =getPreOptimun($order->pre_optimun_yn ?? 'N','cashback',$order,$order->original_total);
        $preOptimunRebateFlag =getPreOptimun($order->pre_optimun_yn ?? 'N','rebate',$order,$order->original_total);
        return view('user.orderShow', [
            'order' => $order,
            'user' => $user,
            'optimunCashbackFlag' => $optimunCashbackFlag,
            'optimunRebateFlag' => $optimunRebateFlag,
            'preOptimunCashbackFlag' => $preOptimunCashbackFlag,
            'preOptimunRebateFlag' => $preOptimunRebateFlag
        ]);
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
    public function getMessage()
    {
        $userId = Auth::user()->id;
        $useEmail = Auth::user()->email;
        $contacts = Contact::where('user_id',$userId)->orWhere('email',$useEmail)->orderBy('updated_at','desc')->paginate(15) ;
        return view('user.message',['contacts' => $contacts] );   
    } 
    public function getMessageShow($id)
    {
        $contact = Contact::find($id);
        $contactDetails = $contact->contactDetail()->paginate(8);
        return view('user.messageShow',['contact' =>$contact,'contactDetails' => $contactDetails]);   
    } 
    public function replyContact(Request $request)
    {
        $this->validate($request,[
            'message' => 'required' ,
        ]);
        $contact = Contact::find($request->id); 
        $contactDetail = new ContactDetail();
        $contactDetail ->name = Auth::user()->name;
        $contactDetail ->message = $request->message;
        $contactDetail ->role = '1';
        $contact->contactDetail()->save($contactDetail);
        return redirect()->back()->withSuccessMessage(__('shop.Successful reply'));
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
        //擇優優惠判斷
        $optimunCashbackFlag =getOptimun($user->level->offer->optimun_yn ?? 'N','cashback',$user->level->offer,$order->original_total);
        if($optimunCashbackFlag){
            if ($cashback_yn == 'Y' && $order->total >= $cashbackAbove) {
                $cashbackPercent = $user->level->offer->cashback->percent;
                $cashbackDollor = round($order->total * $cashbackPercent);
                $userDollor = $user->dollor;
                $userDollor->dollor = $userDollor->dollor + $cashbackDollor ; //給予虛擬幣回饋
                 //紀錄回饋
                setDollorLog(Auth::user()->id,'4',$cashbackDollor,$userDollor->dollor,$order->id,'');
                $userDollor->save();
            }
        }
        //擇優優惠判斷
        $optimunRebateFlag =getOptimun($user->level->offer->optimun_yn ?? 'N','rebate',$user->level->offer,$order->original_total);
        if ($optimunRebateFlag) {
            $rebate_yn = $user->level->offer->rebate_yn ?? 'N';
            $rebateAbove = $user->level->offer->rebate->above ?? '0';
            if ($rebate_yn == 'Y' && $order->total >= $rebateAbove) {
                $cashbackDollor = $user->level->offer->rebate->rebate;
                $userDollor = $user->dollor;
                $userDollor->dollor = $userDollor->dollor + $cashbackDollor ; //給予滿額送現金
                setDollorLog(Auth::user()->id, '5', $cashbackDollor, $userDollor->dollor, $order->id, '');
                $userDollor->save();
            }
        }
        
        // step.3 累計用戶消費總額
        $user->total_cost = $user->total_cost + $order->record;
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
        return redirect()->back();
    }
    public function refund(Request $request)
    {
        $this->validate($request, [
            'product' => 'required',
            'refundMessage' => 'required'
        ],[
            'product.required' => __('shop.productrequired')
        ]);
        // step.1 更改商品狀態
        $order = Order::find($request->orderId);
        $order->status = '4';//申請退款
        $order->save();
        // step.2 紀錄退款理由
        $refund = new Refund;
        $refund->order_id = $order->id;
        $refund->message = $request->refundMessage;
        // step.3 紀錄選取的退貨商品
        $check = $request->product;
        $checkOrderDetails = $order->orderDetail->whereIn('product_id',$check);
        foreach ($checkOrderDetails as $checkOrderDetail ) {
            $checkOrderDetailProductId= $checkOrderDetail->product_id;
            $checkQuantity = $request->$checkOrderDetailProductId; //紀錄選取的退貨商品的數量
            $checkOrderDetail->refund = 'Y';
            $checkOrderDetail->refundQuantity =  $checkQuantity;
            $checkOrderDetail->save();
        }
        $refund->save();
        return redirect()->back()->withSuccessMessage( __('shop.refund'));
    }

    public function getLogout()
    {
        //清除購物車
        Cart::destroy();
        Auth::logout();
        return redirect()->back();
    }
}
