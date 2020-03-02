/* --------- Ban cán sự --------- */
$('#btn_bancansu_search').click(function(e){
    $('#div_save').removeClass('hidden');
    loadereffectshow();
    var hockynamhoc_id = $('#idhockynamhoc').val();
    $('#selected_idhockynamhhoc').val(hockynamhoc_id);
    var lop_id = $('#idlop').val();
    $('#selected_idlop').val(lop_id);

    var url = urlRoute_get_bancansu_lop_hockynamhoc + '/' + lop_id + '/' + hockynamhoc_id;
    var DS_SV = callAjax(url, "GET");
    var DS_ChucVuBanCanSu = callAjax(urlRoute_get_chucvubancansu, "GET");
    var STT = 0;
    // $('#tbody_bancansu_add').html('');
    $('#tbl_bancansu_add').DataTable().clear();
    
    console.log("DS_ChucVuBanCanSu: " + DS_ChucVuBanCanSu.length);
    console.log(DS_SV);
    $.each(DS_SV, function(key, value){
        var row = [
            ++STT,
            value.mssv,
            value.hochulot + " " + value.ten
        ];

        $.each(DS_ChucVuBanCanSu, function(key_bancansu, value_bancansu){
            if(value[key_bancansu] == 0)
                row.push('<td class="text-center"> <input id="' + value['id'] + '_' + value_bancansu['id'] + '" name="chk_' + value['id'] + '_' + value_bancansu['id'] + '" type="checkbox" class="flat" title="' + value_bancansu['tenchucvubancansu'] + '"> </td>');
            else
                row.push('<td class="text-center"> <input id="' + value['id'] + '_' + value_bancansu['id'] + '" name="chk_' + value['id'] + '_' + value_bancansu['id'] + '" type="checkbox" checked="true" class="flat" title="' + value_bancansu['tenchucvubancansu'] + '"> </td>');
        });

        // var newRow = '<tr>';
        // newRow += '<td>' + (++STT) + '</td>';
        // newRow += '<td>' + value['mssv'] + '</td>';
        // newRow += '<td>' + value['hochulot'] + ' ' + value['ten'] + '</td>';
        
        // $.each(DS_ChucVuBanCanSu, function(key_bancansu, value_bancansu){
        //     if(value[key_bancansu] == 0)
        //         newRow += '<td class="text-center"> <input id="' + value['id'] + '_' + value_bancansu['id'] + '" name="chk_' + value['id'] + '_' + value_bancansu['id'] + '" type="checkbox" class="flat"> </td>';
        //     else
        //         newRow += '<td class="text-center"> <input id="' + value['id'] + '_' + value_bancansu['id'] + '" name="chk_' + value['id'] + '_' + value_bancansu['id'] + '" type="checkbox" checked="true" class="flat"> </td>';
        // });
        // newRow += '</tr>';
        // $('#tbl_bancansu_add').append(newRow);
        $('#tbl_bancansu_add').DataTable().row.add(row);
        console.log("DataTable");
    });
    $('#tbl_bancansu_add').DataTable().draw();

    loadereffecthide();
});
/* --------- End ban cán sự --------- */

// ----------Xóa thời gian đánh giá điểm rèn luyện--------
$(".remove_TGDGDRL").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa thời gian đánh giá cho lớp?"))
        callAjaxDestroy($(this).attr('href'));
});

/* --------- Trạng thái học kỳ --------- */

function CapNhatTrangThaiHocKy($ID, $TenTrangThai) {
    document.getElementById("ID_TrangThaiHocKy_CapNhat").value = $ID;
    document.getElementById("TenTrangThaiHocKy_CapNhat").value = $TenTrangThai;
}

$(".save_trangthaihocky").click(function (e) {
    e.preventDefault();
    var data = {
        TenTrangThaiHocKy: document.getElementById("TenTrangThaiHocKy").value
    };
    if(!hasError_TrangThaiHocKy(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_trangthaihocky").click(function(e){
    e.preventDefault();
    
    var data = {
        id: document.getElementById("ID_TrangThaiHocKy_CapNhat").value,
        TenTrangThaiHocKy: document.getElementById("TenTrangThaiHocKy_CapNhat").value
    };

    if(!hasError_TrangThaiHocKy(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".remove_trangthaihocky").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa trạng thái học kỳ tên: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function hasError_TrangThaiHocKy(data) {
    var result = false;
    var message ="";
    // Kiểm tra tên trạng thái
    if(isEmpty(data.TenTrangThaiHocKy.trim()))
    {
        message += " - Vui lòng nhập tên trạng thái học kỳ!";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}
/* --------- End trạng thái học kỳ --------- */

/* --------- Học kỳ --------- */
$(".save_hocky").click(function (e) {
    e.preventDefault();
    var data = {
        MaHocKy: document.getElementById("MaHocKy").value,
        TenHocKy: document.getElementById("TenHocKy").value
    };
    if(!hasError_HocKy(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_hocky").click(function(e){
    e.preventDefault();
    var data = {
        id: document.getElementById("ID_HocKy_CapNhat").value,
        MaHocKy: document.getElementById("MaHocKy_CapNhat").value,
        TenHocKy: document.getElementById("TenHocKy_CapNhat").value
    };
    if(!hasError_HocKy(data))
    {
        callAjaxStore($(this).attr('href'), data);
    }
});

$(".remove_hocky").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa " + $(this).attr("Ten")+"?"))
        callAjaxDestroy($(this).attr('href'));
});

function CapNhatHocKy($ID, $MaHocKy, $TenHocKy) {
    document.getElementById("ID_HocKy_CapNhat").value = $ID;
    document.getElementById("MaHocKy_CapNhat").value = $MaHocKy;
    document.getElementById("TenHocKy_CapNhat").value = $TenHocKy;
}

function hasError_HocKy(data) {
    var result = false;
    var message ="";
    
    // Kiểm tra mã học kỳ
    if(isEmpty(data.MaHocKy.trim()))
    {
        message += " - Vui lòng nhập mã học kỳ!";
        result = true;
    }

    // Kiểm tra tên học kỳ
    if(isEmpty(data.TenHocKy.trim()))
    {
        message += "<br> - Vui lòng nhập tên học kỳ!";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}

/* --------- End học kỳ --------- */

/* --------- Năm học --------- */
$(".save_namhoc").click(function (e) {
    e.preventDefault();
    var data = {
        MaNamHoc: document.getElementById("MaNamHoc").value,
        TenNamHoc: document.getElementById("TenNamHoc").value
    };
    if(!hasError_NamHoc(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_namhoc").click(function(e){
    e.preventDefault();
    var data = {
        id: document.getElementById("ID_NamHoc_CapNhat").value,
        MaNamHoc: document.getElementById("MaNamHoc_CapNhat").value,
        TenNamHoc: document.getElementById("TenNamHoc_CapNhat").value
    };
    if(!hasError_NamHoc(data))
    {
        callAjaxStore($(this).attr('href'), data);
    }
});

$(".remove_namhoc").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa năm: " + $(this).attr("Ten")+"?"))
        callAjaxDestroy($(this).attr('href'));
});

function CapNhatNamHoc($ID, $MaNamHoc, $TenNamHoc) {
    document.getElementById("ID_NamHoc_CapNhat").value = $ID;
    document.getElementById("MaNamHoc_CapNhat").value = $MaNamHoc;
    document.getElementById("TenNamHoc_CapNhat").value = $TenNamHoc;
}

function hasError_NamHoc(data) {
    var result = false;
    var message ="";

     // Kiểm tra mã năm học
    if(isEmpty(data.MaNamHoc.trim()))
    {
        message += " - Vui lòng nhập mã năm học!";
        result = true;
    }

    // Kiểm tra tên năm học
    if(isEmpty(data.TenNamHoc.trim()))
    {
        message += "<br> - Vui lòng nhập tên năm học!";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}
/* --------- End năm học --------- */

/* --------- Học kỳ - Năm học --------- */
$(".save_hockynamhoc").click(function(e){
    e.preventDefault();
    if($(".HocKy:checked").is(':checked'))
        var idHK = $(".HocKy:checked").attr('value');
    else
        var idHK = "";

    var idNH = $(".NamHoc:selected").attr('value');

    if($(".TrangThai:checked").is(':checked'))
        var idTrangThai = $(".TrangThai:checked").attr('value');
    else
        var idTrangThai = "";

    var data = {
        idhocky : idHK,
        idnamhoc : idNH,
        idtrangthai : idTrangThai
    };

    if(!hasError_HocKyNamHoc(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_hockynamhoc").click(function(e){
    e.preventDefault();
    if($(".HocKy_CapNhat:checked").is(':checked'))
        var idHocKy = $(".HocKy_CapNhat:checked").attr('value');
    else
        var idHocKy = "";

    var idNamHoc = $(".NamHoc_CapNhat:selected").attr('value');

    if($(".TrangThai_CapNhat:checked").is(':checked'))
        var idTrangThai = $(".TrangThai_CapNhat:checked").attr('value');
    else
        var idTrangThai = "";
    var data = {
        id: document.getElementById("ID_HocKyNamHoc_CapNhat").value,
        idhocky : idHocKy,
        idnamhoc : idNamHoc,
        idtrangthai : idTrangThai
    };
    if(!hasError_HocKyNamHoc(data))
    {
        callAjaxStore($(this).attr('href'), data);
    }
});

$(".remove_hockynamhoc").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa " + $(this).attr('Ten') + "?"))
        callAjaxDestroy($(this).attr('href'));
});

function CapNhatHocKyNamHoc($ID, $IDHocKy, $IDNamHoc, $IDTrangThai) {
    $("#ID_HocKyNamHoc_CapNhat").val($ID);
    $("#HocKy"+$IDHocKy+"_CapNhat").prop("checked", true);
    $('.checked').removeClass("checked");
    $("#HocKy"+$IDHocKy+"_CapNhat").parent().addClass("checked");
    $('#NamHoc_CapNhat').val($IDNamHoc).change();
    $("#TrangThai"+$IDTrangThai+"_CapNhat").parent().addClass("checked");
    $("#TrangThai"+$IDTrangThai+"_CapNhat").prop("checked", true);
}

function hasError_HocKyNamHoc(data) {
    var result = false;
    var message ="";

     // Kiểm tra học kỳ
    if(isEmpty(data.idhocky.trim()))
    {
        message += " - Vui lòng chọn học kỳ!";
        result = true;
    }

    // Kiểm tra năm học
    if(isEmpty(data.idnamhoc.trim()) || data.idnamhoc == 0)
    {
        message += "<br> - Vui lòng chọn năm học!";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}

/* --------- End Học kỳ - Năm học --------- */

/* --------- Tiêu chí đánh giá --------- */
var IdTieuChiCha_Modal=0;
$(".btn-themmoitieuchi").click(function(e){
    IdTieuChiCha_Modal = $(this).attr('idtieuchi');
});

$(".save_tieuchi").click(function(e){
    e.preventDefault();
    if($(".LoaiDiem:checked").is(':checked'))
    {
        var idLoaiDiem = $(".LoaiDiem:checked").attr('value');
    }
    else
    {
        var idLoaiDiem = 0;
    }

    if($(".TrangThai:checked").is(':checked'))
    {
        var idTrangThai = $(".TrangThai:checked").attr('value');
    }
    else
    {
        var idTrangThai = 0;
    }

    var data = {
        idhocky_namhoc : $(".selhocky").val(),
        muc : $(".inpmuc").val(),
        tentieuchi : CKEDITOR.instances['txttentieuchi'].getData(),
        idtieuchicha: IdTieuChiCha_Modal,
        idloaidiem: idLoaiDiem,
        diemtoida: $(".inpdiemtoida").val(),
        idtrangthai : idTrangThai
    };

    if(!hasError_TieuChi(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_tieuchi").click(function(e){
    e.preventDefault();
    var data = {
        idtieuchicha: $("#IDTieuChiCha_TieuChi_CapNhat").val(),
        id : $(".ID_TieuChi_CapNhat").val(),
        muc : $("#Muc_TieuChi_CapNhat").val(),
        tentieuchi : CKEDITOR.instances['Ten_TieuChi_CapNhat'].getData(),
        idloaidiem: $(".LoaiDiem_CapNhat:checked").attr('value'),
        diemtoida: $("#DiemToiDa_TieuChi").val(),
        idtrangthai : $(".TrangThai_CapNhat:checked").attr('value')
    };

    if(!hasError_TieuChi(data))
    {
        callAjaxUpdate($(this).attr('href'), data);
    }
});

function CapNhatTieuChi($ID, $ChiMuc, $TenTieuChi, $IDTieuChiCha, $IDLoaiDiem, $DiemToiDa, $IDTrangThai) {
    $("#ID_TieuChi_CapNhat").val($ID);
    $("#IDTieuChiCha_TieuChi_CapNhat").val($IDTieuChiCha);
    $('#Muc_TieuChi_CapNhat').val($ChiMuc);
    CKEDITOR.instances['Ten_TieuChi_CapNhat'].setData($TenTieuChi);
    $("#LoaiDiem_"+$IDLoaiDiem+"_CapNhat").prop("checked", true);
    $("#LoaiDiem_"+$IDLoaiDiem+"_CapNhat").closest('div').addClass('checked');
    $("#DiemToiDa_TieuChi").val($DiemToiDa);
    $("#TrangThai_"+$IDTrangThai+"_CapNhat").prop("checked", true);
    $("#TrangThai_"+$IDTrangThai+"_CapNhat").closest('div').addClass('checked');
}

function hasError_TieuChi(data) {
    var result = false;
    var message ="";

    // Kiểm tra tên tiêu chí
    if(isEmpty(data.tentieuchi))
    {
        message += "<br> - Vui lòng nhập tên/nội dung tiêu chí!";
        result = true;
    }

    // Kiểm tra loại điểm
    if(isEmpty(data.idloaidiem) || data.idloaidiem === 0)
    {
        message += "<br> - Vui lòng chọn loại điểm cho tiêu chí!";
        result = true;
    }
    
    // Kiểm tra điểm tối đa
    if(isEmpty(data.diemtoida.trim()))
    {
        message += "<br> - Vui lòng nhập điểm tối đa cho tiêu chí!";
        result = true;
    }
    else
    {
        if(data.diemtoida < 0 || data.diemtoida > 100)
        {
            message += "<br> - Điểm tối đa không hợp lệ (điểm không được < 0 và không được > 100) !";
            result = true;
        }
    }

    // Kiểm tra trạng thái tiêu chí
    if(isEmpty(data.idtrangthai) || data.idtrangthai === 0)
    {
        message += "<br> - Vui lòng chọn trạng thái!";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}

function notificationInformationValidation(message) {
    addmessagetostrongdivalert(message);
    showdivalert();
    $('.modal').animate({ scrollTop: 0 }, 'slow');
}
/* --------- End Tiêu chí đánh giá --------- */

/* --------- Bậc đào tạo --------- */
function CapNhatBacDaoTao($ID, $MaBacDaoTao, $TenBacDaoTao) {
    $("#ID_BacDaoTao_CapNhat").val($ID);// = $ID;
    $("#MaBacDaoTao_CapNhat").val($MaBacDaoTao);
    $("#TenBacDaoTao_CapNhat").val($TenBacDaoTao);
}

$(".save_bacdaotao").click(function (e) {
    e.preventDefault();
    var data = {
        MaBacDaoTao: $("#MaBacDaoTao").val(),
        TenBacDaoTao: $("#TenBacDaoTao").val()
    };
    if(!hasError_BacDaoTao(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_bacdaotao").click(function(e){
    e.preventDefault();
    
    var data = {
        id: $("#ID_BacDaoTao_CapNhat").val(),
        MaBacDaoTao: $("#MaBacDaoTao_CapNhat").val(),
        TenBacDaoTao: $("#TenBacDaoTao_CapNhat").val()
    };

    if(!hasError_BacDaoTao(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".remove_bacdaotao").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa bậc đào tạo: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function hasError_BacDaoTao(data) {
    var result = false;
    var message ="";

    // Kiểm tra mã bậc đào tạo
    if(isEmpty(data.MaBacDaoTao.trim()))
    {
        message = " - Vui lòng nhập mã bậc đào tạo!";
        result = true;
    }

    // Kiểm tra tên bậc đào tạo
    if(isEmpty(data.TenBacDaoTao.trim()))
    {
        message += "<br> - Vui lòng nhập tên bậc đào tạo!";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}
/* --------- End Bậc đào tạo --------- */

/* --------- Hệ đào tạo --------- */
function CapNhatHeDaoTao($ID, $MaHeDaoTao, $TenHeDaoTao) {
    $("#ID_HeDaoTao_CapNhat").val($ID);
    $("#MaHeDaoTao_CapNhat").val($MaHeDaoTao);
    $("#TenHeDaoTao_CapNhat").val($TenHeDaoTao);
}

$(".save_hedaotao").click(function (e) {
    e.preventDefault();
    var data = {
        MaHeDaoTao: $("#MaHeDaoTao").val(),
        TenHeDaoTao: $("#TenHeDaoTao").val()
    };
    if(!hasError_HeDaoTao(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_hedaotao").click(function(e){
    e.preventDefault();
    
    var data = {
        id: $("#ID_HeDaoTao_CapNhat").val(),
        MaHeDaoTao: $("#MaHeDaoTao_CapNhat").val(),
        TenHeDaoTao: $("#TenHeDaoTao_CapNhat").val()
    };

    if(!hasError_HeDaoTao(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".remove_hedaotao").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa hệ đào tạo: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function hasError_HeDaoTao(data) {
    var result = false;
    var message ="";

    // Kiểm tra mã hệ đào tạo
    if(isEmpty(data.MaHeDaoTao.trim()))
    {
        message = " - Vui lòng nhập mã hệ đào tạo!";
        result = true;
    }

    // Kiểm tra tên hệ đào tạo
    if(isEmpty(data.TenHeDaoTao.trim()))
    {
        message += "<br> - Vui lòng nhập tên hệ đào tạo!";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}
/* --------- End Hệ đào tạo --------- */

/* --------- Dân tộc --------- */
function CapNhatDanToc($ID, $MaDanToc, $TenDanToc) {
    $("#ID_DanToc_CapNhat").val($ID);
    $("#MaDanToc_CapNhat").val($MaDanToc);
    $("#TenDanToc_CapNhat").val($TenDanToc);
}

$(".save_dantoc").click(function (e) {
    e.preventDefault();
    var data = {
        MaDanToc: $("#MaDanToc").val(),
        TenDanToc: $("#TenDanToc").val()
    };
    if(!hasError_DanToc(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_dantoc").click(function(e){
    e.preventDefault();
    
    var data = {
        id: $("#ID_DanToc_CapNhat").val(),
        MaDanToc: $("#MaDanToc_CapNhat").val(),
        TenDanToc: $("#TenDanToc_CapNhat").val()
    };

    if(!hasError_DanToc(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".remove_dantoc").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa dân tộc: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function hasError_DanToc(data) {
    var result = false;
    var message ="";

    // Kiểm tra mã dân tộc
    if(isEmpty(data.MaDanToc.trim()))
    {
        message = " - Vui lòng nhập mã dân tộc!";
        result = true;
    }

    // Kiểm tra tên dân tộc
    if(isEmpty(data.TenDanToc.trim()))
    {
        message += "<br> - Vui lòng nhập tên dân tộc!";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}
/* --------- End Dân tộc --------- */

/* --------- Tôn giáo --------- */
function CapNhatTonGiao($ID, $MaTonGiao, $TenTonGiao) {
    $("#ID_TonGiao_CapNhat").val($ID);
    $("#MaTonGiao_CapNhat").val($MaTonGiao);
    $("#TenTonGiao_CapNhat").val($TenTonGiao);
}

$(".save_tongiao").click(function (e) {
    e.preventDefault();
    var data = {
        MaTonGiao: $("#MaTonGiao").val(),
        TenTonGiao: $("#TenTonGiao").val()
    };
    if(!hasError_TonGiao(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_tongiao").click(function(e){
    e.preventDefault();
    
    var data = {
        id: $("#ID_TonGiao_CapNhat").val(),
        MaTonGiao: $("#MaTonGiao_CapNhat").val(),
        TenTonGiao: $("#TenTonGiao_CapNhat").val()
    };

    if(!hasError_TonGiao(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".remove_tongiao").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa tôn giáo: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function hasError_TonGiao(data) {
    var result = false;
    var message ="";

    // Kiểm tra mã tôn giáo
    if(isEmpty(data.MaTonGiao.trim()))
    {
        message = " - Vui lòng nhập mã tôn giáo!";
        result = true;
    }

    // Kiểm tra tên tôn giáo
    if(isEmpty(data.TenTonGiao.trim()))
    {
        message += "<br> - Vui lòng nhập tên tôn giáo!";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}
/* --------- End Tôn giáo --------- */

/* --------- Loại điểm --------- */
function CapNhatLoaiDiem($ID, $TenLoaiDiem) {
    $("#ID_LoaiDiem_CapNhat").val($ID);
    $("#TenLoaiDiem_CapNhat").val($TenLoaiDiem);
}

$(".save_loaidiem").click(function (e) {
    e.preventDefault();
    var data = {
        TenLoaiDiem: $("#TenLoaiDiem").val()
    };
    if(!hasError_LoaiDiem(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_loaidiem").click(function(e){
    e.preventDefault();
    
    var data = {
        id: $("#ID_LoaiDiem_CapNhat").val(),
        TenLoaiDiem: $("#TenLoaiDiem_CapNhat").val()
    };

    if(!hasError_LoaiDiem(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".remove_loaidiem").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa loại điểm: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function hasError_LoaiDiem(data) {
    var result = false;
    var message ="";

    // Kiểm tra tên loại điểm
    if(isEmpty(data.TenLoaiDiem.trim()))
    {
        message = " - Vui lòng nhập tên loại điểm!";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}
/* --------- End Loại điểm --------- */

/* --------- Loại điểm --------- */
function CapNhatTrangThaiTieuChi($ID, $TenTrangThaiTieuChi) {
    $("#ID_TrangThaiTieuChi_CapNhat").val($ID);
    $("#TenTrangThaiTieuChi_CapNhat").val($TenTrangThaiTieuChi);
}

$(".save_trangthaitieuchi").click(function (e) {
    e.preventDefault();
    var data = {
        TenTrangThaiTieuChi: $("#TenTrangThaiTieuChi").val()
    };
    if(!hasError_TrangThaiTieuChi(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_trangthaitieuchi").click(function(e){
    e.preventDefault();
    
    var data = {
        id: $("#ID_TrangThaiTieuChi_CapNhat").val(),
        TenTrangThaiTieuChi: $("#TenTrangThaiTieuChi_CapNhat").val()
    };

    if(!hasError_TrangThaiTieuChi(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".remove_trangthaitieuchi").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa trạng thái: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function hasError_TrangThaiTieuChi(data) {
    var result = false;
    var message ="";

    // Kiểm tra tên trạng thái tiêu chí
    if(isEmpty(data.TenTrangThaiTieuChi.trim()))
    {
        message = " - Vui lòng nhập tên trạng thái tiêu chí!";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}
/* --------- End Loại điểm --------- */

/* --------- Xếp loại điểm rèn luyện --------- */
function CapNhatXepLoaiDiemRenLuyen($ID, $MaXepLoaiDiemRenLuyen, $TenXepLoaiDiemRenLuyen, $MinDiemXepLoaiDiemRenLuyen, $MaxDiemXepLoaiDiemRenLuyen) {
    $("#ID_XepLoaiDiemRenLuyen_CapNhat").val($ID);
    $("#MaXepLoaiDiemRenLuyen_CapNhat").val($MaXepLoaiDiemRenLuyen);
    $("#TenXepLoaiDiemRenLuyen_CapNhat").val($TenXepLoaiDiemRenLuyen);
    $("#MinDiemXepLoaiDiemRenLuyen_CapNhat").val($MinDiemXepLoaiDiemRenLuyen);
    $("#MaxDiemXepLoaiDiemRenLuyen_CapNhat").val($MaxDiemXepLoaiDiemRenLuyen);
}

$(".save_xeploaidiemrenluyen").click(function (e) {
    e.preventDefault();
    var data = {
        MaXepLoaiDiemRenLuyen: $('#MaXepLoaiDiemRenLuyen').val(),
        TenXepLoaiDiemRenLuyen: $("#TenXepLoaiDiemRenLuyen").val(),
        MinDiemXepLoaiDiemRenLuyen: $("#MinDiemXepLoaiDiemRenLuyen").val(),
        MaxDiemXepLoaiDiemRenLuyen: $("#MaxDiemXepLoaiDiemRenLuyen").val()
    };
    if(!hasError_XepLoaiDiemRenLuyen(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_xeploaidiemrenluyen").click(function(e){
    e.preventDefault();
    
    var data = {
        id: $("#ID_XepLoaiDiemRenLuyen_CapNhat").val(),
        MaXepLoaiDiemRenLuyen: $('#MaXepLoaiDiemRenLuyen_CapNhat').val(),
        TenXepLoaiDiemRenLuyen: $("#TenXepLoaiDiemRenLuyen_CapNhat").val(),
        MinDiemXepLoaiDiemRenLuyen: $("#MinDiemXepLoaiDiemRenLuyen_CapNhat").val(),
        MaxDiemXepLoaiDiemRenLuyen: $("#MaxDiemXepLoaiDiemRenLuyen_CapNhat").val()
    };

    if(!hasError_XepLoaiDiemRenLuyen(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".remove_xeploaidiemrenluyen").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa loại: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function hasError_XepLoaiDiemRenLuyen(data) {
    var result = false;
    var message ="";

    // Kiểm tra mã xếp loại điểm rèn luyện
    if(isEmpty(data.MaXepLoaiDiemRenLuyen.trim()))
    {
        message = " - Vui lòng nhập mã xếp loại!";
        result = true;
    }

    // Kiểm tra tên xếp loại điểm rèn luyện
    if(isEmpty(data.TenXepLoaiDiemRenLuyen.trim()))
    {
        message += "<br> - Vui lòng nhập tên xếp loại!";
        result = true;
    }

    // Kiểm tra min điểm xếp loại điểm rèn luyện
    if(isEmpty(data.MinDiemXepLoaiDiemRenLuyen.trim()))
    {
        message += "<br> - Vui lòng nhập điểm Min!";
        result = true;
    }
    else
    {
        if(parseInt(data.MinDiemXepLoaiDiemRenLuyen) < 0 || parseInt(data.MinDiemXepLoaiDiemRenLuyen) > 100)
        {
            message += "<br> - Vui lòng nhập điểm Min trong khoảng từ 0 -> 100!";
            result = true;
        }
    }
    

    // Kiểm tra max điểm xếp loại điểm rèn luyện
    if(isEmpty(data.MaxDiemXepLoaiDiemRenLuyen.trim()))
    {
        message += "<br> - Vui lòng nhập điểm Max!";
        result = true;
    }
    else
    {
        if(parseInt(data.MaxDiemXepLoaiDiemRenLuyen) < 0 || parseInt(data.MaxDiemXepLoaiDiemRenLuyen) > 100)
        {
            message += "<br> - Vui lòng nhập điểm Max trong khoảng từ 0 -> 100!";
            result = true;
        }
    }

    if(!result)
    {
        if(parseInt(data.MaxDiemXepLoaiDiemRenLuyen) <= parseInt(data.MinDiemXepLoaiDiemRenLuyen))
        {
            message = " - Vui lòng nhập điểm Min phải nhỏ hơn điểm Max!";
            result = true;
        }
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}
/* --------- End Xếp loại điểm rèn luyện --------- */

/*Hoạt động sự kiện*/
$(".save_hdsk").click(function (e) {
    e.preventDefault();
    var data = {
        tenhoatdongsukien: document.getElementById("tenhoatdongsukien").value,
        loaihoatdongsukien_id:document.getElementById("IDLoaiHDSK").value,
        thoigianbatdaudangky:document.getElementById("thoigianBDDK").value,
        thoigianketthucdangky:document.getElementById("thoigianKTDK").value,
        giobatdau: document.getElementById("gioBD").value,
        giokethuc: document.getElementById("gioKT").value,
        thoigianbatdau:document.getElementById("thoigianBD").value,
        thoigianketthuc: document.getElementById("thoigianKT").value,
        diadiem: document.getElementById("diadiem").value,
        ghichu: document.getElementById("ghichu").value
    };
    if(!hasError_HoatDongSuKien(data))
        callAjaxStore($(this).attr('href'), data);
});
function CapNhatHDSK($ID,$tenhoatdongsukien ,$loaihoatdongsukien_id,$thoigianbatdaudangky
    ,$thoigianketthucdangky,$giobatdau,$giokethuc,$thoigianbatdau,$thoigianketthuc,$diadiem,$ghichu) {
        document.getElementById("idhoatdongsukien_capnhat").value = $ID;
        document.getElementById("tenhoatdongsukien_capnhat").value = $tenhoatdongsukien;
        document.getElementById("IDLoaiHDSK_capnhat").value = $loaihoatdongsukien_id;
        document.getElementById("thoigianBDDK_capnhat").value = $thoigianbatdaudangky;
        document.getElementById("thoigianKTDK_capnhat").value = $thoigianketthucdangky;
        document.getElementById("gioBD_capnhat").value = $giobatdau;
        document.getElementById("gioKT_capnhat").value = $giokethuc;
        document.getElementById("thoigianBD_capnhat").value = $thoigianbatdau;
        document.getElementById("thoigianKT_capnhat").value = $thoigianketthuc;
        document.getElementById("diadiem_capnhat").value = $diadiem;
        document.getElementById("ghichu_capnhat").value = $ghichu;
}
$(".update_hdsk").click(function(e){
    e.preventDefault();
    
    var data = {
        id: document.getElementById("idhoatdongsukien_capnhat").value,
        tenhoatdongsukien:document.getElementById("tenhoatdongsukien_capnhat").value,
        loaihoatdongsukien_id: document.getElementById("IDLoaiHDSK_capnhat").value,
        thoigianbatdaudangky: document.getElementById("thoigianBDDK_capnhat").value,
        thoigianketthucdangky: document.getElementById("thoigianKTDK_capnhat").value,
        giobatdau : document.getElementById("gioBD_capnhat").value,
        giokethuc: document.getElementById("gioKT_capnhat").value,
        thoigianbatdau: document.getElementById("thoigianBD_capnhat").value,
        thoigianketthuc: document.getElementById("thoigianKT_capnhat").value,
        diadiem: document.getElementById("diadiem_capnhat").value,
        ghichu: document.getElementById("ghichu_capnhat").value

    };

    if(!hasError_HoatDongSuKien(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".remove_hdsk").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa hoạt động sự kiện: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

$(".remove_dkhdsk").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa sinh viên tên: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function hasError_HoatDongSuKien(data) {
    var result = false;
    var message ="";
    var bddk = Date.parse(data.thoigianbatdaudangky);
    var bdkt = Date.parse(data.thoigianketthucdangky);
    var giobd = Date.parse(data.giobatdau);
    var giokt = Date.parse(data.giokethuc);
    var bd = Date.parse(data.thoigianbatdau);
    var kt = Date.parse(data.thoigianketthuc);
    // Kiểm tra tên trạng thái
    if(isEmpty(data.tenhoatdongsukien.trim()))
    {
        message += " - Vui lòng chọn tên hoạt động sự kiện!";
        result = true;
    }
    if(isEmpty(data.thoigianbatdaudangky.trim()))
    {
        message += "<br> - Vui lòng chọn ngày tháng bắt đầu đăng ký!";
        result = true;
    }

    if(isEmpty(data.thoigianketthucdangky.trim())){
        message +="<br>- Vui lòng chọn ngày tháng kết thúc đăng ký!";
        result=true;
    }
    if(isEmpty(data.giobatdau.trim()))
    {
        message += "<br>- Vui lòng chọn giờ bắt đầu!";
        result = true;
    }

    if(isEmpty(data.giokethuc.trim())){
        message +="<br>- Vui lòng chọn giờ kết thúc!";
        result=true;
    }
    if(isEmpty(data.thoigianbatdau.trim()))
    {
        message += "<br> - Vui lòng chọn ngày tháng bắt đầu!";
        result = true;
    }

    if(isEmpty(data.thoigianketthuc.trim())){
        message +="<br>- Vui lòng chọn ngày tháng kết thúc!";
        result=true;
    }
    
    if(isEmpty(data.diadiem.trim()))
    {
        message += "<br> - Vui lòng chọn địa điểm!";
        result = true;
    }
    if(bddk > bdkt)
    {
        message += "- Ngày kết thúc đăng ký phải sau ngày bắt đầu đăng ký!";
        result = true;
    }
    if(bd > kt)
    {
        message += "- Ngày kết thúc phải sau ngày bắt đầu !";
        result = true;
    }

    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}
/*Kết thúc hoạt động sự kiện*/

/*Loại hoạt động sự kiện*/
$(".save_loaihd").click(function (e) {
    e.preventDefault();
    var data = {
        tenloaihoatdongsukien: document.getElementById("tenloaihoatdongsukien").value,
        maloaihoatdongsukien:document.getElementById("maloaihoatdongsukien").value
    };
    if(!hasError_LoaiHoatDongSuKien(data))
        callAjaxStore($(this).attr('href'), data);
});
function CapNhatLoaiHDSK($ID,$MaLoaiHDSK ,$TenLoaiHDSK) {
        document.getElementById("idloaihoatdongsukien_capnhat").value = $ID;
        document.getElementById("maloaihoatdongsukien_capnhat").value = $MaLoaiHDSK;
        document.getElementById("tenloaihoatdongsukien_capnhat").value = $TenLoaiHDSK;
}
$(".update_loaihd").click(function(e){
    e.preventDefault();
    
    var data = {
        id: document.getElementById("idloaihoatdongsukien_capnhat").value,
        maloaihoatdongsukien:document.getElementById("maloaihoatdongsukien_capnhat").value,
        tenloaihoatdongsukien: document.getElementById("tenloaihoatdongsukien_capnhat").value

    };
    if(!hasError_LoaiHoatDongSuKien(data))
        callAjaxUpdate($(this).attr('href'), data);
});

$(".remove_loaihdsk").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa loại hoạt động sự kiện tên: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});
function hasError_LoaiHoatDongSuKien(data) {
    var result = false;
    var message ="";
    // Kiểm tra tên trạng thái
    if(isEmpty(data.maloaihoatdongsukien.trim())){
        message +="- Vui lòng nhập mã loại hoạt động sự kiện!";
        result=true;
    }
    if(isEmpty(data.tenloaihoatdongsukien.trim()))
    {
        message += "<br> - Vui lòng nhập tên loại hoạt động sự kiện!";
        result = true;
    }
    if(result)
    {
        notificationInformationValidation(message);
    }
    return result;
}
/*Kết thúc loại hoạt động sự kiện*/


/* --------- User - Group - Permission --------- */
function CapNhatUserGroup($ID, $TenUser, $EmailUser, $GroupUser, $TrangThaiUser) {
    $.each($GroupUser, function( index, value ) {
          alert( index + ": " + value['idGroup'] );
        $('#PermissionUser_CapNhat'+value['idGroup']).prop("checked", true);

    });
    $("#ID_User_CapNhat").val($ID);
    $("#TenUser_CapNhat").val($TenUser);
    $("#EmailUser_CapNhat").val($EmailUser);

    if($TrangThaiUser == '1')
    {
        $("#TrangThaiUser_CapNhat_KichHoat").prop( "checked", true );
    }
    else
    {
        $("#TrangThaiUser_CapNhat_Khoa").prop( "checked", true );
    }

    
}

$("input[name='searchby']:radio").on("change", function() { 
    // alert('hola'); 
    var checkedValue = $("input[name='searchby']:checked").val();
    switch (checkedValue)
    {
      case '1':
        HiddenAllWithOutID('divSearchFalcuty');
        break;

      case '2':
        HiddenAllWithOutID('divSearchMajor');
        break;
        
      case '3':
        HiddenAllWithOutID('divSearchScholastic');
        break;

    case '4':
        HiddenAllWithOutID('divSearchClass');
        break;

      case '5':
        HiddenAllWithOutID('divSearchIDStudent');
        break;

      case '6':
        HiddenAllWithOutID('divSearchEmail');
        break;

      default:
        break;
    }
});

function HiddenAllWithOutID(id) {
    $('#divSearchFalcuty').attr('hidden', 'true');
    $('#divSearchMajor').attr('hidden', 'true');
    $('#divSearchClass').attr('hidden', 'true');
    $('#divSearchScholastic').attr('hidden', 'true');
    $('#divSearchIDStudent').attr('hidden', 'true');
    $('#divSearchEmail').attr('hidden', 'true');

    $('#'+id).removeAttr('hidden');
}

$('.btn-search-user-group').click(function(e){
    if(!hasError())
    {
        searchGetData();
    }
});

function hasError() {
    var checkedValue = $("input[name='searchby']:checked").val();

    switch (checkedValue)
    {
        case '1':
            return hasErrorSearchFalcuty();
            break;

        case '2':
            return hasErrorSearchMajor();
            break;

        case '3':
            return hasErrorSearchScholastic();
            break;
            
        case '4':
            return hasErrorSearchClass();
            break;

        case '5':
            return hasErrorSearchIDStudent();
            break;

        case '6':
            return hasErrorSearchEmail();
            break;

        default:
    }
}

function hasErrorSearchFalcuty() {
    if($('#selKhoa').val() < '1')
    {
        $('#divSearchFalcuty').addClass('has-error');
        $('#SearchFalcuty-help').html('Chọn khoa');
        return true;
    }
    else
    {
        $('#divSearchFalcuty').removeClass('has-error');
        $('#SearchFalcuty-help').html('');
        return false;
    }
}

function hasErrorSearchMajor() {
    if($('#selMajor').val() < '1')
    {
        $('#divSearchMajor').addClass('has-error');
        $('#SearchMajor-help').html('Chọn ngành');
        return true;
    }
    else
    {
        $('#divSearchMajor').removeClass('has-error');
        $('#SearchMajor-help').html('');
        return false;
    }
}

function hasErrorSearchScholastic() {
    if($('#selScholastic').val() < '1')
    {
        $('#divSearchScholastic').addClass('has-error');
        $('#SearchScholastic-help').html('Chọn khóa');
        return true;
    }
    else
    {
        $('#divSearchScholastic').removeClass('has-error');
        $('#SearchScholastic-help').html('');
        return false;
    }
}

function hasErrorSearchClass() {
    if(isEmpty($('#inpClassName').val()))
    {
        $('#divSearchClass').addClass('has-error');
        $('#SearchClass-help').html('Nhập tên lớp');
        return true;
    }
    else
    {
        $('#divSearchClass').removeClass('has-error');
        $('#SearchClass-help').html('');
        return false;
    }
}

function hasErrorSearchIDStudent() {
    if(isEmpty($('#inpIDStudent').val()))
    {
        $('#divSearchIDStudent').addClass('has-error');
        $('#SearchIDStudent-help').html('Nhập mã số sinh viên');
        return true;
    }
    else
    {
        $('#divSearchIDStudent').removeClass('has-error');
        $('#SearchIDStudent-help').html('');
        return false;
    }
}

function hasErrorSearchEmail() {
    if(isEmpty($('#inpEmail').val()))
    {
        $('#divSearchEmail').addClass('has-error');
        $('#SearchEmail-help').html('Nhập email');
        return true;
    }
    else
    {
        $('#divSearchEmail').removeClass('has-error');
        $('#SearchEmail-help').html('');
        return false;
    }
}

function searchGetData() {
    var checkedValue = $("input[name='searchby']:checked").val();
    openloadingeffect();

    switch (checkedValue)
    {
        case '1':
            getDataByFalcuty();
            break;

        case '2':
            getDataByMajor();
            break;

        case '3':
            getDataByScholastic();
            break;
            
        case '4':
            getDataByClass();
            break;

        case '5':
            getDataByMSSV();
            break;

        case '6':
            getDataByEmail();
            break;

        default:
    }
}

function getDataByFalcuty() {
    urlRoute = urlRouteusergroupkhoa + "/" + $('#selKhoa').val();

    $.ajaxSetup({
            headers: getHeaders()
        });

    $.ajax({
        url: urlRoute,
        type: "get",
    })

    .done(function(data) {
        viewDataInTable(data);
    })

    .fail(function() {
        alert( "error" );
    });
}

function getDataByMajor() {
 
  urlRoute = urlRoutusergroupnganh + "/" + $('#selMajor').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTable(data);
  })

  .fail(function() {
    alert( "error" );
  });

}

function getDataByScholastic() {
 
  urlRoute = urlRouteusergroupkhoahoc + "/" + $('#selScholastic').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTable(data);
  })

  .fail(function() {
    alert( "error" );
  });

}

function getDataByClass() {
 
  urlRoute = urlRouteusergrouplop + "/" + $('#inpClassName').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTable(data);
  })

  .fail(function() {
    alert( "error" );
  });

}

function getDataByMSSV() {
 
  urlRoute = urlRouteusergroupmssv + "/" + $('#inpIDStudent').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTable(data);
  })

  .fail(function() {
    alert( "error" );
  });

}

function getDataByEmail() {
 
  urlRoute = urlRouteusergroupemail + "/" + $('#inpEmail').val();

  $.ajaxSetup({
        headers: getHeaders()
    });

  $.ajax({
      url: urlRoute,
      type: "get",
  })

  .done(function(data) {
    viewDataInTable(data);
  })

  .fail(function() {
    alert( "error" );
  });

}

function viewDataInTable(data) {
    $('#tbodyusergroup').html('');
    var STT = '0';
    $.each(data, function( key, value ) {
        var newRow = '<tr>';
        newRow += '<td>' + (++STT) + '</td>'
        newRow += '<td>' + value['name'] + '</td>'
        newRow += '<td>' + value['email'] + '</td>'
    
        if(value['idtrangthaiuser'] == '1')
            newRow += '<td><span class="badge bg-blue"> Đã kích hoạt </span></td>';
        else
            newRow += '<td><span class="badge bg-red"> Đang bị khóa </span></td>';

        newRow +=   '<td class="text-center-middle">' +
                        '<a target="_blank" href="' + urlRouteusergroupedit + "/" + value['id'] + '" class="btn btn-warning" title="Xem chi tiết & Sửa"><i class="fa fa-edit"></i></a>' + 
                        '<a href="" value="' + value['id'] + '" class="btn btn-danger btn-resetpass-default" title="Reset mật khẩu mặc định"><i class="fa fa-retweet"></i></a>' + 
                    '</td>';
            
        newRow += '</tr>';

        $('#tbodyusergroup').append(newRow);
    });


    if(STT == '0')
        $('#tbodyusergroup').html('<tr><td colspan="7" class="text-center"><h4> Không tìm thấy thông tin trong hệ thống! </h4></td></tr>');

    $('.btn-resetpass-default').click(function(e){
        e.preventDefault();
        if(confirm("Bạn muốn reset mật khẩu của user về mật khẩu mặc định?"))
        {
            openloadingeffect();
            $.ajaxSetup({
                headers: getHeaders()
            });
        
            $.ajax({
                url: urlRoute_ResetpassDefault,
                type: "post",
                data: {'id': $(this).attr('value')}
            })
        
            .done(function(data) {
                alert(data['message']);
                closeloadingeffect();
            })
        
            .fail(function() {
                alert( "error (vui lòng liên hệ quản trị hệ thống)!" );
                closeloadingeffect();
            });
        }
    });
    closeloadingeffect();
}

function getDonVi(idUser, idLoaiUsser) {
    urlRoute = urlRoutegetdonvi + "/" + idUser + "/" + idLoaiUsser;
    // alert(urlRoute);
    $.ajaxSetup({
        headers: getHeaders()
    });

    $.ajax({
        url: urlRoute,
        type: "get",
    })

    .done(function(data) {
        return data[0]['tendonvi'];
    })

    .fail(function() {
        alert( "error" );
    });
}
/* --------- End User - Group - Permission --------- */

function openloadingeffect() {
    $('#contentloading').removeAttr('hidden');
}

function closeloadingeffect() {
    $('#contentloading').attr('hidden', 'true');
}

function isEmpty(str) {
    if(str == null || str == '')
    {
        return true;
    }
    else
    {
        return false;
    }
}

function getToken() {
	return $('meta[name="csrf-token"]').attr('content');
}

function getHeaders() {
	return headers = {
            'X-CSRF-TOKEN': getToken()
        }
}

function callAjaxStore(url, data) {
    $.ajaxSetup({
        headers: getHeaders()
    });
    
    $.ajax({
        url: url,
        type: "post",
        data: data,
    })
    .done(function(result) {
        if(result.status)
        {
            alert(result.message);
            location.reload();
        }
        else
        {
            notificationInformationValidation(result.message);
            // alert(result.message);
        }
    })
    .fail(function(jqXHR, textStatus) {
        alert(textStatus);
    });
}

function callAjaxUpdate(url, data) {
    $.ajaxSetup({
        headers: getHeaders()
    });
    $.ajax({
        url: url,
        type: "post",
        data: data,
    })
    .done(function(result) {
        if(result.status)
        {
            alert(result.message);
            location.reload();
        }
        else
        {
            alert(result.message);
        }
    })
    .fail(function(jqXHR, textStatus) {
      alert(textStatus);
    });
}

function callAjaxDestroy(url) {
    $.ajaxSetup({
        headers: getHeaders()
    });
    $.ajax({
        url: url,
        type: "get",
    })
    .done(function(result) {
        if(result.status)
        {
            alert(result.message);
            location.reload();
        }
        else
        {
            alert(result.message);
        }
    })
    .fail(function(jqXHR, textStatus) {
      alert(textStatus);
    });
}