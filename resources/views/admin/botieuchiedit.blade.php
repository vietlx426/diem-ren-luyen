@extends('admin.layout.master')
@section('title')
  @parent | Bộ tiêu chí
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-edit"></i> BỘ TIÊU CHÍ </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{route('admin_botieuchi_update')}}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{csrf_field()}}
            @include('layouts.gentelella-master.blocks.flash-messages')
            @if(isset($boTieuChi))
                <input type="text" id="idbotieuchi" name="idbotieuchi" class="hidden" hidden="true" value="{{$boTieuChi->id}}">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('tenbotieuchi') ? ' has-error' : ''}}">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tenbotieuchi">Bộ tiêu chí<span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="tenbotieuchi" id="tenbotieuchi" class="form-control" value="{{old('tenbotieuchi', $boTieuChi->tenbotieuchi)}}" placeholder="Bộ tiêu chí">
                                <span class="help-block">
                                    <strong id="help-error-minhchung">{{ $errors->first('tenbotieuchi') }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('motabotieuchi') ? ' has-error' : ''}}">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="motabotieuchi">Mô tả/Ghi chú<span class="required"></span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <textarea name="motabotieuchi" id="motabotieuchi"  rows="5" class="form-control" placeholder="Mô tả/Ghi chú">{{old('motabotieuchi', $boTieuChi->mota)}}</textarea>
                                <span class="help-block">
                                    <strong id="help-error-minhchung">{{ $errors->first('motabotieuchi') }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 {{$errors->has('input_file') ? ' has-error' : ''}}">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">File (vb minh chứng)<span class="required"></span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                
                                <div class="btn-group">
                                    @if($boTieuChi->filename)
                                        <a href="{{route('admin_botieuchi_download', ['id'=>$boTieuChi->id])}}" class="btn btn-danger" title="Tải file văn bản"> &nbsp; <i class="fa fa-download"></i> &nbsp; </a>
                                    @endif
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
                                                <input type="file" accept="application/pdf, .doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" name="input_file" value="{{old('input_file')}}" /> <!-- rename it -->
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

                <div class="row">
                    <div class="col-12 text-center">
                        <button class="btn btn-primary btn-save"><i class="fa fa-save"></i><strong> LƯU </strong></button>
                    </div>
                </div>
            @else
                <div class="row text-center"><h3>KHÔNG CÓ DỮ LIỆU!</h3></div>
            @endif
        </form>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
    @parent
    <!-- Upload bar -->
    <script src="{{URL::asset('js/mystyle_fileinput.js')}}"></script>
    <script type="text/javascript">
      $('.btn-save').click(function(){
        loadereffectshow();
      });
    </script>
@endsection