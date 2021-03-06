@extends('subadmin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
        <h3> Danh sách loại điểm </h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiLoaiDiemModal" title="Thêm mới loại điểm">
            <i class="fa fa-plus"></i> Thêm mới
        </button>
    </div>
    
    <!-- Page content - Danh sách loại điểm -->
    <div class="page-content">
        @if(isset($DanhSach_LoaiDiem))
            @if(count($DanhSach_LoaiDiem)>0)
                <?php $STT = '0' ?>
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên loại điểm</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($DanhSach_LoaiDiem as $LoaiDiem)
                            <tr>
                                <th>{{++$STT}}</th>
                                <td>{{$LoaiDiem->tenloaidiem}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatLoaiDiemModal" title="Sửa" onclick="CapNhatLoaiDiem('{{$LoaiDiem->id}}', '{{$LoaiDiem->tenloaidiem}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_loaidiem" href="{{route('loaidiem_destroy',['id'=>$LoaiDiem->id])}}" Ten="{{$LoaiDiem->tenloaidiem}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiLoaiDiemModal" title="Thêm mới loại điểm">
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

    <!-- Modal thêm mới loại điểm -->
    <div id="ThemMoiLoaiDiemModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới loại điểm</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="form-group">
                        <label for="TenLoaiDiem"> Tên loại điểm </label>
                        <input type="text" name="TenLoaiDiem" id="TenLoaiDiem" class="form-control" placeholder="Tên loại điểm" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_loaidiem" href="{{ route('post_loaidiem') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật loại điểm -->
    <div id="CapNhatLoaiDiemModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin loại điểm</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="ID_LoaiDiem_CapNhat" id="ID_LoaiDiem_CapNhat" type="text" class="hidden" hidden="true">
                    <div class="form-group">
                        <label for="TenLoaiDiem_CapNhat"> Tên loại điểm </label>
                        <input type="text" name="TenLoaiDiem_CapNhat" id="TenLoaiDiem_CapNhat" class="form-control" placeholder="Tên loại điểm" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_loaidiem" href="{{route('post_loaidiem_update')}}"><i class="fa fa-save"></i> Lưu </button>
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