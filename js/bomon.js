/**
 * --------- Bo mon ---------
 */

$(".save_bomon").click(function(e){
    e.preventDefault();

    var data = {
        mabomon : $(".MaBoMon").val(),
        tenbomon : $(".TenBoMon").val(),
        idkhoa : $(".IDKhoa").val(),
    };

    if(!hasError_BoMon(data))
        callAjaxStore($(this).attr('href'), data);
});

$(".update_bomon").click(function(e){
    e.preventDefault();
    var data = {
        id : $(".ID_BoMon_CapNhat").val(),
        mabomon : $(".MaBoMon_CapNhat").val(),
        tenbomon : $(".TenBoMon_CapNhat").val(),
        idkhoa: $(".IDKhoa_CapNhat").val()
    };
    if(!hasError_BoMon(data))
    {
        callAjaxUpdate($(this).attr('href'), data);
    }
});

$(".remove_bomon").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa bộ môn " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function CapNhatBoMon($ID, $MaBoMon, $TenBoMon, $IDKhoa) {
    $("#ID_BoMon_CapNhat").val($ID);
    $('#MaBoMon_CapNhat').val($MaBoMon);
    $('#TenBoMon_CapNhat').val($TenBoMon);
    $('#IDKhoa_CapNhat').val($IDKhoa);
}

function hasError_BoMon(data) {
    var result = false;
    var message ="";

    // Kiểm tra mã bộ môn
    if(isEmpty(data.mabomon))
    {
        message += " - Vui lòng nhập mã/viết tắt bộ môn!";
        result = true;
    }

    // Kiểm tra tên bộ môn
    if(isEmpty(data.tenbomon))
    {
        message += "<br> - Vui lòng nhập tên bộ môn!";
        result = true;
    }

    // Kiểm tra chọn trực thuộc khoa
    if(data.idkhoa < '1')
    {
        message += "<br> - Vui lòng chọn khoa trực thuộc!";
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