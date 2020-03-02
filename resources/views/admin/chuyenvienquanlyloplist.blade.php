@extends('admin.layout.master')
@section('title')
  @parent | Expert
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
        <h2> <i class="fa fa-sun-o"></i> DANH SÁCH CHUYÊN VIÊN PHỤ TRÁCH QUẢN LÝ ĐIỂM RÈN LUYỆN CÁC LỚP </h2>
        <div class="pull-right">
          <a href=" {{route('admin_expers_create')}} " class="btn btn-primary"><strong><i class="fa fa-plus"></i> THÊM </strong></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-12 col-md-12">
            <!-- Block error message -->
            @include('layout.block.message_flash')
          </div>
        </div>
        <div class="row">
          <table  class="table table-striped table-bordered tableThoiGianDanhGia">
            <thead>
                <tr class="filters">
                    <th class="text-center">#</th>
                    <th>MÃ CBGV</th>
                    <th>HỌ VÀ TÊN</th>
                    <th>ĐIỆN THOẠI</th>
                    <th>EMAIL</th>
                    <th class="text-center">LỚP</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbodystudent">
              @if(isset($dsChuyenVienQuanLyLop))
                <?php $STT = 0; ?>
                @foreach($dsChuyenVienQuanLyLop as $chuyenVienQuanLyLop)
                    <?php 
                      $dsLop = App\Http\Controllers\ChuyenVienQuanLyLopController::ChuyenVienQuanLyLop($chuyenVienQuanLyLop->cbgv_id);
                      $totalLop = count($dsLop)>0?count($dsLop):1;
                      $countRow = 1;
                     ?>
                    @foreach($dsLop as $lop)
                    <tr>
                      @if($countRow == 1)
                        <th rowspan="{{$totalLop}}" class="text-center">{{++$STT}}</th>
                        <td rowspan="{{$totalLop}}"> {{ $chuyenVienQuanLyLop->cbgv->macanbogiangvien }} </td>
                        <td rowspan="{{$totalLop}}"> {{ $chuyenVienQuanLyLop->cbgv->hochulot . ' ' . $chuyenVienQuanLyLop->cbgv->ten}} </td>
                        <td rowspan="{{$totalLop}}"> {{ $chuyenVienQuanLyLop->cbgv->dienthoaicanhan }} </td>
                        <td rowspan="{{$totalLop}}"> {{ $chuyenVienQuanLyLop->cbgv->email }} </td>
                      @endif
                          <td class="text-center"> {{ $lop->lop->tenlop }} </td>
                      @if($countRow++ == 1)
                        <td rowspan="{{$totalLop}}" class="text-center">
                          <a href="{{route('admin_expers_edit', ['id'=>$chuyenVienQuanLyLop->cbgv_id])}}" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                          <a href="{{route('admin_expers_destroy', ['id'=>$chuyenVienQuanLyLop->cbgv_id])}}" class="btn btn-danger btn-remove" title="Remove"><i class="fa fa-trash"></i></a>
                        </td>
                      @endif
                    </tr>
                    @endforeach
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

    <script>
      $('.btn-remove').click(function(e){
        if(confirm("Bạn thực sự muốn xóa?") == false)
        {
          e.preventDefault();
          e.stopImmediatePropagation();
        }
      });
    </script>
@endsection