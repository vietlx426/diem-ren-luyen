@extends('subadmin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
        <h3> Danh sách học kỳ - năm học </h3>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiHocKyNamHocModal" title="Thêm mới năm học">
            <i class="fa fa-plus"></i> Thêm mới
        </button>
    </div>
    <!-- Page content - Danh sách học kỳ-năm học -->
    <div class="page-content">
        @if(isset($DanhSach_HocKyNamHoc))
            @if(count($DanhSach_HocKyNamHoc)>0)
                <?php $STT = '0' ?>
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th>#</th>
                            <th>Học kỳ - Năm học</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($DanhSach_HocKyNamHoc as $HocKyNamHoc)
                            <tr>
                                <th>{{++$STT}}</th>
                                <td>{{$HocKyNamHoc->tenhockynamhoc}}</td>
                                <td>{{$HocKyNamHoc->TenTrangThai}}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatHocKyNamHocModal" title="Sửa" onclick="CapNhatHocKyNamHoc('{{$HocKyNamHoc->id}}', '{{$HocKyNamHoc->idhocky}}','{{$HocKyNamHoc->idnamhoc}}','{{$HocKyNamHoc->idtrangthaihocky}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_hockynamhoc" href="{{route('hockynamhoc_destroy',['id'=>$HocKyNamHoc->id])}}" Ten="{{$HocKyNamHoc->tenhockynamhoc}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiHocKyNamHocModal" title="Thêm mới học kỳ năm học">
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
                                    <input type="radio" id="HocKy{{$HocKy->id}}" class="HocKy" name="HocKy" value="{{$HocKy->id}}"> &ensp; &ensp; &ensp;
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
                                    <input type="radio" id="TrangThai{{$TrangThai->id}}" class="TrangThai" name="TrangThai" value="{{$TrangThai->id}}">&ensp;&ensp;&ensp;
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
                                    <input type="radio" id="HocKy{{$HocKy->id}}_CapNhat" class="HocKy_CapNhat" name="HocKy_CapNhat" value="{{$HocKy->id}}"> &ensp; &ensp; &ensp;
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
                                    <input type="radio" id="TrangThai{{$TrangThai->id}}_CapNhat" class="TrangThai_CapNhat" name="TrangThai_CapNhat" value="{{$TrangThai->id}}">&ensp;&ensp;&ensp;
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
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
@endsection