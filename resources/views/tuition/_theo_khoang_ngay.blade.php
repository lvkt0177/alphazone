<div class="stats-summary">
    Từ <strong>01/08/2026</strong> đến <strong>15/08/2026</strong>-
    <span class="stat-item">Đã đóng: <strong>2</strong></span> |
    <span class="stat-item">Chưa đóng: <strong>28</strong></span>
</div>

<div class="tuition-section-title">Đã đóng</div>
<table>
    <thead>
        <tr>
            <th>Ngày đóng</th>
            <th>Mã số</th>
            <th>Học viên</th>
            <th>Tháng</th>
            <th>Học phí</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($daDongList as $rec)
            <tr>
                <td>{{ $rec->ngay_dong->format('d/m/Y') }}</td>
                <td><a href="{{ route('hocvien.show', $rec->hocVien) }}" class="code-link">{{ $rec->hocVien->ma_so }}</a>
                </td>
                <td>
                    <div class="cell-user"><img src="{{ $rec->hocVien->avatar_url }}" alt="">
                        <div class="name">{{ $rec->hocVien->ho_ten }}</div>
                    </div>
                </td>
                <td>{{ $rec->thang->format('n/Y') }}</td>
                <td>{{ number_format($rec->hoc_phi, 0, ',', '.') }} đ</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-2 tuition-empty-row">Không có lượt đóng nào trong khoảng ngày này</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    @if (!$daDongList->onFirstPage())
        <a href="{{ $daDongList->previousPageUrl() }}">Trước</a>
    @else
        <span class="tuition-page-disabled">Trước</span>
    @endif
    @for ($i = 1; $i <= $daDongList->lastPage(); $i++)
        <a href="{{ $daDongList->url($i) }}"
            class="{{ $i == $daDongList->currentPage() ? 'active' : '' }}">{{ $i }}</a>
    @endfor
    @if ($daDongList->hasMorePages())
        <a href="{{ $daDongList->nextPageUrl() }}">Sau</a>
    @else
        <span class="tuition-page-disabled">Sau</span>
    @endif
</div>

<div class="tuition-section-title tuition-section-title--spaced">Chưa đóng</div>
<table>
    <thead>
        <tr>
            <th>Mã số</th>
            <th>Học viên</th>
            <th>Cơ sở</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($chuaDongList as $hv)
            <tr>
                <td><a href="{{ route('hocvien.show', $hv) }}" class="code-link">{{ $hv->ma_so }}</a></td>
                <td>
                    <div class="cell-user"><img src="{{ $hv->avatar_url }}" alt="">
                        <div class="name">{{ $hv->ho_ten }}</div>
                    </div>
                </td>
                <td>
                    @if ($hv->coSos->isNotEmpty())
                        @foreach ($hv->coSos as $coSo)
                            <div>{{ $coSo->ten }}</div>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-2 tuition-empty-row">Không có học viên nào chưa đóng trong khoảng ngày
                    này</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    @if (!$chuaDongList->onFirstPage())
        <a href="{{ $chuaDongList->previousPageUrl() }}">Trước</a>
    @else
        <span class="tuition-page-disabled">Trước</span>
    @endif
    @for ($i = 1; $i <= $chuaDongList->lastPage(); $i++)
        <a href="{{ $chuaDongList->url($i) }}"
            class="{{ $i == $chuaDongList->currentPage() ? 'active' : '' }}">{{ $i }}</a>
    @endfor
    @if ($chuaDongList->hasMorePages())
        <a href="{{ $chuaDongList->nextPageUrl() }}">Sau</a>
    @else
        <span class="tuition-page-disabled">Sau</span>
    @endif
</div>
