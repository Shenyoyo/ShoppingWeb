@extends('layouts.admin')
@section('title')
{{__('shop.Order Management')}}
@endsection
@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
@section('content')
@if (session()->has('success_message'))
  <div class="alert alert-success">
      {{ session()->get('success_message') }}
  </div>
@endif
<h1>{{__('shop.Order Management')}}</h1>
<div style="margin-top:20px;">
    <form style="display: inline-block" action="{{route('order.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box" placeholder="{{__('shop.ordernumber')}}" oninput = "value=value.replace(/[^\d]/g,'')">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
    <form class="pull-right" action="{{route('order.orderby')}}" method="GET" class="search-form">
        <select class="form-control" name="oderbyStatus" id="oderbyStatus" onchange="this.form.submit()" >
            <option value="0">{{__('shop.alloffer')}}</option>
            @for ($i = 1; $i <= 5 ; $i++)
                <option {{($oderbyStatus ?? '') == $i ? 'selected' : ''}} value="{{$i}}">{{orderStatus($i)}}</option>
            @endfor
        </select>
    </form>
</div>
<div style="margin-top:10px;" class="row"">
    <div class="col-md-12 text-center" >
        <table class="table table-striped ">
            <thead class="bg-info">
                <td>{{__('shop.ordernumber')}}</td>
                <td>{{__('shop.Buyer')}}</td>
                <td>{{__('shop.total')}}</td>
                <td>{{__('shop.receiver')}}</td>
                <td>{{__('shop.receiverAddress')}}</td>
                <td>{{__('shop.Order Management')}}</td>
                <td>{{__('shop.status')}}</td>
                <td>{{__('shop.operate')}}</td>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->user->name}}</td>
                    <td>{{presentPrice($order->total)}}</td>
                    <td>{{$order->receiver}}</td>
                    <td>{{$order->receiver_address}}</td>
                    <td>{{$order->created_at}}</td>
                    <td style="{{($order->status == '4') ? 'color:red' : '' }}">{{orderStatus($order->status)}}</td>
                    <td>
                       @if ($order->status == '1')
                       <a href="{{route('order.sand',['id' => $order->id ])}}"><button class="btn btn-success btn-sm">{{__('shop.Send')}}</button></a> 
                       <a href="{{route('order.show',['id' => $order->id ])}}"><button class="btn btn-primary btn-sm">{{__('shop.Detail')}}</button></a> 
                       @else
                       <a href="{{route('order.show',['id' => $order->id ])}}"><button class="btn btn-primary btn-sm">{{__('shop.Detail')}}</button></a>     
                       @endif
                       </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
<div class="text-center">
    @if (isset($oderbyStatus))
    {{ $orders->appends(['oderbyStatus' => $oderbyStatus ])->links() }}
    @else
    {{ $orders->links() }}
    @endif
    
</div>

@endsection