@extends('sinhvien.layout.master')
@section('title')
 @parent | Activity - Event
@endsection
@section('css')
    <!-- iCheck -->
    <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <!-- Switchery -->
    <link href="{{URL::asset('gentelella-master/vendors/switchery/dist/switchery.min.css')}}" rel="stylesheet">
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
        <h2> <a href="{{route('sinhvien_hoatdongsukien')}}" class="btn btn-success" title="Trở về danh sách hoạt động - sự kiện"> <i class="fa fa-undo"></i> </a> Thông tin hoạt động - sự kiện</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          @if(isset($hoatDongSuKien))
            <form action="{{route('post_sinhvien_dangkyhoatdongsukien_store')}}" method="POST">
              {{csrf_field()}}
              <input type="text" hidden="true" name="idhoatdongsukien" value="{{$hoatDongSuKien->id}}">
              <?php $STT = '0' ?>
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
              <br>
              <hr>

              @if($hoatDongSuKien->handangky == 1)
                <div class="row text-center">
                  <input id="dangky" name="dangky" type="checkbox" class="flat" {{$hoatDongSuKien->dangky == 0 ? '' : 'checked="true"'}}>
                  <label for="dangky"> <strong> ĐĂNG KÝ THAM GIA </strong> </label>
                </div>
                <br> <hr>
                <div class="row text-center">
                    <button class="btn btn-primary"> <strong> <i class="fa fa-save"></i>  LƯU </strong> </button>
                </div>
              @endif
            </form>
          @else
              {{'Không có thông tin!'}}
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
    @parent
    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Switchery -->
    <script src="{{URL::asset('gentelella-master/vendors/switchery/dist/switchery.min.js')}}"></script>
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
      $('#tbl_hoatdongsukien_hienhanh').dataTable();
    </script>
@endsection