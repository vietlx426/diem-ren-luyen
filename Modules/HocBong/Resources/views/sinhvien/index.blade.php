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
<div class="row">
      <div class="x_panel">
      <div class="pull-right">
          <a href="{{route('sinhvien.ketqua.all')}}" class="btn btn-info">
            <strong><i class="fa fa-info"></i> KẾT QUẢ HỌC BỔNG TOÀN KHÓA</strong>
          </a>
        </div>
        <div class="x_content">
          <div class="row text-center">
            <h4>DANH SÁCH THÔNG BÁO & HỒ SƠ XIN CẤP HỌC BỔNG</h4>
            <br>
          </div>
          <div class="row">
            <div class="row col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              @include('layouts.gentelella-master.blocks.flash-messages')
            </div>
            <table id="tbl_thongbao" class="table table-striped table-bordered" width="100%">
               <thead>
                  <tr class="filters">
                      <th >Danh sách thông báo</th>                                   
                   </tr>
                </thead> 
                <tbody>
                  @isset($dsThongBao)
                  @foreach($dsThongBao as $data)
                                  <tr>
                                    <td class="">
                                      <a href="{{route('sinhvien.thongbao.hocbong',[$data->idthongbao,$data->slug])}}">
                                      <div class="weekly-item" style="display: flex;">
                                          <div class="number"><i class="fa fa-newspaper-o" style="color: red; font-size: 20px; padding-right:10px"></i></div>
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
          <div class="row">
            <div class="row col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            </div>
            
                  @isset($dsHoSo)
                  @foreach($dsHoSo as $data)
                  <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
                                <thead>
                                <tr class="filters">
                                  <th>STT</th>
                                  <th>Tên học bổng</th>
                                  <th>Học kỳ năm học</th>
                                  <th >Ngày nộp</th>
                                  <th >Tình trạng</th>
                                </tr>
                            </thead> 
                            <tbody>
                               @foreach ($dsHoSo as $data)
                               <tr>
                                 <td>{{$loop->iteration}}</td>
                                 <td>{{$data->hocbong->tenhb}}</td>
                                 <td>{{$data->hocbong->HocKyNamHoc->tenhockynamhoc}}</td>
                                 <td>{{ date('d-m-yy', strtotime($data->created_at)) }}</td>
                                <td>
                                @if($data->status === 0)
                                <span class="label label-primary"  style="font-size: 12px"> Đang xử lý </span>
                                @elseif($data->status === 2)
                                <span class="label label-danger"  style="font-size: 12px">Hồ sơ không đạt </span>
                                <br><br>
                                Lý do: {{$data->noidung}}
                                @else
                                <span class="label label-success"  style="font-size: 12px"> Đã nhận học bổng </span>

                                @endif
                                </td>
                                
                                 
                                 
                               </tr>
                               @endforeach
                            </tbody>
                        </table>
                   @endforeach
                    @endif
                
          </div>
        </div>
      </div>
    </div>
       

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
      $('#tbl_hoso').dataTable();
    </script>
@endsection