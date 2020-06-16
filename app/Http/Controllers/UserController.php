<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

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
            'adress' => $request->input('adress'),
            'password' => bcrypt(($request->input('password'))),
            'active' => 1,//預設啟用
            'role_id' => 1,//角色使用者
            'level' => 0,//預設等級0級
        ]);
        $user->save();

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
        ],[
            'captcha.required' => '驗證碼，不能為空',
            'captcha.captcha' => '請輸入正确的驗證碼',
        ]);

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'active' => 1])) {
            return redirect()->route('user.profile');
        }
        return redirect()->back();
    }

    public function getProfile()
    {
        return view('user.profile');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->back();
    }
}
