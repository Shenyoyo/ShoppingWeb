<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class AdminUserController extends Controller
{
    public function getIndex()
    {
        $users = User::paginate(10);
        return view('admin/user.index', ['users' => $users]);
    }
}
