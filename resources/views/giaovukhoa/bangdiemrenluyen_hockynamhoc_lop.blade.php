@extends('giaovukhoa.layout.master')
@section('title')
  @parent | Bảng điểm rèn luyện
@endsection

@section('css')
  <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
          <h2> <i class="fa fa-edit"></i> BẢNG ĐIỂM RÈN LUYỆN - LỚP <small>{{isset($hocKyNamHoc)?$hocKyNamHoc->tenhockynamhoc:''}}</small></h2>
          <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row container">
            @include('layouts.gentelella-master.blocks.flash-messages')
        </div>
        <div class="row">
          @if(isset($dsLop))
            @foreach($dsLop as $lop)
              <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Điểm rèn luyện {{$lop->tenlop}}">
                <div class="row dash-box">
                  <a href="{{route('giaovukhoa_bangdiemrenluyen_hockynamhoc_lop_ketqua', ['idhockynamhoc'=>$hocKyNamHoc->id,'idlop'=>$lop->id])}}" class="a-waiting">
                    <div class="row img">
                      <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 70%;">
                    </div>
                    <div class="row title">
                      {{$lop->tenlop}}
                    </div>
                  </a>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
  @parent
  <script>
    $('.a-waiting').click(function(){
      loadereffectshow();
    });
  </script>
@endsection