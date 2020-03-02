@extends('subadmin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
        <h3> Danh sách loại hoạt động sự kiện </h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiLoaiHDSKModal" title="Thêm mới loại hoạt động sự kiện">
            <i class="fa fa-plus"></i> Thêm mới
        </button>
    </div>
    
    <!-- Page content - Danh sách loại hoạt động sự kiện -->
    <div class="page-content">
        @if(isset($DanhSach_LoaiHoatDongSuKien))
            @if(count($DanhSach_LoaiHoatDongSuKien)>0)
                <?php $STT = '0' ?>
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã hoạt động sự kiện</th>
                            <th>Tên hoạt động sự kiện</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($DanhSach_LoaiHoatDongSuKien as $LoaiHDSK)
                            <tr>
                                <th>{{++$STT}}</th>
                                <td>{{$LoaiHDSK->maloaihoatdongsukien}}</td>
                                <td>{{$LoaiHDSK->tenloaihoatdongsukien}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatLoaiHDSKModal" title="Sửa" onclick="CapNhatLoaiHDSK('{{$LoaiHDSK->id}}', '{{$LoaiHDSK->maloaihoatdongsukien}}','{{$LoaiHDSK->tenloaihoatdongsukien}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_loaihdsk" href="{{route('loaihd_destroy',['id'=>$LoaiHDSK->id])}}" Ten="{{$LoaiHDSK->tenloaihoatdongsukien}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiLoaiHDSKModal" title="Thêm mới loại hoạt động sự kiện">
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

    <!-- Modal thêm mới loại hoạt động sự kiện -->
    <div id="ThemMoiLoaiHDSKModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới loại hoạt động sự kiện</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="form-group">
                        <label for="maloaihoatdongsukien"> Mã loại hoạt động sự kiện </label>
                        <input type="text" name="maloaihoatdongsukien" id="maloaihoatdongsukien" class="form-control" placeholder="Mã loại hoạt động sự kiện" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="tenloaihoatdongsukien"> Tên loại hoạt động sự kiện </label>
                        <input type="text" name="tenloaihoatdongsukien" id="tenloaihoatdongsukien" class="form-control" placeholder="Tên loại hoạt động sự kiện" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_loaihd" href="{{ route('post_loaihd') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật loại hoạt động sự kiện-->
    <div id="CapNhatLoaiHDSKModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin loại hoạt động sự kiện</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="idloaihoatdongsukien_capnhat" id="idloaihoatdongsukien_capnhat" type="text" class="hidden" hidden="true">
                    <div class="form-group">
                        <label for="maloaihoatdongsukien_capnhat"> Mã loại hoạt động sự kiện </label>
                        <input type="text" name="maloaihoatdongsukien_capnhat" id="maloaihoatdongsukien_capnhat" class="form-control" placeholder="Mã loại hoạt động sự kiện" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="tenloaihoatdongsukien_capnhat"> Tên loại hoạt động sự kiện </label>
                        <input type="text" name="tenloaihoatdongsukien_capnhat" id="tenloaihoatdongsukien_capnhat" class="form-control" placeholder="Tên loại hoạt sự kiện" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_loaihd" href="{{route('post_loaihd_update')}}"><i class="fa fa-save"></i> Lưu </button>
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