@extends('layouts.admin')

@section('title')
{{__('shop.Edit Offer')}}   
@endsection

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">{{__('shop.Edit Offer')}}</div>
        </div>
        <div class="panel-body" >
            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-bottom: 10px">
                  <a href="{{route('offer.index')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> {{__('shop.Back to list')}}</a>
                </div>
            </div>
            <form method="POST" action="{{route('offer.update')}}" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <input type="hidden" name="id" value="{{$offer->id}}">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="level">{{__('shop.Beneficiary Member')}}</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            {{$offer->level->name}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="optimun_yn">{{__('shop.Optimun')}}</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            @if ($offer->optimun_yn == 'Y')
                            <input id="optimun_yn" name="optimun_yn"" class="form-check-input" type="checkbox" value="Y" checked >
                            @else
                            <input id="optimun_yn" name="optimun_yn"" class="form-check-input" type="checkbox" value="Y" >
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="discount_yn">{{__('shop.Discount')}}</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            @if ($offer->discount_yn == 'Y')
                            <input id="discount_yn" name="discount_yn"" class="form-check-input" type="checkbox" value="Y" checked >
                            @else
                            <input id="discount_yn" name="discount_yn"" class="form-check-input" type="checkbox" value="Y" >
                            @endif
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label" for="discount_above">{{__('shop.Above')}}</label>
                        <div class="col-md-2" ">
                            <input id="discount_above" name="discount_above" type="text"  class="form-control input-md group1" required=""
                             oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off" value="{{$offer->discount->above}}">
                        </div>
                        <label class="col-md-1 control-label" for="discount_percent">{{__('shop.Discount Percnet')}}</label>
                        <div class="col-md-1" ">
                            <input id="discount_percent" name="discount_percent" type="text"  class="form-control input-md group1" required=""
                            value="{{showDiscount($offer->discount->percent*100)}}" >
                        </div>
                        <div style="margin-top: 7px;">
                            折
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="cashback_yn">{{__('shop.Cashback')}}</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            @if ($offer->cashback_yn == 'Y')
                            <input id="cashback_yn" name="cashback_yn" class="form-check-input" type="checkbox" value="Y"  checked >
                            @else
                            <input id="cashback_yn" name="cashback_yn" class="form-check-input" type="checkbox" value="Y"   >
                            @endif
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-3 control-label" for="cashback_above">{{__('shop.Above')}}</label>
                        <div class="col-md-2" ">
                            <input id="cashback_above" name="cashback_above" type="text"  class="form-control input-md group2" required="" 
                            oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off" value="{{$offer->cashback->above}}">
                        </div>
                        <label class="col-md-1 control-label" for="cashback_percent">{{__('shop.Cachback Percnet')}}</label>
                        <div class="col-md-1" ">
                            <input id="cashback_percent" name="cashback_percent" type="text"  class="form-control input-md group2" required=""
                             oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off" value="{{$offer->cashback->percent*100}}">
                        </div>
                        <div style="margin-top: 7px;">
                            %
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="rebate_yn">{{__('shop.Rebated')}}</label>
                        <div class="col-md-9" style="margin-top: 7px;">
                            @if ($offer->rebate_yn == 'Y')
                            <input id="rebate_yn" name="rebate_yn" class="form-check-input" type="checkbox" value="Y"  checked >
                            @else
                            <input id="rebate_yn" name="rebate_yn" class="form-check-input" type="checkbox" value="Y"   >
                            @endif
                        </div>
                    </div>

                    <div class="form-group ">
                        <label class="col-md-3 control-label" for="rebate_above">{{__('shop.Above')}}</label>
                        <div class="col-md-2" ">
                            <input id="rebate_above" name="rebate_above" type="text"  class="form-control input-md group3" required="" 
                            oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off" value="{{$offer->rebate->above}}">
                        </div>
                        <label class="col-md-1 control-label" for="rebate_rebate">{{__('shop.Rebate Dollor')}}</label>
                        <div class="col-md-1" ">
                            <input id="rebate_rebate" name="rebate_rebate" type="text"  class="form-control input-md group3" required=""
                             oninput = "value=value.replace(/[^\d]/g,'')"  autocomplete="off" value="{{$offer->rebate->rebate}}">
                        </div>
                        <div style="margin-top: 7px;">
                            元
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
@section('scripts')
<script  src="{{ asset('js/offernew.js') }}"></script>
@endsection