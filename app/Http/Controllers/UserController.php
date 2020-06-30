<?php

namespace App\Http\Controllers;

use App\Cashback;
use App\Level;
use App\User;
use App\Dollor;
use App\Order;
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
            'name' => 'required|max:255',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4|confirmed'

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
            'password' => 'required|min:4',
            'captcha'  => 'required|captcha'
        ], [
            'captcha.required' => '驗證碼，不能為空',
            'captcha.captcha' => '請輸入正确的驗證碼',
        ]);

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'active' => 1])) {
            Cart::restore(Auth::user()->name);
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function getProfile()
    {
        return view('user.profile');
    }
    public function getOrder()
    {
        $orders = Auth::user()->order()->orderBy('id', 'desc')->get();
        
        return view('user.order')->with([
            'orders' => $orders,
        ]);
    }
    public function confirmOrder($id)
    {
        // step.1 更改商品狀態
        $order = Order::find($id);
        $order->status = '3';//已簽收
        $order->save();
        // step.2 虛擬幣回饋確認
        $user = Auth::user();
        $cashback_yn = $user->level->offer->cashback_yn;
        $cashbackAbove = $user->level->offer->cashback->above;
        if ($cashback_yn == 'Y' && $order->total >= $cashbackAbove) {
            $cashbackPercent = $user->level->offer->cashback->percent;
            $cashbackDollor = round($order->total * $cashbackPercent);
            $userDollor = $user->dollor;
            $userDollor->dollor = $userDollor->dollor + $cashbackDollor ; //給予虛擬幣回饋
            $userDollor->save();
        }
        // step.3 累計用戶消費總額
        $user->total_cost = $user->total_cost + $order->total;
        $user->save();
        // setp.4 會員晉升
        $nextLevel = $user->level_level+1;
        $nextLevelUpgrade = Level::find($nextLevel)->upgrade;
        //有設定才會升等 
        if (!empty($nextLevelUpgrade)) {
            if ($user->total_cost > $nextLevelUpgrade) {
                //不能跳級
                $user->level_level = $nextLevel;
                $user->save();
            }
        }
       
        return redirect()->route('user.order');
    }

    public function getLogout()
    {
        //清除購物車
        Cart::destroy();
        Auth::logout();
        return redirect()->back();
    }
}
