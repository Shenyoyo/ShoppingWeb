@extends('layouts.master')

@section('content')
<div class="container">
    <div class="col-md-4 col-md-offset-4">
    <h1>重設密碼</h1>
    
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email" >請輸入信箱</label>
                    <input id="email" type="email" placeholder="xxxx@mail.com" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">取得信件</button>
            </div>
        </form>
    </div>
</div>
@endsection
