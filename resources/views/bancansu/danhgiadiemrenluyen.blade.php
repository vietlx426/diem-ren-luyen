@extends('bancansu.layout.master')
@section('title')
  @parent | Dashboard
@endsection

@section('css')
  <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">
@endsection

@section('content')

    <form action="{{route('post_bancansu_danhgiadiemrenluyen')}}" method="POST">
      {{csrf_field()}}

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
                          <th colspan="{{(App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::CountMaxColumn($TieuChi_Level_0->id) + 1) * 2}}"class="text-center" style="bottom: 1px;">{{$TieuChi_Level_0->chimuctieuchi}} {!!$TieuChi_Level_0->tentieuchi!!}</th>
                        @endforeach
                      @endif
                      <th colspan="2" class="text-center">TỔNG</th>
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
                                  <th colspan="{{($CountMaxColumn + 1) * 2}}" title="{{$TieuChi_Level_1->tentieuchi}}">
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
                                        <!-- {!! $tentieuchi !!} -->
                                      @else
                                        <!-- {!! $TieuChi_Level_1->tentieuchi !!} -->
                                      @endif

                                    </p>
                                  </th>
                              @endforeach
                            @else
                                <th colspan="2"> <p></p> </th>
                            @endif
                        @endforeach
                      @endif
                      <th colspan="2"></th>
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
                                      <th colspan="{{($CountMaxColumn + 1) * 2}}">
                                        <p>
                                          {{$TieuChi_Level_2->chimuctieuchi}} 
                                          @if($CountMaxColumn > 0)
                                            <?php $tentieuchi = substr($TieuChi_Level_2->tentieuchi, 0, 150); ?>
                                            {!! $tentieuchi !!}
                                          @else
                                            {!! $TieuChi_Level_2->tentieuchi !!}
                                          @endif

                                        </p>
                                      </th>
                                  @endforeach
                                @else
                                  <th colspan="2"> <p></p> </th>
                                @endif

                            @endforeach
                          @else
                            <th colspan="2"> <p></p> </th>
                          @endif
                        @endforeach
                      @endif
                      <th colspan="2"></th>

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
                                      $DS_TieuChi_Level_3 = App\TieuChi::where('idtieuchicha', '=', $TieuChi_Level_2->id)->get();
                                    ?>

                                    
                                    @if(count($DS_TieuChi_Level_3) > 0)
                                      @foreach($DS_TieuChi_Level_3 as $TieuChi_Level_3)
                                          <th colspan="{{(App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::CountMaxColumn($TieuChi_Level_3->id) + 1) * 2}}"> <p>{{$TieuChi_Level_3->chimuctieuchi}} {!!$TieuChi_Level_3->tentieuchi!!} </p> </th>
                                      @endforeach
                                    @else
                                      <th colspan="2"> <p></p> </th>
                                    @endif


                                @endforeach

                              @else
                                <th colspan="2"> <p></p> </th>
                              @endif

                            @endforeach
                          @else
                            <th colspan="2"> <p></p> </th>
                          @endif
                        @endforeach
                      @endif
                      <th colspan="2"></th>

                    </tr>
                    
                    <!-- Title SV vs BCS -->
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
                                          <th class="revenueCol text-center"> <p>BCS</p> </th>
                                      @endforeach
                                    @else
                                      <th class="profitCol text-center"> <p>SV</p> </th>
                                      <th class="revenueCol text-center"> <p>BCS</p> </th>
                                    @endif

                                @endforeach

                              @else
                                <th class="profitCol text-center"> <p>SV</p> </th>
                                <th class="revenueCol text-center"> <p>BCS</p> </th>
                              @endif

                            @endforeach
                          @else
                            <th class="profitCol text-center"> <p>SV</p> </th>
                            <th class="revenueCol text-center"> <p>BCS</p> </th>
                          @endif
                        @endforeach
                      @endif

                      <th>SV</th>
                      <th>BCS</th>

                    </tr>

                  </thead>

                  <tbody id="tbody_tbl_ds_sinhvien_tieuchi">
                    @if(isset($DS_SinhVien))
                      
                      @foreach($DS_SinhVien as $SinhVien)
                        <tr id="{{$SinhVien->id}}">
                          <td>
                            <div class="row">{{$SinhVien->mssv}} - {{$SinhVien->hochulot}} {{$SinhVien->ten}}</div>
                          </td>

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
                                            
                                            <!-- Lấy điểm sinh viên đã tự đánh giá -->
                                            <?php 

                                              $diem_SinhVien = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::getDiemSVTuDanhGia($SinhVien->id, $TieuChi_Level_3->id);
                                             ?>

                                            <!-- Column điểm SV đã tự đánh giá -->
                                            <td class="text-center"> {{$diem_SinhVien}} </td>
                                            
                                            <!-- Column BSC đánh giá -->
                                            <td class="text-center">

                                              <!-- Lấy điểm BCS đã đánh giá -->
                                              <?php 

                                                $diem_BCS = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::getDiemBCSDanhGia($SinhVien->id, $TieuChi_Level_3->id);
                                                
                                                if(strcmp($diem_BCS, "NULL") === 0)
                                                {
                                                  $diem_BCS = $diem_SinhVien;
                                                }
                                              ?>


                                              <div class="row">
                                                @if(intval($TieuChi_Level_3->idloaidiem) == intval(2))
                                                  <input type="number" name="{{$SinhVien->id}}_{{$TieuChi_Level_3->id}}" idtieuchi="{{$TieuChi_Level_3->id}}" class="form-control" min="0" max="{{$TieuChi_Level_3->diemtoida}}" value="{{$diem_BCS}}" title="Điểm tối đa {{$TieuChi_Level_3->diemtoida}}">
                                                @endif

                                                @if(intval($TieuChi_Level_3->idloaidiem) == intval(3))
                                                  <input type="checkbox" name="{{$SinhVien->id}}_{{$TieuChi_Level_3->id}}" idtieuchi="{{$TieuChi_Level_3->id}}" max="{{$TieuChi_Level_3->diemtoida}}" {{$diem_BCS>0 ? 'checked="true"' : ''}} title="Chọn là được {{$TieuChi_Level_3->diemtoida}} điểm">
                                                @endif
                                              </div>
                                            </td>
                                            
                                          @endforeach

                                        @else

                                          <!-- Lấy điểm sinh viên đã tự đánh giá -->
                                          <?php 

                                            $diem_SinhVien = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::getDiemSVTuDanhGia($SinhVien->id, $TieuChi_Level_2->id);
                                           ?>

                                          <!-- Column điểm SV đã tự đánh giá -->
                                          <td class="text-center"> {{$diem_SinhVien}} </td>
                                          
                                          <!-- Column BSC đánh giá -->
                                          <td class="text-center">

                                            <!-- Lấy điểm BCS đã đánh giá -->
                                            <?php 

                                              $diem_BCS = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::getDiemBCSDanhGia($SinhVien->id, $TieuChi_Level_2->id);
                                              
                                              if(strcmp($diem_BCS, "NULL") === 0)
                                              {
                                                $diem_BCS = $diem_SinhVien;
                                              }
                                            ?>


                                            <div class="row">
                                              @if(intval($TieuChi_Level_2->idloaidiem) == intval(2))
                                                <input type="number" name="{{$SinhVien->id}}_{{$TieuChi_Level_2->id}}" class="form-control" min="0" max="{{$TieuChi_Level_2->diemtoida}}" value="{{$diem_BCS}}" title="Điểm tối đa {{$TieuChi_Level_2->diemtoida}}">
                                              @endif

                                              @if(intval($TieuChi_Level_2->idloaidiem) == intval(3))
                                                <input type="checkbox" name="{{$SinhVien->id}}_{{$TieuChi_Level_2->id}}"   {{$diem_BCS>0 ? 'checked="true"' : ''}} title="Chọn là được {{$TieuChi_Level_2->diemtoida}} điểm">
                                              @endif
                                            </div>
                                          </td>

                                        @endif

                                    @endforeach

                                  @else

                                    <!-- Lấy điểm sinh viên đã tự đánh giá -->
                                    <?php 

                                      $diem_SinhVien = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::getDiemSVTuDanhGia($SinhVien->id, $TieuChi_Level_1->id);
                                     ?>

                                    <!-- Column điểm SV đã tự đánh giá -->
                                    <td class="text-center"> {{$diem_SinhVien}} </td>
                                    
                                    <!-- Column BSC đánh giá -->
                                    <td class="text-center">

                                      <!-- Lấy điểm BCS đã đánh giá -->
                                      <?php 

                                        $diem_BCS = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::getDiemBCSDanhGia($SinhVien->id, $TieuChi_Level_1->id);
                                        
                                        if(strcmp($diem_BCS, "NULL") === 0)
                                        {
                                          $diem_BCS = $diem_SinhVien;
                                        }
                                      ?>


                                      <div class="row">
                                        @if(intval($TieuChi_Level_1->idloaidiem) == intval(2))
                                          <input type="number" name="{{$SinhVien->id}}_{{$TieuChi_Level_1->id}}"  class="form-control" min="0" max="{{$TieuChi_Level_1->diemtoida}}" value="{{$diem_BCS}}" title="Điểm tối đa {{$TieuChi_Level_1->diemtoida}}">
                                        @endif

                                        @if(intval($TieuChi_Level_1->idloaidiem) == intval(3))
                                          <input type="checkbox" name="{{$SinhVien->id}}_{{$TieuChi_Level_1->id}}"   {{$diem_BCS>0 ? 'checked="true"' : ''}} title="Chọn là được {{$TieuChi_Level_1->diemtoida}} điểm">
                                        @endif
                                      </div>
                                    </td>

                                  @endif

                                @endforeach
                              @else

                                <!-- Lấy điểm sinh viên đã tự đánh giá -->
                                <?php 

                                  $diem_SinhVien = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::getDiemSVTuDanhGia($SinhVien->id, $TieuChi_Level_0->id);
                                 ?>

                                <!-- Column điểm SV đã tự đánh giá -->
                                <td class="text-center"> {{$diem_SinhVien}} </td>
                                
                                <!-- Column BSC đánh giá -->
                                <td class="text-center">

                                  <!-- Lấy điểm BCS đã đánh giá -->
                                  <?php 

                                    $diem_BCS = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::getDiemBCSDanhGia($SinhVien->id, $TieuChi_Level_0->id);

                                    if(strcmp($diem_BCS, "NULL") === 0)
                                    {
                                      $diem_BCS = $diem_SinhVien;
                                    }
                                  ?>


                                  <div class="row">
                                    @if(intval($TieuChi_Level_0->idloaidiem) == intval(2))
                                      <input type="number" name="{{$SinhVien->id}}_{{$TieuChi_Level_0->id}}" class="form-control" min="0" max="{{$TieuChi_Level_0->diemtoida}}" value="{{$diem_BCS}}" title="Điểm tối đa {{$TieuChi_Level_0->diemtoida}}">
                                    @endif

                                    @if(intval($TieuChi_Level_0->idloaidiem) == intval(3))
                                      <input type="checkbox" name="{{$SinhVien->id}}_{{$TieuChi_Level_0->id}}" {{$diem_BCS>0 ? 'checked="true"' : ''}} title="Chọn là được {{$TieuChi_Level_0->diemtoida}} điểm">
                                    @endif
                                  </div>
                                </td>

                              @endif

                            @endforeach
                          @endif

                          <td class="text-center" style="background: #2A3F54; color: #fff;">{{App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::GetTongDiem_SinhVien($SinhVien->id)}}</td>
                          <td class="text-center" style="background: #542a3f; color: #fff; font-weight: bold;">{{App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::GetTongDiem_BanCanSu($SinhVien->id)}}</td>
                        </tr>
                      @endforeach
                    @endif
                    
                  </tbody>
                </table>
              </div>
              <hr>
              <div class="text-center">
                <button class="btn btn-primary btn_save_bangdiem_bcs">
                  <i class="fa fa-save"> </i>
                  <strong> LƯU BẢNG ĐIỂM</strong>
                </button>

                <a href="{{route('bancansu_danhgiadiemrenluyen_export')}}" class="btn btn-info btn_export_bangdiem_bcs">
                  <i class="fa fa-download"> </i>
                  <strong> TẢI BẢNG ĐIỂM </strong>
                </a>

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

    $('.btn_save_bangdiem_bcs').click(function (e) {
      $('#site-loader').addClass('show');
    });

    // $('.btn_save_bangdiem_bcs').click(function (e) {
    //   var data = [];
    //   console.log("id tr: ");
    //   var count = 0;
    //   $('#tbody_tbl_ds_sinhvien_tieuchi tr').each(function(){
    //     var sinhvien_id = this.id;
    //     var data_tmp = {};
    //     data_tmp['sinhvien_id'] = sinhvien_id;

    //     // .push({
    //     //   'sinhvien_id': sinhvien_id
    //     // });

    //     var nameInputNumber_Checkbox=this.id;
        
    //     console.log(this.id + ": ");

    //     $("input[name='" + nameInputNumber_Checkbox + "']").each(function(){
    //       // t.push(this.value);
    //       console.log($(this).attr('idtieuchi'));
    //       var diem = 0;
    //       if(this.checked)
    //       {
    //         diem = $(this).attr('max');
    //       }

    //       var idtieuchi = "tc" + $(this).attr('idtieuchi');
    //       // var data_tmp_tieuchi = {
    //       //   [idtieuchi]: diem
    //       // };
    //       data_tmp[idtieuchi] = diem;
    //       // data_tmp.push(idtieuchi: diem);

    //     });
    //     // data.push(data_tmp);

    //     // $.each(data, function(key, value) {
    //     //   $.each(value, function(k, v){
    //     //     // console.log("key: " + key + "; value: " + value + "; k: " + k + "; v: " + v);
    //     //     $.each(v, function(k1, v1){
    //     //       console.log("key: " + key +  "; k: " + k + "; k1: "+ k1 +"; v1: "  + v1);
    //     //     })
    //     //   });
    //     // });

    //     // $("input[type='number']").each(function(){
    //     //   var id = $(this).attr("id");
    //     //   var value = id+"-"+this.value;
    //     //   t.push(value);
    //     // });


    //   });

    //   console.log("Count: " + count);
    //   console.log("Data: " + data);
    //  alert("vdfv");
    // });
  </script>
@endsection