<aside @class(['sidebar']) id="sidebar">
    <script>
        if (localStorage.getItem('sidebarCollapsed') === '1') {
            document.getElementById('sidebar').classList.add('sidebar--collapsed');
        }
    </script>

    <div class="sidebar-inner">
        <div @class(['sidebar-logo'])>
            <div @class(['logo-icon'])>
                <img src="{{ asset('images/logo/logo.jpg') }}" alt="Logo">
            </div>
            <div @class(['logo-text'])>
                Alpha<span>Zone</span>
            </div>
            <button type="button" class="sidebar-toggle-btn" id="sidebarToggleBtn" onclick="toggleSidebarCollapse()"
                title="Thu gọn / Mở rộng">
                <i class="ri-arrow-left-s-line"></i>
            </button>
        </div>

        <div @class(['sidebar-scroll'])>
            <div @class(['nav-label'])>Tổng quan</div>

            <a href="{{ route('dashboard') }}" @class(['nav-item', request()->routeIs('dashboard') ? 'active' : '']) data-view="dashboard">
                <i @class(['ri-dashboard-3-line'])></i> <span class="nav-text">Dashboard</span>
            </a>

            <div @class(['nav-label'])>Học viên</div>

            @if (hasQuyen('hocvien'))
                <a href="{{ route('hocvien.index') }}" @class(['nav-item', request()->routeIs('hocvien.*') ? 'active' : '']) data-view="students">
                    <i @class(['ri-group-line'])></i> <span class="nav-text">Danh sách Học viên</span>
                    <span @class(['nav-badge', 'green'])>{{ $countHocVien }}</span>
                </a>
            @endif

            @if (hasQuyen('diemdanh'))
                <a href="{{ route('diemdanh.index') }}" @class(['nav-item', request()->routeIs('diemdanh.*') ? 'active' : '']) data-view="attendance">
                    <i @class(['ri-calendar-check-line'])></i> <span class="nav-text">Điểm danh</span>
                </a>
            @endif

            @if (hasQuyen('hocphi'))
                <a href="{{ route('hocphi.index') }}" @class(['nav-item', request()->routeIs('hocphi.*') ? 'active' : '']) data-view="tuition">
                    <i @class(['ri-money-dollar-circle-line'])></i> <span class="nav-text">Học phí</span>
                    <span @class(['nav-badge', 'red'])>{{ $countHocVienChuaDongHocPhi }}</span>
                </a>
            @endif

            @if (hasQuyen('tiensan'))
                <a href="{{ safe_route('tiensan.index') }}"
                    class="nav-item {{ request()->routeIs('tiensan.*') ? 'active' : '' }}" data-view="tiensan">
                    <i class="ri-basketball-line"></i> <span class="nav-text">Tiền sân</span>
                </a>
            @endif

            @if (hasQuyen('trainghiem'))
                <a href="{{ route('trainghiem.index') }}" @class([
                    'nav-item',
                    request()->routeIs('trainghiem.*') ? 'active' : '',
                ]) data-view="trial">
                    <i @class(['ri-user-star-line'])></i> <span class="nav-text">Trải nghiệm</span>
                    <span @class(['nav-badge', 'green'])>{{ $countTraiNghiem }}</span>
                </a>
            @endif

            <div @class(['nav-label'])>Quản lý</div>

            @if (hasQuyen('coso'))
                <a href="{{ route('coso.index') }}" @class(['nav-item', request()->routeIs('coso.*') ? 'active' : '']) data-view="branches">
                    <i @class(['ri-building-4-line'])></i> <span class="nav-text">Quản lý Cơ sở</span>
                </a>
            @endif

            @if (hasQuyen('giaovien'))
                <a href="{{ route('giaovien.index') }}" @class(['nav-item', request()->routeIs('giaovien.*') ? 'active' : '']) data-view="teachers">
                    <i @class(['ri-user-voice-line'])></i> <span class="nav-text">Quản lý Giáo viên</span>
                </a>
            @endif

            @if (hasQuyen('giaoan'))
                <a href="{{ route('giaoan.menu') }}" @class(['nav-item', request()->routeIs('giaoan.*') ? 'active' : '']) data-view="giaoan">
                    <i @class(['ri-file-list-3-line'])></i> <span class="nav-text">Giáo án</span>
                </a>
            @endif

            <div @class(['nav-label'])>Chứng từ</div>

            @if (hasQuyen('bieumau'))
                <a href="{{ route('bieumau.menu') }}" @class(['nav-item', request()->routeIs('bieumau.*') ? 'active' : '']) data-view="bieumau">
                    <i @class(['ri-file-copy-2-line'])></i> <span class="nav-text">Biểu mẫu</span>
                </a>
            @endif

            @if (hasQuyen('hoadon'))
                <div @class(['nav-group', request()->routeIs('hoadon.*') ? 'open' : ''])>
                    <div @class(['nav-item', 'nav-group-toggle']) onclick="toggleNavGroup(this)">
                        <i @class(['ri-bill-line'])></i> <span class="nav-text">Hóa đơn</span>
                        <i @class(['ri-arrow-down-s-line', 'nav-group-arrow'])></i>
                    </div>
                    <div @class(['nav-submenu'])>
                        <a href="{{ route('hoadon.dauvao.menu') }}" @class([
                            'nav-item',
                            'nav-subitem',
                            request()->routeIs('hoadon.dauvao.*') ? 'active' : '',
                        ])
                            data-view="hoadon-dauvao">
                            <i @class(['ri-file-list-3-line'])></i> <span class="nav-text">Hóa đơn đầu vào</span>
                        </a>
                        <a href="{{ route('hoadon.daura.index') }}" @class([
                            'nav-item',
                            'nav-subitem',
                            request()->routeIs('hoadon.daura.*') ? 'active' : '',
                        ])
                            data-view="hoadon-daura">
                            <i @class(['ri-file-chart-2-line'])></i> <span class="nav-text">Hóa đơn đầu ra</span>
                        </a>
                    </div>
                </div>
            @endif

            @if (hasQuyen('chamcong'))
                <a href="{{ route('chamcong.index') }}" @class(['nav-item', request()->routeIs('chamcong.*') ? 'active' : '']) data-view="chamcong">
                    <i @class(['ri-calendar-check-line'])></i> <span class="nav-text">Chấm công</span>
                </a>
            @endif

            @if (hasQuyen('phieuluongnhanvien') || hasQuyen('phieuluongctv'))
                <div @class([
                    'nav-group',
                    request()->routeIs('phieuluongnhanvien.*') ||
                    request()->routeIs('phieuluongctv.*')
                        ? 'open'
                        : '',
                ])>
                    <div @class(['nav-item', 'nav-group-toggle']) onclick="toggleNavGroup(this)">
                        <i @class(['ri-file-paper-2-line'])></i> <span class="nav-text">Phiếu lương</span>
                        <i @class(['ri-arrow-down-s-line', 'nav-group-arrow'])></i>
                    </div>
                    <div @class(['nav-submenu'])>
                        @if (hasQuyen('phieuluongnhanvien'))
                            <a href="{{ route('phieuluongnhanvien.index') }}" @class([
                                'nav-item',
                                'nav-subitem',
                                request()->routeIs('phieuluongnhanvien.*') ? 'active' : '',
                            ])
                                data-view="phieuluongnhanvien">
                                <i @class(['ri-file-list-3-line'])></i> <span class="nav-text">PL Nhân viên chính
                                    thức</span>
                            </a>
                        @endif
                        @if (hasQuyen('phieuluongctv'))
                            <a href="{{ route('phieuluongctv.index') }}" @class([
                                'nav-item',
                                'nav-subitem',
                                request()->routeIs('phieuluongctv.*') ? 'active' : '',
                            ])
                                data-view="phieuluongctv">
                                <i @class(['ri-file-list-3-line'])></i> <span class="nav-text">PL Cộng tác viên</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <div @class(['nav-label'])>Cấu hình</div>

            @if (hasQuyen('caidathocphi') || hasQuyen('caidattienluong'))
                <div @class([
                    'nav-group',
                    request()->routeIs('caidathocphi.*') ||
                    request()->routeIs('caidattienluong.*')
                        ? 'open'
                        : '',
                ])>
                    <div @class(['nav-item', 'nav-group-toggle']) onclick="toggleNavGroup(this)">
                        <i @class(['ri-settings-3-line'])></i> <span class="nav-text">Cài đặt</span>
                        <i @class(['ri-arrow-down-s-line', 'nav-group-arrow'])></i>
                    </div>
                    <div @class(['nav-submenu'])>
                        @if (hasQuyen('caidathocphi'))
                            <a href="{{ route('caidathocphi.index') }}" @class([
                                'nav-item',
                                'nav-subitem',
                                request()->routeIs('caidathocphi.*') ? 'active' : '',
                            ])
                                data-view="caidathocphi">
                                <i @class(['ri-money-dollar-circle-line'])></i> <span class="nav-text">Tiền học phí</span>
                            </a>
                        @endif
                        @if (hasQuyen('caidattienluong'))
                            <a href="{{ route('caidattienluong.index') }}" @class([
                                'nav-item',
                                'nav-subitem',
                                request()->routeIs('caidattienluong.*') ? 'active' : '',
                            ])
                                data-view="caidattienluong">
                                <i @class(['ri-wallet-3-line'])></i> <span class="nav-text">Tiền lương</span>
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
                <i @class(['ri-lock-password-line'])></i> <span class="nav-text">Đổi mật khẩu</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <a href="#" @class(['nav-item']) id="logoutBtn"
                    onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                    <i @class(['ri-logout-box-r-line'])></i> <span class="nav-text">Đăng xuất</span>
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
    </div>
</aside>
