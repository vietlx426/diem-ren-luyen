<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> ĐRL AGU | Information @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/Ionicons/css/ionicons.min.css')}}">
  @yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper text-center">
    <br>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <!-- <div class="panel-heading">THÔNG BÁO TỪ HỆ HỐNG ĐIỂM RÈN LUYỆN - AGU</div> -->
              <div class="panel-heading"><h4>THÔNG BÁO TỪ HỆ HỐNG AGU</h4></div>
              <div class="panel-body">
                @yield('content_body')
              </div>
              <div class="panel-footer">
                @yield('content_footer')
              </div>
          </div>
      </div>
    </div>
  </div>
  <!-- ./wrapper -->
  @yield('javascript')
</body>
</html>
