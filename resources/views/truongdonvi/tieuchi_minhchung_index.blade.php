@extends('truongdonvi.layout.master')

@section('css')
  @parent
  <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">

  <!-- Datatables -->
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@endsection


@section('content')
    <div class="text-center">
        <h3> TIÊU CHÍ ĐIỂM RÈN LUYỆN </h3>
        <h4>
            {{isset($boTieuChi)?$boTieuChi->tenbotieuchi:''}}
        </h4>
    </div>
    <div class="row">
        <div class="x_panel">
            <div class="x_content">
                @include('layouts.gentelella-master.blocks.flash-messages')
                @if(isset($dsTieuChi_Level_0) && isset($boTieuChi))
                    <?php $STT = '0' ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="55%">Nội dung</th>
                                <th width="10%" class="text-right-middle">Hạn mức</th>
                                <th width="10%" class="text-right-middle">Mặc định</th>
                                <th width="10%" class="text-center-middle">Minh chứng</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($dsTieuChi_Level_0 as $tieuChi)
                                <tr>
                                    <th class="text-justify-middle">{{$tieuChi->chimuctieuchi}}</th>
                                    @if($tieuChi->idloaidiem == 1)
                                        <th class="text-justify-middle">
                                            {!! $tieuChi->tentieuchi !!}
                                        </th>
                                        <td class="text-right-middle">{{$tieuChi->diemtoida}}</td>
                                        <td class="text-right-middle">{{$tieuChi->diemmacdinh}}</td>
                                        <td></td>
                                    @else
                                        <td class="text-justify-middle">
                                            {!! $tieuChi->tentieuchi !!}
                                        </td>
                                        <td class="text-right-middle">{{$tieuChi->diemtoida}}</td>
                                        <td class="text-right-middle">{{$tieuChi->diemmacdinh}}</td>
                                        @if($tieuChi->module_id == 2)
                                            <td class="text-center-middle"><a href="{{route('truongdonvi_tieuchi_minhchung_module', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id, 'idmodule'=>$tieuChi->module_id])}}" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>
                                        @else
                                            <td class="text-center-middle"><a href="{{route('truongdonvi_tieuchi_minhchung', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id])}}" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>
                                        @endif
                                    @endif
                                </tr>
                                {{App\Http\Controllers\TieuChiController::TruongDonVi_TieuChiCon_MinhChung($tieuChi->id, $boTieuChi, $idHocKy)}}
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-center">
                                    @if(isset($countTieuChi_Level_0))
                                        <strong>Tổng cộng {{$countTieuChi_Level_0}} tiêu chí</strong>
                                    @endif
                                </td>
                                <td class="text-right-middle">
                                    @if(isset($totalMarks))
                                        <strong>{{$totalMarks}}</strong>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    {{'Không có thông tin!'}}
                @endif
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
@endsection