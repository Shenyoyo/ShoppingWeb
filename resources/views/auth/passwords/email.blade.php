@extends('layouts.master')

@section('content')
<div class="container">
    <div class="col-md-4 col-md-offset-4">
    <h1>{{__('shop.ResetPassword') }}</h1>
    
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email" >{{__('shop.E-MailAddress') }}</label>
                    <input id="email" type="email" placeholder="xxxx@mail.com" class="form-control  {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{__('shop.SendPasswordResetLink') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
