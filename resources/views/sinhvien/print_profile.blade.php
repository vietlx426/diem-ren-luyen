<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

 <style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Times New Roman;
    font-size: 17px;
}
/*
#myVideo {
    position: fixed;
    right: 0;
    bottom: 0;
    min-width: 100%; 
    min-height: 100%;
}*/

/*.content {
    position: fixed;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    color: #f1f1f1;
    width: 100%;
    padding: 20px;
}*/

/*#myBtn {
    width: 200px;
    font-size: 18px;
    padding: 10px;
    border: none;
    background: #000;
    color: #fff;
    cursor: pointer;
}

#myBtn:hover {
    background: #ddd;
    color: black;
}
</style>
<!-- Styles -->
<!-- Styles -->
<link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}" type="text/css">
<link href="{{URL::asset('css/font-awesome.min.css')}}" rel="stylesheet">

</head>
  <body>
    <div class="container">

      <div class="row">
        <div class="col-md-12 text-center"  style="font-weight: bold;">
          <b>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</b>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center" style="font-weight: bold;">
          <b><u>Độc lập - Tự do - Hạnh phúc</u></b>
        </div>
      </div>
      <table width="80%">
        <tr>
          <td width="10%"></td>
          <td width="15%">
            <table class="table table-bordered" width="100%">
              <tr>
                <td class="text-center" style="text-align: center; vertical-align: middle;" >
                  @if(isset($LyLich))
                    @if($LyLich->picture)
                      <img width="30mm" src="{{URL::asset($LyLich->picture)}}" class="" >
                    @else
                      @if(isset($SV))
                        @if($SV->hinhthe)
                          <img width="30mm" src="{{URL::asset($SV->hinhthe)}}" class="" >
                        @else
                          <br>
                          <br>
                          Ảnh
                          <br>
                          (4x6)
                          <br>
                          <br>
                          <br>
                          <br>
                        @endif
                      @else
                        <br>
                        <br>
                        Ảnh
                        <br>
                        (4x6)
                        <br>
                        <br>
                        <br>
                        <br>
                      @endif
                    @endif
                  @else
                    @if(isset($SV))
                        @if($SV->hinhthe)
                          <img width="30mm" src="{{URL::asset($SV->hinhthe)}}" class="" >
                        @else
                          <br>
                          <br>
                          Ảnh
                          <br>
                          (4x6)
                          <br>
                          <br>
                          <br>
                          <br>
                        @endif
                      @else
                        <br>
                        <br>
                        Ảnh
                        <br>
                        (4x6)
                        <br>
                        <br>
                        <br>
                        <br>
                      @endif
                  @endif
                </td>
              </tr>
            </table>
          </td>
          <td width="75%" class="text-center" style="text-align: center; vertical-align: middle;" >
           <!--  <div class="row">
              <div class="col-md-12 text-center"> -->
                
                <h3><div style="font-weight: bold;">SƠ YẾU LÝ LỊCH SINH VIÊN</div></h3>
              <!-- </div> -->
           <!-- </div> -->


          </td>
        </tr>
      </table>

      <div class="row">
        <div class="col-md-12 text-center">
          <br>
          <b><div style="font-weight: bold;">I/ PHẦN BẢN THÂN SINH VIÊN</div></b>
       </div>
      </div>

      

      <table class="table-borderless" width="100%">
        <tr>
          <td width="17%"> </td>
          <td width="17%"> </td>
          <td width="17%"> </td>
          <td width="17%"> </td>
          <td width="17%"> </td>
          <td width="15%"> </td>
        </tr>
        <tr>
          <td colspan="4">
            - Họ và tên: {!! $SV->hochulot . ' ' . $SV->ten!!} 
          </td>
          <td colspan="2">
            Giới tính: {!! $SV->gioitinh? ($SV->gioitinh  == 1 ? 'Nam' : 'Nữ') : '' !!}
          </td>
        </tr>
        <tr>
          <td colspan="2">- Lớp: {!! $SV->lop->tenlop !!}</td>
          <td colspan="2">MSSV: {!! $SV->mssv !!}</td>
          <td colspan="2">Khóa học: {!! $SV->lop->khoahoc->tenkhoahoc !!} </td>
        </tr>
        <tr>
          <td colspan="3">- Ngành: {!! $SV->lop->nganh->tennganh !!} </td>
          <td colspan="3">Khoa: {!! $SV->lop->nganh->bomon->khoa->tenkhoa !!}</td>
        </tr>
      <tr>
        <td colspan="2">- Điểm trúng tuyển ĐH: {!! $SV->diemtrungtuyen !!} </td>
        <td colspan="2">Ngày sinh: {!! date('d/m/Y', strtotime($SV->ngaysinh)) !!} </td>
        <td colspan="2">Nơi sinh: {!! $LyLich->noisinh !!} </td>
      </tr>
      <tr>
        <td colspan="2">- Số CMND: {!! $SV->cmnd !!} </td>
        <td colspan="2">Ngày cấp: {!! date('d/m/Y', strtotime($LyLich->ngaycapcmnd)) !!} </td>
        <td colspan="2">Nơi cấp: {!! $LyLich->noicapcmnd !!} </td>
      </tr>
      <tr>
        <td colspan="6">- Hộ khẩu thường trú: {!! $LyLich->hokhauthuongtru . ', ' . App\Xa::find($LyLich->xa_id)->tenxa . ', ' . App\Xa::find($LyLich->xa_id)->huyen->tenhuyen . ', ' . App\Xa::find(  $LyLich->xa_id)->huyen->tinh->tentinh !!} </td>
      </tr>
      <tr>
        <td colspan="3">- Dân tộc: {!! App\DanToc::find($LyLich->dantoc_id)->tendantoc !!} </td>
        <td colspan="3">Tôn giáo: {!! App\TonGiao::find($LyLich->tongiao_id)->tentongiao !!} </td>
      </tr>
      <tr>
        <td colspan="3">- Email: {!! $LyLich->email !!} </td>
        <td colspan="3">Điện thoại: {!! $LyLich->dienthoai !!}</td>
      </tr>
      <tr>
        <td colspan="3">- Ngày vào Đoàn TNCS HCM: {!! $LyLich->ngayvaodoantncshcm ? date('d/m/Y', strtotime($LyLich->ngayvaodoantncshcm)) : '' !!}</td>
        <td colspan="3">tại: {!! $LyLich->noivaodoantncshcm !!}</td>
      </tr>
      <tr>
        <td colspan="3">- Ngày vào Đảng CS Việt Nam: {!! $LyLich->ngayvaodangcsvn ? date('d/m/Y', strtotime($LyLich->ngayvaodangcsvn)) : '' !!}</td>
        <td colspan="3">tại: {!! $LyLich->noivaodangcsvn !!}</td>
      </tr>
      <tr>
        <td colspan="6">- Thuộc diện: {!!  $LyLich->hongheo ? 'Hộ nghèo, ' : '' !!} {!!  $LyLich->hocanngheo ? 'Hộ cận nghèo, ' : '' !!} {!! $LyLich->mocoicha ? 'Mồ côi cha, ' : ''!!} {!! $LyLich->mocoime ? 'Mồ côi mẹ, ' : '' !!} {!! $LyLich->conthuongbinh ? 'Con thương binh, ' : '' !!} {!! $LyLich->conlietsy ? 'Con liệt sỹ, ' : '' !!} {!! $LyLich->tantat ? 'Tàn tật' : '' !!}</td>
      </tr>
      <tr>
        <td colspan="6" class="text-center"  style="font-weight: bold;">
          <br>
          <b>II/ PHẦN GIA ĐÌNH</b>
        </td>
      </tr>
      <tr>
        <td colspan="6" style="font-weight: bold;"><b>1. Cha: </b></td>
      </tr>
      <tr>
        <td colspan="2">- Họ và tên: {!! $LyLich->hotencha !!} </td>
        <td colspan="2">Năm sinh: {!! $LyLich->ngaysinhcha ?  date('d/m/Y', strtotime($LyLich->ngaysinhcha)) : '' !!}</td>
        <td colspan="2">Dân tộc: {!! $LyLich->dantoc_idcha ? $LyLich->dantoccha->tendantoc : '' !!} </td>
      </tr>
      <tr>
        <td colspan="6">- Hộ khẩu thường trú: {!! $LyLich->xa_idcha ? ( $LyLich->hokhauthuongtrucha .  ', ' .  App\Xa::find($LyLich->xa_idcha)->tenxa . ', '  . App\Xa::find($LyLich->xa_idcha)->huyen->tenhuyen . ', ' . App\Xa::find(  $LyLich->xa_idcha)->huyen->tinh->tentinh) : '' !!} </td>
      </tr>
      <tr>
        <td colspan="2">- Nghề nghiệp: {!! $LyLich->nghenghiepcha !!}</td>
        <td colspan="2">Nơi làm việc: {!! $LyLich->noilamvieccha !!} </td>
        <td colspan="2">Số điện thoại: {!! $LyLich->dienthoaicha !!} </td>
      </tr>

      <tr>
        <td colspan="6"  style="font-weight: bold;"><b>2. Mẹ:</b></td>
      </tr>
      <tr>
        <td colspan="2">- Họ và tên: {!! $LyLich->hotenme !!} </td>
        <td colspan="2">Năm sinh: {!! $LyLich->ngaysinhme ? date('d/m/Y', strtotime($LyLich->ngaysinhme)) : '' !!}</td>
        <td colspan="2">Dân tộc: {!! $LyLich->dantoc_idme ? $LyLich->dantocme->tendantoc : '' !!} </td>
      </tr>
      <tr>
        <td colspan="6">- Hộ khẩu thường trú: {!! $LyLich->xa_idme ? ($LyLich->hokhauthuongtrume  . ', ' . App\Xa::find($LyLich->xa_idme)->tenxa . ', ' . App\Xa::find($LyLich->xa_idme)->huyen->tenhuyen . ', ' . App\Xa::find(  $LyLich->xa_idme)->huyen->tinh->tentinh) : '' !!} </td>
      </tr>
      <tr>
        <td colspan="2">- Nghề nghiệp: {!! $LyLich->nghenghiepme !!}</td>
        <td colspan="2">Nơi làm việc: {!! $LyLich->noilamviecme !!} </td>
        <td colspan="2">Số điện thoại: {!! $LyLich->dienthoaime !!} </td>
      </tr>
      <tr>
        <td colspan="6" style="font-weight: bold;"><b>3. Anh, chị, em ruột:</b></td>
      </tr>
    </table>

    @if($DanhSach_AnhChiEm)
      <table class="table table-bordered" width="100%">
        <tbody>
          <tr class="text-center">
            <td class="text-center" width="10%"   style="font-weight: bold;">Quan hệ</td>
            <td class="text-center" width="25%"   style="font-weight: bold;">Họ và tên</td>
            <td class="text-center" width="15%"   style="font-weight: bold;">Năm sinh</td>
            <td class="text-center" width="20%"   style="font-weight: bold;">Nghề nghiệp</td>
            <td class="text-center" width="30"   style="font-weight: bold;">Nơi ở</td>
          </tr>
          @foreach($DanhSach_AnhChiEm as $AnhChiEm)
            <tr class="text-center">
              <td>{{ $AnhChiEm->moiquanhe->tenmoiquanhe }}</td>
              <td>{{ $AnhChiEm->hoten }}</td>
              <td class="text-center">{{ date('d/m/Y', strtotime($AnhChiEm->namsinh)) }}</td>
              <td>{{ $AnhChiEm->nghenghiep }}</td>
              <td>{{ $AnhChiEm->noio }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
      <table>
        <tr>
          <td colspan="2"   style="font-weight: bold; font-style: italic;"><b> <strong>Tôi xin cam đoan những lời khai trên đây là đúng sự thật./.</strong></b></td>
        </tr>
        <tr>
          <td width="50%"></div>
          <td width="50%" class="text-center">
            <div  style="font-style: italic;"><i>.................., ngày ...... tháng ...... năm {{date('Y')}}</i></div>
            
            <br>
            <div  style="font-weight: bold;"><strong><b>NGƯỜI KHAI LÝ LỊCH</b></strong></div>
            <i>(Ký và ghi rõ họ tên)</i>
          </td>
        </tr>
      </table>
      <br>
  </body>
</html>
