@extends('subadmin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/filterTable.css')}}">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <!-- <div class="page-header text-center">
        <h3> DANH SÁCH SINH VIÊN </h3>
    </div> -->
    
    <!-- Page content - Danh sách sinh viên -->
    <!-- <div class="page-content">
        @if(isset($DanhSach_SinhVien))
            @if(count($DanhSach_SinhVien)>0)
                <?php $STT = '0' ?>
                <table class="table table-striped">
                     <thead>
                        <tr class="text-center-middle">
                            <th width="5%">#</th>
                            <th width="10%">MSSV</th>
                            <th width="20%">Họ tên</th>
                            <th width="10%">Lớp</th>
                            <th width="20%">Ngành</th>
                            <th width="20%">Khoa</th>
                            <th width="15%"></th>
                        </tr>
                    </thead> 
                    <tbody>
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
                                <td class="text-right-middle">
                                    <button type="button" class="btn btn-warning" title="Xem thông tin chi tiết">
                                        <i class="fa fa-info-circle"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" title="Thêm hình ảnh"><i class="fa fa-picture-o"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                {{'Chưa có dữ liệu!'}}
            @endif
        @else
            {{'Không có thông tin!'}}
        @endif
    </div> -->

    <div class="page-content">
        <div class="row">
            @if(isset($DanhSach_SinhVien))
                @if(count($DanhSach_SinhVien)>0)
                    <?php $STT = '0' ?>
                   <!--  <div class="card bg-info text-white">
                        <div class="card-heading"> -->
                    <div class="panel panel-primary filterable">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">DANH SÁCH SINH VIÊN</h3>
                             
                            <div class="pull-right">
                                <button class="btn btn-default btn-xs btn-filter"><i class="fa fa-filter"></i> Lọc</button>
                            </div>
                                
                        </div>
                        <table class="table table-striped" width="100%">
                            <thead>
                                <tr class="filters">
                                    <th width="5%"><input type="text" class="form-control" placeholder="#" disabled></th>
                                    <th width="10%"><input type="text" class="form-control" placeholder="MSSV" disabled></th>
                                    <th width="20%"><input type="text" class="form-control" placeholder="Họ và tên" disabled></th>
                                    <th width="10%"><input type="text" class="form-control" placeholder="Lớp" disabled></th>
                                    <th width="20%"><input type="text" class="form-control" placeholder="Ngành" disabled></th>
                                    <th width="20%"><input type="text" class="form-control" placeholder="Khoa" disabled></th>
                                    <th width="15%"></th>
                                </tr>
                            </thead>
                            <tbody>
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
                                        <td class="text-right-middle">
                                            <a target="_blank" href="{{route('studentprofile', ['id'=>$SinhVien->id])}}" class="btn btn-warning" title="Xem thông tin chi tiết">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            <!-- <button type="button" class="btn btn-danger" title="Thêm hình ảnh"><i class="fa fa-picture-o"></i>
                                            </button> -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                {{'Chưa có dữ liệu!'}}
                @endif
            @else
                {{'Không có thông tin!'}}
            @endif
        </div>
    </div>

@endsection
@section('javascript')
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/filterTable.js') !!}"></script>
     <script src="{{URL::asset('js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}" type="text/javascript" charset="utf-8" async defer></script>
@endsection