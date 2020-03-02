@extends('truongdonvi.layout.master')
@section('title')
  @parent | Chuyên viên
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
                    <!-- <th>MÃ CBGV</th> -->
                    <th>HỌ VÀ TÊN</th>
                    <th>ĐIỆN THOẠI</th>
                    <th>EMAIL</th>
                    <th>LỚP</th>
                </tr>
            </thead>
            <tbody id="tbodystudent">
              @if(isset($dsChuyenVienQuanLyLop))
                <?php $STT = 0; ?>
                @foreach($dsChuyenVienQuanLyLop as $chuyenVienQuanLyLop)
                    <?php 
                        $dsLop = App\Http\Controllers\ChuyenVienQuanLyLopController::ChuyenVienQuanLyLop($chuyenVienQuanLyLop->cbgv_id);
                    ?>
                    <tr>
                        <th class="text-center">{{++$STT}}</th>
                        <!-- <td> {{ $chuyenVienQuanLyLop->cbgv->macanbogiangvien }} </td> -->
                        <td> {{ $chuyenVienQuanLyLop->cbgv->hochulot . ' ' . $chuyenVienQuanLyLop->cbgv->ten}} </td>
                        <td> {{ $chuyenVienQuanLyLop->cbgv->dienthoaicanhan }} </td>
                        <td> {{ $chuyenVienQuanLyLop->cbgv->email }} </td>
                        <td> 
                            @foreach($dsLop as $lop)
                                <span class="label label-success"> {{ $lop->lop->tenlop }} </span> &nbsp;
                            @endforeach
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