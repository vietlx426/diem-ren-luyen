var arrTinhID = new Array();
var arrHuyenID = new Array();
var arrXaID = new Array();
var arrKhoaHocID = new Array();
var arrKhoaID = new Array();

$('.btn_statical_filter').click(function(e){
    try{
        loadereffectshow();
        setTimeout(function(){
            getSinhVienTheoKhoaHocKhoaTinhHuyenXa();
        }, 10); 
    }catch(e){
        loadereffecthide();
    }
});

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

$('.khoahoc').click(function(e){
    try{
        loadereffectshow();
        var item = $(this).val();
        var index = arrKhoaHocID.indexOf(item);
        if (index !== -1) 
            arrKhoaHocID.splice(index, 1);
        else
            arrKhoaHocID.push($(this).val());
        loadereffecthide();
    }catch(e){}
});

$('.khoa').click(function(e){
    try{
        loadereffectshow();
        var item = $(this).val();
        var index = arrKhoaID.indexOf(item);
        if (index !== -1) 
            arrKhoaID.splice(index, 1);
        else
            arrKhoaID.push($(this).val());
        loadereffecthide();
    }catch(e){}
});

$('.tinh').click(function(e){
    try{
        loadereffectshow();
        var item = $(this).val();
        var index = arrTinhID.indexOf(item);
        if (index !== -1) 
            arrTinhID.splice(index, 1);
        else
            arrTinhID.push($(this).val());

        getHuyenTheoTinh();
        loadereffecthide();
    }catch(e){}
});

$('.huyen').click(function(e){
    try{
        loadereffectshow();
        var item = $(this).val();
        var index = arrHuyenID.indexOf(item);
        if (index !== -1) 
            arrHuyenID.splice(index, 1);
        else
            arrHuyenID.push($(this).val());
        getXaTheoHuyen();
        loadereffecthide();
    }catch(e){}
});

$('.lop').click(function(e){
    try{

        var item = $(this).val();
        var index = arrLopID.indexOf(item);
        if (index !== -1) 
            arrLopID.splice(index, 1);
        else
            arrLopID.push($(this).val());
    }catch(e){}
});

function getHuyenTheoTinh() {
    try
    {
        if(arrTinhID.length > 0)
        {
            var data = {'tinhID': arrTinhID};
            var dataAjaxResult = callAjax(urlRouteGetHuyenByTinh, "POST", data);
            showHuyen(dataAjaxResult);
            arrHuyenID=new Array();
            getXaTheoHuyen();
        }
        else{
            setHuyenNull();
        }
    }catch(e){}
}

function getXaTheoHuyen() {
    try
    {
        if(arrHuyenID.length > 0)
        {
            var data = {'huyenID': arrHuyenID};
            var dataAjaxResult = callAjax(urlRouteGetXaByHuyen, "POST", data);
            showXa(dataAjaxResult);
            // console.log("getXa: " + dataAjaxResult);
            arrXaID=new Array();
        }
        else
            setXaNull();
    }catch(e){}
}

function getDataKhoaHocKhoaTinhHuyenXa() {
    return {'khoaHoc' : arrKhoaHocID, 'khoa': arrKhoaID,'tinhID': arrTinhID, 'huyenID': arrHuyenID, 'xaID': arrXaID};
}

function getSinhVienTheoKhoaHocKhoaTinhHuyenXa() {
    try
    {
        var data = getDataKhoaHocKhoaTinhHuyenXa();
        var dataAjaxResult = callAjax(urlRouteGetStaticalByTinhHuyenXa, "POST", data);
        ShowChart(dataAjaxResult);
        ShowStaticalTable(dataAjaxResult);
        loadereffecthide();

    }catch(e){}
}

