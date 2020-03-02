@extends('admin.layout.master')
@section('title')
  @parent | Groups
@endsection

@section('css')
  <!-- <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}"> -->
  <!-- iCheck -->
  <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2>PHÂN CÔNG CHUYÊN VIÊN PHỤ TRÁCH LỚP</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form method="POST" action="{{route('admin_expers_store')}}" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{csrf_field()}}
          <div class="row">
            <div class="col-12 col-md-12">
              <!-- Block error message -->
              @include('layout.block.message_flash')
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group{{$errors->has('cbgv')? ' has-error' : ''}}">
              <label for="cbgv" class="control-label">CÁN BỘ - GIẢNG VIÊN</label>
              <select name="cbgv" id="cbgv" class="form-control">
                <option value=""> --- Chọn cán bộ-giảng viên ---</option>
                @if(isset($dsCanBoGiangVien))
                  @foreach($dsCanBoGiangVien as $canBoGiangVien)
                    <option value="{{$canBoGiangVien->id}}" {{$canBoGiangVien->id == old('cbgv') ? 'selected="true"' : ''}}>{{$canBoGiangVien->hochulot . ' ' . $canBoGiangVien->ten . ' - ' . $canBoGiangVien->bomonto->khoa->tenkhoa}}</option>
                  @endforeach
                @endif
              </select>
              @if ($errors->has('cbgv'))
                <span class="help-block">
                  <strong>{{ $errors->first('cbgv') }}</strong>
                </span>
              @endif
            </div>
          </div>
          @if(isset($dsKhoa))
            <hr>
            <div class="row">
              @foreach($dsKhoa as $khoa)
                <?php 
                  $dsLop = App\Http\Controllers\LopController::getLopByKhoa($khoa->id);
                 ?>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                  <h4 class="text-center">{{$khoa->tenkhoa}}</h4>
                  <div class="well" style="height: 150px; overflow: auto;">
                      <ul class="list-group checked-list-box">
                          @if(isset($dsLop))
                              @foreach($dsLop as $lop)
                                  <li class="list-group-item" value="{{$lop->id}}"> <input type="checkbox" id="{{$lop->id}}" name="lop[]" value="{{$lop->id}}" class="flat"> <label for="{{$lop->id}}"> {{$lop->tenlop}} </label> </li>
                              @endforeach
                          @endif
                      </ul>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
          <hr>
          <div class="row text-center">
            <button class="btn btn-primary"><strong><i class="fa fa-save"></i> LƯU </strong></button>
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
@endsection