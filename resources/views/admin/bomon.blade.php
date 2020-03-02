@extends('admin.layout.master')
@section('title')
    @parent | Department
@endsection

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
                <h2> DANH SÁCH BỘ MÔN/TỔ </h2>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiBoMonModal" title="Thêm mới bộ môn">
                        <strong> <i class="fa fa-plus"></i> Thêm mới </strong>
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    @if(isset($DanhSach_BoMon))
                        @if(count($DanhSach_BoMon)>0)
                            <?php $STT = '0' ?>
                            <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
                                 <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Mã</th>
                                        <th>Bộ môn</th>
                                        <th>Khoa</th>
                                        <th></th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    @foreach($DanhSach_BoMon as $BoMon)
                                        <tr>
                                            <th>{{++$STT}}</th>
                                            <td>{{$BoMon->mabomon}}</td>
                                            <td>{{$BoMon->tenbomon}}</td>
                                            <td>{{$BoMon->tenkhoa}}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatBoMonModal" title="Sửa" onclick="CapNhatBoMon('{{$BoMon->id}}', '{{$BoMon->mabomon}}','{{$BoMon->tenbomon}}', '{{$BoMon->idkhoa}}')">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger remove_bomon" href="{{route('bomon_destroy',['id'=>$BoMon->id])}}" Ten="{{$BoMon->tenbomon}}" title="Xóa"><i class="fa fa-remove"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            {{'Chưa có dữ liệu!'}}
                        @endif
                    @else
                        {{'Không có thông tin!'}}
                    @endif
                </div>
                <hr>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiBoMonModal" title="Thêm mới bộ môn">
                        <strong> <i class="fa fa-plus"></i> Thêm mới </strong>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thêm mới bộ môn -->
    <div id="ThemMoiBoMonModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <!-- <form action="" method="post" class="form-signin" accept-charset="utf-8"> -->
                    <div class="modal-header">
                        <div class="col-11 pull-left">
                            <h3>Thêm mới bộ môn</h3>
                        </div>
                        <div class="col-1 pull-right">
                            <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                    	@include('layout.block.message_validation')
                        <div class="form-group">
                            <label for="MaBoMon"> Mã/Viết tắt </label>
                            <input type="text" name="MaBoMon" id="MaBoMon" class="form-control MaBoMon" placeholder="Mã bộ môn" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenBoMon"> Tên bộ môn </label>
                            <input type="text" name="TenBoMon" id="TenBoMon" class="form-control TenBoMon" placeholder="Tên bộ môn" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="IDKhoa"> Khoa </label>
                            <select name="IDKhoa" id="IDKhoa" class="IDKhoa Khoa form-control">
                            @if(isset($DanhSach_Khoa))
                                @foreach($DanhSach_Khoa as $Khoa)
                                    <option value="{{$Khoa->id}}"> {{$Khoa->tenkhoa}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary save_bomon" href="{{ route('post_bomon') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>

    <!-- Modal cập nhật bộ môn -->
    <div id="CapNhatBoMonModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="" method="post" class="form-signin" accept-charset="utf-8">
                    <div class="modal-header">
                        <div class="col-11 pull-left">
                            <h3>Cập nhật thông tin bộ môn</h3>
                        </div>
                        <div class="col-1 pull-right">
                            <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                    	@include('layout.block.message_validation_update')
                        <input name="ID_BoMon_CapNhat" id="ID_BoMon_CapNhat" type="text" class="hidden ID_BoMon_CapNhat" hidden="true">
                        <div class="form-group">
                            <label for="MaBoMon_CapNhat"> Mã bộ môn </label>
                            <input type="text" name="MaBoMon_CapNhat" id="MaBoMon_CapNhat" class="form-control MaBoMon_CapNhat" placeholder="Mã bộ môn" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenBoMon_CapNhat"> Tên bộ môn </label>
                            <input type="text" name="TenBoMon_CapNhat" id="TenBoMon_CapNhat" class="form-control TenBoMon_CapNhat" placeholder="Tên bộ môn" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="IDKhoa_CapNhat"> Khoa </label>
                            <select name="IDKhoa_CapNhat" id="IDKhoa_CapNhat" class="IDKhoa_CapNhat Khoa form-control">
                            @if(isset($DanhSach_Khoa))
                                @foreach($DanhSach_Khoa as $Khoa)
                                    <option value="{{$Khoa->id}}"> {{$Khoa->tenkhoa}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary update_bomon" href="{{route('post_bomon_update')}}"><i class="fa fa-save"></i> Lưu </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                    </div>
                </form>
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
    <script type="text/javascript" src="{!! URL::asset('js/bomon.js') !!}"></script>
@endsection