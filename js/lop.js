/**
 * --------- Bo mon ---------
 */

$(".save_lop").click(function(e){
    e.preventDefault();

    try
    {
        var data = {
            malop : $(".MaLop").val(),
            tenlop : $(".TenLop").val(),
            idkhoahoc : $(".IDKhoaHoc").val(),
            idnganh : $(".IDNganh").val(),
        };

        if(!hasError_Lop(data))
            callAjaxStore($(this).attr('href'), data);

    }catch(e){

    }
    
});

$(".update_lop").click(function(e){
    e.preventDefault();
    var data = {
        id : $(".ID_Lop_CapNhat").val(),
        malop : $(".MaLop_CapNhat").val(),
        tenlop : $(".TenLop_CapNhat").val(),
        idkhoahoc : $(".IDKhoaHoc_CapNhat").val(),
        idnganh : $(".IDNganh_CapNhat").val()
    };
    if(!hasError_Lop(data))
    {
        callAjaxUpdate($(this).attr('href'), data);
    }
});

$(".remove_lop").click(function (e) {
    e.preventDefault();
    if(confirm("Bạn có muốn xóa lớp " + $(this).attr("Ten")))
        callAjaxDestroy($(this).attr('href'));
});

function CapNhatLop($ID, $MaLop, $TenLop, $IDKhoaHoc, $IDNganh) {
    $("#ID_Lop_CapNhat").val($ID);
    $('#MaLop_CapNhat').val($MaLop);
    $('#TenLop_CapNhat').val($TenLop);
    $('#IDKhoaHoc_CapNhat').val($IDKhoaHoc);
    $('#IDNganh_CapNhat').val($IDNganh);
}

function hasError_Lop(data) {
    var result = false;
    var message ="";

    // Kiểm tra mã lớp
    if(isEmpty(data.malop))
    {
        message += " - Vui lòng nhập mã lớp!";
        result = true;
    }

    // Kiểm tra tên lớp
    if(isEmpty(data.tenlop))
    {
        message += "<br> - Vui lòng nhập tên lớp!";
        result = true;
    }

    // Kiểm tra chọn khóa
    if(data.idkhoahoc < 1)
    {
        message += "<br> - Vui lòng chọn khóa!";
        result = true;
    }

    // Kiểm tra chọn ngành
    if(data.idnganh < 1)
    {
        message += "<br> - Vui lòng chọn ngành!";
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