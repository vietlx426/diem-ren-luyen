@extends('subadmin.layout.master')
@section('css')
  @parent
  <!-- bootstrap-daterangepicker -->
  <link href="{{URL::asset('gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
  <!-- bootstrap-datetimepicker -->
  <link href="{{URL::asset('gentelella-master/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{URL::asset('gentelella-master/vendors/select2/dist/css/select2.min.css')}}">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-futbol-o"></i> HOẠT ĐỘNG - SỰ KIỆN <small>ACTIVITIES - EVENTS</small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          @include('layouts.gentelella-master.blocks.flash-messages')

          <form action="{{route('post_subadmin_hoatdongsukien_edit',['id'=>$hoatdongsukien->id])}}" method="POST" class="form-horizontal form-label-left">
            {{csrf_field()}}
            
            <div class="form-group col-md-6{{$errors->has('tenhoatdongsukien')? ' has-error' : ''}}">
                <label for="tenhoatdongsukien" class="control-label"> Tên hoạt động sự kiện </label>
                <input type="text" name="tenhoatdongsukien" id="tenhoatdongsukien" class="form-control" value="{{$hoatdongsukien->tenhoatdongsukien}}" placeholder="Tên hoạt động sự kiện" autofocus>
                
            </div>
            <div class="form-group col-md-6{{$errors->has('loaihoatdongsukien')? ' has-error' : ''}}">
              <label for="loaihoatdongsukien" class="control-label"> Loại hoạt động sự kiện </label>
              <select name="loaihoatdongsukien" id="loaihoatdongsukien" class="form-control">
                <option value=""> --- Chọn loại hoạt động - sự kiện --- </option>

                @if(isset($DS_LoaiHoatDongSuKien))
                    @foreach($DS_LoaiHoatDongSuKien as $LoaiHDSK)
                        <option 
                          @if($hoatdongsukien->loaihoatdongsukien->id == $LoaiHDSK->id)
                          {{'selected'}}
                          @endif
                        value="{{$LoaiHDSK->id}}" {{old('loaihoatdongsukien') == $LoaiHDSK->id ? 'selected="true"' : ''}}> {{$LoaiHDSK->tenloaihoatdongsukien}} </option>
                    @endforeach
                @endif
              </select>
              <span class="help-block"> <strong>{{ $errors->first('loaihoatdongsukien') }}</strong> </span>
            </div>

            <div class="form-group col-md-6{{$errors->has('thoigianbatdau')? ' has-error' : ''}}">
                <label for="thoigianbatdau" class="control-label"> Thời gian bắt đầu</label>
                <div class='input-group date' id='myDatepickerStart'>
                    <input type='text' name="thoigianbatdau" class="form-control" value="{{old('thoigianbatdau', ($hoatdongsukien->thoigianbatdau ? date('d/m/Y h:i',strtotime($hoatdongsukien->thoigianbatdau)) : ''))}}"   readonly="true">
                    <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <span class="help-block"> <strong>{{ $errors->first('thoigianbatdau') }}</strong> </span>
            </div>
            <div class="form-group col-md-6{{$errors->has('thoigianketthuc')? ' has-error' : ''}}">
                <label for="thoigianketthuc" class="control-label"> Thời gian kết thúc</label>
                <div class='input-group date' id='myDatepickerEnd'>
                    <input type='text' name="thoigianketthuc" id="thoigianketthuc" class="form-control" value="{{old('thoigianketthuc', ($hoatdongsukien->thoigianketthuc ? date('d/m/Y h:i:s',strtotime($hoatdongsukien->thoigianketthuc)) : ''))}}" readonly="true">
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <span class="help-block"> <strong>{{ $errors->first('thoigianketthuc') }}</strong> </span>
            </div>

            <div class="form-group col-md-6{{$errors->has('thoigianBDDK')? ' has-error' : ''}}">
                <label for="thoigianBDDK" class="control-label"> Thời gian bắt đầu đăng ký</label>
                <div class='input-group date' id='myDatepickerRegStart'>
                    <input type='text' name="thoigianBDDK" id="thoigianBDDK" class="form-control" value="{{old('thoigianBDDK', ($hoatdongsukien->thoigianbatdaudangky ? date('d/m/Y',strtotime($hoatdongsukien->thoigianbatdaudangky)) : ''))}}" readonly="true">
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <span class="help-block"> <strong>{{ $errors->first('thoigianBDDK') }}</strong> </span>

            </div>
            <div class="form-group col-md-6{{$errors->has('thoigianKTDK')? ' has-error' : ''}}">
                <label for="thoigianKTDK" class="control-label"> Thời gian kết thúc đăng ký </label>
                <div class='input-group date' id='myDatepickerRegEnd'>
                    <input type='text' name="thoigianKTDK" id="thoigianKTDK" class="form-control" value="{{old('thoigianKTDK', ($hoatdongsukien->thoigianketthucdangky ? date('d/m/Y',strtotime($hoatdongsukien->thoigianketthucdangky)) : '' ))}}" readonly="true">
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <span class="help-block"> <strong>{{ $errors->first('thoigianKTDK') }}</strong> </span>

            </div>
            
            <div class="form-group col-md-6{{$errors->has('diadiem')? ' has-error' : ''}}">
                <label for="diadiem" class="control-label"> Địa điểm </label>
                <textarea name="diadiem" id="diadiem" placeholder="Địa điểm" class="form-control" style="resize: none;">{{$hoatdongsukien->diadiem}}</textarea>
                <span class="help-block"> <strong>{{ $errors->first('diadiem') }}</strong> </span>

            </div>
            <div class="form-group col-md-6{{$errors->has('ghichu')? ' has-error' : ''}}">
                <label for="ghichu" class="control-label"> Ghi chú </label>
                <textarea name="ghichu" id="ghichu" placeholder="Ghi chú" class="form-control" style="resize: none;">{{$hoatdongsukien->ghichu}} </textarea>
                <span class="help-block"> <strong>{{ $errors->first('ghichu') }}{!!$errors->has('diadiem')? '<br>' : ''!!}</strong> </span>

            </div>

            <div class="form-group col-md-6">
                    <label for="hockynamhoc" class="control-label"> Học kỳ - Năm học </label>
                    <select name="hockynamhoc" id="hockynamhoc" class="hockynamhoc Khoa form-control">
                      @if(isset($DS_HocKyNamHoc))
                          @foreach($DS_HocKyNamHoc as $HocKyNamHoc)
                              <option 
                              @if($hoatdongsukien->hocky_namhoc_id == $HocKyNamHoc->id)
                              {{'selected'}}
                              @endif
                              value="{{$HocKyNamHoc->id}}" {{old('hockynamhoc') == $HocKyNamHoc->id ? 'selected="true"' : ($HocKyNamHoc->idtrangthaihocky == 2) ? 'selected="true"' : ''}}> {{$HocKyNamHoc->tenhockynamhoc}} </option>
                          @endforeach
                      @endif
                    </select>
                    <span class="help-block"> <strong>{{ $errors->first('hockynamhoc') }}</strong> </span>
            </div>
            <div class="form-group col-md-6{{$errors->has('selected_rating')? ' has-error' : ''}}">
                <label for="ghichu" class="control-label"> Đánh giá hoạt động <strong><span class="selected-rating">{{$hoatdongsukien->xeploaihoatdongsukien}}</span></strong><small>/5</small></label>
                <div class="" id="rating-ability-wrapper">
                    <input type="hidden" id="selected_rating" name="selected_rating" value="{{old('selected_rating', $hoatdongsukien->xeploaihoatdongsukien)}}">
                    
                    <button type="button" class="btnrating btn {{old('selected_rating', $hoatdongsukien->xeploaihoatdongsukien) >= 1 ? 'btn-warning' : 'btn-default'}}" data-attr="1" id="rating-star-1">
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating btn {{old('selected_rating', $hoatdongsukien->xeploaihoatdongsukien) >= 2 ? 'btn-warning' : 'btn-default'}}" data-attr="2" id="rating-star-2">
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating btn {{old('selected_rating', $hoatdongsukien->xeploaihoatdongsukien) >= 3 ? 'btn-warning' : 'btn-default'}}" data-attr="3" id="rating-star-3">
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating btn {{old('selected_rating',$hoatdongsukien->xeploaihoatdongsukien) >= 4 ? 'btn-warning' : 'btn-default'}}" data-attr="4" id="rating-star-4">
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating btn {{old('selected_rating', $hoatdongsukien->xeploaihoatdongsukien) >= 5 ? 'btn-warning' : 'btn-default'}}" data-attr="5" id="rating-star-5">
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                </div>
                <span class="help-block"> <strong>{{ $errors->first('selected_rating') }}</strong> </span>
            </div>

            <div class="x_title">
              <div class="clearfix"></div>
            </div>
            
            <div class="form-group">
              <label for="" class="control-label col-sm-12 col-md-3 col-lg-2">
                Tiêu chí:
              </label>
              <div class="col-sm-12 col-md-9 col-lg-10">
                <select name="tieuchi" id="tieuchi" class="form-control">
                  @if(isset($DS_TieuChi))
                    <option value="">----- Chọn tiêu chí -----</option>
                    @foreach($DS_TieuChi as $key => $TieuChi)
                      @if($TieuChi['levelhierachy'] == 0)
                        <?php $label_optgrouptext = $TieuChi['tentieuchi']; ?>
                      <optgroup label="{!!$label_optgrouptext!!}">SDFDS
                      </optgroup>
                      @else
                        <option
                        @if( $HDSKTC['tieuchi_id'] == $TieuChi['id'])
                        {{'selected'}}
                        @endif
                         class="level_{{$TieuChi['levelhierachy']}}" value="{!!$TieuChi['id']!!}">{!!$TieuChi['tentieuchi']!!}</option>
                        }}
                      @endif

                      
                    @endforeach
                  @endif
                </select>
              </div>
                
            </div>
            <div class="form-group">
              <label for="" class="control-label col-sm-12 col-md-3 col-lg-2">
                Lớp:
              </label>
              <div class="col-sm-12 col-md-9 col-lg-10">
                
                <select name="lop[]" id="lop[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                  @if(isset($DS_Lop))
                    <option value="">----- Chọn lớp -----</option>

                    @foreach($DS_Lop as $lp)

                      <?php $boolChon = false; ?>
                      
                      @foreach($HDSKDCL as $cholop)
                        @if($lp->id == $cholop['lop_id'])
                          <?php $boolChon = true; ?>
                        @endif
                      
                      @endforeach

                      <option 
                        {{$boolChon ? 'selected' : ''}}
                       value="{{$lp->id}}" {{old('lop') == $lp->id ? 'selected="true"' : ''}}> {{$lp->tenlop}} </option>

                    @endforeach
                  @endif
                </select>
              </div>
                
            </div>

            <div class="form-group">
              <div class="col-md-6">
                <div class="row">
                  <label for="" class="control-label col-sm-12 col-md-6 col-lg-4">
                    Điểm cộng:
                  </label>
                  <div class="col-sm-12 col-md-6 col-lg-8">
                    <input type="number" name="diemcong" class="form-control" min="0" value="{{old('diemcong', $HDSKTC? $HDSKTC->diemcong : '0') }}" placeholder="Điểm cộng">
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="row">
                  <label for="" class="control-label col-sm-12 col-md-6 col-lg-4">
                    Điểm trừ:
                  </label>
                  <div class="col-sm-12 col-md-6 col-lg-8">
                    <input type="number" name="diemtru" class="form-control" min="0" value="{{old('diemtru', $HDSKTC? $HDSKTC->diemtru : '0') }}" placeholder="Điểm trừ">
                  </div>
                </div>
              </div>

            </div>

            <div class="x_title">
              <div class="clearfix"></div>
            </div>

            <div class="row col-md-12 text-center">
              <button type="submit" class="btn btn-primary save_hdsk"><i class="fa fa-save" aria-hidden="true"></i> <strong> LƯU </strong> </button>
            </div>

          </form>
        </div>
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
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

  })
