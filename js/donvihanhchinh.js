/*
 * --------- Đơn vị hành chính ---------
 */

function getToken() {
    return $('meta[name="csrf-token"]').attr('content');
}

function getHeaders() {
    return headers = {
            'X-CSRF-TOKEN': getToken()
        }
}

// Bắt sự kiện chọn tỉnh thường trú => Ajax huyện tương ứng
$('#tinh').on('change', function(e){
    var tinh_id = parseInt($('#tinh').val());
    if(tinh_id != 0)
    {
        url =  (($('#tinh').attr('url')) + "/" + tinh_id);
        var select_id = '#huyen';
        callAjaxGetValueForHuyen(url, select_id);
        setValueForXaNull('#xa');
    }
    else
    {
       e.preventDefault();
       e.stopImmediatePropagation();
    }
});

// Bắt sự kiện chọn huyện thường trú => Ajax xã tương ứng
$('#huyen').on('change', function(e){
    var huyen_id = parseInt($('#huyen').val());
    if(huyen_id != 0)
    {
        {
        url =  (($('#huyen').attr('url')) + "/" + huyen_id);
        var select_id = '#xa';
        callAjaxGetValueForXa(url, select_id);
        }
    }
    else
    {
        setValueForXaNull('#xa');
        e.preventDefault();
        e.stopImmediatePropagation();
    }
});

// Bắt sự kiện chọn tỉnh tạm trú => Ajax huyện tương ứng
$('#tinh_tamtru').on('change', function(e){
    var tinh_id = parseInt($('#tinh_tamtru').val());
    if(tinh_id != 0)
    {
        url =  (($('#tinh_tamtru').attr('url')) + "/" + tinh_id);
        var select_id = '#huyen_tamtru';
        callAjaxGetValueForHuyen(url, select_id);
        setValueForXaNull('#xa_tamtru');
    }
    else
    {
       e.preventDefault();
       e.stopImmediatePropagation();
    }
});

// Bắt sự kiện chọn huyện tạm trú => Ajax xã tương ứng
$('#huyen_tamtru').on('change', function(e){
    var huyen_id = parseInt($('#huyen_tamtru').val());
    if(huyen_id != 0)
    {
        {
        url =  (($('#huyen_tamtru').attr('url')) + "/" + huyen_id);
        var select_id = '#xa_tamtru';
        callAjaxGetValueForXa(url, select_id);
        }
    }
    else
    {
        setValueForXaNull('#xa_tamtru');
        e.preventDefault();
        e.stopImmediatePropagation();
    }
});

// Bắt sự kiện chọn tỉnh thường trú của cha => Ajax huyện tương ứng
$('#tinh_thuongtru_cha').on('change', function(e){
    var tinh_id = parseInt($('#tinh_thuongtru_cha').val());
    if(tinh_id != 0)
    {
        url =  (($('#tinh_thuongtru_cha').attr('url')) + "/" + tinh_id);
        var select_id = '#huyen_thuongtru_cha';
        callAjaxGetValueForHuyen(url, select_id);
        setValueForXaNull('#xa_thuongtru_cha');
    }
    else
    {
       e.preventDefault();
       e.stopImmediatePropagation();
    }
});

// Bắt sự kiện chọn huyện thường trú của cha => Ajax xã tương ứng
$('#huyen_thuongtru_cha').on('change', function(e){
    var huyen_id = parseInt($('#huyen_thuongtru_cha').val());
    if(huyen_id != 0)
    {
        {
        url =  (($('#huyen_thuongtru_cha').attr('url')) + "/" + huyen_id);
        var select_id = '#xa_thuongtru_cha';
        callAjaxGetValueForXa(url, select_id);
        }
    }
    else
    {
        setValueForXaNull('#xa_thuongtru_cha');
        e.preventDefault();
        e.stopImmediatePropagation();
    }
});

// Bắt sự kiện chọn tỉnh thường trú của mẹ => Ajax huyện tương ứng
$('#tinh_thuongtru_me').on('change', function(e){
    var tinh_id = parseInt($('#tinh_thuongtru_me').val());
    if(tinh_id != 0)
    {
        url =  (($('#tinh_thuongtru_me').attr('url')) + "/" + tinh_id);
        var select_id = '#huyen_thuongtru_me';
        callAjaxGetValueForHuyen(url, select_id);
        setValueForXaNull('#xa_thuongtru_me');
    }
    else
    {
       e.preventDefault();
       e.stopImmediatePropagation();
    }
});

// Bắt sự kiện chọn huyện thường trú của mẹ => Ajax xã tương ứng
$('#huyen_thuongtru_me').on('change', function(e){
    var huyen_id = parseInt($('#huyen_thuongtru_me').val());
    if(huyen_id != 0)
    {
        {
        url =  (($('#huyen_thuongtru_me').attr('url')) + "/" + huyen_id);
        var select_id = '#xa_thuongtru_me';
        callAjaxGetValueForXa(url, select_id);
        }
    }
    else
    {
        setValueForXaNull('#xa_thuongtru_me');
        e.preventDefault();
        e.stopImmediatePropagation();
    }
});

// get ajax Huyện
function callAjaxGetValueForHuyen(url, select_id) {
    
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
            var obj_option = '<option value="0">----- Chọn Quận - Huyện -----</option>'
            
            $.each( result.Data, function( key, value ) {
                obj_option += '<option value="' + value['id'] +'">' + value['tenhuyen'] + '</option>';

            });

            $(select_id).html(obj_option);

        }
        else
        {
            alert(result.Data);
        }
    })
    .fail(function(jqXHR, textStatus) {
      alert("Xử lý thất bại. Vui lòng refesh và thử lại sau.\n" + textStatus);
    });
}

// get ajax Xã
function callAjaxGetValueForXa(url, select_id) {
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
            var obj_option = '<option value="0">----- Chọn Xã - Phường -----</option>'
            
            $.each( result.Data, function( key, value ) {
                obj_option += '<option value="' + value['id'] +'">' + value['tenxa'] + '</option>';

            });

            $(select_id).html(obj_option);
        }
        else
        {
            alert(result.Data);
        }
    })
    .fail(function(jqXHR, textStatus) {
      alert("Xử lý thất bại. Vui lòng refesh và thử lại sau.\n" + textStatus);
    });
}

// Thiết lập Null nếu Không chọn Huyện hoặc chọn tỉnh khác.
function setValueForXaNull(select_id) {
    var obj_option = '<option value="0">----- Chọn Xã - Phường -----</option>'
    $(select_id).html(obj_option);
}

/**
 * --------- End Đơn vị hành chính ---------
 */
 