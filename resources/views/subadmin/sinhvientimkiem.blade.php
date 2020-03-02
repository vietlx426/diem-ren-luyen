@extends('subadmin.layout.master')

@section('title')
  @parent | Student
@endsection

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">

@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-graduation-cap"></i> SINH VIÊN <small>STUDENTS</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-xs-12">
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

          <div class="col-lg-4 col-md-6 col-xs-12">
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

          <div class="col-lg-4 col-md-6 col-xs-12">
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
          <button class="btn btn-primary subadmin_student_filter">
            <i class="fa fa-search"></i> <strong> TÌM KIẾM/LỌC </strong>
          </button>

          <button class="btn btn-warning student_export">
            <i class="fa fa-file-excel-o"></i> <strong> XUẤT FILE </strong>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="div-studentListResult" class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-list"></i> DANH SÁCH <small>LIST</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <table id="table-studentListResult" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr class="filters">
              <th width="10%">MSSV</th>
              <th width="23%">Họ và tên</th>
              <th width="10%">Lớp</th>
              <th width="20%">Ngành</th>
              <th width="22%">Khoa</th>
              <th width="15%"></th>
            </tr>
          </thead>
          <tbody id="tbody_studentListResult">
              
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
    @parent

    <!-- Datatables -->
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/pdfmake/build/vfs_fonts.js')}}"></script>
    
    <script type="text/javascript" src="{!! URL::asset('js/ajax.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/admin_student_filter.js') !!}"></script>

    <script type="text/javascript">
      var urlRouteGetNganhByKhoa = "{{route('admin_getnganhbykhoa')}}";
      var urlRouteGetLopByNganh = "{{route('admin_getlopbynganh')}}";
      var urlRouteGetSinhVienByKhoaNganhLop = "{{route('admin_getsinhvienbykhoanganhlop')}}";
      var urlRouteGetSinhVienByKhoaNganhLopExport = "{{route('admin_getsinhvienbykhoanganhlopexport')}}";
      var urlRoute_subadmin_sinhvien_show = "{{route('subadmin_sinhvien_show')}}";
    </script>
@endsection