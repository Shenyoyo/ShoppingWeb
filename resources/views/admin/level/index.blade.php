@extends('layouts.admin')

@section('title')
    會員等級管理
@endsection

@section('styles')
<link rel="stylesheet" href="/css/level.css">
@endsection
@section('content')
<h1>會員等級管理</h1>
<div class="row">
    <div class="col-md-6">
        <a href="{{route('level.new')}}"><button class="btn btn-success">新增等級</button></a>
    </div>
</div>
<div style="margin-top:20px;">
    <form action="{{route('category.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box" placeholder="Search for product">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div class="row">
    <div class="col-md-12 text-center" >
        <table class="table table-striped ">
            <thead class="bg-info " >
            <tr class="">
            <th colspan="1" rowspan="2"><div class="text-center cell">編號<div></th>
            <th colspan="1" rowspan="2"><div class="text-center cell">等級名稱<div></th>
            <th colspan="1" rowspan="2"><div class="text-center cell">等級描述<div></th>
            <th colspan="1" rowspan="1" style="border-bottom-width: 0px;"><div class="text-center ">晉 級 條 件<div></th>
            <th colspan="1" rowspan="2"><div class="text-center cell">操作<div></th>
            </tr>
            <th colspan="1" rowspan="1" style="border-top-width: 0px;"><div class="text-center ">累計消費<div></th>
            <tr>
            </tr>
            </thead>
            <tbody>
                @foreach ($levels as $level )
                <tr>
                    <td>{{$level->id}}</td>
                    <td>{{$level->name}}</td>
                    <td>{{$level->description}}</td>
                    <td>{{$level->upgrade}}</td>
                    <td>
                    <a href="＃"><button class="btn btn-primary">修改</button></a> 
                    <a href="＃" onclick="javascript:return del()"><button class="btn btn-danger">删除</button></a>
                    </td>
                </tr>
                @endforeach
           </tbody>
           </table>
    </div>
</div>
@endsection
@section('scripts')
<script  src="{{ asset('js/level.js') }}"></script>
@endsection