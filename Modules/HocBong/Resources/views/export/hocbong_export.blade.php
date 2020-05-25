@extends('layouts.print_export')

@section('container')
    <div class="row">
        <div class="x_panel">
            <div class="x_content">
                    <table style="width:100%;">
                        <tr>
                            <td class="text-center">TRƯỜNG ĐẠI HỌC AN GIANG</td>
                            <th class="text-center"><strong> <b> CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM </b></strong></th>
                        </tr>
                        <tr>
                            <th class="text-center"><strong>PHÒNG CÔNG TÁC SINH VIÊN</strong></th>
                            <th class="text-center"><strong>Độc lập - Tự do - Hạnh phúc</strong></th>
                        </tr>
                        <tr>
                            <td class="text-center">---------------------</td>
                            <td class="text-center">----------------------------------------</td>
                        </tr>
                       <tr>
                            <th colspan="2" class="text-center">
                                <strong><br>
                                BẢNG THỐNG KÊ HỌC BỔNG LỚP
                                {{$tenlop->tenlop}}
                                </strong>
                                <br>
                                 {{isset($getTenNH) ? 'NĂM HỌC '.$getTenNH->tennamhoc : $getTenHKNH->tenhockynamhoc}}
                                
                               
                                <br>
                                  SỐ SINH VIÊN ĐÃ NHẬN HỌC BỔNG: {{count($soluong_hb)}} 
                                 <br>
                                  TỔNG SỐ TIỀN ĐÃ TRAO: {{number_format((isset($soluong_hb) ? $soluong_hb->sum("giatri") : 0), 0 , ',', '.')}} 
                                  <br>
                                  
                            </th>
                        </tr>
                    </table>
                    <br>
                    
                    <?php $STT = '0' ?>
                     @if(isset($dssvByNamHoc))
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="10%" class="text text-center">STT</th>
                                <th width="30%" class="text text-center">Tên sinh viên</th>
                                <th width="15%" class="text text-center">Tên học bổng</th>
                                <th width="20%" class="text">Tổng giá trị đã trao</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($dssvByNamHoc as $data)
                                <tr>
                                    <td class="text text-center">{{++$STT}}</td>
                                    <td class="text text-center">{{$data->hochulot}} {{$data->ten}}</td>
                                    <td class="text">
                                        @foreach($dshb as $hocbong)
                                          @if($hocbong->id_sinhvien === $data->id_sinhvien)
                                          {{$hocbong->HocBong->tenhb}}<br>
                                          @endif
                                          
                                          @endforeach
                                    </td>
                                
                                    
                                    <td class="text text-center">
                                      {{ number_format(($soluong_hb->where("id_sinhvien", $data->id_sinhvien))->sum("giatri"), 0 , ',', '.') }}đ

                                     </td>
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
                                <br> TRƯỞNG PHÒNG
                            </th>
                        </tr>
                    </table>
                    @endif
                    @if(isset($dssvByHocKy))
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="10%" class="text text-center">STT</th>
                                <th width="30%" class="text text-center">Tên sinh viên</th>
                                <th width="25%" class="text text-center">Tên học bổng</th>
                                <th width="10%" class="text text-center">Điểm học tập</th>
                                <th width="10%" class="text text-center">Điểm rèn luyện</th>
                                <th width="15%" class="text">Tổng giá trị đã trao</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($dssvByHocKy as $data)
                                <tr>
                                  <th >{{++$STT}}</th>
                                  <td >{{$data->hochulot}} {{$data->ten}}</td>
                                  <td>
                                     
                                    @foreach($dshb as $hocbong)
                                  @if($hocbong->id_sinhvien === $data->id_sinhvien)
                                  {{$hocbong->HocBong->tenhb}}<br>
                                  @endif
                                  
                                  @endforeach
                                  </td>
                                  <td>{{$data->diemhoctap}}</td>
                                 <td>{{$data->drl}}</td>
                                 <td>
                                  {{ number_format(($soluong_hb->where("id_sinhvien", $data->id_sinhvien))->sum("giatri"), 0 , ',', '.') }}đ

                                 </td>
                                 
                                 
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    
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
                                <br> TRƯỞNG PHÒNG
                            </th>
                        </tr>
                    </table>
               
                
            </div>
        </div>
    </div>
@endsection