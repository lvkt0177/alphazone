<div class="breadcrumb"><a>Trang chủ</a> <i class="ri-arrow-right-s-line"></i> <a class="active">Tiền sân</a></div>
<div class="page-head">
    <div class="page-title">Tính tiền Sân theo Cơ sở</div>
    <button type="button" class="btn btn-primary" onclick="openTienSanModal()"><i class="ri-add-line"></i> Tạo Tiền
        sân</button>
</div>

@if (session('success'))
    <div class="badge green" style="display:block;padding:10px 14px;margin-bottom:16px;">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red" style="display:block;padding:10px 14px;margin-bottom:16px;">{{ session('error') }}</div>
@endif

<div class="table-card">
    <form method="GET" action="{{ route('tiensan.index') }}" class="table-toolbar">
        <div class="filters" style="align-items:flex-end;">
            <div class="field" style="margin:0;min-width:220px;">
                <label style="font-size:12.5px;margin-bottom:5px;">Cơ sở</label>
                <select name="co_so_id" onchange="this.form.submit()">
                    <option value="">Tất cả Cơ sở</option>
                    @foreach ($coSos as $cs)
                        <option value="{{ $cs->id }}" {{ request('co_so_id') == $cs->id ? 'selected' : '' }}>
                            {{ $cs->ten }} - {{ $cs->giaoVien->ho_ten ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if (request()->hasAny(['co_so_id']))
                <a href="{{ route('tiensan.index') }}" class="btn btn-outline btn-sm">Làm mới bộ lọc</a>
            @endif
        </div>
        <div class="text-2" style="font-size:13px;">{{ $tienSans->total() }} bản ghi</div>
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
                            <a href="{{ $ts->bill_url }}" target="_blank" rel="noopener">
                                <img src="{{ $ts->bill_url }}" alt="Bill"
                                    style="width:40px;height:40px;object-fit:cover;border-radius:8px;border:1px solid var(--border);">
                            </a>
                        @else
                            <span class="text-2">—</span>
                        @endif
                    </td>
                    <td class="text-2">{{ $ts->ghi_chu ?? '—' }}</td>
                    <td>
                        <div class="actions-cell">
                            <i class="ri-edit-line" onclick='openTienSanModal(@json($ts))'></i>
                            <form action="{{ route('tiensan.destroy', $ts) }}" method="POST" style="display:inline;"
                                class="confirm-delete-form" data-confirm-title="Xoá bản ghi Tiền sân"
                                data-confirm-message="Bạn có chắc muốn xoá bản ghi ngày {{ $ts->ngay->format('d/m/Y') }} của Cơ sở {{ $ts->coSo->ten }}?">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:none;padding:0;"><i
                                        class="ri-delete-bin-line del"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-2" style="text-align:center;padding:30px;">Chưa có bản ghi Tiền sân
                        nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        @if (!$tienSans->onFirstPage())
            <a href="{{ $tienSans->previousPageUrl() }}">Trước</a>
        @else
            <span style="opacity:.5;padding:8px 14px;">Trước</span>
        @endif
        @for ($i = 1; $i <= $tienSans->lastPage(); $i++)
            <a href="{{ $tienSans->url($i) }}"
                class="{{ $i == $tienSans->currentPage() ? 'active' : '' }}">{{ $i }}</a>
        @endfor
        @if ($tienSans->hasMorePages())
            <a href="{{ $tienSans->nextPageUrl() }}">Sau</a>
        @else
            <span style="opacity:.5;padding:8px 14px;">Sau</span>
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
