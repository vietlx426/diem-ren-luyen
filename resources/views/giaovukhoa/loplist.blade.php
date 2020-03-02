@extends('giaovukhoa.layout.master')
@section('title')
  @parent | Class
@endsection

@section('css')
  <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
          <h2> <i class="fa fa-graduation-cap"></i> DANH SÁCH LỚP - SINH VIÊN </h2>
          <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          @if(isset($listLop))
            @foreach($listLop as $lop)
              <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Click để đánh giá điểm rèn luyện cho lớp {{$lop->tenlop}}">
                <div class="row dash-box">
                  <a href="{{route('giaovukhoa_lop_sinhvien', ['id'=>$lop->id])}}">
                    <div class="row img">
                      <img src="{{URL::asset('images/icons/checklist.png')}}" alt="" style="width: 70%;">
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