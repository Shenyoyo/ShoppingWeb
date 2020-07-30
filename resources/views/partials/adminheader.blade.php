<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        <a class="navbar-brand" href="{{route('admin.products')}}">{{__('shop.home')}}</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{route('admin.products')}}"></i>{{__('shop.Stock Management')}}</a></li>
                <li><a href="{{route('category.index')}}"></i> {{__('shop.Category Management')}}</a></li>
                <li><a href="{{route('level.index')}}"></i> {{__('shop.Level Management')}} </a></li>
                <li><a href="{{route('offer.index')}}"></i> {{__('shop.Offer Management')}}</a></li>
                <li><a href="{{route('order.index')}}"></i> {{__('shop.Order Management')}}</a></li>
                <li><a href="{{route('adminUser.index')}}"></i> {{__('shop.Account Management')}}</a></li>
                <li><a href="{{route('adminContact.index')}}"></i> {{__('shop.Reply Management')}}</a></li>
                <li><a href="{{route('dollor.index')}}"></i> {{__('shop.virtualrecord')}}</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-language"></i>{{__('shop.language') }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/changeLocale/zh')}}">{{__('shop.zh') }}</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ url('/changeLocale/en')}}">{{__('shop.en') }}</a></li>
                    </ul>
                </li>
                <li class="dropdown ">
                    <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i> {{__('shop.Administrator')}} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                            <li><a href="#">{{__('shop.Administrator info')}}</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('admin.logout')}}">{{__('shop.signout')}}</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>