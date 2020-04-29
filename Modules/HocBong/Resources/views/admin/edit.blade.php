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
        <h2> <i class="fa fa-graduation-cap"></i> THÔNG TIN HỌC BỔNG TEST <small>SCHOLARSHIP INFORMATION</small></h2>
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
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12{{ $errors->has('mahb') ? ' has-error' : '' }}">
                <label class="control-label">Mã học bổng</label>
                <input type="text" id="mahb" name="mahb" class="form-control" value="{{old('mahb',$scholar->mahb)}}" placeholder="Mã học bổng">
                @if ($errors->has('mahb'))
                <span class="help-block">
                  <strong>{{ $errors->first('mahb') }}</strong>
                </span>
              @endif
                
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
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

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12{{ $errors->has('tendvtt') ? ' has-error' : '' }}">
                  <label class="control-label">Tên đơn vị tài trợ</label>
                    <input type="text" id="tendvtt" name="tendvtt" class="form-control" value="{{old('tendvtt',$scholar->tendvtt)}}" placeholder="Tên đơn vị tài trợ">

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
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12{{ $errors->has('lop') ? ' has-error' : '' }}">
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
            
            
            

            
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 form-group{{ $errors->has('gthb') ? ' has-error' : '' }}">
                  <label class="control-label">Giá trị học bổng</label>
                    <input type="number" id="gthb" name="gthb" class="form-control" value="{{old('gthb',$scholar->gthb)}}" placeholder="Giá trị học bổng">

                   


                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12{{ $errors->has('soluong') ? ' has-error' : '' }}">
                  <label class="control-label">Số lượng</label>
                    <input type="number" id="soluong" name="soluong" class="form-control" value="{{old('soluong',$scholar->soluong)}}" placeholder="Số lượng">

                    

                </div>
                
              </div>

            </div>

          </div>
          <div class="row">
             
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  <h4 class="text-center">Khoa</h4>
                  <div class="well" style="height: 150px; overflow: auto;">
                    
                      <ul class="list-group checked-list-box">
                         <li class="list-group-item"> <input type="checkbox" id="select_all" class="flat"> <label for="">Toàn trường  </label> </li>
                            @if(isset($ds_khoa))
                              @foreach($ds_khoa as $khoa)
                                <?php 
                                  $strchk="";
                                  foreach (old('khoa', $dsKhoaCuaHocBong) as $key => $khoaHocBong) {
                                    if ($khoa->id == $khoaHocBong->id_khoa)
                                      $strchk = 'checked="true"';
                                  }
                                 ?>
                                  <li class="list-group-item" value="{{$khoa->id}}"> <input type="checkbox" id="{{$khoa->id}}" name="khoa[]" value="{{$khoa->id}}" class="flat" {{$strchk}} >
                                  <label for="{{$khoa->id}}"> {{$khoa->tenkhoa}} </label> </li>
                              @endforeach
                          @endif
                      </ul>
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


<!--/////////////////////////////////////////////////////// -->
  
@endsection
@section('javascript')
    @parent
    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
    <script src="{{URL::asset('js/admin_canbogiangvien.khoa.bomon.js')}}"></script>

    <script>
      var url_route_admin_get_bomonbykhoa = "{{route('admin_get_bomonbykhoa')}}";
    </script>
  <script src="{{URL::asset('js/jquery.min.js')}}"></script>
      <script>
          $('#select_all').change(function() {
          var checkboxes = $(this).closest('form').find(':checkbox').not($(this));
          checkboxes.prop('checked', $(this).is(':checked'));
        });
      </script>

@endsection