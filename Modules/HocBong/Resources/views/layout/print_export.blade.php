<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {
                font-family: Times New Roman;
                font-size: 14px;
            }

            .text{
                padding: 5px 5px 5px 5px !important;
            }
        </style>
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}" type="text/css">
        <link href="{{URL::asset('css/font-awesome.min.css')}}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            @yield('container')
        </div>
    </body>
</html>
