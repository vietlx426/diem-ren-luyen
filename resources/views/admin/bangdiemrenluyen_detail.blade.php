@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <style>
        .tr_bgr_1{
        background-color: #c7c7c7;
        }

        .tr_bgr_2{
        background-color: #aeaeae;
        }
    </style>
@endsection

@section('content')
    <div class="text-center">
        <h3> ĐIỂM RÈN LUYỆN </h3>
        <h4>
            {{isset($hocKyNamHoc)?$hocKyNamHoc->tenhockynamhoc:''}}
        </h4>
        <h4>
            {{isset($sinhVien)? $sinhVien->mssv . " - " . $sinhVien->hochulot . " " . $sinhVien->ten . ($sinhVien->lop? " - ". $sinhVien->lop->tenlop : '') :''}}
        </h4>
    </div>
    <div class="row">
        <div class="x_panel">
            <div class="x_content">
                @include('layouts.gentelella-master.blocks.flash-messages')
                @if(isset($dsTieuChi_Level_0) && isset($boTieuChi))
                    <?php $STT = '0' ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="75%">Nội dung</th>
                                <th width="10%" class="text-right-middle">Hạn mức</th>
                                <th width="10%" class="text-right-middle">Điểm</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($dsTieuChi_Level_0 as $tieuChi)
                                <tr>
                                    <th class="text-justify-middle">{{$tieuChi->chimuctieuchi}}</th>
                                    @if($tieuChi->idloaidiem == 1)
                                        <th class="text-justify-middle">
                                            {!! $tieuChi->tentieuchi !!}
                                        </th>
                                        <th class="text-right-middle col-total-council-faculty">{{$tieuChi->diemtoida}}</th>
                                        <th class="text-right-middle col-total-council-university">{{number_format((float)$tieuChi->diem, 2, '.', '')}}</th>
                                    @else
                                        <td class="text-justify-middle">
                                            {!! $tieuChi->tentieuchi !!}
                                        </td>
                                        <td class="text-right-middle col-total-council-faculty">{{$tieuChi->diemtoida}}</td>
                                        <th class="text-right-middle col-total-council-university">{{number_format((float)$tieuChi->diem, 2, '.', '')}}</th>
                                    @endif
                                    
                                </tr>
                                {{App\Http\Controllers\TieuChiController::Admin_TieuChiCon_DiemSinhVien($tieuChi->id, $boTieuChi, $idHocKyNamHoc, $idSinhVien)}}
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-center-middle">
                                    @if(isset($countTieuChi_Level_0))
                                        <strong>Tổng cộng {{$countTieuChi_Level_0}} tiêu chí</strong>
                                    @endif
                                </td>
                                <td class="text-right-middle col-total-council-faculty">
                                        <strong>{{$totalMaxMarks?$totalMaxMarks:0}}</strong>
                                </td>
                                <td class="text-right-middle col-total-council-university">
                                    <strong> {{number_format((float)$totalMarks?$totalMarks:0, 2, '.','')}}</strong><br>
                                    <strong>XL: {{App\Http\Controllers\XepLoaiDiemRenLuyenController::getXepLoai($totalMarks?$totalMarks:0)->tenxeploai}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=4 class="text-center">
                                    <a href="{{route('admin_bangdiemrenluyen_sinhvien_hockynamhoc_export', ['idhockynamhoc'=>$hocKyNamHoc->id, 'idsinhvien'=>$idSinhVien])}}" class="btn btn-success btn-download"><i class="fa fa-download"></i><strong> TẢI BẢNG ĐIỂM </strong></a>
                                </td>
                            </tr>
                        </tfoot>
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
    <script src="{{URL::asset('js/export_loading.js')}}"></script>
@endsection