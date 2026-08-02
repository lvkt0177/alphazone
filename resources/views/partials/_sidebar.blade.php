<aside @class(['sidebar']) id="sidebar">
    <div @class(['sidebar-logo'])>
        <div @class(['logo-icon'])>
            <img src="{{ asset('images/logo/logo.jpg') }}" alt="Logo">
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

        @if (hasQuyen('hocvien'))
            <a href="{{ route('hocvien.index') }}" @class(['nav-item', request()->routeIs('hocvien.*') ? 'active' : '']) data-view="students">
                <i @class(['ri-group-line'])></i> Danh sách Học viên
                <span @class(['nav-badge', 'green'])>{{ $countHocVien }}</span>
            </a>
        @endif

        @if (hasQuyen('diemdanh'))
            <a href="{{ route('diemdanh.index') }}" @class(['nav-item', request()->routeIs('diemdanh.*') ? 'active' : '']) data-view="attendance">
                <i @class(['ri-calendar-check-line'])></i> Điểm danh
            </a>
        @endif

        @if (hasQuyen('hocphi'))
            <a href="{{ route('hocphi.index') }}" @class(['nav-item', request()->routeIs('hocphi.*') ? 'active' : '']) data-view="tuition">
                <i @class(['ri-money-dollar-circle-line'])></i> Học phí
                <span @class(['nav-badge', 'red'])>{{ $countHocVienChuaDongHocPhi }}</span>
            </a>
        @endif

        @if (hasQuyen('tiensan'))
            <a href="{{ safe_route('tiensan.index') }}"
                class="nav-item {{ request()->routeIs('tiensan.*') ? 'active' : '' }}" data-view="tiensan">
                <i class="ri-basketball-line"></i> Tiền sân
            </a>
        @endif

        @if (hasQuyen('trainghiem'))
            <a href="{{ route('trainghiem.index') }}" @class([
                'nav-item',
                request()->routeIs('trainghiem.*') ? 'active' : '',
            ]) data-view="trial">
                <i @class(['ri-user-star-line'])></i> Trải nghiệm
                <span @class(['nav-badge', 'green'])>{{ $countTraiNghiem }}</span>
            </a>
        @endif

        <div @class(['nav-label'])>Quản lý</div>

        @if (hasQuyen('coso'))
            <a href="{{ route('coso.index') }}" @class(['nav-item', request()->routeIs('coso.*') ? 'active' : '']) data-view="branches">
                <i @class(['ri-building-4-line'])></i> Quản lý Cơ sở
            </a>
        @endif

        @if (hasQuyen('giaovien'))
            <a href="{{ route('giaovien.index') }}" @class(['nav-item', request()->routeIs('giaovien.*') ? 'active' : '']) data-view="teachers">
                <i @class(['ri-user-voice-line'])></i> Quản lý Giáo viên
            </a>
        @endif

        @if (hasQuyen('giaoan'))
            <a href="{{ route('giaoan.menu') }}" @class(['nav-item', request()->routeIs('giaoan.*') ? 'active' : '']) data-view="giaoan">
                <i @class(['ri-file-list-3-line'])></i> Giáo án
            </a>
        @endif

        <div @class(['nav-label'])>Chứng từ</div>

        @if (hasQuyen('bieumau'))
            <a href="{{ route('bieumau.menu') }}" @class(['nav-item', request()->routeIs('bieumau.*') ? 'active' : '']) data-view="bieumau">
                <i @class(['ri-file-copy-2-line'])></i> Biểu mẫu
            </a>
        @endif

        {{-- <a href="" @class(['nav-item', request()->routeIs('stats.*') ? 'active' : '']) data-view="stats">
            <i @class(['ri-bar-chart-2-line'])></i> Thống kê
        </a> --}}

        @if (hasQuyen('chamcong'))
            <div @class([
                'nav-group',
                request()->routeIs('chamcong.*') ? 'open' : '',
            ])>
                <div @class(['nav-item', 'nav-group-toggle']) onclick="toggleNavGroup(this)">
                    <i @class(['ri-calendar-check-line'])></i> Chấm công
                    <i @class(['ri-arrow-down-s-line', 'nav-group-arrow'])></i>
                </div>
                <div @class(['nav-submenu'])>
                    <a href="{{ route('chamcong.thay') }}" @class([
                        'nav-item',
                        'nav-subitem',
                        request()->routeIs('chamcong.thay*') ? 'active' : '',
                    ]) data-view="chamcong-thay">
                        <i @class(['ri-graduation-cap-line'])></i> Thầy phụ trách
                    </a>
                    <a href="{{ route('chamcong.ctv') }}" @class([
                        'nav-item',
                        'nav-subitem',
                        request()->routeIs('chamcong.ctv*') ? 'active' : '',
                    ]) data-view="chamcong-ctv">
                        <i @class(['ri-user-follow-line'])></i> Cộng tác viên
                    </a>
                </div>
            </div>
        @endif

        @if (hasQuyen('caidathocphi') || hasQuyen('caidattienluong'))
            <div @class([
                'nav-group',
                request()->routeIs('caidathocphi.*') || request()->routeIs('caidattienluong.*') ? 'open' : '',
            ])>
                <div @class(['nav-item', 'nav-group-toggle']) onclick="toggleNavGroup(this)">
                    <i @class(['ri-settings-3-line'])></i> Cài đặt
                    <i @class(['ri-arrow-down-s-line', 'nav-group-arrow'])></i>
                </div>
                <div @class(['nav-submenu'])>
                    @if (hasQuyen('caidathocphi'))
                        <a href="{{ route('caidathocphi.index') }}" @class([
                            'nav-item',
                            'nav-subitem',
                            request()->routeIs('caidathocphi.*') ? 'active' : '',
                        ]) data-view="caidathocphi">
                            <i @class(['ri-money-dollar-circle-line'])></i> Tiền học phí
                        </a>
                    @endif
                    @if (hasQuyen('caidattienluong'))
                        <a href="{{ route('caidattienluong.index') }}" @class([
                            'nav-item',
                            'nav-subitem',
                            request()->routeIs('caidattienluong.*') ? 'active' : '',
                        ]) data-view="caidattienluong">
                            <i @class(['ri-wallet-3-line'])></i> Tiền lương
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <div @class(['nav-label'])>Tài khoản</div>

        <a href="{{ route('doi-mat-khau') }}" @class([
            'nav-item',
            request()->routeIs('doi-mat-khau') ? 'active' : '',
        ]) data-view="account">
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
            <div @class(['role'])>{{ auth()->user()?->role?->getLabel() ?? 'Quản trị viên' }}</div>
        </div>
    </div>
</aside>