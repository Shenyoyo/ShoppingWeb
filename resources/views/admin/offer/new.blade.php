@extends('layouts.admin')

@section('title')
新增優惠設定    
@endsection

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">新增優惠設定</div>
        </div>
        <div class="panel-body" >
            <form method="POST" action="{{route('offer.add')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="level">受惠會員等級</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            <select name="level" id="level">
                                @foreach ($levels as $level)
                                <option value="{{$level->level}}">{{$level->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="discount_yn">打折優惠</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            <input id="discount_yn" name="discount_yn"" class="form-check-input" type="checkbox" value="Y" checked >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label" for="discount_above">消費滿額</label>
                        <div class="col-md-2" ">
                            <input id="discount_above" name="discount_above" type="text"  class="form-control input-md group1" required="" oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off">
                        </div>
                        <label class="col-md-1 control-label" for="discount_percent">優惠折數</label>
                        <div class="col-md-1" ">
                            <input id="discount_percent" name="discount_percent" type="text"  class="form-control input-md group1" required="" >
                        </div>
                        <div style="margin-top: 7px;">
                            折
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="cashback_yn">虛擬幣回饋</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            <input id="cashback_yn" name="cashback_yn" class="form-check-input" type="checkbox" value="Y"  checked >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label" for="cashback_above">消費滿額</label>
                        <div class="col-md-2" ">
                            <input id="cashback_above" name="cashback_above" type="text"  class="form-control input-md group2" required="" oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off">
                        </div>
                        <label class="col-md-1 control-label" for="cashback_percent">優惠回饋</label>
                        <div class="col-md-1" ">
                            <input id="cashback_percent" name="cashback_percent" type="text"  class="form-control input-md group2" required="" oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off">
                        </div>
                        <div style="margin-top: 7px;">
                            %
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="rebate_yn">滿額送現金</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            <input id="rebate_yn" name="rebate_yn" class="form-check-input" type="checkbox" value="Y"  checked >
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label" for="rebate_above">消費滿額</label>
                        <div class="col-md-2" ">
                            <input id="rebate_above" name="rebate_above" type="text"  class="form-control input-md group3" required="" oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off">
                        </div>
                        <label class="col-md-1 control-label" for="rebate_rebate">回贈金額</label>
                        <div class="col-md-1" ">
                            <input id="rebate_rebate" name="rebate_rebate" type="text"  class="form-control input-md group3" required="" oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off">
                        </div>
                        <div style="margin-top: 7px;">
                            元
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
@section('scripts')
<script  src="{{ asset('js/offernew.js') }}"></script>
@endsection