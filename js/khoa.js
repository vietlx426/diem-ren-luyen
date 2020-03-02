/**
 * --------- Khoa ---------
 */

$(".save_khoa").click(function(e){
    e.preventDefault();

    var data = {
        makhoa : $(".MaKhoa").val(),
        tenkhoa : $(".TenKhoa").val(),
    };

    if(!hasError_Khoa(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_khoa").click(function(e){
    e.preventDefault();
    var data = {
        id : $(".ID_Khoa_CapNhat").val(),
        makhoa : $(".MaKhoa_CapNhat").val(),
        tenkhoa : $(".TenKhoa_CapNhat").val()
    };

    if(!hasError_Khoa(data))
    {
        callAjaxUpdate($(this).attr('href'), data);
    }
});

$(".remove_khoa").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa khoa: " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function CapNhatKhoa($ID, $MaKhoa, $TenKhoa) {
    $("#ID_Khoa_CapNhat").val($ID);
    $('#MaKhoa_CapNhat').val($MaKhoa);
    $('#TenKhoa_CapNhat').val($TenKhoa);
}

function hasError_Khoa(data) {
    var result = false;
    var message ="";

    // Kiểm tra mã khoa
    if(isEmpty(data.makhoa))
    {
        message += "<br> - Vui lòng nhập mã/viết tắt khoa!";
        result = true;
    }

    // Kiểm tra tên khoa
    if(isEmpty(data.tenkhoa))
    {
        message += "<br> - Vui lòng nhập tên khoa!";
        result = true;
    }

    if(result)
    {
        showNotificationInformation('alert-warning', message);
    }
    else
    {
        hideNotificationInformation();
    }
    return result;
}
/**
 * --------- End Khoa ---------
 */