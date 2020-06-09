@extends('giaovukhoa.layout.master')
@section('title')
 @parent | Student
@endsection
@section('css')
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
        <h2> <i class="fa fa-graduation-cap"></i> Danh sách sinh viên nhận học bổng</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <form>
      <div class="x_content">
        <div class="row col-12 text-center">
          <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 text-center">
            
            
            
            
           <!--  <div >
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
          </div> -->
            
          
            <!-- <div id="divSearch" class="form-group">
              <button class="btn btn-primary btn-search-user-group"><i class="fa fa-search"></i> Tìm </button>
            </div> -->
          </div>
          <!-- /.col -->
        </div>
      </div>
      </form>
      <div class="x_content">
        <table id="tbl_sinhvien" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">MSSV</th>
              <th>Họ tên</th>
              <th>Email</th>
              <th>Số lượng học bổng đã nhận</th>
              <th class="text-center"></th>
            </tr>
          </thead>
          <tbody>
            <?php $STT = 0; ?>
            @foreach($dsSinhVien as $sinhVien)
              <tr>
                <td class="text-center">{{++$STT}}</td>
                <td class="text-center">{{$sinhVien->mssv}}</td>
                <td>{{$sinhVien->hochulot . " ". $sinhVien->ten}}</td>
                <td>{{$sinhVien->email_agu}}</td>
                <td>{{count($dsSinhVien->where("id_sinhvien", $sinhVien->id_sinhvien))}} </td>
                <td class="text-center"> <a  href="{{route('giaovukhoa.hocbong.lichsu', $sinhVien->id_sinhvien)}}" class="btn btn-info"> <i class="fa fa-info-circle"></i> </a> </td>
              </tr>
            @endforeach
          </tbody>
        </table>
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
      $('#tbl_sinhvien').dataTable();
    </script>
@endsection