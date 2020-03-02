@extends('covanhoctap.layout.master')
@section('title')
  @parent | Dashboard
@endsection

@section('css')
  <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">
@endsection

@section('content')
  <!-- Information statical -->
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <!-- Sale statical -->
          <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 col-lg-offset-3 col-md-offset-3">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-futbol-o"></i></div>
                  <div class="count"> <font style="font-size: 20px;"> {{number_format((isset($countHoatDongSuKien) ? $countHoatDongSuKien : 0), 0 , ',', '.')}} </font> </div>
                  <h3>HOẠT ĐỘNG</h3>
                  <h3>SỰ KIỆN</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-graduation-cap"></i></div>
                  <div class="count"> <font style="font-size: 20px;"> {{number_format((isset($countTongSinhVien) ? $countTongSinhVien : 0), 0 , ',', '.')}} </font> </div>
                  <h3>SINH VIÊN</h3>
                  <h3>&nbsp;</h3>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Danh mục - Danh sách -->
  <div class="row">
    <div class="x_panel">
      <div class="x_content">
        <div class="row">
          <div class="col-xm-12 col-sm-4 col-md-3 col-lg-2 col-md-offset-1 col-lg-offset-2 col-xl-offset-2" title="Kết quả rèn luyện của lớp">
            <div class="row dash-box">
              <a href="{{route('covanhoctap_bangdiemrenluyen')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/checklist1.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  KẾT QUẢ ĐRL
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Tiêu chí - Minh chứng">
            <div class="row dash-box">
              <a href="{{route('covanhoctap_index_tieuchi_minhchung')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/checklist.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  MINH CHỨNG
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Danh sách hoạt động - sự kiện">
            <div class="row dash-box">
              <a href="{{route('covanhoctap_hoatdongsukien')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/running.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  HĐ - SK
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Danh sách sinh viên">
            <div class="row dash-box">
              <a href="{{route('covanhoctap_sinhvien')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/graduates.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  SINH VIÊN
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection