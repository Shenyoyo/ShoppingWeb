@extends('layouts.admin')
@section('title')
    訂單管理
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
<h1>訂單管理</h1>
<div style="margin-top:20px;">
    <form style="display: inline-block" action="{{route('order.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box" placeholder="訂單號碼" oninput = "value=value.replace(/[^\d]/g,'')">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
    <form class="pull-right" action="{{route('order.orderby')}}" method="POST" class="search-form">
        {!! csrf_field() !!}
        <select class="form-control" name="oderbyStatus" id="oderbyStatus" onchange="this.form.submit()" >
            <option value="0">全部</option>
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
                <td>訂單號碼</td>
                <td>買家</td>
                <td>總金額</td>
                <td>收件人</td>
                <td>收件人地址</td>
                <td>訂購時間</td>
                <td>狀態</td>
                <td>操作</td>
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
                    <td>{{orderStatus($order->status)}}</td>
                    <td>
                       @if ($order->status == '1')
                       <a href="{{route('order.sand',['id' => $order->id ])}}"><button class="btn btn-success btn-sm">送貨</button></a> 
                       <a href="{{route('order.show',['id' => $order->id ])}}"><button class="btn btn-primary btn-sm">明細</button></a> 
                       @else
                       <a href="{{route('order.show',['id' => $order->id ])}}"><button class="btn btn-primary btn-sm">明細</button></a>     
                       @endif
                       </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
<div class="text-center">
    {{ $orders->links() }}
</div>

@endsection