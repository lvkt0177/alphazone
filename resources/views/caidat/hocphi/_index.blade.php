<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a>Cài đặt</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Tiền học phí</a>
</div>

<div class="page-head">
    <div class="page-title">Cấu hình Tiền học phí theo số lượng Cơ sở</div>
    <button class="btn btn-primary" onclick="openCaiDatHocPhiModal()"><i class="ri-add-line"></i> Thêm cấu hình</button>
</div>

@if (session('success'))
    <div class="badge green caidathocphi-alert-success">{{ session('success') }}</div>
@endif

<div class="table-card">
    <div class="text-2 caidathocphi-note">
        "Giá 1 buổi" chỉ để tham khảo — được tự động tính bằng Học phí
        ÷ Tổng số buổi.
    </div>

    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Số lượng Cơ sở</th>
                <th>Học phí</th>
                <th>Tổng số buổi/tháng</th>
                <th>Giá 1 buổi (ước tính)</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($caiDats as $cd)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="caidathocphi-so-luong-cell">{{ $cd->so_luong_co_so }} cơ sở</td>
                    <td>{{ number_format($cd->hoc_phi, 0, ',', '.') }} đ</td>
                    <td>{{ $cd->tong_so_buoi }} buổi</td>
                    <td class="text-2">{{ number_format($cd->gia_1_buoi, 0, ',', '.') }} đ</td>
                    <td>
                        <div class="actions-cell">
                            <i class="ri-edit-line"
                                onclick="openCaiDatHocPhiModal({{ $cd->id }}, {{ $cd->so_luong_co_so }}, {{ $cd->hoc_phi }}, {{ $cd->tong_so_buoi }})"></i>
                            <form action="{{ route('caidathocphi.destroy', $cd) }}" method="POST"
                                class="caidathocphi-inline-form confirm-delete-form"
                                data-confirm-title="Xoá cấu hình học phí"
                                data-confirm-message="Bạn có chắc muốn xoá cấu hình cho {{ $cd->so_luong_co_so }} cơ sở?">
                                @csrf @method('DELETE')
                                <button type="submit" class="caidathocphi-icon-btn"><i
                                        class="ri-delete-bin-line del"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-2 caidathocphi-empty-row">Chưa có cấu hình học phí nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            openCaiDatHocPhiModal(
                {{ old('_editing_id') ? (int) old('_editing_id') : 'null' }},
                {{ old('so_luong_co_so') !== null ? (int) old('so_luong_co_so') : 'null' }},
                {{ old('hoc_phi') !== null ? (int) old('hoc_phi') : 'null' }},
                {{ old('tong_so_buoi') !== null ? (int) old('tong_so_buoi') : 'null' }}
            );
        });
    </script>
@endif