</script>
    
    <script>
      $('#myDatepickerStart').datetimepicker({
        ignoreReadonly: true,
        allowInputToggle: true,
        format: 'DD/MM/YYYY hh:mm A'
      });

      $('#myDatepickerEnd').datetimepicker({
        ignoreReadonly: true,
        allowInputToggle: true,
        format: 'DD/MM/YYYY hh:mm A'
      });

      $('#myDatepickerRegStart').datetimepicker({
        ignoreReadonly: true,
        allowInputToggle: true,
        format: 'DD/MM/YYYY'
      });
      $('#myDatepickerRegEnd').datetimepicker({
        ignoreReadonly: true,
        allowInputToggle: true,
        format: 'DD/MM/YYYY'
      });

      $(".btnrating").on('click',(function(e) {
  
        var previous_value = $("#selected_rating").val();
        
        var selected_value = $(this).attr("data-attr");
        $("#selected_rating").val(selected_value);
        
        $(".selected-rating").empty();
        $(".selected-rating").html(selected_value);
        
        for (i = 1; i <= selected_value; ++i) {
        $("#rating-star-"+i).toggleClass('btn-warning');
        $("#rating-star-"+i).toggleClass('btn-default');
        }
        
        for (ix = 1; ix <= previous_value; ++ix) {
        $("#rating-star-"+ix).toggleClass('btn-warning');
        $("#rating-star-"+ix).toggleClass('btn-default');
        }
        
      }));

      // alert($('.level0').text());
      $('.level_1').each(
          function(){
              $(this).html('&nbsp;&nbsp;&nbsp;'+$(this).text());
          }
      );

      $('.level_2').each(
          function(){
              $(this).html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+$(this).text());
          }
      );

      $('.level_3').each(
          function(){
              $(this).html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+$(this).text());
          }
      );
    </script>
    
@endsection