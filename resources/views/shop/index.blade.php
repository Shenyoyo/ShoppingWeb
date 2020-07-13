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
                <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box" placeholder="{{ __('shop.search') }}">
                <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
            </form>
        </div>
        @if ($id == '')
        <div class="col-md-3 pull-right">
            <strong>Price: </strong>
            <a href="{{ route('shop.orderby', ['sort'=> 'asc'])}}">{{__('shop.lowtohigh') }}</a> 
            <a href="{{ route('shop.orderby', ['sort'=> 'desc']) }}">{{__('shop.hightolow') }}</a>
        </div>
        @else
        <div class="col-md-3 pull-right">
            <strong>Price: </strong>
            <a href="{{ route('shop.category', ['id' => $id ,'orderby' => 'asc'])}}">{{__('shop.lowtohigh') }}</a> 
            <a href="{{ route('shop.category', ['id' => $id ,'orderby' => 'desc']) }}">{{__('shop.hightolow') }}</a>
        </div>    
        @endif
        
        
    </div>
    <hr>
    <ul class="nav nav-pills">
        @foreach ($categories as $category)
        @if ($id == $category->id)
        <li class="active" ><a href="{{ route('shop.category', ['id' => $category->id ,'orderby' => 'asc']) }}">{{ $category->name }}</a></li>
        @else
        <li class="#" ><a href="{{ route('shop.category', ['id' => $category->id ,'orderby' => 'asc']) }}">{{ $category->name }}</a></li>    
        @endif
        @endforeach
        
    </ul>
    <br>
    @foreach ($products->chunk(4) as $items)
        <div class="row">
            @foreach ($items as $product)
                <div class="col-md-3">
                    <div class="thumbnail">
                        <div class="caption text-center">
                            <a href="{{ route('shop.show', [$product->id]) }}"><img src="{{asset('storage/'.$product->file->filename.'')}}" alt="product" class="img-responsive"></a>
                            <a href="{{ route('shop.show', [$product->id]) }}"><h3>{{ $product->name }}</h3>
                            <p>${{ $product->price }}</p>
                            </a>
                        </div> <!-- end caption -->
                    </div> <!-- end thumbnail -->
                </div> <!-- end col-md-3 -->
            @endforeach
        </div> <!-- end row -->
    @endforeach
    <div class="text-center">
        {{ $products->links() }}
    </div>
@endsection
