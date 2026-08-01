<div class="breadcrumb">
    <a href="{{ route('bieumau.menu') }}">Biểu mẫu</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">{{ $loaiBieuMau->getLabel() }}</a>
</div>
<div class="page-head">
    <div class="page-title">{{ $loaiBieuMau->getLabel() }}</div>
    <a href="{{ route('bieumau.menu') }}" class="btn btn-outline"><i class="ri-arrow-left-line"></i> Quay lại</a>
</div>

@if (session('success'))
    <div class="badge green bieumau-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red bieumau-alert-error">{{ session('error') }}</div>
@endif

@if (hasQuyen('bieumau', 'them'))
    <div class="card bieumau-upload-card">
        <form method="POST" action="{{ route('bieumau.store', ['loai' => $loaiBieuMau->value]) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="form-grid full">
                <div class="field">
                    <label>Tên biểu mẫu</label>
                    <input type="text" name="ten" value="{{ old('ten') }}" placeholder="VD: Mẫu hoàn tạm ứng tháng 8">
                    @error('ten')
                        <div class="badge red bieumau-field-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label>File (pdf, doc, docx, xls, xlsx — tối đa 30MB)</label>
                    <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx">
                    @error('file')
                        <div class="badge red bieumau-field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="bieumau-form-actions">
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
                <th>Tên biểu mẫu</th>
                <th>File</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bieuMaus as $bm)
                <tr>
                    <td>{{ $loop->iteration + ($bieuMaus->currentPage() - 1) * $bieuMaus->perPage() }}</td>
                    <td>{{ $bm->ten }}</td>
                    <td>
                        <div class="bieumau-file-cell">
                            <i class="ri-file-text-line"></i> {{ $bm->file_name_goc }}
                        </div>
                    </td>
                    <td>
                        <div class="actions-cell">
                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($bm->file_path) }}"
                                target="_blank" title="Tải file"><i class="ri-download-2-line"></i></a>
                            @if (hasQuyen('bieumau', 'sua'))
                                <i class="ri-edit-line"
                                    onclick="openBieuMauEditModal({{ $bm->id }}, {{ Js::from($bm->ten) }}, {{ Js::from(route('bieumau.update', $bm)) }})"></i>
                            @endif
                            @if (hasQuyen('bieumau', 'xoa'))
                                <form action="{{ route('bieumau.destroy', $bm) }}" method="POST"
                                    class="bieumau-inline-form confirm-delete-form" data-confirm-title="Xoá biểu mẫu"
                                    data-confirm-message="Bạn có chắc muốn xoá biểu mẫu {{ $bm->ten }}?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bieumau-icon-btn"><i
                                            class="ri-delete-bin-line del"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-2 bieumau-empty-row">Chưa có biểu mẫu nào được tải lên</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        @if (! $bieuMaus->onFirstPage())
            <a href="{{ $bieuMaus->previousPageUrl() }}">Trước</a>
        @else
            <span class="bieumau-page-disabled">Trước</span>
        @endif
        @for ($i = 1; $i <= $bieuMaus->lastPage(); $i++)
            <a href="{{ $bieuMaus->url($i) }}"
                class="{{ $i == $bieuMaus->currentPage() ? 'active' : '' }}">{{ $i }}</a>
        @endfor
        @if ($bieuMaus->hasMorePages())
            <a href="{{ $bieuMaus->nextPageUrl() }}">Sau</a>
        @else
            <span class="bieumau-page-disabled">Sau</span>
        @endif
    </div>
</div>

@if ($errors->any() && old('_editing_id'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            openBieuMauEditModal(
                {{ (int) old('_editing_id') }},
                {{ Js::from(old('ten')) }},
                {{ Js::from(route('bieumau.update', old('_editing_id'))) }}
            );
        });
    </script>
@endif