@extends('layouts.app_none_navbar')
@section('content')
<div>
    <div class="row">
        <div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <div class="panel panel-default">
                <!-- <div class="panel-heading text-center">
                    <h4>THÔNG TIN ĐĂNG NHẬP</h4>
                </div> -->

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            @include('layout.block.message_flash')
                        </div>
                        <div class="row col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            @if ($errors->has('email') || $errors->has('password'))
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    &nbsp; E-mail và mật khẩu không đúng!
                                    
                                </div>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                <!-- @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif -->
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Mật khẩu</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                <!-- @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif -->
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" class="flat" {{ old('remember') ? 'checked' : '' }}> Nhớ mật khẩu
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block">
                                    <strong> <i class="fa fa-sign-in pull-left"></i> ĐĂNG NHẬP </strong>
                                </button>

                                <!-- <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Quên mật khẩu?
                                </a> -->
                            </div>
                        </div>

                    </form>

                    <div class="form-group">
                        <a class="btn btn-primary btn-block" href="{{ route('gsignin', ['provider'=>'google']) }}">
                            <strong> <i class="fa fa-google pull-left"></i> ĐĂNG NHẬP BẰNG EMAIL AGU </strong>
                        </a>
                    </div>

                    <!-- <div class="form-group">
                        <a target="_blank" class="btn btn-info btn-block" href="https://docs.google.com/document/d/1JQ-gvr14_1sDI9cMQXSIgXObJHgwH2CHP5s8Umnjyzk/edit?usp=sharing">
                            <strong> <i class="fa fa-info-circle pull-left"></i> HƯỚNG DẪN THÔNG TIN ĐĂNG NHẬP </strong>
                        </a>
                    </div> -->

                    <div class="form-group">
                        
                        <a target="_blank" class="btn btn-danger btn-block" href="https://docs.google.com/document/d/10E0XwPBZ_PyMlnDCNANt2xrz2B0ghcJURTGwDF-qsnA/edit?usp=sharing">
                            <marquee behavior="" direction="">
                                <strong> <i class="fa fa-info-circle pull-left"></i> HƯỚNG DẪN TÂN SINH VIÊN (KHÓA DH20 & CD44) </strong>
                            </marquee>
                        </a>
                    </div>


                </div>

                <!-- <div class="panel-footer text-center">
                    Nếu đăng nhập không được vui lòng liên hệ thầy Nguyễn Ngọc Trọng (0949.309.899 - <a href="mailto:nntrong@agu.edu.vn">nntrong@agu.edu.vn</a>)
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection
