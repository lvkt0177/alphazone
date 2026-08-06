<div class="breadcrumb">
    <a>Chấm công</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Cộng tác viên</a>
</div>
<div class="page-head">
    <div class="page-title">Chấm công - Cộng tác viên</div>
</div>

@if (session('success'))
    <div class="badge green chamcong-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red chamcong-alert-error">{{ session('error') }}</div>
@endif

<div class="table-card">
    <form method="GET" action="{{ route('chamcong.ctv') }}" class="chamcong-toolbar">
        <div class="filters">
            <div class="field chamcong-filter-field--date">
                <label class="chamcong-filter-label">Ngày chấm công</label>
                <input type="date" name="ngay" value="{{ $ngay }}" max="{{ now()->toDateString() }}"
                    onchange="this.form.submit()">
            </div>
        </div>

        <div class="thong-tin-cham-cong">
            <div class="text-2 chamcong-status-line">
                Đang chấm công ngày <b>{{ \Carbon\Carbon::parse($ngay)->format('d/m/Y') }}</b>
            </div>
            <div class="text-2 chamcong-status-line">
                <span class="badge purple">Đã chấm: {{ $soDaCham }}/{{ $ctvs->count() }}</span>
            </div>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th class="w-px-350">Cộng tác viên</th>
                <th class="w-px-150">Số giờ</th>
                <th class="w-px-150">Số tiền</th>
                <th class="w-px-150">Hỗ trợ xăng xe</th>
                <th class="w-px-250">Ghi chú</th>
                <th class="w-px-150">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ctvs as $gv)
                @php
                    $rec = $existing->get($gv->id);
                    $donGia = $gv->don_gia_gio;
                    $soTien = $rec && $rec->so_gio !== null && $donGia !== null ? $rec->so_gio * $donGia : null;
                @endphp
                <tr>
                    <td>{{ $gv->ho_ten }}</td>
                    <td>{{ $rec && $rec->so_gio !== null ? rtrim(rtrim(number_format($rec->so_gio, 1), '0'), '.') : '—' }}
                    </td>
                    <td>{{ $soTien !== null ? number_format($soTien, 0, ',', '.') . ' đ' : '—' }}</td>
                    <td>{{ $rec && $rec->ho_tro_xang_xe !== null ? number_format($rec->ho_tro_xang_xe, 0, ',', '.') . ' đ' : '—' }}
                    </td>
                    <td>{{ $rec->ghi_chu ?? '—' }}</td>
                    <td class="chamcong-ctv-action">
                        @if ($donGia === null)
                            <div class="chamcong-canh-bao-donia">
                                <i class="ri-error-warning-line"></i>
                                Chưa có đơn giá —
                                <a href="{{ route('caidattienluong.index') }}">Cài đặt ngay</a>
                            </div>
                        @elseif (hasQuyen('chamcong', 'them'))
                            <button type="button" class="btn btn-sm {{ $rec ? 'btn-warning' : 'btn-outline' }}"
                                onclick="openChamCongCtvModal({{ $gv->id }}, {{ Js::from($gv->ho_ten) }}, {{ Js::from($ngay) }}, {{ $donGia }}, {{ $rec?->so_gio ?? 'null' }}, {{ $rec?->ho_tro_xang_xe ?? 'null' }}, {{ Js::from($rec?->ghi_chu) }}, {{ Js::from(route('chamcong.ctv.luu', $gv)) }}, {{ Js::from(route('chamcong.ctv.xoa', $gv)) }}, {{ $rec ? 'true' : 'false' }})">
                                {{ $rec ? 'Chỉnh sửa' : 'Chấm công' }}
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-2 chamcong-empty-row">Chưa có giáo viên nào giữ chức danh CTV Hỗ trợ
                        bóng đá</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($errors->any() && old('_editing_id'))
    @php
        $ccErrGv = $ctvs->firstWhere('id', (int) old('_editing_id'));
        $ccErrRec = $ccErrGv ? $existing->get($ccErrGv->id) : null;
    @endphp
    @if ($ccErrGv)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                openChamCongCtvModal(
                    {{ $ccErrGv->id }},
                    {{ Js::from($ccErrGv->ho_ten) }},
                    {{ Js::from($ngay) }},
                    {{ $ccErrGv->don_gia_gio ?? 0 }},
                    {{ Js::from(old('so_gio', $ccErrRec?->so_gio)) }},
                    {{ Js::from(old('ho_tro_xang_xe', $ccErrRec?->ho_tro_xang_xe)) }},
                    {{ Js::from(old('ghi_chu', $ccErrRec?->ghi_chu)) }},
                    {{ Js::from(route('chamcong.ctv.luu', $ccErrGv)) }},
                    {{ Js::from(route('chamcong.ctv.xoa', $ccErrGv)) }},
                    {{ $ccErrRec ? 'true' : 'false' }}
                );
            });
        </script>
    @endif
@endif

@include('partials.modals._chamcongctv')
