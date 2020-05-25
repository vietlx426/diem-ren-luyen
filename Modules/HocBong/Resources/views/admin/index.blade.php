@extends('admin.layout.master')

@section('title')
  @parent | Search student
@endsection

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">

@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-graduation-cap"></i> HỌC BỔNG {{isset($getHKNH) ? $getHKNH->tenhockynamhoc : 'NĂM HỌC '.$getNamHoc->tennamhoc}} 

        </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="pull-right">
           
          <a href="{{route('hocbong.create')}}" class="btn btn-primary">
            <strong><i class="fa fa-plus"></i> THÊM </strong>
          </a>
          <a href="{{route('hocbong.import')}}" class="btn btn-success student_import">
            <strong><i class="fa fa-upload"></i> IMPORT </strong>
          </a>
          <a href="{{route('thongbao.create')}}" class="btn btn-success">
            <strong><i class="fa fa-upload"></i> THÔNG BÁO </strong>
          </a>
          
        </div>
        <div class="clearfix"></div>
      </div>
      
      
      <form>
        
      <div class="x_content">
        <div class="row">
          

          

          
    
          
          
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <h4 class="text-center">KHOA</h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                  <label class="control-label">Khoa</label>
              <select name="khoa" id="khoa" class="form-control">
                <option value="">--- Tất cả ---</option>
                
                  
                   @foreach($ds_khoa as $khoa)
                      <option value="{{$khoa->id}}" {{\Request::get('khoa')==$khoa->id ? "selected='selected'" : ""}}>{{$khoa->tenkhoa}}</option>
                    @endforeach
              </select>
              </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <h4 class="text-center">Năm học</h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                  <label class="control-label">Năm học</label>
              <select name="namhoc" id="namhoc" class="form-control">
                <option value="">--- Tất cả ---</option>
                
                  
                   @foreach($dsnamhoc as $namhoc)
                      <option value="{{$namhoc->id}}" {{\Request::get('namhoc')==$namhoc->id ? "selected='selected'" : ""}}>{{$namhoc->tennamhoc}}</option>
                    @endforeach
              </select>
              </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <h4 class="text-center">HỌC KỲ, NĂM HỌC</h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                  <label class="control-label">Học kỳ, năm học</label>
              <select name="hknh" id="hknh" class="form-control">
                <option value="">--- Tất cả ---</option>
                
                  
                   @foreach($ds_hknh as $hknh)
                      <option value="{{$hknh->id}}" {{\Request::get('hknh')==$hknh->id ? "selected='selected'" : ""}}>{{$hknh->tenhockynamhoc}}</option>
                    @endforeach
              </select>
              </div>
          </div>
            

          

        <div class="row text-center">
          <div class="col-xs-12 col sm-12 col-md-4 col-lg-4 col-xl-4 col-md-offset-4 col-lg-offset-4 col-xl-offset-4 form-group">
            <label for="inpmssv">Mã học bổng hoặc Tên học bổng </label>
            <input type="text" id="inpmssv" name="tenhb" placeholder="Tên học bổng" value="{{\Request::get('tenhb')}}" class="form-control" >
          </div>
        </div>


        <div class="row text-center">
          <button class="btn btn-primary student_filter">
            <i class="fa fa-search"></i> <strong> TÌM KIẾM/LỌC </strong>
          </button>
          
          <?php
          if(isset($getHKNH)){
        ?>
          <a href="{{route('xuatexcel.hocky',$getHKNH->id)}}" class="btn btn-success btn_export_bangdiem_bcs btn-download">
              <i class="fa fa-download"> </i>
              <strong> TẢI THỐNG KÊ</strong>
            </a> 
                                                      
        <?php                       
        }
        else{
        ?>
        

        <a href="{{route('xuatexcel.namhoc',$getNamHoc->id)}}" class="btn btn-success btn_export_bangdiem_bcs btn-download">
              <i class="fa fa-download"> </i>
              <strong> TẢI THỐNG KÊ</strong>
            </a>       
        <?php 
        }
        ?>

          
            
          
        </div>

      </div>
    </div>
    </form>
  </div>
