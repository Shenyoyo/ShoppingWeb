<?php

namespace App\Http\Controllers;

use Auth;
use App\Order;
use App\OrderDetail;
use App\Product;
use Illuminate\Http\Request;
use Boolfalse\LaravelShoppingCart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $dollor_yn =  '';
        $offer = Auth::user()->level->offer;
        if(!empty($offer)){
            $discount_yn = $offer->discount_yn;
            $above = $offer->discount->above;
            $percent = $offer->discount->percent;
        }else{
            $discount_yn = 'N';
            $above = 0;
            $percent = 0;
        }
       
        $dollor = Auth::user()->dollor;
        $newSubtotal = Cart::subtotal();
        if ($newSubtotal < 0) {
            $newSubtotal = 0;
        }
        if ($newSubtotal < $above || $discount_yn !='Y') {
            $newTotal = $newSubtotal;
        } else {
            $newTotal = $newSubtotal * $percent;
        }
        //計入若退貨需要返回的錢
        $recordReturnTotal = round($newTotal);
        $discountMoney = $newSubtotal -$newTotal;
        return view('shop/cart')->with([
            'dollor_yn' => $dollor_yn,
            'dollor' => $dollor,
            'above'  => $above,
            'percent' => $percent,
            'newSubtotal' => $newSubtotal,
            'discountMoney' => $discountMoney,
            'newTotal' => round($newTotal),
            'recordReturnTotal' => $recordReturnTotal,
        ]);
    }

    public function dollor(Request $request)
    {
        $dollor_yn =  $request->dollor_yn;
        $offer = Auth::user()->level->offer;
        if(!empty($offer)){
            $discount_yn = $offer->discount_yn;
            $above = $offer->discount->above;
            $percent = $offer->discount->percent;
        }else{
            $discount_yn = 'N';
            $above = 0;
            $percent = 0;
        }
        $dollor = Auth::user()->dollor;
        $newSubtotal = Cart::subtotal();
        if ($newSubtotal < 0) {
            $newSubtotal = 0;
        }
        if ($newSubtotal < $above || $discount_yn !='Y') {
            $newTotal = $newSubtotal;
        } else {
            $newTotal = $newSubtotal * $percent;
        }
        $discountMoney = $newSubtotal -$newTotal;
        //計入若退貨需要返回的錢
        $recordReturnTotal = round($newTotal);

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
            'above'  => $above,
            'percent' => $percent,
            'newSubtotal' => $newSubtotal,
            'discountMoney' => $discountMoney,
            'newTotal' => $newTotal,
            'recordReturnTotal' => $recordReturnTotal,
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
        Cart::store(Auth::user()->name);
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
        Cart::store(Auth::user()->name);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Cart::remove($id);
        Cart::store(Auth::user()->name);
        return redirect('cart')->withSuccessMessage('商品已經刪除');
    }

    public function emptyCart()
    {
        Cart::destroy();
        Cart::store(Auth::user()->name);
        return redirect('cart')->withSuccessMessage('購物車已清空');
    }

    

    public function checkout(Request $request)
    {
        //檢查有無庫存防呆
        foreach (Cart::content() as $item ) {
            if($item->model->amount == 0){
               return redirect()->route('cart.index')->withErrors($item->model->name.'已無庫存，無法結帳。');
            }
        }
        $dollor_yn= $request->dollor_yn;
        $newTotal = $request->newTotal;
        $dollor = $request->dollor;
        //顯示與上方
        $recordReturnTotal = $request->recordReturnTotal;
        Auth::user()->dollor->dollor = $dollor;
        // echo $request->recordReturnTotal;
        return view('shop.checkout')->with([
            'dollor_yn' => $dollor_yn,
            'newTotal' => $newTotal,
            'dollor' => $dollor,
            'recordReturnTotal' => $recordReturnTotal,
        ]);
    }

    public function buy(Request $request)
    {
        
        //setp.1 建立訂單
        $order = new Order;
        $order->record = $request->recordReturnTotal;//紀錄退貨金額使用
        $order->total = $request->newTotal;
        $order->receiver = $request->receiver;
        $order->receiver_address = $request->receiverAddress;
        $order->status = 1 ;//1.訂單確認中 2.送貨中 3.已簽收 4.退貨
        Auth::user()->order()->save($order);
        //setp.2 建立訂單明細
        foreach (Cart::content() as $item) {
            $orderDetail = new OrderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $item->model->id;
            $orderDetail->quantity = $item->qty;
            $orderDetail->price =$item->subtotal;
            $orderDetail->save();
            //更新庫存，減去賣出去的商品
            $product = Product::find($orderDetail->product_id);
            $product->amount = ($product->amount) - ($orderDetail->quantity);
            $product->save();
        }
        //setp.3 更新會員虛擬幣
        $dollor =Auth::user()->dollor;
        $userDollor = $dollor->dollor;//原始餘額

        $dollor->dollor = round($request->dollor);
        //紀錄是否花費虛擬幣，有使用才會紀錄
        if($request->dollor_yn == 'Y'){
            if(($userDollor - $request->recordReturnTotal) > 0){
                $buyusedollor = $request->recordReturnTotal;
            }else{
                $buyusedollor = $userDollor;
            }
            setDollorLog(Auth::user()->id,'3',-$buyusedollor,$dollor->dollor,$order->id,'');
        }
        
        $dollor->save();
        Cart::destroy();

        return redirect()->route('user.order');
    }
}
