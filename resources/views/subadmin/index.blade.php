@extends('subadmin.layout.master')
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
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
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
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Chức năng -->
  <div class="row">
    <div class="x_panel">
      <div class="x_content">
        <div class="row">
          <div class="col-xm-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 col-lg-offset-3 col-xl-offset-3" title="Kết quả điểm rèn luyện">
            <div class="row dash-box">
              <a href="{{route('subadmin_bangdiemrenluyen_hockynamhoc')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/checklist1.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  KẾT QUẢ ĐRL
                </div>
              </a>
            </div>
          </div>
          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Hoạt động sự kiện">
            <div class="row dash-box">
              <a href="{{route('hoatdongsukien')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/running.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  HĐ-SK
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Tiêu chí - Minh chứng">
            <div class="row dash-box">
              <a href="{{route('subadmin_index_tieuchi_minhchung')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/privacy-policy.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  TIÊU CHÍ
                </div>
              </a>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('subadmin_sinhvien')}}">
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
              <a href="{{route('subadmin_canbogiangvien')}}">
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
              <a href="{{route('subadmin_khoa')}}">
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
              <a href="{{route('subadmin_bomon')}}">
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
              <a href="{{route('subadmin_nganhhoc')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  NGÀNH ĐÀO TẠO
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
            <div class="row dash-box">
              <a href="{{route('subadmin_lop')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  LỚP HỌC
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection