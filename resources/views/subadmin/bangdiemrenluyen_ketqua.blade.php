@extends('subadmin.layout.master')
@section('title')
  @parent | Bảng điểm rèn luyện
@endsection

@section('css')
  <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">

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
        <h2> <i class="fa fa-list-alt"></i> KẾT QUẢ ĐIỂM RÈN LUYỆN LỚP {{isset($lop)?$lop->tenlop:''}} </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <table id="datatable-buttons"  class="table table-striped table-bordered">
            <thead>
              <tr>
                @if(isset($dsHocKyNamHoc))
                  <th class="text-center" rowspan="2">#</th>
                  <th class="text-center" rowspan="2">MSSV</th>
                  <th rowspan="2">Họ tên</th>
                  @foreach($dsHocKyNamHoc as $hocKyNamHoc)
                    <th colspan="6" class="text-center">{{$hocKyNamHoc->tenhockynamhoc}}</th>
                  @endforeach
                @endif
              </tr>
              <tr>
                @if(isset($dsHocKyNamHoc))
                  @foreach($dsHocKyNamHoc as $hocKyNamHoc)
                    <th class="text-right" title="Cá nhân tự đánh giá">CN</th>
                    <th class="text-right" title="Tập thể đánh giá">TT</th>
                    <th class="text-right" title="Cố vấn học tập đánh giá">CVHT</th>
                    <th class="text-right" title="Hội đồng khoa đánh giá">HĐK</th>
                    <th class="text-right" title="Hội đồng trường đánh giá">HĐT</th>
                    <th title="Xếp loại">XL</th>
                  @endforeach
                @endif
              </tr>
            </thead>
            <tbody>
              @if(isset($dsSinhVien))
                <?php $stt = 0; ?>
                @foreach($dsSinhVien as $sinhVien)
                <tr>
                  <td class="text-center">{{++$stt}}</td>
                  <td class="text-center">{{$sinhVien->mssv}}</td>
                  <td>{{$sinhVien->hochulot . ' ' . $sinhVien->ten}}</td>
                  @if(isset($dsHocKyNamHoc))
                    @foreach($dsHocKyNamHoc as $hocKyNamHoc)
                      <?php 
                        $diemTong = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::GetTongDiemTheoHocKy($sinhVien->id, $hocKyNamHoc->id);
                       ?>
                      @if(isset($diemTong) && count($diemTong) > 0)
                        <?php 
                          $xepLoai = App\Http\Controllers\XepLoaiDiemRenLuyenController::getXepLoai($diemTong['tongDiem_HoiDongTruongDanhGia']);
                         ?>
                          <td class="text-right col-total-student">{{$diemTong['tongDiem_SinhVienDanhGia']}}</td>
                          <td class="text-right col-total-monitor">{{$diemTong['tongDiem_BanCanSuDanhGia']}}</td>
                          <td class="text-right col-total-adviser">{{$diemTong['tongDiem_CoVanHocTapDanhGia']}}</td>
                          <td class="text-right col-total-council-faculty">{{$diemTong['tongDiem_HoiDongKhoaDanhGia']}}</td>
                          <td class="text-right col-total-council-university">{{$diemTong['tongDiem_HoiDongTruongDanhGia']}}</td>
                          <td class="col-total-council-university">{{$xepLoai->tenxeploai}}</td>
                      @else
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                      @endif
                    @endforeach
                  @endif
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