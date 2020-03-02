@extends('admin.layout.master')
@section('title')
  @parent | Monitor list
@endsection

@section('css')
  @parent
  <!-- Datatables -->
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
      <div class="x_panel">
        <div class="x_title">
          <h2> <i class="fa fa-user-secret"></i> Danh sách ban cán sự  {{$hocKyNamHoc_HienChon?$hocKyNamHoc_HienChon->tenhockynamhoc:''}} </h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
          <div class="pull-right">
            <a href="{{ route('admin_bancansu_create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> <strong> THÊM MỚI </strong> </a>
            <a href="{{ route('admin_bancansu_import') }}" class="btn btn-warning"> <i class="fa fa-upload"></i> <strong> IMPORT </strong> </a>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            @include('layouts.gentelella-master.blocks.flash-messages')
            <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
              <thead>
                  <tr class="filters">
                      <th class="text-center">#</th>
                      <th class="text-center">MSSV</th>
                      <th>Họ tên</th>
                      <th>Nam/Nữ</th>
                      <th>Email</th>
                      <th>Lớp</th>
                      <th>Chức vụ</th>
                  </tr>
              </thead>
              <tbody id="tbodystudent">
                    @if(isset($DS_BanCanSu))
                      <?php $STT = 0; ?>
                      @foreach($DS_BanCanSu as $banCanSu)
                          <tr>
                              <th class="text-center-middle text-center">{{++$STT}}</th>
                              <td class="text-center-middle text-center">{{$banCanSu->mssv}}</td>
                              <td class="text-justify-middle">
                                  {{ $banCanSu->hochulot }} {{ $banCanSu->ten }}
                              </td>
                              <td class="text-justify-middle">
                                  {{ $banCanSu->gioitinh? 'Nam' : 'Nữ' }}
                              </td>
                              <td class="text-justify-middle">
                                  {{ $banCanSu->email_agu }}
                              </td>
                              <td class="text-justify-middle">
                                  {{ $banCanSu->tenlop }}
                              </td>
                              <td class="text-justify-middle">
                                  {{ $banCanSu->tenchucvubancansu }}
                              </td>
                          </tr>
                      @endforeach
                    @endif
              </tbody>
            </table>
          </div>
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
@endsection