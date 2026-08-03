<div class="breadcrumb">
    <a>Phiếu lương</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Nhân viên chính thức</a>
</div>
<div class="page-head">
    <div class="page-title">Phiếu lương Nhân viên chính thức</div>
    <div class="phieuluong-head-actions">
        @if (hasQuyen('phieuluongnhanvien', 'xem'))
            <a href="{{ route('phieuluongnhanvien.xuatexcel', ['thang' => $thang->format('Y-m')]) }}"
                class="btn btn-outline"><i class="ri-file-excel-2-line"></i> Xuất Excel</a>
        @endif
        @if (hasQuyen('phieuluongnhanvien', 'them'))
            <a href="{{ route('phieuluongnhanvien.create', ['thang' => $thang->format('Y-m')]) }}"
                class="btn btn-primary"><i class="ri-add-line"></i> Tạo phiếu lương</a>
        @endif
    </div>
</div>

@if (session('success'))
    <div class="badge green phieuluong-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red phieuluong-alert-error">{{ session('error') }}</div>
@endif

<form method="GET" action="{{ route('phieuluongnhanvien.index') }}" class="phieuluong-thang-bar">
    <label>Tháng</label>
    <input type="month" name="thang" value="{{ $thang->format('Y-m') }}" onchange="this.form.submit()">
</form>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Tên</th>
                <th>Mã nhân viên</th>
                <th>Ngày lương</th>
                <th>Lương thực nhận</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($phieus as $p)
                <tr>
                    <td>{{ $p->ho_ten_snapshot }}</td>
                    <td>{{ $p->ma_nhan_vien_snapshot ?? '—' }}</td>
                    <td>{{ $p->ngay_chot ? $p->ngay_chot->format('d/m/Y') : $thang->format('m/Y') }}</td>
                    <td>{{ number_format($p->luong_thuc_nhan, 0, ',', '.') }} đ</td>
                    <td class="actions-cell">
                        @if (hasQuyen('phieuluongnhanvien', 'sua'))
                            <a href="{{ route('phieuluongnhanvien.edit', $p) }}"><i class="ri-edit-line"></i></a>
                        @endif
                        @if (hasQuyen('phieuluongnhanvien', 'xoa'))
                            <form action="{{ route('phieuluongnhanvien.destroy', $p) }}" method="POST"
                                class="phieuluong-inline-form confirm-delete-form" data-confirm-title="Xoá phiếu lương"
                                data-confirm-message="Bạn có chắc muốn xoá phiếu lương của {{ $p->ho_ten_snapshot }}?">
                                @csrf @method('DELETE')
                                <button type="submit"><i class="ri-delete-bin-line del"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-2 phieuluong-empty-row">Chưa có phiếu lương nào trong tháng
                        {{ $thang->format('m/Y') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>