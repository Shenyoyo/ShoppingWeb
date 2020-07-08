@extends('layouts.admin')

@section('title')
    虛擬幣紀錄
@endsection

@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
@if (session()->has('success_message'))
  <div class="alert alert-success">
      {{ session()->get('success_message') }}
  </div>
@endif
<h1>虛擬幣紀錄</h1>
<div style="margin-top:10px;">
    
    <form action="{{ route('dollor.search') }}" method="post" class="search-form">
        {!! csrf_field() !!}
        <input id="date" type="date" name="startDate" value="{{$startDate }}" required> ~
        <input id="date" type="date" name="endDate"   value="{{$endDate }}" required>
        <input type="text" name="name" id="name"  class="search-box" placeholder="用戶名" >
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div style="margin-top:10px;" class="row"">
    <div class="col-md-12 text-center" >
        <table class="table table-striped ">
            <thead class="bg-info">
                <td>ID</td>
                <td>用戶名</td>
                <td>交易類別</td>
                <td>金額</td>
                <td>小計</td>
                <td>執行時間</td>
                <td>註解</td>
            </thead>
            <tbody>
                @if (isset($dollorlogs))
                @foreach ($dollorlogs as $dollorlog)
                <tr>
                    <td>{{$dollorlog->id}}</td>
                    <td>{{$dollorlog->user->name}}</td>
                    <td>{{txStatus($dollorlog->tx_type)}}</td>
                    <td>{{presentPrice($dollorlog->amount)}}</td>
                    <td>{{presentPrice($dollorlog->sub_total)}}</td>
                    <td>{{$dollorlog->created_at}}</td>
                    <td>{{$dollorlog->memo}}</td>
                </tr>
                @endforeach    
                @endif
                </tbody>
            </table>
    </div>
</div>
<div class="text-center">
    @if (isset($dollorlogs))
    {{ $dollorlogs->links()  }}
    @endif
</div>

@endsection