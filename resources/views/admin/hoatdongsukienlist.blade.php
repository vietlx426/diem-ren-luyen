@extends('admin.layout.master')
@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-futbol-o"></i> DANH SÁCH HOẠT ĐỘNG - SỰ KIỆN <small>ACTIVITIES - EVENTS LIST</small></h2>
        <div class="pull-right">
          <a href="{{route('admin_hoatdongsukien_create')}}" class="btn btn-primary" title="Thêm mới hoạt động sự kiện">
              <i class="fa fa-plus"></i> <strong> THÊM MỚI </strong>
          </a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('layouts.gentelella-master.blocks.flash-messages')

        @if(isset($DS_HoatDongSuKien))
            @if(count($DS_HoatDongSuKien)>0)
                <?php $STT = '0' ?>
                <table id="tbl-hoatdong-sukien" class="table table-striped table-bordered table-hover" >
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Hoạt động sự kiện</th>
                            <th>Tiêu chí</th>
                            <th>Điểm cộng/trừ</th>
                            <th>T/g đăng ký</th>
                            <th>T/g bắt đầu</th>
                            <th>Địa điểm</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($DS_HoatDongSuKien as $HDSK)
                            <tr>
                                <th class="text-center">{{++$STT}}</th>
                                <td>{{$HDSK->tenhoatdongsukien}}</td>
                                <td>
                                  {{$HDSK->hoatdongsukientieuchi? $HDSK->hoatdongsukientieuchi[0]->tieuchi? $HDSK->hoatdongsukientieuchi[0]->tieuchi->chimuctieuchi : '' : ''}}
                                </td>
                                <td class="text-center">
                                  {{count($HDSK->hoatdongsukientieuchi)? $HDSK->hoatdongsukientieuchi[0]->diemcong . "/". $HDSK->hoatdongsukientieuchi[0]->diemtru : ''}}
                                </td>
                                <td>{{$HDSK->thoigianbatdaudangky ? date('d/m/Y',strtotime($HDSK->thoigianbatdaudangky)) : ''}} <i class="fa fa-long-arrow-right"></i> <br> {{$HDSK->thoigianketthucdangky ? date('d/m/Y',strtotime($HDSK->thoigianketthucdangky)) : ''}}</td>
                                <td>{{$HDSK->thoigianbatdau ? date('h:i a d/m/Y',strtotime($HDSK->thoigianbatdau)) : ''}} <i class="fa fa-long-arrow-right"></i> <br> {{$HDSK->thoigianketthuc ? date('h:i a d/m/Y',strtotime($HDSK->thoigianketthuc)) : ''}}</td>
                                <td>{{$HDSK->diadiem}}</td>
                                <td>
                                  <?php
                                    $tatCaDaCongDiem = App\Http\Controllers\DangKyHoatDongSuKienController::isAllAddedMark($HDSK->id);
                                  ?>
                                  @if($tatCaDaCongDiem)
                                    <span class="label label-success"> Đã cộng điểm </span>
                                  @else
                                    <a href="{{route('admin_hoatdongsukien_congdiemsinhvien', ['idhoatdongsukien'=>$HDSK->id])}}" class="btn btn-success" title="Thực hiện cộng điểm"><i class="fa fa-cogs"></i> <i class="fa fa-plus"></i> </a>
                                  @endif
                                </td>
                                <td class="text-center">
                                  <a href="{{route('admin_hoatdongsukien_danhsachsinhvien', ['idhoatdongsukien'=>$HDSK->id])}}" class="btn btn-info" title="Danh sách tham dự"> <i class="fa fa-info-circle"></i> </a>
                                  <a href="{{route('admin_hoatdongsukien_edit', ['id'=>$HDSK->id])}}" class="btn btn-warning"> <i class="fa fa-pencil-square-o"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                {{'Chưa có dữ liệu!'}}
            @endif
        @else
            {{'Không có thông tin!'}}
        @endif
      </div>
    </div>
  </div>
@endsection
@section('javascript')
    @parent 
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
    
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
    <script>
      $('#tbl-hoatdong-sukien').DataTable();
    </script>
@endsection