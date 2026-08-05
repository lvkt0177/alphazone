<div class="table-card mb-4">
    <div class="tuition-section-title">Danh sách học viên đã đóng tiền tháng này</div>
    <table>
        <thead>
            <tr>
                <th class="w-px-50">Mã số</th>
                <th class="w-px-200">Học viên</th>
                <th class="w-px-100">Tháng</th>
                <th class="w-px-150">Học phí</th>
                <th class="w-px-150">Ngày đóng</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($daDongList as $rec)
                <tr>
                    <td><a href="{{ route('hocvien.show', $rec->hocVien) }}"
                            class="code-link">{{ $rec->hocVien->ma_so }}</a>
                    </td>
                    <td>
                        <div class="cell-user"><img src="{{ $rec->hocVien->avatar_url }}" alt="">
                            <div class="name">{{ $rec->hocVien->ho_ten }}</div>
                        </div>
                    </td>
                    <td>{{ $rec->thang->format('n/Y') }}</td>
                    <td>{{ number_format($rec->hoc_phi, 0, ',', '.') }} đ</td>
                    <td>{{ $rec->ngay_dong->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-2 tuition-empty-row">Không có lượt đóng nào trong khoảng ngày này
                    </td>
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
</div>

<div class="table-card">
    <div class="tuition-section-title">Danh sách học viên chưa đóng tiền tháng này</div>
    <table>
        <thead>
            <tr>
                <th class="w-px-50">Mã số</th>
                <th class="w-px-200">Học viên</th>
                <th class="w-px-250">Cơ sở</th>
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
                    <td colspan="3" class="text-2 tuition-empty-row">Không có học viên nào chưa đóng trong khoảng
                        ngày
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
</div>
