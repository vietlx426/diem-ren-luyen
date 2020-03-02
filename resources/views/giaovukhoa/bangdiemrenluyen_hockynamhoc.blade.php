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
      <div class="x_content">
        <div class="row">
          @if(isset($dsHocKyNamHoc))
            @foreach($dsHocKyNamHoc as $hocKyNamHoc)
              <div class="col-xm-6 col-sm-4 col-md-3 col-lg-3 col-xl-1" title="Điểm rèn luyện {{$hocKyNamHoc->tenhockynamhoc}}">
                <div class="row dash-box">
                  <a href="{{route('giaovukhoa_bangdiemrenluyen_hockynamhoc_lop', ['idhockynamhoc'=>$hocKyNamHoc->id])}}">
                    <div class="row img">
                      <img src="{{URL::asset('images/icons/annual.png')}}" alt="" style="width: 70%;">
                    </div>
                    <div class="row title">
                      {{trim(explode("-",$hocKyNamHoc->tenhockynamhoc)[0])}}
                      <br>
                      {{trim(explode("-",$hocKyNamHoc->tenhockynamhoc)[1])}} - {{trim(explode("-",$hocKyNamHoc->tenhockynamhoc)[2])}}
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