@extends('sinhvien.layout.master')
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
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-history"></i>XEM THÔNG BÁO</h2>
        @if($checkDate === true)
        <div class="pull-right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#NopHoSo" title="Sửa" onclick=""> <strong><i class="fa fa-upload">
        </i> NỘP HỒ SƠ </strong>
        
      </button>
      @if(session()->has('message'))
    <div class="alert alert-danger">
        {{ session()->get('message') }}
    </div>
@endif
        </div>
      @endif
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <form class="form-horizontal form-label-center" enctype="multipart/form-data">
        <div class="row" >
        @include('layouts.gentelella-master.blocks.flash-messages')
          <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 ">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tieude"><span class="required"></span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <p><strong style="font-size: 30px; color: black">{{$ThongBao->tieude}}</strong></p>
                            <hr>
                        </div>
                       <div>
                        <p>
                          <span>Đăng bởi: {{$author->name}}</span> 
                          <span>Vào lúc: {{date('d-m-Y', strtotime($ThongBao->created_at))}}</span>
                         </p>
                       </div>
                        <div style="font-size: 15px; color: black">
                          {!! $ThongBao->noidung !!}
                        </div>
                    </div>
                    <hr>
                    <p><strong>Tập tin đính kèm:</strong></p>

              <div class="table-responsive" style="width: 500px">
                <table class="table table-bordered table-hover table-sm fit-post-file" >
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th width="20%">Tên tài liệu</th>
                      
                      <th width="10%">Tải về</th>
                    </tr>
                  </thead>
                  <tbody>
                    @isset($FileDinhKem)
                   @foreach($FileDinhKem as $data)
                      <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$data->tenfile}}</td>
                        
                        <td class="text-center"><a href="{{route('sinhvien.download',$data->id)}}"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                      </tr>
                    @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
        </div>
      </form>

       
           
        
      </div>
    </div>
  </div>
  <form action="{{route('hoso.store')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
  
  <div id="NopHoSo" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <!-- <form action="" method="post" class="form-signin" accept-charset="utf-8"> -->
                    <div class="modal-header">
                        <div class="col-11 pull-left">
                            <h3>Nộp hồ sơ</h3>
                        </div>
                        <div class="col-1 pull-right">
                            <button type="button" class="close" data-dismiss="modal" title="Đóng Form">&times;</button>
                        </div>
                    </div>
                    
                    <div class="modal-body">
                   
                        
                      <div class="one-more  add-more-after">
                        <div class="form-group">
                          <div class="btn-group">
                            <label for="TenLop"> File </label>
                            <input type="hidden" name="MaHocBong" id="MaHocBong" class="form-control MaHocBong" value="{{$ThongBao->id_hocbong}}">
                            <div class="input-group image-preview">

                                    
                            <input type="file" class="form-control" id="DinhKem1" name="DinhKem[]" value="" readonly="readonly" placeholder="" required/>
                             
                              <span class="input-group-btn" >
                              
                                        
                             
                                 <div class="btn btn-default image-preview-input btn-add-more">
                                          <i class="fa fa-plus" ></i>
                                  </div>                                    
                                    </span>
                                </div>
                          </div>
                        </div>
                      </div>
                      <div style="display: none">
                      <div class="copy">
                        <div class="form-group">
                          <div class="btn-group">
                            <label for="TenLop"> File </label>
                            <div class="input-group image-preview">

                                    
                              <input type="file" class="form-control" id="DinhKem1" name="DinhKem[]" value="" readonly="readonly" placeholder="" required/>
                              @if($errors->has('DinhKem'))
                              <div class="invalid-feedback"><strong>{{ $errors->first('DinhKem') }}</strong></div>
                            @endif
                              <span class="input-group-btn" >
                              
                                        
                                
                                 <div class="btn btn-default image-preview-input btn-remover">
                                          <i class="fa fa-minus" ></i>
                                          
                                        </div>                                   
                                    </span>
                                </div>
                          </div>
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
    <!-- iCheck -->
    <script src="{{URL::asset('js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{URL::asset('js/ckfinder/ckfinder.js')}}"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      
      
      var index = 2;
      $(".btn-add-more").click(function() {
        $(".copy input[name^='DinhKem']").attr("id", "DinhKem" + index);
        index++;
        
        var html = $(".copy").html();
        $(".add-more-after").after(html);
      });
      $("body").on("click", ".btn-remover", function() {
        $(this).parents(".form-group").remove();
      });
    });
    
    
  </script>
@endsection