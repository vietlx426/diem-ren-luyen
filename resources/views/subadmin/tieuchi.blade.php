@extends('subadmin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page header - Tiêu đề danh sách -->
    <div class="page-header text-center">
        <h3> TIÊU CHÍ ĐIỂM RÈN LUYỆN </h3>
    </div>
    <div class="x_panel">
      <div class="x_content">
        <div class="row">
          @if(isset($DanhSach_TieuChi))
            <?php $STT = '0' ?>
            <table class="table table-striped" width="100%">
                <thead>
                    <tr>
                        <th width="5%" class="text-center-middle">#</th>
                        <th width="85%">Nội dung</th>
                        <th width="10%" class="text-right-middle">Hạn mức</th>
                    </tr>
                </thead> 
                <tbody>
                    @foreach($DanhSach_TieuChi as $TieuChi)
                        <tr>
                            <th class="text-center-middle">{{$TieuChi->chimuctieuchi}}</th>
                            <td class="text-justify-middle">
                                @if($TieuChi->idtieuchicha == 0 || $TieuChi->idtieuchicha == null)
                                    <p class="font-weight-bold">
                                         {!! $TieuChi->tentieuchi !!}
                                    </p>
                                @else
                                    {!! $TieuChi->tentieuchi !!}
                                @endif
                            </td>
                            <td class="text-right-middle">{{$TieuChi->diemtoida}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-center">
                          <strong>Tổng điểm</strong>
                        </td>
                        <td class="text-right-middle">
                            @if(isset($totalMarks))
                                <strong>{{$totalMarks}}</strong>
                            @endif
                        </td>
                    </tr>
                </tfoot>
            </table>
          @endif
        </div>
      </div>
    </div>
@endsection
