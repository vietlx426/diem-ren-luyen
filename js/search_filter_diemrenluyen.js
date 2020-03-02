var arrHocKyNamHocID = new Array();
var arrDiemHocTap = new Array();
var arrDiemRenLuyen = new Array();
var arrThuocDien = new Array();

$('.btn_search_filter').click(function(e){
    try{
        loadereffectshow();
        if(ValidateData())
        {
            setTimeout(function(){
                var data = GetData();
                var dataAjaxResult = callAjax(urlRouteSearchFilterDiemRenLuyen, "POST", data);
                showSinhVienList(dataAjaxResult);
            }, 10);
        }
        else
        {
            loadereffecthide();
        }
    }catch(e){
        // loadereffecthide();
    }
    // loadereffecthide();
});

function ValidateData() {
    var result = true;
    var messages = "";
    if(arrHocKyNamHocID.length <= 0)
    {
        result = false;
        messages += "\n - Vui lòng chọn học kỳ";
    }
    if(isEmpty($('#renluyendieukien1').val()) && isEmpty($('#renluyendieukien2').val()))
    {
        result = false;
        messages += "\n - Thiết lập điều kiện điểm rèn luyện để lọc";
    }
    if(!isEmpty($('#renluyendieukien1').val()))
    {
        if(isEmpty($('#renluyendieukien1value').val()))
        {
            result = false;
            messages += "\n - Thiết lập giá trị cho điều kiện 1 điểm rèn luyện";
        }
        else
            if(parseFloat($('#renluyendieukien1value').val()) < 0 || parseFloat($('#renluyendieukien1value').val()) > 100)
            {
                result = false;
                messages += "\n - Điều kiện điểm rèn luyện không được nhỏ hơn 0 và lớn hơn 100";
            }
    }
    if(!isEmpty($('#renluyendieukien2').val()))
    {
        if(isEmpty($('#renluyendieukien2value').val()))
        {
            result = false;
            messages += "\n - Thiết lập giá trị cho điều kiện 2 điểm rèn luyện";
        }
        else
            if(parseFloat($('#renluyendieukien2value').val()) < 0 || parseFloat($('#renluyendieukien2value').val()) > 100)
            {
                result = false;
                messages += "\n - Điều kiện điểm rèn luyện không được nhỏ hơn 0 và lớn hơn 100";
            }
    }
    if(!result)
        alert(messages);
    return result;
}

$('.student_export').click(function(e){
    try{
        loadereffectshow();
        var data = getDataKhoaNganhLop();
        var url = urlRouteGetSinhVienByKhoaNganhLopExport + "?" + $.param(data);
        window.location = url;
        loadereffecthide();
    }catch(e){}

    e.preventDefault();
    e.stopImmediatePropagation();
});

$('#hoctapdieukien1').change(function(e){
    if($(this).val() == "")
        $('#hoctapdieukien1value').attr('disabled', "true");
    else
        $('#hoctapdieukien1value').removeAttr('disabled');
});
$('#hoctapdieukien2').change(function(e){
    if($(this).val() == "")
        $('#hoctapdieukien2value').attr('disabled', "true");
    else
        $('#hoctapdieukien2value').removeAttr('disabled');
});

$('#renluyendieukien1').change(function(e){
    if($(this).val() == "")
        $('#renluyendieukien1value').attr('disabled', "true");
    else
        $('#renluyendieukien1value').removeAttr('disabled');
});
$('#renluyendieukien2').change(function(e){
    if($(this).val() == "")
        $('#renluyendieukien2value').attr('disabled', "true");
    else
        $('#renluyendieukien2value').removeAttr('disabled');
});

$('.hockynamhoc').click(function(e){
    try{
        loadereffectshow();
        var item = $(this).val();
        var index = arrHocKyNamHocID.indexOf(item);
        if (index !== -1) 
        {
            arrHocKyNamHocID.splice(index, 1);
        }
        else
        {
            arrHocKyNamHocID.push($(this).val());
        }
        loadereffecthide();
    }catch(e){}
});

