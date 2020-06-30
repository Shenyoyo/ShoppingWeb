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
        <a class="navbar-brand" href="{{route('admin.products')}}">首頁</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{route('admin.products')}}"></i> 庫存管理</a></li>
                <li><a href="{{route('category.index')}}"></i> 分類管理</a></li>
                <li><a href="{{route('level.index')}}"></i> 會員等級管理 </a></li>
                <li><a href="{{route('offer.index')}}"></i> 優惠管理</a></li>
                <li><a href="{{route('order.index')}}"></i> 訂單管理</a></li>
                <li><a href="#"></i> 會員帳號管理</a></li>
                
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown ">
                    <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i> 管理者 <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                            <li><a href="#">管理者資料</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('admin.logout')}}">登出</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>