<?php

namespace App\Http\Controllers;

use Auth;
use App\Product;
use Illuminate\Http\Request;
use Boolfalse\LaravelShoppingCart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function index()
    {
        
        return view('shop/cart');
    }

    public function store(Request $request)
    {
        //檢查重複商品
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->id;
        });

        if (!$duplicates->isEmpty()) {
            return redirect('cart')->withSuccessMessage('商品已經在購物車了!');
        }
        Cart::add($request->id, $request->name, $request->quantity, $request->price)->associate(Product::class);
        
        return redirect('cart')->withSuccessMessage('成功新增到你的購物車了!');
    }

    public function update(Request $request, $id)
    {
        // Validation on max quantity
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

         if ($validator->fails()) {
            session()->flash('error_message', '請輸入1~5');
            return response()->json(['success' => false]);
         }

        Cart::update($id, $request->quantity);
        session()->flash('success_message', '數量更改成功');

        return response()->json(['success' => true]);

    }

    public function destroy($id)
    {
        Cart::remove($id);
        return redirect('cart')->withSuccessMessage('Item has been removed!');
    }

    public function emptyCart()
    {
        Cart::destroy();
        return redirect('cart')->withSuccessMessage('Your cart has been cleared!');
    }

}
