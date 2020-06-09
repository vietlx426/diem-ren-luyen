@extends('admin.layout.master')
@section('title')
  @parent | Tạo mới thông báo
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        
        <h2>THÊM MỚI THÔNG BÁO</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
       <form action="{{route('thongbao.store')}}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{csrf_field()}}
            @include('layouts.gentelella-master.blocks.flash-messages')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 ">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tieude">Tiêu đề<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="tieude" id="tieude" class="form-control" value="{{old('tieude')}}" placeholder="Tiêu đề">
                            @if ($errors->has('tieude'))
                              <span class="help-block">
                                <strong style="color: red">{{ $errors->first('tieude') }}</strong>
                              </span>
                            @endif
                            
                        </div>
                    </div>
                </div>
                 <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tieude">Học bổng<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select name="hocbong" id="hocbong" class="form-control">
                                <option value="">--- Chọn học bổng ---</option>
                             @foreach($dsHocBong as $data)
                                <option value="{{$data->idhb}}" {{$data->idhb == old('hocbong') ? 'selected="true"' : ''}}>{{$data->tenhb}}</option>
                              @endforeach
                            </select>
                            @if ($errors->has('hocbong'))
                              <span class="help-block">
                                <strong style="color: red">{{ $errors->first('hocbong') }}</strong>
                              </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 ">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="motabotieuchi">Nội dung thông báo<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea name="noidung" id="noidung" class="ckeditor"  rows="5" class="form-control" placeholder="Nội dung thông báo">{{ old('noidung') }}</textarea>
                            @if ($errors->has('noidung'))
                              <span class="help-block">
                                <strong style="color: red">{{ $errors->first('noidung') }}</strong>
                              </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="one-more add-more-after">
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 ">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">File văn bản<span class="required"></span></label>

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="btn-group">
                                <div class="input-group image-preview">

                                    
                                    <input type="text" class="form-control" id="DinhKem1" name="DinhKem[]" value="" readonly="readonly" placeholder="" />
                                    <span class="input-group-btn" >
                                        <!-- image-preview-clear button -->
                                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;" title="">
                                        <span class="glyphicon glyphicon-remove"></span> Clear
                                        </button>
                                        <!-- image-preview-input -->
                                        <div class="btn btn-default image-preview-input">
                                            
                                            <span class="image-preview-input-title"><a href="#dinhkem" onclick="BrowseServer(1);">Chọn tập tin</a></span>
                                            
                                            
                                        </div>
                                        <div class="btn btn-default image-preview-input btn-add-more">
                                          <i class="fa fa-plus" ></i>
                                          
                                        </div>

                                    </span>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Tên văn bản<span class="required"></span></label>

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="btn-group">
                                <div class="input-group image-preview">
                                  
                                    <input type="text" name="tenvanban[]" id="tenvanban" class="form-control" value="{{old('tenbotieuchi')}}" placeholder="Tên văn bản">
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
              </div>
              <div style="display: none">
                <div class="copy">
                <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 ">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">File văn bản <span class="required"></span></label>

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="btn-group">
                                <div class="input-group image-preview">

                                    
                                    <input type="text" class="form-control" id="DinhKem1" name="DinhKem[]" value="" readonly="readonly" placeholder="" />
                                    <span class="input-group-btn">
                                        <!-- image-preview-clear button -->
                                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;" title="Chỉ chấp nhận file .pdf">
                                        <span class="glyphicon glyphicon-remove"></span> Clear
                                        </button>
                                        <!-- image-preview-input -->
                                        <div class="btn btn-default image-preview-input">
                                            
                                            <span class="image-preview-input-title"><a href="#dinhkem" onclick="">Chọn tập tin</a></span>
                                            
                                            
                                        </div>
                                        <div class="btn btn-default image-preview-input btn-remover">
                                          <i class="fa fa-minus" ></i>
                                          
                                        </div>

                                    </span>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Tên văn bản<span class="required"></span></label>

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="btn-group">
                                <div class="input-group image-preview">
                                  
                                    <input type="text" name="tenvanban[]" id="tenvanban" class="form-control" value="{{old('tenbotieuchi')}}" placeholder="Tên văn bản">
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
              </div>
              </div>
              </div>
            </div>

            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-primary btn-save"><i class="fa fa-save"></i><strong> LƯU </strong></button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
  <script src="{{URL::asset('js/ckeditor/ckeditor.js')}}"></script>
  <script src="{{URL::asset('js/ckfinder/ckfinder.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      
      
      var index = 2;
      $(".btn-add-more").click(function() {
        $(".copy input[name^='DinhKem']").attr("id", "DinhKem" + index);
        $(".copy input[name^='tenvanban']").attr("id", "tenvanban" + index);
        $(".copy a").attr("onclick", "BrowseServer(" + index + ");");
        index++;
        
        var html = $(".copy").html();
        $(".add-more-after").after(html);
      });
      $("body").on("click", ".btn-remover", function() {
        $(this).parents(".form-group").remove();
      });
    });
    
    function BrowseServer(index)
    {
      var finder = new CKFinder();
      finder.basePath = "../";
      finder.startupPath = "Files:/";
      finder.selectActionFunction = function(fileUrl) {
        document.getElementById("DinhKem" + index).value = fileUrl.substring(fileUrl.lastIndexOf('/') + 1);
      };
      finder.popup();
    }
    
  </script>
@endsection