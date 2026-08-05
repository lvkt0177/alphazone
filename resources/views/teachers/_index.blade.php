<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Quản lý Giáo viên</a>
</div>
<div class="page-head">
    <div class="page-title">Quản lý Giáo viên</div>
    @if (hasQuyen('giaovien', 'them'))
        <button class="btn btn-primary" onclick="openTeacherModal()"><i class="ri-add-line"></i> Tạo Giáo viên</button>
    @endif
</div>

@if (session('error'))
    <div class="badge red teacher-alert-error">{{ session('error') }}</div>
@endif

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th class="w-px-300">Họ tên</th>
                <th>Mã nhân viên</th>
                <th>Ngày sinh</th>
                <th>Số điện thoại</th>
                <th>Chức danh</th>
                <th class="w-px-300">Cơ sở phụ trách</th>
                <th>Tài khoản</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($giaoViens as $gv)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="cell-user">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($gv->ho_ten) }}&background=2563EB&color=fff&bold=true"
                                alt="">
                            <div class="name">{{ $gv->ho_ten }}</div>
                        </div>
                    </td>
                    <td>{{ $gv->ma_nhan_vien ?? '—' }}</td>
                    <td>{{ $gv->ngay_sinh?->format('d/m/Y') ?? '—' }}</td>
                    <td>{{ $gv->sdt ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $gv->chuc_danh->getBadge() }}">{{ $gv->chuc_danh->getLabel() }}</span>
                    </td>
                    <td>
                        @forelse($gv->coSos as $coSo)
                            <div>- {{ $coSo->ten }}</div>
                        @empty
                            <div class="text-2">Chưa có cơ sở phụ trách</div>
                        @endforelse
                    </td>
                    <td>
                        @if ($gv->user)
                            <span class="badge blue">{{ $gv->user->name }}</span>
                        @else
                            <span class="text-2">Chưa có</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $gv->trang_thai->getBadge() }}">{{ $gv->trang_thai->getLabel() }}</span>
                    </td>
                    <td>
                        <div class="actions-cell">
                            @if (hasQuyen('giaovien', 'sua'))
                                <i class="ri-edit-line"
                                    onclick="openTeacherModal({{ $gv->id }}, {{ Js::from($gv->ho_ten) }}, {{ Js::from($gv->ma_nhan_vien) }}, {{ Js::from($gv->cccd) }}, {{ Js::from($gv->ngay_sinh?->format('Y-m-d')) }}, {{ Js::from($gv->sdt) }}, {{ Js::from($gv->chuc_danh->value) }})"></i>

                                <form action="{{ route('giaovien.trangthai', $gv) }}" method="POST"
                                    class="teacher-inline-form">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="teacher-icon-btn"
                                        title="{{ $gv->trang_thai === \App\Enum\TrangThaiGiaoVien::DANG_DAY ? 'Cho nghỉ dạy' : 'Cho dạy lại' }}">
                                        <i
                                            class="ri-user-{{ $gv->trang_thai === \App\Enum\TrangThaiGiaoVien::DANG_DAY ? 'unfollow' : 'follow' }}-line"></i>
                                    </button>
                                </form>
                            @endif
                            @if ($gv->trang_thai === \App\Enum\TrangThaiGiaoVien::DANG_DAY && hasQuyen('giaovien', 'xoa'))
                                <form action="{{ route('giaovien.destroy', $gv) }}" method="POST"
                                    class="teacher-inline-form confirm-delete-form" data-confirm-title="Xoá giáo viên"
                                    data-confirm-message="Bạn có chắc muốn xoá giáo viên {{ $gv->ho_ten }}?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="teacher-icon-btn"><i
                                            class="ri-delete-bin-line del"></i></button>
                                </form>
                            @endif

                            @if (!$gv->user)
                                @if (hasQuyen('giaovien', 'them'))
                                    <form action="{{ route('giaovien.captaikhoan', $gv) }}" method="POST"
                                        class="teacher-inline-form confirm-delete-form"
                                        data-confirm-title="Cấp tài khoản đăng nhập"
                                        data-confirm-message="Tài khoản đăng nhập: {{ generate_username_from_name($gv->ho_ten) }} — Mật khẩu là Số điện thoại: {{ $gv->sdt ?? 'Chưa có SĐT' }}. Xác nhận cấp tài khoản?">
                                        @csrf
                                        <button type="submit" class="teacher-icon-btn" title="Cấp tài khoản">
                                            <i class="ri-user-add-line"></i>
                                        </button>
                                    </form>
                                @endif
                            @else
                                @if (hasQuyen('giaovien', 'sua'))
                                    <i class="ri-shield-user-line" title="Cấp quyền"
                                        onclick="openQuyenModal({{ $gv->id }}, {{ Js::from($gv->ho_ten) }}, {{ Js::from($gv->user->permissions) }})"></i>

                                    <form action="{{ route('giaovien.doimatkhau', $gv) }}" method="POST"
                                        class="teacher-inline-form confirm-delete-form"
                                        data-confirm-title="Đổi mật khẩu"
                                        data-confirm-message="Mật khẩu sẽ đổi thành Số điện thoại: {{ $gv->sdt ?? 'Chưa có SĐT' }}. Xác nhận?">
                                        @csrf
                                        <button type="submit" class="teacher-icon-btn" title="Đổi mật khẩu về SĐT">
                                            <i class="ri-key-2-line"></i>
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-2 teacher-empty-row">Chưa có giáo viên nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            openTeacherModal(
                {{ old('_editing_id') ? (int) old('_editing_id') : 'null' }},
                {{ Js::from(old('ho_ten')) }},
                {{ Js::from(old('ma_nhan_vien')) }},
                {{ Js::from(old('cccd')) }},
                {{ Js::from(old('ngay_sinh')) }},
                {{ Js::from(old('sdt')) }},
                {{ Js::from(old('chuc_danh')) }}
            );
        });
    </script>
@endif
