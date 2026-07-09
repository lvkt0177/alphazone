    <div class="topbar">
        <div class="topbar-right">
            <div class="topbar-avatar">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->ho_ten ?? 'Admin') }}&background=6C5DD3&color=fff&bold=true"
                    alt="">
                <div class="meta">
                    <div class="name">{{ auth()->user()->ho_ten ?? 'Quản trị viên' }}</div>
                    <div class="role">Admin</div>
                </div>
            </div>
        </div>
    </div>
