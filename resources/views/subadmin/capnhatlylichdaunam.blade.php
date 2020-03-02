@extends('subadmin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/admin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/image-profile.css')}}">
    <style>
        .btn{
            margin-top: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="container text-center">
        <div class="col-12" id="chart">
          <div class="col-12 text-center" id="piechart"></div>
        </div>
        <div class="text-center">Sơ đồ tỷ lệ sinh viên đã cập nhật lý lịch bậc Đại học và Cao đẳng</div>
        <hr>

        <div class="row">
          <div class="col-12">
            <h4>DANH SÁCH TÂN SINH VIÊN CÁC KHOA</h4>
          </div>

          @if(isset($DanhSach_Khoa))
              @foreach($DanhSach_Khoa as $Khoa)
                  <div class="col-sm-12 col-md-6 col-lg-6">
                      <a target="_blank" href="{{route('updatedstudentprofilefalcuty', ['id'=>$Khoa->id])}}" class="btn btn-primary btn-block">{{$Khoa->tenkhoa}}</a>
                  </div>
              @endforeach
          @endif
        </div>
        <br>
        <input id="numCD" type="text" value="{{$CD}}" hidden="true">
        <input id="numCD_DaCapNhat" type="text" value="{{$CD_DaCapNhat}}" hidden="true">
        <input id="numDH" type="text" value="{{$DH}}" hidden="true">
        <input id="numDH_DaCapNhat" type="text" value="{{$DH_DaCapNhat}}" hidden="true">
    </div>
       
@endsection
@section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/profile_register.js') !!}"></script>

    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/upload-image-profile.js') !!}"></script>

    <script src="{{URL::asset('js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}" type="text/javascript" charset="utf-8" async defer></script>

     <script type="text/javascript" src="{!! URL::asset('js/donvihanhchinh.js') !!}"></script>
     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
        var numCD = parseInt($('#numCD').val());
        var numCD_DaCapNhat = parseInt($('#numCD_DaCapNhat').val());
        var numDH = parseInt($('#numDH').val());
        var numDH_DaCapNhat = parseInt($('#numDH_DaCapNhat').val());
        // alert("char: " + $('#chart').width());
        // alert("document: " + $(document).width());
        
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Cao đẳng đã cập nhật lý lịch', numCD_DaCapNhat],
          ['Cao đẳng chưa cập nhật lý lịch', numCD-numCD_DaCapNhat],
          ['Đại học đã cập nhật lý lịch', numDH_DaCapNhat],
          ['Đại học chưa cập nhật lý lịch', numDH-numDH_DaCapNhat]
          // ['Gym', 2],
          // ['Sleep', 7]
        ]);
     

      // Optional; add a title and set the width and height of the chart
      var options = {'title':'', 'width':$('#chart').width(), 'height':($('#chart').width()/2)};

      // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
    </script>
@endsection