<!-- left menu   -->
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
        <hr>
        <ul class="nav side-menu">
            <li><a href="{{route('admin')}}"><i class="fa fa-desktop"></i>DASHBOARD</a></li>
            <li>
                <a><i class="fa fa-bar-chart"></i>THỐNG KÊ-BÁO CÁO<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('adminsearchfilterindex')}}">ĐIỂM RÈN LUYỆN-HỌC TẬP</a></li>
                    <li><a href="{{route('adminstaticalregion')}}">ĐƠN VỊ HÀNH CHÍNH</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-edit"></i>RÈN LUYỆN<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('admin_exportbangdiemrenluyen_show')}}">DOWNLOAD</a></li>
                    <li><a href="{{route('admin_index_tieuchi')}}">TIÊU CHÍ</a></li>
                    <li><a href="{{route('admin_botieuchi_index')}}">BỘ TIÊU CHÍ</a></li>
                    <li><a href="{{route('admin_hockynamhocbotieuchi_index')}}">HỌC KỲ-TIÊU CHÍ</a></li>
                    <li><a href="{{route('admin_hoatdongsukien')}}">HOẠT ĐỘNG-SỰ KIỆN</a></li>
                    <li><a href="{{route('admin_index_tieuchi_minhchung')}}">TIÊU CHÍ-MINH CHỨNG</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-list-alt"></i>DANH SÁCH<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li title="Danh sách user/người dùng"><a href="{{route('user')}}">USER</a></li>
                    <li title="Danh sách sinh viên"><a href="{{route('admin_sinhvien_timkiem')}}">SINH VIÊN</a></li>
                    <li title="Danh sách ban cán sự lớp"><a href="{{route('admin_bancansu')}}">BAN CÁN SỰ</a></li>
                    <li title="Danh sách chuyên viên quản lý lớp"><a href="{{route('admin_expers')}}">CV QUẢN LÝ LỚP</a></li>
                    <li title="Danh sách cố vấn học tập"><a href="{{route('admin_covanhoctap')}}">CỐ VẤN HỌC TẬP</a></li>
                    <li title="Danh sách cán bộ - giảng viên"><a href="{{route('admin_canbogiangvien')}}">CÁN BỘ-GIẢNG VIÊN</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-list"></i>DANH MỤC<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('lop')}}">LỚP</a></li>
                    <li><a href="{{route('admin_khoahoc_index')}}">KHÓA</a></li>
                    <li><a href="{{route('nganh')}}">NGÀNH</a></li>
                    <li><a href="{{route('khoa')}}">KHOA-PHÒNG</a></li>
                    <li><a href="{{route('hocky')}}">HỌC KỲ</a></li>
                    <li><a href="{{route('namhoc')}}">NĂM HỌC</a></li>
                    <li><a href="{{route('hockynamhoc')}}">HỌC KỲ-NĂM HỌC</a></li>
                    <li><a href="{{route('dantoc')}}">DÂN TỘC</a></li>
                    <li><a href="{{route('tongiao')}}">TÔN GIÁO</a></li>
                    <li><a href="{{route('hedaotao')}}">HỆ ĐÀO TẠO</a></li>
                    <li><a href="{{route('bacdaotao')}}">BẬC ĐÀO TẠO</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-credit-card"></i>HÌNH THẺ<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('adminstudentpiccardhinhthe')}}">XUẤT THÔNG TIN</a></li>
                    <li><a href="{{route('adminstudentsearch_hinhthe')}}">TÌM KIẾM-CẬP NHẬT</a></li>
                </ul>
            </li>
            
            <li>
                <a><i class="fa fa-credit-card"></i>HỌC BỔNG<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('hocbong.dashboard')}}">Dashboard học bổng</a></li>
                    <li><a href="{{route('hocbong.thongbao')}}">Thông báo</a></li>
                    <li><a href="{{route('hocbong.index')}}">TÌM KIẾM - THỐNG KÊ</a></li>
                    <li><a href="{{route('hocbong.timkiem.sinhvien')}}">Trao học bổng</a></li>
                    
                </ul>
            </li>

            <li><a href="{{route('admin_import_template')}}"><i class="fa fa-download"></i> MẪU IMPORT</a></li>
        </div>
    </div>
    <!-- /sidebar menu -->
<!-- /left menu  