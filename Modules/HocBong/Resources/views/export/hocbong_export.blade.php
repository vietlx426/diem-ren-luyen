@extends('layouts.print_export')

@section('container')
    <div class="row">
        <div class="x_panel">
            <div class="x_content">
                @if(isset($dsHocBong))
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
                                <strong><br>BẢNG THỐNG KÊ HỌC BỔNG</strong>
                                <br>
                                 {{isset($namhoc) ? 'NĂM HỌC '.$namhoc->tennamhoc : $hknh->tenhockynamhoc}}
                                <br>
                                {{isset($soluong_hb) ? 'Số học bổng '.count($soluong_hb) : ''}} 
                               
                                <br>
                                 Tổng giá trị {{number_format((isset($soluong_hb) ? $soluong_hb->sum("gthb") : 0), 0 , ',', '.')}}
                                 <br>
                                  Số tiền đã trao: {{number_format((isset($sl_HBdatrao) ? $sl_HBdatrao->sum("giatri") : 0), 0 , ',', '.')}} 
                                  <br>
                                  Số SV đã nhận học bổng: {{(isset($sl_HBdatrao) ? $sl_HBdatrao->count("id_sinhvien") : 0)}}
                            </th>
                        </tr>
                    </table>
                    <br>
                    
                    <?php $STT = '0' ?>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="10%" class="text text-center">STT</th>
                                <th width="10%" class="text text-center">Mã HB</th>
                                <th width="25%" class="text">Tên HB</th>
                                <th width="20%" class="text">Phạm vi</th>
                                <th width="15%" class="text text-right">Giá trị HB</th>
                                <th width="20%" class="text">ĐVTT</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($dsHocBong as $data)
                                <tr>
                                    <td class="text text-center">{{++$STT}}</td>
                                    <td class="text text-center">{{$data->mahb}}</td>
                                    <td class="text">{{$data->tenhb}}</td>
                                    <td>
                                        <?php
                                  if(count($toantruong->where("id_hocbong", $data->idhb)) < 9){
                                    ?>
                                    
                                      @foreach($hocbong_phamvi as $khoa)
                                      @if($khoa->id_hocbong == $data->idhb)
                                      {{$khoa->tenkhoa->tenkhoa}} 
                                   
                                      @endif
                                      @endforeach
                                    
                                    <?php
                                
                                  }
                                  else{
                                    ?>
                                     Toàn trường
                                    <?php 
                                  }
                                ?>
                                    </td>
                                    <td class="text text-right">{{number_format($data->gthb,0,',','.')}}</td>
                                    <td class="text">{{$data->tendvtt}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="10%" class="text text-center">STT</th>
                                <th width="10%" class="text text-center">Khoa</th>
                                <th width="25%" class="text">Số lượng</th>
                                <th width="20%" class="text">Số lượng SV nhận HB</th>
                                <th width="35%" class="text text-right">Tổng số tiền đã trao</th>
                                
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($ds_khoa as $data)
                            <?php $STT = 0; ?>
                                <tr>
                                    <td class="text text-center">{{++$STT}}</td>
                                    <td class="text text-center">{{$data->tenkhoa}}</td>
                                    <td class="text">{{ count($sl_hb->where("idkhoa", $data->id)) }}</td>
                                    <td>
                                       {{ count($sl_sv->where("idkhoa", $data->id)) }} 
                                    </td>
                                    <td class="text text-right">{{number_format(($sl_sv->where("idkhoa", $data->id))->sum("giatri"),0,',','.')}}</td>
                                    <td class="text"></td>
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
               
                @endif
            </div>
        </div>
    </div>
@endsection