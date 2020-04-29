  @extends('admin.layout.master')
  @section('title')
    @parent | Trao học bổng
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
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="pull-right">
        </div>
        <div class="clearfix"></div>
      </div>
      
      
      <form>
        <div class="x_content">
        <div class="row">
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                 <h4 class="text-center"><label for=""> Học bổng </label></h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                  <label class="control-label">Học bổng</label>
              <select name="hocbong" id="hocbong" class="form-control">
                <option value="">--- Tất cả ---</option>
                @foreach($ds_hocbong as $hocbong)
                      <option value="{{$hocbong->idhb}}" {{\Request::get('hocbong')==$hocbong->idhb ? "selected='selected'" : ""}}>{{$hocbong->tenhb}}</option>
                    @endforeach
              </select>
              </div>
            </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <h4 class="text-center"><label for=""> ĐIỂM HỌC TẬP </label></h4>
                <div class="well" style="max-height: 150px; overflow: auto;">
                  <div class="row form-group">
                      <div class="col-xs-6 col-sm-7 col-md-7 col-lg-5 col-xl-4">
                          <select name="hoctapdieukien1" id="hoctapdieukien1" class="form-control">
                              <option value="">Điều kiện</option>
                              <option value=">"> > </option>
                              <option value=">="> >= </option>
                          </select>
                      </div>
                      <div class="col-xs-6 col-sm-5 col-md-5 col-lg-7 col-xl-8">
                          <input type="number" name="hoctapdieukien1value" value="{{\Request::get('hoctapdieukien1value')}}" id="hoctapdieukien1value" class="form-control" step="0.01" placeholder="Giá trị" disabled>
                      </div>
                  </div>

                  <div class="row form-group">
                      <div class="col-xs-6 col-sm-7 col-md-7 col-lg-5 col-xl-4">
                          <select name="hoctapdieukien2" id="hoctapdieukien2" class="form-control">
                              <option value="">Điều kiện</option>
                              <option value="<"> < </option>
                              <option value="<="> <= </option>
                          </select>
                      </div>
                      <div class="col-xs-6 col-sm-5 col-md-5 col-lg-7 col-xl-8">
                          <input type="number" name="hoctapdieukien2value" value="{{\Request::get('hoctapdieukien2value')}}" id="hoctapdieukien2value" class="form-control" step="0.01" placeholder="Giá trị" disabled>
                      </div>
                  </div>
                  
                  <br>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <h4 class="text-center"><label for=""> ĐIỂM RÈN LUYỆN </label></h4>
                <div class="well" style="max-height: 150px;overflow: auto;">
                  <div class="row form-group">
                      <div class="col-xs-6 col-sm-7 col-md-7 col-lg-5 col-xl-4">
                          <select name="renluyendieukien1" id="renluyendieukien1" class="form-control">
                              <option value="">Điều kiện</option>
                              <option value=">"> > </option>
                              <option value=">="> >= </option>
                          </select>
                      </div>
                      <div class="col-xs-6 col-sm-5 col-md-5 col-lg-7 col-xl-8">
                          <input type="number" name="renluyendieukien1value" value="{{\Request::get('renluyendieukien1value')}}" id="renluyendieukien1value" class="form-control" step="0.01" placeholder="Giá trị" disabled>
                      </div>
                  </div>

                  <div class="row form-group">
                      <div class="col-xs-6 col-sm-7 col-md-7 col-lg-5 col-xl-4">
                          <select name="renluyendieukien2" id="renluyendieukien2" class="form-control">
                              <option value="">Điều kiện</option>
                              <option value="<"> < </option>
                              <option value="<="> <= </option>
                          </select>
                      </div>
                      <div class="col-xs-6 col-sm-5 col-md-5 col-lg-7 col-xl-8">
                          <input type="number" name="renluyendieukien2value" id="renluyendieukien2value" value="{{\Request::get('renluyendieukien2value')}}" class="form-control" step="0.01" placeholder="Giá trị" disabled>
                      </div>
                  </div>
                  <br>
                </div>
            </div>
          

          
        

      

        </div>

        <div class="row text-center">
          <button class="btn btn-primary student_filter">
            <i class="fa fa-search"></i> <strong> TÌM KIẾM </strong>
          </button>

          
        </div>

      </div>
        
      
    </form>
  </div>
</div>


