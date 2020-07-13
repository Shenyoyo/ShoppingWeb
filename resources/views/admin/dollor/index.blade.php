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
    
    <form action="{{ route('dollor.search') }}" method="get" class="search-form">
        <input id="date" type="date" name="startDate" value="{{$startDate }}" required> ~
        <input id="date" type="date" name="endDate"   value="{{$endDate }}" required>
        <input type="text" name="name" id="name" value="{{ request()->input('name') }}" class="search-box" placeholder="用戶名" >
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
                <td>交易日期</td>
                <td>單號</td>
                <td>備註</td>
            </thead>
            <tbody>
                @if (isset($dollorlogs))
                    @if(count($dollorlogs) != 0)
                        @foreach ($dollorlogs as $dollorlog)
                        <tr>
                            <td>{{$dollorlog->id}}</td>
                            <td>{{$dollorlog->user->name}}</td>
                            <td>{{txStatus($dollorlog->tx_type)}}</td>
                            @if ($dollorlog->amount < 0)
                            <td style="color:red" >{{presentPrice($dollorlog->amount)}}</td>
                            @else
                            <td >{{presentPrice($dollorlog->amount)}}</td>   
                            @endif
                            <td>{{presentPrice($dollorlog->sub_total)}}</td>
                            <td>{{$dollorlog->created_at}}</td>
                            <td>{{(empty($dollorlog->order)) ? '' : '單號:'.$dollorlog->order }}</td>
                            <td>{{$dollorlog->memo}}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td  colspan="8">查無資料</td>
                        </tr>
                    @endif    
                @endif
                </tbody>
            </table>
    </div>
</div>
<div class="text-center">
    @if (isset($dollorlogs))
        @if(count($dollorlogs) != 0)
        {{ $dollorlogs->appends([
            'startDate' => $startDate ,
            'endDate' => $endDate,
            'name' => request()->input('name'),
            ])->links()  }}
        @endif     
    @endif
</div>

@endsection