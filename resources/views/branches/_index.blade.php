<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Quản lý Cơ sở</a>
</div>

<div class="page-head">
    <div class="page-title">Quản lý Cơ sở</div>
    @if (hasQuyen('coso', 'them'))
        <button class="btn btn-primary" onclick="openBranchModal()"><i class="ri-add-line"></i> Tạo Cơ sở</button>
    @endif
</div>

@if (session('error'))
    <div class="badge red branches-alert-error">{{ session('error') }}</div>
@endif

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên cơ sở</th>
                <th>Địa điểm</th>
                <th>Người phụ trách</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($coSos as $b)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="branches-name-cell">{{ $b->ten }}</td>
                    <td>
                        @if ($b->diaDiem)
                            <span class="badge purple">{{ $b->diaDiem->ten }}</span>
                        @else
                            <span class="text-2">—</span>
                        @endif
                    </td>
                    <td>{{ $b->giaoVien ? $b->giaoVien->ho_ten : 'N/A' }}</td>
                    <td>
                        <span class="badge {{ $b->trang_thai->getBadge() }}">{{ $b->trang_thai->getLabel() }}</span>
                    </td>
                    <td>
                        <div class="actions-cell">
                            @if (hasQuyen('coso', 'sua'))
                                <i class="ri-edit-line"
                                    onclick="openBranchModal({{ $b->id }}, {{ Js::from($b->ten) }}, {{ $b->giao_vien_id ?? 'null' }}, {{ $b->dia_diem_id ?? 'null' }})"></i>

                                <form action="{{ route('coso.trangthai', $b) }}" method="POST" class="branches-inline-form">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="branches-icon-btn"
                                        title="{{ $b->trang_thai === \App\Enum\TrangThaiCoSo::ACTIVE ? 'Ngừng hoạt động' : 'Kích hoạt lại' }}">
                                        <i
                                            class="ri-user-{{ $b->trang_thai === \App\Enum\TrangThaiCoSo::ACTIVE ? 'unfollow' : 'follow' }}-line"></i>
                                    </button>
                                </form>
                            @endif

                            @if ($b->trang_thai === \App\Enum\TrangThaiCoSo::ACTIVE && hasQuyen('coso', 'xoa'))
                                <form action="{{ route('coso.destroy', $b) }}" method="POST" class="branches-inline-form confirm-delete-form"
                                    data-confirm-title="Xoá cơ sở"
                                    data-confirm-message="Bạn có chắc muốn xoá cơ sở {{ $b->ten }}?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="branches-icon-btn"><i
                                            class="ri-delete-bin-line del"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-2 branches-empty-row">Chưa có cơ sở nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            openBranchModal(
                {{ old('_editing_id') ? (int) old('_editing_id') : 'null' }},
                {{ Js::from(old('ten')) }},
                {{ old('giao_vien_id') ? (int) old('giao_vien_id') : 'null' }},
                {{ old('dia_diem_id') === 'new' ? "'new'" : (old('dia_diem_id') ? (int) old('dia_diem_id') : 'null') }}
            );
        });
    </script>
@endif