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
        <h2> <i class="fa fa-history"></i> LỊCH SỬ NHẬN HỌC BỔNG</h2>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">

       
            <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal form-label-left">
                {{csrf_field()}}
                <p><b>Tên sinh viên: </b>{{$idsinhvien->hochulot}} {{$idsinhvien->ten}}</p>
                <p><b>MSSV: </b>{{$idsinhvien->mssv}}</p>
                <p><b>Lớp: </b>{{$idsinhvien->lop->tenlop}}</p>
                <p><b>Tổng số học bổng đã nhận: </b>{{ count($count->where("id_sinhvien", $idsinhvien->id)) }}</p>
                <p><b>Tổng số tiền đã nhận: </b> {{ number_format(($count->where("id_sinhvien", $idsinhvien->id))->sum("giatri"), 0 , ',', '.') }}đ</p>

                <ul class="list-group">
                    @foreach($history as $data)
                  <li class="list-group-item active">{{$data->tenhockynamhoc}} 
                    
    
                    

                  </li>
                  @foreach($getHB as $hocbong)
                  @if($hocbong->id_sinhvien === $data->id_sinhvien && $hocbong->idhockynamhoc === $data->idhockynamhoc)
                  <li class="list-group-item">
                    <b>Tên học bổng:  </b>{{$hocbong->HocBong->tenhb}} 
                    <a href="{{route('admin.delete.history',$hocbong->idlshb)}}"><i style=" color: #337a;" class="fa fa-close pull-right" aria-hidden="true"></i></a>

                    <a href="{{route('admin.edit.history',$hocbong->idlshb)}}"><i style=" color: #337a; margin-right:5px" class="fa fa-cog pull-right" aria-hidden="true"></i></a>
                  </li>
                  <li class="list-group-item"><b>Giá trị:   </b>{{number_format($hocbong->giatri,0,',','.')}}đ</li>
                  @endif
                  @endforeach

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
    <script>
      $('.fa-close').click(function(e){
        if(confirm("Bạn chắc chắn muốn xóa ?") == false)
        {
          e.preventDefault();
          e.stopImmediatePropagation();
        }
      });
    </script>
@endsection