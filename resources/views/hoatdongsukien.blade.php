@extends('subadmin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header">
            
            <h3> Danh sách hoạt động sự kiện </h3>
            
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiHDSKModal" title="Thêm mới hoạt động sự kiện">
                <i class="fa fa-plus"></i> Thêm mới
            </button>
       
    </div>
   

    <!-- Page content - Danh sách hoạt động sự kiện -->
    <div class="page-content">
            @if(isset($DS_HoatDongSuKien))
                @if(count($DS_HoatDongSuKien)>0)
                    <?php $STT = '0' ?>
                    <table id="dataTables-example" class="table table-striped table-bordered table-hover" >
                         <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên hoạt động sự kiện</th>
                                <th>Loại hoạt động sự kiện</th>
                                <th>Thời gian bắt đầu đăng ký</th>
                                <th>Thời gian kết thúc đăng ký</th>
                                <th>Giờ bắt đầu</th>
                                <th>Giờ kết thúc</th>
                                <th>Thời gian bắt đầu</th>
                                <th>Thời gian kết thúc</th>
                                <th>Địa điểm</th>
                                <th>Ghi chú</th>
                                <th></th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($DS_HoatDongSuKien as $HDSK)
                                <tr>
                                    <th>{{++$STT}}</th>
                                    <td>{{$HDSK->tenhoatdongsukien}}</td>
                                    <td>{{$HDSK->tenloaihoatdongsukien}}</td>
                                    <td>{{date('d/m/Y',strtotime($HDSK->thoigianbatdaudangky))}}</td>
                                    <td>{{date('d/m/Y',strtotime($HDSK->thoigianketthucdangky))}}</td>
                                    <td>{{$HDSK->giobatdau}}</td>
                                    <td>{{$HDSK->giokethuc}}</td>
                                    <td>{{date('d/m/Y',strtotime($HDSK->thoigianbatdau))}}</td>
                                    <td>{{date('d/m/Y',strtotime($HDSK->thoigianketthuc))}}</td>
                                    <td>{{$HDSK->diadiem}}</td>
                                    <td>{{$HDSK->ghichu}}</td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CapNhatHDSKModal" title="Sửa" onclick="CapNhatHDSK('{{$HDSK->id}}', '{{$HDSK->tenhoatdongsukien}}', '{{$HDSK->loaihoatdongsukien_id}}', '{{$HDSK->thoigianbatdaudangky}}', '{{$HDSK->thoigianketthucdangky}}', '{{$HDSK->giobatdau}}', '{{$HDSK->giokethuc}}', '{{$HDSK->thoigianbatdau}}', '{{$HDSK->thoigianketthuc}}', '{{$HDSK->diadiem}}', '{{$HDSK->ghichu}}')">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger remove_hdsk" href="{{route('hdsk_destroy',['id'=>$HDSK->id])}}" Ten="{{$HDSK->tenhoatdongsukien}}" title="Xóa"><i class="fa fa-remove"></i>
                                    </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ThemMoiHDSKModal" title="Thêm mới hoạt động sự kiện">
                                        <i class="fa fa-plus"></i> Thêm mới
                                    </button>
                                     <a href="{{route('export_excel')}}" class="btn btn-success">Xuất excel</a>
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

    <!-- Modal thêm hoạt động sự kiện-->
    <div id="ThemMoiHDSKModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Thêm mới hoạt động sự kiện</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <div class="form-group">
                        <label for="tenhoatdongsukien"> Tên hoạt động sự kiện </label>
                        <input type="text" name="tenhoatdongsukien" id="tenhoatdongsukien" class="form-control" placeholder="Tên hoạt động sự kiện" autofocus>
                    </div>
                    <div class="form-group">
                            <label for="IDLoaiHDSK"> Loại hoạt động sự kiện </label>
                            <select name="IDLoaiHDSK" id="IDLoaiHDSK" class="IDLoaiHDSK Khoa form-control">
                            @if(isset($DS_LoaiHoatDongSuKien))
                                @foreach($DS_LoaiHoatDongSuKien as $LoaiHDSK)
                                    <option value="{{$LoaiHDSK->id}}"> {{$LoaiHDSK->tenloaihoatdongsukien}} </option>
                                @endforeach
                            @endif
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="thoigianBDDK"> Thời gian bắt đầu đăng ký</label>
                        <input type="date" name="thoigianBDDK" id="thoigianBDDK" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="thoigianKTDK"> Thời gian kết thúc đăng ký </label>
                        <input type="date" name="thoigianKTDK" id="thoigianKTDK" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="gioBD"> Giờ bắt đầu</label>
                        <input type="time" name="gioBD" id="gioBD" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="gioKT"> Giờ kết thúc</label>
                        <input type="time" name="gioKT" id="gioKT" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="thoigianBD"> Thời gian bắt đầu </label>
                        <input type="date" name="thoigianBD" id="thoigianBD" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="thoigianKT"> Thời gian kết thúc </label>
                        <input type="date" name="thoigianKT" id="thoigianKT" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="diadiem"> Địa điểm </label>
                        <input type="text" name="diadiem" id="diadiem" class="form-control" placeholder="Địa điểm" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="ghichu"> Ghi chú </label>
                        <textarea name="ghichu" id="ghichu" placeholder="Ghi chú" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_hdsk" href="{{ route('post_hdsk') }}"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật hoạt động sự kiện-->
    <div id="CapNhatHDSKModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-11 pull-left">
                        <h3>Cập nhật thông tin hoạt động sự kiện</h3>
                    </div>
                    <div class="col-1 pull-right">
                        <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    @include('layout.block.message_validation')
                    <input name="idhoatdongsukien_capnhat" id="idhoatdongsukien_capnhat" type="text" class="hidden" hidden="true">
                    <div class="form-group">
                        <label for="tenhoatdongsukien_capnhat"> Tên hoạt động sự kiện </label>
                        <input type="text" name="tenhoatdongsukien_capnhat" id="tenhoatdongsukien_capnhat" class="form-control" placeholder="Tên hoạt động sự kiện" autofocus>
                    </div>
                    <div class="form-group">
                            <label for="IDLoaiHDSK_capnhat"> Loại hoạt động sự kiện </label>
                            <select name="IDLoaiHDSK_capnhat" id="IDLoaiHDSK_capnhat" class="IDLoaiHDSK_capnhat Khoa form-control">
                            @if(isset($DS_LoaiHoatDongSuKien))
                                @foreach($DS_LoaiHoatDongSuKien as $LoaiHDSK)
                                    <option value="{{$LoaiHDSK->id}}"> {{$LoaiHDSK->tenloaihoatdongsukien}} </option>
                                @endforeach
                            @endif
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="thoigianBDDK_capnhat"> Thời gian bắt đầu đăng ký</label>
                        <input type="date" name="thoigianBDDK_capnhat" id="thoigianBDDK_capnhat" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="thoigianKTDK_capnhat"> Thời gian kết thúc đăng ký </label>
                        <input type="date" name="thoigianKTDK_capnhat" id="thoigianKTDK_capnhat" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="gioBD_capnhat"> Giờ bắt đầu</label>
                        <input type="time" name="gioBD_capnhat" id="gioBD_capnhat" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="gioKT_capnhat"> Giờ kết thúc</label>
                        <input type="time" name="gioKT_capnhat" id="gioKT_capnhat" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="thoigianBD_capnhat"> Thời gian bắt đầu </label>
                        <input type="date" name="thoigianBD_capnhat" id="thoigianBD_capnhat" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="thoigianKT_capnhat"> Thời gian kết thúc </label>
                        <input type="date" name="thoigianKT_capnhat" id="thoigianKT_capnhat" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="diadiem_capnhat"> Địa điểm </label>
                        <input type="text" name="diadiem_capnhat" id="diadiem_capnhat" class="form-control" placeholder="Địa điểm" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="ghichu_capnhat"> Ghi chú </label>
                        <textarea name="ghichu_capnhat" id="ghichu_capnhat" placeholder="Ghi chú" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update_hdsk" href="{{route('post_hdsk_update')}}"><i class="fa fa-save"></i> Lưu </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
     @parent 
    <script src="{{URL::asset('dashboard/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{URL::asset('dashboard/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>    
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
    <script src="{{URL::asset('dashboard/bower_components/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('dashboard/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
    
@endsection