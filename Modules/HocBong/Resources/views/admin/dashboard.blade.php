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
     
      <div class="x_content">
        <div class="row">
        

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/user.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
                SỐ LƯỢNG HỌC BỔNG: {{isset($soluong_hb) ? count($soluong_hb) : 'a'}} 
              </div>
            </div>
          </div>

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/graduates.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
              TỔNG TRỊ GIÁ: {{number_format((isset($soluong_hb) ? $soluong_hb->sum("gthb") : 0), 0 , ',', '.')}} 
              </div>
            </div>
          </div>

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
              SỐ TIỀN ĐÃ TRAO: {{number_format((isset($sl_HBdatrao) ? $sl_HBdatrao->sum("giatri") : 0), 0 , ',', '.')}} 
              </div>
            </div>
          </div>

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/teacher.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
                SỐ SV ĐÃ NHẬN HỌC BỔNG: {{(isset($sl_HBdatrao) ? $sl_HBdatrao->count("id_sinhvien") : 0)}}
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
            <div id="piechart" style="width: 100%; height: 500px;"></div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <div id="columnchart_material" style="width: 100%; height: 500px;"></div>
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
              <a href="{{route('hocbong.index')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/user.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                 QUẢN LÝ - THỐNG KÊ
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('hocbong.thongbao')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/graduates.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  QUẢN LÝ THÔNG BÁO
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('hocbong.timkiem.sinhvien')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/teacher.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  TRAO HỌC BỔNG
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
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['{{ \App\Khoa::where('id',1)->first()->tenkhoa }}' ,     {{ count($thong_ke_charts->where("idkhoa", 1)) }}],
          ['{{ \App\Khoa::where('id',2)->first()->tenkhoa }}',      {{ count($thong_ke_charts->where("idkhoa", 2)) }}],
          ['{{ \App\Khoa::where('id',3)->first()->tenkhoa }}',  {{ count($thong_ke_charts->where("idkhoa", 3)) }}],
          ['{{ \App\Khoa::where('id',4)->first()->tenkhoa }}', {{ count($thong_ke_charts->where("idkhoa", 4)) }}],
          ['{{ \App\Khoa::where('id',5)->first()->tenkhoa }}',    {{ count($thong_ke_charts->where("idkhoa", 5)) }}],
          ['{{ \App\Khoa::where('id',6)->first()->tenkhoa }}',    {{ count($thong_ke_charts->where("idkhoa", 6)) }}],
          ['{{ \App\Khoa::where('id',7)->first()->tenkhoa }}',    {{ count($thong_ke_charts->where("idkhoa", 7)) }}],
          ['{{ \App\Khoa::where('id',8)->first()->tenkhoa }}',    {{ count($thong_ke_charts->where("idkhoa", 8)) }}],
          ['{{ \App\Khoa::where('id',9)->first()->tenkhoa }}',    {{ count($thong_ke_charts->where("idkhoa", 9)) }}]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      var analytics = <?php echo $gender; ?>

   google.charts.load('current', {'packages':['bar']});

   google.charts.setOnLoadCallback(drawChart);

   function drawChart()
   {
    var data = google.visualization.arrayToDataTable(analytics);
    var options = {
     title : 'Danh sách sinh viên nhận học bổng theo từng năm'
    };
    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
   }


      
    </script>
@endsection
  