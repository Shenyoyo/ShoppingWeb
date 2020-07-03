<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>購物網後台</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
    <link rel="stylesheet" href="/css/login.css">
    {{-- <script src="{{ asset('js/login.js') }}"></script> --}}
    
</head>
<body>
    <div class="container">
        <h1 class="text-center">購物網後台</h1>
        @if (count($errors) > 0)
        <div class="alert alert-dange text-center">
        @foreach ($errors->all() as $errors)
            <p>{{ $errors }}</p>    
        @endforeach
        </div>
        @endif 
        <div class="login-container">
                <div id="output"></div>
                <div class="avatar"><img class="square" src="{{asset('img/admin.jpg')}}" alt=""> </div>
                <div class="form-box">
                    <form action="{{route('admin.login')}}" method="post">
                        <input id="name" name="name"     type="text" placeholder="管理者">
                        <input id="password" name="password" type="password" placeholder="密碼">
                        <button class="btn btn-info btn-block login" type="submit">登入</button>
                        {{csrf_field()}}
                    </form>
                </div>
            </div>
    </div>
</body>
</html>

