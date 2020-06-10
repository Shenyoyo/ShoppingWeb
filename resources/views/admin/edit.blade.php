@extends('layouts.admin')

@section('title')
    
@endsection

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">修改商品</div>
        </div>
        <div class="panel-body" >
            <form method="POST" action="{{route('admin.update')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="id" value="{{$product->id}}">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name">名稱</label>
                        <div class="col-md-9">
                        <input id="name" name="name" type="text" placeholder="商品名稱" class="form-control input-md" value="{{$product->name}}" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="textarea">描述</label>
                        <div class="col-md-9">
                            <textarea class="form-control" id="textarea" name="description" >{{$product->description}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="price">價格</label>
                        <div class="col-md-9">
                            <input id="price" name="price" type="text" placeholder="商品價格" class="form-control input-md" value="{{$product->price}}" required="">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="image">圖片URL</label>
                        <div class="col-md-9">
                            <input id="image" name="image" type="text" placeholder="商品圖片URL" class="form-control input-md" value="{{$product->image}}">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="file">文件</label>
                        <div class="col-md-9">
                            <input id="file" name="file" class="input-file" type="file" value="{{$product->file->original_filename}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="submit"></label>
                        <div class="col-md-9">
                            <button id="submit" name="submit" class="btn btn-primary">修改</button>
                        </div>
                    </div>

                </fieldset>

            </form>
        </div>
    </div>
@endsection