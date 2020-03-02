@extends('subadmin.layout.master')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{URL::asset('css/select2.min.css')}}" type="text/css">


@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <h4>TÌM SINH VIÊN</h4>
            <hr>
        </div>

        <div class="panel-body">
            {{ csrf_field() }}
            <div class="row col-12">
                <!-- Khoa -->
                <div class="col-12">
                    <div class="form-group{{ $errors->has('khoa') ? ' has-error' : '' }} row">
                        <label for="khoa" class="control-label">Khoa</label>
                            <select id="country" multiple>
                                <option disabled></option>
                                @if(isset($DanhSach_Khoa))
                                    @foreach($DanhSach_Khoa as $Khoa)
                                        <option value="{{$Khoa->id}}"> {{$Khoa->tenkhoa}} </option>
                                    @endforeach
                                @endif
                            </select>
                        @if ($errors->has('khoa'))
                            <span class="help-block">
                                <strong>{{ $errors->first('khoa') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group{{ $errors->has('nganh') ? ' has-error' : '' }} row">
                        <label for="nganh" class="control-label">Ngành</label>
                            <select id="selnganh" multiple class="form-control">
                                <option disabled></option>
                                @if(isset($DanhSach_Khoa))
                                    @foreach($DanhSach_Khoa as $Khoa)
                                        <option value="{{$Khoa->id}}"> {{$Khoa->tenkhoa}} </option>
                                    @endforeach
                                @endif
                            </select>
                        @if ($errors->has('nganh'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nganh') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="form-group{{ $errors->has('khoa') ? ' has-error' : '' }} row">
                        <label for="khoa" class="control-label">Khoa</label>

                            <select id="selectmultiple" name="selectmultiple" class="form-control" multiple="multiple">
                              <option value="1">Option one</option>
                              <option value="2">Option two</option>
                            </select>
                        @if ($errors->has('khoa'))
                            <span class="help-block">
                                <strong>{{ $errors->first('khoa') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="form-group{{ $errors->has('khoa') ? ' has-error' : '' }} row">
                        <label for="khoa" class="control-label">Ngành</label>

                            <select id="selectmultiple" name="selectmultiple" class="form-control" multiple="multiple">
                              <option value="1">Option one</option>
                              <option value="2">Option two</option>
                            </select>
                        @if ($errors->has('khoa'))
                            <span class="help-block">
                                <strong>{{ $errors->first('khoa') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="form-group{{ $errors->has('khoa') ? ' has-error' : '' }} row">
                        <label for="khoa" class="control-label">Lớp</label>

                            <select id="selectmultiple" name="selectmultiple" class="form-control" multiple="multiple">
                              <option value="1">Option one</option>
                              <option value="2">Option two</option>
                            </select>
                        @if ($errors->has('khoa'))
                            <span class="help-block">
                                <strong>{{ $errors->first('khoa') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('mssv') ? ' has-error' : '' }}">
                    <label for="mssv" class="control-label">MSSV</label>

                        <input id="mssv" type="mssv" class="" name="mssv" value="{{ old('mssv') }}" placeholder="Nhập mã số sinh viên" required autofocus>

                        @if ($errors->has('mssv'))
                            <span class="help-block">
                                <strong>{{ $errors->first('mssv') }}</strong>
                            </span>
                        @endif
                    <button class="btn btn-primary search_student_id" url="{{route('searchsinhvienajax')}}">
                        <i class="fa fa-search"></i> Tìm
                    </button>

                    <a id="aalert" href="" class="btn btn-primary">Alert</a>
                </div>
            </div>
            <hr width="20%">
            <input id="div_url_studentprofile" type="text" hidden="true" value="{{route('studentprofilepicurl')}}">
        </div>
    </div>
       
    <div class="panel panel-primary">
        <table class="table table-striped table-bordered" width="100%">
            <thead>
                <tr class="filters">
                    <!-- <th width="5%">#</th> -->
                    <th width="10%">MSSV</th>
                    <th width="20%">Họ và tên</th>
                    <th width="10%">Lớp</th>
                    <th width="20%">Ngành</th>
                    <th width="30%">Khoa</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody id="tbody">
                
            </tbody>
        </table>
    </div>
@endsection
@section('javascript')
    @parent

    <script type="text/javascript" src="{!! URL::asset('js/timsinhvien.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/select2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/select.min.js') !!}"></script>
@endsection