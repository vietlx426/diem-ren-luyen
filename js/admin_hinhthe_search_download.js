var arrKhoaID = new Array();
var arrNganhID = new Array();
var arrLopID = new Array();

$('.student_filter').click(function(e){
    try{
        loadereffectshow();
        setTimeout(function(){
            getSinhVienByKhoaNganhLop();
        }, 10); 
    }catch(e){
        loadereffecthide();
    }
});

$('.subadmin_student_filter').click(function(e){
    try{
        loadereffectshow();
        setTimeout(function(){
            getSinhVienByKhoaNganhLop_Subadmin();
        }, 10); 
    }catch(e){
        loadereffecthide();
    }
});

$('.truongdonvi_student_filter').click(function(e){
    console.log("truongdonvi_student_filter click");
    try{
        loadereffectshow();
        setTimeout(function(){
            getSinhVienByKhoaNganhLop_TruongDonVi();
        }, 10); 
    }catch(e){
        loadereffecthide();
    }
});

$('.student_export').click(function(e){
    try{
        loadereffectshow();
        var data = getDataKhoaNganhLop();
        if(ValidateData())
        {
            var url = urlRoute_admin_getdshinhthebyloplopexport + "?" + $.param(data);
            window.location = url;
        }
        loadereffecthide();
    }catch(e){}

    e.preventDefault();
    e.stopImmediatePropagation();
});

$('.khoa').click(function(e){
    try{
        loadereffectshow();
        var item = $(this).val();
        var index = arrKhoaID.indexOf(item);
        if (index !== -1) 
        {
            arrKhoaID.splice(index, 1);
        }
        else
        {
            arrKhoaID.push($(this).val());
        }

        getNganhByKhoa();
        loadereffecthide();
    }catch(e){}
});

$('.nganh').click(function(e){
    try{
        loadereffectshow();
        var item = $(this).val();
        var index = arrNganhID.indexOf(item);
        if (index !== -1) 
        {
            arrNganhID.splice(index, 1);
        }
        else
        {
            arrNganhID.push($(this).val());
        }

        getLopByNganh();
        loadereffecthide();
    }catch(e){}
});

$('.lop').click(function(e){
    try{

        var item = $(this).val();
        var index = arrLopID.indexOf(item);
        if (index !== -1) 
        {
            arrLopID.splice(index, 1);
        }
        else
        {
            arrLopID.push($(this).val());
        }
    }catch(e){}
});

function ValidateData() {
    console.log("ValidateData");
    var numLopID = arrLopID.length;
    if(numLopID > 0)
        if(numLopID > 1)
            alert("Vui lòng, mỗi lần chỉ chọn 1 lớp");
        else
            return true;
    else
        alert("Vui lòng chọn lớp");

    return false;
}

function getNganhByKhoa() {
    try
    {
        if(arrKhoaID.length > 0)
        {
            var data = {'KhoaID': arrKhoaID};
            var dataAjaxResult = callAjax(urlRouteGetNganhByKhoa, "POST", data);
            showNganhList(dataAjaxResult);
            arrNganhID=new Array();
            getLopByNganh();
        }
        else{
            setNganhListNull();
        }
    }catch(e){}
}

function getLopByNganh() {
    try
    {
        if(arrNganhID.length > 0)
        {
            var data = {'NganhID': arrNganhID};
            var dataAjaxResult = callAjax(urlRouteGetLopByNganh, "POST", data);
            showLopList(dataAjaxResult);
            arrLopID=new Array();
        }
        else{
            setLopListNull();
        }
    }catch(e){}
}

function getDataKhoaNganhLop() {
    var mssv = $('#inpmssv').val();
    return {'KhoaID': arrKhoaID, 'NganhID': arrNganhID, 'LopID': arrLopID, 'MSSV': mssv};
}

function getSinhVienByKhoaNganhLop() {
    try
    {
        var data = getDataKhoaNganhLop();
        var dataAjaxResult = callAjax(urlRouteGetSinhVienByKhoaNganhLop, "POST", data);

        showSinhVienList(dataAjaxResult);
    }catch(e){}
}

function getSinhVienByKhoaNganhLop_Subadmin() {
    try
    {
        var data = getDataKhoaNganhLop();
        var dataAjaxResult = callAjax(urlRouteGetSinhVienByKhoaNganhLop, "POST", data);
        showSinhVienList_Subadmin(dataAjaxResult);
    }catch(e){}
}

