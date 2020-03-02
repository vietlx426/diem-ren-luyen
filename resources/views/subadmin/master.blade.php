@extends('layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/admin.css')}}">
@endsection

@section('content_one_column')
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-1 p-l-0 p-r-0 in" id="sidebar">
                @include('subadmin.menu_left')
            </div>
            <div class="col card none-margin">
                <div class="card-body">
                    <content>
                        <a href="#sidebar" class="toggle" data-toggle="collapse"><i class="fa fa-navicon fa-lg"></i></a>
                        <hr>
                        @yield('content')
                    </content>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @yield('javascript')
@endsection