@extends('subadmin.layout.master')
@section('title')
  @parent
@endsection

@section('css')
  <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">
@endsection

@section('content')
    <form action="{{route('post_subadmin_danhgiadiemrenluyen_lop')}}" method="POST">
      {{csrf_field()}}
      <input type="text" name="idLop" class="hidden" hidden="true" value="{{isset($idLop) ? $idLop : ''}}">
      <div class="row">
        <div class="x_panel">
          <div class="x_title">
            <h2> <i class="fa fa-edit"></i> ĐÁNH GIÁ ĐIỂM RÈN LUYỆN <small></small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- -------------------------------------- -->
            <div class="row">
              @include('layouts.gentelella-master.blocks.flash-messages')
            </div>

            <div class="row">
              <div class="JStableOuter" >
                <table>
                  <thead>
                    <tr style="top: 0px" >
                      <th style="left: 0px"></th>
                      @if(isset($DS_TieuChi_Level_0))
                        @foreach($DS_TieuChi_Level_0 as $TieuChi_Level_0)
                          <?php 
                            $DS_TieuChi_Con = App\TieuChi::where('idtieuchicha', '=', $TieuChi_Level_0->id)->get();
                           ?>
                          <th colspan="{{(App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::CountMaxColumn($TieuChi_Level_0->id) + 1) * 5}}"class="text-center" style="bottom: 1px;" title="{{$TieuChi_Level_0->chimuctieuchi}} {!!$TieuChi_Level_0->tentieuchi!!}">{{$TieuChi_Level_0->chimuctieuchi}} {!!$TieuChi_Level_0->tentieuchi!!}</th>
                        @endforeach
                      @endif
                      <th colspan="5" class="text-center">TỔNG</th>
                    </tr>

                    <tr style="top: 0px" >
                      <th style="left: 0px" ></th>

                      @if(isset($DS_TieuChi_Level_0))
                        @foreach($DS_TieuChi_Level_0 as $TieuChi_Level_0)
                          <?php 
                            $DS_TieuChi_Level_1 = App\TieuChi::where('idtieuchicha', '=', $TieuChi_Level_0->id)->get();
                           ?>
                            @if(count($DS_TieuChi_Level_1) > 0)
                              @foreach($DS_TieuChi_Level_1 as $TieuChi_Level_1)
                                <?php 
                                  $CountMaxColumn = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::CountMaxColumn($TieuChi_Level_1->id);
                                 ?>
                                  <th colspan="{{($CountMaxColumn + 1) * 5}}" class="text-center" title="{{$TieuChi_Level_1->tentieuchi}}">
                                    <p>
                                      {{$TieuChi_Level_1->chimuctieuchi}} 
                                      @if($CountMaxColumn == 0)
                                        <?php
                                          $index = stripos($TieuChi_Level_1->tentieuchi, "<br />");
                                          if($index > 50)
                                            $tentieuchi = substr($TieuChi_Level_1->tentieuchi, 0 , $index);
                                          else
                                            $tentieuchi = $TieuChi_Level_1->tentieuchi;
                                        ?>
                                      @endif
                                    </p>
                                  </th>
                              @endforeach
                            @else
                                <th colspan="5"> <p></p> </th>
                            @endif
                        @endforeach
                      @endif
                      <th colspan="5"></th>
                    </tr>

                    <tr style="top: 0px" >
                      <th style="left: 0px" ></th>

                      @if(isset($DS_TieuChi_Level_0))
                        @foreach($DS_TieuChi_Level_0 as $TieuChi_Level_0)
                          <?php 
                            $DS_TieuChi_Level_1 = App\TieuChi::where('idtieuchicha', '=', $TieuChi_Level_0->id)->get();
                           ?>
                          @if(count($DS_TieuChi_Level_1) > 0)
                            @foreach($DS_TieuChi_Level_1 as $TieuChi_Level_1)
                                
                                <?php 
                                  $DS_TieuChi_Level_2 = App\TieuChi::where('idtieuchicha', '=', $TieuChi_Level_1->id)->get();
                                ?>
                                @if(count($DS_TieuChi_Level_2) > 0)
                                  @foreach($DS_TieuChi_Level_2 as $TieuChi_Level_2)
                                    <?php 
                                      $CountMaxColumn = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::CountMaxColumn($TieuChi_Level_2->id);
                                     ?>
                                      <th colspan="{{($CountMaxColumn + 1) * 5}}" class="text-center" title="{{$TieuChi_Level_2->chimuctieuchi}}. {!! $TieuChi_Level_2->tentieuchi !!}">
                                        <p>
                                          {{$TieuChi_Level_2->chimuctieuchi}} 
                                        </p>
                                      </th>
                                  @endforeach
                                @else
                                  <th colspan="5"> <p></p> </th>
                                @endif

                            @endforeach
                          @else
                            <th colspan="5"> <p></p> </th>
                          @endif
                        @endforeach
                      @endif
                      <th colspan="5"></th>

                    </tr>

                    <tr style="top: 0px" >
                      <th style="left: 0px" ></th>
                      <?php 
                        $arrayTC = array();
                       ?>
                      @if(isset($DS_TieuChi_Level_0))
                        @foreach($DS_TieuChi_Level_0 as $TieuChi_Level_0)
                          <?php 
                            $DS_TieuChi_Level_1 = App\TieuChi::where('idtieuchicha', '=', $TieuChi_Level_0->id)->get();
                           ?>
                           @if(count($DS_TieuChi_Level_1) > 0)
                            @foreach($DS_TieuChi_Level_1 as $TieuChi_Level_1)
                              
                              <?php 
                                $DS_TieuChi_Level_2 = App\TieuChi::where('idtieuchicha', '=', $TieuChi_Level_1->id)->get();
                              ?>
                              @if(count($DS_TieuChi_Level_2) > 0)
                                @foreach($DS_TieuChi_Level_2 as $TieuChi_Level_2)
                                
                                    <?php 
                                      $DS_TieuChi_Level_3 = App\TieuChi::where('idtieuchicha', '=', $TieuChi_Level_2->id)->get();
                                    ?>
                                    @if(count($DS_TieuChi_Level_3) > 0)
                                      @foreach($DS_TieuChi_Level_3 as $TieuChi_Level_3)
                                          <th colspan="{{(App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::CountMaxColumn($TieuChi_Level_3->id) + 1) * 5}}" class="text-center" title="{{$TieuChi_Level_3->chimuctieuchi}} {!!$TieuChi_Level_3->tentieuchi!!}"> <p>{{$TieuChi_Level_3->chimuctieuchi}}</p> </th>
                                      @endforeach
                                    @else
                                      <th colspan="5"> <p></p> </th>
                                    @endif
                                @endforeach

                              @else
                                <th colspan="5"> <p></p> </th>
                              @endif

                            @endforeach
                          @else
                            <th colspan="5"> <p></p> </th>
                          @endif
                        @endforeach
                      @endif
                      <th colspan="5"></th>

                    </tr>
                    
                    <!-- Title SV, BCS, CVHT -->
                    <tr style="top: 0px" >
                      <th style="left: 0px" ></th>

                      @if(isset($DS_TieuChi_Level_0))
                        @foreach($DS_TieuChi_Level_0 as $TieuChi_Level_0)
                          <?php 
                            $DS_TieuChi_Level_1 = App\TieuChi::where('idtieuchicha', '=', $TieuChi_Level_0->id)->get();
                           ?>
                           @if(count($DS_TieuChi_Level_1) > 0)
                            @foreach($DS_TieuChi_Level_1 as $TieuChi_Level_1)
                              
                              <?php 
                                $DS_TieuChi_Level_2 = App\TieuChi::where('idtieuchicha', '=', $TieuChi_Level_1->id)->get();
                              ?>
                              @if(count($DS_TieuChi_Level_2) > 0)
                                @foreach($DS_TieuChi_Level_2 as $TieuChi_Level_2)
                                
                                    <?php 
                                      $DS_TieuChi_Level_3 = App\TieuChi::where('idtieuchicha', '=', $TieuChi_Level_2->id)->get();
                                    ?>

                                    @if(count($DS_TieuChi_Level_3) > 0)
                                      @foreach($DS_TieuChi_Level_3 as $TieuChi_Level_3)
                                          <th class="profitCol text-center"> <p>SV</p> </th>
                                          <th class="profitCol text-center"> <p>BCS</p> </th>
                                          <th class="profitCol text-center"> <p>CVHT</p> </th>
                                          <th class="profitCol text-center"> <p>HĐK</p> </th>
                                          <th class="revenueCol text-center"> <p>HĐT</p> </th>
                                      @endforeach
                                    @else
                                      <th class="profitCol text-center"> <p>SV</p> </th>
                                      <th class="profitCol text-center"> <p>BCS</p> </th>
                                      <th class="profitCol text-center"> <p>CVHT</p> </th>
                                      <th class="profitCol text-center"> <p>HĐK</p> </th>
                                      <th class="revenueCol text-center"> <p>HĐT</p> </th>
                                    @endif

                                @endforeach

                              @else
                                <th class="profitCol text-center"> <p>SV</p> </th>
                                <th class="profitCol text-center"> <p>BCS</p> </th>
                                <th class="profitCol text-center"> <p>CVHT</p> </th>
                                <th class="profitCol text-center"> <p>HĐK</p> </th>
                                <th class="revenueCol text-center"> <p>HĐT</p> </th>
                              @endif

                            @endforeach
                          @else
                            <th class="profitCol text-center"> <p>SV</p> </th>
                            <th class="profitCol text-center"> <p>BCS</p> </th>
                            <th class="profitCol text-center"> <p>CVHT</p> </th>
                            <th class="profitCol text-center"> <p>HĐK</p> </th>
                            <th class="revenueCol text-center"> <p>HĐT</p> </th>
                          @endif
                        @endforeach
                      @endif
                      <th class="profitCol text-center"><p>SV</p></th>
                      <th class="profitCol text-center"><p>BCS</p></th>
                      <th class="profitCol text-center"> <p>CVHT</p> </th>
                      <th class="profitCol text-center"> <p>HĐK</p> </th>
                      <th class="revenueCol text-center"> <p>HĐT</p> </th>
                    </tr>
                  </thead>
                  <tbody id="tbody_tbl_ds_sinhvien_tieuchi">
                    @if(isset($DS_SinhVien))
                      @foreach($DS_SinhVien as $SinhVien)
                        <tr id="{{$SinhVien->id}}">
                          <td>
                            <div class="row">{{$SinhVien->mssv}} - {{$SinhVien->hochulot}} {{$SinhVien->ten}}</div>
                          </td>
                          @if(isset($DS_TieuChiCongDiemTrucTiep))
                            @foreach($DS_TieuChiCongDiemTrucTiep as $TieuChi)
                              <?php 
                                $diem = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::getDiemSV($SinhVien->id, $TieuChi['idTieuChi']);
                               ?>

                              <!-- Column điểm SV đã tự đánh giá -->
                              <td class="text-center"> {{$diem?$diem->sinhvien_diem:0}} </td>
                              <!-- Column điểm BCS đã đánh giá -->
                              <td class="text-center"> {{$diem?$diem->bancansu_diem:0}} </td>
                              <!-- Column điểm CVHT đã đánh giá -->
                              <td class="text-center"> {{$diem?$diem->covanhoctap_diem:0}} </td>
                              <!-- Column điểm HĐK đã đánh giá -->
                              <td class="text-center"> {{$diem?$diem->hoidongkhoa_diem:0}} </td>
                                
                              <!-- Column HĐT đánh giá -->
                              <td class="text-center">
                                <!-- Lấy điểm HĐK đã đánh giá -->
                                <?php 
                                  if($diem)
                                    if($diem->hoidongtruong_diem <= -1)
                                      $diem_HDT = $diem->hoidongkhoa_diem;
                                    else
                                      $diem_HDT = $diem->hoidongtruong_diem;
                                  else
                                    $diem_HDT = 0;
                                ?>
                                <div class="row">
                                  @if(intval($TieuChi['idloaidiem']) == intval(2))
                                    <input type="number" name="{{$SinhVien->id}}_{{$TieuChi['idTieuChi']}}" class="form-control" min="0" max="{{$TieuChi['diemtoida']}}" value="{{$diem_HDT}}" title="Điểm tối đa {{$TieuChi['diemtoida']}}">
                                  @endif

                                  @if(intval($TieuChi['idloaidiem']) == intval(3))
                                    <input type="checkbox" name="{{$SinhVien->id}}_{{$TieuChi['idTieuChi']}}" {{$diem_HDT>0 ? 'checked="true"' : ''}} title="Chọn là được {{$TieuChi['diemtoida']}} điểm">
                                  @endif
                                </div>
                              </td>
                            @endforeach
                          @endif
                          <?php 
                            $tongDiem = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::GetTongDiem($SinhVien->id);
                           ?>
                          <td class="text-center col-total-student">{{$tongDiem['tongDiem_SinhVienDanhGia']}}</td>
                          <td class="text-center col-total-monitor">{{$tongDiem['tongDiem_BanCanSuDanhGia']}}</td>
                          <td class="text-center col-total-adviser">{{$tongDiem['tongDiem_CoVanHocTapDanhGia']}}</td>
                          <td class="text-center col-total-council-faculty">{{$tongDiem['tongDiem_HoiDongKhoaDanhGia']}}</td>
                          <td class="text-center col-total-council-university">{{$tongDiem['tongDiem_HoiDongTruongDanhGia']}}</td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
              <hr>
              <div class="text-center">
                <button class="btn btn-primary btn_save_bangdiem_cvht">
                  <i class="fa fa-save"> </i>
                  <strong> LƯU BẢNG ĐIỂM</strong>
                </button>
              </div>
            </div>
            <!-- -------------------------------------- -->
          </div>
        </div>
      </div>
    </form>
@endsection

@section('javascript')
  @parent
  
  <script type="text/javascript">
    $('.JStableOuter table').scroll(function(e) {
   
      $('.JStableOuter thead').css("left", -$(".JStableOuter tbody").scrollLeft()); 
      $('.JStableOuter thead th:nth-child(1)').css("left", $(".JStableOuter table").scrollLeft() -0 ); 
      $('.JStableOuter tbody td:nth-child(1)').css("left", $(".JStableOuter table").scrollLeft()); 
      $('.JStableOuter thead').css("top", -$(".JStableOuter tbody").scrollTop());
      $('.JStableOuter thead tr th').css("top", $(".JStableOuter table").scrollTop()); 
    });

    $('#site-loader').addClass('show');

    $('.btn_save_bangdiem_cvht').click(function (e) {
      $('#site-loader').addClass('show');
      return true;
    });
  </script>
@endsection