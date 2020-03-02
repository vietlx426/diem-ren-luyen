@extends('admin.layout.master')

@section('title')
  @parent | Search student
@endsection

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">

@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-graduation-cap"></i> HỌC BỔNG <small>SCHOLARSHIP</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="pull-right">
          <a href="{{route('admin.create.scholar.form')}}" class="btn btn-primary">
            <strong><i class="fa fa-plus"></i> THÊM </strong>
          </a>
          <a href="{{route('admin_hocbong_import')}}" class="btn btn-success student_import">
            <strong><i class="fa fa-upload"></i> IMPORT </strong>
          </a>
        </div>
        <div class="clearfix"></div>
      </div>
      
      
      <form>
        
      <div class="x_content">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <h4 class="text-center">KHOA</h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                  <label class="control-label">Khoa</label>
              <select name="khoa" id="khoa" class="form-control">
                <option value="">--- Tất cả ---</option>
                
                  
                   @foreach($ds_khoa as $khoa)
                      <option value="{{$khoa->id}}" {{\Request::get('khoa')==$khoa->id ? "selected='selected'" : ""}}>{{$khoa->tenkhoa}}</option>
                    @endforeach
              </select>
              </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <h4 class="text-center">HỌC KỲ, NĂM HỌC</h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                  <label class="control-label">Học kỳ, năm học</label>
              <select name="hknh" id="hknh" class="form-control">
                <option value="">--- Tất cả ---</option>
                
                  
                   @foreach($ds_hknh as $hknh)
                      <option value="{{$hknh->id}}" {{\Request::get('hknh')==$hknh->id ? "selected='selected'" : ""}}>{{$hknh->tenhockynamhoc}}</option>
                    @endforeach
              </select>
              </div>
          </div>

          

        <div class="row text-center">
          <div class="col-xs-12 col sm-12 col-md-4 col-lg-4 col-xl-4 col-md-offset-4 col-lg-offset-4 col-xl-offset-4 form-group">
            <label for="inpmssv">Mã học bổng hoặc Tên học bổng</label>
            <input type="text" id="inpmssv" name="tenhb" placeholder="Tên học bổng" value="{{\Request::get('tenhb')}}" class="form-control" >
          </div>
        </div>


        <div class="row text-center">
          <button class="btn btn-primary student_filter">
            <i class="fa fa-search"></i> <strong> TÌM KIẾM/LỌC </strong>
          </button>

          
        </div>

      </div>
    </div>
    </form>
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
        <table id="table-studentListResult" class="table table-striped" width="100%">
          <thead>
            <tr class="filters">
              <th width="5%">STT</th>
              <th width="10%">Mã học bổng</th>
              <th width="20%">Tên học bổng</th>
              <th width="10%">Đơn vị tài trợ</th>
              <th width="10%">Khoa</th>
              <th width="22%">Học kỳ, năm học</th>
              <th width="10%">Giá trị học bổng</th>
              <th width="10%">Số lượng</th>
              <th width="10%">Thao tác</th>
            </tr>
          </thead>
          <tbody id="tbody_studentListResult">
            @if(isset($scholar))
            <?php $STT = 0; ?>
            @foreach($scholar as $data)
              <tr>
                <td>{{++$STT}}</td>
                <td>{{$data->mahb}}</td>
                <td>{{$data->tenhb}}</td>
                <td>{{$data->tendvtt}}</td>
                <td>{{isset ($data->Khoa->tenkhoa) ? $data->Khoa->tenkhoa :  '[N\A]'}}</td>
                <td>{{isset ($data->HocKyNamHoc->tenhockynamhoc) ? $data->HocKyNamHoc->tenhockynamhoc :  '[N\A]'}}</td>
                <td>{{number_format($data->gthb,0,',','.')}}</td>
                <td>{{$data->soluong}}</td>
                <td>
                  
                  <a href="{{route('admin.get.edit.scholar',$data->id)}}"><i style="font-size: 25px; color: orange" class="fa fa-pencil-square-o"></i></a>
                  <a href="{{route('admin.action.list.scholar',['delete',$data->id])}}"><i style="font-size: 25px; color: red" class="fa fa-trash"></i></a>
                </td>
              </tr>
              @endforeach
              @endif
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
      var urlRouteGetSinhVienCapNhat = "{{route('admin_getcapnhatthongtinsinhvien')}}";
      var urlRouteSinhVienDestroy = "{{route('sinhviendestroy')}}";
      var urlRouteBangDiemRenLuyenChiTiet = "{{route('admin_bangdiemrenluyen_sinhvien_hockynamhoc')}}";
      var idHocKyNamHocHienHanh = "{{ isset($idHocKyNamHocHienHanh)?$idHocKyNamHocHienHanh:'' }}";
    </script>
@endsection