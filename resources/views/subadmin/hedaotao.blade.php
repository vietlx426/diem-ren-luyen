@extends('subadmin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
        <h3> Danh sách hệ đào tạo </h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiHeDaoTaoModal" title="Thêm mới hệ đào tạo">
            <i class="fa fa-plus"></i> Thêm mới
        </button>
    </div>
    
    <!-- Page content - Danh sách hệ đào tạo -->
    <div class="page-content">
        @if(isset($DanhSach_HeDaoTao))
            @if(count($DanhSach_HeDaoTao)>0)
                <?php $STT = '0' ?>
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã hệ đào tạo</th>
                            <th>Tên hệ đào tạo</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($DanhSach_HeDaoTao as $HeDaoTao)
                            <tr>
                                <th>{{++$STT}}</th>
                                <td>{{$HeDaoTao->mahe}}</td>
                                <td>{{$HeDaoTao->tenhe}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatHeDaoTaoModal" title="Sửa" onclick="CapNhatHeDaoTao('{{$HeDaoTao->id}}', '{{$HeDaoTao->mahe}}','{{$HeDaoTao->tenhe}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_hedaotao" href="{{route('hedaotao_destroy',['id'=>$HeDaoTao->id])}}" Ten="{{$HeDaoTao->tenhe}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiHeDaoTaoModal" title="Thêm mới hệ đào tạo">
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

    <!-- Modal thêm mới hệ đào tạo -->
    <div id="ThemMoiHeDaoTaoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới hệ đào tạo</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="form-group">
                        <label for="MaHeDaoTao"> Mã hệ đào tạo </label>
                        <input type="text" name="MaHeDaoTao" id="MaHeDaoTao" class="form-control" placeholder="Mã hệ đào tạo" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="TenHeDaoTao"> Tên hệ đào tạo </label>
                        <input type="text" name="TenHeDaoTao" id="TenHeDaoTao" class="form-control" placeholder="Tên hệ đào tạo" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_hedaotao" href="{{ route('post_hedaotao') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật hệ đào tạo -->
    <div id="CapNhatHeDaoTaoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin hệ đào tạo</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="ID_HeDaoTao_CapNhat" id="ID_HeDaoTao_CapNhat" type="text" class="hidden" hidden="true">
                    <div class="form-group">
                        <label for="MaHeDaoTao_CapNhat"> Mã hệ đào tạo </label>
                        <input type="text" name="MaHeDaoTao_CapNhat" id="MaHeDaoTao_CapNhat" class="form-control" placeholder="Mã hệ đào tạo" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="TenHeDaoTao_CapNhat"> Tên hệ đào tạo </label>
                        <input type="text" name="TenHeDaoTao_CapNhat" id="TenHeDaoTao_CapNhat" class="form-control" placeholder="Tên hệ đào tạo" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_hedaotao" href="{{route('post_hedaotao_update')}}"><i class="fa fa-save"></i> Lưu </button>
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