@extends('covanhoctap.layout.master')
@section('title')
 @parent | Activity - Event
@endsection
@section('css')
    <!-- Datatables -->
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('gentelella-master/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

@endsection
@section('content')
  @if(isset($hocKyNamHocHienHanh))
    <div class="row">
      <div class="x_panel">
        <div class="x_title">
          <h2> <i class="fa fa-futbol-o"></i> Hoạt động sự kiện  {{$hocKyNamHocHienHanh->tenhockynamhoc}} </h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            @include('layouts.gentelella-master.blocks.flash-messages')

            @if(isset($dsHoatDongSuKienHienHanh))
              
                <input type="text" hidden="true" name="idhockynamhochienhanh" value="{{$hocKyNamHocHienHanh->id}}">
                <?php $STT = '0' ?>
                <table id="tbl_hoatdongsukien_hienhanh" class="table table-striped table-bordered tableThoiGianDanhGia">
                    <thead>
                        <tr>
                          <th>#</th>
                          <th>Hoạt động-sự kiện</th>
                          <th>T/g bắt đầu</th>
                          <th>Địa điểm</th>
                          <th>T/chí-Điểm</th>
                          <th></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($dsHoatDongSuKienHienHanh as $HDSK)
                          <tr>
                              <th>{{++$STT}}</th>
                              <td>{{$HDSK->tenhoatdongsukien}}</td>
                              <td>{{date('h:i a d/m/Y',strtotime($HDSK->thoigianbatdau))}} <i class="fa fa-long-arrow-right"></i> {{date('h:i a d/m/Y',strtotime($HDSK->thoigianketthuc))}}</td>
                              <td>{{$HDSK->diadiem}}</td>
                              <td>
                                @if($HDSK->hoatdongsukientieuchi)
                                  @if($HDSK->hoatdongsukientieuchi[0]->tieuchi)
                                    <span class="label label-success">
                                      {{$HDSK->hoatdongsukientieuchi[0]->tieuchi ? $HDSK->hoatdongsukientieuchi[0]->tieuchi->chimuctieuchi: '#'}}
                                    </span>
                                    &nbsp; - 
                                  @endif
                                  @if($HDSK->hoatdongsukientieuchi[0]->diemcong)
                                    &nbsp;
                                    <span class="label label-warning">
                                      {{$HDSK->hoatdongsukientieuchi[0]->diemcong . " đ"}}
                                    </span>
                                  @endif
                                @endif
                              </td>
                              <td class="text-center">
                                <a href="{{route('covanhoctap_hoatdongsukien_show', ['id'=>$HDSK->id])}}" class="btn btn-info a-waiting" title="Xem thông tin chi tiết"> <i class="fa fa-info-circle"></i> </a>
                              </td>
                          </tr>
                      @endforeach
                    </tbody>
                </table>
            @else
                {{'Không có thông tin!'}}
            @endif
          </div>
        </div>
      </div>
    </div>
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

    <script type="text/javascript">
      $('#tbl_hoatdongsukien_hienhanh').dataTable();
      $('.a-waiting').click(function(e){
        loadereffectshow();
      });
    </script>
@endsection