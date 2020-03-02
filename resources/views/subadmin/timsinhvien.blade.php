@extends('subadmin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
@endsection
@section('content')
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h4>TÌM SINH VIÊN</h4>
                        <hr>
                    </div>

                    <div class="panel-body">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('mssv') ? ' has-error' : '' }}">
                            <label for="mssv" class="control-label">MSSV</label>

                                <input id="mssv" type="mssv" class="" name="mssv" value="{{ old('mssv') }}" placeholder="Nhập mã số sinh viên" required autofocus>

                                @if ($errors->has('mssv'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mssv') }}</strong>
                                    </span>
                                @endif
                            <button class="btn btn-primary search_student_id" url="{{route('searchsinhvienajax')}}">
                                <i class="fa fa-search"></i> Tìm
                            </button>
                        </div>
                        <hr width="20%">
                        <input id="div_url_studentprofile" type="text" hidden="true" value="{{route('studentprofilepicurl')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <table class="table table-striped table-bordered" width="100%">
            <thead>
                <tr class="filters">
                    <!-- <th width="5%">#</th> -->
                    <th width="10%">MSSV</th>
                    <th width="20%">Họ và tên</th>
                    <th width="10%">Lớp</th>
                    <th width="20%">Ngành</th>
                    <th width="30%">Khoa</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody id="tbody">
                
            </tbody>
        </table>
    </div>
@endsection
@section('javascript')
    @parent

    <script type="text/javascript" src="{!! URL::asset('js/timsinhvien.js') !!}"></script>
@endsection