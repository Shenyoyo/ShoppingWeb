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
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4'

        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt(($request->input('password'))),
            'active' => 1 
        ]);
        $user->save();

        return redirect()->route('shop.index');
    }

    public function getSignin()
    {
        return view('user.signin');
    }
    public function PostSignin(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|min:4'
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
}