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
@endsection

@section('content')
  @if(isset($HocKyNamHoc_HienTai))
    <div class="row">
      <div class="x_panel">
        <div class="x_title">
          <h2> <i class="fa fa-user-secret"></i> Danh sách ban cán sự  {{$HocKyNamHoc_HienTai->tenhockynamhoc}} </h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
          <div class="pull-right">
            <a href="{{ route('subadmin_bancansu_add') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> <strong> Thêm mới </strong> </a>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            @include('layouts.gentelella-master.blocks.flash-messages')
            <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
              <thead>
                  <tr class="filters">
                      <th>#</th>
                      <th>MSSV</th>
                      <th>Họ tên</th>
                      <th>Nam/Nữ</th>
                      <th>Email</th>
                      <th>Lớp</th>
                      <th>Chức vụ</th>
                  </tr>
              </thead>
              <tbody id="tbodystudent">
                  @if(isset($DS_BanCanSu_HienTai) && count($DS_BanCanSu_HienTai) > 0)
                      <?php $STT = 0; ?>
                      @foreach($DS_BanCanSu_HienTai as $banCanSu)
                          <tr>
                              <th class="text-center-middle">{{++$STT}}</th>
                              <td class="text-center-middle">{{$banCanSu->mssv}}</td>
                              <td class="text-justify-middle">
                                  {{ $banCanSu->hochulot }} {{ $banCanSu->ten }}
                              </td>
                              <td class="text-justify-middle">
                                  {{ $banCanSu->gioitinh? 'Nam' : 'Nữ' }}
                              </td>
                              <td class="text-justify-middle">
                                  {{ $banCanSu->email_agu }}
                              </td>
                              <td class="text-justify-middle">
                                  {{ $banCanSu->tenlop }}
                              </td>
                              
                              <td class="text-justify-middle">
                                  {{ $banCanSu->tenchucvubancansu }}
                              </td>
                          </tr>
                      @endforeach
                  @else
                    <tr>
                        <td colspan="7" class="text-center">KHÔNG CÓ DỮ LIỆU</td>
                    </tr>
                  @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  @endif

  @if(isset($DS_HocKyNamHoc))
    @foreach($DS_HocKyNamHoc as $HocKy_NamHoc)
      <div class="row">
        <div class="x_panel">
          <div class="x_title">
            <h2> <i class="fa fa-user-secret"></i> Danh sách ban cán sự {{ $HocKy_NamHoc->tenhockynamhoc}} </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content" style="display: none;">
            <?php 
              $DS_BanCanSu = App\Http\Controllers\BanCanSuController::getDSBanCanSu($HocKy_NamHoc->id);
             ?>
            <div class="row">
              @if(isset($DS_BanCanSu))
                @if(count($DS_BanCanSu)>0)
                    <?php $STT = '0' ?>
                    <table class="table table-striped table-bordered tableThoiGianDanhGia">
                      <thead>
                          <tr class="filters">
                              <th>#</th>
                              <th>MSSV</th>
                              <th>Họ tên</th>
                              <th>Nam/Nữ</th>
                              <th>Email</th>
                              <th>Lớp</th>
                              <th>Chức vụ</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody id="tbodystudent">
                        <?php $STT = 0; ?>
                        @foreach($DS_BanCanSu as $banCanSu)
                            <tr>
                                <th class="text-center-middle">{{++$STT}}</th>
                                <td class="text-center-middle">{{$banCanSu->mssv}}</td>
                                <td class="text-justify-middle">
                                    {{ $banCanSu->hochulot }} {{ $banCanSu->ten }}
                                </td>
                                <td class="text-justify-middle">
                                    {{ $banCanSu->gioitinh? 'Nam' : 'Nữ' }}
                                </td>
                                <td class="text-justify-middle">
                                    {{ $banCanSu->email_agu }}
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
                      </tbody>
                    </table>
                @else
                    {{'Chưa có dữ liệu!'}}
                @endif
              @else
                  {{'Không có thông tin!'}}
              @endif
            </div>
          </div>
        </div>
      </div>
    @endforeach
  @endif
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
@endsection