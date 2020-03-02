@extends('admin.layout.master')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">

@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-list"></i> DANH SÁCH CÁN BỘ - GIẢNG VIÊN <small>STAFF LIST</small></h2>
        <div class="pull-right">
          <a href="{{route('admin_canbogiangvien_add')}}" class="btn btn-primary"> <strong> <i class="fa fa-plus"></i> THÊM </strong> </a>
        </div>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="row">
          <div class="col-12 col-md-12">
            @include('layout.block.message_flash')
          </div>
        </div>
        
        <table id="datatable-buttons" class="table table-striped " width="100%">
          <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Mã</th>
                <th>Họ tên</th>
                <th>Điện thoại</th>
                <th>Email</th>
                <th>Khoa/Phòng</th>
                <th>Quyền</th>
                <th></th>
            </tr>
          </thead>
          <tbody id="tbody_studentListResult">
              @if(isset($DS_CBGV))
                <?php $STT = 0; ?>
                @foreach($DS_CBGV as $CBGV)
                    <tr>
                        <th class="text-center-middle text-center">{{++$STT}}</th>
                        <td class="text-center-middle text-center">{{$CBGV->macanbogiangvien}}</td>
                        <td class="text-justify-middle">
                            {{ $CBGV->hochulot }} {{ $CBGV->ten }}
                        </td>
                        <td class="text-justify-middle">
                            {{ $CBGV->dienthoaicanhan }}
                        </td>
                        <td class="text-justify-middle">
                            {{ $CBGV->email }}
                        </td>
                        <td class="text-justify-middle">
                            {{ $CBGV->bomonto->khoa->tenkhoa }}
                        </td>
                        <td class="text-justify-middle">
                            <?php $dsQuyen = App\Http\Controllers\ServiceUserController::GetStringPermissionWithIdCBGV($CBGV->id); ?>
                            @foreach($dsQuyen as $quyen)
                                <span class="label label-success"> {{$quyen}} </span><br>
                            @endforeach
                        </td>
                        <td class="text-center-middle text-center">
                          <a href="{{route('admin_canbogiangvien_edit', ['id' => $CBGV->id])}}" class="btn btn-warning" title="Xem chi tiết & Sửa"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
              <tr>
                  <td colspan="7" class="text-center">KHÔNG CÓ DỮ LIỆU</td>
              </tr>
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
@endsection