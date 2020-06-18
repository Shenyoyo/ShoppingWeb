@extends('layouts.admin')

@section('title')
    優惠管理
@endsection

@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
<h1>優惠管理</h1>
<div class="row">
    <div class="col-md-6">
        <a href="{{route('offer.new')}}""><button class="btn btn-success">新增優惠設定</button></a>
    </div>
</div>
<div style="margin-top:20px;">
    <form action="#" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box" placeholder="Search for product">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div class="row">
    <div class="col-md-12 text-center" >
           <table class="table table-striped ">
           <thead class="bg-info">
           <td>編號</td>
           <td>受惠會員</td>
           <td>是否給予打折優惠</td>
           <td>是否給予虛擬幣回饋</td>
           <td>操作</td>
           </thead>
           <tbody>
    {{--            @foreach ($products as $product) --}}
                   <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>           
                       <td>
                       <a href="#"><button class="btn btn-primary">修改</button></a> 
                       <a href="#" onclick="javascript:return del()"><button class="btn btn-danger">删除</button></a>
                       </td>
                   </tr>
    {{--            @endforeach --}}
           </tbody>
           </table>
    </div>
</div>
@endsection

@section('scripts')
<script  src="{{ asset('js/offer.js') }}"></script>
@endsection