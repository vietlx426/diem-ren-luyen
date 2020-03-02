@extends('layouts.app')

<style>
    .bgImgCenter{
        background-image: url('images/background/bgr_agu_2.png');
        background-repeat: no-repeat;
        background-position: center; 
        position: relative;
        width: 100%;
        height: 100%;
    }
</style>

@section('content')
<div class="bgImgCenter">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('storechangepassword') }}">
                        {{ csrf_field() }}
                        <div class="col-md-12">
                            @include('layout.block.message_flash')
                        </div>

                        <div class="form-group{{ $errors->has('oldpassword') ? ' has-error' : '' }}">
                            <label for="oldpassword" class="col-md-4 control-label">Mật khẩu cũ</label>

                            <div class="col-md-6">
                                <input id="oldpassword" type="password" class="form-control" name="oldpassword" value="{{ old('oldpassword') }}" placeholder="Mật khẩu cũ" autofocus>

                                @if ($errors->has('oldpassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('oldpassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('newpassword') ? ' has-error' : '' }}">
                            <label for="newpassword" class="col-md-4 control-label">Mật khẩu mới</label>

                            <div class="col-md-6">
                                <input id="newpassword" type="password" class="form-control" name="newpassword" value="{{ old('newpassword') }}"  placeholder="Mật khẩu mới">

                                @if ($errors->has('newpassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('newpassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('confirmnewpassword') ? ' has-error' : '' }}">
                            <label for="confirmnewpassword" class="col-md-4 control-label">Xác nhận lại mật khẩu</label>

                            <div class="col-md-6">
                                <input id="confirmnewpassword" type="password" class="form-control" name="confirmnewpassword" value="{{ old('confirmnewpassword') }}"  placeholder="Xác nhận lại mật khẩu">

                                @if ($errors->has('confirmnewpassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('confirmnewpassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-danger">
                                    <strong> LƯU </strong>
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
