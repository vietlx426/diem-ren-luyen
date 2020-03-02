@extends('subadmin.layout.master')
@section('title')
  @parent | Advisers
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2>THÊM MỚI CỐ VẤN HỌC TẬP</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form method="POST" action="{{route('subadmin_covanhoctap_store')}}" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{csrf_field()}}
          <div class="row">
            <div class="col-12 col-md-12">
              <!-- Block error message -->
              @include('layout.block.message_flash')
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group{{$errors->has('cbgv')? ' has-error' : ''}}">
              <label for="cbgv" class="control-label">CÁN BỘ - GIẢNG VIÊN</label>
              <select name="cbgv" id="cbgv" class="form-control">
                <option value=""> --- Chọn cán bộ-giảng viên ---</option>
                @if(isset($dsCanBoGiangVien))
                  @foreach($dsCanBoGiangVien as $canBoGiangVien)
                    <option value="{{$canBoGiangVien->id}}" {{$canBoGiangVien->id == old('cbgv') ? 'selected="true"' : ''}}>{{$canBoGiangVien->hochulot . ' ' . $canBoGiangVien->ten . ' - Khoa ' . $canBoGiangVien->bomonto->khoa->tenkhoa}}</option>
                  @endforeach
                @endif
              </select>
              @if ($errors->has('cbgv'))
                <span class="help-block">
                  <strong>{{ $errors->first('cbgv') }}</strong>
                </span>
              @endif
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group{{$errors->has('lop')? ' has-error' : ''}}">
              <label for="lop" class="control-label">LỚP PHỤ TRÁCH</label>
              <select name="lop" id="lop" class="form-control">
                <option value=""> --- Chọn lớp ---</option>
                @if(isset($dsLop))
                  @foreach($dsLop as $lop)
                    <option value="{{$lop->id}}" {{$lop->id == old('lop') ? 'selected="true"' : ''}}>{{$lop->tenlop}}</option>
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
          <hr>
          <div class="row text-center">
            <button class="btn btn-primary"><strong><i class="fa fa-save"></i> LƯU </strong></button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection