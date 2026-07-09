<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Quản lý Cơ sở</a>
</div>

<div class="page-head">
    <div class="page-title">Quản lý Cơ sở</div>
    <button class="btn btn-primary" onclick="openBranchModal()"><i class="ri-add-line"></i> Tạo Cơ sở</button>
</div>

@if (session('error'))
    <div class="badge red" style="display:block;padding:10px 14px;margin-bottom:16px;">{{ session('error') }}</div>
@endif

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên cơ sở</th>
                <th>Người phụ trách</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($coSos as $b)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight:700;">{{ $b->ten }}</td>
                    <td>{{ $b->giaoVien->ho_ten }}</td>
                    <td>
                        <span class="badge {{ $b->trang_thai->getBadge() }}">{{ $b->trang_thai->getLabel() }}</span>
                    </td>
                    <td>
                        <div class="actions-cell">
                            <i class="ri-edit-line"
                                onclick="openBranchModal({{ $b->id }}, {{ Js::from($b->ten) }}, {{ $b->giao_vien_id }})"></i>

                            <form action="{{ route('coso.trangthai', $b) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" style="background:none;border:none;padding:0;"
                                    title="{{ $b->trang_thai === \App\Enum\TrangThaiCoSo::ACTIVE ? 'Ngừng hoạt động' : 'Kích hoạt lại' }}">
                                    <i
                                        class="ri-user-{{ $b->trang_thai === \App\Enum\TrangThaiCoSo::ACTIVE ? 'unfollow' : 'follow' }}-line"></i>
                                </button>
                            </form>

                            @if ($b->trang_thai === \App\Enum\TrangThaiCoSo::ACTIVE)
                                <form action="{{ route('coso.destroy', $b) }}" method="POST" style="display:inline;"
                                    onsubmit="
                                        event.preventDefault(); 
                                        confirmAction('Xoá cơ sở','Bạn có chắc muốn xoá cơ sở {{ addslashes($b->ten) }}?',()=>this.submit());">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none;border:none;padding:0;">
                                        <i class="ri-delete-bin-line del"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-2" style="text-align:center;padding:30px;">Chưa có cơ sở nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
