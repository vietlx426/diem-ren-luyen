@extends('truongdonvi.layout.master')

@section('title')
    @parent
@endsection

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">
    <!-- iCheck -->
    <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2> <i class="fa fa-bar-chart"></i> THỐNG KÊ - BÁO CÁO THEO ĐƠN VỊ HÀNH CHÍNH </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h4 class="text-center"><label for=""> KHÓA </label></h4>
                        <div class="well" style="max-height: 150px; height:150px; overflow: auto;">
                            <ul class="list-group checked-list-box">
                                @if(isset($dsKhoaHoc))
                                    @foreach($dsKhoaHoc as $khoaHoc)
                                        <li class="list-group-item khoahoc" value="{{$khoaHoc->id}}"> {{$khoaHoc->tenkhoahoc}} </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h4 class="text-center"><label for=""> KHOA </label></h4>
                        <div class="well" style="max-height: 150px; height:150px; overflow: auto;">
                            <ul class="list-group checked-list-box">
                                @if(isset($dsKhoa))
                                    @foreach($dsKhoa as $khoa)
                                        <li class="list-group-item khoa" value="{{$khoa->id}}"> {{$khoa->tenkhoa}} </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="text-center"><label for=""> PHƯỜNG/XÃ </label></h4>
                        <div class="well" style="max-height: 150px; height:150px; overflow: auto;">
                            <ul id="ul-xa" class="list-group checked-list-box"> </ul>
                        </div>
                    </div> -->
                </div>


                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="text-center"><label for=""> TỈNH/THÀNH PHỐ </label></h4>
                        <div class="well" style="max-height: 150px; height:150px; overflow: auto;">
                            <ul class="list-group checked-list-box">
                                @if(isset($dsTinh))
                                    @foreach($dsTinh as $tinh)
                                        <li class="list-group-item tinh" value="{{$tinh->id}}"> {{$tinh->tentinh}} </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="text-center"><label for=""> QUẬN/HUYỆN </label></h4>
                        <div class="well" style="max-height: 150px; height:150px; overflow: auto;">
                            <ul id="ul-huyen" class="list-group checked-list-box"> </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="text-center"><label for=""> PHƯỜNG/XÃ </label></h4>
                        <div class="well" style="max-height: 150px; height:150px; overflow: auto;">
                            <ul id="ul-xa" class="list-group checked-list-box"> </ul>
                        </div>
                    </div>
                </div>

                <div class="row text-center">
                    <button class="btn btn-primary btn_statical_filter">
                        <i class="fa fa-search"></i> <strong> TÌM KIẾM </strong>
                    </button>
                    <!-- <button class="btn btn-success btn_export">
                        <i class="fa fa-file-excel-o"></i> <strong> XUẤT FILE </strong>
                    </button> -->
                </div>
            </div>
        </div>
    </div>

    <div id="div_chart" class="row" style="display:none;">
        <div class="x_panel">
            <div class="x_title">
                <h2> <i class="fa fa-bar-chart"></i> BIỂU ĐỒ THỐNG KÊ </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <div id="province_chart" style="width: 100%; height: 350px;"></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <div id="district_chart" style="width: 100%; height: 350px;"></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div id="town_chart" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>


    <div class="row div_table" style="display:none; background-color:#cccccc;">
        <div class="x_panel">
            <div class="x_title">
                <h2> <i class="fa fa-list"></i> DANH SÁCH THỐNG KÊ THEO TỈNH </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <table id="table_statical_province" class="table table-striped" width="100%">
                    <thead>
                        <tr class="filters">
                            <th width="10%">STT</th>
                            <th width="60%">TỈNH</th>
                            <th width="30%">SỐ LƯỢNG</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_statical_province">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row div_table" style="display:none;">
        <div class="x_panel">
            <div class="x_title">
                <h2> <i class="fa fa-list"></i> DANH SÁCH THỐNG KÊ THEO HUYỆN </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="table_statical_district" class="table table-striped" width="100%">
                    <thead>
                        <tr class="filters">
                            <th width="10%">STT</th>
                            <th width="60%">HUYỆN</th>
                            <th width="30%">SỐ LƯỢNG</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_statical_district">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row div_table" style="display:none;">
        <div class="x_panel" >
            <div class="x_title">
                <h2> <i class="fa fa-list"></i> DANH SÁCH THỐNG KÊ THEO XÃ </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="table_statical_town" class="table table-striped" width="100%">
                    <thead>
                        <tr class="filters">
                            <th width="10%">STT</th>
                            <th width="60%">XÃ</th>
                            <th width="30%">SỐ LƯỢNG</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_statical_town">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @parent

    <!-- Datatables -->
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/pdfmake/build/vfs_fonts.js')}}"></script>
    
    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
    
    <!-- Chart -->
    <script type="text/javascript" src="{{URL::asset('js/charts_loader.js')}}"></script>

    <!-- My define -->
    <script type="text/javascript" src="{!! URL::asset('js/function.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/ajax.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/admin_statical_region.js') !!}"></script>
    <script type="text/javascript">
        var urlRouteGetHuyenByTinh = "{{route('admin_gethuyenbytinh')}}";
        var urlRouteGetXaByHuyen = "{{route('admin_getxabyhuyen')}}";
        var urlRouteGetStaticalByTinhHuyenXa = "{{route('admin_getstaticalbytinhhuyenxa')}}";
    </script>
@endsection