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
                                <th width="20%" class="text-right-middle"><a href="{{route('admin_botieuchi_tieuchi_create', ['idbotieuchi'=>$boTieuChi->id])}}" class="btn btn-primary btn-themmoitieuchi" title="Thêm mới năm học">
                        <strong><i class="fa fa-plus"></i> Thêm mới</strong>
                    </a></th>
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
                                    <td class="text-center-middle">{{$tieuChi->diemmacdinh}}</td>
                                    <td class="text-justify-middle"> {!! $tieuChi->module?('<span class="label label-success">' . $tieuChi->module->modulename . '</span>'):'' !!} </td>
                                    <td class="text-right-middle">
                                        @if($tieuChi->idloaidiem == 1)
                                            <a href="{{route('admin_botieuchi_tieuchi_create',['idbotieuchi'=>$boTieuChi->id, 'idtieuchicha'=>$tieuChi->id])}}" class="btn btn-primary" title="Thêm tiêu chí con"><i class="fa fa-plus"></i></a>
                                        @endif
                                        <a href="{{route('admin_botieuchi_tieuchi_edit',['idbotieuchi'=>$boTieuChi->id, 'idtieuchi'=>$tieuChi->id])}}" class="btn btn-warning" title="Sửa"><i class="fa fa-edit"></i></a>
                                        <a href="{{route('admin_botieuchi_tieuchi_destroy',['idbotieuchi'=>$boTieuChi->id, 'idtieuchi'=>$tieuChi->id])}}" class="btn btn-danger btn-remove" title="Xóa"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                {{App\Http\Controllers\TieuChiController::TieuChiCon($tieuChi->id, $boTieuChi)}}
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
                            <tr>
                                <td colspan="7" class="text-right">
                                <a href="{{route('admin_botieuchi_tieuchi_create', ['idbotieuchi'=>$boTieuChi->id])}}" class="btn btn-primary btn-themmoitieuchi" title="Thêm mới năm học">
                                    <strong><i class="fa fa-plus"></i> Thêm mới</strong>
                                </a>
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