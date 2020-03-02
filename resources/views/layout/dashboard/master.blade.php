<?php 
    header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', FALSE);
    header('Pragma: no-cache');
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="cache-control" content="max-age=0">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
  <meta http-equiv="pragma" content="no-cache">

  <title> DRL @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}" type="text/css">
  <!-- <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css')}}"> -->
  <link href="{{URL::asset('css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('css/master.css')}}" rel="stylesheet" type="text/css">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/font-awesome/css/font-awesome.min.css')}}"> -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">


  <!-- Daterange picker -->
  <!-- <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css')}}"> -->

  <!-- loader -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/dist/css/skins/style.css')}}">

  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->

  @yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Header . contains the logo, menu, login... -->
  @include('layout.dashboard.menu_header');

  <!-- Left side column. contains the logo and sidebar -->
  @include('layout.dashboard.menu_left');

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('content-header')
    </section>

    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Footer . contains designer, version... -->
   @include('layout.dashboard.footer');
   
</div>
<!-- ./wrapper -->

<!-- loader -->
<div id="site-loader" class="fullscreen" style="background-color: rgba(0, 0, 0, 0.7);"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg>
</div>




<!-- jQuery 3 -->
<script src="{{URL::asset('dashboard/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{URL::asset('dashboard/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{URL::asset('dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{URL::asset('dashboard/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{URL::asset('dashboard/bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{URL::asset('dashboard/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{URL::asset('dashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{URL::asset('dashboard/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{URL::asset('dashboard/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{URL::asset('dashboard/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{URL::asset('dashboard/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{URL::asset('dashboard/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{URL::asset('dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{URL::asset('dashboard/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{URL::asset('dashboard/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{URL::asset('dashboard/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{URL::asset('dashboard/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{URL::asset('dashboard/dist/js/demo.js')}}"></script>
<script type="text/javascript" src="{!! URL::asset('js/ckeditor/ckeditor.js') !!}"></script>
<script type="text/javascript" src="{!! URL::asset('js/ckfinder/ckfinder.js') !!}"></script>
@yield('javascript')
</body>
</html>
