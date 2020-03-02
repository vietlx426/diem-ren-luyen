@extends('subadmin.layout.master')
@section('title')
  @parent | Class
@endsection

@section('css')
  <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">
@endsection

@section('content')
  <div class="row text-center">
    <h4>DANH SÁCH LỚP - ĐÁNH GIÁ ĐIỂM RÈN LUYỆN</h4>
  </div>
  <div class="row">
    <div class="x_panel">
      <div class="x_content">
        <div class="row">
          @if(isset($listLop))
            @foreach($listLop as $lop)
              <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Click để đánh giá điểm rèn luyện cho lớp {{$lop->tenlop}}">
                <div class="row dash-box">
                  <a href="{{route('subadmin_danhgiadiemrenluyen_lop', ['id'=>$lop->id])}}">
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