@extends('covanhoctap.layout.master')

@section('css')
  <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">
@endsection

@section('content')
  <!-- Danh sách học kỳ - năm học -->
  <div class="row">
    <div class="x_panel">
      <!-- <div class="x_title">
        <h2> <i class="fa fa-calendar"></i> Học kỳ - Năm học </h2>
        <div class="clearfix"></div>
      </div> -->
      <div class="x_content">
        <div class="row">
            <div class="col-12 col-md-12">
            <!-- Block error message -->
            @include('layout.block.message_flash')
            </div>
        </div>
        <div class="row">
          @if(isset($dsHocKyNamHoc))
            @foreach($dsHocKyNamHoc as $hocKyNamHoc)
              <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Điểm rèn luyện {{$hocKyNamHoc->tenhockynamhoc}}">
                <div class="row dash-box">
                  <a href="{{route('covanhoctap_bangdiemrenluyen_hockynamhoc', ['idhockynamhoc'=>$hocKyNamHoc->id])}}" class="a-waiting">
                    <div class="row img">
                      <img src="{{URL::asset('images/icons/checklist1.png')}}" alt="" style="width: 70%;">
                    </div>
                    <div class="row title">
                      {{trim(explode("-",$hocKyNamHoc->tenhockynamhoc)[0])}}
                      <br>
                      {{substr(trim($hocKyNamHoc->tenhockynamhoc), -12)}}
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
  <script type="text/javascript">
    $('.a-waiting').click(function(){
      loadereffectshow();
    });
  </script>
@endsection