function getSinhVienByKhoaNganhLop_TruongDonVi() {
    try
    {
        var data = getDataKhoaNganhLop();
        var dataAjaxResult = callAjax(urlRouteGetSinhVienByKhoaNganhLop, "POST", data);
        showSinhVienList_TruongDonVi(dataAjaxResult);
    }catch(e){}
}


function showNganhList(arrayNganh) {
    $('#ul-nganh').html("");

    if(arrayNganh.length > 0)
    {
        $.each(arrayNganh, function(key, value){
            $('#ul-nganh').append('<li class="list-group-item nganh" value="' + value["id"] + '">' + value["tennganh"] + ' (' + value["tenbac"] + ') </li>')
        });

        initListGroupCheckboxNganh();

        $('.nganh').click(function(e){
            try{
                loadereffectshow();

                var item = $(this).val();
                var index = arrNganhID.indexOf(item);
                if (index !== -1) 
                {
                    arrNganhID.splice(index, 1);
                }
                else
                {
                    arrNganhID.push($(this).val());
                }

                getLopByNganh();
                loadereffecthide();
            }catch(e){}
        });
    }
}

function showLopList(arrayLop) {
    $('#ul-lop').html("");

    if(arrayLop.length > 0)
    {
        $.each(arrayLop, function(key, value){
            $('#ul-lop').append('<li class="list-group-item lop" value="' + value["id"] + '">' + value["tenlop"] + ' </li>')
        });
    }

    // init();
    $('.lop').click(function(e){
        try{
            // loadereffectshow();

            var item = $(this).val();
            var index = arrLopID.indexOf(item);
            if (index !== -1) 
            {
                arrLopID.splice(index, 1);
            }
            else
            {
                arrLopID.push($(this).val());
            }
            // loadereffecthide();
        }catch(e){}
    });
    initListGroupCheckboxLop();
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
                    value.tennganh,
                    value.tenkhoa,
                    '<a target="_blank" href="' + urlRouteGetSinhVienCapNhat + '/' + value.id + '" class="btn btn-warning"><i class="fa fa-info-circle"></i></a> <a href="' + urlRouteSinhVienDestroy + '/' + value.id + '" class="btn btn-danger sinhvien_remove" Ten="' + value.hochulot + " " + value.ten + '"><i class="fa fa-remove"></i></a> '
                ];

                $('#table-studentListResult').DataTable().row.add(row);
            });
            $('#table-studentListResult').DataTable().draw();

            loadereffecthide();
        }

        $('.sinhvien_remove').click(function (e) {
            e.preventDefault();
            if(confirm("Bạn có chắc là muốn xóa sinh viên " + $(this).attr("Ten") + "?"))
            {
                console.log($(this).attr("href"));
                var resultAjax = callAjax($(this).attr("href"), "GET");
                alert(resultAjax['message']);
                if(resultAjax['result'] == true)
                    $(this).closest("tr").remove(); 
            }
        });
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

function showSinhVienList_TruongDonVi(arraySinhVien) {
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
                  '<a target="_blank" href="' + urlRoute_truongdonvi_sinhvien_show + '/' + value.id + '" class="btn btn-info"><i class="fa fa-info-circle"></i></a>'
                ];
                $('#table-studentListResult').DataTable().row.add(row);
            });
            $('#table-studentListResult').DataTable().draw();
            loadereffecthide();
        }
        loadereffecthide();
    }
    catch(e){}
}

function setNganhListNull() {
    $('#ul-nganh').html("");
}

function setLopListNull() {
    $('#ul-lop').html("");
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

function initListGroupCheckboxNganh() {
    $('#ul-nganh .list-group-item').each(function () {
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
            updateDisplayNganh();
        });
        $checkbox.on('change', function () {
            updateDisplayNganh();
        });

        // Actions
        function updateDisplayNganh() {
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
        function initNganh() {
            
            if ($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }
            
            updateDisplayNganh();

            // Inject the icon if applicable
            if ($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span> ');
            }
        }
        initNganh();
        });
}

function initListGroupCheckboxLop() {
    $('#ul-lop .list-group-item').each(function () {
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
            updateDisplayLop();
        });

        // Actions
        function updateDisplayLop() {
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
        function initLop() {
            
            if ($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }
            
            updateDisplayLop();

            // Inject the icon if applicable
            if ($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span> ');
            }
        }
        initLop();
        });
}