<div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-user-secret"></i> </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="pull-right">
        </div>
        <div class="clearfix"></div>
      </div>
      
      
      <form action="{{route('asdasddasa')}}" method="POST">
                {{csrf_field()}}
        <div class="x_content">
        <div class="row">
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
                        
                        <th>Thao tác</th>
                        <th></th>
                    </tr>
                </thead>
               
                
                <tbody id="tbodystudent">
                      @if(isset($students) && $students !== [])
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
                                  {{isset ($data->drl) ? $data->drl :  '[Chưa biết]'}}
                                </td>
                               
                                <td class="text-center">
                                  <?php
                                    if(count($scholar_history->where("id_sinhvien", $data->idsv)) > 0){
                                  ?>
                                
                                  @foreach($scholar_history as $his)
                                      @if($his->id_sinhvien == $data->idsv)
                                      <span class="label label-success" style="font-size: 12px"> {{$his->HocBong->tenhb}} </span><br><br>
                                      
                                      @else
                                      @endif
                                       @endforeach
                                
                                  <?php
                            
                                  }
                                    else{
                                  ?>
                                    <span class="label label-primary"  style="font-size: 12px"> Chưa có </span>
                                <?php 
                                  }
                                  ?>


                                  
                                
                                </td>
                               

                               
                                <td class="text-center">
                                  <a href="{{route('hocbong.lichsu.sinhvien',$data->idsv)}}" class="btn btn-success"  title="Lịch sử học bổng module"><i class="fa fa-university"></i></a>
                             

                              </td>
                              <td>
                               <!--  <input type="hidden" value="{{$data->idsv}}" id="inputidsv" name="inputidsv[]"> -->
                                <input type="hidden" value="{{$getTenHB->id}}" id="inputidhb" name="inputidhb">
                                <input type="number" class="textgiatri" value="{{$getTenHB->gtmoihocbong}}" id="giatri" name="giatri[]" disabled="true" required="true">

                                <input type='checkbox'  class="Blocked" name='inputidsv[]' id='check_all' value='{{$data->idsv}}'/>

                              
                              </td>
                            
                            </tr>
                           
                        @endforeach
                        @else
                        <tr>
                          KHÔNG CÓ DỮ LIỆU
                      </tr>
                      @endif
                </tbody>
                
                
            
                
              
              </table>

        </div>

          @if($getTenHB!==null)

               <div class="row text-center">
                <!-- <input type="button" class="btn btn-primary" id="btn1" value="Chọn hết"/>
              <input type="button" class="btn btn-primary" id="btn2" value="Bỏ chọn"/> -->
              <button type="submit" class="btn btn-primary">Trao học bổng</button>
              
              <label>
                <input type="checkbox" id="checkAll" class="form-radio" >
                <label for="checkAll">Chọn hết</label>
              </label>
  
            </div>
            @endif

      </div>
        
      
    </form>
  </div>
</div>

 @if (session('message'))
    <div id="div-studentListResult" class="row">
      <div class="x_panel">
        <div class="x_title">
          <h2> <i class="fa fa-info-circle"></i> THÔNG BÁO <small> INFORMATION MESSAGES</small></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>

        <div class="x_content">
         <textarea class="resizable_textarea form-control" rows="10" v-html="content" readonly="true" style="resize: none; font-family: Courier New;">{!! session('message') !!}</textarea>
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
      <script type="text/javascript" src="{!! URL::asset('js/admin_student_filter.js') !!}"></script>

      <script type="text/javascript" src="{!! URL::asset('js/search_filter_diemrenluyen.js') !!}"></script>
      <script src="{{URL::asset('js/mystyle_fileinput.js')}}"></script>
    <script type="text/javascript">
      $('.btnimport').click(function(){
        loadereffectshow();
      });
    </script>

    <script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }


  </script>

  <script language="javascript">
 
             
 
        </script>
       <script type="text/javascript">
        $("#checkAll").click(function () {
         $('input:checkbox').not(this).prop('checked', this.checked);
         $(".textgiatri").prop("disabled", !$(this).is(':checked'));
          });

         $('.Blocked').change( function() {
          var isChecked = this.checked;
          
          if(isChecked) {
              $(this).parents("tr:eq(0)").find(".textgiatri").prop("disabled",false); 
          } else {
              $(this).parents("tr:eq(0)").find(".textgiatri").prop("disabled",true);
          }
          
      });
       </script>
  


  @endsection