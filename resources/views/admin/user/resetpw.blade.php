@extends('layouts.admin')

@section('title')
用戶修改
@endsection

@section('content')
@if (count($errors) > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $errors)
        <p>{{ $errors }}</p>    
    @endforeach
</div>
@endif 
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">重設密碼</div>
        </div>
        <div class="panel-body" >
            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-bottom: 10px">
                  <a href="{{route('adminUser.index')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 返回列表</a>
                </div>
            </div>
            <form method="POST" action="{{route('adminUser.updatePassword')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="name">用戶名</label>
                        <div class="col-md-2">
                        <input id="name" name="name" type="text"  class="form-control input-md" value="{{$user->name}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email">信箱</label>
                        <div class="col-md-4">
                        <input id="email" name="email" type="text"  class="form-control input-md" value="{{$user->email}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="password"">新密碼</label>
                        <div class="col-md-4">
                            
                            <input class="password" id="password" name="password" type="password"  class="form-control input-md"  required="" > <i class="show_pass glyphicon glyphicon-eye-open"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="submit"></label>
                        <div class="col-md-4">
                            <button id="submit" name="submit" class="btn btn-primary">送出</button>
                        </div>
                    </div>

                </fieldset>

            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script  src="{{ asset('js/resetPassword.js') }}"></script>
@endsection