@extends('admin.layout.master')
@section('title')
  @parent | Thống kê toàn trường
@endsection

@section('css')
  @parent
  <!-- Datatables -->
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
      <div class="x_panel">
        <div class="x_title">
                <h2> THÔNG TIN HỌC BỔNG: {{isset($details_hb) ? $details_hb->tenhb : ''}} </h2>
                <div class="pull-right">
                    

                  
                </div>
                <div class="clearfix"></div>
            </div>
        <div class="x_content">
        <div class="row">
          

          

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/graduates.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
            SỐ LƯỢNG: {{$details_hb->soluong}}
              </div>
            </div>
          </div>

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
             TỔNG TRỊ GIÁ: {{number_format($details_hb->gthb,'0',',','.')}}
              </div>
            </div>
          </div>
           <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
             SỐ TIỀN ĐÃ TRAO: {{number_format(($ds_sv)->sum("giatri"),0,',','.')}} VNĐ
              </div>
            </div>
          </div>
          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
             SỐ SV ĐÃ NHẬN HỌC BỔNG: {{ count($ds_sv) }}
              </div>
            </div>
          </div>
    
          
          
        </div>
        

      </div>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
          <div class="pull-right">
           
          </div>
          <div class="clearfix">
            
          </div>
        </div>
        <div class="x_content">
          <div class="row">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Khoa</th>
                  <th scope="col">Số lượng học bổng đã trao</th>
                  
                </tr>
              </thead>
              <tbody>
                @if(isset($khoa))
                @foreach($khoa as $data)
                 <?php $STT = 0; ?>
                <tr>
                  <th>{{++$STT}}</th>
                  <td>{{$data->tenkhoa->tenkhoa}}</td>
                  <td>{{ count($sl_HBdatrao->where("idk", $data->id_khoa)) }}</td>
                  
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>

        <div class="x_content">
          <div class="row">
            @include('layouts.gentelella-master.blocks.flash-messages')
            <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
              <thead>
                  <tr class="filters">
                      <th width="10%">STT</th>
                      <th width="23%">MSSV</th>
                      <th width="10%">Họ tên</th>
                     
                      
                      <th width="10%">Lớp</th>
                      <th width="20%">Số tiền đã trao</th>
                      
                  </tr>
              </thead>
              <tbody id="tbodystudent">
                <!-- <tr>
                  <th></th>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    {{number_format(($ds_sv)->sum("giatri"),0,',','.')}} VNĐ
                  </td>
                </tr> -->
                @if(isset($ds_sv))
                 <?php $STT = 0; ?>
                 @foreach($ds_sv as $data)
                <tr>
                  <th >{{++$STT}}</th>
                  <td >{{$data->mssv}}</td>
                  <td>
                     {{$data->hochulot}} {{$data->ten}}
                  </td>
               
                 <td>
                  {{$data->lop->tenlop}}
                    
                   
                 </td>
                 <td>
                  {{number_format($data->giatri,'0',',','.')}} đ

                  
                 </td>
                 
                </tr>
               @endforeach
               @endif
                
              </tbody>
             
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('javascript')
    @parent
    <!-- Datatables -->
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
@endsection