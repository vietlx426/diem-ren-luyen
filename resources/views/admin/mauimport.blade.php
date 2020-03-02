@extends('admin.layout.master')
@section('title')
  @parent | Import template
@endsection()
@section('css')
  <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
@endsection()
@section('content')


  <!-- Danh mục - Danh sách -->
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2>BIỂU MẪU IMPORT <small>import template</small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <table id="table-import-template" class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center"> # </th>
                <th> BIỂU MẪU </th>
                <th class="text-center"> TẢI </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center">1</td>
                <td>Mẫu import danh sách sinh viên</td>
                <td class="text-center"><a href="{{route('admin_import_template_download', ['id'=>1])}}" class="btn btn-success" title="Tải (Download)"><i class="fa fa-download"></i></a></td>
              </tr>
              <tr>
                <td class="text-center">2</td>
                <td>Mẫu import danh sách sinh viên tham gia hoạt động sự kiện</td>
                <td class="text-center"><a href="{{route('admin_import_template_download', ['id'=>2])}}" class="btn btn-success" title="Tải (Download)"><i class="fa fa-download"></i></a></td>
              </tr>
              <tr>
                <td class="text-center">3</td>
                <td>Mẫu import danh sách lớp</td>
                <td class="text-center"><a href="{{route('admin_import_template_download', ['id'=>3])}}" class="btn btn-success" title="Tải (Download)"><i class="fa fa-download"></i></a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection()

@section('javascript')
    @parent
    <!-- Datatables -->
    <!-- <script src="{{URL::asset('gentelella-master/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
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
    <script type="text/javascript">
      $('#table-import-template').DataTable();
    </script> -->
@endsection
  