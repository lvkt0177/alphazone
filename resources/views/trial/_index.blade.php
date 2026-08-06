<div class="breadcrumb">
    <a>Trang chủ</a> 
    <i class="ri-arrow-right-s-line"></i> 
    <a class="active">Trải nghiệm</a>
</div>
<div class="page-head">
    <div class="page-title">Học viên Trải nghiệm</div>
    @if (hasQuyen('trainghiem', 'them'))
        <button class="btn btn-primary" onclick="openTrialModal()"><i class="ri-add-line"></i> Tạo Học viên Trải
            nghiệm</button>
    @endif
</div>

@if (session('success'))
    <div class="badge green trial-alert-success">{{ session('success') }}</div>
@endif

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/trial.css') }}">
@endpush

<div class="table-card trial-filter-card">
    <form method="GET" action="{{ route('trainghiem.index') }}" class="table-toolbar">
        <div class="filters trial-filters">
            <div class="field trial-filter-field">
                <label class="trial-filter-label">Họ tên / SĐT</label>
                <div class="search-mini">
                    <i class="ri-search-line"></i>
                    <input type="text" name="ho_ten" value="{{ request('ho_ten') }}"
                        placeholder="Tìm theo Họ tên hoặc SĐT...">
                </div>
            </div>

            <div class="field trial-filter-field">
                <label class="trial-filter-label">Cơ sở</label>
                <select name="co_so_id" onchange="this.form.submit()">
                    <option value="">Tất cả Cơ sở</option>
                    @foreach ($coSos as $cs)
                        <option value="{{ $cs->id }}" {{ request('co_so_id') == $cs->id ? 'selected' : '' }}>
                            {{ $cs->ten }} - {{ $cs->giaoVien->ho_ten ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field trial-filter-field--date">
                <label class="trial-filter-label">Ngày trải nghiệm</label>
                <input type="date" name="ngay_trai_nghiem" value="{{ request('ngay_trai_nghiem') }}"
                    onchange="this.form.submit()">
            </div>

            <div class="field trial-filter-field">
                <label class="trial-filter-label">Trạng thái</label>
                <select name="trang_thai" onchange="this.form.submit()">
                    <option value="">Tất cả trạng thái</option>
                    @foreach (\App\Enum\TrangThaiLoaiDangKyTraiNghiem::cases() as $st)
                        <option value="{{ $st->value }}" {{ request('trang_thai') !== null && (int) request('trang_thai') === $st->value ? 'selected' : '' }}>
                            {{ $st->getLabel() }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
            @if (request()->hasAny(['ho_ten', 'co_so_id', 'ngay_trai_nghiem', 'trang_thai']))
                <a href="{{ route('trainghiem.index') }}" class="btn btn-outline btn-sm">Làm mới bộ lọc</a>
            @endif
        </div>
        <div class="text-2 trial-count-text">{{ $traiNghiems->total() }} học viên trải nghiệm</div>
    </form>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th class="w-px-250">Họ tên</th>
                <th class="w-px-150">Số điện thoại</th>
                <th class="w-px-100">Năm sinh</th>
                <th class="w-px-150">Ngày trải nghiệm</th>
                <th class="w-px-350">Cơ sở</th>
                <th class="w-px-150">Trạng thái</th>
                <th class="w-px-250">Ghi chú</th>
                <th class="w-px-150">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($traiNghiems as $t)
                <tr>
                    <td>
                        <div class="cell-user"><img
                                src="https://ui-avatars.com/api/?name={{ urlencode($t->ho_ten) }}&background=FFA45C&color=fff&bold=true"
                                alt="">
                            <div class="name">{{ $t->ho_ten }}</div>
                        </div>
                    </td>
                    <td>{{ $t->sdt ?? '—' }}</td>
                    <td>{{ $t->nam_sinh ?? '—' }}</td>
                    <td>{{ $t->ngay_trai_nghiem ? $t->ngay_trai_nghiem->format('d/m/Y') : '—' }}</td>
                    <td>
                        @if ($t->coSos->isNotEmpty())
                            @foreach ($t->coSos as $coSo)
                                <div>{{ $coSo->ten }} - {{ $coSo->giaoVien->ho_ten ?? 'N/A' }}</div>
                            @endforeach
                        @else
                            N/A
                        @endif
                    </td>
                    <td><span class="badge {{ $t->trang_thai->getBadge() }}">{{ $t->trang_thai->getLabel() }}</span>
                    </td>
                    <td class="text-2">{{ $t->ghi_chu ?? '—' }}</td>
                    <td>
                        <div class="actions-cell">
                            @if (hasQuyen('trainghiem', 'sua'))
                                <i class="ri-edit-line"
                                    onclick="openTrialModal({{ $t->id }}, 
                                    {{ Js::from($t->ho_ten) }}, 
                                    {{ Js::from($t->sdt) }}, 
                                    {{ Js::from($t->nam_sinh) }}, 
                                    {{ Js::from($t->ngay_trai_nghiem?->format('Y-m-d')) }}, 
                                    {{ $t->trang_thai->value }}, {{ Js::from($t->ghi_chu) }},
                                    {{ Js::from($t->coSos->pluck('id')) }})">
                                </i>
                            @endif
                            @if ($t->trang_thai !== \App\Enum\TrangThaiLoaiDangKyTraiNghiem::DA_DANG_KY && hasQuyen('trainghiem', 'xoa'))
                                <form action="{{ route('trainghiem.destroy', $t) }}" method="POST"
                                    class="trial-inline-form confirm-delete-form"
                                    data-confirm-title="Xoá học viên trải nghiệm"
                                    data-confirm-message="Bạn có chắc muốn xoá {{ $t->ho_ten }}?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="trial-icon-btn"><i
                                            class="ri-delete-bin-line del"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-2 trial-empty-row">Chưa có học viên trải
                        nghiệm nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        @if (!$traiNghiems->onFirstPage())
            <a href="{{ $traiNghiems->previousPageUrl() }}">Trước</a>
        @else
            <span class="trial-page-disabled">Trước</span>
        @endif
        @for ($i = 1; $i <= $traiNghiems->lastPage(); $i++)
            <a href="{{ $traiNghiems->url($i) }}"
                class="{{ $i == $traiNghiems->currentPage() ? 'active' : '' }}">{{ $i }}</a>
        @endfor
        @if ($traiNghiems->hasMorePages())
            <a href="{{ $traiNghiems->nextPageUrl() }}">Sau</a>
        @else
            <span class="trial-page-disabled">Sau</span>
        @endif
    </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            openTrialModal(
                {{ old('_editing_id') ? (int) old('_editing_id') : 'null' }},
                {{ Js::from(old('ho_ten')) }},
                {{ Js::from(old('sdt')) }},
                {{ Js::from(old('nam_sinh')) }},
                {{ Js::from(old('ngay_trai_nghiem')) }},
                {{ old('trang_thai') ?? 'null' }},
                {{ Js::from(old('ghi_chu')) }},
                {{ Js::from(old('co_so_ids', [])) }}
            );
        });
    </script>
@endif