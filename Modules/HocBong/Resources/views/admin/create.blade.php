@extends('admin.layout.master')
@section('css')
    @parent
    <!-- iCheck -->
    <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection

@section('content')

  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <div class="pull-right">
          
          <button class="btn btn-success" onclick="myFunction()">Thêm thông báo</button>
          </a>
        </div>
        <h2> <i class="fa fa-graduation-cap"></i> THÔNG TIN HỌC BỔNG <small>SCHOLARSHIP INFORMATION</small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      

        <div class="row">
          @include('layouts.gentelella-master.blocks.flash-messages')
          <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{csrf_field()}}

         
            <div class="form-group col-md-4{{$errors->has('mahb')? ' has-error' : ''}}">
                <label class="control-label">Mã học bổng</label>
                <input type="text" id="mahb" name="mahb" class="form-control" value="{{old('mahb')}}" placeholder="Mã học bổng">
                @if ($errors->has('mahb'))
                        <span class="help-block">
                          <strong style="color: red">{{ $errors->first('mahb') }}</strong>
                        </span>
                @endif
            </div>
            

            <div class="form-group col-md-4{{ $errors->has('tenhb') ? ' has-error' : '' }}">
                <label class="control-label">Tên học bổng</label>
                    <input type="text" id="tenhb" name="tenhb" class="form-control" value="{{old('tenhb')}}" placeholder="Tên học bổng">
            </div>
             <div class="form-group col-md-4{{ $errors->has('tenhb') ? ' has-error' : '' }}">
                <label class="control-label">Tên đơn vị tài trợ</label>
                    <input type="text" id="tendvtt" name="tendvtt" class="form-control" value="{{old('tendvtt')}}" placeholder="Tên đơn vị tài trợ">
            </div>
            <div class="form-group col-md-4{{$errors->has('tendvtt')? ' has-error' : ''}}">
                <label class="control-label">Học kỳ, năm học</label>
                <select name="idhockynamhoc" id="idhockynamhoc" class="form-control">
                <option value="">--- Học kỳ, năm học ---</option>
                
                  @foreach($hockynamhoc as $hknh)
                    <option value="{{$hknh->id}}" {{\Request::get('hknh')==$hknh->id ? "selected='selected'" : ""}}>{{$hknh->tenhockynamhoc}}</option>
                  @endforeach
               
              </select>
                <span class="help-block"> <strong>{{ $errors->first('idhockynamhoc') }}</strong> </span>
            </div>

            <div class="form-group col-md-4{{$errors->has('thoigianBDDK')? ' has-error' : ''}}">
                <label class="control-label">Giá trị học bổng</label>
                    <input type="number" id="gthb" name="gthb"  class="form-control" value="{{old('gthb')}}" placeholder="Giá trị học bổng">
                <!-- <input type="date" name="thoigianBDDK" id="thoigianBDDK" class="form-control" value="{{old('thoigianBDDK')}}" autofocus> -->
                <span class="help-block"> <strong>{{ $errors->first('thoigianBDDK') }}</strong> </span>

            </div>
            <div class="form-group col-md-4{{$errors->has('thoigianKTDK')? ' has-error' : ''}}">
                <label class="control-label">Số lượng</label>
                    <input type="number" id="soluong" name="soluong" class="form-control" value="{{old('soluong')}}" placeholder="Số lượng">
                <!-- <input type="date" name="thoigianKTDK" id="thoigianKTDK" class="form-control" value="{{old('thoigianKTDK')}}" autofocus> -->
                <span class="help-block"> <strong>{{ $errors->first('thoigianKTDK') }}</strong> </span>

            </div>
            
            
            

            <div class="form-group col-md-6">
                    <h4 class="text-center">Khoa</h4>
                  <div class="well" style="height: 150px; overflow: auto;">
                    
                      <ul class="list-group checked-list-box {{ $errors->has('khoa[]') ? ' has-error' : '' }}">
                         <li class="list-group-item"> <input type="checkbox" id="select_all" class="flat"> <label for="">Toàn trường  </label> </li>
                           @if(isset($ds_khoa))
                              @foreach($ds_khoa as $data)
                        <li class="list-group-item" value="{{$data->id}}"> <input type="checkbox" id="{{$data->id}}" name="khoa[]" value="{{$data->id}}" class="checkbox flat"> <label for="">{{$data->tenkhoa}}  </label> </li>
                               @endforeach
                          @endif
                      </ul>
                       
                  </div>
            </div>
            <div class="form-group col-md-6{{$errors->has('selected_rating')? ' has-error' : ''}}">
               <label class="control-label">Giá trị mỗi học bổng</label>
                    <input type="number" id="gtmoihocbong" name="gtmoihocbong" class="form-control" value="{{old('gtmoihocbong')}}" placeholder="Giá trị mỗi học bổng">
                <!-- <input type="date" name="thoigianKTDK" id="thoigianKTDK" class="form-control" value="{{old('thoigianKTDK')}}" autofocus> -->
                <span class="help-block"> <strong>{{ $errors->first('thoigianKTDK') }}</strong> </span>
            </div>

            <div class="x_title">
              <div class="clearfix"></div>
            </div>
            <div id="themthongbao" style="display: none;">
            <div class="form-group">
              <label for="" class="control-label col-sm-12 col-md-3 col-lg-2">
                Tiêu đề thông báo:
              </label>
              <div class="col-sm-12 col-md-9 col-lg-8">
                <input type="text" name="tieude" id="tieude" class="form-control" value="{{old('tieude')}}" placeholder="Tiêu đề">
                            @if ($errors->has('tieude'))
                              <span class="help-block">
                                <strong style="color: red">{{ $errors->first('tieude') }}</strong>
                              </span>
                            @endif
              </div>
                
            </div>
            <div class="form-group">
              <label for="" class="control-label col-sm-12 col-md-3 col-lg-2">
                Nội dung thông báo
              </label>
              <div class="col-sm-12 col-md-9 col-lg-10">
               <textarea name="noidung" id="noidung" class="ckeditor"  rows="5" class="form-control" placeholder="Nội dung thông báo">{{ old('noidung') }}</textarea>
                            @if ($errors->has('noidung'))
                              <span class="help-block">
                                <strong style="color: red">{{ $errors->first('noidung') }}</strong>
                              </span>
                            @endif
              </div>
                
            </div>

            <div class="one-more add-more-after">
              <div class="form-group">
                        <label for="" class="control-label col-sm-12 col-md-3 col-lg-2">
                           File văn bản
                        </label>

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
                     
                    <div class="form-group">
                        <label class="control-label col-sm-12 col-md-3 col-lg-2" for="">Tên văn bản<span class="required"></span></label>

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
<!--                 <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 ">
 -->                    <div class="form-group">
                        <label class="control-label col-sm-12 col-md-3 col-lg-2" for="">File văn bản<span class="required"></span></label>

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
                <!-- </div> -->
                    <div class="form-group">
                        <label class="control-label col-sm-12 col-md-3 col-lg-2" for="">Tên văn bản<span class="required"></span></label>

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

            <div class="x_title">
              <div class="clearfix"></div>
            </div>

            <div class="row col-md-12 text-center">
              <button type="submit" class="btn btn-primary save_hdsk"> <strong><i class="fa fa-save" aria-hidden="true"></i> LƯU </strong></button>
            </div>

          </form>
        </div>
      </div>
  
     
    </div>
  </div>
@endsection
@section('javascript')
    @parent
    <!-- iCheck -->
    

    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
    <script src="{{URL::asset('js/admin_canbogiangvien.khoa.bomon.js')}}"></script>
    <script src="{{URL::asset('js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{URL::asset('js/ckfinder/ckfinder.js')}}"></script>
  
     <script src="{{URL::asset('js/jquery.min.js')}}"></script>
     <script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
    
  </script>
      <script>
          $('#select_all').change(function() {
          var checkboxes = $(this).closest('form').find(':checkbox').not($(this));
          checkboxes.prop('checked', $(this).is(':checked'));
        });
      </script>
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
    $('.add').click(function() {
    $('.optionBox').append('<input type="text" /><span class="remove">Remove Option</span>');
});
  </script>
  <script type="text/javascript">
    function myFunction() {
  var x = document.getElementById("themthongbao");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
  </script>

   
  
   
@endsection