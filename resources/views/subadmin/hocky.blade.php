@extends('subadmin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
        <h3> Danh sách học kỳ </h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiHocKyModal" title="Thêm mới học kỳ">
            <i class="fa fa-plus"></i> Thêm mới
        </button>
    </div>
    
    <!-- Page content - Danh sách học kỳ -->
    <div class="page-content">
        @if(isset($DanhSach_HocKy))
            @if(count($DanhSach_HocKy)>0)
                <?php $STT = '0' ?>
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã học kỳ</th>
                            <th>Tên học kỳ</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($DanhSach_HocKy as $HocKy)
                            <tr>
                                <th>{{++$STT}}</th>
                                <td>{{$HocKy->mahocky}}</td>
                                <td>{{$HocKy->tenhocky}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatHocKyModal" title="Sửa" onclick="CapNhatHocKy('{{$HocKy->id}}', '{{$HocKy->mahocky}}','{{$HocKy->tenhocky}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_hocky" href="{{route('hocky_destroy',['id'=>$HocKy->id])}}" Ten="{{$HocKy->tenhocky}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiHocKyModal" title="Thêm mới học kỳ">
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

    <!-- Modal thêm mới học kỳ -->
    <div id="ThemMoiHocKyModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới học kỳ</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="form-group">
                        <label for="MaHocKy"> Mã học kỳ </label>
                        <input type="text" name="MaHocKy" id="MaHocKy" class="form-control" placeholder="Mã học kỳ" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="TenHocKy"> Tên học kỳ </label>
                        <input type="text" name="TenHocKy" id="TenHocKy" class="form-control" placeholder="Tên học kỳ" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_hocky" href="{{ route('post_hocky') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật học kỳ -->
    <div id="CapNhatHocKyModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin học kỳ</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="ID_HocKy_CapNhat" id="ID_HocKy_CapNhat" type="text" class="hidden" hidden="true">
                    <div class="form-group">
                        <label for="MaHocKy_CapNhat"> Mã học kỳ </label>
                        <input type="text" name="MaHocKy_CapNhat" id="MaHocKy_CapNhat" class="form-control" placeholder="Mã học kỳ" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="TenHocKy_CapNhat"> Tên học kỳ </label>
                        <input type="text" name="TenHocKy_CapNhat" id="TenHocKy_CapNhat" class="form-control" placeholder="Tên học kỳ" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_hocky" href="{{route('post_hocky_update')}}"><i class="fa fa-save"></i> Lưu </button>
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