@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/auth.css') }}">
@endpush

<section class="auth-page" id="loginView">
    <div class="auth-shape">
        <img src="{{ asset('images/auth/shape1.png') }}" alt="Shape">
    </div>

    <div class="auth-container">
        <div class="auth-col-left">
            <div class="auth-illustration auth-anim-x auth-delay-10">
                <img src="{{ asset('images/auth/human-authenticate.png') }}" alt="">
            </div>

            <div class="auth-logo auth-anim-x auth-delay-3">
                <img src="{{ asset('images/logo/logo.jpg') }}" alt="Logo">
                <span>AlphaZone</span>
            </div>

            <div class="auth-anim-x auth-delay-5">
                <h1 class="auth-main-title">Đăng nhập vào AlphaZone</h1>
                <p class="auth-subtitle">Quản lý học viên và trung tâm đào tạo bóng đá</p>
            </div>
        </div>

        <div class="auth-col-right auth-fade-in">
            <div class="auth-form">
                @if ($errors->any())
                    <div class="auth-alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ safe_route('login') }}">
                    @csrf
                    <div class="auth-form-group">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                            placeholder="Nhập tên đăng nhập" autocomplete="username" autofocus>
                    </div>
                    <div class="auth-form-group">
                        <input type="password" name="password" id="authPassword" class="form-control"
                            placeholder="Nhập mật khẩu" autocomplete="current-password">
                        <i class="ri-eye-line auth-field-icon" id="authPasswordToggle"
                            role="button" tabindex="0" aria-label="Hiện/ẩn mật khẩu"></i>
                    </div>
                    <div class="auth-form-group">
                        <button type="submit" class="auth-btn-fill">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script src="{{ asset('js/pages/auth.js') }}"></script>
@endpush