function GetData() {
    var ht = ({'hoctapdieukien1':$('#hoctapdieukien1').val(), 'hoctapdieukien1value':$('#hoctapdieukien1value').val(), 'hoctapdieukien2':$('#hoctapdieukien2').val(), 'hoctapdieukien2value':$('#hoctapdieukien2value').val()});
    var rl = ({'renluyendieukien1':$('#renluyendieukien1').val(), 'renluyendieukien1value':$('#renluyendieukien1value').val(), 'renluyendieukien2':$('#renluyendieukien2').val(), 'renluyendieukien2value':$('#renluyendieukien2value').val()});
    return {'HocKyNamHocID': arrHocKyNamHocID, 'HocTap': ht, 'RenLuyen': rl};
}

function showSinhVienList(arraySinhVien) {
    try
    {
        $('#table-studentListResult').DataTable().clear();
        if(arraySinhVien.length > 0)
        {
            $.each(arraySinhVien, function(key, value){
                var row = [
                    value.mssv,
                    value.hochulot + " " + value.ten,
                    value.tenlop,
                    value.tenkhoa,
                    value.tongdiem,
                    value.diemhoctap
                ];
                $('#table-studentListResult').DataTable().row.add(row);
            });
            // $('#table-studentListResult').DataTable().draw();
        }
        else
            $('#tbody_studentListResult').html('<tr><td colspan="6>Không tìm thấy</td></tr>');
        $('#table-studentListResult').DataTable().draw();
        loadereffecthide();
    }
    catch(e){}
}

function showSinhVienList_Subadmin(arraySinhVien) {
    try
    {
        $('#table-studentListResult').DataTable().clear();

        if(arraySinhVien.length > 0)
        {
            $.each(arraySinhVien, function(key, value){

                var row = [
                    value.mssv,
                    value.hochulot + " " + value.ten,
                    value.tenlop,
                    value.tennganh,
                    value.tenkhoa,
                    '<a target="_blank" href="' + urlRoute_subadmin_sinhvien_show + '/' + value.id + '" class="btn btn-info"><i class="fa fa-info-circle"></i></a>'
                ];

                $('#table-studentListResult').DataTable().row.add(row);
            });
            $('#table-studentListResult').DataTable().draw();
            loadereffecthide();
        }

        $('.sinhvien_remove').click(function (e) {
            e.preventDefault();
            if(confirm("Bạn có chắc là muốn xóa sinh viên " + $(this).attr("Ten") + "?"))
                alert(callAjax($(this).attr("href"), "GET"));
        });
        loadereffecthide();

    }
    catch(e){}
}


$('.list-group.checked-list-box .list-group-item').each(function () {
    // Settings
    var $widget = $(this),
        $checkbox = $('<input type="checkbox" class="hidden" />'),
        color = ($widget.data('color') ? $widget.data('color') : "primary"),
        style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),
        settings = {
            on: {
                icon: 'glyphicon glyphicon-check'
            },
            off: {
                icon: 'glyphicon glyphicon-unchecked'
            }
        };
        
    $widget.css('cursor', 'pointer')
    $widget.append($checkbox);

    // Event Handlers
    $widget.on('click', function () {
        $checkbox.prop('checked', !$checkbox.is(':checked'));
        $checkbox.triggerHandler('change');
        updateDisplay();
    });
    $checkbox.on('change', function () {
        updateDisplay();
    });

    // Actions
    function updateDisplay() {
        var isChecked = $checkbox.is(':checked');

        // Set the button's state
        $widget.data('state', (isChecked) ? "on" : "off");

        // Set the button's icon
        $widget.find('.state-icon')
            .removeClass()
            .addClass('state-icon ' + settings[$widget.data('state')].icon);

        // Update the button's color
        if (isChecked) {
            $widget.addClass(style + color + ' active');
        } else {
            $widget.removeClass(style + color + ' active');
        }
    }

    // Initialization
    function init() {
        
        if ($widget.data('checked') == true) {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
        }
        
        updateDisplay();

        // Inject the icon if applicable
        if ($widget.find('.state-icon').length == 0) {
            $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span> ');
        }
    }
    init();
});