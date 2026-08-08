<div class="breadcrumb">
    <a href="{{ route('hoadon.dauvao.menu') }}">Hóa đơn đầu vào</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">{{ $loaiHoaDon->getLabel() }}</a>
</div>
<div class="page-head">
    <div class="page-title">Hóa đơn đầu vào - {{ $loaiHoaDon->getLabel() }}</div>
    <div class="hoadon-head-actions">
        <a href="{{ route('hoadon.dauvao.menu') }}" class="btn btn-outline"><i class="ri-arrow-left-line"></i> Quay lại</a>
    </div>
</div>

@if (session('success'))
    <div class="badge green hoadon-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red hoadon-alert-error">{{ session('error') }}</div>
@endif

@if (hasQuyen('hoadon', 'them'))
    <div class="card hoadon-upload-card">
        <form method="POST" action="{{ route('hoadon.dauvao.store', ['loai' => $loaiHoaDon->value]) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="form-grid full">
                <div class="field">
                    <label>Tên hóa đơn</label>
                    <input type="text" name="ten" value="{{ old('ten') }}"
                        placeholder="VD: Hóa đơn mua dụng cụ tháng 8">
                    @error('ten')
                        <div class="badge red hoadon-field-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label>Ngày tạo</label>
                    <input type="date" name="ngay_tao" value="{{ old('ngay_tao', now()->format('Y-m-d')) }}">
                    @error('ngay_tao')
                        <div class="badge red hoadon-field-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label>File (pdf, doc, docx, xls, xlsx — tối đa 30MB)</label>
                    <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx">
                    @error('file')
                        <div class="badge red hoadon-field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="hoadon-form-actions">
                <button type="submit" class="btn btn-primary"><i class="ri-upload-2-line"></i> Tải lên</button>
            </div>
        </form>
    </div>
@endif

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên hóa đơn</th>
                <th>Ngày tạo</th>
                <th>File</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hoaDons as $hd)
                <tr>
                    <td>{{ $loop->iteration + ($hoaDons->currentPage() - 1) * $hoaDons->perPage() }}</td>
                    <td>{{ $hd->ten }}</td>
                    <td>{{ $hd->ngay_tao?->format('d/m/Y') ?? '—' }}</td>
                    <td>
                        <div class="hoadon-file-cell">
                            <i class="ri-file-text-line"></i> {{ $hd->file_name_goc }}
                        </div>
                    </td>
                    <td>
                        <div class="actions-cell">
                            <a href="{{ route('hoadon.dauvao.download', $hd) }}" title="Tải file"><i
                                    class="ri-download-2-line"></i></a>
                            @if (hasQuyen('hoadon', 'sua'))
                                <i class="ri-edit-line"
                                    onclick="openHoaDonEditModal({{ $hd->id }}, {{ Js::from($hd->ten) }}, {{ Js::from($hd->ngay_tao?->format('Y-m-d')) }}, {{ Js::from(route('hoadon.dauvao.update', $hd)) }})"></i>
                            @endif
                            @if (hasQuyen('hoadon', 'xoa'))
                                <form action="{{ route('hoadon.dauvao.destroy', $hd) }}" method="POST"
                                    class="hoadon-inline-form confirm-delete-form" data-confirm-title="Xoá hóa đơn"
                                    data-confirm-message="Bạn có chắc muốn xoá hóa đơn {{ $hd->ten }}?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="hoadon-icon-btn"><i
                                            class="ri-delete-bin-line del"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-2 hoadon-empty-row">Chưa có hóa đơn nào được tải lên</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        @if (!$hoaDons->onFirstPage())
            <a href="{{ $hoaDons->previousPageUrl() }}">Trước</a>
        @else
            <span class="hoadon-page-disabled">Trước</span>
        @endif
        @for ($i = 1; $i <= $hoaDons->lastPage(); $i++)
            <a href="{{ $hoaDons->url($i) }}"
                class="{{ $i == $hoaDons->currentPage() ? 'active' : '' }}">{{ $i }}</a>
        @endfor
        @if ($hoaDons->hasMorePages())
            <a href="{{ $hoaDons->nextPageUrl() }}">Sau</a>
        @else
            <span class="hoadon-page-disabled">Sau</span>
        @endif
    </div>
</div>

@if ($errors->any() && old('_editing_id'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            openHoaDonEditModal(
                {{ (int) old('_editing_id') }},
                {{ Js::from(old('ten')) }},
                {{ Js::from(old('ngay_tao')) }},
                {{ Js::from(route('hoadon.dauvao.update', old('_editing_id'))) }}
            );
        });
    </script>
@endif