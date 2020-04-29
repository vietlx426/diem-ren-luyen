@extends('giaovukhoa.layout.master')
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
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <form class="form-horizontal form-label-center" enctype="multipart/form-data">
        <div class="row" >
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
                    @isset($DinhKem)
                   @foreach($DinhKem as $data)
                   <?php $STT=0;?>
                      <tr>
                        <th scope="row">{{++$STT}}</th>
                        <td>{{$data->tenfile}}</td>
                        
                        <td class="text-center"><a href="{{route('giaovukhoa.download',$data->id)}}"><i class="fa fa-download" aria-hidden="true"></i></a></td>
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
@endsection
@section('javascript')
    @parent
    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
@endsection