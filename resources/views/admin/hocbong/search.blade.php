  @extends('admin.layout.master')
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
      <div class="row">
        <div class="x_panel">
          <div class="x_title">
            <h2> <i class="fa fa-user-secret"></i> Trao học bổng cho sinh viên {{$hocKyNamHoc_HienChon?$hocKyNamHoc_HienChon->tenhockynamhoc:''}}</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="pull-right">
              <a href="" class="btn btn-primary"> <i class="fa fa-plus"></i> <strong> THÊM MỚI </strong> </a>
              <a href="" class="btn btn-warning"> <i class="fa fa-upload"></i> <strong> IMPORT </strong> </a>
            </div>
            <div class="clearfix"></div>
          </div>
        <form>
        <div class="x_content">
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
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
           <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <h4 class="text-center">BỘ MÔN</h4>
                <div class="well" style="max-height: 150px; overflow: auto;">
                    <label class="control-label">BỘ MÔN</label>
                <select name="bomon" id="bomon" class="form-control ">
                  <option >--- Bộ môn ---</option>
                </select>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <h4 class="text-center">NGÀNH</h4>
                <div class="well" style="max-height: 150px; overflow: auto;">
                    <label class="control-label">Ngành</label>
                <select name="nganh" id="nganh" class="form-control">
                  <option>--- Ngành ---</option>
                </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <h4 class="text-center">Lớp</h4>
                <div class="well" style="max-height: 150px; overflow: auto;">
                    <label class="control-label">Lớp</label>
                <select name="lop" id="lop" class="form-control">
                  <option>--- Lớp ----</option>
                </select>
                </div>
            </div>
            
           
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <div class="container">
                <div class="tab-holder"
                <h4 class="text-center"><label for=""> ĐIỂM HỌC TẬP </label></h4>
                  <ul class="nav nav-tabs" >
                              <li class="active"><a href="#featured" data-toggle="tab"><=</a></li>
                              <li><a href="#new-arrivals" data-toggle="tab">>=<</a></li>
                              <li><a href="#top-sales" data-toggle="tab">>=</a></li>
                  </ul>
                </div>
                <div class="tab-content">
                  <div class="tab-pane active" id="featured">
                    <div class="product-grid-holder">
                                     
                      <div >
                        <div style="display: flex;">
                            <input step="any" type="number" id="diemnhohon" name="diemnhohon" placeholder="" value="{{\Request::get('diemnhohon')}}" class="form-control" >
                         </div>
                      </div>
                                      
                    </div>
                                  

                  </div>
                   <div class="tab-pane" id="new-arrivals">
                      <div class="product-grid-holder">
                        <div>
                          <div class="product-item">
                          <div style="display: flex;" class="row form-group">
                              <input step="any" type="number" id="diemtrong1" name="diemtrong1" placeholder="" value="{{\Request::get('diemtrong1')}}" class="form-control" >
                              <input sstep="any" type="number" id="diemtrong2" name="diemtrong2" placeholder="" value="{{\Request::get('diemtrong2')}}" class="form-control" >
                          </div>
                         </div>
                      </div>
                            </div>
                   </div>
                   <div class="tab-pane" id="top-sales">
                    <div style="display: flex;" class="row form-group">
                      <input step="any" type="number" id="diemtren" name="diemtren" placeholder="" value="{{\Request::get('diemtren')}}" class="form-control" >

                  </div>
                   </div>

                </div>

              </div>
            </div>
          <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <div class="container">
                <div class="tab-holder"
                <h4 class="text-center"><label for=""> ĐIỂM RÈN LUYỆN </label></h4>
                  <ul class="nav nav-tabs" >
                              <li class="active"><a href="#featured" data-toggle="tab"><=</a></li>
                              <li><a href="#diemrltrong" data-toggle="tab">>=<</a></li>
                              <li><a href="#diemrltren" data-toggle="tab">>=</a></li>
                  </ul>
                </div>
                <div class="tab-content">
                  <div class="tab-pane active" id="featured">
                    <div class="product-grid-holder">
                                     
                      <div >
                        <div style="display: flex;">
                            <input style="" type="number" id="diemrlnhohon" name="diemrlnhohon" placeholder="" value="{{\Request::get('diemrlnhohon')}}" class="form-control" >
                         </div>
                      </div>
                                      
                    </div>
                                  

                  </div>
                   <div class="tab-pane" id="diemrltrong">
                      <div class="product-grid-holder">
                        <div>
                          <div class="product-item">
                          <div style="display: flex;" class="row form-group">
                              <input style="" type="number" id="diemrltrong1" name="diemrltrong1" placeholder="" value="{{\Request::get('diemrltrong1')}}" class="form-control" >
                              <input style="" type="number" id="diemrltrong2" name="diemrltrong2" placeholder="" value="{{\Request::get('diemrltrong2')}}" class="form-control" >
                          </div>
                         </div>
                      </div>
                            </div>
                   </div>
                   <div class="tab-pane" id="diemrltren">
                    <div style="display: flex;" class="row form-group">
                      <input style="" type="number" id="diemrltren" name="diemrltren" placeholder="" value="{{\Request::get('diemrltren')}}" class="form-control" >

                  </div>
                   </div>

                </div>
                
              </div>
            </div>
          

          <div class="row text-center">
            <button class="btn btn-primary student_filter">
              <i class="fa fa-search"></i> <strong> TÌM KIẾM/LỌC </strong>
            </button>

            
          </div>

        </div>
      </div>
      </form>

            
          </div>
              @include('layouts.gentelella-master.blocks.flash-messages')
              <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
                <thead>
                    <tr class="filters">
                        <th class="text-center">#</th>
                        <th class="text-center">MSSV</th>
                        <th>Họ tên</th>
                        <th>Nam/Nữ</th>
                        <th>Lớp</th>
                        <th>Học kỳ, năm học</th>

                        <th>Điểm học tập</th>
                        <th>Điểm rèn luyện</th>
                        <th>Tình trạng học bổng </th>
                        <th>Lịch sử</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="tbodystudent">
                      @if(isset($students))
                        <?php $STT = 0; ?>
                        @foreach($students as $data)
                            <tr>
                                <th class="text-center-middle text-center">{{++$STT}}</th>
                                <td class="text-center-middle text-center">{{$data->mssv}}</td>
                                <td class="text-justify-middle">
                                   {{$data->hochulot}} {{$data->ten}}
                                </td>
                                <td class="text-justify-middle">
                                    {{$data->getGioitinh($data->gioitinh)['name']}}
                                </td>
                                <td class="text-justify-middle">
                                   {{isset ($data->lop->tenlop) ? $data->lop->tenlop :  '[Chưa biết]'}}
                                </td>
                                <td class="text-justify-middle">
                                    {{isset ($data->HocKyNamHoc->tenhockynamhoc) ? $data->HocKyNamHoc->tenhockynamhoc :  '[Chưa biết]'}}
                                </td>
                                <td class="text-justify-middle">
                                    {{isset ($data->diem) ? $data->diem :  '[Chưa biết]'}}
                                </td>
                                <td>
                                  {{$data->sinhvien_diem}}
                                </td>
                               
                                <td>
                                   @foreach($scholar_history as $his)
                                  @if($his->id_sinhvien == $data->idsv)
                                  {{isset ($his->HocBong->tenhb) ? $his->HocBong->tenhb :  '[Chưa có]'}}<br>
                                  @endif
                                   @endforeach
                                
                                </td>
                               


                                <td class="text-center">
                                  
                                   <a href="{{route('admin.edit.award',$data->sinhvien_id)}}" class="btn btn-success"  title="Lịch sử học bổng"><i class="fa fa-university"></i></a>
                                      
                                 
                                </td>
                                <td class="text-center">
                            <a href="{{route('admin.award.scholar',$data->mssv)}}" class="btn btn-warning"  title="Trao học bổng"><i class="fa fa-edit"></i></a>
                          </td>
                            
                            </tr>
                        @endforeach
                      @endif
                </tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div id="XemLichSu" class="modal fade" role="dialog">
          <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                  <div class="modal-header">
                      <div class="col-11 pull-left">
                          <h3>Lịch sử học bổng</h3>
                      </div>
                      <div class="col-1 pull-right">
                          <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                      </div>
                  </div>
                  <div class="modal-body">
                     
                    
                  </ul>
                  </div>
                  <div class="modal-footer">
                      
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
      <script type="text/javascript">
      jQuery(document).ready(function ()
      {
              jQuery('select[name="khoa"]').on('change',function(){
                 var khoaID = jQuery(this).val();
                 if(khoaID)
                 {
                    jQuery.ajax({
                       url : 'tim-kiem/getbomon/' +khoaID,
                       type : "GET",
                       dataType : "json",
                       success:function(data)
                       {
                          console.log(data);
                          jQuery('select[name="bomon"]').empty();
                          jQuery.each(data, function(key,value){
                             $('select[name="bomon"]').append('<option value="'+ key +'">'+ value +'</option>');
                          });
                       }
                    });
                 }
                 else
                 {
                    $('select[name="bomon"]').empty();
                 }
              });
      });
      jQuery(document).ready(function ()
      {
              jQuery('select[name="bomon"]').on('change',function(){
                 var bomonID = jQuery(this).val();
                 if(bomonID)
                 {
                    jQuery.ajax({
                       url : 'tim-kiem/getnganh/' +bomonID,
                       type : "GET",
                       dataType : "json",
                       success:function(data)
                       {
                          console.log(data);
                          jQuery('select[name="nganh"]').empty();
                          jQuery.each(data, function(key,value){
                             $('select[name="nganh"]').append('<option value="'+ key +'">'+ value +'</option>');
                          });
                       }
                    });
                 }
                 else
                 {
                    $('select[name="nganh"]').empty();
                 }
              });
      });
      jQuery(document).ready(function ()
      {
              jQuery('select[name="nganh"]').on('change',function(){
                 var nganhID = jQuery(this).val();
                 if(nganhID)
                 {
                    jQuery.ajax({
                       url : 'tim-kiem/getlop/' +nganhID,
                       type : "GET",
                       dataType : "json",
                       success:function(data)
                       {
                          console.log(data);
                          jQuery('select[name="lop"]').empty();
                          jQuery.each(data, function(key,value){
                             $('select[name="lop"]').append('<option value="'+ key +'">'+ value +'</option>');
                          });
                       }
                    });
                 }
                 else
                 {
                    $('select[name="lop"]').empty();
                 }
              });
      });
      </script>
  @endsection