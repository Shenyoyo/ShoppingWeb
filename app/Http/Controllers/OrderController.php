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
        $refundDollorLog = $order->dollorlog->where('tx_type', 6)->first();
        $refundDollor =$refundDollorLog->amount ?? '';
        $optimunCashbackFlag =getOptimun($user->level->offer->optimun_yn ?? 'N','cashback',$user->level->offer,$order->original_total);
        $optimunRebateFlag =getOptimun($user->level->offer->optimun_yn ?? 'N','rebate',$user->level->offer,$order->original_total);
        //歷史
        $preOptimunCashbackFlag =getPreOptimun($order->pre_optimun_yn ?? 'N','cashback',$order,$order->original_total);
        $preOptimunRebateFlag =getPreOptimun($order->pre_optimun_yn ?? 'N','rebate',$order,$order->original_total);

        return view('admin/order.show', [
            'order' => $order,
            'user' => $user,
            'refundDollor' =>$refundDollor,
            'optimunCashbackFlag' => $optimunCashbackFlag,
            'optimunRebateFlag' => $optimunRebateFlag,
            'preOptimunCashbackFlag' => $preOptimunCashbackFlag,
            'preOptimunRebateFlag' => $preOptimunRebateFlag
        ]);
    }
    public function sandProduct($id)
    {
        $order = Order::find($id);
        $user = Auth::user()->find($order->user_id);
        $order->status = '2' ;
        //紀錄虛擬幣回饋
        $order->pre_cashback_yn = $user->level->offer->cashback_yn ?? 'N';
        $order->pre_levelname = $user->level->name ?? '';
        $order->pre_above= $user->level->offer->cashback->above ?? 0;
        $order->pre_percent=$user->level->offer->cashback->percent ?? 0;
        if ($order->pre_cashback_yn == 'Y' && $order->total >=$order->pre_above) {
            $order->pre_dollor=round($order->total  * ($user->level->offer->cashback->percent ?? 0)) ;
        } else {
            $order->pre_dollor=0;
        }
        //紀錄滿額送現金
        $order->pre_rebate_yn = $user->level->offer->rebate_yn ?? 'N';
        $order->pre_rebate_above= $user->level->offer->rebate->above ?? 0;
        if ($order->pre_rebate_yn == 'Y' && $order->total >=$order->pre_rebate_above) {
            $order->pre_rebate_dollor=$user->level->offer->rebate->rebate ?? 0 ;
        } else {
            $order->pre_rebate_dollor=0;
        }
        //紀錄打折
        $order->pre_discount_yn = $user->level->offer->discount_yn ?? 'N';
        $order->pre_discount_above = $user->level->offer->discount->above ?? 0;
        $order->pre_discount_percent = $user->level->offer->discount->percent ?? 0;
        
        $order->pre_optimun_yn = $user->level->offer->optimun_yn ?? 'N';
        
        $order->save();

        return redirect()->back()->withSuccessMessage(__('shop.Successful delivery'));
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
        $user->total_cost = $user->total_cost - $refundDollor; //減去累計總消費
        
        $Level = $user->level_level ?? 0;
        $LevelUpgrade = Level::find($Level)->upgrade ?? 0;
        if ($user->total_cost < $LevelUpgrade) {
            if ($user->level_level < 1) {
                $user->level_level = 0;
            } else {
                $user->level_level = $user->level_level-1;
            }
            $user->save();
        } else {
            $user->save();
        }
        // step.4 虛擬幣優惠饋扣除
        $preOptimunCashbackFlag = getPreOptimun($order->pre_optimun_yn ?? 'N','cashback',$order,$order->original_total);
        $preOptimunRebateFlag = getPreOptimun($order->pre_optimun_yn ?? 'N','rebate',$order,$order->original_total);
        $preCashbackPercent = $order->pre_percent ?? '';
        $record = $order->record;
        $cashbackDollor=0; //扣除金額
        //檢查這筆訂單有沒有虛擬回饋
        foreach ($orderDetails as $orderDetail) {
            $orderDetailOnePrice = $orderDetail->price / $orderDetail->quantity;
            $orderDetailPrice = $orderDetailOnePrice * intval($orderDetail->refundQuantity);
            $record = $record - $orderDetailPrice;
            //計算退貨要收回的虛擬幣
            if (($preCashbackPercent != '') && ($order->pre_cashback_yn == 'Y') && $preOptimunCashbackFlag) {
                $cashbackDollor = $cashbackDollor + ($orderDetailPrice * $preCashbackPercent);
            }
        }
        
        if ($record >= ($order->pre_above ?? 0) ) {
            $userDollor = $userDollor - $cashbackDollor; //計算虛擬幣回饋扣除
        } else {
            if ($preOptimunCashbackFlag) {
                $cashbackDollor =$order->pre_dollor;
            }
            $userDollor = $userDollor - $cashbackDollor; //整筆虛擬幣回饋扣除
        }
     
        //紀錄虛擬幣優惠饋扣除(沒扣錢不記錄)
        ($cashbackDollor != 0) ? setDollorLog($user->id, '7', -$cashbackDollor, $userDollor, $order->id, '') : '';
        //end現金回饋
        //滿額送現金
        $rebateDollor = 0;
        if (($order->pre_rebate_yn == 'Y' )&& $preOptimunRebateFlag ) {
            if ($record >= ($order->pre_rebate_above ?? 0)) {
                $userDollor = $userDollor; //退貨商品後有達標準不扣錢
            } else {
                if ($preOptimunRebateFlag) {
                    $rebateDollor =$order->pre_rebate_dollor;
                }
                $userDollor = $userDollor - $rebateDollor; //滿額送現金扣除
            }
        }
        //紀錄虛擬幣滿額現金扣除(沒扣錢不記錄)
        ($rebateDollor != 0) ? setDollorLog($user->id, '8', -$rebateDollor, $userDollor, $order->id, '') : '';
        $user->dollor->dollor= $userDollor ;

        $user->dollor->save();
        
        return redirect()->back()->withSuccessMessage(__('shop.Successful refund'));
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
        return redirect()->back()->withSuccessMessage(__('shop.Refused to refund'));
    }
    public function searchOrder(Request $request)
    {
        $query = $request->input('query');
        $orders = Order::where('id', 'LIKE', '%'.$query.'%')->orderBy('id', 'desc')->paginate(10);
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
