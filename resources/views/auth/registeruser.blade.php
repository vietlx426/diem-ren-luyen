@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <!-- Mã số sinh viên -->
                        <div class="form-group{{ $errors->has('mssv') ? ' has-error' : '' }}">
                            <label for="mssv" class="col-md-4 control-label">Mã số sinh viên</label>

                            <div class="col-md-6">
                                <input id="mssv" type="text" class="form-control" name="mssv" value="{{ old('mssv') }}" placeholder="Mã số sinh viên">

                                @if ($errors->has('mssv'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mssv') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Họ và chữ lót -->
                        <div class="form-group{{ $errors->has('hochulot') ? ' has-error' : '' }}">
                            <label for="hochulot" class="col-md-4 control-label">Họ và chữ lót</label>

                            <div class="col-md-6">
                                <input id="hochulot" type="text" class="form-control" name="hochulot" value="{{ old('hochulot') }}" placeholder="Họ và chữ lót">

                                @if ($errors->has('hochulot'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hochulot') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Tên -->
                        <div class="form-group{{ $errors->has('ten') ? ' has-error' : '' }}">
                            <label for="ten" class="col-md-4 control-label">Tên</label>

                            <div class="col-md-6">
                                <input id="ten" type="text" class="form-control" name="ten" value="{{ old('ten') }}" placeholder="Tên">

                                @if ($errors->has('ten'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ten') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Email AGU -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email AGU">
                                    <span class="input-group-addon">@agu.edu.vn</span>
                                </div>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Chứng minh nhân dân -->
                        <div class="form-group{{ $errors->has('cmnd') ? ' has-error' : '' }}">
                            <label for="cmnd" class="col-md-4 control-label">Chứng minh nhân dân</label>

                            <div class="col-md-6">
                                <input id="cmnd" type="text" class="form-control" name="cmnd" value="{{ old('cmnd') }}" placeholder="Số chứng minh nhân dân">

                                @if ($errors->has('cmnd'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cmnd') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Giới tính -->
                        <div class="form-group{{ $errors->has('gioitinh') ? ' has-error' : '' }}">
                            <label for="gioitinh" class="col-md-4 control-label">Giới tính</label>

                            <div class="col-md-6">
                                <div class="form-control">
                                    <label for="gioitinhnam">Nam </label>
                                    <input id="gioitinhnam" type="radio" class="" name="gioitinh" value="{{1, old('gioitinh') }}">
                                    <label for="gioitinhnu">Nữ </label>
                                    <input id="gioitinhnu" type="radio" class="" name="gioitinh" value="{{2, old('gioitinh') }}">
                                </div>
                                @if ($errors->has('gioitinh'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gioitinh') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Ngày sinh -->
                        <div class="form-group{{ $errors->has('ngaysinh') ? ' has-error' : '' }}">
                            <label for="ngaysinh" class="col-md-4 control-label">Ngày sinh</label>

                            <div class="col-md-6">ư
                                <input id="ngaysinh" type="date" class="form-control" name="ngaysinh" value="{{ old('ngaysinh') }}" required autofocus>

                                @if ($errors->has('ngaysinh'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ngaysinh') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
