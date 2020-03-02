@extends('admin.layout.master')

@section('title')
    @parent | Search - Filter
@endsection

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-search"></i> XUẤT BẢNG ĐIỂM RÈN LUYỆN </h2>
        <!-- <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul> -->
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div id="test"></div>
        <form action="{{route('admin_exportbangdiemrenluyen_export')}}" method="post">
            {{csrf_field()}}
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <!-- Block error message -->
                @include('layout.block.message_flash')
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12{{ $errors->has('hockynamhoc') ? ' has-error' : '' }}">
                    <h4 class="text-center"><label for=""> HỌC KỲ - NĂM HỌC </label></h4>
                    <div>
                        
                        <select id="hockynamhoc" name="hockynamhoc" class="form-control">
                            <option value="">--- Chọn Học Kỳ ---</option>
                            @if(isset($dsHocKyNamHoc))
                                @foreach($dsHocKyNamHoc as $hocKyNamHoc)
                                    <option value="{{$hocKyNamHoc->id}}"> {{$hocKyNamHoc->tenhockynamhoc}} </option>
                                @endforeach
                            @endif
                        </select>

                        @if ($errors->has('hockynamhoc'))
                            <span class="help-block">
                                <strong>{{ $errors->first('hockynamhoc') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12{{ $errors->has('khoa') ? ' has-error' : '' }}">
                    <h4 class="text-center"><label for=""> KHOA </label></h4>
                    <div>
                        <select id="khoa" name="khoa" class="form-control">
                            <option value="">--- Chọn Khoa ---</option>
                            @if(isset($dsKhoa))
                                @foreach($dsKhoa as $khoa)
                                    <option value="{{$khoa->id}}"> {{$khoa->tenkhoa}} </option>
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
            </div>
            <hr>

            <div class="row text-center">
                <button type="submit" class="btn btn-primary btn-download">
                    <i class="fa fa-download"></i> <strong> DOWNLOAD </strong>
                </button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
    @parent
    <script src="{!! URL::asset('js/admin_bangdiemrenluyen_export.js') !!}"></script>

    <script>
        var url_Admin_Export_BangDiemRenLuyen = "{{route('admin_exportbangdiemrenluyen_export')}}";
    </script>
@endsection