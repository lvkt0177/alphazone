<div class="breadcrumb">
    <a>Trang chủ</a> 
    <i class="ri-arrow-right-s-line"></i> 
    <a class="active">Tiền sân</a>
</div>
<div class="page-head">
    <div class="page-title">Tính tiền Sân theo Cơ sở</div>
    @if (hasQuyen('tiensan', 'them'))
        <button type="button" class="btn btn-primary" onclick="openTienSanModal()"><i class="ri-add-line"></i> Tạo Tiền
            sân</button>
    @endif
</div>

@if (session('success'))
    <div class="badge green tiensan-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red tiensan-alert-error">{{ session('error') }}</div>
@endif

<div class="table-card">
    <form method="GET" action="{{ route('tiensan.index') }}" class="table-toolbar">
        <div class="filters tiensan-filters">
            <div class="field tiensan-filter-field">
                <label class="tiensan-filter-label">Cơ sở</label>
                <select name="co_so_id" onchange="this.form.submit()">
                    <option value="">Tất cả Cơ sở</option>
                    @foreach ($coSos as $cs)
                        <option value="{{ $cs->id }}" {{ request('co_so_id') == $cs->id ? 'selected' : '' }}>
                            {{ $cs->ten }} - {{ $cs->giaoVien->ho_ten ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field tiensan-filter-field">
                <label class="tiensan-filter-label">Tháng</label>
                <select name="thang" onchange="this.form.submit()">
                    @foreach ($danhSachThang as $t)
                        <option value="{{ $t['value'] }}"
                            {{ $thang->format('Y-m') == $t['value'] ? 'selected' : '' }}>{{ $t['label'] }}</option>
                    @endforeach
                </select>
            </div>

            @if (request()->hasAny(['co_so_id', 'thang']))
                <a href="{{ route('tiensan.index') }}" class="btn btn-outline btn-sm">Làm mới bộ lọc</a>
            @endif

            <div class="field tiensan-filter-field">
                <label class="tiensan-filter-label">Tổng tiền sân tháng {{ $thang->format('n/Y') }}</label>
                <span class="badge blue tiensan-tongthu-badge">{{ number_format($tongTienThang, 0, ',', '.') }} đ</span>
            </div>
        </div>
        <div class="text-2 tiensan-count-text">{{ $tienSans->total() }} bản ghi</div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Cơ sở</th>
                <th>Số tiền</th>
                <th>Bill</th>
                <th>Ghi chú</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tienSans as $ts)
                <tr>
                    <td>{{ $ts->ngay->format('d/m/Y') }}</td>
                    <td>{{ $ts->coSo->ten }} - {{ $ts->coSo->giaoVien->ho_ten ?? 'N/A' }}</td>
                    <td>{{ number_format($ts->so_tien, 0, ',', '.') }} đ</td>
                    <td>
                        @if ($ts->bill_url)
                            <img src="{{ $ts->bill_url }}" alt="Bill"
                                class="tiensan-bill-thumb" onclick="openBillPreview('{{ $ts->bill_url }}')">
                        @else
                            <span class="text-2">—</span>
                        @endif
                    </td>
                    <td class="text-2">{{ $ts->ghi_chu ?? '—' }}</td>
                    <td>
                        <div class="actions-cell">
                            @if (hasQuyen('tiensan', 'sua'))
                                <i class="ri-edit-line" onclick='openTienSanModal(@json($ts))'></i>
                            @endif
                            @if (hasQuyen('tiensan', 'xoa'))
                                <form action="{{ route('tiensan.destroy', $ts) }}" method="POST"
                                    class="tiensan-inline-form confirm-delete-form" data-confirm-title="Xoá bản ghi Tiền sân"
                                    data-confirm-message="Bạn có chắc muốn xoá bản ghi ngày {{ $ts->ngay->format('d/m/Y') }} của Cơ sở {{ $ts->coSo->ten }}?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="tiensan-icon-btn"><i
                                            class="ri-delete-bin-line del"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-2 tiensan-empty-row">Chưa có bản ghi Tiền sân
                        nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        @if (!$tienSans->onFirstPage())
            <a href="{{ $tienSans->previousPageUrl() }}">Trước</a>
        @else
            <span class="tiensan-page-disabled">Trước</span>
        @endif
        @for ($i = 1; $i <= $tienSans->lastPage(); $i++)
            <a href="{{ $tienSans->url($i) }}"
                class="{{ $i == $tienSans->currentPage() ? 'active' : '' }}">{{ $i }}</a>
        @endfor
        @if ($tienSans->hasMorePages())
            <a href="{{ $tienSans->nextPageUrl() }}">Sau</a>
        @else
            <span class="tiensan-page-disabled">Sau</span>
        @endif
    </div>
</div>

@push('modals')
    @include('partials.modals._tiensan')
@endpush

@if ($errors->any() && old('_editing_id'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            openTienSanModal({
                id: {{ (int) old('_editing_id') }},
                co_so_id: {{ old('co_so_id') ?? 'null' }},
                ngay: {{ Js::from(old('ngay')) }},
                so_tien: {{ old('so_tien') !== null ? (int) old('so_tien') : 'null' }},
                ghi_chu: {{ Js::from(old('ghi_chu')) }},
            });
        });
    </script>
@endif

<div class="overlay" id="billPreviewModal">
    <div class="modal tiensan-bill-modal">
        <div class="modal-head">
            <h3>Xem Bill</h3><i class="ri-close-line" onclick="closeModal('billPreviewModal')"></i>
        </div>
        <div class="modal-body tiensan-bill-modal-body">
            <img id="billPreviewImg" src="" alt="Bill" class="tiensan-bill-modal-img">
        </div>
        <div class="modal-foot">
            <a id="billPreviewDownload" href="#" target="_blank" rel="noopener" class="btn btn-outline">
                <i class="ri-external-link-line"></i> Mở ảnh gốc
            </a>
            <button type="button" class="btn btn-primary" onclick="closeModal('billPreviewModal')">Đóng</button>
        </div>
    </div>
</div>