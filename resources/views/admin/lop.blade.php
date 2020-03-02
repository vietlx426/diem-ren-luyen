@extends('admin.layout.master')
@section('title')
    @parent | Majors
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
                <h2> DANH SÁCH LỚP </h2>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiLopModal" title="Thêm mới lớp">
                        <strong><i class="fa fa-plus"></i> Thêm mới</strong>
                    </button>

                    <a href="{{route('admin_lop_import_show')}}" class="btn btn-warning" title="Import lớp từ danh sách (file)">
                        <strong><i class="fa fa-upload"></i> Import</strong>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    @if(isset($DanhSach_Lop))
                        <?php $STT = '0' ?>
                        <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Lớp</th>
                                    <th>Ngành</th>
                                    <th>Bậc đào tạo</th>
                                    <th>Hệ đào tạo</th>
                                    <th class="text-center">Khóa học</th>
                                    <th></th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($DanhSach_Lop as $Lop)
                                    <tr>
                                        <th class="text-center">{{++$STT}}</th>
                                        <td>{{$Lop->tenlop}}</td>
                                        <td>{{$Lop->nganh->tennganh}}</td>
                                        <td>{{$Lop->nganh->bacdaotao->tenbac}}</td>
                                        <td>{{$Lop->nganh->hedaotao->tenhe}}</td>
                                        <td class="text-center">{{$Lop->khoahoc->nambatdau . ' - ' . $Lop->khoahoc->namketthuc }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#CapNhatLopModal" title="Sửa" onclick="CapNhatLop('{{$Lop->id}}', '{{$Lop->malop}}','{{$Lop->tenlop}}', '{{$Lop->khoahoc_id}}', '{{$Lop->nganh_id}}')">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger remove_lop" href="{{route('lop_destroy',['id'=>$Lop->id])}}" Ten="{{$Lop->tenlop}}" title="Xóa"><i class="fa fa-trash"></i>
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiLopModal" title="Thêm mới lớp">
                        <strong><i class="fa fa-plus"></i> Thêm mới</strong>
                    </button>
                    <a href="{{route('admin_lop_import_show')}}" class="btn btn-warning" title="Import lớp từ danh sách (file)">
                        <strong><i class="fa fa-upload"></i> Import</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thêm mới lớp -->
    <div id="ThemMoiLopModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <!-- <form action="" method="post" class="form-signin" accept-charset="utf-8"> -->
                    <div class="modal-header">
                        <div class="col-11 pull-left">
                            <h3>Thêm mới lớp</h3>
                        </div>
                        <div class="col-1 pull-right">
                            <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                    	@include('layout.block.message_validation')
                        <div class="form-group">
                            <label for="MaLop"> Mã/Viết tắt </label>
                            <input type="text" name="MaLop" id="MaLop" class="form-control MaLop" placeholder="Mã lớp" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenLop"> Tên lớp </label>
                            <input type="text" name="TenLop" id="TenLop" class="form-control TenLop" placeholder="Tên lớp" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="IDKhoaHoc"> Khóa học </label>
                            <select name="IDKhoaHoc" id="IDKhoaHoc" class="IDKhoaHoc KhoaHoc form-control">
                            @if(isset($DanhSach_KhoaHoc))
                                <option value="0"> --- Chọn khóa --- </option>
                                @foreach($DanhSach_KhoaHoc as $KhoaHoc)
                                    <option value="{{$KhoaHoc->id}}"> {{$KhoaHoc->tenkhoahoc}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="IDNganh"> Ngành </label>
                            <select name="IDNganh" id="IDNganh" class="IDNganh Nganh form-control">
                            @if(isset($DanhSach_Nganh))
                                <option value="0"> --- Chọn ngành --- </option>
                                @foreach($DanhSach_Nganh as $Nganh)
                                    <option value="{{$Nganh->id}}"> {{$Nganh->tennganh}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary save_lop" href="{{ route('post_lop') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>

    <!-- Modal cập nhật lớp -->
    <div id="CapNhatLopModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="" method="post" class="form-signin" accept-charset="utf-8">
                    <div class="modal-header">
                        <div class="col-11 pull-left">
                            <h3>Cập nhật thông tin lớp</h3>
                        </div>
                        <div class="col-1 pull-right">
                            <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                    	@include('layout.block.message_validation_update')
                        <input name="ID_Lop_CapNhat" id="ID_Lop_CapNhat" type="text" class="hidden ID_Lop_CapNhat" hidden="true">
                        <div class="form-group">
                            <label for="MaLop_CapNhat"> Mã lớp </label>
                            <input type="text" name="MaLop_CapNhat" id="MaLop_CapNhat" class="form-control MaLop_CapNhat" placeholder="Mã lớp" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenLop_CapNhat"> Tên lớp </label>
                            <input type="text" name="TenLop_CapNhat" id="TenLop_CapNhat" class="form-control TenLop_CapNhat" placeholder="Tên lớp" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="IDKhoaHoc_CapNhat"> Khóa học </label>
                            <select name="IDKhoaHoc_CapNhat" id="IDKhoaHoc_CapNhat" class="IDKhoaHoc_CapNhat KhoaHoc form-control">
                            @if(isset($DanhSach_KhoaHoc))
                                @foreach($DanhSach_KhoaHoc as $KhoaHoc)
                                    <option value="{{$KhoaHoc->id}}"> {{$KhoaHoc->tenkhoahoc}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="IDNganh_CapNhat"> Ngành </label>
                            <select name="IDNganh_CapNhat" id="IDNganh_CapNhat" class="IDNganh_CapNhat Nganh form-control">
                            @if(isset($DanhSach_Nganh))
                                @foreach($DanhSach_Nganh as $Nganh)
                                    <option value="{{$Nganh->id}}"> {{$Nganh->tennganh}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary update_lop" href="{{route('post_lop_update')}}"><i class="fa fa-save"></i> Lưu </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                    </div>
                </form>
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
    <script type="text/javascript" src="{!! URL::asset('js/lop.js') !!}"></script>
@endsection