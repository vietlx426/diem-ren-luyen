@extends('admin.layout.master')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-graduation-cap"></i> HÌNH THẺ <small></small></h2>
        <!-- <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul> -->
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="row">
        
          <div class="row">
            <div class="col-12 col-md-12">
              <!-- Block error message -->
              @include('layout.block.message_flash')
            </div>
          </div>

          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <h4 class="text-center">KHOA</h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                  <ul class="list-group checked-list-box">
                      @if(isset($DanhSach_Khoa))
                          @foreach($DanhSach_Khoa as $Khoa)
                              <li class="list-group-item khoa" value="{{$Khoa->id}}"> {{$Khoa->tenkhoa}} </li>
                          @endforeach
                      @endif
                  </ul>
              </div>
          </div>

          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <h4 class="text-center">NGÀNH</h4>
              <div class="well" style="max-height: 150px;overflow: auto;">
                  <ul id="ul-nganh" class="list-group checked-list-box">
                      @if(isset($DanhSach_Nganh))
                          @foreach($DanhSach_Nganh as $Nganh)
                              <li class="list-group-item nganh" value="{{$Nganh->id}}"> {{$Nganh->tennganh}} ({{$Nganh->bacdaotao->tenbac}}) </li>
                          @endforeach
                      @endif
                  </ul>
              </div>
          </div>

          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <h4 class="text-center">LỚP</h4>
              <div class="well" style="max-height: 150px;overflow: auto;">
                  <ul id="ul-lop" class="list-group checked-list-box">
                      @if(isset($DanhSach_Lop))
                          @foreach($DanhSach_Lop as $Lop)
                              <li class="list-group-item lop" value="{{$Lop->id}}"> {{$Lop->tenlop}} </li>
                          @endforeach
                      @endif
                  </ul>
              </div>
          </div>
        </div>

        <div class="row text-center">
          <!-- <button class="btn btn-primary student_filter">
            <i class="fa fa-search"></i> <strong> TÌM KIẾM/LỌC </strong>
          </button> -->

          <button class="btn btn-success student_export">
            <i class="fa fa-download"></i> <strong> DOWNLOAD </strong>
          </button>
        </div>

      </div>
    </div>
  </div>
@endsection
@section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/ajax.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/admin_hinhthe_search_download.js') !!}"></script>

    <script type="text/javascript">
      var urlRouteGetNganhByKhoa = "{{route('admin_getnganhbykhoa')}}";
      var urlRouteGetLopByNganh = "{{route('admin_getlopbynganh')}}";
      var urlRouteGetSinhVienByKhoaNganhLop = "{{route('admin_getsinhvienbykhoanganhlop')}}";
      var urlRoute_admin_getdshinhthebyloplopexport = "{{route('admin_getdshinhthebyloplopexport')}}";
      // var urlRouteGetSinhVienCapNhat = "{{route('admin_getcapnhatthongtinsinhvien')}}";
      // var urlRouteSinhVienDestroy = "{{route('sinhviendestroy')}}";
    </script>
@endsection