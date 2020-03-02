@extends('truongdonvi.layout.master')

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
                                    <th width="70%">Bộ tiêu chí</th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($dsHocKyNamHoc as $hocKyNamHoc)
                                    <tr>
                                        <th class="text-center">{{++$STT}}</th>
                                        <td>{{$hocKyNamHoc->tenhockynamhoc}}</td>
                                        <td>
                                            @if($hocKyNamHoc->hockynamhocbotieuchi)
                                                <a href="{{route('truongdonvi_botieuchi_tieuchi_index', ['idbotieuchi'=>$hocKyNamHoc->hockynamhocbotieuchi->botieuchi->id])}}" title="Xem chi tiết tiêu chí">
                                                    <span class="label label-success"> <strong> {{$hocKyNamHoc->hockynamhocbotieuchi->botieuchi->tenbotieuchi}} </strong> </span>
                                                </a>
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