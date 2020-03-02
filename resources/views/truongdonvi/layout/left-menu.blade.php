<!-- left menu   -->
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
        <hr>
        <ul class="nav side-menu">
            <li><a href="{{route('truongdonvi')}}"><i class="fa fa-desktop"></i>DASHBOARD</a></li>
            <li>
                <a><i class="fa fa-bar-chart"></i>THỐNG KÊ-BÁO CÁO <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li> <a href="{{route('truongdonvisearchfilterindex')}}">ĐIỂM RÈN LUYỆN-HỌC TẬP</a></li>
                    <li> <a href="{{route('truongdonvi_statical_region')}}">ĐƠN VỊ HÀNH CHÍNH</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-edit"></i>TIÊU CHÍ-HOẠT ĐỘNG <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('truongdonvi_index_tieuchi')}}">TIÊU CHÍ</a></li>
                    <li><a href="{{route('truongdonvi_botieuchi_index')}}">BỘ TIÊU CHÍ</a></li>
                    <li><a href="{{route('truongdonvi_hockynamhocbotieuchi_index')}}">HỌC KỲ-TIÊU CHÍ</a></li>
                    <!-- <li><a href="{{route('admin_botieuchi_index')}}">HOẠT ĐỘNG-SỰ KIỆN</a></li> -->
                    <li><a href="{{route('truongdonvi_index_tieuchi_minhchung')}}">TIÊU CHÍ-MINH CHỨNG</a></li>
                </ul>
            </li>

            <li>
                <a><i class="fa fa-list-alt"></i>DANH SÁCH<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li title="Danh sách sinh viên"><a href="{{route('truongdonvi_sinhvien_timkiem')}}">SINH VIÊN</a></li>
                    <li title="Danh sách ban cán sự lớp"><a href="{{route('truongdonvi_bancansu')}}">BAN CÁN SỰ</a></li>
                    <li title="Danh sách cố vấn học tập"><a href="{{route('truongdonvi_covanhoctap')}}">CỐ VẤN HỌC TẬP</a></li>
                    <li title="Danh sách chuyên viên quản lý lớp"><a href="{{route('truongdonvi_chuyenvien')}}">CHUYÊN VIÊN QUẢN LÝ LỚP</a></li>
                </ul>
            </li>

            <!-- <li>
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
            </li> -->
        </div>
    </div>
    <!-- /sidebar menu -->
<!-- /left menu  