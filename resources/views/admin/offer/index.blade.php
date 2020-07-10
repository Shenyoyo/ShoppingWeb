@extends('layouts.admin')

@section('title')
優惠管理
@endsection

@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach ($errors->all() as $errors)
            <p>{{ $errors }}</p>    
        @endforeach
    </div>
    @endif 
<h1>優惠管理</h1>
<div class="row">
    <div class="col-md-6">
        <a href="{{route('offer.new')}}""><button class=" btn btn-success">新增優惠設定</button></a>
    </div>
</div>
<div style="margin-top:10px;">
    <form action="{{route('offer.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box"
            placeholder="編號">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div style="margin-top:10px;" class="row">
    <div class="col-md-12 text-center">
        <table class="table table-striped ">
            <thead class="bg-info">
                <td>編號</td>
                <td>受惠會員</td>
                <td>是否給予打折優惠</td>
                <td>是否給予虛擬幣回饋</td>
                <td>是否給予滿額送現金</td>
                <td>操作</td>
            </thead>
            <tbody>
                @foreach ($offers as $offer)
                <tr>
                    <td>{{$offer->id}}</td>
                    <td>{{$offer->level->name}}</td>
                    <td>{{$offer->discount_yn}}</td>
                    <td>{{$offer->cashback_yn}}</td>
                    <td>{{$offer->rebate_yn}}</td>
                    <td>
                        <a href="{{route('offer.edit',['id' => $offer->id ])}}"><button
                                class="btn btn-primary btn-sm">修改</button></a>
                        {{-- VIP0優惠只能修改不能刪除 --}}
                        @if ($offer->level->name != 'VIP0')
                        <a href="{{route('offer.destroy',['id' => $offer->id ])}}"
                            onclick="javascript:return del()"><button class="btn btn-danger btn-sm">删除</button></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="text-center">
    {{ $offers->links() }}
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/offer.js') }}"></script>
@endsection