@extends('layouts.admin')

@section('title')
人工提取
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
            <div class="panel-title">人工提取</div>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" href="{{route('adminUser.edit',['id' => $user->id ])}}">基本資料修改</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('adminUser.deposit',['id' => $user->id ])}}">人工存入</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('adminUser.withdraw',['id' => $user->id ])}}">人工提取</a>
            </li>
          </ul>
        <div class="panel-body" >
            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-bottom: 10px">
                  <a href="{{route('adminUser.index')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 返回列表</a>
                </div>
            </div>
            <form method="POST" action="{{route('adminUser.postWithdraw')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="deposit">用戶名</label>
                        <div class="col-md-2" style="margin-top: 7px;">
                            {{$user->name}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="deposit">虛擬幣</label>
                        <div class="col-md-2" style="margin-top: 7px;">
                            {{presentPrice($user->dollor->dollor)}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="deposit">提取金額</label>
                        <div class="col-md-2">
                        <input id="deposit"" name="deposit" type="text"  class="form-control input-md"  required="" oninput = "value=value.replace(/[^\d]/g,'')" autofocus="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="memo">註解</label>
                        <div class="col-md-4">
                            <textarea class="form-control" id="memo" name="memo" value="{{old('memo')}}"></textarea>
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
