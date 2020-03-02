<?php 
    header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', FALSE);
    header('Pragma: no-cache');
 ?>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="cache-control" content="max-age=0">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="0">
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
        <meta http-equiv="pragma" content="no-cache">

        <title>QL ĐRL @yield('title')</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}" type="text/css">
        <link href="{{URL::asset('css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/master.css')}}" rel="stylesheet" type="text/css">

        @yield('css')
        
    </head>
    <body>
        <!-- Header -->
        <header>
            <!-- Banner -->
           @include('layout.block.banner')

            <!-- Horizontal menu -->
            @include('layout.block.menu_horizontal')
        </header>
        
        <!-- Content -->
        <content>
            <div class="container">
                <div class="row">
                    @yield('content_one_column')
                </div>
                <div class="row">
                    <!-- Left conten -->
                   
                    <div class="row col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        @yield('çontent_left')
                    </div>

                    <!-- Middle content -->
                    <div class="row col-12 col-xs-2 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                         @yield('middle')
                    </div>
                </div>
            </div>
        </content>

        <!-- Footer -->
        <hr>
        <footer>
           @include('layout.block.footer')
        </footer>
        
        <!-- Javascript -->
        <script src="{{URL::asset('js/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('js/bootstrap.min.js')}}" type="text/javascript" charset="utf-8" async defer></script>
        <script type="text/javascript" src="{!! URL::asset('js/ckeditor/ckeditor.js') !!}"></script>
        <script type="text/javascript" src="{!! URL::asset('js/ckfinder/ckfinder.js') !!}"></script>
        @yield('javascript')
    </body>
</html>
