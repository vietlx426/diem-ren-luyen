@extends('truongdonvi.layout.master')

@section('title')
    @parent | Search - Filter
@endsection

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/mystyle.css')}}">
    <!-- iCheck -->
    <link href="{{URL::asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-search"></i> TÌM KIẾM - LỌC <small>SEARCH - FILTER</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <h4 class="text-center"><label for=""> HỌC KỲ - NĂM HỌC </label></h4>
              <div class="well" style="max-height: 150px; height:150px; overflow: auto;">
                  <ul class="list-group checked-list-box">
                      @if(isset($dsHocKyNamHoc))
                          @foreach($dsHocKyNamHoc as $hocKyNamHoc)
                              <li class="list-group-item hockynamhoc" value="{{$hocKyNamHoc->id}}"> {{$hocKyNamHoc->tenhockynamhoc}} </li>
                          @endforeach
                      @endif
                  </ul>
              </div>
          </div>

          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <h4 class="text-center"><label for=""> ĐIỂM HỌC TẬP </label></h4>
              <div class="well" style="max-height: 150px; overflow: auto;">
                <div class="row form-group">
                    <div class="col-xs-6 col-sm-7 col-md-7 col-lg-5 col-xl-4">
                        <select name="hoctapdieukien1" id="hoctapdieukien1" class="form-control">
                            <option value="">Điều kiện</option>
                            <option value=">"> > </option>
                            <option value=">="> >= </option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-5 col-md-5 col-lg-7 col-xl-8">
                        <input type="number" name="hoctapdieukien1value" id="hoctapdieukien1value" class="form-control" step="0.01" placeholder="Giá trị" disabled>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6 col-sm-7 col-md-7 col-lg-5 col-xl-4">
                        <select name="hoctapdieukien2" id="hoctapdieukien2" class="form-control">
                            <option value="">Điều kiện</option>
                            <option value="<"> < </option>
                            <option value="<="> <= </option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-5 col-md-5 col-lg-7 col-xl-8">
                        <input type="number" name="hoctapdieukien2value" id="hoctapdieukien2value" class="form-control" step="0.01" placeholder="Giá trị" disabled>
                    </div>
                </div>
                <br>
              </div>
          </div>

          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <h4 class="text-center"><label for=""> ĐIỂM RÈN LUYỆN </label></h4>
              <div class="well" style="max-height: 150px;overflow: auto;">
                <div class="row form-group">
                    <div class="col-xs-6 col-sm-7 col-md-7 col-lg-5 col-xl-4">
                        <select name="renluyendieukien1" id="renluyendieukien1" class="form-control">
                            <option value="">Điều kiện</option>
                            <option value=">"> > </option>
                            <option value=">="> >= </option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-5 col-md-5 col-lg-7 col-xl-8">
                        <input type="number" name="renluyendieukien1value" id="renluyendieukien1value" class="form-control" step="0.01" placeholder="Giá trị" disabled>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-6 col-sm-7 col-md-7 col-lg-5 col-xl-4">
                        <select name="renluyendieukien2" id="renluyendieukien2" class="form-control">
                            <option value="">Điều kiện</option>
                            <option value="<"> < </option>
                            <option value="<="> <= </option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-5 col-md-5 col-lg-7 col-xl-8">
                        <input type="number" name="renluyendieukien2value" id="renluyendieukien2value" class="form-control" step="0.01" placeholder="Giá trị" disabled>
                    </div>
                </div>
                <br>
              </div>
          </div>

          <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <h4 class="text-center"> <label for=""> THUỘC DIỆN </label></h4>
              <div class="well" style="max-height: 150px;overflow: auto;">
                <div class="row form-group text-center">
                    <input type="checkbox" id="hongheo" name="hongheo" value="hongheo" class="flat"> <label for="hongheo"> Hộ nghèo </label>
                    &nbsp; &nbsp; &nbsp;
                    <input type="checkbox" id="hocanngheo" name="hocanngheo" value="hocanngheo" class="flat"> <label for="hocanngheo"> Hộ cận nghèo </label>
                    &nbsp; &nbsp; &nbsp;
                    <input type="checkbox" id="mocoicha" name="mocoicha" value="mocoicha" class="flat"> <label for="mocoicha"> Mồ côi cha </label>
                    &nbsp; &nbsp; &nbsp;
                    <input type="checkbox" id="mocoime" name="mocoime" value="mocoime" class="flat"> <label for="mocoime"> Mồ côi mẹ </label>
                    &nbsp; &nbsp; &nbsp;
                    <input type="checkbox" id="conthuongbinh" name="conthuongbinh" value="conthuongbinh" class="flat"> <label for="conthuongbinh"> Con thương binh </label>
                    &nbsp; &nbsp; &nbsp;
                    <input type="checkbox" id="conlietsy" name="conlietsy" value="conlietsy" class="flat"> <label for="conlietsy"> Con liệt sỹ </label>
                    &nbsp; &nbsp; &nbsp;
                    <input type="checkbox" id="tantat" name="tantat" value="tantat" class="flat"> <label for="tantat"> Tàn tật </label>
                </div>
              </div>
          </div> -->

        </div>

        <div class="row text-center">
          <button class="btn btn-primary btn_search_filter">
            <i class="fa fa-search"></i> <strong> TÌM KIẾM </strong>
          </button>

          <!-- <button class="btn btn-success student_export">
            <i class="fa fa-file-excel-o"></i> <strong> XUẤT FILE </strong>
          </button> -->
        </div>

      </div>
    </div>
  </div>

  <div id="div-studentListResult" class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-list"></i> DANH SÁCH KẾT QUẢ<small>RESULT LIST</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <table id="table-studentListResult" class="table table-striped" width="100%">
          <thead>
            <tr class="filters">
              <th width="10%">MSSV</th>
              <th width="25%">Họ và tên</th>
              <th width="10%">Lớp</th>
              <th width="25%">Khoa</th>
              <th width="15%">Điểm RL</th>
              <th width="15%">Điểm HT</th>
            </tr>
          </thead>
          <tbody id="tbody_studentListResult">
              
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
    @parent

    <!-- Datatables -->
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('gentelella-master/vendors/pdfmake/build/vfs_fonts.js')}}"></script>
    <!-- iCheck -->
    <script src="{{URL::asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
    
    <script type="text/javascript" src="{!! URL::asset('js/function.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/ajax.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/search_filter_diemrenluyen.js') !!}"></script>

    <script type="text/javascript">
      var urlRouteSearchFilterDiemRenLuyen = "{{route('adminsearchfilterindexpost')}}";
    </script>
@endsection