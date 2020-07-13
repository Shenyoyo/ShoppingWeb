@extends('layouts.master')

@section('title')
登入    
@endsection
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
    <h1>{{__('shop.signin') }}</h1>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach ($errors->all() as $errors)
            <p>{{ $errors }}</p>    
        @endforeach
    </div>
    @endif 
    <form action="{{ route('user.signin')}}" method="post">
        <div class="form-group">
            <label for="email">{{__('shop.email') }}</label>
            <input type="text" id="email" name="email" class="form-control" value="{{old('email')}}">
        </div>
        <div class="form-group">
            <label for="password">{{__('shop.password') }}</label>
            <input type="password" id="password" name="password" class="form-control" required value="{{old('password')}}">
        </div>
        <div class="form-group ">
            <label for="captcha">{{__('shop.captcha') }}</label>
            <input type="text" id="captcha" name="captcha" class="form-control">
            <img style="margin: 12px 0 0;” class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="點選圖片重新獲取驗證碼">
        </div>
        <button type="submit" class="btn btn-primary">{{__('shop.signin') }}</button>

        <a class="btn btn-link pull-right" href="{{ route('password.request') }}">
            {{__('shop.forgot') }}
        </a>
        {{csrf_field()}}
    </form>
    </div>
</div>
@endsection