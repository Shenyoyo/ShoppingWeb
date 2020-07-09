@extends('layouts.master')

@section('title')
    我的訂單
@endsection
@section('content')
    <h1>{{__('shop.myorder')}}</h1>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">{{__('shop.orderlist')}}</div>
        </div>
        <div class="panel-body" >
            @foreach($orders as $order)
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <div class="panel-title">{{__('shop.ordernumber')}}：{{$order->id}} <span class="pull-right">{{ $order->created_at->format('Y/m/d H:i:s') }}</span></div> 
                </div>
                <div class="panel-body"  >
                    <table class="table mb-0 border" style="margin-bottom:0px">
                        <thead >
                          <tr class="text-center">
                            <th class="text-left">{{__('shop.productcontent')}}</th>
                            <th class="text-center">{{__('shop.unit')}}</th>
                            <th class="text-center">{{__('shop.quantity')}}</th>
                            <th class="text-center">{{__('shop.total')}}</th>
                            <th class="text-center">{{__('shop.status')}}</th>
                            <th class="text-center">{{__('shop.operate')}}</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetail as $index => $item )
                                <tr>
                                  <td class="table-image">
                                      <a target="_blank" href="{{ url('shop', [$item->product->id]) }}">
                                        <img class=" cart-image" src="{{asset('storage/'.$item->product->file->filename.'')}}">
                                      </a>&emsp;
                                    <a target="_blank" href="{{ url('shop', [$item->product->id]) }}">{{ $item->product->name }}</a>
                                  </td>
                                  <td class="sku-price text-center">${{ presentPrice($item->product->price) }}</td>
                                  <td class="sku-amount text-center">{{ $item->quantity }}</td>
                                  
                                  @if($index === 0)
                                  <td rowspan="{{ count($order->orderDetail) }}" class="text-center total-amount border">
                                    ${{ presentPrice($order->total) }}
                                  </td>
                                  <td rowspan="{{ count($order->orderDetail) }}" class="text-center border">
                                    {{orderStatus($order->status)}}
                                  </td>

                                  <td rowspan="{{ count($order->orderDetail) }}" class="text-center border">
              
                                    {{-- 訂單 --}}
                                    @if(($order->status == '2'))
                                    <a class="btn btn-success btn-sm" href="{{route('user.confirm',['id' => $order->id ])}}">{{__('shop.confirmOrder')}}</a><br><br>
                                    <a class="btn btn-primary btn-sm" href="{{route('user.orderDetail',['id' => $order->id ])}}">{{__('shop.checkOrder')}}</a>
                                    @else
                                    <a class="btn btn-primary btn-sm" href="{{route('user.orderDetail',['id' => $order->id ])}}">{{__('shop.checkOrder')}}</a>
                                    @endif
                                    
                                  </td>
                                  @endif
                                </tr>
                            @endforeach
                          </tbody>
                    </table>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
    <div class="text-center">
      {{ $orders->links()  }}
  </div>
@endsection