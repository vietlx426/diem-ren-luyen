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
                <h2> DANH SÁCH TÔN GIÁO </h2>
                <div class="pull-right">
                   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiTonGiaoModal" title="Thêm mới tôn giáo">
                        <strong><i class="fa fa-plus"></i> Thêm mới </strong>
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    @if(isset($DanhSach_TonGiao))
                        <?php $STT = '0' ?>
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Mã tôn giáo</th>
                                    <th>Tên tôn giáo</th>
                                    <th></th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($DanhSach_TonGiao as $TonGiao)
                                    <tr>
                                        <th class="text-center">{{++$STT}}</th>
                                        <td>{{$TonGiao->matongiao}}</td>
                                        <td>{{$TonGiao->tentongiao}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#CapNhatTonGiaoModal" title="Sửa" onclick="CapNhatTonGiao('{{$TonGiao->id}}', '{{$TonGiao->matongiao}}','{{$TonGiao->tentongiao}}')">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger remove_tongiao" href="{{route('tongiao_destroy',['id'=>$TonGiao->id])}}" Ten="{{$TonGiao->tentongiao}}" title="Xóa"><i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiTonGiaoModal" title="Thêm mới tôn giáo">
                                            <strong><i class="fa fa-plus"></i> Thêm mới </strong>
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        {{'Không có thông tin!'}}
                    @endif
                </div>
            </div>
        </div>
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