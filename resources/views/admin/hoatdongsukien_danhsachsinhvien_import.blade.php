@extends('admin.layout.master')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">

@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-upload"></i> NHẬP DANH SÁCH SINH VIÊN <small>IMPORT</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <form action="{{route('admin_post_hoatdongsukien_importsinhvien')}}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="text" name="HDSK" value="{{isset($hoatDongSuKien) ? $hoatDongSuKien->id : ''}}" class="hidden" hidden="true">
          
          <div class="row">
            @include('layouts.gentelella-master.blocks.flash-messages')
            <div class="row">
                @if(isset($hoatDongSuKien))
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <strong> {{($hoatDongSuKien->tenhoatdongsukien)}} </strong>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <strong> <i class="fa fa-calendar"></i> {{ date('h:i A d/m/Y', strtotime($hoatDongSuKien->thoigianbatdau))}} </strong>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <strong> <i class="fa fa-map-marker"></i> {{($hoatDongSuKien->diadiem)}} </strong>
                    </div>
                    <hr>
                @endif
            </div>

            <div class="col-md-10 col-xs-12{{$errors->has('input_file') ? ' has-error' : ''}}">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Upload DS<span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <div class="btn-group" title="Chỉ chấp nhận file .pdf">
                    <div class="input-group image-preview">
                      <input type="text" id="inp-minhchung" name="minhchung" value="{{old('minhchung')}}" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
                      <span class="input-group-btn" title="Chỉ chấp nhận file .pdf">
                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;" title="Chỉ chấp nhận file .pdf">
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
          </div>

          <hr>

          <div class="row text-center">
            <button class="btn btn-success student_import">
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
@endsection