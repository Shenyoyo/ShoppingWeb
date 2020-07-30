@extends('layouts.admin')

@section('title')
{{__('shop.Category Management')}}
@endsection

@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
<h1>{{__('shop.Category Management')}}</h1>
<div class="row">
    <div class="col-md-6">
        <a href="{{route('category.new')}}"><button class="btn btn-success">{{__('shop.Add Category')}}</button></a>
    </div>
</div>
<div style="margin-top:10px;">
    <form action="{{route('category.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box"
            placeholder="{{__('shop.Category Name')}}"">
        <button type=" submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div class="row" style="margin-top:10px;">
    <div class="col-md-7 text-center">
        <table class="table table-striped ">
            <thead class="bg-info">
                <td>{{__('shop.ID')}}</td>
                <td>{{__('shop.Category Name')}}</td>
                <td>{{__('shop.Display')}}</td>
                <td>{{__('shop.operate')}}</td>
            </thead>
            <tbody>
                @foreach ($categories as $category )
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->display_yn}}</td>
                    <td>
                        <a href="{{route('category.edit',['id' => $category->id ])}}"><button
                                class="btn btn-primary btn-sm">{{__('shop.Edit')}}</button></a>
                        <a href="{{route('category.destroy',['id' => $category->id ])}}"
                            onclick="javascript:return del()"><button class="btn btn-danger btn-sm">{{__('shop.Delete')}}</button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="text-center">
    {{ $categories->links() }}
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/category.js') }}"></script>
@endsection