</div>

  <div id="div-studentListResult" class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-list"></i>DANH SÁCH HỌC BỔNG {{isset($getHKNH) ? $getHKNH->tenhockynamhoc : 'NĂM HỌC '.$getNamHoc->tennamhoc}} </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="row">
                    @if(isset($scholar))
                         <?php $STT = 0; ?>
                        <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
                                <thead>
                                <tr class="filters">
                                  <th width="5%">STT</th>
                                  <th width="5%">Mã học bổng</th>
                                  <th width="10%">Tên học bổng</th>
                                  <th width="10%">Đơn vị tài trợ</th>
                                  <th width="10%">Phạm vi</th>
                                  <th width="15%">Học kỳ, năm học</th>
                                  <th width="10%">Giá trị học bổng</th>
                                  <th width="5%">Số lượng</th>
                                  <th width="5%">Số lượng đã trao</th>
                                  <th width="8%">Số tiền đã trao</th>
                                  <th width="10%">Trạng thái</th>
                                  
                                  <th width="10%"></th>
                                </tr>
                            </thead> 
                            <tbody>
                               @foreach($scholar as $data)
                                    <tr>
                                    <td>{{++$STT}}</td>
                                    <td>{{$data->mahb}}</td>
                                    <td>{{$data->tenhb}}</td>
                                    <td>{{$data->tendvtt}}</td>
                                    <td>
                 
                                    <?php
                                  if(count($toantruong->where("id_hocbong", $data->idhb)) < 9){
                                    ?>
                                    
                                      @foreach($hocbong_phamvi as $khoa)
                                      @if($khoa->id_hocbong == $data->idhb)
                                      <span class="label label-primary" style="font-size: 12px"> {{$khoa->tenkhoa->tenkhoa}} </span>
                                      <br><br>
                                      @endif
                                      @endforeach
                                    
                                    <?php
                                
                                  }
                                  else{
                                    ?>
                                    <span class="label label-success"  style="font-size: 12px"> Toàn trường </span>
                                    <?php 
                                  }
                                ?>

                          </td>
                          <td>{{isset ($data->HocKyNamHoc->tenhockynamhoc) ? $data->HocKyNamHoc->tenhockynamhoc :  '[N\A]'}}</td>
                          <td>{{number_format($data->gthb,0,',','.')}}</td>
                          <td>{{$data->soluong}}</td>
                          <td>  
                            
                            {{ count($sl_hbdatrao->where("id_hocbong", $data->idhb)) }}

                          </td>
                          <td> {{ number_format(($sl_hbdatrao->where("id_hocbong", $data->idhb))->sum("giatri"), 0 , ',', '.') }}đ</td>
                          <td>
                             @foreach($trangthai as $status)
                            @if($status->id == $data->idhockynamhoc)
                              
                              <?php
                                    if($status->idtrangthaihocky==1){
                                      ?>
                                       <span class="label label-danger"  style="font-size: 12px"> Đã hoàn thành </span>
                                      
                                      <?php
                                  
                                    }
                                    else{
                                      ?>
                                      <span class="label label-success"  style="font-size: 12px"  > Hiện hành </span>
                                      <?php 
                                    }
                                    ?>
                            @endif

                            @endforeach
                          </td>
                
                <td>
                  <a href="{{route('thongke.theo.hocbong.namcu',$data->idhb)}}"><i style="font-size: 25px; color: green" class="fa fa-search"></i></a>

                  
                  <a href="{{route('hocbong.edit',$data->idhb)}}"><i style="font-size: 25px; color: orange" class="fa fa-pencil-square-o"></i></a>
                  <a href="{{route('hocbong.delete',$data->idhb)}}"><i style="font-size: 25px; color: red" class="fa fa-trash"></i></a>
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
<!--   -------------------------------------------------------------->  
<div id="div-studentListResult" class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-list"></i>THỐNG KÊ HỌC BỔNG {{isset($getHKNH) ? $getHKNH->tenhockynamhoc : 'NĂM HỌC '.$getNamHoc->tennamhoc}} </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="row">
                      
                          <table id="tbl_khoa" class="table table-striped table-bordered" width="100%">
                                  <thead>
                                  <tr class="filters">
                                   <th width="10%">STT</th>
                                    <th width="23%">Khoa</th>
                                    <th width="10%">Số lượng HB</th>
                                   
                                    
                                    <th width="10%">Số lượng SV nhận HB</th>
                                    <th width="20%">Tổng số tiền đã trao</th>
                                    <th width="15%"></th>
                                  </tr>
                              </thead> 
                              <tbody>
                                 @if(isset($ds_khoa))
                                  <?php $STT = 0; ?>
                                  @foreach($ds_khoa as $data)
                                  <tr>
                                    <th >{{++$STT}}</th>
                                    <td >{{$data->tenkhoa}}</td>
                                    <td>
                                        
                                        {{ count($sl_hb->where("idkhoa", $data->id)) }}
                                      
                                    </td>
                                 
                                   <td>
                                    {{ count($sl_sv->where("idkhoa", $data->id)) }}
                                      
                                     
                                   </td>
                                   <td>

                                    {{number_format(($sl_sv->where("idkhoa", $data->id))->sum("giatri"),0,',','.')}} VNĐ
                                   </td>
                                   <td class="text-center">
                                  <?php
                                      if(isset($getHKNH)){
                                        ?>
                                        <a href="{{route('thongke.hocky',[$data->id, $getHKNH->id])}}" class="btn btn-success"  title="Xem chi tiết học kỳ"><i class="fa fa-search"></i></a>
                                        <?php
                                    
                                      }
                                      else{
                                        ?>
                                        <a href="{{route('thongke.nammoi',[$data->id,$getNamHoc->id])}}" class="btn btn-success"  title="Xem chi tiết năm học"><i class="fa fa-search"></i></a>
                                        <?php 
                                      }
                                 ?>
                                 
                               </td>
                              </tr>
                  @endforeach
                @endif
                              </tbody>
                          </table>
                      
                  </div>
        
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
    
    <script type="text/javascript" src="{!! URL::asset('js/ajax.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/admin_student_filter.js') !!}"></script>

    
    <script>
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
      $('.fa-trash').click(function(e){
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
    
    <script>
      var url_route_get_hknhbyhk = "{{route('admin_get_hknhbyhk')}}";
      $('#namhoc').change(function(e){
      var idnamhoc = $('#namhoc').val();
      var url = url_route_get_hknhbyhk + "/" + idnamhoc;
      var data = callAjax(url, "GET");
      $('#hknh').html("");
      var opt = '<option value="">--- Tất cả ---</option>';
      $.each(data, function(key, value){
        opt += '<option value="' + value.id + '">' + value.tenhockynamhoc + '</option>';
      })
      $('#hknh').html(opt);
    });
    </script>
    
@endsection