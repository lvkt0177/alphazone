    <div class="topbar">
        <div class="topbar-right">
            <div class="icon-btn"><i class="ri-notification-3-line"></i><span class="dot">5</span></div>
            <div class="icon-btn"><i class="ri-mail-line"></i></div>
            <div class="topbar-avatar">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->ho_ten ?? 'Admin') }}&background=6C5DD3&color=fff&bold=true"
                    alt="">
                <div class="meta">
                    <div class="name">{{ auth()->user()->ho_ten ?? 'Quản trị viên' }}</div>
                    <div class="role">Admin</div>
                </div>
                <i class="ri-arrow-down-s-line" style="color:var(--text-2)"></i>
            </div>
        </div>
    </div>
