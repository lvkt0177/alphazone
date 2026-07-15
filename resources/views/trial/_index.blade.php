<div class="breadcrumb"><a>Trang chủ</a> <i class="ri-arrow-right-s-line"></i> <a class="active">Trải nghiệm</a></div>
<div class="page-head">
    <div class="page-title">Học viên Trải nghiệm</div>
    <button class="btn btn-primary" onclick="openTrialModal()"><i class="ri-add-line"></i> Tạo Học viên Trải
        nghiệm</button>
</div>

@if (session('success'))
    <div class="badge green" style="display:block;padding:10px 14px;margin-bottom:16px;">{{ session('success') }}</div>
@endif

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/trial.css') }}">
@endpush

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Năm sinh</th>
                <th>Cơ sở</th>
                <th>Trạng thái</th>
                <th>Ghi chú</th>
                <th></th>
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
                    <td>{{ $t->nam_sinh ?? '—' }}</td>
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
                            <i class="ri-edit-line"
                                onclick="openTrialModal({{ $t->id }}, {{ Js::from($t->ho_ten) }}, {{ Js::from($t->nam_sinh) }}, {{ $t->trang_thai->value }}, {{ Js::from($t->ghi_chu) }}, {{ Js::from($t->coSos->pluck('id')) }})"></i>
                            @if ($t->trang_thai !== \App\Enum\TrangThaiLoaiDangKyTraiNghiem::DA_DANG_KY)
                                <form action="{{ route('trainghiem.destroy', $t) }}" method="POST"
                                    style="display:inline;" class="confirm-delete-form"
                                    data-confirm-title="Xoá học viên trải nghiệm"
                                    data-confirm-message="Bạn có chắc muốn xoá {{ $t->ho_ten }}?">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background:none;border:none;padding:0;"><i
                                            class="ri-delete-bin-line del"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-2" style="text-align:center;padding:30px;">Chưa có học viên trải
                        nghiệm nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        @if (!$traiNghiems->onFirstPage())
            <a href="{{ $traiNghiems->previousPageUrl() }}">Trước</a>
        @else
            <span style="opacity:.5;padding:8px 14px;">Trước</span>
        @endif
        @for ($i = 1; $i <= $traiNghiems->lastPage(); $i++)
            <a href="{{ $traiNghiems->url($i) }}"
                class="{{ $i == $traiNghiems->currentPage() ? 'active' : '' }}">{{ $i }}</a>
        @endfor
        @if ($traiNghiems->hasMorePages())
            <a href="{{ $traiNghiems->nextPageUrl() }}">Sau</a>
        @else
            <span style="opacity:.5;padding:8px 14px;">Sau</span>
        @endif
    </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            openTrialModal(
                {{ old('_editing_id') ? (int) old('_editing_id') : 'null' }},
                {{ Js::from(old('ho_ten')) }},
                {{ Js::from(old('nam_sinh')) }},
                {{ old('trang_thai') ?? 'null' }},
                {{ Js::from(old('ghi_chu')) }},
                {{ Js::from(old('co_so_ids', [])) }}
            );
        });
    </script>
@endif
