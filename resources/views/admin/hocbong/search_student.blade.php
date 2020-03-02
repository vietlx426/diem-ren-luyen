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
          <a href="{{route('admin_sinhvien_import')}}" class="btn btn-success student_import">
            <strong><i class="fa fa-upload"></i> IMPORT </strong>
          </a>
        </div>
        <div class="clearfix"></div>
      </div>
      <form>
      <div class="x_content">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
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
         <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <h4 class="text-center">BỘ MÔN</h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                  <label class="control-label">BỘ MÔN</label>
              <select name="bomon" id="bomon" class="form-control ">
                <option >--- Bộ môn ---</option>
              </select>
              </div>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <h4 class="text-center">NGÀNH</h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                  <label class="control-label">Ngành</label>
              <select name="nganh" id="nganh" class="form-control">
                <option>--- Ngành ---</option>
              </select>
              </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <h4 class="text-center">Lớp</h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                  <label class="control-label">Lớp</label>
              <select name="lop" id="lop" class="form-control">
                <option>--- Lớp ----</option>
              </select>
              </div>
          </div>
          

        <div class="row text-center">
          <div class="col-xs-12 col sm-12 col-md-4 col-lg-4 col-xl-4 col-md-offset-4 col-lg-offset-4 col-xl-offset-4 form-group">
            <label for="inpmssv">MSSV</label>
            <input type="text" id="tensv" name="tensv" placeholder="" value="{{\Request::get('tensv')}}" class="form-control" >
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
              <th width="10%">MSSV</th>
              <th width="20%">Tên sinh viên</th>
              <th width="10%">Giới tính</th>
              <th width="10%">Lớp</th>
              <th width="22%">Học kỳ, năm học</th>
              <th width="10%">Điểm học tập</th>
              <th width="10%">Điểm rèn luyện</th>
              <th width="10%">Thao tác</th>
            </tr>
          </thead>
          <tbody id="tbody_studentListResult">
              @foreach($students as $data)
              <tr>
                <td></td>
                <td>{{$data->mssv}}</td>
                <td>{{$data->hochulot}} {{$data->ten}}</td>
                <td>{{$data->getGioitinh($data->gioitinh)['name']}}</td>
                <td>{{isset ($data->lop->tenlop) ? $data->lop->tenlop :  '[Chưa biết]'}}</td>
                <td>{{isset ($data->HocKyNamHoc->tenhockynamhoc) ? $data->HocKyNamHoc->tenhockynamhoc :  '[Chưa biết]'}}</td>
                <td>{{isset ($data->diem) ? $data->diem :  '[Chưa biết]'}}</td>
               
                <td></td>
                <td></td>
                <td>
                  
                  <a href="" style="display: inline-block;"><i style="font-size: 25px; color: orange; text-align: center;" class="fa fa-pencil-square-o"></i></a>
                  
                </td>
              </tr>


              @endforeach
              {{ $students->links() }}
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

    <script type="text/javascript">
    jQuery(document).ready(function ()
    {
            jQuery('select[name="khoa"]').on('change',function(){
               var khoaID = jQuery(this).val();
               if(khoaID)
               {
                  jQuery.ajax({
                     url : 'tim-kiem/getbomon/' +khoaID,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="bomon"]').empty();
                        jQuery.each(data, function(key,value){
                           $('select[name="bomon"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="bomon"]').empty();
               }
            });
    });
    jQuery(document).ready(function ()
    {
            jQuery('select[name="bomon"]').on('change',function(){
               var bomonID = jQuery(this).val();
               if(bomonID)
               {
                  jQuery.ajax({
                     url : 'tim-kiem/getnganh/' +bomonID,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="nganh"]').empty();
                        jQuery.each(data, function(key,value){
                           $('select[name="nganh"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="nganh"]').empty();
               }
            });
    });
    jQuery(document).ready(function ()
    {
            jQuery('select[name="nganh"]').on('change',function(){
               var nganhID = jQuery(this).val();
               if(nganhID)
               {
                  jQuery.ajax({
                     url : 'tim-kiem/getlop/' +nganhID,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="lop"]').empty();
                        jQuery.each(data, function(key,value){
                           $('select[name="lop"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="lop"]').empty();
               }
            });
    });
    </script>


@endsection