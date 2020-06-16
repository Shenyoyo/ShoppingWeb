@extends('layouts.admin')

@section('title')
    
@endsection

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">新增商品</div>
        </div>
        <div class="panel-body" >
            <form method="POST" action="{{route('admin.add')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name">名稱</label>
                        <div class="col-md-9">
                            <input id="name" name="name" type="text" placeholder="商品名稱" class="form-control input-md" required="">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="textarea">描述</label>
                        <div class="col-md-9">
                            <textarea class="form-control" id="textarea" name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="price">價格</label>
                        <div class="col-md-9">
                            <input id="price" name="price" type="text" placeholder="商品價格" class="form-control input-md" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="imageurl">圖片URL</label>
                        <div class="col-md-9">
                            <input id="imageurl" name="imageurl" type="text" placeholder="商品圖片URL" class="form-control input-md" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="amount">庫存數量</label>
                        <div class="col-md-9">
                            <input id="amount" name="amount" type="number" class="form-control input-md" value="1" min="1">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label" for="category">分類</label>
                        <div class="col-md-9" ">
                        @foreach($categories as $category)
                        <label class="checkbox-inline">
                            <input type="checkbox" name="{{$category->name}}" id="inlineCheckbox{{$category->id}}" value="{{$category->id}}">{{$category->name}}
                        </label>
                        @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="display" >商品上架到首頁</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            <input id="display_yn" name="display_yn" class="form-check-input" type="checkbox" value="Y" checked >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="buy_yn">商品用戶可購買</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            <input id="buy_yn" name="buy_yn" class="form-check-input" type="checkbox" value="Y"  checked >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="file">上傳圖片</label>
                        <div class="col-md-9">
                            <input id="file" name="file" class="input-file" type="file">
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