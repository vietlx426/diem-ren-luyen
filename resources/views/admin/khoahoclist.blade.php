@extends('admin.layout.master')
@section('title')
    @parent | Khóa học
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
                <h2> DANH SÁCH KHÓA HỌC </h2>
                <div class="pull-right">
                    <a href="{{route('admin_khoahoc_create')}}" class="btn btn-primary" title="Thêm mới khóa học">
                        <strong><i class="fa fa-plus"></i> THÊM MỚI</strong>
                    </a>
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
                    @if(isset($dsKhoaHoc))
                        <?php $STT = '0' ?>
                        <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Khóa học</th>
                                    <th>Niên học</th>
                                    <th>Bậc đào tạo</th>
                                    <th></th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($dsKhoaHoc as $khoaHoc)
                                    <tr>
                                        <th class="text-center">{{++$STT}}</th>
                                        <td>{{$khoaHoc->tenkhoahoc}}</td>
                                        <td>{{$khoaHoc->nambatdau . " - " . $khoaHoc->namketthuc}}</td>
                                        <td>{{$khoaHoc->bacdaotao->tenbac}}</td>
                                        <td class="text-center">
                                            <a href="{{route('admin_khoahoc_edit', ['id'=>$khoaHoc->id])}}" class="btn btn-warning" title="Sửa khóa học"> <i class="fa fa-edit"></i> </a>
                                            <a href="{{route('admin_khoahoc_destroy', ['id'=>$khoaHoc->id])}}" class="btn btn-danger btn-remove" title="Xóa khóa học"> <i class="fa fa-trash"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        {{'Không có thông tin!'}}
                    @endif
                </div>
                <hr>
                <div class="pull-right">
                    <a href="{{route('admin_khoahoc_create')}}" class="btn btn-primary" title="Thêm mới khóa học">
                        <strong><i class="fa fa-plus"></i> THÊM MỚI</strong>
                    </a>
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