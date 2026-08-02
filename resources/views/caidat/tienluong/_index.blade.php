<div class="breadcrumb">
    <a>Cài đặt</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Tiền lương</a>
</div>
<div class="page-head">
    <div>
        <div class="page-title">Cấu hình tiền lương</div>
        <div class="text-2 tienluong-subtitle">Thiết lập lương cơ bản / đơn giá cho từng giáo viên.</div>
    </div>
</div>

@if (session('success'))
    <div class="badge green tienluong-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red tienluong-alert-error">{{ session('error') }}</div>
@endif

<div class="tienluong-card">
    <div class="tienluong-card-head">
        <div class="tienluong-card-icon"><i class="ri-user-follow-line"></i></div>
        <div class="tienluong-card-title">Lương Cộng tác viên</div>
    </div>
    <table class="tienluong-table">
        <thead>
            <tr>
                <th>Cộng tác viên</th>
                <th>Đơn giá / giờ</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ctvHoTros as $gv)
                <tr>
                    <td>
                        <div class="tienluong-person">
                            <div class="tienluong-avatar">{{ $gv->ky_tu_dau }}</div>
                            <span>{{ $gv->ho_ten }}</span>
                        </div>
                    </td>
                    <td>{{ $gv->don_gia_gio !== null ? number_format($gv->don_gia_gio, 0, ',', '.') . ' đ' : '—' }}</td>
                    <td class="tienluong-action-cell">
                        @if (hasQuyen('caidattienluong', 'sua'))
                            <a href="javascript:void(0)" class="tienluong-sua-link"
                                onclick="openTienLuongModal({{ $gv->id }}, {{ Js::from($gv->ho_ten) }}, {{ Js::from('don_gia_gio') }}, {{ Js::from('Đơn giá/giờ') }}, {{ $gv->don_gia_gio ?? 'null' }}, {{ Js::from(route('caidattienluong.update', $gv)) }})">Sửa</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-2 tienluong-empty-row">Chưa có giáo viên nào giữ chức danh CTV Hỗ trợ
                        bóng đá</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="tienluong-card">
    <div class="tienluong-card-head">
        <div class="tienluong-card-icon"><i class="ri-graduation-cap-line"></i></div>
        <div class="tienluong-card-title">Lương Thầy phụ trách</div>
    </div>
    <table class="tienluong-table">
        <thead>
            <tr>
                <th>Thầy phụ trách</th>
                <th>Lương cơ bản / tháng</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($thayPhuTrachs as $gv)
                <tr>
                    <td>
                        <div class="tienluong-person">
                            <div class="tienluong-avatar">{{ $gv->ky_tu_dau }}</div>
                            <span>{{ $gv->ho_ten }}</span>
                        </div>
                    </td>
                    <td>{{ $gv->luong_co_ban !== null ? number_format($gv->luong_co_ban, 0, ',', '.') . ' đ' : '—' }}</td>
                    <td class="tienluong-action-cell">
                        @if (hasQuyen('caidattienluong', 'sua'))
                            <a href="javascript:void(0)" class="tienluong-sua-link"
                                onclick="openTienLuongModal({{ $gv->id }}, {{ Js::from($gv->ho_ten) }}, {{ Js::from('luong_co_ban') }}, {{ Js::from('Lương cơ bản/tháng') }}, {{ $gv->luong_co_ban ?? 'null' }}, {{ Js::from(route('caidattienluong.update', $gv)) }})">Sửa</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-2 tienluong-empty-row">Chưa có giáo viên nào giữ chức danh Thầy phụ
                        trách</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($errors->any() && old('_editing_id'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            openTienLuongModal(
                {{ (int) old('_editing_id') }},
                {{ Js::from(old('_ho_ten')) }},
                {{ Js::from(old('_field')) }},
                {{ Js::from(old('_label')) }},
                {{ old('luong_co_ban') ?? old('don_gia_gio') ?? 'null' }},
                {{ Js::from(old('_update_url')) }}
            );
        });
    </script>
@endif