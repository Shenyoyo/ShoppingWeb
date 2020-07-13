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
        <form action="{{route('user.updateProfile')}}" method="post">
        {!! csrf_field() !!}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{__('shop.myprodile')}}
                    <div class="btn-group pull-right">
                    <button id="submit" name="submit" class="btn btn-sm btn-default">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>{{__('shop.saveedit')}}
                    </button>
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
                            <h4 style="color:#00b1b1;">{{__('shop.upgraderule')}} :  </h4>
                            <h5 style="color:#b15000;">
                                @if (!empty($nextLevel->upgrade))
                                    @if ($user->total_cost < $nextLevel->upgrade)
                                    {{__('shop.upgradelevel',[
                                        'above'=>$nextLevel->upgrade - $user->total_cost ,
                                        'nextlevel'=>$nextLevel->name
                                        ])
                                    }}
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
                                <p>
                                   
                                    @if (Session::has('locale') && in_array(Session::get('locale'), ['en']))
                                    {{__('shop.discount',[
                                        'above'=>$user->level->offer->discount->above ,
                                        'percent'=>(100- ($user->level->offer->discount->percent*100))
                                        ])
                                    }}
                                    @else
                                    {{__('shop.discount',[
                                        'above'=>$user->level->offer->discount->above ,
                                        'percent'=>showDiscount($user->level->offer->discount->percent*100)
                                        ])
                                    }}    
                                    @endif
                                </p>
                                @endif
                                @if (($user->level->offer->cashback_yn ?? '') == 'Y')
                                <p>
                                    {{__('shop.cashback',[
                                        'above'=>$user->level->offer->cashback->above ,
                                        'percent'=>showDiscount($user->level->offer->cashback->percent*100)
                                        ])
                                    }}
                                </p>
                                @endif
                                @if (($user->level->offer->rebate_yn ?? '') == 'Y')
                                <p>
                                    {{__('shop.rebate',[
                                        'above'=>$user->level->offer->rebate->above ,
                                        'rebate'=>showDiscount($user->level->offer->rebate->rebate)
                                        ])
                                    }}
                                </p>
                                @endif
                            </span>
                        </div>
                        
                        <div class="clearfix"></div>
                        <hr style="margin:5px 0 5px 0;">
                        <div class="text-center">
                            <div class="col-sm-5 col-xs-6 tital ">{{__('shop.name')}}:</div>
                            <div class="col-sm-4 col-xs-3  pull-right" >
                                 <input id="name" name="name" type="text"  class="form-control  " value="{{$user->name}}" required="">
                            </div>
                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">{{__('shop.email')}}:</div>
                            <div class="col-sm-4 pull-right"">
                                <input id="email" name="email" type="text"  class="form-control  " value="{{$user->email}}" required="">    
                            </div>
                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">{{__('shop.level')}}:</div>
                            <div class="col-sm-7"> {{$user->level->name}}</div>
                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">{{__('shop.phone')}}:</div>
                            <div class="col-sm-4 pull-right"">
                                <input id="phone" name="phone" type="text"  class="form-control  " value="{{$user->phone}}" required="">    
                            </div>

                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">{{__('shop.address')}}:</div>
                            <div class="col-sm-4 pull-right"">
                                
                                <input id="address" name="address" type="text"  class="form-control  " value="{{$user->address}}" required=""> 
                            </div>

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
        </form>
    </div>
</div>
@endsection