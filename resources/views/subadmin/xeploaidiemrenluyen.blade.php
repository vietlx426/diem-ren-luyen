@extends('subadmin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
        <h3> Danh sách xếp loại </h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiXepLoaiDiemRenLuyenModal" title="Thêm mới xếp loại">
            <i class="fa fa-plus"></i> Thêm mới
        </button>
    </div>
    
    <!-- Page content - Danh sách xếp loại -->
    <div class="page-content">
        @if(isset($DanhSach_XepLoaiDiemRenLuyen))
            @if(count($DanhSach_XepLoaiDiemRenLuyen)>0)
                <?php $STT = '0' ?>
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã xếp loại</th>
                            <th>Tên xếp loại</th>
                            <th>Điểm Min</th>
                            <th>Điểm Max</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($DanhSach_XepLoaiDiemRenLuyen as $XepLoaiDiemRenLuyen)
                            <tr>
                                <th>{{++$STT}}</th>
                                <td>{{$XepLoaiDiemRenLuyen->maxeploai}}</td>
                                <td>{{$XepLoaiDiemRenLuyen->tenxeploai}}</td>
                                <td>{{$XepLoaiDiemRenLuyen->mindiem}}</td>
                                <td>{{$XepLoaiDiemRenLuyen->maxdiem}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatXepLoaiDiemRenLuyenModal" title="Sửa" onclick="CapNhatXepLoaiDiemRenLuyen('{{$XepLoaiDiemRenLuyen->id}}', '{{$XepLoaiDiemRenLuyen->maxeploai}}', '{{$XepLoaiDiemRenLuyen->tenxeploai}}', '{{$XepLoaiDiemRenLuyen->mindiem}}', '{{$XepLoaiDiemRenLuyen->maxdiem}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_xeploaidiemrenluyen" href="{{route('xeploaidiemrenluyen_destroy',['id'=>$XepLoaiDiemRenLuyen->id])}}" Ten="{{$XepLoaiDiemRenLuyen->tenxeploai}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiXepLoaiDiemRenLuyenModal" title="Thêm mới xếp loại">
                                    <i class="fa fa-plus"></i> Thêm mới
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @else
                {{'Chưa có dữ liệu!'}}
            @endif
        @else
            {{'Không có thông tin!'}}
        @endif
    </div>

    <!-- Modal thêm mới xếp loại -->
    <div id="ThemMoiXepLoaiDiemRenLuyenModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới xếp loại</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="MaXepLoaiDiemRenLuyen"> Mã xếp loại </label>
                        <input type="text" name="MaXepLoaiDiemRenLuyen" id="MaXepLoaiDiemRenLuyen" class="form-control" placeholder="Mã xếp loại" autofocus>
                    </div>
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="TenXepLoaiDiemRenLuyen"> Tên xếp loại </label>
                        <input type="text" name="TenXepLoaiDiemRenLuyen" id="TenXepLoaiDiemRenLuyen" class="form-control" placeholder="Tên xếp loại" autofocus>
                    </div>
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="MinDiemXepLoaiDiemRenLuyen"> Điểm Min </label>
                        <input type="number" name="MinDiemXepLoaiDiemRenLuyen" id="MinDiemXepLoaiDiemRenLuyen" class="form-control" autofocus>
                    </div>
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="MaxDiemXepLoaiDiemRenLuyen"> Điểm Max </label>
                        <input type="number" name="MaxDiemXepLoaiDiemRenLuyen" id="MaxDiemXepLoaiDiemRenLuyen" class="form-control" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_xeploaidiemrenluyen" href="{{ route('post_xeploaidiemrenluyen') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật xếp loại -->
    <div id="CapNhatXepLoaiDiemRenLuyenModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin xếp loại</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="ID_XepLoaiDiemRenLuyen_CapNhat" id="ID_XepLoaiDiemRenLuyen_CapNhat" type="text" class="hidden" hidden="true">
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="MaXepLoaiDiemRenLuyen_CapNhat"> Mã xếp loại </label>
                        <input type="text" name="MaXepLoaiDiemRenLuyen_CapNhat" id="MaXepLoaiDiemRenLuyen_CapNhat" class="form-control" placeholder="Mã xếp loại" autofocus>
                    </div>
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="TenXepLoaiDiemRenLuyen_CapNhat"> Tên xếp loại </label>
                        <input type="text" name="TenXepLoaiDiemRenLuyen_CapNhat" id="TenXepLoaiDiemRenLuyen_CapNhat" class="form-control" placeholder="Tên xếp loại" autofocus>
                    </div>
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="MinDiemXepLoaiDiemRenLuyen_CapNhat"> Điểm Min </label>
                        <input type="number" name="MinDiemXepLoaiDiemRenLuyen_CapNhat" id="MinDiemXepLoaiDiemRenLuyen_CapNhat" class="form-control" autofocus>
                    </div>
                    <div class="col-sm-12 col-md-6 form-group">
                        <label for="MaxDiemXepLoaiDiemRenLuyen_CapNhat"> Điểm Max </label>
                        <input type="number" name="MaxDiemXepLoaiDiemRenLuyen_CapNhat" id="MaxDiemXepLoaiDiemRenLuyen_CapNhat" class="form-control" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_xeploaidiemrenluyen" href="{{route('post_xeploaidiemrenluyen_update')}}"><i class="fa fa-save"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
@endsection