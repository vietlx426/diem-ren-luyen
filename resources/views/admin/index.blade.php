@extends('admin.layout.master')
@section('title')
  @parent | Dashboard
@endsection()
@section('css')
  <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
@endsection()
@section('content')
  <!-- Information statical -->
  <div class="row">
    <div class="x_panel">
      <!-- <div class="x_title">
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
        </ul>
        <div class="clearfix"></div>
      </div> -->
      <div class="x_content">
        <div class="row">
          <!-- Sale statical -->
          <!-- <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-users"></i></div>
                  <div class="count"> <font style="font-size: 20px;"> {{number_format((isset($userTotal) ? $userTotal : 0), 0 , ',', '.')}} </font> </div>
                  <h3>USERS</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-graduation-cap"></i></div>
                  <div class="count"> <font style="font-size: 20px;">  {{number_format((isset($studentTotal) ? $studentTotal : 0), 0 , ',', '.')}} </font> </div>
                  <h3>STUDENTS</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-university"></i></div>
                  <div class="count"> <font style="font-size: 20px;">  {{number_format((isset($classTotal) ? $classTotal : 0), 0 , ',', '.')}} </font> </div>
                  <h3>CLASS</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                  <div class="count"> <font style="font-size: 20px;">  {{number_format((isset($staffTotal) ? $staffTotal : 0), 0 , ',', '.')}} </font> </div>
                  <h3>LECTURERS</h3>
                </div>
              </div>
          </div> -->

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/user.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
                {{number_format((isset($userTotal) ? $userTotal : 0), 0 , ',', '.')}} USERS
              </div>
            </div>
          </div>

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/graduates.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
              {{number_format((isset($studentTotal) ? $studentTotal : 0), 0 , ',', '.')}} SINH VIÊN
              </div>
            </div>
          </div>

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
              {{number_format((isset($classTotal) ? $classTotal : 0), 0 , ',', '.')}} LỚP
              </div>
            </div>
          </div>

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/teacher.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
                {{number_format((isset($staffTotal) ? $staffTotal : 0), 0 , ',', '.')}} CB-GV
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>

  <!-- Statical chart -->
  <div class="row">
    <div class="x_panel">
      <!-- <div class="x_title">
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
        </ul>
        <div class="clearfix"></div>
      </div> -->
      <div class="x_content">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div id="columnchart_material" style="width: 100%; height: 400px;"></div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <div id="piechart1" style="width: 100%; height: 200px;"></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <div id="piechart2" style="width: 100%; height: 200px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Danh mục - Danh sách -->
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2>Danh mục <small>category/list</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('user')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/user.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  USERS
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('admin_sinhvien_timkiem')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/graduates.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  SINH VIÊN
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('admin_canbogiangvien')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/teacher.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  CB-GV
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('khoa')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/school.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  KHOA-PHÒNG
                </div>
              </a>
            </div>
          </div>
          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('bomon')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/teamwork.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  BỘ MÔN-TỔ
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('lop')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  LỚP HỌC
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('hockynamhoc')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/annual.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  HK-NH
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('namhoc')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/calendar.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  NĂM HỌC
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('bacdaotao')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/equalizer.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  BẬC ĐT
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('hedaotao')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/elearning.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  HỆ ĐT
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('dantoc')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/vietnam.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  DÂN TỘC
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('tongiao')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/lotus-flower.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  TÔN GIÁO
                </div>
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection()

@section('javascript')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      var title1 = "{{$dataStaticalKind[0]['hockynamhoc']}}";

      console.log("Title: " + title1);
      google.charts.load('current', {'packages':['bar', 'corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['', 'Xuất sắc', 'Tốt', 'Khá', 'Trung bình', 'Yếu', 'Kém'],
          ["{{$dataStaticalKind[0]['hockynamhoc']}}", parseInt("{{$dataStaticalKind[0]['xuatsac']}}"), parseInt("{{$dataStaticalKind[0]['tot']}}"), parseInt("{{$dataStaticalKind[0]['kha']}}"), parseInt("{{$dataStaticalKind[0]['trungbinh']}}"), parseInt("{{$dataStaticalKind[0]['yeu']}}"), parseInt("{{$dataStaticalKind[0]['kem']}}")],
          ["{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['hockynamhoc']:''}}", parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['xuatsac']:0}}"), parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['tot']:0}}"), parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['kha']:0}}"), parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['trungbinh']:0}}"), parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['yeu']:0}}"), parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['kem']:0}}")]
        ]);

        var options = {
          chart: {
            title: 'BIỂU ĐỒ THỐNG KÊ THEO LOẠI RÈN LUYỆN',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));

        
        var data_piechar1 = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Xuất sắc',     parseInt("{{$dataStaticalKind[0]['xuatsac']}}")],
          ['Tốt',      parseInt("{{$dataStaticalKind[0]['tot']}}")],
          ['Khá',  parseInt("{{$dataStaticalKind[0]['kha']}}")],
          ['Trung bình', parseInt("{{$dataStaticalKind[0]['trungbinh']}}")],
          ['Yếu',    parseInt("{{$dataStaticalKind[0]['yeu']}}")],
          ['Kém',    parseInt("{{$dataStaticalKind[0]['kem']}}")]
        ]);

        var options_piechar1 = {
          title: "{{$dataStaticalKind[0]['hockynamhoc']}}",
          is3D: true,
        };
        var chart_piechar1 = new google.visualization.PieChart(document.getElementById('piechart1'));
        chart_piechar1.draw(data_piechar1, options_piechar1);


        var data_piechar2 = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Xuất sắc',     parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['xuatsac']:0}}")],
          ['Tốt',      parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['tot']:0}}")],
          ['Khá',  parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['kha']:0}}")],
          ['Trung bình', parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['trungbinh']:0}}")],
          ['Yếu',    parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['yeu']:0}}")],
          ['Kém',    parseInt("{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['kem']:0}}")]
        ]);

        var options_piechar2 = {
          title: "{{isset($dataStaticalKind[1])?$dataStaticalKind[1]['hockynamhoc']:''}}",
          is3D: true,
        };

        var chart_piechar2 = new google.visualization.PieChart(document.getElementById('piechart2'));
        chart_piechar2.draw(data_piechar2, options_piechar2);
      }
    </script>
@endsection
  