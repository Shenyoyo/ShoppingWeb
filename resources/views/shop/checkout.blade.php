@extends('layouts.master')

@section('title')
    結帳
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-5 col-md-offset-4 col-sm-offset-3">
            <h1>{{__('shop.cashondelivery') }}</h1>
            <h4>{{__('shop.quantity') }}： {{Cart::instance('default')->count(false)}} {{__('shop.piece') }}</h4>
            <h4>{{__('shop.total') }}： ${{  presentPrice($newTotal) }}{{ __('shop.dollor') }}</h4>
            @if ($dollor_yn == 'Y')
            <h4>{{__('shop.usevirtual') }}</h4>
            @endif
            
            @if (session()->has('error_message'))
            <div class="alert alert-danger">
            {{ session()->get('error_message') }}
            </div>
            @endif
            <form action="{{route('cart.buy')}}" method="post" id="checkout-form">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="name">{{__('shop.receiver') }}</label>
                            <input type="text" id="receiver" class="form-control" required name="receiver" value="{{Auth::user()->name}}">
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="address">{{__('shop.receiverAddress') }}</label>
                            <input type="text" id="receiverAddress" class="form-control" required name="receiverAddress" value="{{Auth::user()->address}}">
                        </div>
                    </div>
                    <hr>
                </div>
                <input type="hidden" name="dollor_yn" value="{{ $dollor_yn }}"> 
                <input type="hidden" name="newTotal"" value="{{ $newTotal }}"> 
                <input type="hidden" name="dollor"" value="{{ $dollor }}">    
                <input type="hidden" name="recordReturnTotal" value="{{ $recordReturnTotal }}">
                <input type="hidden" name="original_total" value="{{ $original_total }}">
                {{ csrf_field() }}
                <a href="{{ url('cart')}}" class="btn btn-danger ">{{__('shop.cancel') }}</a> &nbsp;
                <button type="submit" class="btn btn-success pull-right">{{__('shop.buy') }}</button>
            </form>
        </div>
    </div>
@endsection
