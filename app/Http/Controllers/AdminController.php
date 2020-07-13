<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function getIndex()
    {
        return view('admin/login');
    }
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required|min:4'
        ]);

        if (Auth::attempt(['name' => $request->input('name'), 'password' => $request->input('password'), 'active' => 1,'role_id' => 2])) {
            return redirect()->route('admin.products');
        }
        return redirect()->back();
    }
    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
