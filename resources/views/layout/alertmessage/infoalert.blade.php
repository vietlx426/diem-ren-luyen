@extends('layout.alertmessage.layout.master');
  @if (session('status'))
    @section('content_body')
      <!-- <div class="alert alert-success"> -->
          <h5>{!! session('status') !!}</h5>
      <!-- </div> -->
    
    @endsection
    @section('content_footer')
      
      <a href="{{route('index')}}" class="btn btn-danger">
        <i class="fa fa-reply"></i>
        Quay lại trang chủ
      </a>

      <a href="{{route('redirect-login')}}" class="btn btn-primary">
        <i class="fa fa-sign-in"></i>
        Đăng nhập lại
      </a>

      <a target="_blank" href="https://mail.google.com" class="btn btn-warning">
        <i class="fa fa-sign-out"></i>
        Vào google để đăng xuất
      </a>
      <!-- <a target="_blank" href="https://mail.google.com" class="btn btn-primary"> Vào google để đăng xuất </a>
      <a href="{{route('index')}}" class="btn btn-primary"> Quay lại trang chủ </a> -->
    @endsection
  @else
    <script>window.location.href = "http://localhost/diemrenluyen/public";</script>
  @endif

