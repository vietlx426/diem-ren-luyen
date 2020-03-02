@extends('subadmin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
        <h3> Danh sách bậc đào tạo </h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiBacDaoTaoModal" title="Thêm mới bậc đào tạo">
            <i class="fa fa-plus"></i> Thêm mới
        </button>
    </div>
    
    <!-- Page content - Danh sách bậc đào tạo -->
    <div class="page-content">
        @if(isset($DanhSach_BacDaoTao))
            @if(count($DanhSach_BacDaoTao)>0)
                <?php $STT = '0' ?>
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã bậc đào tạo</th>
                            <th>Tên bậc đào tạo</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($DanhSach_BacDaoTao as $BacDaoTao)
                            <tr>
                                <th>{{++$STT}}</th>
                                <td>{{$BacDaoTao->mabac}}</td>
                                <td>{{$BacDaoTao->tenbac}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatBacDaoTaoModal" title="Sửa" onclick="CapNhatBacDaoTao('{{$BacDaoTao->id}}', '{{$BacDaoTao->mabac}}','{{$BacDaoTao->tenbac}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_bacdaotao" href="{{route('bacdaotao_destroy',['id'=>$BacDaoTao->id])}}" Ten="{{$BacDaoTao->tenbac}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiBacDaoTaoModal" title="Thêm mới bậc đào tạo">
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

    <!-- Modal thêm mới bậc đào tạo -->
    <div id="ThemMoiBacDaoTaoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới bậc đào tạo</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="form-group">
                        <label for="MaBacDaoTao"> Mã bậc đào tạo </label>
                        <input type="text" name="MaBacDaoTao" id="MaBacDaoTao" class="form-control" placeholder="Mã bậc đào tạo" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="TenBacDaoTao"> Tên bậc đào tạo </label>
                        <input type="text" name="TenBacDaoTao" id="TenBacDaoTao" class="form-control" placeholder="Tên bậc đào tạo" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_bacdaotao" href="{{ route('post_bacdaotao') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật bậc đào tạo -->
    <div id="CapNhatBacDaoTaoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin bậc đào tạo</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="ID_BacDaoTao_CapNhat" id="ID_BacDaoTao_CapNhat" type="text" class="hidden" hidden="true">
                    <div class="form-group">
                        <label for="MaBacDaoTao_CapNhat"> Mã bậc đào tạo </label>
                        <input type="text" name="MaBacDaoTao_CapNhat" id="MaBacDaoTao_CapNhat" class="form-control" placeholder="Mã bậc đào tạo" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="TenBacDaoTao_CapNhat"> Tên bậc đào tạo </label>
                        <input type="text" name="TenBacDaoTao_CapNhat" id="TenBacDaoTao_CapNhat" class="form-control" placeholder="Tên bậc đào tạo" autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_bacdaotao" href="{{route('post_bacdaotao_update')}}"><i class="fa fa-save"></i> Lưu </button>
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