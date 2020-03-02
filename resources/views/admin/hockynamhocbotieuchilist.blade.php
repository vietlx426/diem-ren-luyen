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
                <h2> DANH SÁCH HỌC KỲ - NĂM HỌC - BỘ TIÊU CHÍ </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    @include('layouts.gentelella-master.blocks.flash-messages')
                    @if(isset($dsHocKyNamHoc))
                        <?php $STT = '0' ?>
                        <table id="datatable-buttons" class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th width="25%">Học kỳ - Năm học</th>
                                    <th width="50%">Bộ tiêu chí</th>
                                    <th width="20%"></th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($dsHocKyNamHoc as $hocKyNamHoc)
                                    <tr>
                                        <th class="text-center">{{++$STT}}</th>
                                        <td>{{$hocKyNamHoc->tenhockynamhoc}}</td>
                                        <td>
                                            @if($hocKyNamHoc->hockynamhocbotieuchi)
                                                <a href="{{route('admin_botieuchi_tieuchi_index', ['idbotieuchi'=>$hocKyNamHoc->hockynamhocbotieuchi->botieuchi->id])}}" title="Xem chi tiết tiêu chí">
                                                    <span class="label label-success"> <strong> {{$hocKyNamHoc->hockynamhocbotieuchi->botieuchi->tenbotieuchi}} </strong> </span>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($hocKyNamHoc->hockynamhocbotieuchi)
                                                @if($hocKyNamHoc->idtrangthaihocky != 1)
                                                    @if(!App\Http\Controllers\HocKyNamHocBoTieuChiController::hasBangDiemTieuChi($hocKyNamHoc->hockynamhocbotieuchi))
                                                        <a href="{{route('admin_hockynamhocbotieuchi_edit', ['idhockynamhocbotieuchi'=>$hocKyNamHoc->hockynamhocbotieuchi->id])}}" class="btn btn-warning" title="Sửa (chọn bộ tiêu chí)"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                @else
                                                    @if($hocKyNamHoc->idtrangthaihocky == 3)
                                                        <a href="" class="btn btn-danger" title="Xóa bộ tiêu chí"><i class="fa fa-trash"></i></a>
                                                    @endif
                                                @endif
                                            @else
                                                @if($hocKyNamHoc->idtrangthaihocky != 1)
                                                    <a href="{{route('admin_hockynamhocbotieuchi_create', ['idhockynamhoc'=>$hocKyNamHoc->id])}}" class="btn btn-primary" title="Thêm bộ tiêu chí cho học kỳ"><i class="fa fa-plus"></i></a>
                                                @endif
                                            @endif
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

    <script type="text/javascript">
      $('.btn-generate').click(function(){
        loadereffectshow();
      });
    </script>
@endsection