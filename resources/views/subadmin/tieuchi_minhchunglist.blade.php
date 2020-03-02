@extends('subadmin.layout.master')

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
        <h3> TIÊU CHÍ ĐIỂM RÈN LUYỆN - MINH CHỨNG </h3>
        <h4>
            {{isset($boTieuChi)?$boTieuChi->tenbotieuchi:''}}
        </h4>
    </div>
    <div class="row">
        <div class="x_panel">
            <div class="x_content">
                @include('layouts.gentelella-master.blocks.flash-messages')
                @if(isset($tieuChi))
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-justify-middle"><a href="{{route('subadmin_index_tieuchi_minhchung')}}" class="btn btn-success" title="Tiêu chí - Minh chứng"><i class="fa fa-undo"></i></a></th>
                                <th width="90%" class="text-justify-middle">Tiêu chí: {!!$tieuChi->chimuctieuchi . " " . $tieuChi->tentieuchi!!}</th>
                                <th width="10%" class="text-center-middle">Tối đa {{$tieuChi->diemtoida}}đ</th>
                            </tr>
                        </thead> 
                    </table>
                @endif

                @if(isset($dsTieuChiMinhChung))
                    <?php $STT = '0' ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center-middle">#</th>
                                <th width="65%">Tên (mô tả minh chứng)</th>
                                <th width="15%" class="text-center-middle">File upload</th>
                                <th width="15%" class="text-center-middle">File scan</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($dsTieuChiMinhChung as $tieuChiMinhChung)
                                <tr>
                                    <th class="text-center-middle">{{++$STT}}</th>
                                    <th class="text-justify-middle">{{$tieuChiMinhChung->tenminhchung}}</th>
                                    <th class="text-center-middle">
                                        @if($tieuChiMinhChung->fileupload)
                                            <a href="{{route('subadmin_tieuchi_minhchung_downloadfileimport', ['idtieuchiminhchung'=>$tieuChiMinhChung->id])}}" class="btn btn-success"><i class="fa fa-download"></i></a>
                                        @endif
                                    </th>
                                    <th class="text-center-middle">
                                        @if($tieuChiMinhChung->filescan)
                                            <a href="{{route('subadmin_tieuchi_minhchung_downloadfileminhchung', ['idtieuchiminhchung'=>$tieuChiMinhChung->id])}}" class="btn btn-primary"><i class="fa fa-download"></i></a>
                                        @endif
                                    </th>
                                    <th class="text-right-middle">{{$tieuChiMinhChung->diem}}</th>
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