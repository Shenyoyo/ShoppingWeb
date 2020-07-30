@extends('layouts.admin')

@section('title')
    庫存管理
@endsection

@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
<h1>{{__('shop.Stock Management')}}</h1>
<div class="row">
    <div class="col-md-6">
        <a href="{{route('admin.new')}}"><button class="btn btn-success">{{__('shop.Add Product')}}</button></a>
    </div>
</div>
<div style="margin-top:10px;">
    <form action="{{route('admin.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box" placeholder="{{__('shop.Product Name')}}">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div style="margin-top:10px;" class="row">
    <div class="col-md-12 text-center" >
        <table class="table table-striped ">
            <thead class="bg-info">
                <td>{{__('shop.Product Name')}}</td>
                <td>{{__('shop.price')}}</td>
                <td>{{__('shop.Stock Quantity')}}</td>
                <td>{{__('shop.Category')}}</td>
                <td>{{__('shop.Product Dispaly')}}</td>
                <td>{{__('shop.Product Buy')}}</td>
                <td>{{__('shop.Image')}}</td>
                <td>{{__('shop.operate')}}</td>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>￥{{presentPrice($product->price)}}</td>
                    <td style="{{($product->amount == 0) ? 'color:red' : '' }}"">{{$product->amount}}</td>
                    <td>
                        @foreach ($product->category as $category)
                        {{$category->name}} 
                        @endforeach
                    </td>
                    <td>{{$product->display_yn}}</td>
                    <td>{{$product->buy_yn}}</td>
                    <td>{{$product->file->original_filename}}</td>
                    <td>
                        <a href="{{route('admin.edit',['id' => $product->id ])}}"><button class="btn btn-primary btn-sm">{{__('shop.Edit')}}</button></a> 
                        <a href="{{route('admin.destroy',['id' => $product->id ])}}" onclick="javascript:return del()"><button class="btn btn-danger btn-sm">{{__('shop.Delete')}}</button></a>                
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="text-center">
    {{ $products->links() }}
</div>
@endsection

@section('scripts')
<script  src="{{ asset('js/product.js') }}"></script>
@endsection