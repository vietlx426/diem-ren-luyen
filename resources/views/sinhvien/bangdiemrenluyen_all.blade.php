@extends('sinhvien.layout.master')
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
  @if(isset($dsHocKyNamHoc))
    <div class="row">
      <div class="x_panel">
        <!-- <div class="x_title">
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
          </ul>
          <div class="clearfix"></div>
        </div> -->
        <div class="x_content">
          <div class="row text-center">
            <h4>KẾT QUẢ RÈN LUYỆN TOÀN KHÓA HỌC</h4>
            <h4>----------o0o----------</h4>
            <br>
          </div>
          <div class="row">
            <div class="row col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              @include('layouts.gentelella-master.blocks.flash-messages')
            </div>
            <table class="table" width="100%">
                <tbody>
                  <?php 
                    $STT = 0; 
                    $idSinhVien = isset($idSinhVien)?$idSinhVien:'';
                  ?>
                  @foreach($dsHocKyNamHoc as $hocKyNamHoc)
                    <?php 
                      $diemTong = App\Http\Controllers\ServiceDanhGiaDiemRenLuyenController::GetTongDiemTheoHocKy($idSinhVien, $hocKyNamHoc->id);
                      $xepLoai = App\Http\Controllers\XepLoaiDiemRenLuyenController::getXepLoai($diemTong);
                    ?>
                    <tr>
                        <td width="40%">{{++$STT}}. {{$hocKyNamHoc->tenhockynamhoc}}</td>
                        <td width="20%">ĐRL: <strong>{{number_format((float)$diemTong ? $diemTong : '0', 2, '.', '')}}</strong></td>
                        <td width="20%">Xếp loại: <strong>{{$xepLoai ? $xepLoai->tenxeploai : ''}}</strong></td>
                        <td width="20%"><a href="{{route('sinhvien_bangdiemrenluyen_hockynamhoc', ['idhockynamhoc'=>$hocKyNamHoc->id])}}" class="btn btn-success" title="Chi tiết bảng điểm"><i class="fa fa-info-circle"></i></a></td>
                    </tr>
                  @endforeach
                  <tr>
                    <td colspan="4"></td>
                  </tr>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection