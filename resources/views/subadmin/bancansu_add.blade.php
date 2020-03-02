@extends('subadmin.layout.master')
@section('title')
  @parent | Monitor list
@endsection

@section('css')
  @parent
  <!-- Datatables -->
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{URL::asset('gentelella-master/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
  <!-- iCheck -->
  <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-user-secret"></i> Danh sách ban cán sự </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li>
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('post_subadmin_bancansu_add') }}" method="POST">
          {{csrf_field()}}
          @include('layouts.gentelella-master.blocks.flash-messages')
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <label for="">Học kỳ - Năm học</label>
              <select name="idhockynamhoc" id="idhockynamhoc" class="form-control">
                @if(isset($DS_HocKyNamHoc))
                  @foreach($DS_HocKyNamHoc as $HocKyNamHoc)
                    <option value="{{ $HocKyNamHoc->id }}"> {{ $HocKyNamHoc->tenhockynamhoc }} </option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="col-sm-12 col-md-6">
              <label for="">Lớp</label>
              <select name="idlop" id="idlop" class="form-control">
                @if(isset($DS_Lop))
                  @foreach($DS_Lop as $Lop)
                    <option value="{{ $Lop->id }}"> {{ $Lop->tenlop }} </option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-12 text-center">
              <a id="btn_bancansu_search" class="btn btn-primary"><i class="fa fa-search"></i> <strong> SEARCH/FILTER </strong> </a>
            </div>
          </div>
          <hr>
          <div class="row">
            <input id="selected_idhockynamhhoc" name="selected_idhockynamhhoc" type="text" hidden="true" value="">
            <input id="selected_idlop" name="selected_idlop" type="text" hidden="true" value="">
            <table id="tbl_bancansu_add" class="table table-striped table-bordered" width="100%">
              <thead>
                  <tr class="filters">
                      <th width="3%">#</th>
                      <th width="7%">MSSV</th>
                      <th width="20%">Họ tên</th>
                      @if(isset($DS_ChucVuBanCanSu))
                        @foreach($DS_ChucVuBanCanSu as $ChucVuBanCanSu)
                          <th width="9%">{{$ChucVuBanCanSu->tenchucvubancansu}}</th>
                        @endforeach
                      @endif
                  </tr>
              </thead>
              <tbody id="tbody_bancansu_add">
                  @if(isset($DS_BanCanSu_HienTai))
                      <?php $STT = 0; ?>
                      @foreach($DS_BanCanSu_HienTai as $banCanSu)
                          <tr>
                              <th class="text-center-middle">{{++$STT}}</th>
                              <td class="text-center-middle">{{$banCanSu->mssv}}</td>
                              <td class="text-justify-middle">
                                  {{ $banCanSu->hochulot }} {{ $banCanSu->ten }}
                              </td>
                              <td class="text-justify-middle">
                                  {{ $banCanSu->tenlop }}

                              </td>
                              
                              <td class="text-justify-middle">
                                  {{ $banCanSu->tenchucvubancansu }}
                              </td>
                              <td class="text-center-middle">
                                <a target="_blank" href="{{route('staffedit', ['idstaff' => $banCanSu->id])}}" class="btn btn-warning" title="Xem chi tiết & Sửa"><i class="fa fa-edit"></i></a>
                              </td>
                          </tr>
                      @endforeach
                  @endif
              </tbody>
            </table>
            <div id="div_save" class="row text-center hidden">
              <button class="btn btn-primary"> <i class="fa fa-save"></i> <strong> LƯU </strong></button>
            </div>
          </div>
        </form>

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
    
    <script src="{{URL::asset('js/subadmin.js')}}"></script>
    <script>
      $('#tbl_bancansu_add').DataTable();
      var urlRoute_get_bancansu_lop_hockynamhoc = "{{route('get_bancansu_lop_hockynamhoc')}}";
      var urlRoute_get_chucvubancansu = "{{route('get_chucvubancansu')}}";
    </script>
@endsection