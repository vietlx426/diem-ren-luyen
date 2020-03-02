<!-- Header . contains the logo, menu, login... -->

<header class="main-header">
  <!-- Logo -->
  <a href="{{route('home')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">
      <!-- <img src="{{URL::asset('dashboard/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image"> -->
      <b>AGU</b>
    </span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>AGU</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav navbar-right">
        <!-- User Account: style can be found in dropdown.less -->
        @if (Route::has('login'))
          @auth
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{URL::asset('images/nobody_m.original.jpg')}}" class="user-image" alt="User Image">
                <span class="hidden-xs"><b>{{Auth::user()->name}}</b></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="{{URL::asset('images/nobody_m.original.jpg')}}" class="img-circle" alt="User Image">

                  <p>
                    {{Auth::user()->name}}
                    <!-- <small>Member since Nov. 2012</small> -->
                  </p>
                </li>
                <!-- Menu Body -->
                <!-- <li class="user-body"> -->
                  <!-- <div class="row">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>

                  </div> -->
                  <!-- /.row -->

                <!-- </li> -->
                <!-- Menu Footer-->
                <li class="user-footer">
                  <?php $DanhSach_Group =  Auth::user()->groups; ?>
                  
                  <!-- btn permission -->
                  <!-- @if(isset($DanhSach_Group))
                    <div class="pull-left" style="padding-bottom: 5px;">
                      @if(count($DanhSach_Group) > 1)
                        @foreach($DanhSach_Group as $Group)
                          <?php $Gr = App\Group::find($Group->idGroup); ?>
                          @switch($Gr->id)
                            @case(env('GROUP_SINHVIEN'))
                              <a href="{{route('sinhvien')}}" class="btn btn-primary btn-flat" style="margin-bottom: 5px;"> {{$Gr->Name}} </a>
                              @break

                            @case(env('GROUP_BANCANSU'))
                              <a href="{{route('sinhvien')}}" class="btn btn-primary btn-flat" style="margin-bottom: 5px;"> {{$Gr->Name}} </a>
                              @break

                            @case(env('GROUP_COVANHOCTAP'))
                              <a href="{{route('sinhvien')}}" class="btn btn-primary btn-flat" style="margin-bottom: 5px;"> {{$Gr->Name}} </a>
                              @break
                              
                            @case(env('GROUP_GIAOVUKHOA'))
                              <a href="{{route('sinhvien')}}" class="btn btn-primary btn-flat" style="margin-bottom: 5px;"> {{$Gr->Name}} </a>
                              @break
                              
                            @case(env('GROUP_CHUYENVIEN'))
                              <a href="{{route('subadmin')}}" class="btn btn-primary btn-flat" style="margin-bottom: 5px;"> {{$Gr->Name}} </a>
                              @break

                            @case(env('GROUP_TRUONGDONVI'))
                              <a href="{{route('truongdonvi')}}" class="btn btn-primary btn-flat" style="margin-bottom: 5px;"> {{$Gr->Name}} </a>
                              @break
                              

                            @case(env('GROUP_CHUYENVIENHETHONG'))
                              <a href="{{route('admin')}}" class="btn btn-primary btn-flat" style="margin-bottom: 5px;"> {{$Gr->Name}} </a>
                              @break
                              
                            @case(env('GROUP_QUANTRIHETHONG'))
                              <a href="{{route('sinhvien')}}" class="btn btn-primary btn-flat" style="margin-bottom: 5px;"> {{$Gr->Name}} </a>
                              @break
                          @endswitch
                        @endforeach
                      @endif
                    </div>
                  @endif -->
                  
                  <!-- btn profile -->
                  @if(isset($DanhSach_Group))
                    <div class="pull-left">
                      @if(count($DanhSach_Group) > 0)
                        @foreach($DanhSach_Group as $Group)
                          <?php $Gr = App\Group::find($Group->idGroup); ?>
                          @switch($Gr->id)
                            @case(env('GROUP_SINHVIEN'))
                              <a href="{{route('profile')}}" class="btn btn-default btn-flat">Profile</a>
                              @break
                          @endswitch
                        @endforeach
                      @endif
                    </div>
                  @endif
                  <div class="pull-right">
                    <a href="{{route('signout', ['provider' => env('PROVIDER')])}}" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>

            <!-- Change permisstion-->
            @if(isset($DanhSach_Group) && count($DanhSach_Group) > 1)
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-gears"></i>
                <!-- <span class="label label-success"> {{ count($DanhSach_Group) }} </span> -->
              </a>
              <ul class="dropdown-menu">
                <li class="header text-center" style="background: #3C8DBC; color: #fff;"><h4>CHUYỂN QUYỀN</h4></li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">

                    @foreach($DanhSach_Group as $Group)
                      <?php $Gr = App\Group::find($Group->idGroup); ?>
                      @switch($Gr->id)
                        @case(env('GROUP_SINHVIEN'))
                          <li><!-- start message -->
                            <a href="{{route('sinhvien')}}">
                              <div class="pull-left">
                                <i class="fa fa-universal-access fa-2x"></i>
                              </div>
                              <h4>
                                <b>{!! $Gr->Name !!}</b>
                              </h4>
                            </a>
                          </li>
                          <!-- end message -->
                          @break

                        @case(env('GROUP_BANCANSU'))
                          <li><!-- start message -->
                            <a href="{{route('sinhvien')}}">
                              <div class="pull-left">
                                <i class="fa fa-universal-access fa-2x"></i>
                              </div>
                              <h4>
                                <b>{!! $Gr->Name !!}</b>
                              </h4>
                            </a>
                          </li>
                          <!-- end message -->
                          @break

                        @case(env('GROUP_COVANHOCTAP'))
                          <li><!-- start message -->
                            <a href="{{route('sinhvien')}}">
                              <div class="pull-left">
                                <i class="fa fa-universal-access fa-2x"></i>
                              </div>
                              <h4>
                                <b>{!! $Gr->Name !!}</b>
                              </h4>
                            </a>
                          </li>
                          <!-- end message -->
                          @break
                          
                        @case(env('GROUP_GIAOVUKHOA'))
                          <li><!-- start message -->
                            <a href="{{route('sinhvien')}}">
                              <div class="pull-left">
                                <i class="fa fa-universal-access fa-2x"></i>
                              </div>
                              <h4>
                                <b>{!! $Gr->Name !!}</b>
                              </h4>
                            </a>
                          </li>
                          <!-- end message -->
                          @break
                          
                        @case(env('GROUP_CHUYENVIEN'))
                          <li><!-- start message -->
                            <a href="{{route('subadmin')}}">
                              <div class="pull-left">
                                <i class="fa fa-universal-access fa-2x"></i>
                              </div>
                              <h4>
                                <b>{!! $Gr->Name !!}</b>
                              </h4>
                            </a>
                          </li>
                          <!-- end message -->
                          @break

                        @case(env('GROUP_TRUONGDONVI'))
                          <li><!-- start message -->
                            <a href="{{route('truongdonvi')}}">
                              <div class="pull-left">
                                <i class="fa fa-universal-access fa-2x"></i>
                              </div>
                              <h4>
                                <b>{!! $Gr->Name !!}</b>
                              </h4>
                            </a>
                          </li>
                          <!-- end message -->
                          @break
                          

                        @case(env('GROUP_CHUYENVIENHETHONG'))
                          <li><!-- start message -->
                            <a href="{{route('admin')}}">
                              <div class="pull-left">
                                <i class="fa fa-universal-access fa-2x"></i>
                              </div>
                              <h4>
                                <b>{!! $Gr->Name !!}</b>
                              </h4>
                            </a>
                          </li>
                          <!-- end message -->
                          @break
                          
                        @case(env('GROUP_QUANTRIHETHONG'))
                          <li><!-- start message -->
                            <a href="{{route('admin')}}">
                              <div class="pull-left">
                                <i class="fa fa-universal-access fa-2x"></i>
                              </div>
                              <h4>
                                <b>{!! $Gr->Name !!}</b>
                              </h4>
                            </a>
                          </li>
                          <!-- end message -->
                          @break
                      @endswitch
                    @endforeach
                   
                  </ul>
                </li>
                <!-- <li class="footer"><a href="#">&nbsp;</a></li> -->
              </ul>
            </li>
            @endif

          @else
            <li>
              <a href="{{route('gsignin', ['provider' => env('PROVIDER')])}}" data-toggle="control-sidebar"><i class="fa fa-login"></i>Đăng nhập</a>
            </li>
          @endauth
        @endif
         &emsp; 
        <!-- Control Sidebar Toggle Button -->
        <!-- <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li> -->
      </ul>

    </div>
  </nav>
</header>