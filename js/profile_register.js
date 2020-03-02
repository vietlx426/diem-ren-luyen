/*
 * --------- Profile Sinh Vien ---------
 */
function setAllBtnCircleDefault() {
    $('.btn-circle').removeClass('active');
    $('.btn-circle').removeClass('show');
    
    // $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');
    // $('.btn-circle').removeClass('btn-info');
    $('.btn-direction').removeClass('active');
    $('.btn-direction').removeClass('show');
    // $('.btn-circle').removeClass('show');

}

$('.btn-circle').on('click',function(e){
    
    setAllBtnCircleDefault();
    $(this).addClass('btn-info');
    $(this).removeClass('btn-default').blur();
    $('#btn_nav_process_giadinh').addClass('btn-info');
    e.preventDefault();
    // e.stopImmediatePropagation();
});

$('#btn-next-giadinh').click(function (e) {
    
    // if(hasAlertInformationPersonal())
    // {
    //     e.stopImmediatePropagation();
    // }
    // else
    // {
        setAllBtnCircleDefault();
        $('#btn_nav_process_giadinh').addClass('active').removeClass('btn-default').blur();
        // hideNotificationInformation();
    // }
});

// $('#btn_nav_process_giadinh').click(function (e) {
//     e.preventDefault();
//     // if(hasAlertInformationPersonal())
//     // {
        // setAllBtnCircleDefault();
        // $('#btn_nav_process_banthan').addClass('active').removeClass('btn-default').blur();
//         // e.stopImmediatePropagation();
//     // }
//     // else
//     // {
//     //     hideNotificationInformation();
//     // }
// });

$('#btn-previous-banthan').click(function (e) {
    e.preventDefault();
    setAllBtnCircleDefault();
    $('#btn_nav_process_banthan').addClass('active').removeClass('btn-default').blur();
});

$('.btn_save').click(function (e) {
    if(hasAlertInformationFamily())
    {
        $('#div_table_anhchiem').addClass('has-error');
        $('#str_error_anhchiem').html(' * Vui lòng nhập đầy đầy đủ thông tin cho anh, chị, em.');
        e.preventDefault();
        e.stopImmediatePropagation();
    }
    else
    {
        $('#div_table_anhchiem').removeClass('has-error');
        $('#str_error_anhchiem').html('');
    }
//     else
//     {
//         alert("not error");
//         hideNotificationInformation();
//     }
});

