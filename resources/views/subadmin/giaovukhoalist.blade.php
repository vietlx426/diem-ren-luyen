@extends('subadmin.layout.master')
@section('title')
  @parent | Groups
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
        <h2> <i class="fa fa-sun-o"></i> DANH SÁCH GIÁO VỤ KHOA</h2>
        <div class="pull-right">
          <a href=" {{route('subadmin_giaovukhoa_create')}} " class="btn btn-primary"><strong><i class="fa fa-plus"></i> THÊM </strong></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-12 col-md-12">
            <!-- Block error message -->
            @include('layout.block.message_flash')
          </div>
        </div>
        <div class="row">
          <table id="datatable-buttons" class="table table-striped table-bordered tableThoiGianDanhGia">
            <thead>
                <tr class="filters">
                    <th class="text-center">#</th>
                    <th>MÃ CBGV</th>
                    <th>HỌ VÀ TÊN</th>
                    <!-- <th>ĐIỆN THOẠI</th> -->
                    <th>EMAIL</th>
                    <th>KHOA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbodystudent">
              @if(isset($dsGiaoVuKhoa))
                <?php $STT = 0; ?>
                @foreach($dsGiaoVuKhoa as $giaoVuKhoa)
                    <tr>
                        <th class="text-center">{{++$STT}}</th>
                        <td> {{ $giaoVuKhoa->cbgv->macanbogiangvien }} </td>
                        <td> {{ $giaoVuKhoa->cbgv->hochulot . ' ' . $giaoVuKhoa->cbgv->ten}} </td>
                        <!-- <td> {{ $giaoVuKhoa->cbgv->dienthoaicanhan }} </td> -->
                        <td> {{ $giaoVuKhoa->cbgv->email }} </td>
                        <td> {{ $giaoVuKhoa->khoa->tenkhoa }} </td>
                        <td class="text-center" title="Xóa giáo vụ khoa">
                          <a href="{{route('subadmin_giaovukhoa_updatestatus', ['id'=>$giaoVuKhoa->id])}}" class="btn btn-danger btn-remove"><i class="fa fa-remove"></i></a>
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

    <script>
      $('.btn-remove').click(function(e){
        if(!confirm("Bạn có muốn xóa?"))
        {
            e.stopPropagation();
            e.preventDefault();
        }
      });
    </script>
@endsection