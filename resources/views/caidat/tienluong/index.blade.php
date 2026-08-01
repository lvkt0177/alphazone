<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a>Cài đặt</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Tiền lương</a>
</div>
<div class="page-head">
    <div class="page-title">Cấu hình Tiền lương</div>
</div>

@if (session('success'))
    <div class="badge green tienluong-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red tienluong-alert-error">{{ session('error') }}</div>
@endif

<div class="tienluong-grid">
    <div class="table-card">
        <div class="tienluong-box-title"><i class="ri-chalkboard-line"></i> Thầy phụ trách</div>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Lương cơ bản/tháng</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($thayPhuTrachs as $gv)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $gv->ho_ten }}</td>
                        <td>{{ $gv->luong_co_ban !== null ? number_format($gv->luong_co_ban, 0, ',', '.') . ' đ' : '—' }}</td>
                        <td>
                            @if (hasQuyen('caidattienluong', 'sua'))
                                <div class="actions-cell">
                                    <i class="ri-edit-line"
                                        onclick="openTienLuongModal({{ $gv->id }}, {{ Js::from($gv->ho_ten) }}, {{ Js::from('luong_co_ban') }}, {{ Js::from('Lương cơ bản/tháng') }}, {{ $gv->luong_co_ban ?? 'null' }}, {{ Js::from(route('caidattienluong.update', $gv)) }})"></i>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-2 tienluong-empty-row">Chưa có giáo viên nào giữ chức danh Thầy
                            phụ trách</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-card">
        <div class="tienluong-box-title"><i class="ri-user-follow-line"></i> CTV Hỗ trợ bóng đá</div>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Đơn giá/giờ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ctvHoTros as $gv)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $gv->ho_ten }}</td>
                        <td>{{ $gv->don_gia_gio !== null ? number_format($gv->don_gia_gio, 0, ',', '.') . ' đ' : '—' }}</td>
                        <td>
                            @if (hasQuyen('caidattienluong', 'sua'))
                                <div class="actions-cell">
                                    <i class="ri-edit-line"
                                        onclick="openTienLuongModal({{ $gv->id }}, {{ Js::from($gv->ho_ten) }}, {{ Js::from('don_gia_gio') }}, {{ Js::from('Đơn giá/giờ') }}, {{ $gv->don_gia_gio ?? 'null' }}, {{ Js::from(route('caidattienluong.update', $gv)) }})"></i>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-2 tienluong-empty-row">Chưa có giáo viên nào giữ chức danh CTV Hỗ
                            trợ bóng đá</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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