@extends('admin.layout.master')

@section('title')
  @parent | Search student
@endsection

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">

@endsection

@section('content')

  <div id="div-studentListResult" class="row">
    <div class="x_panel">
      <div class="x_title">
        <div class="pull-right">
          
          <a href="{{route('thongbao.create')}}" class="btn btn-success">
            <strong><i class="fa fa-upload"></i> HỒ SƠ </strong>
          </a>
        </div>
        <h2> <i class="fa fa-list"></i>DANH SÁCH HỒ SƠ CẤP HỌC BỔNG</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="row">
          <div class="col-12 col-md-12">
            <!-- Block error message -->
            @include('layout.block.message_flash')
          </div>
        </div>
        <div class="row">
                    @if(isset($dsHoSo))
                        <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
                                <thead>
                                <tr class="filters">
                                  <th >STT</th>
                                  <th>MSSV</th>
                                  <th >Tên sinh viên</th>
                                  <th >Học bổng</th>
                                  <th>Học kỳ, năm học</th>
                                  <th >File hồ sơ</th>
                                   <th >Trạng thái</th>
                                </tr>
                            </thead> 
                            <tbody>
                               @foreach($dsHoSo as $data)
                               <tr>
                                 <td >{{$loop->iteration}}</td>
                                 <td >{{$data->sinhvien->mssv}}</td>
                                 <td >{{$data->sinhvien->hochulot}} {{$data->sinhvien->ten}}</td>
                                 <td >
                                 {{$data->hocbong->tenhb}}
                                 </td>
                                 <td>
                                 @foreach($dshocky as $hocky)
                                  @if($hocky->id === $data->hocbong->idhockynamhoc)
                                  {{$hocky->tenhockynamhoc}}
                                  @endif 
                                  @endforeach
                                 </td>
                                 <td class="">
                                   
                                  
                                 @foreach($fileHoSo as $file)
                                  @if($file->id_hoso === $data->id)
                                  <?php 
                                  $tenfile = str_replace('%20', ' ', $file->url);
                                  ?>
                                  <a href="{{route('download.file.hoso',$file->id)}}">{{$tenfile}}</a> <br><br>
                                  @endif 
                                  @endforeach
                                 </td>
                                
                                
                                 <td class="text-center">
                                 @if($data->status == 0)
                                   <a href=""  onclick="TraoHocBong(
                                     '{{$data->id}}',
                                     '{{$data->sinhvien->mssv}}',
                                     '{{$data->sinhvien->id}}', 
                                     '{{$data->sinhvien->hochulot}}',
                                     '{{$data->sinhvien->ten}}',
                                     '{{$data->hocbong->mahb}}',
                                     '{{$data->hocbong->id}}',
                                     '{{$data->hocbong->tenhb}}',
                                     '{{$data->hocbong->gtmoihocbong}}'
                                   )" data-toggle="modal" data-target="#TraoHocBong" class="btn btn-warning" title="Trao học bổng">
                                    <i class="fa fa-edit"></i> </a>

                                  @else
                                   <i style="font-size: 40px; color: green" class="fa fa-check-circle" ></i> 
                                  @endif
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
  <form action="{{route('hoso.trao.hocbong')}}" method="post">
    {{ csrf_field() }}
  <div id="TraoHocBong" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <!-- <form action="" method="post" class="form-signin" accept-charset="utf-8"> -->
                    <div class="modal-header">
                        <div class="col-11 pull-left">
                            <h3>Sửa văn bản</h3>
                        </div>
                        <div class="col-1 pull-right">
                            <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                      @include('layout.block.message_validation')
                      <div class="form-group">
                            <label for="TenSV">Giá trị học bổng</label>
                            <input type="hidden" name="IDHoSo" id="IDHoSo" class="form-control IDHoSo" placeholder="Tên văn bản"  autofocus>
                            
                        </div>
                        <div class="form-group">
                            <label for="TenSV"> MSSV</label>
                            <input type="text" name="MSSV" id="MSSV" class="form-control MSSV" placeholder="MSSV"  readonly="readonly"   autofocus>
                            <input type="hidden" name="IDSV" id="IDSV" class="form-control IDSV" placeholder="IDSV"  readonly="readonly"   autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenSV"> Họ tên sinh viên</label>
                            <input type="text" name="TenSV" id="TenSV" class="form-control MaLop" placeholder="Tên sinh viên"  readonly="readonly"   autofocus>
                            
                        </div>
                        
                        <div class="form-group">
                            <label for="TenSV"> Mã học bổng</label>
                            <input type="text" name="MaHB" id="MaHB" class="form-control MaHB" placeholder="Tên văn bản"  readonly="readonly"   autofocus>
                            <input type="hidden" name="IDHB" id="IDHB" class="form-control IDHB" placeholder="Tên văn bản"  readonly="readonly"   autofocus>
                        </div>
                        <div class="form-group">
                            <label for="TenSV"> Tên học bổng</label>
                            <input type="text" name="TenHB" id="TenHB" class="form-control TenHB" placeholder="Tên văn bản"  readonly="readonly"   autofocus>
                            
                        </div>
                        <div class="form-group">
                            <label for="TenSV">Giá trị học bổng</label>
                            <input type="text" name="GTHB" id="GTHB" class="form-control MaLop" placeholder="Tên văn bản"  autofocus>
                            
                        </div>
                        
                        
                     
                        

                        
                       
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Thực hiện</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Đóng </button>
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
  </form>
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
    
    <script type="text/javascript" src="{!! URL::asset('js/ajax.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/admin_student_filter.js') !!}"></script>

    
    <script>
    function TraoHocBong($idhoso,$mssv,$idsv, $hochulot, $tensv, $mahb, $idhb , $tenhb, $gtmoihocbong) {
    $("#IDHoSo").val($idhoso);
    $("#MSSV").val($mssv);
    $("#IDSV").val($idsv);
    $("#TenSV").val($hochulot+' '+$tensv);
    $("#MaHB").val($mahb);
    $("#IDHB").val($idhb);
    $('#TenHB').val($tenhb);
    $('#GTHB').val($gtmoihocbong);
   
}
    var msg = '{{Session::get('alert_them')}}';
    var exist = '{{Session::has('alert_them')}}';
    if(exist){
      alert(msg);
    }
    var msg1 = '{{Session::get('alert_sua')}}';
    var exist1 = '{{Session::has('alert_sua')}}';
    if(exist1){
      alert(msg1);
    }
  </script>
  <script>
      $('.btn-remove').click(function(e){
        if(confirm("Bạn chắc chắn muốn xóa ?") == false)
        {
          e.preventDefault();
          e.stopImmediatePropagation();
        }
      });
    </script>
    <script type="text/javascript">
      $('#tbl_khoa').dataTable();
    </script>
@endsection