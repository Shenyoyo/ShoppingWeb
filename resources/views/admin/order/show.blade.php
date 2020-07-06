@extends('layouts.admin')
@section('title')
    訂單明細
@endsection
@section('content')
@if (session()->has('success_message'))
  <div class="alert alert-success">
      {{ session()->get('success_message') }}
  </div>
@endif
<div class="box box-info">
  <div class="box-header with-border">
    <h1 class="box-title">訂單號碼：{{ $order->id }}</h1>
    <div class="box-tools">
      <div class="btn-group pull-right" style="margin-bottom: 10px">
        <a href="{{route('order.index')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 返回列表</a>
      </div>
    </div>
  </div>
  <br>
  <div class="box-body">
    <table class="table table-bordered ">
      <tbody>
      <tr>
        <td>買家：</td>
        @if ($order->status == '1' )
        <td>{{ $order->user->name }}({{$user->level->name}})</td>
        @else
        <td>{{ $order->user->name }}({{$order->pre_levelname}})</td>
        @endif
        <td>購買時間：</td>
        <td>{{ $order->created_at }}</td>
      </tr>
      <tr>
        <td>支付方式：</td>
        <td colspan="3">貨到付款</td>
      </tr>
      <tr>
        <td>收件人：</td>
        <td >{{ $order->receiver }}</td>
        <td>收件地址：</td>
        <td >{{ $order->receiver_address }}</td>
      </tr>

      <tr>
        <td rowspan="{{ $order->orderDetail->count() + 1 }}">商品列表：</td>
        <td>商品名稱</td>
        <td>單價</td>
        <td>數量</td>
      </tr>
      @foreach($order->orderDetail as $item)
      <tr>
        <td>
          <div>{{ $item->product->name }}</div>
        </td>
        <td>${{ presentPrice($item->price) }}</td>
        <td>{{ $item->quantity }}</td>
      </tr>
      @endforeach

      <tr>
        <td>訂單金額：</td>
        <td>${{ presentPrice($order->total) }}</td>
        <td>訂單狀態：</td>
        <td>{{  orderStatus($order->status) }}</td>
      </tr>

      <tr>
      @if ($order->status == '1' )
          @if (($user->level->offer->cashback_yn ?? '') == 'Y')
          <td>{{$user->level->name}}滿額{{$user->level->offer->cashback->above}}以上<br>
            虛擬幣回饋{{$user->level->offer->cashback->percent *100}}%
          </td>
              @if ($order->total >= $user->level->offer->cashback->above)
              <td style="padding-top: 18px;" colspan="3" >${{ presentPrice(round($order->total * $user->level->offer->cashback->percent)) }}</td>   
              @else
              <td style="padding-top: 18px;" colspan="3" >${{ $order->total * 0 }}</td>     
              @endif
          @endif
      </tr>
      <tr>
          @if (($user->level->offer->rebate_yn ?? '') == 'Y')
          <td>{{$user->level->name}}滿額{{$user->level->offer->rebate->above}}以上<br>
            滿額送現金{{$user->level->offer->rebate->rebate}}元
          </td>
              @if ($order->total >= $user->level->offer->rebate->above)
              <td style="padding-top: 18px;" colspan="3" >${{ presentPrice($user->level->offer->rebate->rebate) }}</td>   
              @else
              <td style="padding-top: 18px;" colspan="3" >${{ $order->total * 0 }}</td>     
              @endif
          @endif
      <tr>
        <td colspan="4">
          <a class="pull-right" href="{{route('order.sand',['id' => $order->id ])}}"><button class="btn btn-success">送貨</button></a> 
        </td>
      </tr>
      @else
      <tr>
          @if ($order->pre_cashback_yn == 'Y')
          <td>{{$order->pre_levelname}}滿額{{$order->pre_above}}以上<br>
            虛擬幣回饋{{$order->pre_percent *100}}%
          </td>
              <td style="padding-top: 18px;" colspan="3" >${{ presentPrice(round($order->pre_dollor)) }}</td>   
          @endif
      </tr>
      <tr>
          @if ($order->pre_rebate_yn == 'Y')
          <td>{{$order->pre_levelname}}滿額{{$order->pre_rebate_above}}以上<br>
            滿額送現金{{$order->pre_rebate_dollor}}元
          </td>
              <td style="padding-top: 18px;" colspan="3" >${{ presentPrice($order->pre_rebate_dollor)}}</td>   
          @endif
      </tr>
          @if($order->status == '4')
          <tr>
            <td>退款理由：</td>
            <td colspan="2">{{ $order->refund->message }}</td>
            <td>
              <a href="{{route('order.refundAgree',['id' => $order->id ])}}">
                <button class="btn btn-sm btn-success" id="btn-refund-agree">同意</button>
              </a>
              <form style="display: inline-block" id='refund-disagree' action="{{route('order.refundDisagree')}}" method="post">
                {!! csrf_field() !!}
                <button class="btn btn-sm btn-danger " name="nomessage"  id="btn-refund-disagree" type="button" value="" onClick="subForm()";>不同意</button>
                <input type="hidden" name="orderId" value="{{ $order->id }}"> 
              </form>
            </td>
          </tr>
      @endif
      @endif  
      </tr>

      
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('scripts')
<script  src="{{ asset('js/show.js') }}"></script>
@endsection

