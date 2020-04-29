<!-- left menu -->
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('home')}}" class="site_title">
                <!-- <i class="fa fa-paw"></i> -->
                <img src="{{URL::asset('images/icons/favicon.ico')}}" alt="">
                <span>ĐRL - P.CTSV</span>
            </a>
        </div>

        <div class="clearfix"></div>
    
        <!-- menu profile quick info -->
        <!-- <div class="profile clearfix">
            <div class="profile_pic">
            <img src="{{URL::asset('images/profile_default.png')}}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
            <span>Welcome,</span>
            <h2>John Doe</h2>
            </div>
        </div> -->
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        @yield('left-menu')
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <!-- <a data-toggle="tooltip" data-placement="top" title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a> -->
            <!-- <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{route('logout')}}">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a> -->
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
<!-- /left menu  