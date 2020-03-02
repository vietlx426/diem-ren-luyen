@extends('admin.layout.master')
@section('css')
  @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
    <!-- <link rel="stylesheet" type="text/css" href="{{URL::asset('css/bootstrap.min.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{URL::asset('css/dataTables.bootstrap.min.css')}}" type="text/css"> -->
@endsection

@section('content')
  <!-- Search -->
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-search"></i> TÌM KIẾM NGƯỜI DÙNG<small>search-filter users</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row col-12 text-center">
          <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 text-center">
            <div class="form-group">
              <b>TÌM THEO</b>
            </div>
            <div class="form-group">
              <label>
                <input type="radio" id="radKho" name="searchby" class="form-radio" value="1" checked="true">
                <label for="radKho">Khoa</label>
              </label>
              &emsp;
              <label>
                <input type="radio" id="radNganh" name="searchby" value="2" class="form-radio">
                <label for="radNganh">Ngành</label>
              </label>
              &emsp;
              <label>
                <input type="radio" id="radKhoaHoc" name="searchby" value="3" class="form-radio">
                <label for="radKhoaHoc">Khóa</label>
              </label>
              &emsp;
              <label>
                <input type="radio" id="radLop" name="searchby" value="4" class="form-radio">
                <label for="radLop">Lớp</label>
              </label>
              &emsp;
              <label>
                <input type="radio" id="radMSSV" name="searchby" value="5" class="form-radio">
                <label for="radMSSV">MSSV</label>
              </label>
              &emsp;
              <label>
                <input type="radio" id="radEmail" name="searchby" value="6" class="form-radio">
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
              <button class="btn btn-primary btn-search-user-group"><i class="fa fa-search"></i> Tìm </button>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-user"></i> DANH SÁCH NGƯỜI DÙNG<small>users list</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table id="tbluser" class="table table-striped table-bordered" width="100%">
          <thead>
              <tr class="filters">
                  <th width="5%">#</th>
                  <th width="20%">Tên</th>
                  <th width="20%">Email</th>
                  <th width="10%">Trạng thái</th>
                  <th width="10%"></th>
              </tr>
          </thead>
          <tbody id="tbodyusergroup">
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
  </div>

  <!-- Loading effect -->
  <div id="contentloading" class="bg-text" hidden="true"><img id="loader-img" alt="" src="{{URL::asset('images/loading.gif')}}" width="100" height="100" align="center" /></div>
    
@endsection
@section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/jquery.dataTables.min.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/dataTables.bootstrap.min.js') !!}"></script>
    <script>
      var urlRouteusergroupkhoa = "{{ route('usergroupkhoa')}}";
      var urlRoutusergroupnganh = "{{ route('usergroupnganh')}}";
      var urlRouteusergroupkhoahoc = "{{ route('usergroupkhoahoc')}}";
      var urlRouteusergrouplop = "{{ route('usergrouplop')}}";
      var urlRouteusergroupmssv = "{{ route('usergroupmssv')}}";
      var urlRouteusergroupemail = "{{ route('usergroupemail')}}";
      var urlRoutegetdonvi= "{{ route('getdonvi')}}";
      var urlRouteusergroupedit= "{{ route('usergroupedit')}}";
      var urlRoute_ResetpassDefault = "{{ route('admin_user_resetpassdefault')}}";
    </script>
@endsection