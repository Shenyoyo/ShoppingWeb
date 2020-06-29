<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Level;
use App\Product;
use Session;
use Illuminate\Http\Request;
use Boolfalse\LaravelShoppingCart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $dollor_yn =  '';
        $offer = Auth::user()->level->offer;
        $discount_yn = $offer->discount_yn;
        $above = $offer->discount->above;
        $discount = $offer->discount;
        $dollor = Auth::user()->dollor;
        $newSubtotal = Cart::subtotal();
        if ($newSubtotal < 0) {
            $newSubtotal = 0;
        }
        if ($newSubtotal < $above || $discount_yn !='Y') {
            $newTotal = $newSubtotal;
        } else {
            $newTotal = $newSubtotal * $discount->percent;
        }
        $discountMoney = $newSubtotal -$newTotal;
        return view('shop/cart')->with([
            'dollor_yn' => $dollor_yn,
            'dollor' => $dollor,
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
            'discountMoney' => $discountMoney,
            'newTotal' => $newTotal,
        ]);
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
            'quantity' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            session()->flash('error_message', '錯誤數量請聯絡管理員');
            return response()->json(['success' => false]);
        }

        Cart::update($id, $request->quantity);
        session()->flash('success_message', '數量更改成功');

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Cart::remove($id);
        return redirect('cart')->withSuccessMessage('商品已經刪除');
    }

    public function emptyCart()
    {
        Cart::destroy();
        return redirect('cart')->withSuccessMessage('購物車已清空');
    }

    public function dollor(Request $request)
    {
        $dollor_yn =  $request->dollor_yn;
        $offer = Auth::user()->level->offer;
        $discount_yn = $offer->discount_yn;
        $above = $offer->discount->above;
        $discount = $offer->discount;
        $dollor = Auth::user()->dollor;
        $newSubtotal = Cart::subtotal();
        if ($newSubtotal < 0) {
            $newSubtotal = 0;
        }
        if ($newSubtotal < $above || $discount_yn !='Y') {
            $newTotal = $newSubtotal;
        } else {
            $newTotal = $newSubtotal * $discount->percent;
        }
        $discountMoney = $newSubtotal -$newTotal;

        if ($dollor_yn == 'Y') {
            $newTotal =  $newTotal-$dollor->dollor;
            if ($newTotal < 0) {
                $dollor->dollor = abs($newTotal);
                $newTotal = 0;
            } else {
                $dollor->dollor=0;
            }
        }

        return view('shop/cart')->with([
            'dollor_yn' => $dollor_yn,
            'dollor' =>  $dollor,
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
            'discountMoney' => $discountMoney,
            'newTotal' => $newTotal,
        ]);
    }

    public function checkout(Request $request)
    {
        if (sizeof(Cart::content()) < 0) {
            return view('shop.cart');
        }
        $newTotal = $request->newTotal;
        $dollor = $request->dollor;
        Auth::user()->dollor->dollor = $dollor;
        return view('shop.checkout')->with([
            'newTotal' => $newTotal,
            'dollor' => $dollor,
        ]);
    }

    public function buy(Request $request)
    {
        
    }
}
