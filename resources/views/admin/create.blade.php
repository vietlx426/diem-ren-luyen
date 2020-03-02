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
        <h2> <i class="fa fa-graduation-cap"></i> THÔNG TIN HỌC BỔNG <small>SCHOLARSHIP INFORMATION</small></h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal form-label-left">
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

                
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
              <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 form-group{{ $errors->has('hochulot') ? ' has-error' : '' }}">
                  <label class="control-label">Họ và chữ lót</label>
                    <input type="text" id="hochulot" name="hochulot" class="form-control" value="{{old('hochulot')}}" placeholder="Họ và chữ lót">

                   

                </div>

                <div class="col-xs-4 col-sm-4 col-md-4 form-group{{ $errors->has('ten') ? ' has-error' : '' }}">
                  <label class="control-label">Tên</label>
                    <input type="text" id="ten" name="ten" class="form-control" value="{{old('ten')}}" placeholder="Tên">

                    

                </div>
                
              </div>
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