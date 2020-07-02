@extends('layouts.master')

@section('title')
訂單詳情
@endsection
@section('content')
@if (session()->has('success_message'))
  <div class="alert alert-success">
      {{ session()->get('success_message') }}
  </div>
@endif
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title">訂單詳情</div>
    </div>
    <table class="table mb-0">
      <thead>
        <tr class="text-center">
          <th class="text-left">商品內容</th>
          <th>單價</th>
          <th>數量</th>
          <th class="text-right item-amount">小計</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->orderDetail as $index => $item)
        <tr class="border">
          <td class="table-image ">
            <a target="_blank" href="{{ url('shop', [$item->product->id]) }}">
              <img class=" cart-image" src="{{ $item->product->imageurl }}">
            </a>&emsp;
          <a target="_blank" href="{{ url('shop', [$item->product->id]) }}">{{ $item->product->name }}</a>
          </td>
          <td class=" align-middle">${{  presentPrice($item->product->price) }}</td>
          <td class=" align-middle">{{  $item->quantity }}</td>
          <td class="text-right align-middle">${{ presentPrice($item->price)  }}</td>
        </tr>
        @endforeach
        
      </tbody>
    </table>

    <div class="row">
      <div class="col-md-6" style="border-right: 2px solid #e9e9e9" >
          <div class="col-md-12" style="font-size: 16px">收件人：{{ $order->receiver }}</div>
          <div class="col-md-12" style="font-size: 16px">收貨地址：{{ $order->receiver_address }}</div>
          <div class="col-md-12" style="font-size: 16px">訂單號碼：{{ $order->id }}</div>
          <div class="col-md-12" style="font-size: 16px">訂單狀態：{{ orderStatus($order->status) }}</div>
          @if ($order->status == '4')
          <div class="col-md-12" style="font-size: 16px">退款理由：{{ $order->refund->message }}</div>    
          @endif
          @if ($order->status == '6')
          <div class="col-md-12" style="font-size: 16px">退款理由：{{ $order->refund->message }}</div>   
          <div class="col-md-12" style="font-size: 16px">拒絕退款理由：{{ $order->refund->nomessage }}</div>    
          @endif
      </div>

      <div class="col-md-6 text-right">

        <div class="col-md-12" style="font-size: 24px">訂單總價：${{ presentPrice($order->total )}}</div>
        <div class="col-md-12" style="font-size: 18px">
              {{-- 當下紀錄 --}}
          @if ($order->status == '1')
              @if(!empty($user->level->offer->cashback_yn))
                @if ($user->level->offer->cashback_yn == 'Y' && $order->total >=$user->level->offer->cashback->above )
                虛擬幣回饋{{$user->level->offer->cashback->percent *100}}%：${{presentPrice(round($order->total * $user->level->offer->cashback->percent))}}
                @endif
              @endif

              @if(!empty($user->level->offer->rebate_yn))
                @if ($user->level->offer->rebate_yn == 'Y' && $order->total >=$user->level->offer->rebate->above)
                滿額送現金：${{presentPrice($user->level->offer->rebate->rebate)}}
                @endif
              @endif
          @else
              {{-- 歷史紀錄 --}}
              @if ($order->pre_cashback_yn == 'Y' && $order->total >= $order->pre_above )
              虛擬幣回饋{{$order->pre_percent *100}}%：${{presentPrice(round($order->pre_dollor))}}
              @endif  

              @if ($order->pre_rebate_yn == 'Y' && $order->total >= $order->pre_rebate_above)
              滿額送現金：${{presentPrice($order->pre_rebate_dollor)}}
              @endif 
          @endif
          
        </div>

        @if($order->status == '2')
        <div class="col-md-12">
          <a class="btn btn-success btn-sm" href="{{route('user.confirm',['id' => $order->id ])}}">確認簽收</a><br><br>
        </div>
        @endif

      </div>
    </div>
    
  </div>
  @if($order->status == '3')
  <form action="{{route('user.refund')}}" method="post">
    {!! csrf_field() !!}
    <input type="hidden" name="orderId" value="{{ $order->id }}">
    <div class="form-group ">
      <label for="exampleFormControlTextarea1">請輸入退款理由</label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="refundMessage" required></textarea>
      <br>
      <button type="submit" class="btn btn-sm btn-danger pull-right" >申請退款</button>
    </div>
    
  </form>
  
  @endif
@endsection
