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
        <h2> <i class="fa fa-graduation-cap"></i> TRAO HỌC BỔNG CHO SINH VIÊN:  {{$infoSinhvien->hochulot.' '.$infoSinhvien->ten}}</h2>
        <div class="clearfix"></div>
      </div>
      <?php
  $message = Session::get('message');
  if($message){
    echo '<span class="text-alert" style="color:red">'.$message.'</span>';
    Session::put('message',null);
  }
  ?>

      <div class="x_content">
        <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{csrf_field()}}
            
          <div class="row">
            <div class="col-12 col-md-12">
              <!-- Block error message -->
              @include('layout.block.message_flash')
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 form-group {{ $errors->has('id_hocbong') ? ' has-error' : '' }}">
               <label class="control-label">Tên học bổng</label>
              <select name="id_hocbong" id="id_hocbong" class="form-control">
                <option value="">--- Học bổng ---</option>
                
                  @foreach($ds_hocbong as $data)
                    <option value="{{$data->idhb}}" {{$data->id == old('id_hocbong') ? 'selected="true"' : ''}}>{{$data->tenhb}}</option>
                  @endforeach
               
              </select>
                
                
            </div>
            <div class="row">
            
            <input  type="hidden" id="id_sinhvien" name="id_sinhvien" class="form-control" value="{{$infoSinhvien->id}}" placeholder="">

            

            
            
              
            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
              <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 form-group{{ $errors->has('giatri') ? ' has-error' : '' }}">
                  <label class="control-label">Giá trị</label>
                    <input type="number" id="giatri" name="giatri" class="form-control" value="{{old('giatri')}}" placeholder="Giá trị">



                </div>

               
                
              </div>
            </div>
          </div>

         
  

          
          


          <hr>
          <div class="row text-center">
            <button type="submit" class="btn btn-primary" title="Lưu thông tin"> <strong><i class="fa fa-save"></i> LƯU </strong> </button>
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
    <script src="{{URL::asset('js/admin_canbogiangvien.khoa.bomon.js')}}"></script>

    <script>
      var url_route_admin_get_bomonbykhoa = "{{route('admin_get_bomonbykhoa')}}";
    </script>

@endsection