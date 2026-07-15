<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quá nhiều lượt thử - AlphaZone</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="login-wrap">
        <div class="login-card" style="text-align:center;">
            <div
                style="width:64px;height:64px;border-radius:50%;background:var(--orange-bg);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                <i class="ri-time-line" style="font-size:30px;color:var(--orange);"></i>
            </div>
            <div class="login-title">Bạn thao tác quá nhanh</div>
            <div class="login-sub" style="margin-bottom:22px;">
                Hệ thống tạm khoá đăng nhập trong ít phút để bảo vệ tài khoản khỏi bị dò mật khẩu.
                Vui lòng chờ khoảng 1 phút rồi thử lại.
            </div>
            <a href="{{ route('login') }}" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="ri-arrow-left-line"></i> Quay lại trang Đăng nhập
            </a>
        </div>
    </div>
</body>

</html>
