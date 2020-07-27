@extends('layouts.admin')

@section('title')
    
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
            <div class="panel-title">修改商品</div>
        </div>
        <div class="panel-body" >
            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-bottom: 10px">
                  <a href="{{route('admin.products')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 返回列表</a>
                </div>
            </div>
            <form method="POST" action="{{route('admin.update')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="id" value="{{$product->id}}">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name">名稱</label>
                        <div class="col-md-7">
                        <input id="name" name="name" type="text" placeholder="商品名稱" class="form-control input-md" value="{{$product->name}}" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="textarea">描述</label>
                        <div class="col-md-7">
                            <textarea class="form-control" id="textarea" name="description" >{{$product->description}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="price">價格</label>
                        <div class="col-md-7">
                            <input id="price" name="price" type="text" placeholder="商品價格" class="form-control input-md" value="{{$product->price}}" oninput = "value=value.replace(/[^\d]/g,'')" required="">
                        </div>
                    </div>
        
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="amount">庫存數量</label>
                        <div class="col-md-7">
                            <input id="amount" name="amount" type="number" class="form-control input-md" value="{{$product->amount}}" min="1">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label" for="category">分類</label>
                        <div class="col-md-7" ">
                            @foreach($categories as $category)
                                @if (in_array($category->id,$category_id))
                                <label class="checkbox-inline">
                                    <input checked type="checkbox" name="{{$category->id}}" id="inlineCheckbox{{$category->id}}" value="{{$category->id}}">{{$category->name}}
                                </label> 
                                @else
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="{{$category->id}}" id="inlineCheckbox{{$category->id}}" value="{{$category->id}}">{{$category->name}}
                                </label> 
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="display" >商品上架到首頁</label>
                        <div class="col-md-7" style="margin-top: 7px;">
                            @if ($product->display_yn == 'Y')
                            <input id="display_yn" name="display_yn" class="form-check-input" type="checkbox" value="Y"  checked >
                            @else
                            <input id="display_yn" name="display_yn" class="form-check-input" type="checkbox" value="Y">    
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="buy_yn">商品用戶可購買</label>
                        <div class="col-md-7" style="margin-top: 7px;">
                            @if ($product->buy_yn == 'Y')
                            <input id="buy_yn" name="buy_yn" class="form-check-input" type="checkbox" value="Y"  checked >
                            @else
                            <input id="buy_yn" name="buy_yn" class="form-check-input" type="checkbox" value="Y" >
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="file">上傳圖片</label>
                        <div class="col-md-7">
                            <input id="file" name="file" class="input-file" type="file">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="submit"></label>
                        <div class="col-md-7">
                            <button id="submit" name="submit" class="btn btn-primary">修改</button>
                        </div>
                    </div>

                </fieldset>

            </form>
        </div>
    </div>
@endsection