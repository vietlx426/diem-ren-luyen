@extends('truongdonvi.layout.master')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <!-- bootstrap-daterangepicker -->
    <link href="{{URL::asset('gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="{{URL::asset('gentelella-master/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::asset('gentelella-master/vendors/select2/dist/css/select2.min.css')}}">
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
                <form action="{{route('admin_tieuchi_minhchung_modulethoigianstore')}}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="text" name="idhocky" class="hidden" hidden="true" value="{{isset($idHocKy)?$idHocKy:''}}">
                    <input type="text" name="idtieuchi" class="hidden" hidden="true" value="{{isset($tieuChi)?$tieuChi->id:''}}">
                    <input type="text" name="idmodule" class="hidden" hidden="true" value="{{isset($idModule)?$idModule:''}}">
                    @include('layouts.gentelella-master.blocks.flash-messages')
                    @if(isset($tieuChi))
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="90%" class="text-justify-middle">Tiêu chí: {!! $tieuChi->chimuctieuchi ." ". $tieuChi->tentieuchi!!}</th>
                                    <th width="10%" class="text-center-middle">Tối đa {{$tieuChi->diemtoida}}đ</th>
                                </tr>
                            </thead> 
                        </table>
                    @endif
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('thoigianbatdau') ? ' has-error' : ''}}">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="thoigianbatdau">Thời gian bắt đầu<span class="required">*</span></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class='input-group date' id='myDatepickerStart'>
                                        <input type='text' name="thoigianbatdau" id="thoigianbatdau" class="form-control" value="{{old('thoigianbatdau', isset($tieuChiModuleThoiGian)? date('d/m/Y h:i', strtotime($tieuChiModuleThoiGian->thoigianbatdau)) : '')}}"  readonly="true">
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <span class="help-block">
                                        <strong id="help-error-minhchung">{{ $errors->first('thoigianbatdau') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('thoigianketthuc') ? ' has-error' : ''}}">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="thoigianketthuc">Thời gian kết thúc<span class="required">*</span></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class='input-group date' id='myDatepickerEnd'>
                                        <input type='text' name="thoigianketthuc" id="thoigianketthuc" class="form-control" value="{{old('thoigianketthuc', isset($tieuChiModuleThoiGian)? date('d/m/Y h:i', strtotime($tieuChiModuleThoiGian->thoigianketthuc)) : '')}}" readonly="true">
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <span class="help-block">
                                        <strong id="help-error-minhchung">{{ $errors->first('thoigianketthuc') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent 
    <!-- bootstrap-daterangepicker -->
    <script src="{{URL::asset('gentelella-master/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="{{URL::asset('gentelella-master/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/select2/dist/js/select2.full.min.js')}}"></script>
    
    <script>
        $('#myDatepickerStart').datetimepicker({
            ignoreReadonly: true,
            allowInputToggle: true,
            format: 'DD/MM/YYYY'
        });

        $('#myDatepickerEnd').datetimepicker({
            ignoreReadonly: true,
            allowInputToggle: true,
            format: 'DD/MM/YYYY'
        });
    </script>
@endsection