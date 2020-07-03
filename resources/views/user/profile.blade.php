@extends('layouts.master')
@section('title')
會員資料
@endsection
@section('styles')
<link rel="stylesheet" href="/css/profile.css">
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>會員資料</h4>
            </div>
            <div class="panel-body">

                <div class="box box-info">
                    <div class="box-body">
                        <div class="col-sm-6">
                            <div align="center"> <img alt="User Pic"
                                    src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg"
                                    id="profile-image1" class="img-circle img-responsive">
                                <input id="profile-image-upload" class="hidden" type="file">
                                <div style="color:#999;">click here to change profile image</div>
                                <!--Upload Image Js And Css-->
                            </div>
                            <br>
                            <!-- /input-group -->
                        </div>
                        <div class="col-sm-6">
                            <h4 style="color:#00b1b1;">晉 級 條 件 :  </h4>
                            <h5 style="color:#b15000;">
                                @if (!empty($nextLevel->upgrade))
                                    @if ($user->total_cost < $nextLevel->upgrade)
                                    在消費{{$nextLevel->upgrade - $user->total_cost}}元以上就可晉升{{$nextLevel->name}}
                                    @else
                                    已達晉級條件再消費一次不限金額，晉級{{$nextLevel->name}} 。  
                                    @endif
                                @else
                                    現在已經是最高等級了。
                                @endif
                                 
                            </h5>
                            <br>
                            
                            <span>
                                <h4>{{$user->level->name}}可享優惠：</h4>
                                
                                @if ($user->level->offer->discount_yn ?? ''  == 'Y')
                                <p>單筆消費滿{{$user->level->offer->discount->above}}元以上，
                                    可獲得{{showDiscount($user->level->offer->discount->percent*100)}}折的優惠。</p>
                                @endif
                                @if ($user->level->offer->cashback_yn ?? '' == 'Y')
                                <p>單筆消費滿{{$user->level->offer->cashback->above}}元以上，
                                   可獲得{{$user->level->offer->cashback->percent*100}}%的虛擬幣回饋。</p>
                                @endif
                                @if ($user->level->offer->rebate_yn ?? '' == 'Y')
                                <p>單筆消費滿{{$user->level->offer->rebate->above}}元以上，
                                   可獲得{{$user->level->offer->rebate->rebate}}元的虛擬幣回饋。</p>
                                @endif
                            </span>
                        </div>
                        <div class="clearfix"></div>
                        <hr style="margin:5px 0 5px 0;">
                        <div class="text-center">
                            <div class="col-sm-5 col-xs-6 tital ">用戶名稱:</div>
                            <div class="col-sm-7 col-xs-6 ">{{$user->name}}</div>
                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">信箱:</div>
                            <div class="col-sm-7"> {{$user->email}}</div>
                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">等級:</div>
                            <div class="col-sm-7"> {{$user->level->name}}</div>
                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">手機:</div>
                            <div class="col-sm-7">{{$user->phone}}</div>

                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">通訊地址:</div>
                            <div class="col-sm-7">{{$user->address}}</div>

                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">累積消費:</div>
                            <div class="col-sm-7">{{presentPrice($user->total_cost)}}</div>
                          
                            <!-- /.box-body -->
                        </div>
                        <!-- /text-center -->
                    </div>
                    <!-- /.box -->

                </div>


            </div>
        </div>
        @endsection