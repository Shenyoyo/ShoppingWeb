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
    <div class="panel-title">{{__('shop.orderDetail')}}</div>
  </div>
  <table class="table mb-0">
    <thead>
      <tr class="text-center">
        <th class="text-left">{{__('shop.productcontent')}}</th>
        <th>{{__('shop.unit')}}</th>
        <th>{{__('shop.quantity')}}</th>
        <th class="text-right item-amount">{{__('shop.subtotal')}}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($order->orderDetail as $index => $item)
      <tr class="border">
        <td class="table-image ">
          <a target="_blank" href="{{ url('shop', [$item->product->id]) }}">
            <img class=" cart-image" src="{{asset('storage/'.$item->product->file->filename.'')}}">
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
    <div class="col-md-6" style="border-right: 2px solid #e9e9e9">
      <div class="col-md-12" style="font-size: 16px">{{__('shop.receiver')}}：{{ $order->receiver }}</div>
      <div class="col-md-12" style="font-size: 16px">{{__('shop.receiverAddress')}}：{{ $order->receiver_address }}</div>
      <div class="col-md-12" style="font-size: 16px">{{__('shop.ordernumber')}}：{{ $order->id }}</div>
      <div class="col-md-12" style="font-size: 16px">{{__('shop.orderstatus')}}：{{ orderStatus($order->status) }}</div>
      @if ($order->status == '4')
      <div class="col-md-12" style="font-size: 16px">{{__('shop.reasonRefund')}}：{{ $order->refund->message }}</div>
      @endif
      @if ($order->status == '6')
      <div class="col-md-12" style="font-size: 16px">{{__('shop.reasonRefund')}}：{{ $order->refund->message }}</div>
      <div class="col-md-12" style="font-size: 16px">{{__('shop.reasonRejection')}}：{{ $order->refund->nomessage }}</div>
      @endif
    </div>

    <div class="col-md-6 text-right">

      <div class="col-md-12" style="font-size: 24px">{{__('shop.orderTotal')}}：${{ presentPrice($order->total )}}</div>

      {{-- 當下紀錄 --}}
      @if ($order->status == '1')
      @if(!empty($user->level->offer->cashback_yn))
      <div class="col-md-12" style="font-size: 18px">
        @if ($user->level->offer->cashback_yn == 'Y' && $order->total >=$user->level->offer->cashback->above )
        虛擬幣回饋{{$user->level->offer->cashback->percent *100}}%：${{presentPrice(round($order->total * $user->level->offer->cashback->percent))}}
        @endif
      </div>
      @endif
      @if(!empty($user->level->offer->rebate_yn))
      <div class="col-md-12" style="font-size: 18px">
        @if ($user->level->offer->rebate_yn == 'Y' && $order->total >=$user->level->offer->rebate->above)
        滿額送現金：${{presentPrice($user->level->offer->rebate->rebate)}}
        @endif
      </div>
      @endif

      @else
      {{-- 歷史紀錄 --}}
      @if ($order->pre_cashback_yn == 'Y' && $order->total >= $order->pre_above )
      <div class="col-md-12" style="font-size: 18px">
        虛擬幣回饋{{$order->pre_percent *100}}%：${{presentPrice(round($order->pre_dollor))}}
      </div>
      @endif

      @if ($order->pre_rebate_yn == 'Y' && $order->total >= $order->pre_rebate_above)
      <div class="col-md-12" style="font-size: 18px">
        滿額送現金：${{presentPrice($order->pre_rebate_dollor)}}
      </div>
      @endif
      @endif

    </div>

    @if($order->status == '2')
    <div class="col-md-12">
      <a class="btn btn-success btn-sm pull-right"
        href="{{route('user.confirm',['id' => $order->id ])}}">{{__('shop.confirmOrder')}}</a><br><br>
    </div>
    @endif

  </div>
</div>
@if($order->status == '3')
<form action="{{route('user.refund')}}" method="post">
  {!! csrf_field() !!}
  <input type="hidden" name="orderId" value="{{ $order->id }}">
  <div class="form-group ">
    <label for="exampleFormControlTextarea1">{{__('shop.enterRefund')}}</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="refundMessage" required></textarea>
    <br>
    <button type="submit" class="btn btn-sm btn-danger pull-right">{{__('shop.applyrefund')}}</button>
  </div>
</form>


</div>
@endif
@endsection