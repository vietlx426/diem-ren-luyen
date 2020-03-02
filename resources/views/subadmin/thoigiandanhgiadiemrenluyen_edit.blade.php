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
        <h2> <i class="fa fa-futbol-o"></i> THỜI GIAN ĐÁNH GIÁ ĐIỂM RÈN LUYỆN <small>ACTIVITIES - EVENTS</small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          @include('layouts.gentelella-master.blocks.flash-messages')

          <form action="{{route('post_subadmin_thoigiandanhgiaDRL_edit',['id'=>$thoigiandanhgiaDRL->id])}}" method="POST" class="form-horizontal form-label-left">
            {{csrf_field()}}
            <div class="form-group col-md-6">
                    <label for="hockynamhoc" class="control-label"> Học kỳ - Năm học </label>
                    <select name="hockynamhoc" id="hockynamhoc" class="hockynamhoc Khoa form-control">
                      @if(isset($DS_HocKyNamHoc))
                          @foreach($DS_HocKyNamHoc as $HocKyNamHoc)
                              <option 
                              @if($thoigiandanhgiaDRL->hockynamhoc_id == $HocKyNamHoc->id)
                              {{'selected'}}
                              @endif
                              value="{{$HocKyNamHoc->id}}" {{old('hockynamhoc') == $HocKyNamHoc->id ? 'selected="true"' : ($HocKyNamHoc->idtrangthaihocky == 2) ? 'selected="true"' : ''}}> {{$HocKyNamHoc->tenhockynamhoc}} </option>
                          @endforeach
                      @endif
                    </select>
                    <span class="help-block"> <strong>{{ $errors->first('hockynamhoc') }}</strong> </span>
            </div>
            <div class="form-group">
              <label for="" class="control-label  col-ms-6">
                Lớp:
              </label>
              <div class="col-md-6">
                <select name="lop[]" id="lop[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                  @if(isset($DS_Lop))
                    <option value="">----- Chọn lớp -----</option>
                    @foreach($DS_Lop as $lp)
                      @if($thoigiandanhgiaDRL->lop_id == $lp->id)
                       <option {{'selected'}} value="{{$lp->id}}" {{old('lop') == $lp->id ? 'selected="true"' : ''}}> {{$lp->tenlop}} </option>
                       @else
                        <option  value="{{$lp->id}}" {{old('lop') == $lp->id ? 'selected="true"' : ''}}> {{$lp->tenlop}} </option>  
                      @endif
                      
                    @endforeach
                  @endif
                </select>
              </div>
                
            </div>
            
            <div class="form-group col-md-6{{$errors->has('thoigianbatdau')? ' has-error' : ''}}">
                <label for="thoigianbatdau" class="control-label"> Thời gian bắt đầu</label>
                <div class='input-group date' id='myDatepickerRegStart'>
                    <input type='text' name="thoigianbatdau" class="form-control" value="{{date('d/m/Y',strtotime($thoigiandanhgiaDRL->thoigianbatdau))}}"  readonly="true">
                    <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <span class="help-block"> <strong>{{ $errors->first('thoigianbatdau') }}</strong> </span>

            </div>
            <div class="form-group col-md-6{{$errors->has('thoigiankethuc')? ' has-error' : ''}}">
                <label for="thoigiankethuc" class="control-label"> Thời gian kết thúc</label>
                <div class='input-group date' id='myDatepickerRegEnd'>
                    <input type='text' name="thoigiankethuc" class="form-control" value="{{date('d/m/Y',strtotime($thoigiandanhgiaDRL->thoigianketthuc))}}" readonly="true">
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
              <button type="submit" class="btn btn-primary save_hdsk"><i class="fa fa-save" aria-hidden="true"></i> Lưu </button>
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

    </script>
    
@endsection