@extends('layouts.admin')

@section('title')
分類管理
@endsection

@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
<h1>分類管理</h1>
<div class="row">
    <div class="col-md-6">
        <a href="{{route('category.new')}}"><button class="btn btn-success">新增分類</button></a>
    </div>
</div>
<div style="margin-top:10px;">
    <form action="{{route('category.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box"
            placeholder="名稱"">
        <button type=" submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div class="row" style="margin-top:10px;">
    <div class="col-md-7 text-center">
        <table class="table table-striped ">
            <thead class="bg-info">
                <td>編號</td>
                <td>名稱</td>
                <td>是否顯示</td>
                <td>操作</td>
            </thead>
            <tbody>
                @foreach ($categories as $category )
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->display_yn}}</td>
                    <td>
                        <a href="{{route('category.edit',['id' => $category->id ])}}"><button
                                class="btn btn-primary btn-sm">修改</button></a>
                        <a href="{{route('category.destroy',['id' => $category->id ])}}"
                            onclick="javascript:return del()"><button class="btn btn-danger btn-sm">删除</button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/category.js') }}"></script>
@endsection