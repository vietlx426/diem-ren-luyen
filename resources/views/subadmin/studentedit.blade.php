@extends('subadmin.layout.master')
@section('css')
  @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/dataTables.bootstrap.min.css')}}" type="text/css">
  
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/plugins/iCheck/all.css')}}">
  
  <!-- Select2 -->
  <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/select2/dist/css/select2.min.css')}}">
@endsection

@section('content')
  
  <div class="panel panel-primary filterable">
    <div class="panel-heading">
        <h3 class="panel-title text-center">THÔNG TIN SINH VIÊN</h3>
        <!-- <hr width="30%"> -->
    </div>
  </div>

  <section class="content">
    <form method="POST" action="{{route('poststudentupdate')}}" enctype="multipart/form-data">
      {{csrf_field()}}
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Thông tin tuyển sinh - đầu vào</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->

        
        <div class="box-body">
          @if(isset($Student))
            <div class="row">
              <div class="col-12 col-md-12">
                <!-- Block error message -->
                @include('layout.block.message_flash')
                @include('layout.block.message_validation')
              </div>
            </div>
            
            <input type="text" name="id" hidden="true" value="{{$Student->id}}">
            <div class="row">
              <div class="col-md-6 form-group{{ $errors->has('mssv') ? ' has-error' : '' }}">
                <div class="form-group">
                  <label>MSSV</label>
                  <input type="text" id="mssv" name="mssv" class="form-control" value="{{old('mssv', $Student->mssv)}}" placeholder="Mã số sinh viên">

                  @if ($errors->has('mssv'))
                    <span class="help-block">
                      <strong>{{ $errors->first('mssv') }}</strong>
                    </span>
                  @endif

                </div>
              </div>

              <div class="col-md-6 form-group">
                <div class="row">
                  <div class="col-md-9 form-group{{ $errors->has('hochulot') ? ' has-error' : '' }}">
                    <label>Họ và chữ lót</label>
                      <input type="text" id="hochulot" name="hochulot" class="form-control" value="{{old('hochulot', $Student->hochulot)}}" placeholder="Họ và chữ lót">

                      @if ($errors->has('hochulot'))
                        <span class="help-block">
                          <strong>{{ $errors->first('hochulot') }}</strong>
                        </span>
                      @endif

                  </div>

                  <div class="col-md-3 form-group{{ $errors->has('ten') ? ' has-error' : '' }}">
                    <label>Tên</label>
                      <input type="text" id="ten" name="ten" class="form-control" value="{{old('ten', $Student->ten)}}" placeholder="Tên">

                      @if ($errors->has('ten'))
                        <span class="help-block">
                          <strong>{{ $errors->first('ten') }}</strong>
                        </span>
                      @endif

                  </div>
                </div>
              </div>

              <div class="col-md-6 form-group{{ $errors->has('gioitinh') ? ' has-error' : '' }}">
                <div class="form-group">
                  <label>Giới tính</label>
                  <div class="form-control no-border">
                    @if(isset($DS_GioiTinh))
                      @foreach($DS_GioiTinh as $GioiTinh)
                        &emsp;&emsp;
                        <input type="radio" id="radGioiTinh{{$GioiTinh->id}}" name="gioitinh" class="minimal-red" value="{{$GioiTinh->id}}" {{($GioiTinh->id == old('gioitinh', $Student->gioitinh)) ? 'checked="true"':''}}> 
                        <label for="radGioiTinh{{$GioiTinh->id}}">{{$GioiTinh->tengioitinh}}</label>
                      @endforeach
                    @endif
                  </div>

                  @if ($errors->has('gioitinh'))
                    <span class="help-block">
                      <strong>{{ $errors->first('gioitinh') }}</strong>
                    </span>
                  @endif
                  
                </div>
              </div>

              <div class="col-md-6 form-group{{ $errors->has('ngaysinh') ? ' has-error' : '' }}">
                <div class="form-group">
                  <label>Ngày sinh <small>(Nếu không có ngày, tháng thì nhập 01/01/năm sinh)</small></label>
                  <div class="input-group date">
                    <!-- <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div> -->
                    <input type="text" class="form-control pull-right" id="datepickerngaysinh" name="ngaysinh" value="{{old('ngaysinh', Carbon\Carbon::createFromFormat('Y-m-d', $Student->ngaysinh)->format('d/m/Y'))}}" placeholder="Ngày sinh (dd/mm/yyyy)" title="Nếu không có ngày, tháng thì nhập 01/01/năm sinh">
                  </div>

                  @if ($errors->has('ngaysinh'))
                    <span class="help-block">
                      <strong>{{ $errors->first('ngaysinh') }}</strong>
                    </span>
                  @endif

                </div>
              </div>

              <div class="col-md-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="form-group">
                  <label>Email</label>
                  <div class="input-group date">
                    <input type="text" class="form-control" id="email" name="email" value="{{old('email', $Student->email_agu)}}" placeholder="Email">
                  </div>

                  @if ($errors->has('email'))
                    <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif

                </div>
              </div>

              <div class="col-md-6 form-group{{ $errors->has('cmnd') ? ' has-error' : '' }}">
                <div class="form-group">
                  <label>Số cmnd</label>
                  <div class="input-group date">
                    <input type="text" class="form-control" id="cmnd" name="cmnd" value="{{old('cmnd', $Student->cmnd)}}" placeholder="Số cmnd">
                  </div>

                  @if ($errors->has('cmnd'))
                    <span class="help-block">
                      <strong>{{ $errors->first('cmnd') }}</strong>
                    </span>
                  @endif

                </div>
              </div>

              <div class="col-md-6 form-group{{ $errors->has('lop') ? ' has-error' : '' }}">
                <div class="form-group">
                  <label>Lớp</label>
                  <select name="lop" id="lop" class="form-control">
                    <option value="">--- Chọn lớp ---</option>
                    @if(isset($DS_Lop))
                      @foreach($DS_Lop as $Lop)
                        <option value="{{$Lop->id}}" {{(old('lop', $Student->lop_id) == $Lop->id) ? 'selected="true"' : ''}}>{{$Lop->tenlop}}</option>
                      @endforeach
                    @endif
                  </select>

                  @if ($errors->has('lop'))
                    <span class="help-block">
                      <strong>{{ $errors->first('lop') }}</strong>
                    </span>
                  @endif

                </div>
              </div>

               <div class="col-md-6 form-group{{ $errors->has('diemtrungtuyen') ? ' has-error' : '' }}">
                <div class="form-group">
                  <label>Điểm trúng tuyển</label>
                  <div class="input-group date">
                    <input type="number" class="form-control" id="diemtrungtuyen" name="diemtrungtuyen"  value="{{floatval(old('diemtrungtuyen', $Student->diemtrungtuyen))}}" placeholder="Điểm trúng tuyển">
                  </div>

                  @if ($errors->has('diemtrungtuyen'))
                    <span class="help-block">
                      <strong>{{ $errors->first('diemtrungtuyen') }}</strong>
                    </span>
                  @endif

                </div>
              </div>

            </div>
          @else
            <div class="row">
              <div class="col-12 text-center">
                <h4>KHÔNG CÓ THÔNG TIN!</h4>
              </div>
            </div>
          @endif
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <button type="submit" class="btn btn-primary" title="Lưu thông tin"><i class="fa fa-save"></i> LƯU</button>
        </div>
      </div>
      <!-- /.box -->
    </form>
  </section>
@endsection
@section('javascript')
    @parent
    
    <!-- <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script> -->

    <script type="text/javascript" src="{!! URL::asset('js/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/jquery.dataTables.min.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/dataTables.bootstrap.min.js') !!}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{URL::asset('dashboard/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

    <!-- iCheck 1.0.1 -->
    <script src="{{URL::asset('dashboard/plugins/iCheck/icheck.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{URL::asset('dashboard/bower_components/fastclick/lib/fastclick.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#tbluser').DataTable();
        } );

        $('#datepickerngaysinh').datepicker({
          autoclose: true,
          format: 'dd/mm/yyyy'
        });

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass   : 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass   : 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
        });
    </script>

@endsection