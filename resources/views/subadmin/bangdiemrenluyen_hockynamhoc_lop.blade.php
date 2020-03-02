@extends('subadmin.layout.master')
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
          @if(isset($dsLop))
            @foreach($dsLop as $lop)
              <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Điểm rèn luyện {{$lop->tenlop}}">
                <div class="row dash-box">
                  <a href="{{route('subadmin_bangdiemrenluyen_hockynamhoc_lop_ketqua', [ 'idhockynamhoc'=>$hocKyNamHoc->id ,'idlop'=>$lop->id])}}" class="a-waiting">
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