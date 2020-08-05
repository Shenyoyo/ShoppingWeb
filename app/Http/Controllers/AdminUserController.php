<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Level;
class AdminUserController extends Controller
{
    public function getIndex()
    {
        $users = User::WithoutAdmin()->paginate(10);
        return view('admin/user.index', ['users' => $users]);
    }
    public function editUser($id)
    {
        $user = User::find($id);
        $levels = Level::all();
        return view('admin/user.edit', ['user' => $user , 'levels' =>$levels ]);
    }
    public function updateUser(Request $request)
    {
        $user = User::find($request->input('id'));
        $this->validate($request, [
            'name' => 'required|max:255|regex:/^[\x7f-\xffA-Za-z0-9 ()（）\s]+$/|unique:users,name,'.$user->id,
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
        $user->total_cost = $request->input('total_cost');
        $user->level_level = $request->input('level');
        $user->active = $request->input('active') ?? '1' ; 
        $user->save();
        return redirect()->route('adminUser.index');
    }
    public function resetPassword($id)
    {
        $user = User::find($id);
        return view('admin/user.resetpw', ['user' => $user]);
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
        ], [
            'password.min' => __('shop.passwordmin'),
            'password.regex' => __('shop.passwordregex')
        ]);
        $user = User::find($request->input('id'));
        $user->password = bcrypt(($request->input('password')));
        $user->save();
        return redirect()->route('adminUser.index')->withSuccessMessage('更改用戶'.$user->name.'成功');
    }
    public function searchUser(Request $request)
    {
        $query = $request->input('query');

        $users = User::WithoutAdmin()->where('name', 'LIKE', '%'.$query.'%')->paginate(10);

        return view('admin/user.index', ['users' => $users]);
    }

    public function getDepositIndex($id)
    {
        $user = User::find($id);
        return view('admin/user.deposit', ['user' => $user]);
    }
    
    public function postDeposit(Request $request)
    {
      
        $user = User::find($request->input('id'));
        $user->dollor->dollor =$user->dollor->dollor + $request->input('deposit');
        setDollorLog($user->id,'1',$request->input('deposit'),$user->dollor->dollor,'',$request->input('memo'));
        $user->dollor->save();
        return redirect()->route('adminUser.index')->withSuccessMessage('人工存取'.$user->name.'成功');
    }
    public function getWithdrawIndex($id)
    {
        $user = User::find($id);
        return view('admin/user.withdraw', ['user' => $user]);
    }
    
    public function postWithdraw(Request $request)
    {
        $user = User::find($request->input('id'));
        $user->dollor->dollor =$user->dollor->dollor - $request->input('withdraw');
        setDollorLog($user->id,'2',-($request->input('withdraw')),$user->dollor->dollor,'',$request->input('memo'));
        $user->dollor->save();
        return redirect()->route('adminUser.index')->withSuccessMessage('人工提取'.$user->name.'成功');
    }
    
}
