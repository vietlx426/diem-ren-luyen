@extends('subadmin.layout.master')
@section('title')
  @parent | Class
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
  <div class="row text-center">
    <h4>DANH SÁCH LỚP</h4>
  </div>
  <div class="row">
    <div class="x_panel">
      <div class="x_content">
        <div class="row">
          <table id="datatable-buttons" class="table table-striped table-bordered tableThoiGianDanhGia">
            <thead>
                <tr class="filters">
                    <th>#</th>
                    <th>TÊN</th>
                    <th>BẬC</th>
                    <th>HỆ</th>
                    <th>NGÀNH</th>
                    <th>BỘ MÔN</th>
                    <th>KHOA</th>
                </tr>
            </thead>
            <tbody id="tbodystudent">
              @if(isset($dsLop))
                <?php $STT = 0; ?>
                @foreach($dsLop as $lop)
                    <tr>
                        <th class="text-center-middle">{{++$STT}}</th>
                        <td> {{ $lop->tenlop }} </td>
                        <td> {{ $lop->nganh->bacdaotao->tenbac }} </td>
                        <td> {{ $lop->nganh->hedaotao->tenhe }} </td>
                        <td> {{ $lop->nganh->tennganh}} </td>
                        <td> {{ $lop->nganh->bomon->tenbomon}} </td>
                        <td> {{ $lop->nganh->bomon->khoa->tenkhoa}} </td>
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