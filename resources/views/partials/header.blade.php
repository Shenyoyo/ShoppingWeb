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
        <a class="navbar-brand" href="{{route('shop.index')}}">{{__('shop.home')}}</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
            <li><a href="{{route('contact.index')}}"><i class="fa fa-comments" aria-hidden="true"></i> {{__('shop.contact') }}</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-language"></i>{{__('shop.language') }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/changeLocale/zh')}}">{{__('shop.zh') }}</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ url('/changeLocale/en')}}">{{__('shop.en') }}</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/cart') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{__('shop.ShoppingCart') }} ({{ Cart::instance('default')->count(false) }})</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        @if (Auth::check())   
                        $:{{ presentPrice(Auth::user()->dollor->dollor) }} <i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }}({{Auth::user()->level->name}}) <span class="caret"></span>
                        @else
                        <i class="fa fa-user" aria-hidden="true"></i> {{__('shop.user') }} <span class="caret"></span>
                        @endif
                    </a>
                    
                    <ul class="dropdown-menu">
                        @if (Auth::check())
                            <li><a href="{{ route('user.profile')}}">{{__('shop.myprodile') }}</a></li>
                            <li><a href="{{ route('user.order')}}">{{__('shop.myorder') }}</a></li>
                            <li><a href="{{ route('user.dollor')}}">{{__('shop.virtualrecord') }}</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('user.logout')}}">{{__('shop.signout') }}</a></li>
                        @else
                            <li><a href="{{ route('user.signup')}}">{{__('shop.signup') }}</a></li>
                            <li><a href="{{ route('user.signin')}}">{{__('shop.signin') }}</a></li>
                        @endif
                        
                       
                      
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>