@extends('giaovukhoa.layout.master')
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
              <!-- <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-users"></i></div>
                  <div class="count"> <font style="font-size: 20px;"> {{number_format((isset($countHoatDongSuKien) ? $countHoatDongSuKien : 0), 0 , ',', '.')}} </font> </div>
                  <h3>HOẠT ĐỘNG</h3>
                  <h3>SỰ KIỆN</h3>
                </div>
              </div> -->
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 col-lg-offset-3 col-md-offset-3">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-graduation-cap"></i></div>
                  <div class="count"> <font style="font-size: 20px;"> {{number_format((isset($countTongSinhVien) ? $countTongSinhVien : 0), 0 , ',', '.')}} </font> </div>
                  <h3>SINH VIÊN</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-university"></i></div>
                  <div class="count"> <font style="font-size: 20px;"> {{number_format((isset($countLopQuanLy) ? $countLopQuanLy : 0), 0 , ',', '.')}} </font> </div>
                  <h3>LỚP</h3>
                </div>
              </div>
              <!-- <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-gears"></i></div>
                  <div class="count"> <font style="font-size: 20px;">  {{number_format((isset($countLopQuanLy) ? $countLopQuanLy : 0), 0 , ',', '.')}} </font> </div>
                  <h3>LỚP THUỘC</h3>
                  <h3>QUYỀN QUẢN LÝ</h3>
                </div>
              </div> -->
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
          <div class="col-xm-12 col-sm-4 col-md-4 col-lg-2 col-xl-2  col-lg-offset-2 col-xl-2" title="Kết quả điểm rèn luyện">
            <div class="row dash-box">
              <a href="{{route('giaovukhoa_bangdiemrenluyen_hockynamhoc')}}">
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
              <a href="{{route('giaovukhoa_index_tieuchi_minhchung')}}">
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
              <a href="{{route('giaovukhoa_hoatdongsukien')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/running.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  HĐ - SK
                </div>
              </a>
            </div>
          </div>
          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Lớp học">
            <div class="row dash-box">
              <a href="{{route('giaovukhoa_lop')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  LỚP
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection