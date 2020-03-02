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
        <h2> <i class="fa fa-calendar"></i> THỜI GIAN ĐÁNH GIÁ ĐIỂM RÈN LUYỆN </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          @include('layouts.gentelella-master.blocks.flash-messages')

          <form action="{{route('post_subadmin_thoigiandanhgiaDRL_add')}}" method="POST" class="form-horizontal form-label-left">
            {{csrf_field()}}
            <div class="row">
              <div class="form-group col-md-6">
                <label for="hockynamhoc" class="control-label"> Học kỳ - Năm học </label>
                <select name="hockynamhoc" id="hockynamhoc" class="hockynamhoc Khoa form-control">
                  @if(isset($DS_HocKyNamHoc))
                      @foreach($DS_HocKyNamHoc as $HocKyNamHoc)
                          <option value="{{$HocKyNamHoc->id}}" {{old('hockynamhoc') == $HocKyNamHoc->id ? 'selected="true"' : ($HocKyNamHoc->idtrangthaihocky == 2) ? 'selected="true"' : ''}}> {{$HocKyNamHoc->tenhockynamhoc}} </option>
                      @endforeach
                  @endif
                </select>
                <span class="help-block"> <strong>{{ $errors->first('hockynamhoc') }}</strong> </span>
              </div>
              <div class="form-group col-md-6{{$errors->has('lop')? ' has-error' : ''}}">
                <label for="lop" class="control-label">
                  Lớp:
                </label>
                <div>
                  <select name="lop[]" id="lop" class="form-control select2" multiple="multiple" style="width: 100%;">
                    @if(isset($DS_Lop))
                      <option value="">----- Chọn lớp -----</option>
                      @foreach($DS_Lop as $lp)
                         <option value="{{$lp->id}}" {{old('lop') == $lp->id ? 'selected="true"' : ''}}> {{$lp->tenlop}} </option>
                      @endforeach
                    @endif
                  </select>
                </div>
                 <span class="help-block"> <strong>{{ $errors->first('lop') }}</strong> </span>
              </div>
            </div>
            
            <div class="form-group col-md-6{{$errors->has('thoigianbatdau')? ' has-error' : ''}}">
                <label for="thoigianbatdau" class="control-label"> Thời gian bắt đầu</label>
                <div class='input-group date' id='myDatepickerRegStart'>
                    <input type='text' name="thoigianbatdau" class="form-control" value="{{old('thoigianbatdau')}}"  readonly="true">
                    <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <span class="help-block"> <strong>{{ $errors->first('thoigianbatdau') }}</strong> </span>

            </div>
            <div class="form-group col-md-6{{$errors->has('thoigiankethuc')? ' has-error' : ''}}">
                <label for="thoigiankethuc" class="control-label"> Thời gian kết thúc</label>
                <div class='input-group date' id='myDatepickerRegEnd'>
                    <input type='text' name="thoigiankethuc" class="form-control" value="{{old('thoigiankethuc')}}"  readonly="true">
                    <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <span class="help-block"> <strong>{{ $errors->first('thoigiankethuc') }}</strong> </span>

            </div>

            <div class="x_title">
              <div class="clearfix"></div>
            </div>

            <div class="row col-md-12 text-center">
              <button type="submit" class="btn btn-primary save_hdsk"><i class="fa fa-save" aria-hidden="true"></i> <strong> Lưu </strong> </button>
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
  </script>
@endsection