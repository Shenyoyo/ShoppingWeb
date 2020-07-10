@extends('layouts.master')
@section('title')
會員資料
@endsection
@section('styles')
<link rel="stylesheet" href="/css/profile.css">
@endsection
@section('content')
@if (count($errors) > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $errors)
        <p>{{ $errors }}</p>    
    @endforeach
</div>
@endif 
@if (session()->has('success_message'))
    <div class="alert alert-success">
        {{ session()->get('success_message') }}
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{__('shop.myprodile')}}
                    <div class="btn-group pull-right">
                        <a href="{{route('user.profileEdit')}}" class="btn btn-sm btn-default">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>{{__('shop.edit')}}</a>
                    </div>
                </h4>
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
                            <h4 style="color:#00b1b1;">{{__('shop.upgraderule')}}: </h4>
                            <h5 style="color:#b15000;">
                                @if (!empty($nextLevel->upgrade))
                                @if ($user->total_cost < $nextLevel->upgrade)
                                    在消費{{$nextLevel->upgrade - $user->total_cost}}元以上就可晉升{{$nextLevel->name}}
                                    @else
                                    {{__('shop.aboveconditions')}}{{$nextLevel->name}} 。
                                    @endif
                                    @else
                                    {{__('shop.bestlevel')}}
                                    @endif
                            </h5>
                            <br>
                            <span>
                                <h4>{{$user->level->name}}{{__('shop.dicount')}}：</h4>

                                @if (($user->level->offer->discount_yn ?? '') == 'Y')
                                <p>單筆消費滿{{$user->level->offer->discount->above}}元以上，
                                    可獲得{{showDiscount($user->level->offer->discount->percent*100)}}折的優惠。</p>
                                @endif
                                @if (($user->level->offer->cashback_yn ?? '') == 'Y')
                                <p>單筆消費滿{{$user->level->offer->cashback->above}}元以上，
                                    可獲得{{$user->level->offer->cashback->percent*100}}%的虛擬幣回饋。</p>
                                @endif
                                @if (($user->level->offer->rebate_yn ?? '') == 'Y')
                                <p>單筆消費滿{{$user->level->offer->rebate->above}}元以上，
                                    可獲得{{$user->level->offer->rebate->rebate}}元的虛擬幣回饋。</p>
                                @endif
                            </span>
                        </div>
                        <div class="clearfix"></div>
                        <hr style="margin:5px 0 5px 0;">
                        <div class="text-center">
                            <div class="col-sm-5 col-xs-6 tital ">{{__('shop.name')}}:</div>
                            <div class="col-sm-7 col-xs-6 ">{{$user->name}}</div>
                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">{{__('shop.email')}}:</div>
                            <div class="col-sm-7"> {{$user->email}}</div>
                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">{{__('shop.level')}}:</div>
                            <div class="col-sm-7"> {{$user->level->name}}</div>
                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">{{__('shop.phone')}}:</div>
                            <div class="col-sm-7">{{$user->phone}}</div>

                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">{{__('shop.address')}}:</div>
                            <div class="col-sm-7">{{$user->address}}</div>

                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">{{__('shop.totalcost')}}:</div>
                            <div class="col-sm-7">{{presentPrice($user->total_cost)}}</div>

                            <!-- /.box-body -->
                        </div>
                        <!-- /text-center -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    {{__('shop.editpassword')}}
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
                <form method="POST" action="{{route('user.updatePassword')}}" class="form-horizontal" >
                    {!! csrf_field() !!}
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="password"">{{__('shop.newpassowrd')}}</label>
                            <div class="col-md-4">
                                <input class="password" id="password" name="password" type="password"  class="form-control input-md"  required="" > <i class="show_pass glyphicon glyphicon-eye-open"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-5 control-label" for="password-confirm"">{{__('shop.confirmnewpassword')}}</label>
                            <div class="col-md-4">
                                <input class="password-confirm" id="password" name="password_confirmation" type="password"  class="form-control input-md"  required="" > <i class="show_pass glyphicon glyphicon-eye-open"></i>
                            </div>
                        </div>
    
                        <div class="form-group">
                            <label class="col-md-5 control-label" for="submit"></label>
                            <div class="col-md-4">
                                <button id="submit" name="submit" class="btn btn-primary">{{__('shop.confirm')}}</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script  src="{{ asset('js/resetPassword.js') }}"></script>
@endsection
