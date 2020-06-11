@extends('giaovukhoa.layout.master')
@section('title')
  @parent | Class
@endsection

@section('css')
  <link rel="stylesheet" href="{{URL::asset('css\mystyle.css')}}">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
    <div class="pull-right">
          <a href="{{route('giaovukhoa.download.excel',$getHKNH->id)}}" class="btn btn-success student_import">
            <strong><i class="fa fa-download"></i>TẢI THỐNG KÊ</strong>
          </a>
        </div>
      <div class="x_title">
          <h2> <i class="fa fa-graduation-cap"></i> DANH SÁCH LỚP - SINH VIÊN - HỌC BỔNG {{isset($getHKNH) ? $getHKNH->tenhockynamhoc : ''}}</h2>
          <div class="clearfix"></div>
      </div>
      
      <div class="x_content" >
       <table id="tbl_thongbao" class="table table-striped table-bordered" >
       <thead>
                  <tr class="filters">
                      <th >Danh sách thông báo</th>                                   
                   </tr>
                </thead> 

          <tbody >
           @isset($ThongBao)
           @foreach($ThongBao as $data)
              <tr>
                <td class="">
                  <a href="{{route('giaovukhoa.thongbao',[$data->idthongbao,$data->slug])}}">
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
        <br>
        <hr>
        <form>
      <div class="x_content">
        <div class="row col-12 text-center">
          <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-3 col-lg-offset-3 text-center">
            
            
            
            
            <div >
              <h4 class="text-center">HỌC KỲ, NĂM HỌC</h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                  <label class="control-label">Học kỳ, năm học</label>
              <select name="hknh" id="hknh" class="form-control">
                <option value="">--- Tất cả ---</option>
                
                  
                   @foreach($ds_hknh as $hknh)
                      <option value="{{$hknh->id}}" {{\Request::get('hknh')==$hknh->id ? "selected='selected'" : ""}}>{{$hknh->tenhockynamhoc}}</option>
                    @endforeach
              </select>
              </div>
          </div>
            
          
            <div id="divSearch" class="form-group">
              <button class="btn btn-primary btn-search-user-group"><i class="fa fa-search"></i> Tìm </button>
            </div>
          </div>
         
        </div>
      </div>
      </form>
        <br>  
      <div class="x_content">
        <div class="row">
          @if(isset($dsLop))
            @foreach($dsLop as $lop)
              <div class="col-xm-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" title="Click để đánh giá điểm rèn luyện cho lớp {{$lop->tenlop}}">
                <div class="row dash-box">
                  <a href="{{route('giaovukhoa.hocbong.sinhvien', [$lop->id,$getHKNH->id])}}">
                    <div class="row img">
                      <img src="{{URL::asset('images/icons/checklist.png')}}" alt="" style="width: 70%;">
                    </div>
                    <div class="row title">
                      {{$lop->tenlop}}
                    </div>
                  </a>
                </div>
              </div>
            @endforeach
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
    
    <script type="text/javascript">
      $('#tbl_thongbao').dataTable();
    </script>

@endsection