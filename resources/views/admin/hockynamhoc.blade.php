@extends('admin.layout.master')

@section('css')
    @parent
    <!-- iCheck -->
    <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">

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
                <h2> <i class="fa fa-calendar"></i> DANH SÁCH HỌC KỲ - NĂM HỌC </h2>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiHocKyNamHocModal" title="Thêm mới năm học">
                        <strong><i class="fa fa-plus"></i> Thêm mới </strong>
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    @if(isset($DanhSach_HocKyNamHoc))
                        <?php $STT = '0' ?>
                        <table id="datatable-buttons" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Học kỳ - Năm học</th>
                                    <th>Trạng thái</th>
                                    <th></th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($DanhSach_HocKyNamHoc as $HocKyNamHoc)
                                    <tr>
                                        <th class="text-center">{{++$STT}}</th>
                                        <td>{{$HocKyNamHoc->tenhockynamhoc}}</td>
                                        <td>
                                            @if($HocKyNamHoc->idtrangthaihocky == 2)
                                                <span class="label label-success"> {{$HocKyNamHoc->TenTrangThai}} </span>
                                            @else
                                                <span class="label label-info"> {{$HocKyNamHoc->TenTrangThai}} </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#CapNhatHocKyNamHocModal" title="Sửa" onclick="CapNhatHocKyNamHoc('{{$HocKyNamHoc->id}}', '{{$HocKyNamHoc->idhocky}}','{{$HocKyNamHoc->idnamhoc}}','{{$HocKyNamHoc->idtrangthaihocky}}')">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger remove_hockynamhoc" href="{{route('hockynamhoc_destroy',['id'=>$HocKyNamHoc->id])}}" Ten="{{$HocKyNamHoc->tenhockynamhoc}}" title="Xóa"><i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiHocKyNamHocModal" title="Thêm mới học kỳ năm học">
                                            <strong> <i class="fa fa-plus"></i> Thêm mới </strong>
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

    <!-- Modal thêm mới năm học -->
    <div id="ThemMoiHocKyNamHocModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới học kỳ - năm học</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <strong><label for="HocKy"><b> Học kỳ: </b></label></strong>
                        </div>
                        <div class="col-12 col-md-10">
                            @if(isset($DanhSach_HocKy))
                                @foreach($DanhSach_HocKy as $HocKy)
                                    <label for="HocKy{{$HocKy->id}}"> {{$HocKy->tenhocky}}</label>
                                    <input type="radio" id="HocKy{{$HocKy->id}}" class="HocKy flat" name="HocKy" value="{{$HocKy->id}}"> &ensp; &ensp; &ensp;
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <strong><label for="NamHoc"><b> Năm học: </b></label></strong>
                        </div>
                        <div class="col-12 col-md-10">
                            <select class="NamHoc form-control">
                                <option class="NamHoc" value="0"> ----- Chọn năm học ----- </option>
                                @if(isset($DanhSach_NamHoc))
                                    @foreach($DanhSach_NamHoc as $NamHoc)
                                    <option class="NamHoc" value="{{$NamHoc->id}}"> {{$NamHoc->tennamhoc}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <strong><label for="TrangThai"><b> Trạng thái: </b></label></strong>
                        </div>
                        <div class="col-12 col-md-10">
                            @if(isset($DanhSach_TrangThai))
                                @foreach($DanhSach_TrangThai as $TrangThai)
                                    <label for="TrangThai{{$TrangThai->id}}"> {{$TrangThai->TenTrangThai}} </label>
                                    <input type="radio" id="TrangThai{{$TrangThai->id}}" class="TrangThai flat" name="TrangThai" value="{{$TrangThai->id}}">&ensp;&ensp;&ensp;
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_hockynamhoc" href="{{ route('post_hockynamhoc') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật năm học -->
    <div id="CapNhatHocKyNamHocModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin học kỳ - năm học</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="ID_HocKyNamHoc_CapNhat" id="ID_HocKyNamHoc_CapNhat" type="text" class="hidden" hidden="true">
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <strong><label for="HocKy_CapNhat"><b> Học kỳ: </b></label></strong>
                        </div>
                        <div class="col-12 col-md-10">
                            @if(isset($DanhSach_HocKy))
                                @foreach($DanhSach_HocKy as $HocKy)
                                    <label for="HocKy{{$HocKy->id}}_CapNhat"> {{$HocKy->tenhocky}}</label>
                                    <input type="radio" id="HocKy{{$HocKy->id}}_CapNhat" class="HocKy_CapNhat flat" name="HocKy_CapNhat" value="{{$HocKy->id}}"> &ensp; &ensp; &ensp;
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <strong><label for="NamHoc_CapNhat"><b> Năm học: </b></label></strong>
                        </div>
                        <div class="col-12 col-md-10">
                            <select class="NamHoc_CapNhat form-control" id="NamHoc_CapNhat">
                                <option class="NamHoc_CapNhat" value="0"> ----- Chọn năm học ----- </option>
                                @if(isset($DanhSach_NamHoc))
                                    @foreach($DanhSach_NamHoc as $NamHoc)
                                    <option class="NamHoc_CapNhat" value="{{$NamHoc->id}}"> {{$NamHoc->tennamhoc}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <strong><label for="TrangThai_CapNhat"><b> Trạng thái: </b></label></strong>
                        </div>
                        <div class="col-12 col-md-10">
                            @if(isset($DanhSach_TrangThai))
                                @foreach($DanhSach_TrangThai as $TrangThai)
                                    <label for="TrangThai{{$TrangThai->id}}_CapNhat"> {{$TrangThai->TenTrangThai}} </label>
                                    <input type="radio" id="TrangThai{{$TrangThai->id}}_CapNhat" class="TrangThai_CapNhat flat" name="TrangThai_CapNhat" value="{{$TrangThai->id}}">&ensp;&ensp;&ensp;
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_hockynamhoc" href="{{route('post_hockynamhoc_update')}}"><i class="fa fa-save"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>

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