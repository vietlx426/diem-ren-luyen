@extends('layouts.print_export')

@section('container')
    <div class="row">
        <div class="x_panel">
            <div class="x_content">
                @if(isset($dsTieuChi_Level_0) && isset($boTieuChi))
                    <table style="width:100%;">
                        <tr>
                            <td class="text-center">UBND TỈNH AN GIANG</td>
                            <th class="text-center"><strong> <b> CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM </b></strong></th>
                        </tr>
                        <tr>
                            <th class="text-center"><strong>TRƯỜNG ĐẠI HỌC AN GIANG</strong></th>
                            <th class="text-center"><strong>Độc lập - Tự do - Hạnh phúc</strong></th>
                        </tr>
                        <tr>
                            <td class="text-center">---------------------</td>
                            <td class="text-center">----------------------------------------</td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-right"><i>An Giang, ngày ......... tháng ......... năm ............</i></td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center">
                                <strong><br>KẾT QUẢ RÈN LUYỆN</strong>
                                <br>
                                {{isset($hocKyNamHoc)?$hocKyNamHoc->tenhockynamhoc:''}}
                                <br>
                            </th>
                        </tr>
                    </table>
                    <br>
                    @if(isset($sinhVien))
                        <table style="width:100%;">
                            <tr>
                                <td>Họ và tên: {{$sinhVien->hochulot . " " . $sinhVien->ten}}</td>
                                <td>MSSV: {{$sinhVien->mssv}}</td>
                            </tr>
                            <tr>
                                <td>Lớp: {{$sinhVien->lop->tenlop}}</td>
                                <td>Khoa: {{$sinhVien->lop->nganh->bomon->khoa->tenkhoa}}</td>
                            </tr>
                        </table>
                        <br>
                    @endif
                    <?php $STT = '0' ?>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th width="65%" class="text">Nội dung</th>
                                <th width="15%" class="text text-right">Hạn mức</th>
                                <th width="10%" class="text text-right">Điểm</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($dsTieuChi_Level_0 as $tieuChi)
                                <tr>
                                    <th class="text text-justify">{{$tieuChi->chimuctieuchi}}</th>
                                    @if($tieuChi->idloaidiem == 1)
                                        <th class="text text-justify">
                                            {!! $tieuChi->tentieuchi !!}
                                        </th>
                                        <th class="text text-right col-total-council-faculty">{{$tieuChi->diemtoida}}</th>
                                        <th class="text text-right col-total-council-university">{{number_format((float)$tieuChi->diem, 2, '.', '')}}</th>
                                    @else
                                        <td class="text text-justify">
                                            {!! $tieuChi->tentieuchi !!}
                                        </td>
                                        <td class="text text-right col-total-council-faculty">{{$tieuChi->diemtoida}}</td>
                                        <th class="text text-right col-total-council-university">{{number_format((float)$tieuChi->diem, 2, '.', '')}}</th>
                                    @endif
                                    
                                </tr>
                                {{App\Http\Controllers\TieuChiController::TieuChiCon_DiemSinhVien_PrintExport($tieuChi->id, $boTieuChi, $idHocKyNamHoc, $idSinhVien)}}
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text text-center">
                                    @if(isset($countTieuChi_Level_0))
                                        <strong>Tổng cộng {{$countTieuChi_Level_0}} tiêu chí</strong>
                                    @endif
                                </th>
                                <th class="text text-right col-total-council-faculty">
                                        <strong>{{$totalMaxMarks?$totalMaxMarks:0}}</strong>
                                </th>
                                <th class="text text-right col-total-council-university">
                                    <strong>{{number_format((float)$totalMarks?$totalMarks:0, 2, '.','')}}</strong><br>
                                </th>
                            </tr>
                        </tfoot>
                    </table>

                    <table style="width:100%;">
                        <tr>
                            <th class="text-center">Điểm: {{number_format((float)$totalMarks?$totalMarks:0, 2, '.','')}}</th>
                            <th class="text-center">Xếp loại: {{App\Http\Controllers\XepLoaiDiemRenLuyenController::getXepLoai($totalMarks?$totalMarks:0)->tenxeploai}}</th>
                        </tr>
                    </table>
                @else
                    {{'Không có thông tin!'}}
                @endif
            </div>
        </div>
    </div>
@endsection