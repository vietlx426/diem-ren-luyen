@extends('giaovukhoa.layout.master')

@section('css')
    <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2> <i class="fa fa-edit"></i> BẢNG ĐIỂM RÈN LUYỆN {{isset($lop)?$lop->tenlop:''}} <small>{{isset($hocKyNamHoc)?$hocKyNamHoc->tenhockynamhoc:''}}</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row container">
                    @include('layouts.gentelella-master.blocks.flash-messages')
                </div>
                @if(isset($dsSinhVien_Diem_XepLoai) && count($dsSinhVien_Diem_XepLoai) > 0)
                    <div class="row">
                        <table id="datatable-buttons" class="table table-stripped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-center">MSSV</th>
                                    <th>HỌ TÊN</th>
                                    <th class="text-right">ĐIỂM RÈN LUYỆN</th>
                                    <th>XẾP LOẠI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $STT = 0; ?>
                                @foreach($dsSinhVien_Diem_XepLoai as $sinhVien_Diem_XepLoai)
                                    <tr>
                                        <td class="text-center">{{++$STT}}</td>
                                        <td class="text-center">{{$sinhVien_Diem_XepLoai->mssv}}</td>
                                        <td>{{$sinhVien_Diem_XepLoai->hochulot . " " . $sinhVien_Diem_XepLoai->ten}}</td>
                                        <td class="text-right">{{ number_format($sinhVien_Diem_XepLoai->diemrenluyen, 2, '.', ',')}}</td>
                                        <td>{{$sinhVien_Diem_XepLoai->tenxeploai}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            <a href="{{route('giaovukhoa_bangdiemdiemrenluyen_hockynamhoc_export', ['idhockynamhoc'=>(isset($idHocKyNamHoc)? $idHocKyNamHoc : ''), 'idlop'=>(isset($lop)?$lop->id:'')])}}" class="btn btn-success btn_export_bangdiem_bcs btn-download">
                                <i class="fa fa-download"> </i>
                                <strong> TẢI BẢNG ĐIỂM </strong>
                            </a>
                        </div>
                    </div>
                @endif
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
    <script src="{{URL::asset('js/export_loading.js')}}"></script>
@endsection