<!-- left menu   -->
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
        <hr>
        <ul class="nav side-menu">
            <li><a href="{{route('sinhvien')}}"><i class="fa fa-desktop"></i>DASHBOARD</a></li>
            <li> <a href="{{route('sinhvien_index_tieuchi_minhchung')}}"><i class="fa fa-edit"></i>TIÊU CHÍ - MINH CHỨNG</a> </li>
            <li> <a href="{{route('sinhvien_bangdiemrenluyen')}}"><i class="fa fa-list-alt"></i>KẾT QUẢ RÈN LUYỆN</a> </li>
            <li> <a href="{{route('sinhvien_hoatdongsukien')}}"><i class="fa fa-futbol-o"></i>HOẠT ĐỘNG - SỰ KIỆN</a> </li>
            <li> <a href="{{route('sinhvien_profile')}}"><i class="fa fa-file-text"></i>THÔNG TIN LÝ LỊCH</a> </li>
            <li> 
            <a><i class="fa fa-credit-card"></i>THÔNG TIN HỌC BỔNG<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{route('sinhvien.hocbong')}}">THÔNG BÁO - KẾT QUẢ NỘP HỒ SƠ</a></li>
                    <li><a href="{{route('sinhvien.ketqua.all')}}">KẾT QUẢ HỌC BỔNG TOÀN KHÓA HỌC</a></li>

                    
                </ul>
            </li>
        </div>
    </div>
    <!-- /sidebar menu -->
<!-- /left menu   -->