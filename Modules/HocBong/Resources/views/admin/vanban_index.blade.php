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
          
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ThemMoiVanBan" title="Sửa" onclick=""> <strong><i class="fa fa-upload"></i> THÊM VĂN BẢN </strong></button>
        </div>
        <h2> <i class="fa fa-list"></i>DANH SÁCH VĂN BẢN </h2>
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
                    @if(isset($dsVanBan))
                         <?php $STT = 0; ?>
                        <table id="datatable-buttons" class="table table-striped table-bordered" width="100%">
                                <thead>
                                <tr class="filters">
                                  <th >STT</th>
                                  <th >Tên file</th>
                                  <th ></th>
                                </tr>
                            </thead> 
                            <tbody>
                               @foreach ($dsVanBan as $data)
                               <tr>
                                 <td>{{++$STT}}</td>
                                 <td>{{$data->tenfile}}</td>
                                 
                                
                                
                                 
                                 <td>
                                    <a href=""  onclick="SuaVanBan('{{$data->id}}', '{{$data->tenfile}}','{{$data->url}}')" data-toggle="modal" data-target="#SuaVanBan" class="btn btn-warning" title="Sửa văn bản"> <i class="fa fa-edit"></i> </a>
                                    <a href="{{route('vanban.delete',$data->id)}}" class="btn btn-danger btn-remove" title="Xóa khóa học"> <i class="fa fa-trash"></i> </a>
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
  <form action="{{ route('vanban.store') }}" method="post">
    {{ csrf_field() }}
  <div id="ThemMoiVanBan" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <!-- <form action="" method="post" class="form-signin" accept-charset="utf-8"> -->
                    <div class="modal-header">
                        <div class="col-11 pull-left">
                            <h3>Thêm văn bản</h3>
                        </div>
                        <div class="col-1 pull-right">
                            <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                      @include('layout.block.message_validation')
                        <div class="form-group">
                            <label for="MaLop"> Tên văn bản</label>
                            <input type="text" name="TenVanBan" id="TenVanBan" class="form-control TenVanBan " placeholder="Tên văn bản" required />
                            
                            <input type="hidden" name="MaThongBao" id="MaThongBao" class="form-control MaLop" placeholder="Mã lớp" value="{{$idThongBao}}">
                        </div>
                        
                        <div class="form-group">
                          <div class="btn-group">
                            <label for="TenLop"> File </label>
                            <div class="input-group image-preview">

                                    
                              <input type="text" class="form-control" id="DinhKem" name="DinhKem" value="" readonly="readonly" placeholder="" required/>
                              @if($errors->has('DinhKem'))
                              <div class="invalid-feedback"><strong>{{ $errors->first('DinhKem') }}</strong></div>
                            @endif
                              <span class="input-group-btn" >
                              
                                        
                                <div class="btn btn-default image-preview-input">
                                  <span class="image-preview-input-title"><a href="#dinhkem" onclick="BrowseServer();">Chọn tập tin</a></span>
                                 </div>
                                        

                                    </span>
                                </div>
                          </div>
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
  <form action="{{route('vanban.update')}}" method="post">
    {{ csrf_field() }}
  <div id="SuaVanBan" class="modal fade" role="dialog">
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
                            <label for="MaLop"> Tên văn bản</label>
                            <input type="text" name="TenVanBan_edit" id="TenVanBan_edit" class="form-control MaLop" placeholder="Tên văn bản" autofocus>
                            <input type="hidden" name="IDVanBan_edit" id="IDVanBan_edit" class="form-control MaLop" value="">
                        </div>
                        
                        <div class="form-group">
                          <div class="btn-group">
                            <label for="TenLop"> File </label>
                            <div class="input-group image-preview">

                                    
                              <input type="text" class="form-control" id="DinhKem_edit" name="DinhKem_edit" value="" readonly="readonly" placeholder="" />
                              <span class="input-group-btn" >
                              
                                        
                                <div class="btn btn-default image-preview-input">
                                  <span class="image-preview-input-title"><a href="#dinhkem" onclick="BrowseServerEdit();">Chọn tập tin</a></span>
                                 </div>
                                        

                                    </span>
                                </div>
                          </div>
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
    <script src="{{URL::asset('js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{URL::asset('js/ckfinder/ckfinder.js')}}"></script>
    
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

    function SuaVanBan($ID, $TenFile, $URL) {
    $("#IDVanBan_edit").val($ID);
    $("#TenVanBan_edit").val($TenFile);
    $('#DinhKem_edit').val($URL);
   
}


    function BrowseServer()
    {
      var finder = new CKFinder();
      finder.basePath = '../';
      finder.startupPath = "Files:/";
      finder.selectActionFunction = function(fileUrl) {
        document.getElementById('DinhKem').value = fileUrl.substring(fileUrl.lastIndexOf('/') + 1);
      };
      finder.popup();
    }
    function BrowseServerEdit()
    {
      var finder = new CKFinder();
      finder.basePath = '../';
      finder.startupPath = "Files:/";
      finder.selectActionFunction = function(fileUrl) {
        document.getElementById('DinhKem_edit').value = fileUrl.substring(fileUrl.lastIndexOf('/') + 1);
      };
      finder.popup();
    }
      $('.btn-remove').click(function(e){
        if(confirm("Bạn chắc chắn muốn xóa ?") == false)
        {
          e.preventDefault();
          e.stopImmediatePropagation();
        }
      });
    </script>
    
@endsection