function hasAlertInformationPersonal() {
    var error_count = 0;
    var Error_Max = 5;
    var result = false;
    var message ="";
    
    // Kiểm tra họ lót
    if(error_count < Error_Max && (isEmpty($('#holot').val().trim())))
    {
        message += " - Vui lòng nhập họ và chữ lót!";
        result = true;
        error_count++;
    }

    // Kiểm tra tên
    if(error_count < Error_Max && (isEmpty($('#ten').val().trim())))
    {
        message += "<br> - Vui lòng nhập họ tên!";
        result = true;
        error_count++;
    }

    // Kiểm tra giới tính
    if(error_count < Error_Max && (! $('.gioitinh').is(':checked')))
    {
        message += "<br> - Vui lòng chọn giới tính!";
        result = true;
        error_count++;
    }

    // Kiểm tra ngành học
    if(error_count < Error_Max && ($('#nganh').val() <= 0))
    {
        message += "<br> - Vui lòng chọn ngành học!";
        result = true;
        error_count++;
    }

    // Kiểm tra lớp học
    if(error_count < Error_Max && ($('#lop').val() <= 0))
    {
        message += "<br> - Vui lòng chọn lớp học!";
        result = true;
        error_count++;
    }

    // Kiểm tra số điện thoại
    if(error_count < Error_Max && (!isEmpty($('#dienthoai').val().trim())))
    {
        if(($('#dienthoai').val().trim().length < 10) || ($('#dienthoai').val().trim().length > 11))
        {
            message += "<br> - Vui lòng nhập số điện thoại đủ 10 hoặc 11 số!";
            result = true;
            error_count++;
        }
    }

    // Kiểm tra điểm trúng tuyển
    if(error_count < Error_Max && (isEmpty($('#diemtrungtuyen').val().trim())))
    {
        message += "<br> - Vui lòng nhập điểm trúng tuyển!";
        result = true;
        error_count++;
    }
    else
    {
        if (error_count < Error_Max && (parseFloat($('#diemtrungtuyen').val()) <= 0 || parseFloat($('#diemtrungtuyen').val()) > 35))
        {
            message += "<br> - Điểm trúng không hợp lệ. Vui lòng nhập điểm trong khoảng từ 1->30!";
            result = true;
            error_count++;
        }
    }

    // Kiểm tra ngày, tháng, năm sinh
    var yearcurent = parseInt(new Date().getFullYear());
    var MinOld = 16;
    var MaxOld = 50;
    if(error_count < Error_Max && (isEmpty($("#namsinh").val())))
    {
        message += "<br> - Vui lòng nhập ngày, tháng, năm sinh!";
        result = true;
        error_count++;
    }
    else
    {
        var date_temp = $("#namsinh").val().split("/");
        var yearvalue = parseInt(date_temp[0]);

        if(error_count < Error_Max && (yearcurent < yearvalue || (yearcurent - yearvalue) < MinOld || (yearcurent - yearvalue) > MaxOld))
        {
            message += "<br> - Ngày, tháng, năm sinh không hợp lệ. Vui lòng nhập lại ngày, tháng, năm sinh!";
            result = true;
            error_count++;
        }
    }

    // Kiểm tra nơi sinh
    if(error_count < Error_Max && (isEmpty($('#noisinh').val().trim())))
    {
        message += "<br> - Vui lòng nhập nơi sinh!";
        result = true;
        error_count++;
    }

    // Kiểm tra cmnd
    if(error_count < Error_Max && (isEmpty($('#cmnd').val().trim())))
    {
        message += "<br> - Vui lòng nhập số CMND!";
        result = true;
        error_count++;
    }
    else
    {
        if(error_count < Error_Max && ($('#cmnd').val().trim().length != 9))
        {
            message += "<br> - Vui lòng nhập số CMND đúng 9 số!";
            result = true;
            error_count++;
        }
    }

    // Kiểm tra ngày cấp CMND
    var Duration = 20;
    var datecurent = new Date();
    if(error_count < Error_Max && (isEmpty($("#ngaycapcmnd").val())))
    {
        message += "<br> - Vui lòng nhập ngày cấp CMND!";
        result = true;
        error_count++;
    }
    else
    {
        var date_cmnd_temp = $("#ngaycapcmnd").val().split("-");
        var year_cmnd_value = parseInt(date_cmnd_temp[0]);
        
        // var datevalue = new Date(date_cmnd_temp[2], date_cmnd_temp[1] - 1, date_cmnd_temp[0]);
        var datevalue = new Date(date_cmnd_temp[0], date_cmnd_temp[1] - 1, date_cmnd_temp[2]);
        
        if(error_count < Error_Max && (yearcurent < year_cmnd_value || (yearcurent - year_cmnd_value) > Duration || datevalue > datecurent))
        {
            message += "<br> - Ngày cấp CMND không hợp lệ. Vui lòng nhập lại ngày cấp CMND!";
            result = true;
            error_count++;
        }
    }

    // Kiểm tra nơi cấp CMND
    if(error_count < Error_Max && (isEmpty($('#noicapcmnd').val().trim())))
    {
        message += "<br> - Vui lòng nhập nơi cấp CMND!";
        result = true;
        error_count++;
    }

    // Kiểm tra hộ khẩu thường trú
    if(error_count < Error_Max && (isEmpty($('#hokhauthuongtru').val().trim())))
    {
        message += "<br> - Vui lòng nhập hộ khẩu thường trú!";
        result = true;
        error_count++;
    }

    // Kiểm tra dân tộc
    if(error_count < Error_Max && ($('#dantoc').val() <= 0))
    {
        message += "<br> - Vui lòng chọn dân tộc!";
        result = true;
        error_count++;
    }

    // Kiểm tra tôn giáo
    if(error_count < Error_Max && ($('#tongiao').val() <= 0))
    {
        message += "<br> - Vui lòng chọn tôn giáo!";
        result = true;
        error_count++;
    }

    // Kiểm tra ngày vào đoàn
    if(error_count < Error_Max && (!isEmpty($("#ngayvaodoan").val())))
    {
        var date_vaodoan_temp = $("#ngayvaodoan").val().split("-");
        var date_vaodoan_value = new Date(date_vaodoan_temp[0], date_vaodoan_temp[1] - 1, date_vaodoan_temp[2]);

        var date_namsinh_temp = $("#namsinh").val().split("-");
        var date_namsinh_value = new Date(date_namsinh_temp[0], date_namsinh_temp[1] - 1, date_namsinh_temp[2]);
        
        if(error_count < Error_Max && (date_vaodoan_value > datecurent || date_vaodoan_value < date_namsinh_value ))
        {
            message += "<br> - Ngày vào đoàn không hợp lệ. Vui lòng nhập lại ngày vào đoàn!";
            result = true;
            error_count++;
        }
        else
        {
            if(error_count < Error_Max && (isEmpty($('#vaodoantai').val())))
            {
                message += "<br> - Vui lòng nhập nơi vào đoàn (vào đoàn tại)!";
                result = true;
                error_count++;
            }
        }
    }

    // Kiểm tra ngày vào đoàn
    if(error_count < Error_Max && (!isEmpty($("#ngayvaodang").val())))
    {
        var date_vaodang_temp = $("#ngayvaodang").val().split("-");
        var date_vaodang_value = new Date(date_vaodang_temp[0], date_vaodang_temp[1] - 1, date_vaodang_temp[2]);

        var date_namsinh_temp = $("#namsinh").val().split("-");
        var date_namsinh_value = new Date(date_namsinh_temp[0], date_namsinh_temp[1] - 1, date_namsinh_temp[2]);
        
        if(error_count < Error_Max && (date_vaodang_value > datecurent || date_vaodang_value < date_namsinh_value))
        {
            message += "<br> - Ngày vào đảng không hợp lệ. Vui lòng nhập lại ngày vào đảng!";
            result = true;
            error_count++;
        }
        else
        {
            if(error_count < Error_Max && (isEmpty($('#vaodangtai').val())))
            {
                message += "<br> - Vui lòng nhập nơi vào đảng (vào đảng tại)!";
                result = true;
                error_count++;
            }
        }
    }

    // alert($('.gioitinh:checked').val());
    if(result)
    {
        notificationInformationValidation(message);
        var scrollPos =  $(".divalert").offset().top;
        $(window).scrollTop(scrollPos);
    }
    return result;
}

