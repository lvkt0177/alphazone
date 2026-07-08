<div class="breadcrumb"><a>Trang chủ</a> <i class="ri-arrow-right-s-line"></i> <a class="active">Quản lý Giáo viên</a></div>
<div class="page-head">
  <div class="page-title">Quản lý Giáo viên</div>
  <button class="btn btn-primary" onclick="openTeacherModal()"><i class="ri-add-line"></i> Tạo Giáo viên</button>
</div>

@if (session('success'))
  <div class="badge green" style="display:block;padding:10px 14px;margin-bottom:16px;">{{ session('success') }}</div>
@endif

<div class="table-card">
  <table>
    <thead><tr><th>STT</th><th>Họ tên</th><th>Ngày sinh</th><th>Số điện thoại</th><th></th></tr></thead>
    <tbody>
      @forelse ($giaoViens as $gv)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>
            <div class="cell-user">
              <img src="https://ui-avatars.com/api/?name={{ urlencode($gv->ho_ten) }}&background=2563EB&color=fff&bold=true" alt="">
              <div class="name">{{ $gv->ho_ten }}</div>
            </div>
          </td>
          <td>{{ $gv->ngay_sinh?->format('d/m/Y') ?? '—' }}</td>
          <td>{{ $gv->sdt ?? '—' }}</td>
          <td>
            <div class="actions-cell">
              <i class="ri-edit-line"
                 onclick="openTeacherModal({{ $gv->id }}, {{ Js::from($gv->ho_ten) }}, {{ Js::from($gv->ngay_sinh?->format('Y-m-d')) }}, {{ Js::from($gv->sdt) }})"></i>
              <form action="{{ route('giaovien.destroy', $gv) }}" method="POST" style="display:inline;"
                    onsubmit="return confirm('Bạn có chắc muốn xoá giáo viên {{ addslashes($gv->ho_ten) }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background:none;border:none;padding:0;">
                  <i class="ri-delete-bin-line del"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-2" style="text-align:center;padding:30px;">Chưa có giáo viên nào</td></tr>
      @endforelse
    </tbody>
  </table>
</div>