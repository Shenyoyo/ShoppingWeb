@extends('layouts.admin')

@section('title')
    
@endsection

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">修改分類</div>
        </div>
        <div class="panel-body" >
            <form method="POST" action="{{route('category.update')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="id" value="{{$category->id}}">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name">分類名稱</label>
                        <div class="col-md-9">
                        <input id="name" name="name" type="text" placeholder="例：優惠商品類" class="form-control input-md" required="" value="{{$category->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="display">是否顯示</label>
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
                            <button id="submit" name="submit" class="btn btn-primary">提交</button>
                        </div>
                    </div>
                </fieldset>

            </form>
        </div>
    </div>
@endsection