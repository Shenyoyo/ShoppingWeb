@extends('layouts.admin')

@section('title')
新增商品    
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
            <div class="panel-title">{{__('shop.Add Product')}}</div>
        </div>
        <div class="panel-body" >
            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-bottom: 10px">
                  <a href="{{route('admin.products')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> {{__('shop.Back to list')}}</a>
                </div>
            </div>
            <form method="POST" action="{{route('admin.add')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name">{{__('shop.Product Name')}}</label>
                        <div class="col-md-7">
                            <input id="name" name="name" type="text" placeholder="{{__('shop.Product Name')}}" class="form-control input-md" required="" value="{{old('name')}}">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="textarea">{{__('shop.Description')}}</label>
                        <div class="col-md-7">
                            <textarea class="form-control" id="textarea" name="description" required="" >{{old('description')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="price">{{__('shop.price')}}</label>
                        <div class="col-md-7">
                            <input id="price" name="price" type="text" placeholder="{{__('shop.price')}}" class="form-control input-md" oninput = "value=value.replace(/[^\d]/g,'')" required="" maxlength=“12” value="{{old('price')}}">
                        </div>
                    </div>
                 
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="amount">{{__('shop.Stock Quantity')}}</label>
                        <div class="col-md-7">
                            <input id="amount" name="amount" type="number" class="form-control input-md" value="1" min="1" >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label" for="category">{{__('shop.Category')}}</label>
                        <div class="col-md-7" ">
                        @foreach($categories as $category)
                        <label class="checkbox-inline">
                            <input type="checkbox" name="{{$category->id}}" id="inlineCheckbox{{$category->id}}" value="{{$category->id}}">{{$category->name}}
                        </label>
                        @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="display" >{{__('shop.Product Dispaly')}}</label>
                        <div class="col-md-7" style="margin-top: 7px;">
                            <input id="display_yn" name="display_yn" class="form-check-input" type="checkbox" value="Y" checked >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="buy_yn">{{__('shop.Product Buy')}}</label>
                        <div class="col-md-7" style="margin-top: 7px;">
                            <input id="buy_yn" name="buy_yn" class="form-check-input" type="checkbox" value="Y"  checked >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="file">{{__('shop.Upload Image')}}</label>
                        <div class="col-md-7">
                            <input id="file" name="file" class="input-file" type="file">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="submit"></label>
                        <div class="col-md-7">
                            <button id="submit" name="submit" class="btn btn-primary">{{__('shop.submit')}}</button>
                        </div>
                    </div>

                </fieldset>

            </form>
        </div>
    </div>
@endsection