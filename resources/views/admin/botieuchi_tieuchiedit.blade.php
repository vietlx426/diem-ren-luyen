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
                <h2> CẬP NHẬT TIÊU CHÍ </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if(isset($tieuChi))
                    <form action="{{route('admin_botieuchi_tieuchi_update')}}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @include('layouts.gentelella-master.blocks.flash-messages')
                        <input type="text" name='idbotieuchi' class="hidden" hidden="true" value="{{isset($idBoTieuChi)?$idBoTieuChi:''}}">
                        <input type="text" name="idtieuchi" class="hidden" hidden="true" value="{{isset($tieuChi)?$tieuChi->id:''}}">
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('chimuc') ? ' has-error' : ''}}">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="chimuc">Mục<span class="required"></span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" name="chimuc" id="chimuc" class="form-control" value="{{old('chimuc', $tieuChi->chimuctieuchi)}}" placeholder="Chỉ mục">
                                        <span class="help-block">
                                            <strong id="help-error-minhchung">{{ $errors->first('chimuc') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('noidungtieuchi') ? ' has-error' : ''}}">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noidungtieuchi">Tên/Nội dung tiêu chí<span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea id="txttentieuchi" name="noidungtieuchi" class="txttentieuchi form-control">{{old('noidungtieuchi', $tieuChi->tentieuchi)}}</textarea>
                                        <span class="help-block">
                                            <strong id="help-error-minhchung">{{ $errors->first('noidungtieuchi') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('noidungtieuchitomtat') ? ' has-error' : ''}}">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noidungtieuchitomtat">Tên/Nội dung tiêu chí (tóm tắt)<span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea id="txttentieuchi" name="noidungtieuchitomtat" class="txttentieuchi form-control">{{old('noidungtieuchitomtat', $tieuChi->tentieuchitomtat)}}</textarea>
                                        <span class="help-block">
                                            <strong id="help-error-minhchung">{{ $errors->first('noidungtieuchitomtat') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('loaidiem') ? ' has-error' : ''}}">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="loaidiem">Loại điểm<span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        @if(isset($dsLoaiDiem))
                                            @foreach($dsLoaiDiem as $loaiDiem)
                                                <input type="radio" class="LoaiDiem flat" id="inploaidiem{{$loaiDiem->id}}" name="loaidiem" value="{{$loaiDiem->id}}" {{$loaiDiem->id==old('loaidiem', $tieuChi->idloaidiem)?'checked="true"':''}}>
                                                <label for="inploaidiem{{$loaiDiem->id}}"> {{$loaiDiem->tenloaidiem}} </label> &ensp;&ensp;&ensp;
                                            @endforeach
                                        @endif
                                        <span class="help-block">
                                            <strong id="help-error-minhchung">{{ $errors->first('loaidiem') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('diemtoida') ? ' has-error' : ''}}">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="diemtoida">Điểm tối đa<span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="number" name="diemtoida" min="0" max="100" class="inpdiemtoida form-control" value="{{old('diemtoida', $tieuChi->diemtoida)}}">
                                        <span class="help-block">
                                            <strong id="help-error-minhchung">{{ $errors->first('diemtoida') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('diemmacdinh') ? ' has-error' : ''}}">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="diemmacdinh">Điểm mặc định<span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="number" name="diemmacdinh" min="0" max="100" class="inpdiemmacdinh form-control" value="{{old('diemmacdinh', $tieuChi->diemmacdinh)}}">
                                        <span class="help-block">
                                            <strong id="help-error-minhchung">{{ $errors->first('diemmacdinh') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('module') ? ' has-error' : ''}}" title="Chọn module để tính điểm, nếu không sẽ lấy điểm trực tiếp từ file import (minh chứng)">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module">Module tính điểm <small><br></small></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        @if(isset($dsModule))
                                            <select class="form-control" name="module" title="Chọn module để tính điểm, nếu không sẽ lấy điểm trực tiếp từ file import (minh chứng)">
                                                <option value="">--- Chọn module để tính điểm ---</option>
                                                @foreach($dsModule as $module)
                                                        <option value="{{$module->id}}" {{$module->id==old('module', $tieuChi->module_id)?'selected="true"':''}}>{{$module->modulename}}</option>
                                                    <!-- <input type="radio" class="flat" id="inpmodule{{$module->id}}" name="module" value="{{$module->id}}" {{$module->id==old('module')?'checked="true"':''}}>
                                                    <label for="inpmodule{{$module->id}}"> {{$module->tenmodule}} </label> &ensp;&ensp;&ensp; -->
                                                @endforeach
                                            </select>
                                        @endif
                                        <span class="help-block">
                                            <strong id="help-error-module">{{ $errors->first('module') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('trangthai') ? ' has-error' : ''}}">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="trangthai">Trạng thái<span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        @if(isset($dsTrangThai))
                                            @foreach($dsTrangThai as $trangThai)
                                                <input type="radio" class="TrangThai flat" id="inptrangthai{{$trangThai->id}}" name="trangthai" value="{{$trangThai->id}}" {{$trangThai->id==old('trangthai', $tieuChi->idtrangthai)?'checked="true"':''}}>
                                                <label for="inptrangthai{{$trangThai->id}}"> {{$trangThai->tentrangthai}} </label> &ensp;&ensp;&ensp;
                                            @endforeach
                                        @endif
                                        <span class="help-block">
                                            <strong id="help-error-minhchung">{{ $errors->first('trangthai') }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="row text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i><strong> LƯU </strong></button>
                        </div>
                    </form>
                @else
                    <div class="row text-center"><h3>Không tìm thầy dữ liệu vui lòng thử lại!</h3></div>
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
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/subadmin_tieuchi.js') !!}"></script>
@endsection