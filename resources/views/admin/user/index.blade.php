@extends('layouts.admin')

@section('title')
    帳號管理
@endsection

@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
@if (session()->has('success_message'))
  <div class="alert alert-success">
      {{ session()->get('success_message') }}
  </div>
@endif
<h1>帳號管理</h1>
<div style="margin-top:10px;">
    <form action="{{route('adminUser.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box"
            placeholder="用戶名">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div class="row"">
    <div class="col-md-12 text-center" >
        <table class="table table-striped ">
            <thead class="bg-info">
                <td>ID</td>
                <td>用戶名</td>
                <td>信箱</td>
                <td>手機</td>
                <td>通訊地址</td>
                <td>累積消費</td>
                <td>等級</td>
                <td>停權</td>
                <td>操作</td>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>           
                    <td>{{$user->address}}</td>           
                    <td>{{presentPrice($user->total_cost)}}</td>           
                    <td>{{$user->level->name}}</td> 
                    <td>{{userActive($user->active)}}</td>           
                    <td>
                       <a href="{{route('adminUser.edit',['id' => $user->id ])}}"><button class="btn btn-primary btn-sm">修改</button></a>
                       <a href="{{route('adminUser.resetPassword',['id' => $user->id ])}}"><button class="btn btn-success btn-sm">重設密碼</button></a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
<div class="text-center">
    {{ $users->links() }}
</div>

@endsection