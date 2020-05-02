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
        <h2> <i class="fa fa-graduation-cap"></i> THÔNG TIN HỌC BỔNG TEST <small>SCHOLARSHIP INFORMATION</small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      

        <div class="row">
          @include('layouts.gentelella-master.blocks.flash-messages')
          <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{csrf_field()}}

         
            <div class="form-group col-md-4{{$errors->has('mahb')? ' has-error' : ''}}">
                <label class="control-label">Mã học bổng</label>
                <input type="text" id="mahb" name="mahb" class="form-control" value="{{old('mahb',$scholar->mahb)}}" placeholder="Mã học bổng">
                @if ($errors->has('mahb'))
                <span class="help-block">
                  <strong>{{ $errors->first('mahb') }}</strong>
                </span>
              @endif
            </div>
            

            <div class="form-group col-md-4{{ $errors->has('tenhb') ? ' has-error' : '' }}">
                <label class="control-label">Tên học bổng</label>
                    <input type="text" id="tenhb" name="tenhb" class="form-control" value="{{old('tenhb',$scholar->tenhb)}}" placeholder="Tên học bổng">
            </div>
             <div class="form-group col-md-4{{ $errors->has('tenhb') ? ' has-error' : '' }}">
                <label class="control-label">Tên đơn vị tài trợ</label>
                   <input type="text" id="tendvtt" name="tendvtt" class="form-control" value="{{old('tendvtt',$scholar->tendvtt)}}" placeholder="Tên đơn vị tài trợ">
            </div>
            <div class="form-group col-md-4{{$errors->has('tendvtt')? ' has-error' : ''}}">
                <label class="control-label">Học kỳ, năm học</label>
                <select name="idhockynamhoc" id="idhockynamhoc" class="form-control">
                <option value="">--- Học kỳ, năm học ---</option>
                
                  @if(isset($hockynamhoc))
                        @foreach($hockynamhoc as $data)
                        <option value = "{{ $data ->id }}" {{old('idhockynamhoc',isset($scholar->idhockynamhoc)  ? $scholar->idhockynamhoc : '')==$data->id ? "selected='select'" : "" }}>{{$data->tenhockynamhoc}} </option>
                        @endforeach
                  @endif
               
              </select>
                <span class="help-block"> <strong>{{ $errors->first('idhockynamhoc') }}</strong> </span>
            </div>

            <div class="form-group col-md-4{{$errors->has('thoigianBDDK')? ' has-error' : ''}}">
                <label class="control-label">Giá trị học bổng</label>
                    <input type="number" id="gthb" name="gthb" class="form-control" value="{{old('gthb',$scholar->gthb)}}" placeholder="Giá trị học bổng">
                <!-- <input type="date" name="thoigianBDDK" id="thoigianBDDK" class="form-control" value="{{old('thoigianBDDK')}}" autofocus> -->
                <span class="help-block"> <strong>{{ $errors->first('thoigianBDDK') }}</strong> </span>

            </div>
            <div class="form-group col-md-4{{$errors->has('thoigianKTDK')? ' has-error' : ''}}">
                <label class="control-label">Số lượng</label>
                    <input type="number" id="soluong" name="soluong" class="form-control" value="{{old('soluong',$scholar->soluong)}}" placeholder="Số lượng">
                <!-- <input type="date" name="thoigianKTDK" id="thoigianKTDK" class="form-control" value="{{old('thoigianKTDK')}}" autofocus> -->
                <span class="help-block"> <strong>{{ $errors->first('thoigianKTDK') }}</strong> </span>

            </div>
            
            
            

            <div class="form-group col-md-6">
                    <h4 class="text-center">Khoa</h4>
                  <div class="well" style="height: 150px; overflow: auto;">
                    
                      <ul class="list-group checked-list-box">
                         <li class="list-group-item"> <input type="checkbox" id="select_all" class="flat"> <label for="">Toàn trường  </label> </li>
                            @if(isset($ds_khoa))
                              @foreach($ds_khoa as $khoa)
                                <?php 
                                  $strchk="";
                                  foreach (old('khoa', $dsKhoaCuaHocBong) as $key => $khoaHocBong) {
                                    if ($khoa->id == $khoaHocBong->id_khoa)
                                      $strchk = 'checked="true"';
                                  }
                                 ?>
                                  <li class="list-group-item" value="{{$khoa->id}}"> <input type="checkbox" id="{{$khoa->id}}" name="khoa[]" value="{{$khoa->id}}" class="flat" {{$strchk}} >
                                  <label for="{{$khoa->id}}"> {{$khoa->tenkhoa}} </label> </li>
                              @endforeach
                          @endif
                      </ul>
                       
                  </div>
            </div>
            <div class="form-group col-md-6{{$errors->has('selected_rating')? ' has-error' : ''}}">
               <label class="control-label">Giá trị mỗi học bổng</label>
                    <!-- <input type="number" id="gtmoihocbong" name="gtmoihocbong" class="form-control" value="{{old('gtmoihocbong')}}" placeholder="Giá trị mỗi học bổng"> -->
                    <input type="number" id="gtmoihocbong" name="gtmoihocbong" class="form-control" value="{{old('gtmoihocbong',$scholar->gtmoihocbong)}}" placeholder="Giá trị mỗi học bổng">
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


<!--/////////////////////////////////////////////////////// -->
  
@endsection
@section('javascript')
    @parent
    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
    <script src="{{URL::asset('js/admin_canbogiangvien.khoa.bomon.js')}}"></script>

    <script>
      var url_route_admin_get_bomonbykhoa = "{{route('admin_get_bomonbykhoa')}}";
    </script>
    <script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
    
  </script>
  <script src="{{URL::asset('js/jquery.min.js')}}"></script>
      <script>
          $('#select_all').change(function() {
          var checkboxes = $(this).closest('form').find(':checkbox').not($(this));
          checkboxes.prop('checked', $(this).is(':checked'));
        });
      </script>

@endsection