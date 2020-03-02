@extends('subadmin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
        <h3> Danh sách trạng thái tiêu chí </h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiTrangThaiTieuChiModal" title="Thêm mới trạng thái tiêu chí">
            <i class="fa fa-plus"></i> Thêm mới
        </button>
    </div>
    
    <!-- Page content - Danh sách trạng thái tiêu chí -->
    <div class="page-content">
        @if(isset($DanhSach_TrangThaiTieuChi))
            @if(count($DanhSach_TrangThaiTieuChi)>0)
                <?php $STT = '0' ?>
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên trạng thái tiêu chí</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($DanhSach_TrangThaiTieuChi as $TrangThaiTieuChi)
                            <tr>
                                <th>{{++$STT}}</th>
                                <td>{{$TrangThaiTieuChi->tentrangthai}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatTrangThaiTieuChiModal" title="Sửa" onclick="CapNhatTrangThaiTieuChi('{{$TrangThaiTieuChi->id}}', '{{$TrangThaiTieuChi->tentrangthai}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_trangthaitieuchi" href="{{route('trangthaitieuchi_destroy',['id'=>$TrangThaiTieuChi->id])}}" Ten="{{$TrangThaiTieuChi->tentrangthai}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiTrangThaiTieuChiModal" title="Thêm mới trạng thái tiêu chí">
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

    <!-- Modal thêm mới trạng thái tiêu chí -->
    <div id="ThemMoiTrangThaiTieuChiModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới trạng thái tiêu chí</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="form-group">
                        <label for="TenTrangThaiTieuChi"> Tên trạng thái tiêu chí </label>
                        <input type="text" name="TenTrangThaiTieuChi" id="TenTrangThaiTieuChi" class="form-control" placeholder="Tên trạng thái tiêu chí" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_trangthaitieuchi" href="{{ route('post_trangthaitieuchi') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật trạng thái tiêu chí -->
    <div id="CapNhatTrangThaiTieuChiModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin trạng thái tiêu chí</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="ID_TrangThaiTieuChi_CapNhat" id="ID_TrangThaiTieuChi_CapNhat" type="text" class="hidden" hidden="true">
                    <div class="form-group">
                        <label for="TenTrangThaiTieuChi_CapNhat"> Tên trạng thái tiêu chí </label>
                        <input type="text" name="TenTrangThaiTieuChi_CapNhat" id="TenTrangThaiTieuChi_CapNhat" class="form-control" placeholder="Tên trạng thái tiêu chí" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_trangthaitieuchi" href="{{route('post_trangthaitieuchi_update')}}"><i class="fa fa-save"></i> Lưu </button>
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