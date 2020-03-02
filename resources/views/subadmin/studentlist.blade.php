@extends('subadmin.layout.master')
@section('css')
  @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/dataTables.bootstrap.min.css')}}" type="text/css">
@endsection

@section('content')
    <!-- Loading effect -->
    <div id="contentloading" class="bg-text" hidden="true"><img id="loader-img" alt="" src="{{URL::asset('images/loading.gif')}}" width="100" height="100" align="center" /></div>

    <!-- Content Header (Page header) -->
    <section class="content-header text-center" style="padding-top: 0px; margin-top: -20px;">
      <h1>
        DANH SÁCH SINH VIÊN
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search - Filter</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row col-12">
                <div class="col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-center">
                  <div class="form-group">
                    <b>TÌM THEO</b>
                  </div>
                  <div class="form-group">
                    <label>
                      <input type="radio" id="radKho" name="searchstudentby" class="form-radio" value="1" checked>
                      <label for="radKho">Khoa</label>
                    </label>
                    &emsp;
                    <label>
                      <input type="radio" id="radNganh" name="searchstudentby" value="2" class="form-radio">
                      <label for="radNganh">Ngành</label>
                    </label>
                    &emsp;
                    <label>
                      <input type="radio" id="radKhoaHoc" name="searchstudentby" value="3" class="form-radio">
                      <label for="radKhoaHoc">Khóa</label>
                    </label>
                    &emsp;
                    <label>
                      <input type="radio" id="radLop" name="searchstudentby" value="4" class="form-radio">
                      <label for="radLop">Lớp</label>
                    </label>
                    &emsp;
                    <label>
                      <input type="radio" id="radMSSV" name="searchstudentby" value="5" class="form-radio">
                      <label for="radMSSV">MSSV</label>
                    </label>
                    &emsp;
                    <label>
                      <input type="radio" id="radEmail" name="searchstudentby" value="6" class="form-radio">
                      <label for="radEmail">Email</label>
                    </label>
                  </div>
                  <div id="divSearchFalcuty" class="form-group">
                    <input type="text" value="{{route('usergroupkhoa')}}" hidden="true">
                    <select name="Khoa" id="selKhoa" class="form-control">
                      <option value="0">--- Chọn khoa ---</option>
                      @if(isset($DS_Khoa))
                        @foreach($DS_Khoa as $Khoa)
                          <option value="{{$Khoa->id}}">{{$Khoa->tenkhoa}}</option>
                        @endforeach
                      @endif
                    </select>
                    <div class="col-md-12 text-center">
                      <span class="help-block">
                          <strong id="SearchFalcuty-help"></strong>
                      </span>
                    </div>
                  </div>
                  <div id="divSearchMajor" class="form-group" hidden="true">
                    <select name="Nganh" id="selMajor" class="form-control">
                      <option value="0">--- Chọn ngành ---</option>
                      @if(isset($DS_Nganh))
                        @foreach($DS_Nganh as $Nganh)
                          <option value="{{$Nganh->id}}">{{$Nganh->tennganh}} - {{$Nganh->bacdaotao->tenbac}}</option>
                        @endforeach
                      @endif
                    </select>
                    <div class="col-md-12 text-center">
                      <span class="help-block">
                          <strong id="SearchMajor-help"></strong>
                      </span>
                    </div>
                  </div>
                  <div class="form-group" id="divSearchScholastic" hidden="true">
                    <select name="KhoaHoc" id="selScholastic" class="form-control">
                      <option value="0">--- Chọn khóa học ---</option>
                      @if(isset($DS_KhoaHoc))
                        @foreach($DS_KhoaHoc as $KhoaHoc)
                          <option value="{{$KhoaHoc->id}}">{{$KhoaHoc->tenkhoahoc}}</option>
                        @endforeach
                      @endif
                    </select>
                    <div class="col-md-12 text-center">
                      <span class="help-block">
                          <strong id="SearchScholastic-help"></strong>
                      </span>
                    </div>
                  </div>
                  <div class="form-group" id="divSearchClass" hidden="true">
                    <input type="text" id="inpClassName" class="form-control" placeholder="Tên lớp">
                    <div class="col-md-12 text-center">
                      <span class="help-block">
                          <strong id="SearchClass-help"></strong>
                      </span>
                    </div>
                  </div>
                  <div id="divSearchIDStudent" class="form-group" hidden="true">
                    <input type="text" id="inpIDStudent" class="form-control" placeholder="Mã số sinh viên">
                    <div class="col-md-12 text-center">
                      <span class="help-block">
                          <strong id="SearchIDStudent-help"></strong>
                      </span>
                    </div>
                  </div>
                  <div id="divSearchEmail" class="form-group" hidden="true">
                    <input type="text" id="inpEmail" class="form-control" placeholder="Email">
                    <div class="col-md-12 text-center">
                      <span class="help-block">
                          <strong id="SearchEmail-help"></strong>
                      </span>
                    </div>
                  </div>
                  <div id="divSearch" class="form-group">
                    <button class="btn btn-primary btn-search-student"><i class="fa fa-search"></i> Tìm </button>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-12">
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">DANH SÁCH SINH VIÊN</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="row">
                <div class="col-md-12">
                  <table id="tblstudent" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr class="filters">
                            <th>#</th>
                            <th>MSSV</th>
                            <th>Họ tên</th>
                            <!-- <th>Email</th> -->
                            <th>Lớp</th>
                            <th>Ngành</th>
                            <th>Khoa</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbodystudent">
                        @if(isset($DS_User) && count($DS_User) > 0)
                            <?php $STT = 0; ?>
                            @foreach($DS_User as $User)
                                <tr>
                                    <th class="text-center-middle">{{++$STT}}</th>
                                    <td class="text-justify-middle">
                                        {{ $User->name }}
                                    </td>
                                    <td class="text-justify-middle">
                                        {{ $User->email }}
                                    </td><td class="text-justify-middle">
                                            {{App\Http\Controllers\UserController::getDonViByUser($User)}}
                                    </td>
                                    <td class="text-justify-middle">
                                        <?php $DS_Quyen = $User->usergroup; ?>
                                        @if($DS_Quyen && count($DS_Quyen) > 0)
                                            @foreach($DS_Quyen as $Quyen)
                                                <?php 
                                                    switch ($Quyen->group->id) {
                                                        case '1': // Quản trị hệ thống
                                                            echo '<span class="badge bg-red">' . $Quyen->group->Name . '</span>';
                                                            break;
                                                        case '2': // Chuyên viên hệ thống
                                                            echo '<span class="badge bg-green">' . $Quyen->group->Name . '</span>';
                                                            
                                                            break;
                                                        case '3': // Trưởng đơn vị
                                                            echo '<span class="badge bg-blue">' . $Quyen->group->Name . '</span>';
                                                            
                                                            break;
                                                        case '4': // Chuyên viên
                                                            echo '<span class="badge bg-aqua">' . $Quyen->group->Name . '</span>';
                                                            
                                                            break;
                                                        case '5': // Giáo vụ khoa
                                                            echo '<span class="badge bg-green">' . $Quyen->group->Name . '</span>';
                                                            
                                                            break;
                                                        case '6': // Cố vấn học tập
                                                            echo '<span class="badge bg-blue">' . $Quyen->group->Name . '</span>';
                                                            
                                                            break;
                                                        case '7': // Ban cán sự
                                                            echo '<span class="badge bg-aqua">' . $Quyen->group->Name . '</span>';
                                                            
                                                            break;
                                                        case '8': // Sinh viên
                                                            echo '<span class="badge bg-green">' . $Quyen->group->Name . '</span>';
                                                            
                                                            break;
                                                        
                                                        default:
                                                            # code...
                                                            break;
                                                    }
                                                 ?>
                                            @endforeach
                                        @else
                                            <span class="badge bg-yellow">Chưa gán quyền</span>
                                        @endif
                                    </td>
                                    <td class="text-justify-middle">
                                        @if($User->idtrangthaiuser == '1')
                                            <span class="badge bg-blue"> Đã kích hoạt </span>
                                        @else
                                            <span class="badge bg-red"> Đang bị khóa </span>
                                        @endif
                                    </td>
                                    <td class="text-center-middle">
                                      <a target="_blank" href="{{route('usergroupedit', ['iduser' => $User->id])}}" class="btn btn-warning" title="Xem chi tiết & Sửa"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <!-- <tfoot> -->
                                <tr>
                                    <td colspan="7" class="text-center">KHÔNG CÓ DỮ LIỆU</td>
                                </tr>
                            <!-- </tfoot> -->
                        @endif
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

@endsection
@section('javascript')
    @parent
    
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.studentlist.js') !!}"></script>

    <script type="text/javascript" src="{!! URL::asset('js/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/jquery.dataTables.min.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/dataTables.bootstrap.min.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/ajax.js') !!}"></script>
    <script>
        // $(document).ready(function() {
        //     $('#tbluser').DataTable();
        // } );

        var urlRoutestudentbykhoa = "{{ route('studentbykhoa')}}";
        var urlRoutestudentbynganh = "{{ route('studentbynganh')}}";
        var urlRoutestudentbykhoahoc = "{{ route('studentbykhoahoc')}}";
        var urlRoutestudentbylop = "{{ route('studentbylop')}}";
        var urlRoutestudentbymssv = "{{ route('studentbymssv')}}";
        var urlRoutestudentbyemail = "{{ route('studentbyemail')}}";

        $('#load').click(function (e) {
          loader();
          // alert("sf");
          //   // Adding loading GIF
          //   $('#contentloading').removeAttr('hidden');
          //   $('#contentloading').html('<img id="loader-img" alt="" src="{{URL::asset('images/loading.gif')}}" width="100" height="100" align="center" />');
         
           //AJAX REQUEST HERE
         
        });

    </script>

@endsection