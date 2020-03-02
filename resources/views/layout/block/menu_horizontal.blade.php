<!-- Horizontal menu -->
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light nav_horizontal_menu"> -->
<nav class="navbar navbar-inverse navbar-expand-lg nav_horizontal_menu">
    <div class="container">
        <a class="navbar-brand horizontal_menu_a" href="{{route('home')}}">
            &nbsp; <i class="fa fa-home"></i> AGU &nbsp;
        </a>
        <!-- <button class="navbar-toggler btn-primary" data-toggle="collapse" data-target="#navbarTogglerMenuHorizontal" aria-controls="navbarTogglerMenuHorizontal" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <a href="#navbarTogglerMenuHorizontal" class="navbar-toggler" data-toggle="collapse"><i class="fa fa-navicon fa-lg"></i></a>
        <div class="collapse navbar-collapse" id="navbarTogglerMenuHorizontal">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <!-- <a class="nav-link horizontal_menu_a" href="#">
                        <i class="fa fa-info-circle"></i>
                        Intro 
                    </a> -->
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link horizontal_menu_a" href="#">
                        <i class="fa fa-address-card"></i>
                        Contact 
                    </a> -->
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle " href="#" id="navbardrop" data-toggle="dropdown">
                                <span class="fa fa-user-circle"></span> {{Auth::user()->name}}
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item horizontal_menu_a" href="{{route('signout',['provider', env('PROVIDER')])}}"><span class="fa fa-sign-out"></span> Đăng xuất </a>
                                <a class="dropdown-item horizontal_menu_a" href="#"><span class="fa fa-refresh"></span> Đổi mật khẩu </a>
                            </div>
                        </li>
                    @else
                        <!-- <li><a href="{{ route('gsignin', ['provider'=> env('PROVIDER')]) }}"> <button type="button" class="btn btn-sm btn-pill btn-primary"><span class="fa fa-sign-in"></span> Login </button> </a> </li> -->
                        <li><a href="{{ route('gsignin', ['provider'=> env('PROVIDER')]) }}"> <button type="button" class="btn btn-sm btn-pill btn-primary"><span class="fa fa-sign-in"></span> Đăng nhập </button> </a> </li>
                        <!-- <li><a href="{{ route('register') }}"> <button type="button" class="btn btn-sm btn-pill btn-warning"><span class="fa fa-sign-in"></span>  </button> </a> </li> -->
                    @endauth
                @endif
                <!-- <li><a href="#"> <button type="button" class="btn btn-sm btn-pill btn-success"><span class="fa fa-user-circle"></span> User </button>   </a> </li> -->
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                
            </form> -->
        </div>
    </div>
</nav>