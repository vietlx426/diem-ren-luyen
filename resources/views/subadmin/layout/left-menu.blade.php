<!-- left menu   -->
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
        <hr>
        <ul class="nav side-menu">
            <li><a href="{{route('subadmin')}}"><i class="fa fa-desktop"></i>DASHBOARD</a></li>
            <li><a href="{{route('subadminsearchfilterindex')}}"><i class="fa fa-search"></i>TÌM KIẾM-THỐNG KÊ</a></li>

            <li> <a href="{{route('hoatdongsukien')}}"><i class="fa fa-futbol-o"></i>HOẠT ĐỘNG-SỰ KIỆN</a> </li>

            <li>
                <a><i class="fa fa-edit"></i>ĐIỂM RÈN LUYỆN<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('subadmin_bangdiemrenluyen_hockynamhoc')}}">KẾT QUẢ ĐRL</a></li>
                    <li><a href="{{route('subadmin_index_tieuchi_minhchung')}}">TIÊU CHÍ-MINH CHỨNG</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-list"></i>DANH SÁCH<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('subadmin_sinhvien')}}">SINH VIÊN</a></li>
                    <li><a href="{{route('subadmin_bancansu')}}">BAN CÁN SỰ</a></li>
                    <li><a href="{{route('subadmin_covanhoctap')}}">CỐ VẤN HỌC TẬP</a></li>
                    <li><a href="{{route('subadmin_giaovukhoa')}}">GIÁO VỤ KHOA</a></li>
                    <li><a href="{{route('subadmin_canbogiangvien')}}">CÁN BỘ - GIẢNG VIÊN</a></li>
                    <li><a href="{{route('subadmin_lop')}}">LỚP HỌC</a></li>
                    <li><a href="{{route('subadmin_khoa')}}">KHOA - PHÒNG</a></li>
                    <li><a href="{{route('subadmin_nganhhoc')}}">NGÀNH ĐÀO TẠO</a></li>
                </ul>
            </li>

        </div>
    </div>
    <!-- /sidebar menu -->
<!-- /left menu   -->