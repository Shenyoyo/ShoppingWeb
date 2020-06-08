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
    <h1> 嗨嗨這裡是商品區</h1>
@endsection