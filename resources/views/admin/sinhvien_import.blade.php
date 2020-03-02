@extends('admin.layout.master')

@section('title')
  @parent | Upload student list
@endsection

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-upload"></i> UPLOAD SÁCH SINH VIÊN <small>IMPORT</small></h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <form action="{{route('post_admin_sinhvien_import')}}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{csrf_field()}}
          
          <div class="row">
            @include('layouts.gentelella-master.blocks.flash-messages')
            <!-- <div class="col-md-5 col-xs-12{{$errors->has('lop') ? ' has-error' : ''}}">
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Lớp <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <select name="lop" id="lop" class="form-control">
                      <option value="">----- Chọn lớp -----</option>
                      @if(asset($dsLop))
                        @foreach($dsLop as $Lop)
                          <option value="{{$Lop->id}}" {{old('lop') == $Lop->id ? 'selected="true"' : ''}}>{{$Lop->tenlop}}</option>
                        @endforeach
                      @endif
                    </select>

                    <span class="help-block">
                        <strong id="help-error-minhchung">{{ $errors->first('lop') }}</strong>
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
                        <!-- image-preview-clear button -->
                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;" title="Chỉ chấp nhận file .pdf">
                          <span class="glyphicon glyphicon-remove"></span> Clear
                        </button>
                        <!-- image-preview-input -->
                        <div class="btn btn-default image-preview-input">
                          <span class="glyphicon glyphicon-folder-open"></span>
                          <span class="image-preview-input-title">Browse</span>
                          <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="input_file" value="{{old('input_file')}}" /> <!-- rename it -->
                        </div>
                      </span>
                    </div>
                  </div><!-- /input-group image-preview [TO HERE]--> 

                  <span class="help-block">
                      <strong id="help-error-minhchung">{{ $errors->first('input_file') }}</strong>
                  </span>
                </div>
                
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 has-error text-center">
              <div class="form-group">
                <!-- <label class="control-label">Vui lòng upload danh sách mỗi lần tối đa 300 sinh viên</label> -->
              </div>
            </div>

          </div>

          <hr>

          <div class="row text-center">
            <button class="btn btn-info student_import">
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
      $('.student_import').click(function(){
        loadereffectshow();
      });
    </script>
@endsection