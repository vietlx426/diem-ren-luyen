@extends('sinhvien.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <!-- iCheck -->
    <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header text-center">
        <h3> CHẤM ĐIỂM RÈN LUYỆN</h3>
        <h4> {{$HocKy->tenhockynamhoc}} </h4>
    </div>
    <!-- Page content - Danh sách tiêu chi -->
    <div class="page-content">
        <div id="contentloading" class="bg-text" hidden="true"><img id="loader-img" alt="" src="{{URL::asset('images/loading.gif')}}" width="100" height="100" align="center" /></div>

        @if(isset($DS_BangDiem))
            @if(count($DS_BangDiem)>0)
                <?php $STT = '0' ?>
                @include('layout.block.message_validation')
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="75%">Nội dung</th>
                            <th width="10%">Điểm tối đa</th>
                            <th width="10%">SV Đánh giá</th>
                            <!-- <th></th> -->
                        </tr>
                    </thead> 
                    <tbody id="tbbodytieuchi">
                        @foreach($DS_BangDiem as $BangDiem)
                            <tr>
                                <th class="text-center-middle">{{$BangDiem->chimuctieuchi}}</th>
                                <td class="text-justify-middle">
                                    @if($BangDiem->idtieuchicha == 0 || $BangDiem->idtieuchicha == null)
                                        <p class="font-weight-bold">
                                            {!! $BangDiem->tentieuchi !!}
                                        </p>
                                    @else
                                        {!! $BangDiem->tentieuchi !!}
                                    @endif
                                </td>
                                <td class="text-center-middle">{{$BangDiem->diemtoida}}</td>
                                <td class="text-center-middle">
                                    @if(intval($BangDiem->idloaidiem) === intval(1))
                                        @if($BangDiem->sinhvien_diem != null)
                                            <input  style="text-align:center; border: none; font-weight: bold; color: #fff; background-color: #ff6400;" id="{{$BangDiem->id}}" class="form-control" type="number" readonly="true"  value="{{$BangDiem->sinhvien_diem}}">
                                        @else
                                            <input  style="text-align:center; border: none; font-weight: bold; color: #fff; background-color: #ff6400;" id="{{$BangDiem->id}}" class="form-control" type="number" readonly="true"  value="0">
                                        @endif
                                    @endif
                                    @if(intval($BangDiem->idloaidiem) === intval(2))
                                        <input style="text-align:center;" onkeyup="xulydiemmax(this)" class="form-control xulydanhgia " type="number" id="{{$BangDiem->id}}" max="{{$BangDiem->diemtoida}}" name="{{$BangDiem->idtieuchicha}}" diem="{{$BangDiem->diemtoida}}" value="{{$BangDiem->sinhvien_diem}}"  required >
                                    @endif
                                    @if(intval($BangDiem->idloaidiem) === intval(3))
                                        @if(intval($BangDiem->sinhvien_diem) != intval(0))
                                            <input class="xulydanhgia flat"  type="checkbox" id="{{$BangDiem->id}}" name="{{$BangDiem->idtieuchicha}}" diem="{{$BangDiem->diemtoida}}" value="{{$BangDiem->id}}-{{$BangDiem->diemtoida}}"  checked>
                                        @else
                                            <input class="xulydanhgia flat"  type="checkbox" id="{{$BangDiem->id}}" name="{{$BangDiem->idtieuchicha}}" diem="{{$BangDiem->diemtoida}}"  value="{{$BangDiem->id}}-{{$BangDiem->diemtoida}}">
                                        @endif
                                    @endif
                                    @if(intval($BangDiem->idloaidiem) === intval(4))
                                        @if(intval($BangDiem->sinhvien_diem) != intval(0))
                                            <input class="xulydanhgia flat" type="radio" name="{{$BangDiem->idtieuchicha}}" id="{{$BangDiem->id}}" diem="{{$BangDiem->diemtoida}}"  value="{{$BangDiem->id}}-{{$BangDiem->diemtoida}}" checked>
                                        @else
                                            <input class="xulydanhgia flat" type="radio" id="{{$BangDiem->id}}" name="{{$BangDiem->idtieuchicha}}" diem="{{$BangDiem->diemtoida}}" value="{{$BangDiem->id}}-{{$BangDiem->diemtoida}}" >
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold" style="text-align:center; border: none; font-weight: bold; color: #fff; background-color: #ff6400;">
                            <td colspan="2" class="text-center"> <strong> Tổng điểm </strong></td>
                            <td class="text-center-middle"> <strong> 100 </strong></td>
                            <td class="text-center-middle" style="font-size: 20px;">
                                {{$TongDiem[0]->T}}
                            </td>
                        </tr>
                        @if(count($TGDG)>0)
                            <tr>
                                <td colspan="6" class="text-right-middle ">
                                    <button type="button" href="{{route('sinhvien_bangdiemrenluyen_danhgia_post')}}" class="btn btn-primary bangdiemrenluyen_xacnhan">
                                        <i class="fa fa-save"></i> <strong> ĐỒNG Ý (LƯU) </strong>
                                    </button>
                                </td>
                            </tr>
                        @endif
                    </tfoot>
                </table>
            @else
                {{'Chưa có dữ liệu!'}}
            @endif
        @else
            {{'Không có thông tin!'}}
        @endif
    </div>
@endsection
@section('javascript')
    @parent

    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>

    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/subadmin_bangdiem.js') !!}"></script>
    <script type="text/javascript">
        function xulydiemmax(element) {
            var max =element.getAttribute("diem");
            if(element.value > max){   
                element.value = element.getAttribute("diem");
            }
            else{
                 if(element.value > 50)
                     element.value =element.getAttribute("diem");
                 else if(element.value.length>2)
                    element.value =max;
            }
        }
        // $("input").change(function(){
        //     tinhtongdiem();
        // });

        // function tinhtongdiem(){
        //     $("input[type='checkbox']").each(function(){
        //         if($(this).is(':checked')){
        //             var element = document.getElementById($(this).attr("tieuchicha"));
        //             element.value += $(this).attr("diem");
        //         }


        //     });
        // }

    </script>
 
@endsection