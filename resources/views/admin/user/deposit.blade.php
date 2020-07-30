@extends('layouts.admin')

@section('title')
{{__('shop.Manual deposit')}}
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
            <div class="panel-title">{{__('shop.Manual deposit')}}</div>
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
            <form method="POST" action="{{route('adminUser.postDeposit')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="name">{{__('shop.Account Name')}}</label>
                        <div class="col-md-2" style="margin-top: 7px;">
                            {{$user->name}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="dollor">{{__('shop.VirtualDollor')}}</label>
                        <div class="col-md-2" style="margin-top: 7px;">
                            {{presentPrice($user->dollor->dollor)}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="deposit">{{__('shop.deposit')}}</label>
                        <div class="col-md-2">
                        <input id="deposit"" name="deposit" type="text"  class="form-control input-md"  required="" oninput = "value=value.replace(/[^\d]/g,'')" autofocus="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="memo">{{__('shop.memo')}}</label>
                        <div class="col-md-4">
                            <textarea class="form-control" id="memo" name="memo" value="{{old('memo')}}"></textarea>
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
