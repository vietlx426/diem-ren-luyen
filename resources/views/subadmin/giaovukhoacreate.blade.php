@extends('subadmin.layout.master')
@section('title')
  @parent | Groups
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2>THÊM MỚI GIÁO VỤ KHOA</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form method="POST" action="{{route('subadmin_giaovukhoa_store')}}" enctype="multipart/form-data" class="form-horizontal form-label-left">
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

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group{{$errors->has('khoa')? ' has-error' : ''}}">
              <label for="khoa" class="control-label">KHOA PHỤ TRÁCH</label>
              <select name="khoa" id="khoa" class="form-control">
                <option value=""> --- Chọn khoa ---</option>
                @if(isset($dsKhoa))
                  @foreach($dsKhoa as $khoa)
                    <option value="{{$khoa->id}}" {{$khoa->id == old('khoa') ? 'selected="true"' : ''}}>{{$khoa->tenkhoa}}</option>
                  @endforeach
                @endif
              </select>
              @if ($errors->has('khoa'))
                <span class="help-block">
                  <strong>{{ $errors->first('khoa') }}</strong>
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