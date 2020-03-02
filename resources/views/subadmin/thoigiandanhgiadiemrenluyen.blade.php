@extends('subadmin.layout.master')
@section('title')
  @parent | Staff list
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
  @if(isset($HocKy_NamHoc_HienHanh))
    <div class="row">
      <div class="x_panel">
        <div class="x_title">
          <h2> <i class="fa fa-calendar"></i> Thời gian đánh giá điểm rèn luyện {{$HocKy_NamHoc_HienHanh->tenhockynamhoc}} </h2>
          <div class="pull-right"><a href="{{ route('get_subadmin_thoigiandanhgiaDRL_add') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> <strong> Thêm mới </strong> </a></div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            @include('layouts.gentelella-master.blocks.flash-messages')

            @if(isset($DS_ThoiGianDanhGiaDRL_HienHanh))
              @if(count($DS_ThoiGianDanhGiaDRL_HienHanh)>0)
                  <?php $STT = '0' ?>
                  <table class="table table-striped table-bordered tableThoiGianDanhGia">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Lớp</th>
                              <th>Thời gian bắt đầu</th>
                              <th>Thời gian kết thúc</th>
                              <th></th>
                          </tr>
                      </thead> 
                      <tbody>
                          @foreach($DS_ThoiGianDanhGiaDRL_HienHanh as $ThoiGianDanhGiaDRL)
                              <tr>
                                  <th>{{++$STT}}</th>
                                  <td>{{$ThoiGianDanhGiaDRL->lop->tenlop}}</td>
                                  <td>{{date('d/m/Y',strtotime($ThoiGianDanhGiaDRL->thoigianbatdau))}}</td>
                                  <td>{{date('d/m/Y',strtotime($ThoiGianDanhGiaDRL->thoigianketthuc))}}</td>
                                  <td class="text-center">
                                     <a href="{{route('post_subadmin_thoigiandanhgiaDRL_edit',['id'=>$ThoiGianDanhGiaDRL->id])}}" class="btn btn-primary"> <i class="fa fa-pencil-square-o"></i> </a>
                                      <button type="button" class="btn btn-danger remove_TGDGDRL" href="{{route('TGDGDRL_destroy',['id'=>$ThoiGianDanhGiaDRL->id])}}" Ten="{{$ThoiGianDanhGiaDRL->hocky_namhoc->tenhockynamhoc}}" title="Xóa"><i class="fa fa-remove"></i>
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
          </div>
        </div>
      </div>
    </div>
  @endif

  @if(isset($DS_hocky_namhoc))
    @foreach($DS_hocky_namhoc as $HocKy_NamHoc)
      <div class="row">
        <div class="x_panel">
          <div class="x_title">
            <h2> <i class="fa fa-calendar"></i> Thời gian đánh giá điểm rèn luyện {{ $HocKy_NamHoc->tenhockynamhoc}} </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content" style="display: none;">
            <?php 
              $DS_ThoiGianDanhGiaDRL = App\Http\Controllers\ThoiGianDanhGiaDRLController::getThoiGianDanhGiaDRLTheoHocKy($HocKy_NamHoc->id);
             ?>
            <div class="row">
              @if(isset($DS_ThoiGianDanhGiaDRL))
                @if(count($DS_ThoiGianDanhGiaDRL)>0)
                    <?php $STT = '0' ?>
                    <table class="table table-striped table-bordered tableThoiGianDanhGia">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Lớp</th>
                                <th>Thời gian bắt đầu</th>
                                <th>Thời gian kết thúc</th>
                                <th></th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($DS_ThoiGianDanhGiaDRL as $ThoiGianDanhGiaDRL)
                                <tr>
                                    <th>{{++$STT}}</th>
                                    <td>{{$ThoiGianDanhGiaDRL->lop->tenlop}}</td>
                                    <td>{{date('d/m/Y',strtotime($ThoiGianDanhGiaDRL->thoigianbatdau))}}</td>
                                    <td>{{date('d/m/Y',strtotime($ThoiGianDanhGiaDRL->thoigianketthuc))}}</td>
                                    <td>
                                       <a href="{{route('post_subadmin_thoigiandanhgiaDRL_edit',['id'=>$ThoiGianDanhGiaDRL->id])}}" class="btn btn-primary fa fa-pencil-square-o"></a>
                                        <button type="button" class="btn btn-danger remove_TGDGDRL" href="{{route('TGDGDRL_destroy',['id'=>$ThoiGianDanhGiaDRL->id])}}" Ten="{{$ThoiGianDanhGiaDRL->hocky_namhoc->tenhockynamhoc}}" title="Xóa"><i class="fa fa-remove"></i>
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

    <script type="text/javascript" src=" {{URL::asset('js/subadmin.js')}} "></script>

    <script>
      $('.tableThoiGianDanhGia').dataTable();
    </script>
@endsection