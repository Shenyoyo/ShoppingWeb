@extends('layouts.master')

@section('content')
    {{-- <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2>My Orders</h2>
            @foreach($orders as $order)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($order->orderDetail as $item)
                                <li class="list-group-item">
                                    <span class="badge">${{ $item->price }}</span>
                                    {{ $item->product->name }} | {{ $item->quantity }} 
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="panel-footer">
                        <strong>Total Price: ${{ $order->total}}</strong>
                    </div>
                </div>
            @endforeach
        </div>
    </div> --}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">訂單列表</div>
        </div>
        <div class="panel-body" >
            @foreach($orders as $order)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">訂單號碼：{{$order->id}} <span class="pull-right">{{ $order->created_at->format('Y/m/d H:i:s') }}</span></div> 
                </div>
                <div class="panel-body" >
                    <table class="table mb-0">
                        <thead>
                          <tr class="text-center">
                            <th class="text-left">商品內容</th>
                            <th>單價</th>
                            <th>數量</th>
                            <th>總計</th>
                            <th>狀態</th>
                            <th>操作</th>
                          </tr>
                        </thead>
                    </table>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
@endsection