function ShowChart(dataAjaxResult) {
    try
    {
        $('#div_chart').show();
        var dataSinhVienTheoTinh = [ 
            ['Task', 'Hours per Day']
        ];
        var dataSinhVienTheoHuyen = [ 
            ['Task', 'Hours per Day']
        ];
        var dataSinhVienTheoXa = [ 
            ["Element", "Số lượng", { role: "style" }]
        ];

        $.each(dataAjaxResult.dsSinhVienTheoTinh, function(key, value){
            dataSinhVienTheoTinh.push([value.tentinh, parseInt(value.soluongsinhvien)]);
        });

        $.each(dataAjaxResult.dsSinhVienTheoHuyen, function(key, value){
            dataSinhVienTheoHuyen.push([value.tenhuyen, parseInt(value.soluongsinhvien)]);
        });

        $.each(dataAjaxResult.dsSinhVienTheoXa, function(key, value){
            dataSinhVienTheoXa.push([value.tenxa, parseInt(value.soluongsinhvien), '#'+(Math.random()*0xFFFFFF<<0).toString(16)]);
        });
        
        google.charts.load('current', {'packages':['bar', 'corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Draw char province
            var data_piechar_province = google.visualization.arrayToDataTable(dataSinhVienTheoTinh);
            var options_piechar_province = {
                title: "THỐNG KÊ SINH VIÊN THEO TỈNH",
                is3D: true,
            };
            var chart_piechar_province = new google.visualization.PieChart(document.getElementById('province_chart'));
            chart_piechar_province.draw(data_piechar_province, options_piechar_province);

            // Draw char district
            var data_piechar_district = google.visualization.arrayToDataTable(dataSinhVienTheoHuyen);

            var options_piechar_district = {
                title: "THỐNG KÊ SINH VIÊN THEO HUYỆN",
                is3D: true,
            };
            var chart_piechar_district = new google.visualization.PieChart(document.getElementById('district_chart'));
            chart_piechar_district.draw(data_piechar_district, options_piechar_district);


            var data_column_chart_town = google.visualization.arrayToDataTable(dataSinhVienTheoXa);
            var view = new google.visualization.DataView(data_column_chart_town);
            view.setColumns([0, 1,
                            { calc: "stringify",
                                sourceColumn: 1,
                                type: "string",
                                role: "annotation" },
                            2]);
            var options = {
                title: "THỐNG KÊ SINH VIÊN THEO XÃ",
                // bar: {groupWidth: "25%"},
                legend: { position: "none" }
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("town_chart"));
            chart.draw(view, options);
        }
    }catch(e){}
}

function ShowStaticalTable(dataAjaxResult) {
    try
    {
        $('.div_table').show();
        $('#table_statical_province').DataTable().clear();

        if(dataAjaxResult.dsSinhVienTheoTinh.length > 0)
        {
            var STT_Tinh = 0;
            $.each(dataAjaxResult.dsSinhVienTheoTinh, function(key, value){
                var row = [
                    '<td class="text-center">' + (++STT_Tinh) + '</td>',
                    value.tentinh,
                    '<td class="text-right"> <span class="badge bg-green"> ' + (value.soluongsinhvien) + ' </span> </td>'
                ];

                $('#table_statical_province').DataTable().row.add(row);
            });
            $('#table_statical_province').DataTable().draw();
        }

        $('#table_statical_district').DataTable().clear();
        if(dataAjaxResult.dsSinhVienTheoTinh.length > 0)
        {
            var STT_Huyen = 0;
            $.each(dataAjaxResult.dsSinhVienTheoHuyen, function(key, value){
                var row = [
                    '<td class="text-center">' + (++STT_Huyen) + '</td>',
                    value.tenhuyen,
                    '<td class="text-right"> <span class="badge bg-green"> ' + (value.soluongsinhvien) + ' </span> </td>'
                ];

                $('#table_statical_district').DataTable().row.add(row);
            });
            $('#table_statical_district').DataTable().draw();
        }

        $('#table_statical_town').DataTable().clear();
        if(dataAjaxResult.dsSinhVienTheoTinh.length > 0)
        {
            var STT_Xa = 0;
            $.each(dataAjaxResult.dsSinhVienTheoXa, function(key, value){
                var row = [
                    '<td class="text-center">' + (++STT_Xa) + '</td>',
                    value.tenxa,
                    '<td class="text-right"> <span class="badge bg-green"> ' + (value.soluongsinhvien) + ' </span> </td>'
                ];

                $('#table_statical_town').DataTable().row.add(row);
            });
            $('#table_statical_town').DataTable().draw();
        }
    }
    catch(e){}
}

function showHuyen(arrayHuyen) {
    $('#ul-huyen').html("");

    if(arrayHuyen.length > 0)
    {
        $.each(arrayHuyen, function(key, value){
            $('#ul-huyen').append('<li class="list-group-item huyen" value="' + value["id"] + '">' + value["tenhuyen"] + '</li>')
        });

        initListGroupCheckboxHuyen();

        $('.huyen').click(function(e){
            try{
                loadereffectshow();
                var item = $(this).val();
                var index = arrHuyenID.indexOf(item);
                if (index !== -1) 
                    arrHuyenID.splice(index, 1);
                else
                    arrHuyenID.push($(this).val());
                getXaTheoHuyen();
                loadereffecthide();
            }catch(e){}
        });
    }
}

function showXa(arrayXa) {
    $('#ul-xa').html("");

    if(arrayXa.length > 0)
    {
        $.each(arrayXa, function(key, value){
            $('#ul-xa').append('<li class="list-group-item xa" value="' + value["id"] + '">' + value["tenxa"] + ' </li>')
        });
    }

    // init();
    $('.xa').click(function(e){
        try{
            loadereffectshow();

            var item = $(this).val();
            var index = arrXaID.indexOf(item);
            if (index !== -1) 
                arrXaID.splice(index, 1);
            else
                arrXaID.push($(this).val());
            loadereffecthide();
        }catch(e){}
    });
    initListGroupCheckboxXa();
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

function initListGroupCheckboxHuyen() {
    $('#ul-huyen .list-group-item').each(function () {
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
            updateDisplayHuyen();
        });
        $checkbox.on('change', function () {
            updateDisplayHuyen();
        });

        // Actions
        function updateDisplayHuyen() {
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
        function initHuyen() {
            
            if ($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }
            
            updateDisplayHuyen();

            // Inject the icon if applicable
            if ($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span> ');
            }
        }
        initHuyen();
        });
}

function initListGroupCheckboxXa() {
    $('#ul-xa .list-group-item').each(function () {
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
            updateDisplayXa();
        });

        // Actions
        function updateDisplayXa() {
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
        function initXa() {
            
            if ($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }
            
            updateDisplayXa();

            // Inject the icon if applicable
            if ($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span> ');
            }
        }
        initXa();
        });
}