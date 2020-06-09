@extends('admin.layout.master')
@section('title')
  @parent | Sửa thông báo
@endsection

@section('content')
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h2>SỬA THÔNG BÁO</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
       <form action="" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{csrf_field()}}
            @include('layouts.gentelella-master.blocks.flash-messages')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 ">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tieude">Tiêu đề<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="tieude" id="tieude" class="form-control" value="{{old('tieude',$thongbao->tieude)}}" placeholder="Tiêu đề">
                            
                        </div>
                    </div>
                </div>
                 <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tieude">Học bổng<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select name="hocbong" id="hocbong" class="form-control">
                          @if(isset($dsHocBong))
                            @foreach($dsHocBong as $data)
                                <option value="{{$data->idhb}}" {{old('hocbong',isset($thongbao->id_hocbong)  ? $thongbao->id_hocbong : '')==$data->idhb ? "selected='select'" : "" }}>{{$data->tenhb}}</option>
                             @endforeach
                          @endif
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 ">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="motabotieuchi">Nội dung thông báo<span class="required"></span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea name="noidung" id="noidung" class="ckeditor"  rows="5" class="form-control" placeholder="Nội dung thông báo">{{$thongbao->noidung}}</textarea>
                            
                        </div>
                    </div>
                </div>
               
                
            </div>

            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-primary btn-save"><i class="fa fa-save"></i><strong> LƯU </strong></button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
  <script src="{{URL::asset('js/ckeditor/ckeditor.js')}}"></script>
  <script src="{{URL::asset('js/ckfinder/ckfinder.js')}}"></script>
  
@endsection