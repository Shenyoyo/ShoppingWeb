<?php

namespace App\Http\Controllers;

use App\Order;
use Auth;
use App\Level;
use App\Offer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getIndex()
    {
        $orders = Order::orderBy('id', 'desc')->paginate(10);
        return view('admin/order.index', ['orders' => $orders]);
    }
    public function showOrder($id)
    {
        $order = Order::find($id);
        $user = Auth::user()->find($order->user_id);
        $refundDollorLog = $order->dollorlog->where('tx_type',6)->first();
        $refundDollor =$refundDollorLog->amount ?? '';

        return view('admin/order.show', ['order' => $order,'user' => $user,'refundDollor' =>$refundDollor]);
    }
    public function sandProduct($id)
    {
        $order = Order::find($id);
        $user = Auth::user()->find($order->user_id);
        $order->status = '2' ;
        $order->pre_cashback_yn = $user->level->offer->cashback_yn ?? 'N';
        $order->pre_levelname = $user->level->name ?? '';
        $order->pre_above= $user->level->offer->cashback->above ?? 0;
        $order->pre_percent=$user->level->offer->cashback->percent ?? 0;
        if ($order->pre_cashback_yn == 'Y' && $order->total >=$order->pre_above) {
            $order->pre_dollor=round($order->total  * ($user->level->offer->cashback->percent ?? 0)) ;
        } else {
            $order->pre_dollor=0;
        }
        $order->pre_rebate_yn = $user->level->offer->rebate_yn ?? 'N';
        $order->pre_rebate_above= $user->level->offer->rebate->above ?? 0;
        if ($order->pre_rebate_yn == 'Y' && $order->total >=$order->pre_rebate_above) {
            $order->pre_rebate_dollor=$user->level->offer->rebate->rebate ?? 0 ;
        } else {
            $order->pre_rebate_dollor=0;
        }
        
        $order->save();

        return redirect()->back()->withSuccessMessage('已成功送貨');
    }
    public function refundAgree($id)
    {
        
        // step.1 更改商品狀態
        $order = Order::find($id);
        $order->status = '5';//已退款
        $order->save();
        // step.2 訂單退款(虛擬幣)
        $user = Auth::user()->find($order->user_id);
        $userDollor = $user->dollor->dollor;
        $refundDollor=0; //退貨金額加總
        $orderDetails =$order->orderDetail->where('refund', 'Y');
        foreach ($orderDetails as $orderDetail) {
            $orderDetailOnePrice= $orderDetail->price / $orderDetail->quantity;
            $refundDollor = $refundDollor + ($orderDetailOnePrice * intval($orderDetail->refundQuantity));
        }
        $userDollor = $userDollor + $refundDollor;
        //計入退貨要回饋到虛擬幣
        setDollorLog($user->id, '6', $refundDollor, $userDollor, $order->id, '');
        // setp.3 會員等級重新判斷
        if($order->dollor_yn == 'Y'){
            $usedollor = $order->record - $order->total ;
            if($refundDollor-$usedollor >=0 ) {
                $culLessDollor = $refundDollor-$usedollor;
            } else {
                $culLessDollor =0 ;
            }
            
            $user->total_cost = $user->total_cost - $culLessDollor;
        }else {
            $user->total_cost = ($user->total_cost) - ($refundDollor); //減去累計總消費
        }
        
        $Level = $user->level_level ?? 0;
        $LevelUpgrade = Level::find($Level)->upgrade ?? 0;
        if ($user->total_cost < $LevelUpgrade) {
            if($user->level_level < 1) {
                $user->level_level = 0;
            } else {
                $user->level_level = $user->level_level-1;
            }
            $user->save();
        } else {
            $user->save();
        }
        // step.4 虛擬幣優惠饋扣除
        //現金回饋
        //獲取當時訂單用戶等級
        $orderLevelName = $order->pre_levelname;
        $level = Level::where('name',$orderLevelName)->first();
        //END
        $percent = $level->offer->cashback->percent ?? '';
        $record = $order->record;
        $cashbackDollor=0; //扣除金額
        if ($percent != '') {
            foreach ($orderDetails as $orderDetail) {
                $record = $record - $orderDetail->price;
                $cashbackDollor = $cashbackDollor + ($orderDetail->price * $percent);
            }
        }
        if ($record >= ($level->offer->cashback->above ?? 0)) {
            $userDollor = $userDollor - $cashbackDollor; //虛擬幣回饋扣除
        } else {
            $cashbackDollor =$order->pre_dollor;
            $userDollor = $userDollor - $cashbackDollor; //虛擬幣回饋扣除
        }
        //紀錄虛擬幣優惠饋扣除(沒扣錢不記錄)
        ($cashbackDollor != 0) ? setDollorLog($user->id, '7', -$cashbackDollor, $userDollor, $order->id, '') : '';
        //end現金回饋
        //滿額送現金
        $rebateDollor = 0;
        if ($record >= ($level->offer->rebate->above ?? 0)) {
            $userDollor = $userDollor; //退貨商品後有達標準不扣錢
        } else {
            $rebateDollor =$order->pre_rebate_dollor;
            $userDollor = $userDollor - $rebateDollor; //滿額送現金扣除
        }
        //紀錄虛擬幣滿額現金扣除(沒扣錢不記錄)
        ($rebateDollor != 0) ? setDollorLog($user->id, '8', -$rebateDollor, $userDollor, $order->id, '') : '';
        $user->dollor->dollor= $userDollor ;

        $user->dollor->save();
        
        return redirect()->back()->withSuccessMessage('已成功退款');
    }
    public function refundDisagree(Request $request)
    {
        // step.1 更改商品狀態
        $order = Order::find($request->orderId);
        $order->status = '6';//拒絕退款
        $order->save();
        //將要退貨的訂單改回不退貨
        $orderDetails =$order->orderDetail->where('refund', 'Y');
        foreach ($orderDetails as $orderDetail) {
            $orderDetail->refund = 'N';
            $orderDetail->refundQuantity = '';
            $orderDetail->save();
        }
        // step.2 紀錄拒絕退貨理由
        //echo $request->nomessage;
        $order->refund->nomessage = $request->nomessage;
        $order->refund->save();
        return redirect()->back()->withSuccessMessage('已拒絕退款');
    }
    public function searchOrder(Request $request)
    {
        $query = $request->input('query');
        $orders = Order::where('id', 'LIKE', '%'.$query.'%')->paginate(10);
        return view('admin/order.index', ['orders' => $orders]);
    }
    public function orderbyStatus(Request $request)
    {
        $oderbyStatus = $request->input('oderbyStatus');
        $orders = ($oderbyStatus == '0') ? Order::orderBy('id', 'desc')->paginate(10) :
        Order::where('status', $oderbyStatus)->orderBy('id', 'desc')->paginate(10);
        
        return view('admin/order.index', ['orders' => $orders ,'oderbyStatus' => $oderbyStatus]);
    }
}
