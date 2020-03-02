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
        <h2> <i class="fa fa-calendar"></i> KHÓA HỌC</h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        @if(isset($khoaHoc))
            <form method="POST" action="{{route('admin_khoahoc_update')}}" enctype="multipart/form-data" class="form-horizontal form-label-left">
                {{csrf_field()}}
                <input type="text" name="idkhoahoc" value="{{$khoaHoc->id}}" class="hidden" hidden="true">
                <div class="row">
                    <div class="col-12 col-md-12">
                    <!-- Block error message -->
                    @include('layout.block.message_flash')
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('tenkhoahoc') ? ' has-error' : '' }}">
                        <label class="control-label">Khóa học</label>
                        <input type="text" id="tenkhoahoc" name="tenkhoahoc" class="form-control" value="{{old('tenkhoahoc', $khoaHoc->tenkhoahoc)}}" placeholder="Khóa học => CD43 hoặc DH19">

                        @if ($errors->has('tenkhoahoc'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tenkhoahoc') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('bacdaotao') ? ' has-error' : '' }}">
                        <label class="control-label">Bậc đào tạo</label>
                        <div class="form-control no-border">
                        @if(isset($dsBacDaoTao))
                            @foreach($dsBacDaoTao as $bacDaoTao)
                            &emsp;&emsp;
                            <input type="radio" id="radbacdaotao{{$bacDaoTao->id}}" name="bacdaotao" class="flat" value="{{$bacDaoTao->id}}" {{($bacDaoTao->id == old('bacdaotao', $khoaHoc->bacdaotao_id)) ? 'checked="true"':''}}> 
                            <label for="radbacdaotao{{$bacDaoTao->id}}">{{$bacDaoTao->tenbac}}</label>
                            @endforeach
                        @endif

                        @if ($errors->has('bacdaotao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('bacdaotao') }}</strong>
                        </span>
                        @endif
                        
                    </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('nambatdau') ? ' has-error' : '' }}">
                        <label class="control-label">Năm bắt đầu</label>
                        <input type="text" class="form-control" id="nambatdau" name="nambatdau" value="{{old('nambatdau', $khoaHoc->nambatdau)}}" placeholder="Năm bắt đầu">
                        @if ($errors->has('nambatdau'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nambatdau') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('namketthuc') ? ' has-error' : '' }}">
                        <label class="control-label">Năm kết thúc</label>
                        <input type="text" class="form-control" id="namketthuc" name="namketthuc" value="{{old('namketthuc', $khoaHoc->namketthuc)}}" placeholder="Năm kết thúc">
                        @if ($errors->has('namketthuc'))
                        <span class="help-block">
                            <strong>{{ $errors->first('namketthuc') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <button type="submit" class="btn btn-primary" title="Lưu thông tin"> <strong><i class="fa fa-save"></i> LƯU </strong> </button>
                </div>
            </form>
        @else
            <h4>Không tìm thấy thông tin!</h4>
        @endif
      </div>
    </div>
  </div>
@endsection
@section('javascript')
    @parent
    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
@endsection