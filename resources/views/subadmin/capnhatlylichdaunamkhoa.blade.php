@extends('subadmin.layout.master')
@section('css')
    <!-- <link rel="stylesheet" type="text/css" href="{{URL::asset('css/admin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/image-profile.css')}}"> -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/dataTables.bootstrap.min.css')}}" type="text/css">

@endsection
@section('content')
    @if(isset($DanhSach_SinhVien) && count($DanhSach_SinhVien) > 0)
        <!-- <div class="page-header text-center">
            <br>
            <h4><b>DANH SÁCH TÂN SINH VIÊN KHOA {{strtoupper($Khoa->tenkhoa)}}</b></h4>
            <hr>
        </div> -->
        
        <!-- Block error message -->
        @include('layout.block.message_flash')
        @include('layout.block.message_validation')
        <!-- <div id="piechart"></div> -->


        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Danh sách sinh viên khoa {{$Khoa->tenkhoa}}</h3>
                <hr width="30%">
            </div>

            <table id="tblsv" class="table table-striped table-bordered" width="100%">
                <thead>
                    <tr class="filters">
                        <th width="5%">#</th>
                        <th width="10%">MSSV</th>
                        <th width="20%">Họ và tên</th>
                        <th width="10%">Lớp</th>
                        <th width="20%">Ngành</th>
                        <th width="20%">Khoa</th>
                        <th width="15%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $STT = 0; ?>
                    @foreach($DanhSach_SinhVien as $SinhVien)
                        <tr>
                            <th class="text-center-middle">{{++$STT}}</th>
                            <td class="text-center-middle">
                                {{ $SinhVien->mssv }}
                            </td>
                            <td class="text-justify-middle">{{ $SinhVien->hochulot . ' ' . $SinhVien->ten }}</td>
                            <td class="text-center-middle">{{ $SinhVien->lop->tenlop }}</td>
                            <td class="text-justify-middle">
                                {{ $SinhVien->lop->nganh->tennganh }}
                            </td>
                            <td  class="text-justify-middle"> {{ $SinhVien->lop->nganh->bomon->khoa->tenkhoa }} </td>
                            <td class="text-center-middle">
                                <a target="_blank" href="{{route('studentprofile', ['id'=>$SinhVien->id])}}" class="btn {{count($SinhVien->lylich) ? 'btn-success' : 'btn-danger'}}" title="{{count($SinhVien->lylich) ? 'SV đã cập nhật lý lịch.' : 'SV chưa cập nhật lý lịch.'}} Click vào xem thông tin chi tiết">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
@section('javascript')
    @parent

   <!--  <script src="{{URL::asset('js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}" type="text/javascript" charset="utf-8" async defer></script> -->

    <script type="text/javascript" src="{!! URL::asset('js/jquery.dataTables.min.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/dataTables.bootstrap.min.js') !!}"></script>
    <script>
        $(document).ready(function() {
            $('#tblsv').DataTable();
        } );
    </script>

@endsection