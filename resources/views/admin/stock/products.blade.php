@extends('layouts.admin')

@section('title')
    庫存管理
@endsection

@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
<h1>庫存管理</h1>
<div class="row">
    <div class="col-md-6">
        <a href="{{route('admin.new')}}"><button class="btn btn-success">新增商品</button></a>
    </div>
</div>
<div style="margin-top:10px;">
    <form action="{{route('admin.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box" placeholder="商品名稱">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div style="margin-top:10px;" class="row">
    <div class="col-md-12 text-center" >
        <table class="table table-striped ">
            <thead class="bg-info">
                <td>名稱</td>
                <td>價格</td>
                <td>庫存數量</td>
                <td>分類</td>
                <td>商品是否要顯示</td>
                <td>商品是否可購買</td>
                <td>圖片</td>
                <td>操作</td>
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
                        <a href="{{route('admin.edit',['id' => $product->id ])}}"><button class="btn btn-primary btn-sm">修改</button></a> 
                        <a href="{{route('admin.destroy',['id' => $product->id ])}}" onclick="javascript:return del()"><button class="btn btn-danger btn-sm">删除</button></a>                
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