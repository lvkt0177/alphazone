<div class="breadcrumb">
    <a>Trang chủ</a> <i class="ri-arrow-right-s-line"></i> <a class="active">Đổi mật khẩu</a>
</div>
<div class="page-head">
    <div class="page-title">Quản lý Tài khoản Admin</div>
</div>

 @if ($errors->any())
    <div class="badge red" style="display:block;padding:10px 14px;margin-bottom:16px;margin-top:16px;">
        <ul style="margin:0;padding:0;list-style:none;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('cap-nhat-mat-khau') }}" method="POST" class="form-card">
    @csrf
    @method('POST')
    <div class="form-grid full">
        <div class="field">
            <label>Mật khẩu hiện tại</label>
            <input type="password" name="current_password" placeholder="Nhập mật khẩu hiện tại" required>
        </div>
        <div class="field">
            <label>Mật khẩu mới</label>
            <input type="password" name="new_password" placeholder="Nhập mật khẩu mới" required>
        </div>
        <div class="field">
            <label>Xác nhận mật khẩu mới</label>
            <input type="password" name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới" required>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="ri-save-line"></i> Lưu thay đổi
        </button>
        <a href="{{ route('doi-mat-khau') }}" class="btn btn-outline">Huỷ</a>
    </div>
</form>