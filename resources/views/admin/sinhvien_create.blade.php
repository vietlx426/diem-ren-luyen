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
        <h2> <i class="fa fa-graduation-cap"></i> THÔNG TIN SINH VIÊN <small>STUDENT INFORMATION</small></h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <form method="POST" action="{{route('admin_sinhvien_store')}}" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{csrf_field()}}
            
          <div class="row">
            <div class="col-12 col-md-12">
              <!-- Block error message -->
              @include('layout.block.message_flash')
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('mssv') ? ' has-error' : '' }}">
                <label class="control-label">MSSV</label>
                <input type="text" id="mssv" name="mssv" class="form-control" value="{{old('mssv')}}" placeholder="Mã số sinh viên">

                @if ($errors->has('mssv'))
                  <span class="help-block">
                    <strong>{{ $errors->first('mssv') }}</strong>
                  </span>
                @endif
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
              <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 form-group{{ $errors->has('hochulot') ? ' has-error' : '' }}">
                  <label class="control-label">Họ và chữ lót</label>
                    <input type="text" id="hochulot" name="hochulot" class="form-control" value="{{old('hochulot')}}" placeholder="Họ và chữ lót">

                    @if ($errors->has('hochulot'))
                      <span class="help-block">
                        <strong>{{ $errors->first('hochulot') }}</strong>
                      </span>
                    @endif

                </div>

                <div class="col-xs-4 col-sm-4 col-md-4 form-group{{ $errors->has('ten') ? ' has-error' : '' }}">
                  <label class="control-label">Tên</label>
                    <input type="text" id="ten" name="ten" class="form-control" value="{{old('ten')}}" placeholder="Tên">

                    @if ($errors->has('ten'))
                      <span class="help-block">
                        <strong>{{ $errors->first('ten') }}</strong>
                      </span>
                    @endif

                </div>
                
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('gioitinh') ? ' has-error' : '' }}">
                <label class="control-label">Giới tính</label>
                <div class="form-control no-border">
                  @if(isset($DS_GioiTinh))
                    @foreach($DS_GioiTinh as $GioiTinh)
                      &emsp;&emsp;
                      <input type="radio" id="radGioiTinh{{$GioiTinh->id}}" name="gioitinh" class="minimal-red flat" value="{{$GioiTinh->id}}" {{($GioiTinh->id == old('gioitinh')) ? 'checked="true"':''}}> 
                      <label for="radGioiTinh{{$GioiTinh->id}}">{{$GioiTinh->tengioitinh}}</label>
                    @endforeach
                  @endif

                @if ($errors->has('gioitinh'))
                  <span class="help-block">
                    <strong>{{ $errors->first('gioitinh') }}</strong>
                  </span>
                @endif
                
              </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="control-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" placeholder="Email">
                @if ($errors->has('email'))
                  <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('ngaysinh') ? ' has-error' : '' }}">
              <label class="control-label">Ngày sinh</label>

              <input type="date" name="ngaysinh" class="form-control" value="{{old('ngaysinh')}}">
                
              @if ($errors->has('ngaysinh'))
                <span class="help-block">
                  <strong>{{ $errors->first('ngaysinh') }}</strong>
                </span>
              @endif
                
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('cmnd') ? ' has-error' : '' }}">
              <label class="control-label">Chứng minh nhân dân</label>
              <input type="text" class="form-control" id="cmnd" name="cmnd" value="{{old('cmnd')}}" placeholder="Chứng minh nhân dân">
              @if ($errors->has('cmnd'))
                <span class="help-block">
                  <strong>{{ $errors->first('cmnd') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('lop') ? ' has-error' : '' }}">
              <label class="control-label">Lớp</label>
              <select name="lop" id="lop" class="form-control">
                <option value="">--- Lớp ---</option>
                @if(isset($DS_Lop))
                  @foreach($DS_Lop as $Lop)
                    <option value="{{$Lop->id}}" {{$Lop->id == old('lop') ? 'selected="true"' : ''}}>{{$Lop->tenlop}}</option>
                  @endforeach
                @endif
              </select>

              @if ($errors->has('lop'))
                <span class="help-block">
                  <strong>{{ $errors->first('lop') }}</strong>
                </span>
              @endif
            </div>

            <div class="col-xs-12 col-sm-6 col-sm-6 form-group{{ $errors->has('diemtrungtuyen') ? ' has-error' : '' }}">
              <label class="control-label">Điểm trúng tuyển</label>
              <input type="number" name="diemtrungtuyen" class="form-control" value="{{old('diemtrungtuyen')}}" max="100" min="0">

              @if ($errors->has('diemtrungtuyen'))
                <span class="help-block">
                  <strong>{{ $errors->first('diemtrungtuyen') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <!-- <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-6 form-group{{ $errors->has('createuser') ? ' has-error' : '' }}">

              <label class="control-label">Tạo user cho sinh viên?</label>
              <div class="form-control no-border">
                <input type="radio" id="createuser_yes" name="createuser" class="flat" value="1" checked="true"> 
                <label for="createuser_yes">Có</label>
                &nbsp;&nbsp;&nbsp;
                <input type="radio" id="createuser_no" name="createuser" class="flat" value="2" {{($GioiTinh->id == old('gioitinh')) ? 'checked="true"':''}}> 
                <label for="createuser_no">Không</label>
              </div>

              @if ($errors->has('createuser'))
                <span class="help-block">
                  <strong>{{ $errors->first('createuser') }}</strong>
                </span>
              @endif
            </div>
          </div> -->

          <hr>
          <div class="row text-center">
            <button type="submit" class="btn btn-primary" title="Lưu thông tin"> <strong><i class="fa fa-save"></i> LƯU </strong> </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
    @parent
    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
    <script src="{{URL::asset('js/admin_canbogiangvien.khoa.bomon.js')}}"></script>

    <script>
      var url_route_admin_get_bomonbykhoa = "{{route('admin_get_bomonbykhoa')}}";
    </script>

@endsection