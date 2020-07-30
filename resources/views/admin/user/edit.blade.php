@extends('layouts.admin')

@section('title')
{{__('shop.Edit Account')}}
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
            <div class="panel-title">{{__('shop.Edit Account')}}</div>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" href="{{route('adminUser.edit',['id' => $user->id ])}}">{{__('shop.Revise personal info')}}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('adminUser.deposit',['id' => $user->id ])}}">{{__('shop.Manual deposit')}}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('adminUser.withdraw',['id' => $user->id ])}}">{{__('shop.Manual withdrawal')}}</a>
            </li>
          </ul>
        <div class="panel-body" >
            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-bottom: 10px">
                  <a href="{{route('adminUser.index')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> {{__('shop.Back to list')}}</a>
                </div>
            </div>
            <form method="POST" action="{{route('adminUser.update')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="name">{{__('shop.Account Name')}}</label>
                        <div class="col-md-2">
                        <input id="name" name="name" type="text"  class="form-control input-md" value="{{$user->name}}" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email">{{__('shop.email')}}</label>
                        <div class="col-md-4">
                        <input id="email" name="email" type="text"  class="form-control input-md" value="{{$user->email}}" required="">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="phone">{{__('shop.phone')}}</label>
                        <div class="col-md-4">
                            <input id="phone" name="phone" type="text"  class="form-control input-md" value="{{$user->phone}}" oninput = "value=value.replace(/[^\d]/g,'')" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="address">{{__('shop.address')}}</label>
                        <div class="col-md-4">
                            <input id="address" name="address" type="text"  class="form-control input-md" value="{{$user->address}}" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="total_cost">{{__('shop.totalcost')}}</label>
                        <div class="col-md-2">
                            <input id="total_cost" name="total_cost" type="text"  class="form-control input-md" value="{{$user->total_cost}}" oninput = "value=value.replace(/[^\d]/g,'')" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="level">{{__('shop.level')}}</label>
                        <div class="col-md-4" style="margin-top: 7px;">
                            <select name="level" id="level">
                                @foreach ($levels as $level)
                                <option {{($user->level_level == $level->level) ? 'selected' : '' }} value="{{$level->level}}">{{$level->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
           
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="active">{{__('shop.Suspension')}}</label>
                        <div class="col-md-4" style="margin-top: 7px;">
                            <input {{($user->active != '1') ? 'checked' : ''}} id="active" name="active" class="form-check-input" type="checkbox" value="2"  >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="submit"></label>
                        <div class="col-md-4">
                            <button id="submit" name="submit" class="btn btn-primary">{{__('shop.submit')}}</button>
                        </div>
                    </div>

                </fieldset>

            </form>
        </div>
    </div>
@endsection
