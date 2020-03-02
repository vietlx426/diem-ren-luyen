<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    @if (Route::has('login'))
                        @auth
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="{{URL::asset('images/nobody_m.original.jpg')}}" alt=""> {{Auth::user()->name}}
                            <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <?php 
                                    $DS_GroupOfUserCurrent = App\Http\Controllers\ServiceUserController::DSGroupOfUserCurrent();
                                    $arrayPermission = App\Http\Controllers\ServiceUserController::PermissionList();
                                ?>
                                @if(isset($DS_GroupOfUserCurrent))
                                    @foreach($DS_GroupOfUserCurrent as $Group)
                                        @if($Group->idGroup == 2 || $Group->idGroup == 1)
                                            <li><a href="{{route('admin')}}"><i class="fa fa-cogs pull-right"></i> Chuyên viên hệ thống </a></li>
                                        @endif

                                        @if($Group->idGroup == 8)
                                            <li><a href="{{route('sinhvien')}}"><i class="fa fa-graduation-cap pull-right"></i> Sinh viên </a></li>
                                        @endif

                                    @endforeach
                                @endif

                                @if($arrayPermission['chuyenvien_lop'])
                                    <li><a href="{{route('subadmin')}}"><i class="fa fa-tachometer pull-right"></i> Chuyên viên</a></li>
                                @endif

                                @if($arrayPermission['giaovukhoa'])
                                    <li><a href="{{route('giaovukhoa')}}"><i class="fa fa-user-secret pull-right"></i> Giáo vụ khoa</a></li>
                                @endif

                                @if($arrayPermission['covanhoctap'])
                                    <li><a href="{{route('covanhoctap')}}"><i class="fa fa-user pull-right"></i> Cố vấn học tập</a></li>
                                @endif

                                @if($arrayPermission['bancansu'])
                                    <li><a href="{{route('bancansu')}}"><i class="fa fa-user-secret pull-right"></i> Ban cán sự</a></li>
                                @endif

                                <li><a href="{{route('changepassword')}}"><i class="fa fa-refresh pull-right"></i> Đổi mật khẩu</a></li>

                                <li><a href="{{route('logout')}}"><i class="fa fa-sign-out pull-right"></i> Đăng xuất</a></li>
                            </ul>
                        @else
                            <li><a href="{{ route('redirect-login') }}"> <!-- <button type="button" class="btn btn-sm btn-pill btn-primary"> --> <span class="fa fa-sign-in"></span> Đăng nhập </button> </a> </li>
                        @endauth
                    @endif
                    <!-- <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{URL::asset('images/profile_default.png')}}" alt="">Chitala
                    <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li> -->
                    <!-- <li>
                        <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                        </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li> -->
                    <!-- <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul> -->
                </li>

            <!-- <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-envelope-o"></i>
                <span class="badge bg-green">6</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                <li>
                    <a>
                    <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                    <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                    </span>
                    <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                    </span>
                    </a>
                </li>
                <li>
                    <a>
                    <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                    <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                    </span>
                    <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                    </span>
                    </a>
                </li>
                <li>
                    <a>
                    <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                    <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                    </span>
                    <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                    </span>
                    </a>
                </li>
                <li>
                    <a>
                    <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                    <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                    </span>
                    <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                    </span>
                    </a>
                </li>
                <li>
                    <div class="text-center">
                    <a>
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    </div>
                </li>
                </ul>
            </li> -->
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->