@extends('admin.layout.master')
@section('css')
    @parent
    <!-- iCheck -->
    <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-history"></i> LỊCH SỬ</h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
       
            <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal form-label-left">
                {{csrf_field()}}
                <p><b>Tổng số học bổng đã nhận: </b>{{$count}}</p>
                <p><b>Tổng số tiền đã nhận: </b> {{number_format($countMoney,0,',','.')}}đ</p>

                <ul class="list-group">
                    @foreach($history as $data)
                  <li class="list-group-item active">{{$data->tenhockynamhoc}} <a href="{{route('admin.edit.history',$data->idhb)}}"><i style=" color: white" class="fa fa-cog pull-right" aria-hidden="true"></i></a></li>
                 
                  <li class="list-group-item"><b>Tên học bổng:  </b>{{$data->tenhb}}</li>
                  <li class="list-group-item"><b>Giá trị:   </b>{{number_format($data->giatri,0,',','.')}}đ</li>

                <br>

                  @endforeach
                  
                </ul>

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