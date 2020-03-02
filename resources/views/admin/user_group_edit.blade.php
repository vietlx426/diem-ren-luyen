@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/dataTables.bootstrap.min.css')}}" type="text/css">

  <!-- iCheck for checkboxes and radio inputs -->
  <!-- <link rel="stylesheet" href="{{URL::asset('dashboard/plugins/iCheck/all.css')}}"> -->
  <!-- iCheck -->
    <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
  <!-- Select2 -->
  <!-- <link rel="stylesheet" href="{{URL::asset('dashboard/bower_components/select2/dist/css/select2.min.css')}}"> -->
@endsection

@section('content')
  @if(isset($User))
    <form method="POST" action="{{route('postusergroupupdate')}}" enctype="multipart/form-data">
      {{csrf_field()}}
      <input type="text" name="id" hidden="true" value="{{$User->id}}">

      <div class="row">
        <div class="col-12 col-md-12">
          <!-- Block error message -->
          @include('layout.block.message_flash')
          @include('layout.block.message_validation')
        </div>
      </div>

      <div class="row">
        <div class="x_panel">
          <div class="x_title">
            <h2> <i class="fa fa-check-circle"></i> PHÂN QUYỀN NGƯỜI DÙNG<small>user permission</small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row col-12 ">
              
              <!-- <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 text-center"> -->
              <div class="row">
                @if(intval($User->idloaiuser) == intval('3'))
                  <div class="col-md-6">
                    <label for="Name">Name: <strong>{{$User->name}}</strong></label>
                  </div>
                  <div class="col-md-6">
                    <label for="Email">Email/User name: <strong>{{$User->email}}</strong></label>
                  </div>
                @else
                  <div class="col-md-6">
                    <div class="col-md-2">
                      <label for="Name">Name:</label>
                    </div>
                    <div class="col-md-10">
                      <input type="text" class="form-control" id="Name" name="Name" value="{{$User->name}}" placeholder="Name">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="col-md-4">
                      <label for="Name">Email/User name:</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" class="form-control" id="Email" name="Email" value="{{$User->email}}" placeholder="Email/User name">
                    </div>
                  </div>
                @endif
              </div>
              <div class="form-group">
                <hr>
                <label for="GroupPermission"> <i class="fa fa-group"></i> Phân quyền</label>
                <div class="form-group row">
                  @if(isset($DS_Group))
                    @foreach($DS_Group as $Group)
                      <?php $track = false; ?>
                      @foreach($User->usergroup as $UserGroup)
                        @if($Group->id == $UserGroup->group->id)
                          <?php $track = true; ?>
                          <div class="col-xm-12 col-sm-6 col-md-6 col-xl-3">
                            <input type="checkbox" id="GroupPermission{{$Group->id}}" name="GroupPermission[]" class="minimal-red flat" value="{{$Group->id}}" checked="true">

                            <label for="GroupPermission{{$Group->id}}"> {{$Group->Name}} </label>
                          </div>
                        @endif
                      @endforeach
                      @if(!$track)
                        <div class="col-xm-12 col-sm-6 col-md-6 col-xl-3">
                          <input type="checkbox" id="GroupPermission{{$Group->id}}" name="GroupPermission[]" class="minimal-red flat" value="{{$Group->id}}">
                          
                          <label for="GroupPermission{{$Group->id}}"> {{$Group->Name}} </label>
                        </div>
                      @endif
                    @endforeach
                  @endif
                </div>
              </div>

              <div class="form-group">
                <hr>
                <label for="exampleInputFile"> <i class="fa fa-lock"></i> - <i class="fa fa-unlock"></i> Trạng thái</label>
                <br>
                &emsp;&emsp;
                @if($User->idtrangthaiuser == 1)
                  <input type="radio" id="TrangThaiUser_Active" name="TrangThaiUser" class="minimal-red flat" value="1" checked="true"> 
                  <label for="TrangThaiUser_Active"> Hoạt động <i class="fa fa-unlock"></i> </label>
                  &emsp;&emsp;
                  <input type="radio" id="TrangThaiUser_Lock" name="TrangThaiUser" class="minimal-red flat" value="2">
                  <label for="TrangThaiUser_Lock"> Khóa <i class="fa fa-lock"></i> </label>
                @else
                  <input type="radio" id="TrangThaiUser_Active" name="TrangThaiUser" class="minimal-red flat" value="1">
                  <label for="TrangThaiUser_Active"> Hoạt động <i class="fa fa-unlock"></i> </label>

                  &emsp;&emsp;
                  <input type="radio" id="TrangThaiUser_Lock" name="TrangThaiUser" class="minimal-red flat" value="2" checked="true">
                  <label for="TrangThaiUser_Lock"> Khóa <i class="fa fa-lock"></i> </label>

                @endif
              </div>
              
              <div class="form-group">
                <hr>
                <div class="box-footer text-center">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <strong> LƯU </strong> </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @if(intval($User->idloaiuser) == intval('3'))
        <?php $Student = App\SinhVien::find($User->cbgvsv_id); ?>
        @if($Student)
          <div class="row">
            <div class="x_panel">
              <div class="x_title">
                <h2> <i class="fa fa-info-circle"></i> THÔNG TIN NGƯỜI DÙNG<small>user information</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content" style="display: none;">
                <div class="row">
                  <div class="col-xm-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                      <label>MSSV: </label>
                      <strong>{{$Student->mssv}}</strong>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  
                  <div class="col-xm-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                      <label>Họ và tên: </label>
                      <strong>{{$Student->hochulot}} {{$Student->ten}}</strong>
                    </div>
                    <!-- /.form-group -->
                  </div>

                  <div class="col-xm-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                      <label>Ngày sinh: </label>
                      <strong>{{Carbon\Carbon::createFromFormat('Y-m-d', $Student->ngaysinh)->format('d/m/Y')}}</strong>
                    </div>
                    <!-- /.form-group -->
                  </div>

                  <div class="col-xm-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                      <label>Lớp: </label>
                      <strong>{{$Student->lop->tenlop}}</strong>
                    </div>
                    <!-- /.form-group -->
                  </div>

                  <div class="col-xm-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                      <label>Ngành: </label>
                      <strong>{{$Student->lop->nganh->tennganh}}</strong>
                    </div>
                    <!-- /.form-group -->
                  </div>

                  <div class="col-xm-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                      <label>Khoa: </label>
                      <strong>{{$Student->lop->nganh->bomon->khoa->tenkhoa}}</strong>
                    </div>
                    <!-- /.form-group -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endif
    </form>
  @endif
@endsection
@section('javascript')
    @parent
    
    <!-- <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script> -->

    <!-- <script type="text/javascript" src="{!! URL::asset('js/jquery.min.js') !!}"></script> -->

    <!-- iCheck 1.0.1 -->
    <!-- <script src="{{URL::asset('dashboard/plugins/iCheck/icheck.min.js')}}"></script> -->
    <!-- FastClick -->
    <!-- <script src="{{URL::asset('dashboard/bower_components/fastclick/lib/fastclick.js')}}"></script> -->

    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>

    <!-- <script>
        $(document).ready(function() {
            $('#tbluser').DataTable();
        } );

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass   : 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass   : 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
        });
    </script> -->

@endsection