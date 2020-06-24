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
    {{-- 搜尋 篩選 --}}
    <div class="row">
        <div class="col-md-3">
            <form action="{{route('shop.search')}}" method="GET" class="search-form">
                <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box" placeholder="搜尋">
                <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
            </form>
        </div>
        <div class="col-md-2 pull-right">
            <select class="form-control form-control-sm orderby" name="orderby" >
                <option value="">排序方式</option>
                <option value="asc">價格由低到高</option>
                <option value="desc">價格由高到低</option>
              </select>
        </div>
        
    </div>
    <hr>

    @foreach ($products->chunk(4) as $items)
        <div class="row">
            @foreach ($items as $product)
                <div class="col-md-3">
                    <div class="thumbnail">
                        <div class="caption text-center">
                            <a href="{{ route('shop.show', [$product->id]) }}"><img src="{{$product->imageurl}}" alt="product" class="img-responsive"></a>
                            <a href="{{ route('shop.show', [$product->id]) }}"><h3>{{ $product->name }}</h3>
                            <p>${{ $product->price }}</p>
                            </a>
                        </div> <!-- end caption -->
                    </div> <!-- end thumbnail -->
                </div> <!-- end col-md-3 -->
            @endforeach
        </div> <!-- end row -->
    @endforeach
@endsection