var RegExp_dienthoai = new RegExp("^([ 0-9 \-]{10,})$");

function hasAlertInformationFamily() {
    // if(hasAlertInformationParent())
    // {
    //     return true;
    // }
    // else 
    // {
        if(hasAlertInformationSibling()) 
        {
            return true;
        }
        else
        {
            return false;
        }
    // }
}

function hasAlertInformationParent() {
    var error_count = 0;
    var Error_Max = 5;
    var result = false;
    var message ="";
    var yearcurent = parseInt(new Date().getFullYear());
    var MinOld = 30;
    var MaxOld = 120;
    
    /*
     * Kiểm tra thông tin cha
     */
    // Kiểm tra họ tên cha
    if(error_count < Error_Max && !isEmpty($('#cha_namsinh').val().trim()) || !isEmpty($('#cha_hokhauthuongtru').val().trim()) || !isEmpty($('#cha_nghenghiep').val().trim()) || !isEmpty($('#cha_dienthoai').val().trim()))
    {
        if(isEmpty($('#cha_hoten').val().trim()))
        {
            message = " - Vui lòng nhập họ tên cha!";
            result = true;
            error_count++;
        }
    }

    if(error_count < Error_Max && !isEmpty($('#cha_hoten').val().trim()))
    {

        // Kiểm tra năm sinh cha
        if(isEmpty($('#cha_namsinh').val().trim()))
        {
            message += "<br> - Vui lòng nhập năm sinh của cha!";
            result = true;
            error_count++;
        }
        else
        {
            // Kiểm tra năm sinh cha
            var date_temp = $("#cha_namsinh").val().split("/");
            var yearvalue = parseInt(date_temp[0]);

            if(yearcurent < yearvalue || (yearcurent - yearvalue) < MinOld || (yearcurent - yearvalue) > MaxOld)
            {
                message += "<br> - Ngày, tháng, năm sinh của cha không hợp lệ. Vui lòng nhập lại ngày, tháng, năm sinh của cha!";
                result = true;
                error_count++;
            }
        }

        // Kiểm tra dân tộc cha
        if(error_count < Error_Max && $('#cha_dantoc').val() < 1)
        {
            message += "<br> - Vui lòng chọn dân tộc của cha!";
            result = true;
            error_count++;
        }

        // Kiểm tra địa chỉ hộ khẩu thường trú của cha
        if(error_count < Error_Max && (isEmpty($('#cha_hokhauthuongtru').val().trim())))
        {
            message += "<br> - Vui lòng nhập hộ khẩu thường trú của cha!";
            result = true;
            error_count ++;
        }

        // Kiểm tra nghề nghiệp của cha
        if(error_count < Error_Max && (isEmpty($('#cha_nghenghiep').val().trim())))
        {
            message += "<br> - Vui lòng nhập nghề nghiệp của cha!";
            result = true;
            error_count++;
        }

        // Kiểm tra điện thoại của cha
        if(error_count < Error_Max && (isEmpty($('#cha_dienthoai').val().trim())))
        {
            message += "<br> - Vui lòng nhập điện thoại của cha!";
            result = true;
            error_count++;
        }
        else
        {
            var dienthoai = $('#cha_dienthoai').val();

            if(error_count < Error_Max && (!RegExp_dienthoai.test(dienthoai)))
            {
                message += "<br> - Vui lòng nhập điện thoại của cha đủ 10 hoặc 11 số (không chứa ký tự [a-z], chỉ chứa số [0-9] & khoảng trắng)!";
                result = true;
                error_count++;
            }
            else
            {
                // Kiểm tra số chữ số điện thoại của cha
                if(error_count < Error_Max && (!isEmpty($('#cha_dienthoai').val().trim())))
                {
                    if(($('#cha_dienthoai').val().trim().length < 10) || ($('#cha_dienthoai').val().trim().length > 11))
                    {
                        message += "<br> - Vui lòng nhập số điện thoại của cha đủ 10 hoặc 11 số!";
                        result = true;
                        error_count++;
                    }
                }
            }
        }
    }

    /*
     * Kiểm tra thông tin mẹ
     */
    // Kiểm tra họ tên mẹ
    if(error_count < Error_Max && (!isEmpty($('#me_namsinh').val().trim()) || !isEmpty($('#me_hokhauthuongtru').val().trim()) || !isEmpty($('#me_nghenghiep').val().trim()) || !isEmpty($('#me_dienthoai').val().trim())))
    {
        if(error_count < Error_Max && (isEmpty($('#me_hoten').val().trim())))
        {
            message = " - Vui lòng nhập họ tên mẹ!";
            result = true;
            error_count++;
        }
    }

    if(error_count < Error_Max && (!isEmpty($('#me_hoten').val().trim())))
    {

        // Kiểm tra năm sinh mẹ
        if(isEmpty($('#me_namsinh').val().trim()))
        {
            message += "<br> - Vui lòng nhập năm sinh của mẹ!";
            result = true;
            error_count++;
        }
        else
        {
            // Kiểm tra năm sinh mẹ
            var date_temp = $("#me_namsinh").val().split("/");
            var yearvalue = parseInt(date_temp[0]);

            if(error_count < Error_Max && (yearcurent < yearvalue || (yearcurent - yearvalue) < MinOld || (yearcurent - yearvalue) > MaxOld))
            {
                message += "<br> - Ngày, tháng, năm sinh của mẹ không hợp lệ. Vui lòng nhập lại ngày, tháng, năm sinh của mẹ!";
                result = true;
                error_count++;
            }
        }

        // Kiểm tra dân tộc mẹ
        if(error_count < Error_Max && ($('#me_dantoc').val() < 1))
        {
            message += "<br> - Vui lòng chọn dân tộc của mẹ!";
            result = true;
            error_count++;
        }

        // Kiểm tra địa chỉ hộ khẩu thường trú của mẹ
        if(error_count < Error_Max && (isEmpty($('#me_hokhauthuongtru').val().trim())))
        {
            message += "<br> - Vui lòng nhập hộ khẩu thường trú của mẹ!";
            result = true;
            error_count++;
        }

        // Kiểm tra nghề nghiệp của mẹ
        if(error_count < Error_Max && (isEmpty($('#me_nghenghiep').val().trim())))
        {
            message += "<br> - Vui lòng nhập nghề nghiệp của mẹ!";
            result = true;
            error_count++;
        }

        // Kiểm tra điện thoại của mẹ
        if(error_count < Error_Max && (isEmpty($('#me_dienthoai').val().trim())))
        {
            message += "<br> - Vui lòng nhập điện thoại của mẹ!";
            result = true;
            error_count++;
        }
        else
        {
            var dienthoai = $('#me_dienthoai').val();

            if(error_count < Error_Max && (!RegExp_dienthoai.test(dienthoai)))
            {
                message += "<br> - Vui lòng nhập điện thoại của mẹ đủ 10 hoặc 11 số (không chứa ký tự [a-z], chỉ chứa số [0-9] & khoảng trắng)!";
                result = true;
                error_count++;
            }
            else
            {
                // Kiểm tra số chữ số điện thoại của mẹ
                if(error_count < Error_Max && (!isEmpty($('#me_dienthoai').val().trim())))
                {
                    if(($('#me_dienthoai').val().trim().length < 10) || ($('#me_dienthoai').val().trim().length > 11))
                    {
                        message += "<br> - Vui lòng nhập số điện thoại của mẹ đủ 10 hoặc 11 số!";
                        result = true;
                        error_count++;
                    }
                }
            }
        }
    }

    if(result)
    {
        notificationInformationValidation(message);
        var scrollPos =  $(".divalert").offset().top;
        $(window).scrollTop(scrollPos);
    }
    return result;
}

