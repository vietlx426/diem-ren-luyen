@extends('admin.layout.master')
@section('title')
  @parent | Thống kê học bổng theo khoa
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
          <h2> <i class="fa fa-user-secret"></i>Thống kê học bổng của Khoa {{$tenkhoa->tenkhoa}}, Năm học {{isset($getNamHoc) ? $getNamHoc->tennamhoc : $getHKNH->tenhockynamhoc}}
       </h2>
       <div class="pull-right">
        <?php
          if(isset($getNamHoc)){
        ?>
          <a href="{{route('xuatexcel.theokhoa',[$tenkhoa->id,$getNamHoc->id])}}" class="btn btn-success">
            <strong><i class="fa fa-download"></i> EXPORT</strong>
          </a>   
                                                                  
        <?php                       
        }
        else{
        ?>
        <a href="{{route('xuatexcel.theokhoa.hocky',[$tenkhoa->id,$getHKNH->id])}}" class="btn btn-success">
            <strong><i class="fa fa-download"></i> EXPORT</strong>
          </a>      
        <?php 
        }
        ?>
        
      
       
        </div>
        <div class="x_content">
        <div class="row">

          

          

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/graduates.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
            SỐ HỌC BỔNG TRONG NĂM HỌC: {{ count($soluong_hb) }}
              </div>
            </div>
          </div>

          <!-- <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
             TỔNG TRỊ GIÁ: {{number_format((isset($tong_trigia) ? $tong_trigia : 0), 0 , ',', '.')}} 
              </div>
            </div>
          </div> -->
           <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
             SỐ TIỀN ĐÃ TRAO: {{number_format(($sl_HBdatrao)->sum("giatri"),0,',','.')}} VNĐ
              </div>
            </div>
          </div>
          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
             SỐ SV ĐÃ NHẬN HỌC BỔNG:   {{ count($sl_HBdatrao) }}
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
            @include('layouts.gentelella-master.blocks.flash-messages')
            <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
              <thead>

                  <tr class="filters">
                      <th width="10%">STT</th>
                      <th width="23%">Khoa</th>
                      <th width="10%">Số SV nhận HB</th>
                     
                      <th width="10%">Tổng giá trị đã trao</th>
                      <th></th>
                      
                  </tr>

              </thead>
              <tbody id="tbodystudent">
                 @if(isset($ds_lop))
                 <?php $STT = 0; ?>
                @foreach($ds_lop as $data)
                <tr>
                  <th >{{++$STT}}</th>
                  <td >{{$data->tenlop}}</td>
                  <td>
                     {{ count($sl_SVlop->where("lop_id", $data->lopid)) }}
                  </td>
                 <td>
                {{number_format(($sotien_theolop->where("lop_id", $data->lopid))->sum("giatri"),0,',','.')}} VNĐ
                   
                 </td>
                 <td>
                   <?php
                          if(isset($getNamHoc)){
                            ?>
                            <a href="{{route('thongke.lop.theo.nammoi',[$data->id, $getNamHoc->id])}}" class="btn btn-success"  title="Xem chi tiết năm học"><i class="fa fa-search"></i></a>
                            <?php
                        
                          }
                          else{
                            ?>
                            <a href="{{route('thongke.lop.theo.hockymoi',[$data->id, $getHKNH->id])}}" class="btn btn-success"  title="Xem chi tiết học kỳ"><i class="fa fa-search"></i></a>
                            <?php 
                          }
                     ?>
                   
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
@endsection