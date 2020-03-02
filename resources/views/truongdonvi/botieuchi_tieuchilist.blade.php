@extends('truongdonvi.layout.master')
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
                                <th width="45%">Nội dung</th>
                                <th width="10%" class="text-center">Hạn mức</th>
                                <th width="10%" class="text-center">Mặc định</th>
                                <th width="10%">Module</th>
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
                                    @else
                                        <td class="text-justify-middle">
                                            {!! $tieuChi->tentieuchi !!}
                                        </td>
                                    @endif
                                    <td class="text-center-middle">{{$tieuChi->diemtoida}}</td>
                                    <th class="text-center-middle">{{$tieuChi->diemmacdinh}}</th>
                                    <td class="text-justify-middle"> {!! $tieuChi->module?('<span class="label label-success">' . $tieuChi->module->modulename . '</span>'):'' !!} </td>
                                </tr>
                                {{App\Http\Controllers\TieuChiController::TieuChiCon_TruongDonVi($tieuChi->id, $boTieuChi)}}
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
                                <td colspan="4" class="text-center">
                                </td>
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
    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/ckeditor/ckeditor.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/ckfinder/ckfinder.js') !!}"></script>
    <script>
        $('.btn-remove').click(function(e){
            if(!confirm("Bán muốn xóa bộ tiêu này?"))
                e.preventDefault();
        });
    </script>
@endsection