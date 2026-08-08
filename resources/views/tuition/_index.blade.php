<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Học phí</a>
</div>

<div class="page-head">
    <div class="page-title">Quản lý Đóng Học phí</div>
</div>

@if (session('success'))
    <div class="badge green tuition-alert-success">{{ session('success') }}</div>
@endif

<div class="table-card mb-4">
    <form method="GET" action="{{ route('hocphi.index') }}" class="table-toolbar mb-0">
        <div class="tuition-toolbar-row">
            <div class="filters tuition-filters">
                <div class="field tuition-filter-field">
                    <label class="tuition-filter-label">Tìm kiếm</label>
                    <div class="search-mini">
                        <i class="ri-search-line"></i>
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Tìm theo Mã số, Họ tên, SĐT...">
                    </div>
                </div>

                <div class="field tuition-filter-field--coso w-px-300">
                    <label class="tuition-filter-label">Cơ sở</label>
                    <select name="co_so_id" onchange="this.form.submit()">
                        <option value="">Tất cả Cơ sở</option>
                        @foreach ($coSos as $cs)
                            <option value="{{ $cs->id }}" {{ request('co_so_id') == $cs->id ? 'selected' : '' }}>
                                {{ $cs->ten }} - {{ $cs->giaoVien->ho_ten ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if (!($dangLocNgay ?? false))
                    <div class="field tuition-filter-field--status">
                        <label class="tuition-filter-label">Trạng thái đóng</label>
                        <select name="trang_thai_dong" onchange="this.form.submit()">
                            <option value="">Tất cả trạng thái</option>
                            <option value="da_dong" {{ request('trang_thai_dong') == 'da_dong' ? 'selected' : '' }}>
                                Đã đóng
                            </option>
                            <option value="chua_dong" {{ request('trang_thai_dong') == 'chua_dong' ? 'selected' : '' }}>
                                Chưa đóng
                            </option>
                        </select>
                    </div>

                    <div class="field tuition-filter-field--month">
                        <label class="tuition-filter-label">Tháng</label>
                        <select name="thang" onchange="this.form.submit()">
                            @foreach ($danhSachThang as $t)
                                <option value="{{ $t['value'] }}"
                                    {{ $thang->format('Y-m') == $t['value'] ? 'selected' : '' }}>{{ $t['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if (request()->hasAny(['q', 'co_so_id', 'trang_thai_dong', 'thang']))
                    <a href="{{ route('hocphi.index') }}" class="btn btn-outline btn-sm btn-lam-moi-bo-loc">Đặt lại</a>
                @endif
            </div>

            {{--
            <div class="tuition-daterange-group">
                <div class="field tuition-filter-field--daterange" data-daterange>
                    <label class="tuition-filter-label">Lọc theo khoảng ngày (Ngày đóng)</label>
                    <input type="hidden" name="tu_ngay" value="{{ request('tu_ngay') }}" data-dr-start>
                    <input type="hidden" name="den_ngay" value="{{ request('den_ngay') }}" data-dr-end>
                </div>

                <button type="submit" class="btn btn-outline btn-sm btn-loc-theo-ngay">Lọc theo ngày</button>

                @if ($dangLocNgay ?? false)
                    <a href="{{ route('hocphi.index', request()->except(['tu_ngay', 'den_ngay', 'trang_da_dong', 'trang_chua_dong'])) }}"
                        class="btn btn-outline btn-sm btn-xoa-loc-ngay">Xoá lọc ngày</a>
                @endif
            </div>
            --}}
        </div>

        <div class="tuition-summary-bar">
            <span class="text-2 tuition-count-text tuition-info-count">
                {{ $dangLocNgay ?? false ? $daDongList->total() . ' lượt đã đóng' : 'Sĩ số: ' . $hocViens->total() . ' học viên' }}
            </span>

            @unless ($dangLocNgay ?? false)
                <span class="tuition-summary-sep">|</span>
                <span class="tuition-tongthu-inline">
                    Tổng thu (Tháng {{ $thang->format('n/Y') }}):
                    <span class="badge blue tuition-tongthu-badge">
                        {{ number_format($tongHocPhiThang, 0, ',', '.') }} đ</span>
                </span>
            @endunless
        </div>
        @if ($dangLocNgay ?? false)
            <div class="stats-summary mb-0">
                Từ <strong>{{ \Carbon\Carbon::parse(request('tu_ngay'))->format('d/m/Y') }}</strong> đến
                <strong>{{ \Carbon\Carbon::parse(request('den_ngay'))->format('d/m/Y') }}</strong> -
                <span class="stat-item">Đã đóng: <strong>{{ $daDongList->total() }}</strong></span> |
                <span class="stat-item">Chưa đóng: <strong>{{ $chuaDongList->total() }}</strong></span>
            </div>
        @endif

    </form>
</div>

@if ($dangLocNgay ?? false)
    @include('tuition._theo_khoang_ngay')
@else
    <div class="table-card">

        <div class="text-2 tuition-stats-line">
            {{ \App\Enum\TrangThaiHocPhi::DA_DONG->getLabel() }}: <strong>{{ $countDaDong }}</strong>
            |
            {{ \App\Enum\TrangThaiHocPhi::CHUA_DONG->getLabel() }}: <strong>{{ $countChuaDong }}</strong>
        </div>

        <table class="mt-3">
            <thead>
                <tr>
                    <th class="w-px-100">Mã số</th>
                    <th class="w-px-250">Họ tên</th>
                    <th class="w-px-300">Cơ sở</th>
                    <th class="w-px-150">Học phí</th>
                    <th class="w-px-200">Đồng phục</th>
                    <th class="w-px-150">Học phí dự kiến</th>
                    <th class="trang-thai-hoc-phi w-px-150">Trạng thái</th>
                    <th class="w-px-150">Ngày đóng</th>
                    <th class="w-px-150">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hocViens as $hv)
                    @php
                        $hocPhis = $hv->hocPhis;
                        $rec = $hocPhis->first();
                        $duKien = $hv->duKienHocPhi();
                        $dotListData = $hocPhis->map(fn ($r) => [
                            'id' => $r->id,
                            'hoc_phi' => $r->hoc_phi,
                            'dong_phuc' => $r->dong_phuc,
                            'dong_phuc_size' => $r->dong_phuc_size,
                            'ngay_dong' => $r->ngay_dong->format('Y-m-d'),
                        ])->values();
                    @endphp
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
                                    <div>{{ $coSo->ten }} - {{ $coSo->giaoVien->ho_ten ?? 'N/A' }}</div>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @forelse ($hocPhis as $hp)
                                <div>{{ $hocPhis->count() > 1 ? '' : '' }}{{ number_format($hp->hoc_phi, 0, ',', '.') }} đ</div>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td class="text-2">
                            @forelse ($hocPhis as $hp)
                                <div>
                                    {{ $hocPhis->count() > 1 ? '' : '' }}{{ isset($hp->dong_phuc) ? (\App\Enum\MucDongPhuc::tryFrom($hp->dong_phuc)?->getLabel() ?? '—') : '-' }}
                                    @if ($hp->dong_phuc_size)
                                        (Size {{ $hp->dong_phuc_size }})
                                    @endif
                                </div>
                            @empty
                                
                            @endforelse
                        </td>
                        <td class="text-2">
                            @if ($duKien)
                                {{ number_format($duKien['so_tien'], 0, ',', '.') }} đ
                                ({{ $duKien['so_buoi_da_hoc'] }}/{{ $duKien['tong_so_buoi'] }})
                            @else
                                -
                            @endif
                        <td>
                            @if ($rec)
                                <span class="badge green">Đã đóng</span>
                                @if ($rec->gioi_thieu_ban)
                                    <span class="badge purple tuition-giothieu-tag">
                                        Giới
                                        thiệu{{ $rec->nguoiGioiThieu ? ' ' . $rec->nguoiGioiThieu->ma_so . ' - ' . $rec->nguoiGioiThieu->ho_ten : '' }}
                                    </span>
                                @endif
                            @else
                                <span class="badge red">Chưa đóng</span>
                            @endif
                        </td>
                        <td>
                            @forelse ($hocPhis as $hp)
                                <div>{{ $hocPhis->count() > 1 ? '' : '' }}{{ $hp->ngay_dong->format('d/m/Y') }}</div>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>
                            @if (hasQuyen('hocphi', 'them'))
                                <button type="button"
                                    class="btn btn-sm {{ $rec ? 'btn-warning' : 'btn-primary' }} open-tuition-btn"
                                    data-hoc-vien-id="{{ $hv->id }}" data-ma-so="{{ $hv->ma_so }}"
                                    data-ho-ten="{{ $hv->ho_ten }}" data-thang="{{ $thang->format('Y-m-d') }}"
                                    data-dot-list="{{ json_encode($dotListData) }}"
                                    data-gioi-thieu-ban="{{ $rec->gioi_thieu_ban ?? 0 }}"
                                    data-nguoi-gioi-thieu-id="{{ $rec->nguoi_gioi_thieu_id ?? '' }}"
                                    data-du-kien-so-tien="{{ $duKien['so_tien'] ?? '' }}"
                                    data-du-kien-so-buoi="{{ $duKien['so_buoi_da_hoc'] ?? '' }}"
                                    data-du-kien-tong-buoi="{{ $duKien['tong_so_buoi'] ?? '' }}">
                                    {{ $rec ? 'Sửa' : 'Tạo' }} học phí
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-2 tuition-empty-row">Không có học viên nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            @if (!$hocViens->onFirstPage())
                <a href="{{ $hocViens->previousPageUrl() }}">Trước</a>
            @else
                <span class="tuition-page-disabled">Trước</span>
            @endif
            @for ($i = 1; $i <= $hocViens->lastPage(); $i++)
                <a href="{{ $hocViens->url($i) }}"
                    class="{{ $i == $hocViens->currentPage() ? 'active' : '' }}">{{ $i }}</a>
            @endfor
            @if ($hocViens->hasMorePages())
                <a href="{{ $hocViens->nextPageUrl() }}">Sau</a>
            @else
                <span class="tuition-page-disabled">Sau</span>
            @endif
        </div>
    </div>
@endif

@push('modals')
    @include('partials.modals._tuition')
@endpush

@if ($errors->any() && old('hoc_vien_id'))
    @php
        $errHv = $hocViens->firstWhere('id', (int) old('hoc_vien_id'));
        $errDuKien = $errHv?->duKienHocPhi();
        $oldDotList = collect(old('dot', []))->map(fn ($d) => [
            'id' => $d['id'] ?? null,
            'hoc_phi' => $d['hoc_phi'] ?? null,
            'dong_phuc' => $d['dong_phuc'] ?? null,
            'dong_phuc_size' => $d['dong_phuc_size'] ?? null,
            'ngay_dong' => $d['ngay_dong'] ?? null,
        ])->values();
    @endphp
    @if ($errHv)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                openTuitionModal(
                    {{ $errHv->id }},
                    {{ Js::from($errHv->ma_so) }},
                    {{ Js::from($errHv->ho_ten) }},
                    {{ Js::from(old('thang')) }},
                    {{ Js::from($oldDotList) }},
                    {{ old('gioi_thieu_ban') ? 1 : 0 }},
                    {{ old('nguoi_gioi_thieu_id') ? (int) old('nguoi_gioi_thieu_id') : 'null' }},
                    {{ $errDuKien ? $errDuKien['so_tien'] : 'null' }},
                    {{ $errDuKien ? $errDuKien['so_buoi_da_hoc'] : 'null' }},
                    {{ $errDuKien ? $errDuKien['tong_so_buoi'] : 'null' }}
                );
            });
        </script>
    @endif
@endif