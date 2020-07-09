@extends('layouts.master')

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
    
    <form action="{{route('user.dollorSearch')}}" method="get" class="search-form">
        <input id="date" type="date" name="startDate" value="{{$startDate}}" required> ~
        <input id="date" type="date" name="endDate"   value="{{$endDate}}" required>
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div style="margin-top:10px;" class="row"">
    <div class="col-md-12 text-center" >
        <table class="table table-striped ">
            <thead style="background: #e9e9e9 ;" class="text-light">
                <td>時間</td>
                <td>交易類別</td>
                <td>金額</td>
                <td>現有額度</td>
                <td>備註</td>
                <td>更多</td>
            </thead>
            <tbody>
                @if (isset($dollorlogs))
                @foreach ($dollorlogs as $dollorlog)
                <tr>
                    <td>{{$dollorlog->created_at}}</td>
                    <td>{{txStatus($dollorlog->tx_type)}}</td>
                    @if ($dollorlog->amount < 0)
                    <td style="color:red" >{{presentPrice($dollorlog->amount)}}</td>
                    @else
                    <td >{{presentPrice($dollorlog->amount)}}</td>   
                    @endif
                    <td>{{presentPrice($dollorlog->sub_total)}}</td>
                    <td>{{(empty($dollorlog->order)) ? '' : '單號:'.$dollorlog->order }}</td>
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
    {{ $dollorlogs->appends(['startDate' => $startDate ,'endDate' => $endDate])->links()  }}
    @endif
</div>

@endsection