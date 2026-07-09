<aside @class(['sidebar']) id="sidebar">
    <div @class(['sidebar-logo'])>
        <div @class(['logo-icon'])>
            <i @class(['ri-graduation-cap-fill'])></i>
        </div>
        <div @class(['logo-text'])>
            Alpha<span>Zone</span>
        </div>
    </div>

    <div @class(['sidebar-scroll'])>
        <div @class(['nav-label'])>Tổng quan</div>

        <a href="{{ route('dashboard') }}" @class(['nav-item', request()->routeIs('dashboard') ? 'active' : '']) data-view="dashboard">
            <i @class(['ri-dashboard-3-line'])></i> Dashboard
        </a>

        <div @class(['nav-label'])>Học viên</div>

        <a href="{{ route('hocvien.index') }}" @class(['nav-item', request()->routeIs('hocvien.*') ? 'active' : '']) data-view="students">
            <i @class(['ri-group-line'])></i> Danh sách Học viên
            <span @class(['nav-badge', 'green'])>{{ $countHocVien }}</span>
        </a>

        <a href="" @class(['nav-item', request()->routeIs('attendance.*') ? 'active' : '', ]) data-view="attendance">
            <i @class(['ri-calendar-check-line'])></i> Điểm danh
        </a>

        <a href="" @class(['nav-item', request()->routeIs('tuition.*') ? 'active' : '']) data-view="tuition">
            <i @class(['ri-money-dollar-circle-line'])></i> Học phí
            <span @class(['nav-badge'])>3</span>
        </a>

        <a href="{{ route('trainghiem.index') }}" @class(['nav-item', request()->routeIs('trainghiem.*') ? 'active' : '']) data-view="trial">
            <i @class(['ri-user-star-line'])></i> Trải nghiệm
            <span @class(['nav-badge', 'green'])>{{ $countTraiNghiem }}</span>
        </a>

        <div @class(['nav-label'])>Quản lý</div>

        <a href="{{ route('coso.index') }}" @class(['nav-item', request()->routeIs('coso.*') ? 'active' : '']) data-view="branches">
            <i @class(['ri-building-4-line'])></i> Quản lý Cơ sở
        </a>

        <a href="{{ route('giaovien.index') }}" @class(['nav-item', request()->routeIs('giaovien.*') ? 'active' : '']) data-view="teachers">
            <i @class(['ri-user-voice-line'])></i> Quản lý Giáo viên
        </a>

        <a href="" @class(['nav-item', request()->routeIs('stats.*') ? 'active' : '']) data-view="stats">
            <i @class(['ri-bar-chart-2-line'])></i> Thống kê
        </a>

        <div @class(['nav-label'])>Tài khoản</div>

        <a href="{{ route('doi-mat-khau') }}" @class(['nav-item', request()->routeIs('doi-mat-khau') ? 'active' : '']) data-view="account">
            <i @class(['ri-lock-password-line'])></i> Đổi mật khẩu
        </a>

        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
            @csrf
            <a href="#" @class(['nav-item']) id="logoutBtn"
                onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                <i @class(['ri-logout-box-r-line'])></i> Đăng xuất
            </a>
        </form>
    </div>

    <div @class(['sidebar-user'])>
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->ho_ten ?? 'Admin') }}&background=6C5DD3&color=fff&bold=true"
            alt="">
        <div>
            <div @class(['name'])>{{ auth()->user()->ho_ten ?? 'Quản trị viên' }}</div>
            <div @class(['role'])>Admin</div>
        </div>
    </div>
</aside>