function hasAlertInformationSibling() {
    // var dsanhchiem = [];
    var error_count = 0;
    var Error_Max = 5;
    var result = false;
    var message ="";
    var yearcurent = parseInt(new Date().getFullYear());
    var MinOld = 30;
    var MaxOld = 120;
    var row_count = 0;

    $("#tbody_anhchiem tr").each(function()
    {
        if((this.id != 0) && (!result))
        {
            row_count++;
            // Kiểm tra mối quan hệ
            if(error_count < Error_Max && ($("#anhchiem_sel_moiquanhe_" + this.id).val() <= 0))
            {
                message = " - Vui lòng chọn mối quan hệ Anh, Chị, Em ở dòng " + row_count + "!";
                result = true;
                error_count++;
            }

            // Kiểm tra họ tên
            if(error_count < Error_Max && (isEmpty($("#anhchiem_inp_hoten_" + this.id).val().trim())))
            {
                message += "<br> - Vui lòng nhập họ tên ở dòng " + row_count + "!";
                result = true;
                error_count++;
            }

            // Kiểm tra năm sinh
            if(error_count < Error_Max && (isEmpty($("#anhchiem_dat_namsinh_" + this.id).val())))
            {
                message += "<br> - Vui lòng nhập năm sinh ở dòng " + row_count + "!";
                result = true;
                error_count++;
            }

            // Kiểm tra nghề nghiệp
            if(error_count < Error_Max && (isEmpty($("#anhchiem_inp_nghenghiep_" + this.id).val())))
            {
                message += "<br> - Vui lòng nhập nghề nghiệp ở dòng " + row_count + "!";
                result = true;
                error_count++;
            }

            // Kiểm tra nơi ở
            if(error_count < Error_Max && (isEmpty($("#anhchiem_inp_noio_" + this.id).val())))
            {
                message += "<br> - Vui lòng nhập nơi ở ở dòng " + row_count + "!";
                result = true;
                error_count++;
            }
        }
    });

    if(result)
    {
        notificationInformationValidation(message);
        var scrollPos =  $(".divalert").offset().top;
        $(window).scrollTop(scrollPos);
    }
    return result;
}


