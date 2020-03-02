@extends('admin.layout.master')
@section('title')
    @parent
     | Majors
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
                <h2> DANH SÁCH NGÀNH ĐÀO TẠO </h2>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiNganhModal" title="Thêm mới bộ môn">
                        <strong> <i class="fa fa-plus"></i> THÊM MỚI </strong>
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    @if(isset($DanhSach_Nganh))
                        <?php $STT = '0' ?>
                        <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Mã</th>
                                    <th>Ngành</th>
                                    <th>Ký hiệu</th>
                                    <th>Bậc đào tạo</th>
                                    <th>Hệ đào tạo</th>
                                    <th></th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($DanhSach_Nganh as $Nganh)
                                    <tr>
                                        <th class="text-center">{{++$STT}}</th>
                                        <td>{{$Nganh->manganh}}</td>
                                        <td>{{$Nganh->tennganh}}</td>
                                        <td>{{$Nganh->kyhieunganh}}</td>
                                        <td>{{$Nganh->tenbac}}</td>
                                        <td>{{$Nganh->tenhe}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#CapNhatNganhModal" title="Sửa" onclick="CapNhatNganh('{{$Nganh->id}}', '{{$Nganh->manganh}}','{{$Nganh->tennganh}}','{{$Nganh->kyhieunganh}}', '{{$Nganh->idbomon}}', '{{$Nganh->idbacdaotao}}', '{{$Nganh->idhedaotao}}')">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger remove_nganh" href="{{route('nganh_destroy',['id'=>$Nganh->id])}}" Ten="{{$Nganh->tennganh}}" title="Xóa"><i class="fa fa-trash"></i>
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
                <hr>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiNganhModal" title="Thêm mới bộ môn">
                        <strong> <i class="fa fa-plus"></i> THÊM MỚI </strong>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thêm mới ngành đào tạo -->
    <div id="ThemMoiNganhModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <!-- <form action="" method="post" class="form-signin" accept-charset="utf-8"> -->
                    <div class="modal-header">
                        <div class="col-11 pull-left">
                            <h3>Thêm mới ngành đào tạo</h3>
                        </div>
                        <div class="col-1 pull-right">
                            <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                    	@include('layout.block.message_validation')
                        <div class="form-group">
                            <label for="MaNganh"> Mã/Viết tắt </label>
                            <input type="text" name="MaNganh" id="MaNganh" class="form-control MaNganh" placeholder="Mã ngành" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenNganh"> Tên ngành </label>
                            <input type="text" name="TenNganh" id="TenNganh" class="form-control TenNganh" placeholder="Tên ngành" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenNganh"> Ký hiệu ngành </label>
                            <input type="text" name="KyHieuNganh" id="KyHieuNganh" class="form-control KyHieuNganh" placeholder="Ký hiệu ngành" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="IDBoMon"> Thuộc bộ môn </label>
                            <select name="IDBoMon" id="IDBoMon" class="IDBoMon BoMon form-control">
                            @if(isset($DanhSach_BoMon))
                                <option value="0"> --- Chọn bộ môn --- </option>
                                @foreach($DanhSach_BoMon as $BoMon)
                                    <option value="{{$BoMon->id}}"> {{$BoMon->tenbomon}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="IDBacDaoTao"> Bậc đào tạo </label>
                            <select name="IDBacDaoTao" id="IDBacDaoTao" class="IDBacDaoTao BacDaoTao form-control">
                            @if(isset($DanhSach_BacDaoTao))
                                <option value="0"> --- Chọn bậc đào tạo --- </option>
                                @foreach($DanhSach_BacDaoTao as $BacDaoTao)
                                    <option value="{{$BacDaoTao->id}}"> {{$BacDaoTao->tenbac}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="IDHeDaoTao"> Hệ đào tạo </label>
                            <select name="IDHeDaoTao" id="IDHeDaoTao" class="IDHeDaoTao HeDaoTao form-control">
                            @if(isset($DanhSach_HeDaoTao))
                                <option value="0"> --- Chọn hệ đào tạo --- </option>
                                @foreach($DanhSach_HeDaoTao as $HeDaoTao)
                                    <option value="{{$HeDaoTao->id}}"> {{$HeDaoTao->tenhe}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary save_nganh" href="{{ route('post_nganh') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>

    <!-- Modal cập nhật ngành đào tạo -->
    <div id="CapNhatNganhModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="" method="post" class="form-signin" accept-charset="utf-8">
                    <div class="modal-header">
                        <div class="col-11 pull-left">
                            <h3>Cập nhật thông tin ngành</h3>
                        </div>
                        <div class="col-1 pull-right">
                            <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                    	@include('layout.block.message_validation_update')
                        <input name="ID_Nganh_CapNhat" id="ID_Nganh_CapNhat" type="text" class="hidden ID_Nganh_CapNhat" hidden="true">
                        <div class="form-group">
                            <label for="MaNganh_CapNhat"> Mã ngành </label>
                            <input type="text" name="MaNganh_CapNhat" id="MaNganh_CapNhat" class="form-control MaNganh_CapNhat" placeholder="Mã ngành" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenNganh_CapNhat"> Tên ngành </label>
                            <input type="text" name="TenNganh_CapNhat" id="TenNganh_CapNhat" class="form-control TenNganh_CapNhat" placeholder="Tên ngành" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenNganh"> Ký hiệu ngành </label>
                            <input type="text" name="KyHieuNganh_CapNhat" id="KyHieuNganh_CapNhat" class="form-control KyHieuNganh_CapNhat" placeholder="Ký hiệu ngành" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="IDBoMon_CapNhat"> Thuộc bộ môn </label>
                            <select name="IDBoMon_CapNhat" id="IDBoMon_CapNhat" class="IDBoMon_CapNhat BoMon form-control">
                            @if(isset($DanhSach_BoMon))
                                @foreach($DanhSach_BoMon as $BoMon)
                                    <option value="{{$BoMon->id}}"> {{$BoMon->tenbomon}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="IDBacDaoTao_CapNhat"> Bậc đào tạo </label>
                            <select name="IDBacDaoTao_CapNhat" id="IDBacDaoTao_CapNhat" class="IDBacDaoTao_CapNhat BacDaoTao form-control">
                            @if(isset($DanhSach_BacDaoTao))
                                @foreach($DanhSach_BacDaoTao as $BacDaoTao)
                                    <option value="{{$BacDaoTao->id}}"> {{$BacDaoTao->tenbac}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="IDHeDaoTao_CapNhat"> Bậc đào tạo </label>
                            <select name="IDHeDaoTao_CapNhat" id="IDHeDaoTao_CapNhat" class="IDHeDaoTao_CapNhat HeDaoTao form-control">
                            @if(isset($DanhSach_HeDaoTao))
                                @foreach($DanhSach_HeDaoTao as $HeDaoTao)
                                    <option value="{{$HeDaoTao->id}}"> {{$HeDaoTao->tenhe}} </option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary update_nganh" href="{{route('post_nganh_update')}}"><i class="fa fa-save"></i> Lưu </button>
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
    <script type="text/javascript" src="{!! URL::asset('js/nganh.js') !!}"></script>
@endsection