<div class="breadcrumb">
    <a>Phiếu lương</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Cộng tác viên</a>
</div>
<div class="page-head">
    <div class="page-title">Phiếu lương Cộng tác viên</div>
    <div class="phieuluong-head-actions">
        @if (hasQuyen('phieuluongctv', 'xem'))
            <a href="{{ route('phieuluongctv.xuatexcel', ['thang' => $thang->format('Y-m')]) }}"
                class="btn btn-outline"><i class="ri-file-excel-2-line"></i> Xuất Excel</a>
        @endif
        @if (hasQuyen('phieuluongctv', 'them'))
            <a href="{{ route('phieuluongctv.create', ['thang' => $thang->format('Y-m')]) }}" class="btn btn-primary"><i
                    class="ri-add-line"></i> Tạo phiếu lương</a>
        @endif
    </div>
</div>

@if (session('success'))
    <div class="badge green phieuluong-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red phieuluong-alert-error">{{ session('error') }}</div>
@endif

<form method="GET" action="{{ route('phieuluongctv.index') }}" class="phieuluong-thang-bar">
    <label>Tháng</label>
    <input type="month" name="thang" value="{{ $thang->format('Y-m') }}" onchange="this.form.submit()">
</form>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Tên</th>
                <th>Mã nhân viên</th>
                <th>Tổng số giờ dạy</th>
                <th>Đơn giá/giờ</th>
                <th>Thành tiền</th>
                <th>Khấu trừ</th>
                <th>Thực nhận</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($phieus as $p)
                <tr>
                    <td>{{ $p->ho_ten_snapshot }}</td>
                    <td>{{ $p->ma_nhan_vien_snapshot ?? '—' }}</td>
                    <td>{{ rtrim(rtrim(number_format($p->tong_so_gio, 1), '0'), '.') }}</td>
                    <td>{{ number_format($p->don_gia, 0, ',', '.') }} đ</td>
                    <td>{{ number_format($p->thanh_tien, 0, ',', '.') }} đ</td>
                    <td>{{ $p->khau_tru !== null ? number_format($p->khau_tru, 0, ',', '.') . ' đ' : '—' }}</td>
                    <td>{{ number_format($p->thuc_nhan, 0, ',', '.') }} đ</td>
                    <td class="actions-cell">
                        @if (hasQuyen('phieuluongctv', 'sua'))
                            <a href="{{ route('phieuluongctv.edit', $p) }}"><i class="ri-edit-line"></i></a>
                        @endif
                        @if (hasQuyen('phieuluongctv', 'xoa'))
                            <form action="{{ route('phieuluongctv.destroy', $p) }}" method="POST"
                                class="phieuluong-inline-form confirm-delete-form" data-confirm-title="Xoá phiếu lương"
                                data-confirm-message="Bạn có chắc muốn xoá phiếu lương của {{ $p->ho_ten_snapshot }}?">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-trash"><i class="ri-delete-bin-line del"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-2 phieuluong-empty-row">Chưa có phiếu lương nào trong tháng
                        {{ $thang->format('m/Y') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
