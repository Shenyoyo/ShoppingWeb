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
            <div class="panel-title">用戶修改</div>
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
            <form method="POST" action="{{route('adminUser.update')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="name">用戶名</label>
                        <div class="col-md-2">
                        <input id="name" name="name" type="text"  class="form-control input-md" value="{{$user->name}}" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email">信箱</label>
                        <div class="col-md-4">
                        <input id="email" name="email" type="text"  class="form-control input-md" value="{{$user->email}}" required="">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="phone">手機</label>
                        <div class="col-md-4">
                            <input id="phone" name="phone" type="text"  class="form-control input-md" value="{{$user->phone}}" oninput = "value=value.replace(/[^\d]/g,'')" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="address">通訊地址</label>
                        <div class="col-md-4">
                            <input id="address" name="address" type="text"  class="form-control input-md" value="{{$user->address}}" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="total_cost">累積消費</label>
                        <div class="col-md-2">
                            <input id="total_cost" name="total_cost" type="text"  class="form-control input-md" value="{{$user->total_cost}}" oninput = "value=value.replace(/[^\d]/g,'')" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="level">等級</label>
                        <div class="col-md-4" style="margin-top: 7px;">
                            <select name="level" id="level">
                                @foreach ($levels as $level)
                                <option {{($user->level_level == $level->level) ? 'selected' : '' }} value="{{$level->level}}">{{$level->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
           
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="active">是否停權</label>
                        <div class="col-md-4" style="margin-top: 7px;">
                            <input {{($user->active != '1') ? 'checked' : ''}} id="active" name="active" class="form-check-input" type="checkbox" value="2"  >
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
