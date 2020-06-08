@extends('layouts.master')

@section('title')
    後台
@endsection

@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <a href="{{route('admin.new')}}"><button class="btn btn-success">新增商品</button></a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
           <table class="table table-striped ">
           <thead class="bg-info">
           <td>名稱</td>
           <td>價格</td>
           <td>文件</td>
           <td>操作</td>
           </thead>
           <tbody>
               @foreach ($products as $product)
                   <tr>
                       <td>{{$product->name}}</td>
                       <td>￥{{$product->price}}</td>
                       <td>{{$product->file->original_filename}}</td>
                       <td><a href="{{route('admin.destroy',['id' => $product->id ])}}"><button class="btn btn-danger">删除</button></a> </td>
                   </tr>
               @endforeach
           </tbody>
           </table>
    </div>
</div>
@endsection