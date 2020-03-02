@extends('admin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
        <h3> Danh sách trạng thái học kỳ </h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiTrangThaiHocKyModal" title="Thêm mới">
            <i class="fa fa-plus"></i> Thêm mới
        </button>
    </div>
    
    <!-- Page content - Danh sách trạng thái -->
    <div class="page-content">
        @if(isset($DanhSach_TrangThaiHocKy))
            @if(count($DanhSach_TrangThaiHocKy)>0)
                <?php $STT = '0' ?>
                <table id="tblTrangThaiHocKy" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody id="tbodyTrangThaiHocKy">
                        @foreach($DanhSach_TrangThaiHocKy as $TrangThaiHocKy)
                            <tr>
                                <th>{{++$STT}}</th>
                                <td>{{$TrangThaiHocKy->TenTrangThai}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatTrangThaiHocKyModal" title="Sửa" onclick="CapNhatTrangThaiHocKy('{{$TrangThaiHocKy->id}}','{{$TrangThaiHocKy->TenTrangThai}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_trangthaihocky" href="{{route('trangthaihocky_destroy',['id'=>$TrangThaiHocKy->id])}}" ID_TT = "{{$TrangThaiHocKy->id}}" Ten="{{$TrangThaiHocKy->TenTrangThai}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiTrangThaiHocKyModal" title="Thêm mới">
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

    <!-- Modal thêm mới trạng thái học kỳ -->
    <div id="ThemMoiTrangThaiHocKyModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới trạng thái học kỳ</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="form-group">
                        <label for="TenTrangThaiHocKy"> Trạng thái học kỳ </label>
                        <div>
                            <input type="text" name="TenTrangThaiHocKy" id="TenTrangThaiHocKy" class="form-control" placeholder="Tên trạng thái học kỳ" autofocus>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_trangthaihocky" href="{{ route('post_trangthaihocky') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật trạng thái học kỳ -->
    <div id="CapNhatTrangThaiHocKyModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin trạng thái</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="ID_TrangThaiHocKy_CapNhat" id="ID_TrangThaiHocKy_CapNhat" type="text" class="hidden" hidden="true">
                    <div class="form-group">
                        <label for="TenTrangThaiHocKy_CapNhat"> Trạng thái học kỳ </label>
                        <input type="text" name="TenTrangThaiHocKy_CapNhat" id="TenTrangThaiHocKy_CapNhat" class="form-control" placeholder="Tên trạng thái học kỳ" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_trangthaihocky" href="{{route('post_trangthaihocky_update')}}"><i class="fa fa-save"></i> Lưu </button>
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