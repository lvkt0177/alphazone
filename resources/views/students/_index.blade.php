<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line">
    </i> <a class="active">Danh sách Học viên
    </a>
</div>
<div class="page-head">
    <div class="page-title">Danh sách Học viên</div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('hocvien.export', request()->query()) }}" class="btn btn-outline"><i
                class="ri-file-excel-2-line"></i> Xuất Excel</a>
        <a href="{{ route('hocvien.create') }}" class="btn btn-primary"><i class="ri-add-line"></i> Thêm Học viên</a>
    </div>
</div>

@if (session('success'))
    <div class="badge green" style="display:block;padding:10px 14px;margin-bottom:16px;">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red" style="display:block;padding:10px 14px;margin-bottom:16px;">{{ session('error') }}</div>
@endif

@php
    $soCotCoSo = max(3, $hocViens->max(fn($hv) => $hv->coSos->count()) ?? 0);
@endphp

<div class="table-card">
    <form method="GET" action="{{ route('hocvien.index') }}" class="table-toolbar">
        <div class="filters">
            <div class="search-mini"><i class="ri-search-line"></i>
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Tìm theo Mã số, Họ tên...">
            </div>
            <select name="co_so_id" onchange="this.form.submit()">
                <option value="">Tất cả Cơ sở</option>
                @foreach ($coSos as $cs)
                    <option value="{{ $cs->id }}" {{ request('co_so_id') == $cs->id ? 'selected' : '' }}>
                        {{ $cs->ten }} - {{ $cs->giaoVien->ho_ten ?? 'N/A' }}</option>
                @endforeach
            </select>
            <select name="trang_thai" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                @foreach (\App\Enum\TrangThaiHocVien::cases() as $st)
                    <option value="{{ $st->value }}" {{ request('trang_thai') == $st->value ? 'selected' : '' }}>
                        {{ $st->getLabel() }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
            @if (request()->hasAny(['q', 'co_so_id', 'trang_thai']))
                <a href="{{ route('hocvien.index') }}" class="btn btn-outline btn-sm">Làm mới bộ lọc</a>
            @endif
        </div>
        <div class="text-2" style="font-size:13px;">{{ $hocViens->total() }} học viên</div>
    </form>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Mã số</th>
                    <th>Họ tên</th>
                    <th>SĐT</th>
                    @for ($i = 1; $i <= $soCotCoSo; $i++)
                        <th style="white-space:nowrap;">Cơ sở {{ $i }}</th>
                    @endfor
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hocViens as $hv)
                    <tr>
                        <td>
                            <a href="{{ route('hocvien.show', $hv) }}" class="code-link">{{ $hv->ma_so }}</a>
                        </td>
                        <td>
                            <div class="cell-user"><img src="{{ $hv->avatar_url }}" alt="">
                                <div>
                                    <div class="name">{{ $hv->ho_ten }}</div>
                                    <div class="sub">{{ $hv->nickname }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $hv->sdt ?? '—' }}</td>
                        @php
                            $coSos = $hv->coSos->values();
                        @endphp
                        @for ($i = 0; $i < $soCotCoSo; $i++)
                            @php $coSo = $coSos->get($i); @endphp
                            <td>
                                @if ($coSo)
                                    {{ $coSo->ten }} - {{ $coSo->giaoVien->ho_ten ?? 'N/A' }}
                                @else
                                    -
                                @endif
                            </td>
                        @endfor
                        <td><span
                                class="badge {{ $hv->trang_thai->getBadge() }}">{{ $hv->trang_thai->getLabel() }}</span>
                        </td>
                        <td>
                            <div class="actions-cell">
                                <a href="{{ route('hocvien.show', $hv) }}" class=""><i
                                        class="ri-eye-line"></i></a>
                                <i class="ri-edit-line edit-student-btn" data-student='{{ json_encode($hv) }}'></i>
                                <form action="{{ route('hocvien.destroy', $hv) }}" method="POST"
                                    style="display:inline;" class="confirm-delete-form"
                                    data-confirm-title="Xoá học viên"
                                    data-confirm-message="Bạn có chắc muốn xoá {{ $hv->ho_ten }}?">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background:none;border:none;padding:0;"><i
                                            class="ri-delete-bin-line del"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 5 + $soCotCoSo }}" class="text-2" style="text-align:center;padding:30px;">Không
                            tìm thấy học viên phù hợp</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        @if (!$hocViens->onFirstPage())
            <a href="{{ $hocViens->previousPageUrl() }}">Trước</a>
        @else
            <span style="opacity:.5;padding:8px 14px;">Trước</span>
        @endif
        @for ($i = 1; $i <= $hocViens->lastPage(); $i++)
            <a href="{{ $hocViens->url($i) }}"
                class="{{ $i == $hocViens->currentPage() ? 'active' : '' }}">{{ $i }}</a>
        @endfor
        @if ($hocViens->hasMorePages())
            <a href="{{ $hocViens->nextPageUrl() }}">Sau</a>
        @else
            <span style="opacity:.5;padding:8px 14px;">Sau</span>
        @endif
    </div>
</div>

@push('modals')
    @include('partials.modals._student')
@endpush

@if ($errors->any() && old('_editing_id'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            openStudentModal({
                id: {{ (int) old('_editing_id') }},
                ma_so: {{ Js::from(old('ma_so')) }},
                ho_ten: {{ Js::from(old('ho_ten')) }},
                nickname: {{ Js::from(old('nickname')) }},
                ngay_sinh: {{ Js::from(old('ngay_sinh')) }},
                gioi_tinh: {{ old('gioi_tinh') ?? 1 }},
                sdt: {{ Js::from(old('sdt')) }},
                truong: {{ Js::from(old('truong')) }},
                dia_chi: {{ Js::from(old('dia_chi')) }},
                trang_thai: {{ old('trang_thai') ?? 1 }},
                avatar_url: 'https://ui-avatars.com/api/?name=' + encodeURIComponent(
                    {{ Js::from(old('ho_ten')) }} || 'HV'),
                co_sos: {{ Js::from(collect(old('co_so_ids', []))->map(fn($id) => ['id' => $id])) }}
            });
        });
    </script>
@endif
