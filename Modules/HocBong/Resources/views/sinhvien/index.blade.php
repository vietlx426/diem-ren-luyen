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
  @if(isset($dsHKNH))
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
            <h4>KẾT QUẢ HỌC BỔNG TOÀN KHÓA HỌC</h4>
            <h4>----------o0o----------</h4>
            <br>
          </div>
          <div class="row">
            <div class="row col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              @include('layouts.gentelella-master.blocks.flash-messages')
            </div>
            <table class="table" width="100%">
                <thead>
                  <tr class="filters">
                      <th width="5%">STT</th>
                      <th width="5%">Học kỳ, năm học</th>
                      <th width="5%">Số lượng học bổng đã nhận</th>
                      <th width="10%">Số tiền đã nhận</th>
                                  
                  </tr>
                </thead> 
                <tbody>
                  @foreach($dsHKNH as $data)
                  <?php $STT=0; ?>
                    <tr>
                        <td width="10%">{{++$STT}}</td>
                        <td width="30%">{{$data->tenhockynamhoc}}</td>
                        <td width="20%">Số lượng: <strong>
                           {{ count($dsHocBong->where("idhockynamhoc", $data->id)) }}
                        </strong></td>
                        <td width="20%">Số tiền: <strong>
                          {{ number_format(($dsHocBong->where("idhockynamhoc", $data->id))->sum("giatri"),0,',','.') }}
                        </strong></td>
                        <td width="20%"><a href="{{route('test',$data->id)}}" class="btn btn-success" title="Chi tiết bảng điểm"><i class="fa fa-info-circle"></i></a></td>
                    </tr>
                  @endforeach
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Tổng: <strong>{{ number_format(($dsHocBong)->sum("giatri"),0,',','.') }}</strong> </td>
                  </tr>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
   @endif
@endsection