@extends('subadmin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
        <h3> Danh sách tôn giáo </h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiTonGiaoModal" title="Thêm mới tôn giáo">
            <i class="fa fa-plus"></i> Thêm mới
        </button>
    </div>
    
    <!-- Page content - Danh sách tôn giáo -->
    <div class="page-content">
        @if(isset($DanhSach_TonGiao))
            @if(count($DanhSach_TonGiao)>0)
                <?php $STT = '0' ?>
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã tôn giáo</th>
                            <th>Tên tôn giáo</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($DanhSach_TonGiao as $TonGiao)
                            <tr>
                                <th>{{++$STT}}</th>
                                <td>{{$TonGiao->matongiao}}</td>
                                <td>{{$TonGiao->tentongiao}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatTonGiaoModal" title="Sửa" onclick="CapNhatTonGiao('{{$TonGiao->id}}', '{{$TonGiao->matongiao}}','{{$TonGiao->tentongiao}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_tongiao" href="{{route('tongiao_destroy',['id'=>$TonGiao->id])}}" Ten="{{$TonGiao->tentongiao}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiTonGiaoModal" title="Thêm mới tôn giáo">
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

    <!-- Modal thêm mới tôn giáo -->
    <div id="ThemMoiTonGiaoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới tôn giáo</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="form-group">
                        <label for="MaTonGiao"> Mã tôn giáo </label>
                        <input type="text" name="MaTonGiao" id="MaTonGiao" class="form-control" placeholder="Mã tôn giáo" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="TenTonGiao"> Tên tôn giáo </label>
                        <input type="text" name="TenTonGiao" id="TenTonGiao" class="form-control" placeholder="Tên tôn giáo" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_tongiao" href="{{ route('post_tongiao') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật tôn giáo -->
    <div id="CapNhatTonGiaoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin tôn giáo</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="ID_TonGiao_CapNhat" id="ID_TonGiao_CapNhat" type="text" class="hidden" hidden="true">
                    <div class="form-group">
                        <label for="MaTonGiao_CapNhat"> Mã tôn giáo </label>
                        <input type="text" name="MaTonGiao_CapNhat" id="MaTonGiao_CapNhat" class="form-control" placeholder="Mã tôn giáo" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="TenTonGiao_CapNhat"> Tên tôn giáo </label>
                        <input type="text" name="TenTonGiao_CapNhat" id="TenTonGiao_CapNhat" class="form-control" placeholder="Tên tôn giáo" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_tongiao" href="{{route('post_tongiao_update')}}"><i class="fa fa-save"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
@endsection