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
      <div class="x_content">
        <div class="row text-center">
            <h4>THÔNG BÁO HỌC BỔNG</h4>
           
          </div>
       
        <table id="tbl_thongbao" class="table table-striped table-bordered" width="100%">
                                  <thead>
                                  <tr class="filters">
                                    <th >Thông báo</th>                                   
                                    
                                    
                                  </tr>
                              </thead> 
                              <tbody>
                              @isset($dsThongBao)
                              @foreach($dsThongBao as $data)
                                  <tr>
                                    <td class="">
                                      <a href="{{route('sinhvien.thongbao.hocbong',[$data->idthongbao,$data->slug])}}">
                                      <div class="weekly-item" style="display: flex;">
                                          <div class="number"><i class="fa fa-newspaper-o" style="color: red; font-size: 20px"></i></div>
                                          <div class="info" style="flex-grow: 1;">
                                              <div class="singer">
                                                {{$data->tieude}}
                                              </div>
                                          </div>
                                          <div class="view-count">{{ date('d-m-yy', strtotime($data->ngaytao)) }}</div>
                                      </div>
                                      </a> 
                                    </td>               
                                  </tr>
                                @endforeach
                                @endif
                              </tbody>
                          </table>
 
      </div>
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
                        <td width="20%"><a href="{{route('sinhvien.chitiet.ketqua',$data->id)}}" class="btn btn-success" title="Chi tiết bảng điểm"><i class="fa fa-info-circle"></i></a></td>
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
@section('javascript')
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
  <script type="text/javascript">

      $('#tbl_thongbao').dataTable();
    </script>
@endsection