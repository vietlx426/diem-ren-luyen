@extends('admin.layout.master')

@section('css')
    @parent
    <!-- Datatables -->
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2> DANH SÁCH HỆ ĐÀO TẠO </h2>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiHeDaoTaoModal" title="Thêm mới hệ đào tạo">
                        <strong><i class="fa fa-plus"></i> Thêm mới </strong>
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    @if(isset($DanhSach_HeDaoTao))
                        <?php $STT = '0' ?>
                        <table id="datatable-buttons" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Mã hệ đào tạo</th>
                                    <th>Tên hệ đào tạo</th>
                                    <th></th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($DanhSach_HeDaoTao as $HeDaoTao)
                                    <tr>
                                        <th class="text-center">{{++$STT}}</th>
                                        <td>{{$HeDaoTao->mahe}}</td>
                                        <td>{{$HeDaoTao->tenhe}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#CapNhatHeDaoTaoModal" title="Sửa" onclick="CapNhatHeDaoTao('{{$HeDaoTao->id}}', '{{$HeDaoTao->mahe}}','{{$HeDaoTao->tenhe}}')">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger remove_hedaotao" href="{{route('hedaotao_destroy',['id'=>$HeDaoTao->id])}}" Ten="{{$HeDaoTao->tenhe}}" title="Xóa"><i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        {{'Không có thông tin!'}}
                    @endif
                </div>
            </div>
        </div>
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
    <!-- Datatables -->
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/pdfmake/build/vfs_fonts.js')}}"></script>

    <!-- Check Errors & Alert -->
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
@endsection