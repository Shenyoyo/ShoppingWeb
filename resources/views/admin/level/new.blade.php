@extends('layouts.admin')

@section('title')
     新增等級
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
            <div class="panel-title">新增等級</div>
        </div>
        <div class="panel-body" >
            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-bottom: 10px">
                  <a href="{{route('level.index')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 返回列表</a>
                </div>
            </div>
            <form method="POST" action="{{route('level.add')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="level" value="{{$level->level + 1}}">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name">等級名稱</label>
                        <div class="col-md-1">
                            <input id="name" name="name" type="text"  class="form-control input-md" required="" value="VIP{{$level->level + 1}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="description">等級描述</label>
                        <div class="col-md-3">
                            <input id="description" name="description" type="text"  class="form-control input-md" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="upgrade">晉級條件</label>
                        <label class="col-md-1 control-label" for="upgrade">累積消費</label>
                        <div class="col-md-2">
                            <input id="upgrade" name="upgrade" type="text"  class="form-control input-md" required="" oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="submit"></label>
                        <div class="col-md-9">
                            <button id="submit" name="submit" class="btn btn-primary">提交</button>
                        </div>
                    </div>
                </fieldset>

            </form>
        </div>
    </div>
@endsection