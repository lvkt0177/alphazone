<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Quản lý Giáo viên</a>
</div>
<div class="page-head">
    <div class="page-title">Quản lý Giáo viên</div>
    <button class="btn btn-primary" onclick="openTeacherModal()"><i class="ri-add-line"></i> Tạo Giáo viên</button>
</div>

@if (session('error'))
    <div class="badge red" style="display:block;padding:10px 14px;margin-bottom:16px;">{{ session('error') }}</div>
@endif

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Ngày sinh</th>
                <th>Số điện thoại</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($giaoViens as $gv)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="cell-user">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($gv->ho_ten) }}&background=2563EB&color=fff&bold=true"
                                alt="">
                            <div class="name">{{ $gv->ho_ten }}</div>
                        </div>
                    </td>
                    <td>{{ $gv->ngay_sinh?->format('d/m/Y') ?? '—' }}</td>
                    <td>{{ $gv->sdt ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $gv->trang_thai->getBadge() }}">{{ $gv->trang_thai->getLabel() }}</span>
                    </td>
                    <td>
                        <div class="actions-cell">
                            <i class="ri-edit-line"
                                onclick="openTeacherModal({{ $gv->id }}, {{ Js::from($gv->ho_ten) }}, {{ Js::from($gv->ngay_sinh?->format('Y-m-d')) }}, {{ Js::from($gv->sdt) }})"></i>

                            <form action="{{ route('giaovien.trangthai', $gv) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" style="background:none;border:none;padding:0;"
                                    title="{{ $gv->trang_thai === \App\Enum\TrangThaiGiaoVien::DANG_DAY ? 'Cho nghỉ dạy' : 'Cho dạy lại' }}">
                                    <i
                                        class="ri-user-{{ $gv->trang_thai === \App\Enum\TrangThaiGiaoVien::DANG_DAY ? 'unfollow' : 'follow' }}-line"></i>
                                </button>
                            </form>
                            @if ($gv->trang_thai === \App\Enum\TrangThaiGiaoVien::DANG_DAY)
                                <form action="{{ route('giaovien.destroy', $gv) }}" method="POST"
                                    style="display:inline;"
                                    onsubmit="
                                      event.preventDefault(); 
                                      confirmAction('Xoá giáo viên','Bạn có chắc muốn xoá giáo viên {{ addslashes($gv->ho_ten) }}?',()=>this.submit());">
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
                    <td colspan="5" class="text-2" style="text-align:center;padding:30px;">Chưa có giáo viên nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
