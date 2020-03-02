@extends('covanhoctap.layout.master')
@section('title')
 @parent | Activity - Event
@endsection
@section('css')
    <!-- Datatables -->
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

@endsection
@section('content')
  @if(isset($hoatDongSuKien))
    <div class="row">
      <div class="x_panel">
        <div class="x_title">
          <h2> <i class="fa fa-info-circle"></i> Thông tin hoạt động - sự kiện</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            <div class="col-md-6">
              Tên hoạt động sự kiện: <strong>{{$hoatDongSuKien->tenhoatdongsukien}}</strong>
            </div>
            <div class="col-md-6">
              Loại hoạt động sự kiện: <strong>{{$hoatDongSuKien->tenloaihoatdongsukien}}</strong>
            </div>
            <div class="col-md-6">
              Thời gian bắt đầu: <strong>{{$hoatDongSuKien->thoigianbatdau ? date('h:i a d/m/Y', strtotime($hoatDongSuKien->thoigianbatdau)) : ''}}</strong>
            </div>
            <div class="col-md-6">
              Thời gian kết thúc: <strong>{{$hoatDongSuKien->thoigianketthuc ? date('h:i a d/m/Y', strtotime($hoatDongSuKien->thoigianketthuc)) : ''}}</strong>
            </div>
            <div class="col-md-6">
              Thời gian bắt đầu đăng ký: <strong>{{$hoatDongSuKien->thoigianbatdaudangky ? date('d/m/Y', strtotime($hoatDongSuKien->thoigianbatdaudangky)) : ''}}</strong>
            </div>
            <div class="col-md-6">
              Thời gian kết thúc đăng ký: <strong>{{$hoatDongSuKien->thoigianketthucdangky ? date('d/m/Y', strtotime($hoatDongSuKien->thoigianketthucdangky)) : ''}}</strong>
            </div>
            <div class="col-md-6">
              Địa điểm: <strong>{{$hoatDongSuKien->diadiem}}</strong>
            </div>
            <div class="col-md-6">
              Ghi chú: <strong>{{$hoatDongSuKien->ghichu}}</strong>
            </div>
          </div>
          @if($hoatDongSuKien->chimuc)
            <hr>
            <div class="row">
              <div class="col-md-12">
                Cộng điểm cho tiêu chí điểm rèn luyện:
              </div>
            </div>
            <div class="row">
              
              <div class="col-md-6">
                Tiêu chí: <strong>{{$hoatDongSuKien->chimuc}} {{$hoatDongSuKien->tentieuchi}}</strong>
              </div>
              <div class="col-md-3">
                Điểm cộng: <strong>{{$hoatDongSuKien->diemcong}}</strong>
              </div>
              <div class="col-md-3">
                Điểm trừ: <strong>{{$hoatDongSuKien->diemtru}}</strong>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="row">
      <div class="x_panel">
        <div class="x_title">
          <h2> <i class="fa fa-info-circle"></i> Danh sách sinh viên đăng ký -  tham dự</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table id="tbl_hoatdongsukien_sinhviendangkythamgia" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">MSSV</th>
                <th>Họ tên</th>
                <th class="text-center">Đăng ký</th>
                <th class="text-center">Tham dự</th>
              </tr>
            </thead>
            <tbody>
              <?php $STT = 0; ?>
              @foreach($dsSinhVienDangKyThamDu as $sinhVienDangKyThamDu)
                <tr>
                  <td class="text-center">{{++$STT}}</td>
                  <td class="text-center">{{$sinhVienDangKyThamDu->mssv}}</td>
                  <td>{{$sinhVienDangKyThamDu->hochulot . " ". $sinhVienDangKyThamDu->ten}}</td>
                  <td class="text-center">
                    @if($sinhVienDangKyThamDu->dangky)
                      <span class="label label-success"><i class="fa fa-check"></i></span>
                    @endif
                  <td class="text-center">
                    @if($sinhVienDangKyThamDu->thamdu)
                      <span class="label label-success"><i class="fa fa-check"></i></span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  @else
    {{'Không có thông tin!'}}
  @endif
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

    <script type="text/javascript">
      $('#tbl_hoatdongsukien_sinhviendangkythamgia').dataTable();
    </script>
@endsection