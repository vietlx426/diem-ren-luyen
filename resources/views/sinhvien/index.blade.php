@extends('sinhvien.layout.master')
@section('title')
  @parent | Dashboard
@endsection

@section('css')
  <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">
@endsection

@section('content')
  <!-- Danh mục - Danh sách -->
  <div class="row">
    <div class="x_panel">
      <div class="x_content">
        <div class="row">
          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 col-lg-offset-2 col-xl-offset-2" title="Kết quả rèn luyện">
            <div class="row dash-box">
              <a href="{{route('sinhvien_bangdiemrenluyen')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/checklist1.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  KẾT QUẢ RL
                </div>
              </a>
            </div>
          </div>
          <div class="col-xm-12 col-sm-6 col-md-4 col-lg-2 col-xl-2" title="Tiêu chí - Minh Chứng">
            <div class="row dash-box">
              <a href="{{route('sinhvien_index_tieuchi_minhchung')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/checklist.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  MINH CHỨNG
                </div>
              </a>
            </div>
          </div>
          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-2" title="Danh sách hoạt động - sự kiện">
            <div class="row dash-box">
              <a href="{{route('sinhvien_hoatdongsukien')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/running.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  HĐ - SK
                </div>
              </a>
            </div>
          </div>
          <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-2" title="Thông tin lý lịch">
            <div class="row dash-box">
              <a href="{{route('sinhvien_profile')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/profile.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  LÝ LỊCH
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection