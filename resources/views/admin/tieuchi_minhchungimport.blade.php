@extends('admin.layout.master')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-upload"></i> UPLOAD MINH CHỨNG</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{route('admin_tieuchi_minhchung_importstore')}}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{csrf_field()}}
          <div class="row">
            @include('layouts.gentelella-master.blocks.flash-messages')
            <input type="text" name="idhockynamhoc" class="hidden" hidden="true" value="{{$idHocKy}}">
            <input type="text" name="idtieuchi" class="hidden" hidden="true" value="{{$tieuChi->id}}">
            @if(isset($tieuChi))
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="90%" class="text-justify-middle"> {!! $tieuChi->chimuctieuchi . " " .$tieuChi->tentieuchi!!}</th>
                            <th width="10%" class="text-center-middle">Tối đa {{$tieuChi->diemtoida}}đ</th>
                        </tr>
                    </thead> 
                </table>
            @endif
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('tenminhchung') ? ' has-error' : ''}}">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tên (mô tả minh chứng)<span class="required">*</span></label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="tenminhchung" name="tenminhchung" value="{{old('tenminhchung')}}" class="form-control">
                        <span class="help-block">
                            <strong id="help-error-minhchung">{{ $errors->first('tenminhchung') }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            <!-- <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('diem') ? ' has-error' : ''}}">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Điểm</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="number" id="diem" name="diem" value="{{old('diem')}}" max="100" min="-100" step="0.1" class="form-control">
                        <span class="help-block">
                            <strong id="help-error-minhchung">{{ $errors->first('diem') }}</strong>
                        </span>
                    </div>
                </div>
            </div> -->

            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('input_file') ? ' has-error' : ''}}">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Upload DS<span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <div class="btn-group">
                    <div class="input-group image-preview">
                      <input type="text" id="inp-minhchung" name="minhchung" value="{{old('minhchung')}}" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                          <span class="glyphicon glyphicon-remove"></span> Clear
                        </button>
                        <div class="btn btn-default image-preview-input">
                          <span class="glyphicon glyphicon-folder-open"></span>
                          <span class="image-preview-input-title">Browse</span>
                          <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="input_file" value="{{old('input_file')}}" /> <!-- rename it -->
                        </div>
                      </span>
                    </div>
                  </div>
                  <span class="help-block">
                    <strong id="help-error-minhchung">{{ $errors->first('input_file') }}</strong>
                  </span>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('input_file_scan') ? ' has-error' : ''}}">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Upload</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <div class="btn-group">

                    <div class="input-group image-preview">
                      <input type="text" id="inp-minhchung" name="minhchungfilescan" value="{{old('minhchungfilescan')}}" class="form-control file-preview-filename" disabled="disabled">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-default file-preview-clear" style="display:none;">
                          <span class="glyphicon glyphicon-remove"></span> Clear
                        </button>

                        <div class="btn btn-default file-preview-input">
                          <span class="glyphicon glyphicon-folder-open"></span>
                          <span class="file-preview-input-title">Browse</span>
                          <input type="file" accept="application/pdf, .doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="input_file_scan" value="{{old('input_file_scan')}}" />
                        </div>
                      </span>
                    </div>

                  </div>
                  <span class="help-block">
                    <strong id="help-error-minhchung">{{ $errors->first('input_file_scan') }}</strong>
                  </span>
                </div>
              </div>
            </div>

          </div>
          <hr>
          <div class="row text-center">
            <button class="btn btn-info btnimport">
              <i class="fa fa-upload"></i> <strong> IMPORT </strong>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @if (session('message'))
    <div id="div-studentListResult" class="row">
      <div class="x_panel">
        <div class="x_title">
          <h2> <i class="fa fa-info-circle"></i> THÔNG BÁO <small> INFORMATION MESSAGES</small></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>

        <div class="x_content">
          <textarea class="resizable_textarea form-control" rows="10" v-html="content" readonly="true" style="resize: none; font-family: Courier New;">{!! session('message') !!}</textarea>
        </div>
      </div>
    </div>
  @endif

@endsection
@section('javascript')
    @parent
    <!-- Upload bar -->
    <script src="{{URL::asset('js/mystyle_fileinput.js')}}"></script>

    <script type="text/javascript">
      $('.btnimport').click(function(){
        loadereffectshow();
      });
    </script>
@endsection