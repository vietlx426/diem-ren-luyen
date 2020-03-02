@extends('bancansu.layout.master')
@section('title')
  @parent | Dashboard
@endsection

@section('css')
  <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">
@endsection

@section('content')
  <!-- Danh sách - chức năng -->
  <div class="row">
    <div class="x_panel">
      <div class="x_content">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 col-xl-2 col-md-offset-2 col-lg-offset-4 col-xl-offset-4" title="Kết quả rèn luyện của lớp">
            <div class="row dash-box">
              <a href="{{route('bancansu_bangdiemrenluyen')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/checklist1.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  KẾT QUẢ ĐRL
                </div>
              </a>
            </div>
          </div>

          <div class="col-xm-12 col-sm-6 col-md-4 col-lg-2 col-xl-2" title="Tiêu chí - Minh Chứng">
            <div class="row dash-box">
              <a href="{{route('bancansu_index_tieuchi_minhchung')}}">
                <div class="row img">
                  <img src="{{URL::asset('images/icons/checklist.png')}}" alt="" style="width: 70%;">
                </div>
                <div class="row title">
                  MINH CHỨNG
                </div>
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection