/**
 * --------- Bo mon ---------
 */

$(".save_nganh").click(function(e){
    e.preventDefault();

    var data = {
        manganh : $(".MaNganh").val(),
        tennganh : $(".TenNganh").val(),
        kyhieunganh : $(".KyHieuNganh").val(),
        idbomon : $(".IDBoMon").val(),
        idbacdaotao : $(".IDBacDaoTao").val(),
        idhedaotao : $(".IDHeDaoTao").val(),
    };

    if(!hasError_Nganh(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_nganh").click(function(e){
    e.preventDefault();
    var data = {
        id : $(".ID_Nganh_CapNhat").val(),
        manganh : $(".MaNganh_CapNhat").val(),
        tennganh : $(".TenNganh_CapNhat").val(),
        kyhieunganh : $(".KyHieuNganh_CapNhat").val(),
        idbomon : $(".IDBoMon_CapNhat").val(),
        idbacdaotao : $(".IDBacDaoTao_CapNhat").val(),
        idhedaotao : $(".IDHeDaoTao_CapNhat").val()
    };
    if(!hasError_Nganh(data))
    {
        callAjaxUpdate($(this).attr('href'), data);
    }
});

$(".remove_nganh").click(function (e) {
    e.preventDefault();
    console.log($(this).attr('href'));

    if(confirm("Bạn có muốn xóa ngành " + $(this).attr("Ten")))
       callAjaxDestroy($(this).attr('href'));
});

function CapNhatNganh($ID, $MaNganh, $TenNganh, $KyHieuNganh, $IDBoMon, $IDBacDaoTao, $IDHeDaoTao) {
    $("#ID_Nganh_CapNhat").val($ID);
    $('#MaNganh_CapNhat').val($MaNganh);
    $('#TenNganh_CapNhat').val($TenNganh);
    $('#KyHieuNganh_CapNhat').val($KyHieuNganh);
    $('#IDBoMon_CapNhat').val($IDBoMon);
    $('#IDBacDaoTao_CapNhat').val($IDBacDaoTao);
    $('#IDHeDaoTao_CapNhat').val($IDHeDaoTao);
}

function hasError_Nganh(data) {
    var result = false;
    var message ="";

    // Kiểm tra mã ngành
    if(isEmpty(data.manganh))
    {
        message += " - Vui lòng nhập mã ngành!";
        result = true;
    }

    // Kiểm tra tên ngành
    if(isEmpty(data.tennganh))
    {
        message += "<br> - Vui lòng nhập tên ngành!";
        result = true;
    }

    // Kiểm tra chọn trực thuộc bộ môn
    if(data.idbomon < 1)
    {
        message += "<br> - Vui lòng chọn trực thuộc bộ môn!";
        result = true;
    }

    // Kiểm tra chọn bậc đào tạo
    if(data.idbacdaotao < 1)
    {
        message += "<br> - Vui lòng chọn bậc đào tạo!";
        result = true;
    }

    // Kiểm tra chọn hệ đào tạo
    if(data.idhedaotao < 1)
    {
        message += "<br> - Vui lòng chọn hệ đào tạo!";
        result = true;
    }

    if(result)
    {
        showNotificationInformation('alert-warning', message);
        showNotificationInformationUpdate('alert-warning', message);
    }
    else
    {
        hideNotificationInformation();
    }
    
    return result;
}
/**
 * --------- End Bo mon ---------
 */