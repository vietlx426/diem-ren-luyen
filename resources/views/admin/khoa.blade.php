@extends('admin.layout.master')
@section('title')
    @parent | Faculty
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
                <h2> DANH SÁCH KHOA/PHÒNG </h2>
                <div class="pull-right">
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiKhoaModal" title="Thêm mới khoa">
                        <strong> <i class="fa fa-plus"></i> THÊM MỚI </strong>
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    @if(isset($DanhSach_Khoa))
                        <?php $STT = '0' ?>
                        <table id="datatable-buttons" class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Mã/Viết tắt</th>
                                    <th>Đơn vị</th>
                                    <th></th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($DanhSach_Khoa as $Khoa)
                                    <tr>
                                        <th class="text-center">{{++$STT}}</th>
                                        <td>{{$Khoa->makhoa}}</td>
                                        <td>{{$Khoa->tenkhoa}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#CapNhatKhoaModal" title="Sửa" onclick="CapNhatKhoa('{{$Khoa->id}}', '{{$Khoa->makhoa}}','{{$Khoa->tenkhoa}}')">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger remove_khoa" href="{{route('khoa_destroy',['id'=>$Khoa->id])}}" Ten="{{$Khoa->tenkhoa}}" title="Xóa"><i class="fa fa-trash"></i>
                                            </button>
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiKhoaModal" title="Thêm mới khoa">
                        <strong> <i class="fa fa-plus"></i> THÊM MỚI </strong>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thêm mới khoa -->
    <div id="ThemMoiKhoaModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <!-- <form action="" method="post" class="form-signin" accept-charset="utf-8"> -->
                    <div class="modal-header">
                        <div class="col-11 pull-left">
                            <h3>Thêm mới khoa</h3>
                        </div>
                        <div class="col-1 pull-right">
                            <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                    	@include('layout.block.message_validation')
                        <div class="form-group">
                            <label for="MaKhoa"> Mã/Tên viết tắt khoa </label>
                            <input type="text" name="MaKhoa" id="MaKhoa" class="form-control MaKhoa" placeholder="Mã khoa" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenKhoa"> Tên khoa </label>
                            <input type="text" name="TenKhoa" id="TenKhoa" class="form-control TenKhoa" placeholder="Tên khoa" autofocus>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary save_khoa" href="{{ route('post_khoa') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>

    <!-- Modal cập nhật khoa -->
    <div id="CapNhatKhoaModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <!-- <form action="" method="post" class="form-signin" accept-charset="utf-8"> -->
                    <div class="modal-header">
                        <div class="col-11 pull-left">
                            <h3>Cập nhật thông tin khoa</h3>
                        </div>
                        <div class="col-1 pull-right">
                            <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                    	@include('layout.block.message_validation')
                        <input name="ID_Khoa_CapNhat" id="ID_Khoa_CapNhat" type="text" class="hidden ID_Khoa_CapNhat" hidden="true">
                        <div class="form-group">
                            <label for="MaKhoa_CapNhat"> Mã/Tên viết tắt khoa </label>
                            <input type="text" name="MaKhoa_CapNhat" id="MaKhoa_CapNhat" class="form-control MaKhoa_CapNhat" placeholder="Mã khoa" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenKhoa_CapNhat"> Tên khoa </label>
                            <input type="text" name="TenKhoa_CapNhat" id="TenKhoa_CapNhat" class="form-control TenKhoa_CapNhat" placeholder="Tên khoa" autofocus>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary update_khoa" href="{{route('post_khoa_update')}}"><i class="fa fa-save"></i> Lưu </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                    </div>
                <!-- </form> -->
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
    
    <!-- Check Errors & Alert -->
    <script type="text/javascript" src="{!! URL::asset('js/khoa.js') !!}"></script>
@endsection