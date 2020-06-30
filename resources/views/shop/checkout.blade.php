@extends('layouts.master')

@section('title')
    結帳
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <h1>結 帳-貨到付款</h1>
            <h4>數 量： {{Cart::instance('default')->count(false)}} 件商品</h4>
            <h4>總 額： ${{  presentPrice($newTotal) }}元</h4>
            @if (session()->has('error_message'))
            <div class="alert alert-danger">
            {{ session()->get('error_message') }}
            </div>
            @endif
            <form action="{{route('cart.buy')}}" method="post" id="checkout-form">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="name">收件人</label>
                            <input type="text" id="receiver" class="form-control" required name="receiver" value="{{Auth::user()->name}}">
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="address">收件地址</label>
                            <input type="text" id="receiverAddress" class="form-control" required name="receiverAddress" value="{{Auth::user()->address}}">
                        </div>
                    </div>
                    <hr>
                </div>
                <input type="hidden" name="newTotal"" value="{{ $newTotal }}"> 
                <input type="hidden" name="dollor"" value="{{ $dollor }}">    
                <input type="hidden" name="recordReturnTotal" value="{{ $recordReturnTotal }}">
                {{ csrf_field() }}
                <a href="{{ url('cart')}}" class="btn btn-danger ">取消</a> &nbsp;
                <button type="submit" class="btn btn-success pull-right">購買</button>
            </form>
        </div>
    </div>
@endsection
