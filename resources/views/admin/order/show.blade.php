@extends('layouts.admin')
@section('title')
{{__('shop.OrderDetail')}}
@endsection
@section('content')
@if (session()->has('success_message'))
<div class="alert alert-success">
  {{ session()->get('success_message') }}
</div>
@endif
<div class="box box-info">
  <div class="box-header with-border">
    <h1 class="box-title">{{__('shop.ordernumber')}}：{{ $order->id }}</h1>
    <div class="box-tools">
      <div class="btn-group pull-right" style="margin-bottom: 10px">
        <a href="{{route('order.index')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>
          {{__('shop.Back to list')}}</a>
      </div>
    </div>
  </div>
  <br>
  <div class="box-body">
    <table class="table table-bordered ">
      <tbody>
        <tr>
          <td>{{__('shop.Buyer')}}：</td>
          @if ($order->status == '1' )
          <td>{{ $order->user->name }}({{$user->level->name}})</td>
          @else
          <td>{{ $order->user->name }}({{$order->pre_levelname}})</td>
          @endif
          <td>{{__('shop.Order Time')}}：</td>
          <td>{{ $order->created_at }}</td>
        </tr>
        <tr>
          <td>{{__('shop.Pay Type')}}：</td>
          <td colspan="3">{{__('shop.Cash on delivery')}}</td>
        </tr>
        <tr>
          <td>{{__('shop.receiver')}}：</td>
          <td>{{ $order->receiver }}</td>
          <td>{{__('shop.receiverAddress')}}：</td>
          <td>{{ $order->receiver_address }}</td>
        </tr>

        <tr>
          <td rowspan="{{ $order->orderDetail->count() + 1 }}">{{__('shop.ProductList')}}：</td>
          <td>{{__('shop.Product Name')}}</td>
          <td>{{__('shop.subtotal')}}</td>
          <td>{{__('shop.quantity')}}</td>
        </tr>
        @foreach($order->orderDetail as $item)
        <tr>
          <td>
            <div style="display: inline-block">{{ $item->product->name }}</div>
            @if ($item->refund == 'Y')
            <span style="margin-left: 30%;color:red">{{__('shop.RefundStatus')}}
              {{__('shop.quantity')}}:{{$item->refundQuantity}}</span>
            @endif
          </td>
          <td>${{ presentPrice($item->price) }}</td>
          <td>{{ $item->quantity }}</td>
        </tr>
        @endforeach

        <tr>
          <td>{{__('shop.OrderPrice')}}：</td>
          <td>${{ presentPrice($order->total) }}</td>
          <td>{{__('shop.orderstatus')}}：</td>
          <td>{{  orderStatus($order->status) }}</td>
        </tr>


        @if ($order->status == '1' )
        <tr>
          @if (($user->level->offer->cashback_yn ?? '') == 'Y' && $optimunCashbackFlag)
          <td>

            {{__('shop.Level cashback',[
              'level' =>$user->level->name,
              'above' => $user->level->offer->cashback->above,
              ])
            }}<br>
            {{
              __('shop.Level cashbackpercent',[
              'percent' =>$user->level->offer->cashback->percent *100,
              ])
            }}

          </td>

          @if ($order->total >= $user->level->offer->cashback->above)
          <td style="padding-top: 18px;" colspan="3">
            ${{ presentPrice(round($order->total * $user->level->offer->cashback->percent)) }}</td>
          @else
          <td style="padding-top: 18px;" colspan="3">${{ $order->total * 0 }}</td>
          @endif
          @endif
        </tr>
        <tr>
          @if (($user->level->offer->rebate_yn ?? '') == 'Y' && $optimunRebateFlag)
          <td>
            {{__('shop.Level rebate',[
              'level' =>$user->level->name,
              'above' => $user->level->offer->rebate->above
              ])
            }}<br>
            {{
              __('shop.Level rebatedollor',[
              'dollor' =>$user->level->offer->rebate->rebate
              ])
            }}
          </td>
          @if ($order->total >= $user->level->offer->rebate->above)
          <td style="padding-top: 18px;" colspan="3">${{ presentPrice($user->level->offer->rebate->rebate) }}</td>
          @else
          <td style="padding-top: 18px;" colspan="3">${{ $order->total * 0 }}</td>
          @endif
          @endif
        </tr>
        <tr>
          <td colspan="4">
            <a class="pull-right" href="{{route('order.sand',['id' => $order->id ])}}"><button
                class="btn btn-success">{{__('shop.Send')}}</button></a>
          </td>
        </tr>
        @else
        <tr>
          @if ($order->pre_cashback_yn == 'Y' && $preOptimunCashbackFlag)
          <td>
            {{__('shop.Level cashback',[
              'level' =>$order->pre_levelname,
              'above' => $order->pre_above,
              ])
            }}<br>
            {{
              __('shop.Level cashbackpercent',[
              'percent' =>$order->pre_percent *100,
              ])
            }}
          </td>
          <td style="padding-top: 18px;" colspan="3">${{ presentPrice(round($order->pre_dollor)) }}</td>
          @endif
        </tr>
        <tr>
          @if ($order->pre_rebate_yn == 'Y' && $preOptimunRebateFlag)
          <td>
            {{__('shop.Level rebate',[
              'level' =>$order->pre_levelname,
              'above' => $order->pre_rebate_above
              ])
            }}<br>
            {{
              __('shop.Level rebatedollor',[
              'dollor' =>$order->pre_rebate_dollor
              ])
            }}
          </td>
          <td style="padding-top: 18px;" colspan="3">${{ presentPrice($order->pre_rebate_dollor)}}</td>
          @endif
        </tr>
        @if($order->status == '4' )
        <tr>
          <td>{{__('shop.reasonRefund')}}：</td>
          <td colspan="2">{{ $order->refund->message }}</td>
          <td>
            <a href="{{route('order.refundAgree',['id' => $order->id ])}}">
              <button class="btn btn-sm btn-success" id="btn-refund-agree">{{__('shop.Agree')}}</button>
            </a>
            <form style="display: inline-block" id='refund-disagree' action="{{route('order.refundDisagree')}}"
              method="post">
              {!! csrf_field() !!}
              <button class="btn btn-sm btn-danger " id="btn-refund-disagree" type="button" value="" onClick="subForm()"
                ;>{{__('shop.Disagree')}}</button>
              <input type="hidden" name="orderId" value="{{ $order->id }}">
              <input type="hidden" name="nomessage" id="nomessage" value="">
            </form>
          </td>
        </tr>
        @elseif($order->status =='5')
        <tr>
          <td>{{__('shop.reasonRefund')}}：</td>
          <td>{{ $order->refund->message }}</td>
          <td>{{__('shop.Refund Total')}}：</td>
          <td>{{ $refundDollor}}{{__('shop.yuan')}}</td>
        </tr>
        <tr>


        </tr>
        @elseif($order->status =='6')

        @endif
        @endif



      </tbody>
    </table>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/show.js') }}"></script>
@endsection