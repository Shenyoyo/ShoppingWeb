@extends('layouts.admin')

@section('title')
{{__('shop.Edit Level')}}
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
            <div class="panel-title">{{__('shop.Edit Level')}}</div>
        </div>
        <div class="panel-body" >
            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-bottom: 10px">
                  <a href="{{route('level.index')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> {{__('shop.Back to list')}}</a>
                </div>
            </div>
            <form method="POST" action="{{route('level.update')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="id" value="{{$level->level}}">
                    <input type="hidden" name="level" value="{{$level->level}}">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name">{{__('shop.Level Name')}}</label>
                        <div class="col-md-1">
                            <input id="name" name="name" type="text"  class="form-control input-md" required="" value="VIP{{$level->level}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="description">{{__('shop.Level Description')}}</label>
                        <div class="col-md-3">
                            <input id="description" name="description" type="text"  class="form-control input-md" required="" value="{{$level->description}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="upgrade">{{__('shop.Upgrate Condition')}}</label>
                        @if (Session::has('locale') && in_array(Session::get('locale'), ['en']))
                        <label class="col-md-2 control-label" for="upgrade">{{__('shop.totalcost')}}</label>
                        @else
                        <label class="col-md-1 control-label" for="upgrade">{{__('shop.totalcost')}}</label>
                        @endif
                        
                        <div class="col-md-2">
                            <input id="upgrade" name="upgrade" type="text"  class="form-control input-md" 
                            required="" oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off" value="{{$level->upgrade}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="submit"></label>
                        <div class="col-md-9">
                            <button id="submit" name="submit" class="btn btn-primary">{{__('shop.submit')}}</button>
                        </div>
                    </div>
                </fieldset>

            </form>
        </div>
    </div>
@endsection