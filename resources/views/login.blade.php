@extends('layout.master')
@section('content_one_column')
    <div class="col-md-4 offset-md-4">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <i class="fa fa-user card-image-container"></i>
                </div>
               @include('layout.block.message_alarm') 
               @include('layout.block.message_error')
                <!-- Form Signin -->
                <form action="{{route('post_login')}}" method="post" class="form-signin" accept-charset="utf-8">
                    {{ csrf_field() }}
                    <span id="reauth-email" class="reauth-email"></span>
                    <div class="form-group">
                        <label for="email"> Email </label>
                        <div class="input-group">
                            <input type="email" name="Email" id="email" class="form-control" placeholder="Tài khoản" autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password"> Mật khẩu </label>
                        <div class="input-group">
                            <input type="password" name="Password" id="password" class="form-control" placeholder="Mật khẩu" >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="Remember" value="remember-me"> Ghi nhớ
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">ĐĂNG NHẬP </button>
                </form>
            </div>
            <div class="card-footer">
                <a href="#" class="forgot-password card-link">
                    Quên mật khẩu?
                </a>
                <a href="{{ URL::to('auth/google') }}" class="btn btn-lg btn-primary btn-block btn-signin" type="submit">ĐĂNG NHẬP BẰNG GOOGLE</a>
            </div>
        </div>
    </div>
@endsection