@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
@endsection
@section('content')
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2> TÌM KIẾM - CẬP NHẬT HÌNH THẺ </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- Block error message -->
                @include('layout.block.message_flash')
                @include('layout.block.message_validation')

                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 col-xl-4 col-sm-offset-2 col-md-offset-3 col-lg-offset-4 col-xl-offset-4">
                    <div class="form-horizontal form-label-left">
                        <div class="form-group{{ $errors->has('mssv') ? ' has-error' : '' }}">
                            <label for="mssv" class="col-xs-3 col-sm-3 control-label">MSSV</label>
                            <div class="col-xs-9 col-sm-9">
                                <div class="input-group">
                                    <input id="mssv" type="mssv" class="form-control" name="mssv" value="{{ old('mssv') }}" placeholder="Nhập mã số sinh viên" required autofocus>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary search_student_id" url="{{route('searchsinhvienajax')}}">
                                            <strong><i class="fa fa-search"></i> TÌM </strong>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2> KẾT QUẢ </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr class="filters">
                            <th width="10%">MSSV</th>
                            <th width="20%">Họ và tên</th>
                            <th width="10%">Lớp</th>
                            <th width="20%">Ngành</th>
                            <th width="30%">Khoa</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody id="tbody"> </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/timsinhvien.js') !!}"></script>
    <script type="text/javascript">
        var urlroute_adminstudentprofilepic = "{{route('adminstudentprofilepic')}}";
        console.log(urlroute_adminstudentprofilepic);
    </script>
@endsection