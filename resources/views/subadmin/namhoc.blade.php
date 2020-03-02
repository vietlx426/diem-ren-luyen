@extends('subadmin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
        <h3> Danh sách năm học </h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiNamHocModal" title="Thêm mới năm học">
            <i class="fa fa-plus"></i> Thêm mới
        </button>
    </div>

    <!-- Page content - Danh sách năm học -->
    <div class="page-content">
        @if(isset($DanhSach_NamHoc))
            @if(count($DanhSach_NamHoc)>0)
                <?php $STT = '0' ?>
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã</th>
                            <th>Năm học</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($DanhSach_NamHoc as $NamHoc)
                            <tr>
                                <th>{{++$STT}}</th>
                                <td>{{$NamHoc->manamhoc}}</td>
                                <td>{{$NamHoc->tennamhoc}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatNamHocModal" title="Sửa" onclick="CapNhatNamHoc('{{$NamHoc->id}}', '{{$NamHoc->manamhoc}}','{{$NamHoc->tennamhoc}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_namhoc" href="{{route('namhoc_destroy',['id'=>$NamHoc->id])}}" Ten="{{$NamHoc->tennamhoc}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiNamHocModal" title="Thêm mới năm học">
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

    <!-- Modal thêm mới năm học -->
    <div id="ThemMoiNamHocModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới năm học</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="form-group">
                        <label for="MaNamHoc"> Mã năm học </label>
                        <input type="text" name="MaNamHoc" id="MaNamHoc" class="form-control" placeholder="Mã năm học" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="TenNamHoc"> Tên năm học </label>
                        <input type="text" name="TenNamHoc" id="TenNamHoc" class="form-control" placeholder="Tên năm học" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_namhoc" href="{{ route('post_namhoc') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật năm học -->
    <div id="CapNhatNamHocModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin năm học</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="ID_NamHoc_CapNhat" id="ID_NamHoc_CapNhat" type="text" class="hidden" hidden="true">
                    <div class="form-group">
                        <label for="MaNamHoc_CapNhat"> Mã năm học </label>
                        <input type="text" name="MaNamHoc_CapNhat" id="MaNamHoc_CapNhat" class="form-control" placeholder="Mã năm học" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="TenNamHoc_CapNhat"> Tên năm học </label>
                        <input type="text" name="TenNamHoc_CapNhat" id="TenNamHoc_CapNhat" class="form-control" placeholder="Tên năm học" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_namhoc" href="{{route('post_namhoc_update')}}"><i class="fa fa-save"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
@endsection