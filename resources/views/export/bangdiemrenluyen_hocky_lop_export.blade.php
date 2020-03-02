@extends('layouts.print_export')

@section('container')
    <div class="row">
        <div class="x_panel">
            <div class="x_content">
                @if(isset($dsSinhVien_Diem_XepLoai))
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
                            <th colspan="2" class="text-center">
                                <strong><br>BẢNG ĐIỂM RÈN LUYỆN TỔNG HỢP</strong>
                                <br>
                                {{isset($hocKyNamHoc)?$hocKyNamHoc->tenhockynamhoc:''}}
                                <br>
                                {{isset($lop)?"Lớp: ".$lop->tenlop ."&nbsp;&nbsp;&nbsp;&nbsp;":'' }}
                                {{"Sỉ số: ". count($dsSinhVien_Diem_XepLoai) }}
                                <br>
                            </th>
                        </tr>
                    </table>
                    <br>
                    
                    <?php $STT = '0' ?>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="10%" class="text text-center">STT</th>
                                <th width="20%" class="text text-center">MSSV</th>
                                <th width="30%" class="text">HỌ VÀ TÊN</th>
                                <th width="20%" class="text text-right">ĐIỂM</th>
                                <th width="20%" class="text">XẾP LOẠI</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($dsSinhVien_Diem_XepLoai as $sinhVien_Diem_XepLoai)
                                <tr>
                                    <td class="text text-center">{{++$STT}}</td>
                                    <td class="text text-center">{{$sinhVien_Diem_XepLoai->mssv}}</td>
                                    <td class="text">{{$sinhVien_Diem_XepLoai->hochulot . " " . $sinhVien_Diem_XepLoai->ten}}</td>
                                    <td class="text text-right">{{number_format($sinhVien_Diem_XepLoai->diemrenluyen, 2, '.','')}}</td>
                                    <td class="text">{{$sinhVien_Diem_XepLoai->tenxeploai}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table style="width:100%;">
                        <tr>
                            <td class="text-center" style="width:50%;"></td>
                            <td class="text-center" style="width:50%;">
                                <i>An Giang, ngày {{date('d')}} tháng {{date('m')}} năm {{date('Y')}}</i>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" style="width:50%;"></td>
                            <th class="text-center" style="width:50%;">
                                <br> HIỆU TRƯỞNG
                            </th>
                        </tr>
                    </table>
                @else
                    {{'Không có thông tin!'}}
                @endif
            </div>
        </div>
    </div>
@endsection