// Thêm anh, chị, em ruột
var tr_row = 0;
$('.add-tr-anhchiem').click(function (e) {
    e.preventDefault();

    var sel_dantoc_tmp = $('#anhchiem_sel_moiquanhe_0').html();

    var newrow =    '<tr id="' + (++tr_row) + '">' +
                        '<td>' + 
                            '<select name="anhchiem_sel_moiquanhe[]" id="anhchiem_sel_moiquanhe_' + tr_row + '" class="form-control">' +
                            sel_dantoc_tmp +
                        '</td>' +
                        '<td>' +
                            '<input type="text" name="anhchiem_inp_hoten[]" id="anhchiem_inp_hoten_' + tr_row + '" class="form-control" placeholder="Họ và tên">' +
                        '</td>' +
                        '<td>' +
                            '<input type="date" name="anhchiem_dat_namsinh[]" id="anhchiem_dat_namsinh_' + tr_row + '" class="form-control">' +
                        '</td>' +
                        '<td>' +
                            '<input type="text" name="anhchiem_inp_nghenghiep[]" id="anhchiem_inp_nghenghiep_' + tr_row + '"  class="form-control" placeholder="Nghề nghiệp">' +
                        '</td>' +
                        '<td>' +
                            '<input type="text" name="anhchiem_inp_noio[]" id="anhchiem_inp_noio_' + tr_row + '"  class="form-control" placeholder="Nơi ở">' +
                        '</td>' +
                        '<td class="text-center">' +
                            '<button class="btn btn-warning btn-remove-row" title="Xóa"><i class="fa fa-remove"></i></button>' +
                        '</td>' +
                    '</tr>';

    $('#tbody_anhchiem').append(newrow);

    $(".btn-remove-row").click(function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        if(confirm("Bạn muốn xóa dòng này?"))
        {
            $(this).closest("tr").remove();  
        }
    });
});

