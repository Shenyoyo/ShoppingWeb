@extends('layouts.admin')

@section('title')
{{__('shop.Edit Category')}}
@endsection

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">{{__('shop.Edit Category')}}</div>
        </div>
        <div class="panel-body" >
            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-bottom: 10px">
                  <a href="{{route('category.index')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> {{__('shop.Back to list')}}</a>
                </div>
            </div>
            <form method="POST" action="{{route('category.update')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="id" value="{{$category->id}}">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name">{{__('shop.Category Name')}}</label>
                        <div class="col-md-4">
                        <input id="name" name="name" type="text" placeholder="{{__('shop.Ex.Discount Product')}}" class="form-control input-md" required="" value="{{$category->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="display">{{__('shop.Display')}}</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            @if ($category->display_yn == 'Y')
                            <input id="display_yn" name="display_yn" class="form-check-input" type="checkbox" value="Y" checked >
                            @else
                            <input id="display_yn" name="display_yn" class="form-check-input" type="checkbox" value="Y"  >    
                            @endif
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="submit"></label>
                        <div class="col-md-9">
                            <button id="submit" name="submit" class="btn btn-primary">{{__('shop.Edit')}}</button>
                        </div>
                    </div>
                </fieldset>

            </form>
        </div>
    </div>
@endsection