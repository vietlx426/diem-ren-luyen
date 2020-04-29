<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="icon" href="{{URL::asset('images/icons/favicon.ico')}}" type="image/x-icon"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">

    <title> @yield('title') </title>

    <!-- Bootstrap -->
    <link href="{{URL::asset('gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{URL::asset('gentelella-master/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{URL::asset('gentelella-master/build/css/custom.min.css')}}" rel="stylesheet">

    <!-- Loader -->
    <link href="{{URL::asset('css/mystyle.css')}}" rel="stylesheet">

    @yield('css')
  </head>

  <body class="nav-md">

    <!-- loader -->
    <div id="site-loader" class="fullscreen siteloader show" style="background-color: rgba(0, 0, 0, 0.7);"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg>
    </div>

    <div class="container body" style="margin: 0 0 0 0; height: 25px !important;">
      <div class="main_container">
        <!-- left menu   -->
        <!-- @include('layouts.gentelella-master.blocks.left-menu') -->
        <!-- /left menu   -->

        <!-- top navigation -->
        @include('layouts.gentelella-master.blocks.top-navigation')
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            @yield('content')
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        @include('layouts.gentelella-master.blocks.footer')
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{URL::asset('gentelella-master/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{URL::asset('gentelella-master/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{URL::asset('gentelella-master/build/js/custom.min.js')}}"></script>
    <script type="text/javascript">
        var loader = function() {
          setTimeout(function() { 
            if($('#site-loader').length > 0) {
              $('#site-loader').removeClass('show');
            }
          }, 10);
        };
        loader();
    </script>
    @yield('javascript')
  </body>
</html>