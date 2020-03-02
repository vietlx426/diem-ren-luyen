@extends('admin.layout.master')
@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <a href="{{route('admin_hoatdongsukien')}}" class="btn btn-success" title="Quay về danh sách hoạt động - sự kiện"> <i class="fa fa-undo"></i> </a> DANH SÁCH SINH VIÊN THAM GIA HOẠT ĐỘNG - SỰ KIỆN <small>ACTIVITIES - EVENTS LIST</small>
        </h2>
        <div class="pull-right">
            @if(isset($HoatDongSuKien))
                <a href="{{route('admin_hdsk_importsv',['idhoatdongsukien'=>$HoatDongSuKien->id])}}" class="btn btn-success"><strong> <i class="fa fa-upload"></i> IMPORT </strong></a>
            @endif
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @include('layouts.gentelella-master.blocks.flash-messages')
        <div class="row">
            @if(isset($HoatDongSuKien))
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <strong><i class="fa fa-info-circle"></i> {{($HoatDongSuKien->tenhoatdongsukien)}} </strong>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <strong> <i class="fa fa-calendar"></i> {{ date('h:i A d/m/Y', strtotime($HoatDongSuKien->thoigianbatdau))}} </strong>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <strong> <i class="fa fa-map-marker"></i> {{($HoatDongSuKien->diadiem)}} </strong>
                </div>
                <hr>
            @endif
        </div>

        @if(isset($DS_DKHoatDongSuKien))
            <?php $STT = '0' ?>
            <table id="datatable-buttons" class="table table-striped table-bordered table-hover" >
                <thead>
                    <tr>
                        <th>#</th>
                        <th>MSSV</th>
                        <th>Họ tên</th>
                        <th>Lớp</th>
                        <th>Khoa</th>
                        <!-- <th>Hoạt đông sự kiện</th> -->
                        <!-- <th>T/G kết thúc</th> -->
                        <!-- <th>Thời gian tham gia</th> -->
                        <th></th>
                    </tr>
                </thead> 
                <tbody>
                    @foreach($DS_DKHoatDongSuKien as $DKHDSK)
                        <tr>
                            <th>{{++$STT}}</th>
                            <td>{{$DKHDSK->mssv}}</td>
                            <td>{{$DKHDSK->hochulot}} {{$DKHDSK->ten}}</td>
                            <td>{{$DKHDSK->sinhvien->lop->tenlop}}</td>
                            <td>{{$DKHDSK->sinhvien->lop->nganh->bomon->khoa->tenkhoa}}</td>
                            <!-- <td>{{$DKHDSK->tenhoatdongsukien}}</td>
                            <td>{{date('d/m/Y',strtotime($DKHDSK->thoigianthamgia))}}</td> -->
                            
                            <td class="text-center">
                                <button type="button" class="btn btn-danger remove_dkhdsk" href="{{route('dkhdsk_destroy',['id'=>$DKHDSK->id])}}" Ten="{{$DKHDSK->hochulot}} {{$DKHDSK->ten}}" title="Xóa"><i class="fa fa-remove"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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