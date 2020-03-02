@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <!-- iCheck -->
    <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2> HỌC KỲ - NĂM HỌC - BỘ TIÊU CHÍ </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{{route('admin_hockynamhocbotieuchi_update')}}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{csrf_field()}}
                    @include('layouts.gentelella-master.blocks.flash-messages')
                    <div class="row">
                        @if(isset($hocKyNamHocBoTieuChi))
                            <input type="text" name='idhockynamhocbotieuchi' class="hidden" hidden="true" value="{{$hocKyNamHocBoTieuChi->id}}">
                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('hockynamhoc') ? ' has-error' : ''}}">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hockynamhoc">Học kỳ - Năm học<span class="required"></span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="inpmuc form-control" readonly="true" value="{{$hocKyNamHocBoTieuChi->hockynamhoc->tenhockynamhoc}}">
                                        <span class="help-block">
                                            <strong id="help-error-minhchung">{{ $errors->first('hockynamhoc') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('botieuchi') ? ' has-error' : ''}}">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="botieuchi">Bộ tiêu chí<span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        
                                        @if(isset($dsBoTieuChi))
                                            @foreach($dsBoTieuChi as $boTieuChi)
                                                <input type="radio" class="flat" id="inpbotieuchi{{$boTieuChi->id}}" name="botieuchi" value="{{$boTieuChi->id}}" {{$boTieuChi->id==old('botieuchi', $hocKyNamHocBoTieuChi->botieuchi_id)?'checked="true"':''}}>
                                                <label for="inpbotieuchi{{$boTieuChi->id}}"> {{$boTieuChi->tenbotieuchi}} </label> <br>;
                                            @endforeach
                                        @endif
                                        
                                        <span class="help-block">
                                            <strong id="help-error-minhchung">{{ $errors->first('botieuchi') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i><strong> LƯU </strong></button>
                    </div>
                </form>
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