$(".btn-remove-row").click(function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    if(confirm("Bạn muốn xóa dòng này?"))
    {
        $(this).closest("tr").remove();  
    }
});

$('input[id="cmnd"]').keyup(function(e)
{
    if (/\D/g.test(this.value))
    {
        // Filter non-digits from input value.
        this.value = this.value.replace(/\D/g, '');
    }
});

$('input.dienthoai').keyup(function(e)
{
    if (/\D/g.test(this.value))
    {
        // Filter non-digits from input value.
        this.value = this.value.replace(/\D/g, '');
    }
});

// Bắt sự kiện chọn ngành => Ajax lớp tương ứng
$('#nganh').on('change', function(){
    var nganh_id = parseInt($('#nganh').val());
    if(nganh_id === 0)
    {
        $('#lop').val(0);
        $('#lop').attr('disabled', 'true');
    }
    else
    {
        $('#lop').removeAttr('disabled');
        callAjaxGetValuForClass(nganh_id)
    }
});


/*
 *
 *  Hộ nghèo, hộ cận nghèo
 *
 */
$("#dienngheocanngheo_ngheo").change(function() {
    if(this.checked) {
        if($("#dienngheocanngheo_canngheo").is(':checked'))
        {
            $("#dienngheocanngheo_canngheo").prop("checked", false);
        }
    }
});

$("#dienngheocanngheo_canngheo").change(function() {
    if(this.checked) {
        if($("#dienngheocanngheo_ngheo").is(':checked'))
        {
            $("#dienngheocanngheo_ngheo").prop("checked", false);
        }
    }
});
/*
 *
 *  End Con thương binh, liệt sỹ
 *
 */

/*
 *
 *  Con thương binh, liệt sỹ
 *
 */
$("#conthuongbinhlietsy_lietsy").change(function() {
    if(this.checked) {
        if($("#conthuongbinhlietsy_thuongbinh").is(':checked'))
        {
            $("#conthuongbinhlietsy_thuongbinh").prop("checked", false);
        }
    }
});

$("#conthuongbinhlietsy_thuongbinh").change(function() {
    if(this.checked) {
        if($("#conthuongbinhlietsy_lietsy").is(':checked'))
        {
            $("#conthuongbinhlietsy_lietsy").prop("checked", false);
        }
    }
});
/*
 *
 *  End Con thương binh, liệt sỹ
 *
 */

 /*
 *
 *  Mồ côi cha
 *
 */
$("#dienmocoi_cha").change(function() {
    if(this.checked) {
        $('#divcha').attr('hidden', 'true');
    }
    else
    {
        $("#divcha").removeAttr('hidden');
    }
});

/*
 *
 *  Mồ côi mẹ
 *
 */
$("#dienmocoi_me").change(function() {
    if(this.checked) {
        $("#divme").attr('hidden', 'true');
    }
    else
    {
        $("#divme").removeAttr('hidden');
    }
});



// $('.btn_save').click(function (e) {
//     e.preventDefault();
//     var dsanhchiem = [];
//     $("#tbody_anhchiem tr").each(function()
//     {
//         if(this.id != 0)
//         {
//             alert($("#anhchiem_inp_hoten_" + this.id).val());
//             // alert(this>'input[type:"text"].hoten]').val();
//         }
//         // var item = [];
//         // item.push(
//         //     $("#"+this.id+"inptenthanhvien").val(),
//         //     $("#"+this.id+"selvaitro").val(),
//         //     $("#"+this.id+"inpgiochuan").val()
//         //     );
//         // dsthanhviengiochuan.push(item);
//     });
//     // return dsthanhviengiochuan;
// });
/**
 * --------- End Profile Sinh Vien ---------
 */
 