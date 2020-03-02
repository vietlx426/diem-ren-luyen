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
        <h2> <i class="fa fa-graduation-cap"></i> THÔNG TIN HỌC BỔNG <small>SCHOLARSHIP INFORMATION</small></h2>
        <div class="clearfix"></div>
      </div>

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
            <div class="col-xs-12 col-sm-6 col-md-6 form-group{{ $errors->has('mahb') ? ' has-error' : '' }}">
                <label class="control-label">Mã học bổng</label>
                <input type="text" id="mahb" name="mahb" class="form-control" value="{{old('mahb',$scholar->mahb)}}" placeholder="Mã học bổng">
                @if ($errors->has('mahb'))
                <span class="help-block">
                  <strong>{{ $errors->first('mahb') }}</strong>
                </span>
              @endif
                
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
              <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 form-group{{ $errors->has('tenhb') ? ' has-error' : '' }}">
                  <label class="control-label">Tên học bổng</label>
                    <input type="text" id="tenhb" name="tenhb" class="form-control" value="{{old('tenhb',$scholar->tenhb)}}" placeholder="Tên học bổng">

                   @if ($errors->has('tenhb'))
                <span class="help-block">
                  <strong>{{ $errors->first('tenhb') }}</strong>
                </span>
              @endif


                </div>

                <div class="col-xs-4 col-sm-4 col-md-4 form-group{{ $errors->has('tendvtt') ? ' has-error' : '' }}">
                  <label class="control-label">Tên đơn vị tài trợ</label>
                    <input type="text" id="tendvtt" name="tendvtt" class="form-control" value="{{old('tenhb',$scholar->tenhb)}}" placeholder="Tên đơn vị tài trợ">

                    @if ($errors->has('tendvtt'))
                <span class="help-block">
                  <strong>{{ $errors->first('tendvtt') }}</strong>
                </span>
              @endif

                </div>
                
              </div>
            </div>
          </div>

         <div class="row">
         	<div class="col-xs-12 col-sm-3 col-md-3 form-group{{ $errors->has('lop') ? ' has-error' : '' }}">
              <label class="control-label">Học kỳ, năm học</label>
              <select name="idhockynamhoc" id="idhockynamhoc" class="form-control">
                <option value="">--- Học kỳ, năm học ---</option>
                
                  @if(isset($hockynamhoc))
                        @foreach($hockynamhoc as $data)
                        <option value = "{{ $data ->id }}" {{old('idhockynamhoc',isset($scholar->idhockynamhoc)  ? $scholar->idhockynamhoc : '')==$data->id ? "selected='select'" : "" }}>{{$data->tenhockynamhoc}} </option>
                        @endforeach
                  @endif
               
              </select>
             </div>
             <div class="col-xs-12 col-sm-3 col-md-3 form-group{{ $errors->has('lop') ? ' has-error' : '' }}">
              <label class="control-label">Khoa</label>
              <select name="idkhoa" id="idkhoa" class="form-control">
                <option value="">--- Khoa ---</option>
                
                  @if(isset($ds_khoa))
                        @foreach($ds_khoa as $data)
                        <option value = "{{ $data ->id }}" {{old('idkhoa',isset($scholar->idkhoa)  ? $scholar->idkhoa : '')==$data->id ? "selected='select'" : "" }}>{{$data->tenkhoa}} </option>
                        @endforeach
                  @endif
               
              </select>
             </div>
            

            <div class="col-xs-12 col-sm-6 col-md-6 form-group">
              <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 form-group{{ $errors->has('gthb') ? ' has-error' : '' }}">
                  <label class="control-label">Giá trị học bổng</label>
                    <input type="number" id="gthb" name="gthb" class="form-control" value="{{old('gthb',$scholar->gthb)}}" placeholder="Giá trị học bổng">

                   


                </div>

                <div class="col-xs-4 col-sm-4 col-md-4 form-group{{ $errors->has('soluong') ? ' has-error' : '' }}">
                  <label class="control-label">Số lượng</label>
                    <input type="number" id="soluong" name="soluong" class="form-control" value="{{old('soluong',$scholar->soluong)}}" placeholder="Số lượng">

                    

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