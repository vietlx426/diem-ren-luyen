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
        <h2> <i class="fa fa-list"></i> THÔNG TIN CÁN BỘ - GIẢNG VIÊN <small>STAFF INFORMATION</small></h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <form method="POST" action="{{route('poststaffupdate')}}" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{csrf_field()}}
            
          @if(isset($CBGV))
            <div class="row">

              <div class="col-12 col-md-12">
                <!-- Block error message -->
                @include('layout.block.message_flash')
                @include('layout.block.message_validation')
              </div>
            </div>
            
            <input type="text" name="id" hidden="true" value="{{$CBGV->id}}">

            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('macanbogiangvien') ? ' has-error' : '' }}">
                  <label class="control-label">Mã cán bộ - giảng viên</label>
                  <input type="text" id="macanbogiangvien" name="macanbogiangvien" class="form-control" value="{{old('macanbogiangvien', $CBGV->macanbogiangvien)}}" placeholder="Mã cán bộ - giảng viên">

                  @if ($errors->has('macanbogiangvien'))
                    <span class="help-block">
                      <strong>{{ $errors->first('macanbogiangvien') }}</strong>
                    </span>
                  @endif
              </div>

              <div class="col-xs-12 col-sm-6 col-md-6 form-group">
                <div class="row">
                  <div class="col-xs-8 col-sm-8 col-md-8 form-group{{ $errors->has('hochulot') ? ' has-error' : '' }}">
                    <label class="control-label">Họ và chữ lót</label>
                      <input type="text" id="hochulot" name="hochulot" class="form-control" value="{{old('hochulot', $CBGV->hochulot)}}" placeholder="Họ và chữ lót">

                      @if ($errors->has('hochulot'))
                        <span class="help-block">
                          <strong>{{ $errors->first('hochulot') }}</strong>
                        </span>
                      @endif

                  </div>

                  <div class="col-xs-4 col-sm-4 col-md-4 form-group{{ $errors->has('ten') ? ' has-error' : '' }}">
                    <label class="control-label">Tên</label>
                      <input type="text" id="ten" name="ten" class="form-control" value="{{old('ten', $CBGV->ten)}}" placeholder="Tên">

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
              <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('dienthoaicanhan') ? ' has-error' : '' }}">
                  <label class="control-label">Điện thoại</label>
                    <input type="text" class="form-control" id="dienthoaicanhan" name="dienthoaicanhan" value="{{old('dienthoaicanhan', $CBGV->dienthoaicanhan)}}" placeholder="Số điện thoại">
                  @if ($errors->has('dienthoaicanhan'))
                    <span class="help-block">
                      <strong>{{ $errors->first('dienthoaicanhan') }}</strong>
                    </span>
                  @endif
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <label class="control-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{old('email', $CBGV->email)}}" placeholder="Email">
                  @if ($errors->has('email'))
                    <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
              </div>
            </div>

            <div class="row">
              <!-- <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('bophancongtac') ? ' has-error' : '' }}">
                  <label class="control-label">Bộ phận công tác</label>
                  
                  <input type="text" class="form-control pull-right" id="bophancongtac" name="bophancongtac" value="{{old('bophancongtac', $CBGV->bophancongtac)}}" placeholder="Bộ phận công tác">

                  @if ($errors->has('bophancongtac'))
                    <span class="help-block">
                      <strong>{{ $errors->first('bophancongtac') }}</strong>
                    </span>
                  @endif
              </div> -->

              <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('gioitinh') ? ' has-error' : '' }}">
                  <label class="control-label">Giới tính</label>
                  <div class="form-control no-border">
                    @if(isset($DS_GioiTinh))
                      @foreach($DS_GioiTinh as $GioiTinh)
                        &emsp;&emsp;
                        <input type="radio" id="radGioiTinh{{$GioiTinh->id}}" name="gioitinh" class="minimal-red flat" value="{{$GioiTinh->id}}" {{($GioiTinh->id == old('gioitinh', $CBGV->gioitinh_id)) ? 'checked="true"':''}}> 
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

              <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('loaicbgv') ? ' has-error' : '' }}">
                <label class="control-label">Giảng viên/Cán bộ phòng ban</label>

                <div class="form-control no-border">
                  @if(isset($DS_LoaiCBGV))
                    @foreach($DS_LoaiCBGV as $LoaiCBGV)
                      &emsp;
                      <input type="radio" id="loaicbgv{{$LoaiCBGV->id}}" name="loaicbgv" class="minimal-red flat" value="{{$LoaiCBGV->id}}" {{$LoaiCBGV->id == old('loaicbgv', $CBGV->loaicbgv_id) ? 'checked="true"' : ''}}>

                      <label for="loaicbgv{{$LoaiCBGV->id}}"> {{$LoaiCBGV->tenloaicbgv}} </label>

                    @endforeach
                  @endif
                </div>
                
                @if ($errors->has('loaicbgv'))
                  <span class="help-block">
                    <strong>{{ $errors->first('loaicbgv') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('khoaphong') ? ' has-error' : '' }}">
                <label class="control-label">Khoa/Phòng</label>
                <select name="khoaphong" id="khoaphong" class="form-control">
                  <option value="">--- Khoa/Phòng ---</option>
                  @if(isset($DS_Khoa))
                    @foreach($DS_Khoa as $Khoa)
                      <option value="{{$Khoa->id}}" {{$Khoa->id == old('khoaphong', $CBGV->bomonto->khoa->id) ? 'selected="true"' : ''}}>{{$Khoa->tenkhoa}}</option>
                    @endforeach
                  @endif
                </select>

                @if ($errors->has('khoaphong'))
                  <span class="help-block">
                    <strong>{{ $errors->first('khoaphong') }}</strong>
                  </span>
                @endif
              </div>

              <div class="col-xs-12 col-sm-6 col-sm-6 form-group{{ $errors->has('bomonto') ? ' has-error' : '' }}">
                <label class="control-label">Bộ môn/Tổ</label>
                <select name="bomonto" id="bomonto" class="form-control">
                  <option value="">--- Bộ môn/Tổ ---</option>
                  @if(isset($DS_BoMon))
                    @foreach($DS_BoMon as $BoMon)
                      <option value="{{$BoMon->id}}" {{$BoMon->id == old('bomonto', $CBGV->bomonto->id) ? 'selected="true"' : ''}}>{{$BoMon->tenbomon}}</option>
                    @endforeach
                  @endif
                </select>

                @if ($errors->has('bomonto'))
                  <span class="help-block">
                    <strong>{{ $errors->first('bomonto') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 form-group{{ $errors->has('ghichu') ? ' has-error' : '' }}">
                <div class="form-group">
                  <label class="control-label">Ghi chú</label>
                  <input type="text" class="form-control pull-right" id="ghichu" name="ghichu" value="{{old('ghichu', $CBGV->ghichu)}}" placeholder="Ghi chú">
                  @if ($errors->has('ghichu'))
                    <span class="help-block">
                      <strong>{{ $errors->first('ghichu') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
            </div>

            </div>
            <hr>
            <div class="row text-center">
              <button type="submit" class="btn btn-primary" title="Lưu thông tin"> <strong><i class="fa fa-save"></i> LƯU </strong> </button>
            </div>
          @else
            <div class="row">
              <div class="col-12 text-center">
                <h4>KHÔNG CÓ THÔNG TIN!</h4>
              </div>
            </div>
          @endif

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