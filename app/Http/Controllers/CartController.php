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
        $discount_yn = $offer->discount_yn ?? 'N';
        $above = $offer->discount->above ?? 0;
        $percent = $offer->discount->percent ?? 0;
        $dollor = Auth::user()->dollor;
        $newSubtotal = Cart::subtotal();
        ($newSubtotal < 0) ? $newSubtotal = 0 : '' ;
        $original_total = Cart::subtotal();

        //擇優優惠判斷
        $optimunDiscountFlag =getOptimun($offer->optimun_yn ?? 'N','discount',$offer,$newSubtotal);
        if($optimunDiscountFlag){
            if ($newSubtotal < $above || $discount_yn !='Y') {
                $newTotal = $newSubtotal;
            } else {
                $newTotal = $newSubtotal * $percent;
            }
        }else{
            $newTotal = $newSubtotal;
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
            'optimunDiscountFlag' => $optimunDiscountFlag,
            'original_total' => $original_total,
        ]);
    }

    public function dollor(Request $request)
    {
        $dollor_yn =  $request->dollor_yn;
        $offer = Auth::user()->level->offer;
        $discount_yn = $offer->discount_yn ?? 'N';
        $above = $offer->discount->above ?? 0;
        $percent = $offer->discount->percent ?? 0;
        $dollor = Auth::user()->dollor;
        $newSubtotal = Cart::subtotal();
        ($newSubtotal < 0) ? $newSubtotal = 0 : '' ;
        $original_total = Cart::subtotal();

        //擇優優惠判斷
        $optimunDiscountFlag =getOptimun($offer->optimun_yn ?? 'N','discount',$offer,$newSubtotal);
        if($optimunDiscountFlag){
            if ($newSubtotal < $above || $discount_yn !='Y') {
                $newTotal = $newSubtotal;
            } else {
                $newTotal = $newSubtotal * $percent;
            }
        }else{
            $newTotal = $newSubtotal;
        }
        if ($dollor_yn == 'Y') {
            $original_total =  $original_total - $dollor->dollor;
            if ($original_total < 0) {
                $original_total = 0;
            } 
        }
        //計入若退貨需要返回的錢
        $recordReturnTotal = round($newTotal);
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
            'above'  => $above,
            'percent' => $percent,
            'newSubtotal' => $newSubtotal,
            'discountMoney' => $discountMoney,
            'newTotal' => $newTotal,
            'recordReturnTotal' => $recordReturnTotal,
            'optimunDiscountFlag' => $optimunDiscountFlag,
            'original_total' => $original_total,
        ]);
    }

    public function store(Request $request)
    {
        //檢查是否超出庫存
        $product= Product::find($request->id);
        if($product->amount < $request->quantity){
            return redirect()->back()->withErrors(__('shop.overflow'));
        }
        //檢查重複商品
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->id;
        });


        if (!$duplicates->isEmpty()) {
            return redirect('cart')->withSuccessMessage(__('shop.aleadyincart'));
        }
        Cart::add($request->id, $request->name, $request->quantity, $request->price)->associate(Product::class);
        Cart::store(Auth::user()->name);
        return redirect('cart')->withSuccessMessage(__('shop.addtocart'));
    }

    public function update(Request $request, $id)
    {
        
        // Validation on max quantity
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            session()->flash('error_message', '錯誤數量請重新輸入');
            return response()->json(['success' => false]);
        }

        //檢查是否超出庫存
        $product= Product::find($request->productId);
        if($product->amount < $request->quantity){
            return redirect()->back()->withErrors(__('shop.overflow'));
        }

        Cart::update($id, $request->quantity);
        session()->flash('success_message', __('shop.updatecart'));
        Cart::store(Auth::user()->name);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Cart::remove($id);
        Cart::store(Auth::user()->name);
        return redirect('cart')->withSuccessMessage(__('shop.removecart'));
    }

    public function emptyCart()
    {
        Cart::destroy();
        Cart::store(Auth::user()->name);
        return redirect('cart')->withSuccessMessage(__('shop.emptycart'));
    }

    

    public function checkout(Request $request)
    {
        
        foreach (Cart::content() as $item ) {
            //檢查有無庫存防呆
            if($item->model->amount == 0){
               return redirect()->route('cart.index')->withErrors($item->model->name.__('shop.nostockcart'));
            }
            //檢查有開賣防呆
            if($item->model->buy_yn != 'Y'){
                return redirect()->route('cart.index')->withErrors($item->model->name.__('shop.nobuycart'));
            }
            //檢查有顯示防呆
            if($item->model->display_yn != 'Y'){
                return redirect()->route('cart.index')->withErrors($item->model->name.__('shop.nodispalycart'));
            }
        }
        $dollor_yn= $request->dollor_yn;
        $newTotal = $request->newTotal;
        $dollor = $request->dollor;
        //顯示與上方
        $recordReturnTotal = $request->recordReturnTotal;
        $original_total = $request->original_total;
        Auth::user()->dollor->dollor = $dollor;
        // echo $request->recordReturnTotal;
        return view('shop.checkout')->with([
            'dollor_yn' => $dollor_yn,
            'newTotal' => $newTotal,
            'dollor' => $dollor,
            'recordReturnTotal' => $recordReturnTotal,
            'original_total' => $original_total,
        ]);
    }

    public function buy(Request $request)
    {
        $offer = Auth::user()->level->offer;
        $newSubtotal = Cart::subtotal();
        //setp.1 建立訂單
        $order = new Order;
        $order->record = $request->recordReturnTotal;//紀錄退貨金額使用
        $order->total = $request->newTotal;
        $order->receiver = $request->receiver;
        $order->receiver_address = $request->receiverAddress;
        $order->status = 1 ;//1.訂單確認中 2.送貨中 3.已簽收 4.退貨
        $order->dollor_yn = $request->dollor_yn;
        $order->original_total = $request->original_total;
        Auth::user()->order()->save($order);
        //setp.2 建立訂單明細
        foreach (Cart::content() as $item) {
            $orderDetail = new OrderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $item->model->id ;
            $orderDetail->quantity = $item->qty;
            $optimunDiscountFlag =getOptimun($offer->optimun_yn ?? 'N','discount',$offer,$newSubtotal);
            if($optimunDiscountFlag){
                if($newSubtotal < ($offer->discount->above ?? '') ||($offer->discount_yn ?? '') != 'Y'){
                    $orderDetail->price =$item->subtotal;
                }else{
                    $orderDetail->price =$item->subtotal * $offer->discount->percent;
                }
            }else{
                $orderDetail->price =$item->subtotal;
            }
            
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
