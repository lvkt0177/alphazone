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

<form method="GET" action="{{ route('chamcong.ctv') }}" class="chamcong-date-bar">
    <label for="cc_ctv_ngay">Ngày</label>
    <input type="date" name="ngay" id="cc_ctv_ngay" value="{{ $ngay }}" max="{{ now()->toDateString() }}"
        onchange="this.form.submit()">
</form>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Cộng tác viên</th>
                <th>Số giờ</th>
                <th>Số tiền</th>
                <th>Hỗ trợ xăng xe</th>
                <th>Ghi chú</th>
                <th></th>
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
                            <button type="button" class="btn btn-outline btn-sm"
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

@include('partials.modals._chamcongctv')
