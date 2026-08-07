<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Hóa đơn đầu ra</a>
</div>

<div class="page-head">
    <div class="page-title">Hóa đơn đầu ra</div>
</div>

<div class="table-card mb-4">
    <form method="GET" action="{{ route('hoadon.daura.index') }}" class="table-toolbar mb-0">
        <div class="hoadon-daura-toolbar-row">
            <div class="field hoadon-filter-field--month">
                <label class="hoadon-filter-label">Tháng</label>
                <select name="thang" onchange="this.form.submit()">
                    @foreach ($danhSachThang as $t)
                        <option value="{{ $t['value'] }}"
                            {{ $thang->format('Y-m') == $t['value'] ? 'selected' : '' }}>{{ $t['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="hoadon-daura-tongthu">
            Tổng tiền học phí đã thu (Tháng {{ $thang->format('n/Y') }}):
            <span class="badge blue hoadon-daura-tongthu-badge">
                {{ number_format($tongTien, 0, ',', '.') }} đ</span>
        </div>
    </form>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th class="w-px-100">Mã số Học viên</th>
                <th class="w-px-250">Họ tên</th>
                <th class="w-px-150">Học phí</th>
                <th class="w-px-200">Đồng phục</th>
                <th class="w-px-150">Ngày đóng</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($danhSachHocPhi as $hp)
                <tr>
                    <td>
                        @if ($hp->hocVien)
                            <a href="{{ route('hocvien.show', $hp->hocVien) }}" class="code-link">{{ $hp->hocVien->ma_so }}</a>
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        <div class="cell-user">
                            <img src="{{ $hp->hocVien->avatar_url ?? '' }}" alt="">
                            <div class="name">{{ $hp->hocVien->ho_ten ?? '—' }}</div>
                        </div>
                    </td>
                    <td>{{ number_format($hp->hoc_phi, 0, ',', '.') }} đ</td>
                    <td class="text-2">
                        @if (isset($hp->dong_phuc))
                            {{ \App\Enum\MucDongPhuc::tryFrom($hp->dong_phuc)?->getLabel() ?? '—' }}
                            @if ($hp->dong_phuc_size)
                                (Size {{ $hp->dong_phuc_size }})
                            @endif
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $hp->ngay_dong->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-2 hoadon-empty-row">Chưa có lượt đóng học phí nào trong tháng này</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>