<div @class(['login-wrap']) id="loginView">
    <div @class(['login-card'])>
        <div @class(['login-logo'])>
            <div @class(['logo-icon'])><i @class(['ri-graduation-cap-fill'])></i></div>
            <div @class(['logo-text'])>Alpha<span>Zone</span></div>
        </div>
        <div @class(['login-title'])>Đăng nhập hệ thống</div>
        <div @class(['login-sub'])>Quản lý học viên &amp; trung tâm AlphaZone</div>

        @if ($errors->any())
            <div @class(['badge', 'red']) style="display:block;padding:10px 14px;margin-bottom:16px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ safe_route('login') }}">
            @csrf
            <div @class(['field'])>
                <label>Tài khoản</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nhập tài khoản" autofocus>
            </div>
            <div @class(['field'])>
                <label>Mật khẩu</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu">
            </div>
            <button type="submit" @class(['btn', 'btn-primary'])
                style="width:100%;justify-content:center;margin-top:6px;">
                <i @class(['ri-login-box-line'])></i> Đăng nhập
            </button>
        </form>
    </div>
</div>
