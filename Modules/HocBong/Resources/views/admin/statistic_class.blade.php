@extends('admin.layout.master')
@section('title')
  @parent | Thống kê học bổng theo lớp
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
          <h2> <i class="fa fa-user-secret"></i>Thống kê học bổng của Lớp {{$tenlop->tenlop}}
            {{isset($getTenNH) ?  'Năm học '.$getTenNH->tennamhoc : $getTenHKNH->tenhockynamhoc}}
       </h2>
       <div class="pull-right">
        @if(isset($getTenNH))
          <a href="{{route('admin_hocbong_export',[$getTenNH->id,$tenlop->id])}}" class="btn btn-success student_import">
            <strong><i class="fa fa-download"></i> EXPORT PDF</strong>
          </a>
          @else
          <a href="{{route('admin_hocbong_export_hknh',[$getTenHKNH->id,$tenlop->id])}}" class="btn btn-success student_import">
            <strong><i class="fa fa-download"></i> EXPORT PDF</strong>
          </a>
          @endif
        </div>
        <div class="x_content">
        <div class="row">
          

          

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/graduates.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
            SỐ SINH VIÊN ĐÃ NHẬN HỌC BỔNG: {{count($soluong_hb)}} 
              </div>
            </div>
          </div>

          <div class="col-xm-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="row dash-box">
              <div class="row img">
                <img src="{{URL::asset('images/icons/class.png')}}" alt="" style="width: 50%;">
              </div>
              <div class="row title">
             TỔNG SỐ TIỀN ĐÃ NHẬN: {{number_format((isset($sotien_theolop) ? $sotien_theolop->sum("giatri") : 0), 0 , ',', '.')}} đ
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
            @if(isset($dssvByHocKy))
            <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
              <thead>
               
                  <tr class="filters">
                      <th width="10%">STT</th>
                      <th width="10%">MSSV</th>
                      <th width="23%">Tên sinh viên</th>
                      <th width="10%">Tên học bổng đã nhận</th>
                      
                     <th width="10%">Điểm học tập</th>
                     <th width="10%">Điểm rèn luyện</th>
                     
                      <th width="10%">Tổng giá trị đã trao</th>
                      <th></th>
                      
                  </tr>

  
              </thead>
              <tbody id="tbodystudent">
                 
                 <?php $STT = 0; ?>
                @foreach($dssvByHocKy as $data)
                <tr>
                  <th >{{++$STT}}</th>
                  <td >{{$data->mssv}}</td>
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
                  {{ number_format(($sotien_theolop->where("id_sinhvien", $data->id_sinhvien))->sum("giatri"), 0 , ',', '.') }}đ

                 </td>
                 <td>
                   <a href="{{route('hocbong.lichsu.sinhvien',$data->id_sinhvien)}}" class="btn btn-success"  title="Lịch sử học bổng"><i class="fa fa-university"></i></a>
                 </td>
                 
                </tr>
               @endforeach
             

              </tbody>
            </table>
             @endif

             @if(isset($dssvByNamHoc))
            <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
              <thead>
               
                  <tr class="filters">
                      <th width="10%">STT</th>
                      <th width="10%">MSSV</th>
                      <th width="23%">Tên sinh viên</th>
                      <th width="10%">Tên học bổng đã nhận</th>
                     
                      <th width="10%">Tổng giá trị đã trao</th>
                      <th></th>
                      
                  </tr>

  
              </thead>
              <tbody id="tbodystudent">
                 
                 <?php $STT = 0; ?>
                @foreach($dssvByNamHoc as $data)
                <tr>
                  <th >{{++$STT}}</th>
                  <td >{{$data->mssv}}</td>

                  <td >{{$data->hochulot}} {{$data->ten}}</td>
                  <td>
                     
                    @foreach($dshb as $hocbong)
                  @if($hocbong->id_sinhvien === $data->id_sinhvien)
                  {{$hocbong->HocBong->tenhb}}<br>
                  @endif
                  @endforeach
                  </td>
                 
                 <td>
                  {{ number_format(($sotien_theolop->where("id_sinhvien", $data->id_sinhvien))->sum("giatri"), 0 , ',', '.') }}đ

                 </td>
                 <td>
                   <a href="{{route('hocbong.lichsu.sinhvien',$data->id_sinhvien)}}" class="btn btn-success"  title="Lịch sử học bổng"><i class="fa fa-university"></i></a>
                 </td>
                 
                </tr>
               @endforeach
             

              </tbody>
            </table>
             @endif
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