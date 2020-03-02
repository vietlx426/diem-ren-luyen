@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <!-- iCheck -->
    <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="text-center">
        <h3> TIÊU CHÍ ĐIỂM RÈN LUYỆN </h3>
        <h4>
            <select name="selhocky" id="selhocky" class="selhocky"> 
                @if(isset($DanhSach_HocKyNamHoc))
                    @if(count($DanhSach_HocKyNamHoc)>0)
                        @foreach($DanhSach_HocKyNamHoc as $HocKyNamHoc)
                            @if($HocKyNamHoc->idtrangthaihocky === 2)
                                <option value="{{$HocKyNamHoc->id}}" selected>{{$HocKyNamHoc->tenhockynamhoc}}</option>
                            @else
                                <option value="{{$HocKyNamHoc->id}}">{{$HocKyNamHoc->tenhockynamhoc}}</option>
                            @endif
                        @endforeach
                    @endif
                @endif
            </select>
        </h4>
    </div>
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-themmoitieuchi" data-toggle="modal" data-target="#ThemMoiTieuChiModal" idtieuchi="0" title="Thêm mới năm học">
                        <strong><i class="fa fa-plus"></i> Thêm mới</strong>
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                @if(isset($DanhSach_TieuChi))
                    @if(count($DanhSach_TieuChi)>0)
                        <?php $STT = '0' ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th width="60%">Nội dung</th>
                                    <th width="10%">Hạn mức</th>
                                    <!-- <th width="5%">Trạng thái</th> -->
                                    <th width="20%"></th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($DanhSach_TieuChi as $TieuChi)
                                    <tr>
                                        <th class="text-center-middle">{{$TieuChi->chimuctieuchi}}</th>
                                        <td class="text-justify-middle">
                                            @if($TieuChi->idtieuchicha == 0 || $TieuChi->idtieuchicha == null)
                                                <p class="font-weight-bold">
                                                    {!! $TieuChi->tentieuchi !!}
                                                </p>
                                            @else
                                                {!! $TieuChi->tentieuchi !!}
                                            @endif
                                        </td>
                                        <td class="text-center-middle">{{$TieuChi->diemtoida}}</td>
                                        <!-- <td class="text-center-middle"><span class="label label-success">{{$TieuChi->tentrangthai}}</span></td> -->
                                        
                                        <td class="text-right-middle">
                                            @if($TieuChi->idloaidiem === 1)
                                            <button type="button" class="btn btn-primary btn-themmoitieuchi" data-toggle="modal" data-target="#ThemMoiTieuChiModal" idtieuchi="{{$TieuChi->id}}" title="Thêm tiêu chí con">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            @endif

                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#CapNhatTieuChiModal" title="Sửa" onclick="CapNhatTieuChi('{{$TieuChi->id}}', '{{$TieuChi->chimuctieuchi}}', '{{$TieuChi->tentieuchi}}', '{{$TieuChi->idtieuchicha}}', '{{$TieuChi->idloaidiem}}', '{{$TieuChi->diemtoida}}','{{$TieuChi->idtrangthai}}')">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger remove_tieuchi" href="{{route('tieuchi_destroy',['id'=>$TieuChi->id])}}" Ten="{{$TieuChi->tentieuchi}}" title="Xóa"><i class="fa fa-remove"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        @if(isset($countTieuChi_Level_0))
                                            <strong>Tổng cộng {{$countTieuChi_Level_0}} tiêu chí</strong>
                                        @endif
                                    </td>
                                    <td class="text-center-middle">
                                        @if(isset($totalMarks))
                                            <strong>{{$totalMarks}}</strong>
                                        @endif
                                    </td>
                                    <td colspan="2" class="text-center">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="text-right">
                                        <button type="button" class="btn btn-primary btn-themmoitieuchi" data-toggle="modal" data-target="#ThemMoiTieuChiModal" idtieuchi="0" title="Thêm mới học kỳ năm học">
                                            <strong><i class="fa fa-plus"></i> Thêm mới</strong>
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
        </div>
    </div>

    <!-- Modal thêm mới tiêu chí -->
    <div id="ThemMoiTieuChiModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm tiêu chí</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <label> Mục: </label>
                        </div>
                        <div class="col-12 col-md-10">
                            <input type="text" class="inpmuc form-control" autofocus="true">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <label><strong> Tên/Nội dung tiêu chí: </strong></label>
                        </div>
                        <div class="col-12 col-md-10">
                            <textarea id="txttentieuchi" name="txttentieuchi" class="txttentieuchi form-control"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-12 col-md-2">
                            <label for=""><strong> Loại điểm: </strong></label>
                        </div>
                        <div class="col col-12 col-md-10">
                            <!-- <select name="selloaidiem" id="selloaidiem" class="selloaidiem form-control">
                                <option value="1">vsdv</option>
                            </select> -->
                            @if(isset($DanhSach_LoaiDiem))
                                @foreach($DanhSach_LoaiDiem as $LoaiDiem)
                                    <label for="inploaidiem{{$LoaiDiem->id}}"> {{$LoaiDiem->tenloaidiem}} </label>
                                    <input type="radio" class="LoaiDiem flat" id="inploaidiem{{$LoaiDiem->id}}" name="LoaiDiem" value="{{$LoaiDiem->id}}">&ensp;&ensp;&ensp;
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-12 col-md-2">
                            <label for=""><strong> Điểm tối đa: </strong></label>
                        </div>
                        <div class="col col-12 col-md-10">
                            <input type="number" min="0" max="100" class="inpdiemtoida form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <label><strong> Trạng thái: </strong></label>
                        </div>
                        <div class="col-12 col-md-10">
                            @if(isset($DanhSach_TrangThai))
                                @foreach($DanhSach_TrangThai as $TrangThai)
                                    <label for="inptrangthai{{$TrangThai->id}}"> {{$TrangThai->tentrangthai}} </label>
                                    <input type="radio" class="TrangThai flat" id="inptrangthai{{$TrangThai->id}}" name="trangthai" value="{{$TrangThai->id}}">&ensp;&ensp;&ensp;
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_tieuchi" href="{{ route('post_tieuchi') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật tiêu chí -->
    <div id="CapNhatTieuChiModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật tiêu chí</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="ID_TieuChi_CapNhat" id="ID_TieuChi_CapNhat" type="text" class="hidden ID_TieuChi_CapNhat" hidden="true">
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <strong><label><b> Tiêu chí cha: </b></label></strong>
                        </div>
                        <div class="col-12 col-md-10">
                            <select name="IDTieuChiCha_TieuChi_CapNhat" id="IDTieuChiCha_TieuChi_CapNhat" class="form-control">
                                <option value="0">-----Tiêu chí cấp 1 -----</option>
                                @if(isset($DanhSach_TieuChi))
                                    @foreach($DanhSach_TieuChi as $TieuChi)
                                        @if($TieuChi->idloaidiem === 1)
                                        <option value="{{$TieuChi->id}}">{!!$TieuChi->chimuctieuchi!!} {!!$TieuChi->tentieuchi!!}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <strong><label for=""> Mục: </label></strong>
                        </div>
                        <div class="col-12 col-md-10">
                            <input type="text" name="Muc_TieuChi_CapNhat" id="Muc_TieuChi_CapNhat" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <strong><label for=""> Tên/Nội dung tiêu chí: </label></strong>
                        </div>
                        <div class="col-12 col-md-10">
                            <textarea name="Ten_TieuChi_CapNhat" id="Ten_TieuChi_CapNhat"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <strong><label for=""> Loại điểm: </label></strong>
                        </div>
                        <div class="col-12 col-md-10">
                            @if(isset($DanhSach_LoaiDiem))
                                @foreach($DanhSach_LoaiDiem as $LoaiDiem)
                                    <label for="LoaiDiem_{{$LoaiDiem->id}}_CapNhat"> {{$LoaiDiem->tenloaidiem}} </label>
                                    <input type="radio" class="LoaiDiem_CapNhat flat" id="LoaiDiem_{{$LoaiDiem->id}}_CapNhat" name="LoaiDiem_CapNhat" value="{{$LoaiDiem->id}}">&ensp;&ensp;&ensp;
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-xs-2 col-sm-2 col-md-2">
                            <strong><label for=""> Hạn mức: </label></strong>
                        </div>
                        <div class="col-12 col-xs-2 col-sm-2 col-md-10">
                            <input type="number" min="0" max="100" name="DiemToiDa_TieuChi-CapNhat" id="DiemToiDa_TieuChi" class="form-control DiemToiDa_TieuChi">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-2">
                            <strong><label ><b> Trạng thái: </b></label></strong>
                        </div>
                        <div class="col-12 col-md-10">
                            @if(isset($DanhSach_TrangThai))
                                @foreach($DanhSach_TrangThai as $TrangThai)
                                    <label for="TrangThai_{{$TrangThai->id}}_CapNhat"> {{$TrangThai->tentrangthai}} </label>
                                    <input type="radio" class="TrangThai_CapNhat flat" id="TrangThai_{{$TrangThai->id}}_CapNhat" name="TrangThai_CapNhat" value="{{$TrangThai->id}}">&ensp;&ensp;&ensp;
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_tieuchi" href="{{route('post_tieuchi_update')}}"><i class="fa fa-save"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
     <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/ckeditor/ckeditor.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/ckfinder/ckfinder.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/subadmin_tieuchi.js') !!}"></script>
@endsection