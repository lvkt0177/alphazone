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
                    <td>{{ $gv->don_gia_gio !== null ? number_format($gv->don_gia_gio, 0, ',', '.') . ' đ' : '-' }}</td>
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

@if (hasQuyen('caidattienluong', 'sua'))
    <div class="tienluong-card">
        <div class="tienluong-card-head">
            <div class="tienluong-card-icon"><i class="ri-settings-3-line"></i></div>
            <div class="tienluong-card-title">Cấu hình ngày công chung</div>
        </div>

        <form method="POST" action="{{ route('caidattienluong.ngaycong.update') }}" class="tienluong-ngaycong-form">
            @csrf
            @method('PUT')
            <div class="form-grid full">
                <div class="field">
                    <label>Ngày công tối thiểu / tháng</label>
                    <input type="number" name="ngay_cong_toi_thieu" min="1" max="31"
                        value="{{ old('ngay_cong_toi_thieu', $caiDatLuongThay->ngay_cong_toi_thieu) }}">
                    @error('ngay_cong_toi_thieu')
                        <div class="badge red tienluong-field-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label>Tiền bị trừ 1 ngày mặc định (áp dụng cho GV chưa cấu hình riêng)</label>
                    <input type="text" id="tl_tru_ngay_display" inputmode="numeric" autocomplete="off"
                        value="{{ number_format(old('tien_tru_1_ngay', $caiDatLuongThay->tien_tru_1_ngay), 0, ',', '.') }}">
                    <input type="hidden" name="tien_tru_1_ngay" id="tl_tru_ngay"
                        value="{{ old('tien_tru_1_ngay', $caiDatLuongThay->tien_tru_1_ngay) }}">
                    @error('tien_tru_1_ngay')
                        <div class="badge red tienluong-field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-sm mt-3"><i class="ri-save-line"></i> Lưu cấu hình ngày
                    công</button>
            </div>
        </form>
    </div>
@endif

@foreach ($chucDanhNhanViens as $nhom)
    <div class="tienluong-card">
        <div class="tienluong-card-head">
            <div class="tienluong-card-icon"><i class="{{ $nhom['chuc_danh']->getIcon() }}"></i></div>
            <div class="tienluong-card-title">Lương {{ $nhom['chuc_danh']->getLabel() }}</div>
        </div>

        <table class="tienluong-table">
            <thead>
                <tr>
                    <th>{{ $nhom['chuc_danh']->getLabel() }}</th>
                    <th>Lương cơ bản / tháng</th>
                    <th>Tiền trừ 1 ngày (vắng)</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($nhom['giao_viens'] as $gv)
                    <tr>
                        <td>
                            <div class="tienluong-person">
                                <div class="tienluong-avatar">{{ $gv->ky_tu_dau }}</div>
                                <span>{{ $gv->ho_ten }}</span>
                            </div>
                        </td>
                        <td>{{ $gv->luong_co_ban !== null ? number_format($gv->luong_co_ban, 0, ',', '.') . ' đ' : '-' }}</td>
                        <td>
                            @if ($gv->tien_tru_1_ngay !== null)
                                {{ number_format($gv->tien_tru_1_ngay, 0, ',', '.') }} đ
                            @else
                                <span class="text-2">Mặc định ({{ number_format($caiDatLuongThay->tien_tru_1_ngay, 0, ',', '.') }} đ)</span>
                            @endif
                        </td>
                        <td class="tienluong-action-cell">
                            @if (hasQuyen('caidattienluong', 'sua'))
                                <a href="javascript:void(0)" class="tienluong-sua-link btn btn-primary btn-sm mt-3"
                                    onclick="openTienLuongModal({{ $gv->id }}, {{ Js::from($gv->ho_ten) }}, {{ Js::from('luong_co_ban') }}, {{ Js::from('Lương cơ bản/tháng') }}, {{ $gv->luong_co_ban ?? 'null' }}, {{ Js::from(route('caidattienluong.update', $gv)) }})">Sửa
                                    lương</a>
                                <a href="javascript:void(0)" class="tienluong-sua-link btn btn-warning btn-sm mt-3"
                                    onclick="openTienLuongModal({{ $gv->id }}, {{ Js::from($gv->ho_ten) }}, {{ Js::from('tien_tru_1_ngay') }}, {{ Js::from('Tiền trừ 1 ngày (vắng)') }}, {{ $gv->tien_tru_1_ngay ?? 'null' }}, {{ Js::from(route('caidattienluong.update', $gv)) }})">Sửa
                                    tiền trừ</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-2 tienluong-empty-row">Chưa có giáo viên nào giữ chức danh
                            {{ $nhom['chuc_danh']->getLabel() }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endforeach

@if ($errors->any() && old('_editing_id'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            openTienLuongModal(
                {{ (int) old('_editing_id') }},
                {{ Js::from(old('_ho_ten')) }},
                {{ Js::from(old('_field')) }},
                {{ Js::from(old('_label')) }},
                {{ old('luong_co_ban') ?? old('don_gia_gio') ?? old('tien_tru_1_ngay') ?? 'null' }},
                {{ Js::from(old('_update_url')) }}
            );
        });
    </script>
@endif