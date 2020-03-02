@extends('truongdonvi.layout.master')
@section('title')
  @parent | Bộ tiêu chí
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
            <h2> BỘ TIÊU CHÍ </h2>
            <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    @include('layouts.gentelella-master.blocks.flash-messages')
                    <table class="table table-striped " width="100%">
                        <thead>
                            <tr class="filters">
                                <th class="text-center">#</th>
                                <th>Bộ tiêu chí</th>
                                <th class="text-center">Học kỳ áp dụng</th>
                                <th class="text-center">Tiêu chí</th>
                                <th class="text-center">File</th>
                            </tr>
                        </thead>
                        <tbody id="tbodystudent">
                                @if(isset($dsBoTieuChi))
                                    <?php $STT = 0; ?>
                                    @foreach($dsBoTieuChi as $boTieuChi)
                                        <tr>
                                            <th class="text-center-middle text-center">{{++$STT}}</th>
                                            <td class="text-justify-middle">{{$boTieuChi->tenbotieuchi}}</td>
                                            <td class="text-center-middle text-center">
                                                @if($boTieuChi->hockynamhocbotieuchi)
                                                    @foreach($boTieuChi->hockynamhocbotieuchi as $hocKyNamHocTieuChi)
                                                        {{$hocKyNamHocTieuChi->hocKyNamHoc->tenhockynamhoc}}<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="text-center-middle text-center" title="Xem chi tiết tiêu chí">
                                                <a href="{{route('truongdonvi_botieuchi_tieuchi_index', ['idbotieuchi'=>$boTieuChi->id])}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                            </td>

                                            <td class="text-center-middle text-center" title="Tải file văn bản">
                                                @if(trim($boTieuChi->filename))
                                                    <a href="{{route('admin_botieuchi_download', ['id'=>$boTieuChi->id])}}" class="btn btn-primary"><i class="fa fa-download"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                        </tbody>
                    </table>
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

    <script>
        $('.btn-remove').click(function(e){
            if(!confirm("Bán muốn xóa bộ tiêu này?"))
                e.preventDefault();
        });
    </script>
@endsection