<?php

namespace App\Http\Controllers;

use App\Order;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getIndex()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return view('admin/order.index', ['orders' => $orders]);
    }
    public function showOrder($id)
    {
        $order = Order::find($id);
        $user = Auth::user()->find($order->user_id);
        return view('admin/order.show', ['order' => $order,'user' => $user]);
    }
    public function sandProduct($id)
    {
        $order = Order::find($id);
        $order->status = '2' ;
        $order->save();

        return redirect()->route('order.index');
    }
    public function searchOrder(Request $request)
    {
        $query = $request->input('query');
        $orders = Order::where('id', 'LIKE', '%'.$query.'%')->get();
        return view('admin/order.index', ['orders' => $orders]);
    }
}
