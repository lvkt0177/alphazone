<div class="breadcrumb"><a>Trang chủ</a> <i class="ri-arrow-right-s-line"></i> <a class="active">Điểm danh</a></div>
<div class="page-head">
    <div class="page-title">Điểm danh Học viên</div>
</div>

@if (session('success'))
    <div class="badge green" style="display:block;padding:10px 14px;margin-bottom:16px;">{{ session('success') }}</div>
@endif

<div class="table-card">
    <form method="GET" action="{{ route('diemdanh.index') }}" class="attendance-toolbar">
        <div class="filters">
            <div class="field" style="margin:0;min-width:220px;">
                <label style="font-size:12.5px;margin-bottom:5px;">Cơ sở</label>
                <select name="co_so_id" onchange="this.form.submit()">
                    @forelse ($coSos as $cs)
                        <option value="{{ $cs->id }}" {{ $selectedCoSoId == $cs->id ? 'selected' : '' }}>
                            {{ $cs->ten }} - {{ $cs->giaoVien->ho_ten ?? 'N/A' }}
                        </option>
                    @empty
                        <option value="">Chưa có Cơ sở nào đang hoạt động</option>
                    @endforelse
                </select>
            </div>

            <div class="field" style="margin:0;min-width:180px;">
                <label style="font-size:12.5px;margin-bottom:5px;">Ngày điểm danh</label>
                <input type="date" name="ngay" value="{{ $selectedDate }}" onchange="this.form.submit()">
            </div>
        </div>

        @if ($selectedCoSoId)
            <div class="text-2" style="font-size:13px;margin-top:10px;">
                Đang điểm danh cho <b>{{ optional($coSos->firstWhere('id', $selectedCoSoId))->ten }}</b>
                — ngày <b>{{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}</b>
            </div>
        @endif
    </form>

    {{-- Form lưu điểm danh --}}
    <form method="POST" action="{{ route('diemdanh.store') }}" id="attendanceForm">
        @csrf
        <input type="hidden" name="co_so_id" value="{{ $selectedCoSoId }}">
        <input type="hidden" name="ngay" value="{{ $selectedDate }}">

        <table>
            <thead>
                <tr>
                    <th>Mã số</th>
                    <th>Họ tên</th>
                    <th style="width:130px;">Đi học</th>
                    <th style="width:130px;">Vắng</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hocViens as $hv)
                    @php $rec = $existing->get($hv->id); @endphp
                    <tr>
                        <td>{{ $hv->ma_so }}</td>
                        <td>
                            <div class="cell-user"><img src="{{ $hv->avatar_url }}" alt="">
                                <div class="name">{{ $hv->ho_ten }}</div>
                            </div>
                        </td>
                        <td>
                            <input type="hidden" name="diem_danh[{{ $hv->id }}][hoc_vien_id]"
                                value="{{ $hv->id }}">
                            <label class="check-row">
                                <input type="radio" name="diem_danh[{{ $hv->id }}][trang_thai]" value="1"
                                    {{ !$rec || $rec->trang_thai->value == 1 ? 'checked' : '' }}> Đi học
                            </label>
                        </td>
                        <td>
                            <label class="check-row">
                                <input type="radio" name="diem_danh[{{ $hv->id }}][trang_thai]" value="2"
                                    {{ $rec && $rec->trang_thai->value == 2 ? 'checked' : '' }}> Vắng
                            </label>
                        </td>
                        <td>
                            <textarea class="note-input auto-grow" name="diem_danh[{{ $hv->id }}][ghi_chu]" rows="1" maxlength="150"
                                placeholder="Ghi chú (nếu có)">{{ $rec->ghi_chu ?? '' }}</textarea>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-2" style="text-align:center;padding:24px;">Cơ sở này chưa có học
                            viên đang hoạt động</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($hocViens->isNotEmpty())
            <div style="margin-top:18px;text-align:right;">
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu điểm danh</button>
            </div>
        @endif
    </form>
</div>
