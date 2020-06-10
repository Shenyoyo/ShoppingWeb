@extends('layouts.master')

@section('title')
     購物網站    
@endsection

@section('content')
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <h1> 嗨嗨這裡是商品區</h1>
    <div class="row">
        <div class="col-md-12">
            @foreach ($products as $product)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail" >
                        <img src="{{$product->imageurl}}" class="img-thumbnail">
                        <div class="caption">
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <h3>{{$product->name}}</h3>
                                </div>
                                <div class="col-md-6 col-xs-6 price">
                                    <h3>
                                        <label>￥{{$product->price}}</label></h3>
                                </div>
                            </div>
                            <p>{{$product->description}}</p>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <a href="/addProduct/{{$product->id}}" class="btn btn-success btn-product"><span class="fa fa-shopping-cart"></span> 購買</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
     </div>
@endsection