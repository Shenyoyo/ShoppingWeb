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

    @if (session()->has('error_message'))
            <div class="alert alert-danger">
                {{ session()->get('error_message') }}
            </div>
    @endif
    <div class="jumbotron text-center clearfix">
        <h2>嗨嗨這裡是商品區</h2>
    </div> <!-- end jumbotron -->

    @foreach ($products->chunk(4) as $items)
        <div class="row">
            @foreach ($items as $product)
                <div class="col-md-3">
                    <div class="thumbnail">
                        <div class="caption text-center">
                            <a href="{{ route('shop.show', [$product->id]) }}"><img src="{{$product->imageurl}}" alt="product" class="img-responsive"></a>
                            <a href="{{ route('shop.show', [$product->id]) }}"><h3>{{ $product->name }}</h3>
                            <p>{{ $product->price }}</p>
                            </a>
                        </div> <!-- end caption -->
                    </div> <!-- end thumbnail -->
                </div> <!-- end col-md-3 -->
            @endforeach
        </div> <!-- end row -->
    @endforeach
@endsection