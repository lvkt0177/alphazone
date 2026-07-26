<div class="breadcrumb"><a>Trang chủ</a> <i class="ri-arrow-right-s-line"></i> <a class="active">Điểm danh</a></div>
<div class="page-head">
    <div class="page-title">Điểm danh Học viên</div>
</div>

@if (session('success'))
    <div class="badge green attendance-alert-success">{{ session('success') }}</div>
@endif

<div class="table-card">
    <form method="GET" action="{{ route('diemdanh.index') }}" class="attendance-toolbar">
        <div class="filters">
            <div class="field attendance-filter-field">
                <label class="attendance-filter-label">Cơ sở</label>
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

            <div class="field attendance-filter-field--date">
                <label class="attendance-filter-label">Ngày điểm danh</label>
                <input type="date" name="ngay" value="{{ $selectedDate }}" onchange="this.form.submit()">
            </div>
        </div>

        @if ($selectedCoSoId)
            <div class="text-2 attendance-status-line">
                Đang điểm danh cho <b>{{ optional($coSos->firstWhere('id', $selectedCoSoId))->ten }}</b>
                — ngày <b>{{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}</b>
            </div>

            <div class="attendance-hocbu-btn-wrap">
                <button type="button" class="btn btn-outline btn-sm" onclick="openModal('hocBuModal')">
                    <i class="ri-user-add-line"></i> Học viên học bù
                </button>
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
                    <th class="attendance-col-checkbox">Đi học</th>
                    <th class="attendance-col-checkbox">Vắng</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody id="attendanceTbody">
                @forelse ($hocViens as $hv)
                    @php $rec = $existing->get($hv->id); @endphp
                    <tr>
                        <td><a href="{{ route('hocvien.show', $hv) }}" class="code-link">{{ $hv->ma_so }}</a></td>
                        <td>
                            <div class="cell-user"><img src="{{ $hv->avatar_url }}" alt="">
                                <div class="name">{{ $hv->ho_ten }}</div>
                            </div>
                        </td>
                        <td>
                            <input type="hidden" name="diem_danh[{{ $hv->id }}][hoc_vien_id]"
                                value="{{ $hv->id }}">
                            <input type="hidden" name="diem_danh[{{ $hv->id }}][hoc_bu]" value="0">
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
                    @if ($hocViensBu->isEmpty())
                        <tr id="attendanceEmptyRow">
                            <td colspan="5" class="text-2 attendance-empty-row">Cơ sở này chưa có
                                học
                                viên đang hoạt động</td>
                        </tr>
                    @endif
                @endforelse

                @foreach ($hocViensBu as $hv)
                    @php
                        $rec = $existing->get($hv->id);
                    @endphp
                    <tr class="attendance-row-hocbu">
                        <td><a href="{{ route('hocvien.show', $hv) }}" class="code-link">{{ $hv->ma_so }}</a></td>
                        <td>
                            <div class="cell-user"><img src="{{ $hv->avatar_url }}" alt="">
                                <div class="attendance-user-info">
                                    <div class="name">{{ $hv->ho_ten }}</div>
                                    <div class="attendance-hocbu-meta">
                                        <span class="badge orange attendance-hocbu-badge">Học bù</span>
                                        <i class="ri-close-circle-line del attendance-hocbu-del"
                                            onclick="xoaHocVienHocBu('{{ route('diemdanh.hocbu.destroy', $rec) }}', {{ Js::from($hv->ho_ten) }})"></i>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="hidden" name="diem_danh[{{ $hv->id }}][hoc_vien_id]"
                                value="{{ $hv->id }}">
                            <input type="hidden" name="diem_danh[{{ $hv->id }}][hoc_bu]" value="1">
                            <label class="check-row">
                                <input type="radio" name="diem_danh[{{ $hv->id }}][trang_thai]" value="1"
                                    {{ !$rec || $rec->trang_thai->value == 1 ? 'checked' : '' }}> Đi
                                học
                            </label>
                        </td>
                        <td>
                            <label class="check-row">
                                <input type="radio" name="diem_danh[{{ $hv->id }}][trang_thai]" value="2"
                                    {{ $rec && $rec->trang_thai->value == 2 ? 'checked' : '' }}> Vắng
                            </label>
                        </td>
                        <td>
                            <textarea class="note-input auto-grow" name="diem_danh[{{ $hv->id }}][ghi_chu]" rows="1"
                                maxlength="150" placeholder="Ghi chú (nếu có)">{{ $rec->ghi_chu ?? '' }}</textarea>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="attendance-save-wrap" id="attendanceSaveWrap">
            <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu điểm danh</button>
        </div>
    </form>

    <form id="deleteHocBuForm" method="POST" class="attendance-hidden-form">
        @csrf
        @method('DELETE')
    </form>
</div>

@if ($selectedCoSoId)
    <div class="overlay" id="hocBuModal">
        <div class="modal">
            <div class="modal-head">
                <h3>Thêm Học viên học bù</h3>
                <i class="ri-close-line" onclick="closeModal('hocBuModal')"></i>
            </div>
            <form method="POST" action="{{ route('diemdanh.hocbu') }}" id="hocBuForm">
                @csrf
                <input type="hidden" name="co_so_id" value="{{ $selectedCoSoId }}">
                <input type="hidden" name="ngay" value="{{ $selectedDate }}">
                <input type="hidden" name="hoc_vien_id" id="hb_hoc_vien_id">

                <div class="modal-body modal-hoc-vien-hoc-bu">
                    <div class="field">
                        <label>Chọn học viên (không thuộc Cơ sở này)</label>
                        <div class="attendance-search-wrap">
                            <input type="text" id="hb_search" autocomplete="off"
                                placeholder="Tìm theo Mã số hoặc Họ tên...">
                            <div id="hb_list" class="attendance-search-list">
                            </div>
                        </div>
                        <div id="hbEmptyMsg" class="badge red attendance-hocbu-empty{{ $hocViensChoHocBu->isNotEmpty() ? ' attendance-hidden' : '' }}">
                            Không còn học viên nào để thêm học bù.
                        </div>
                    </div>
                    <div class="small-note attendance-hocbu-note">
                        Sau khi thêm, học viên sẽ xuất hiện trong bảng điểm danh bên dưới (đánh dấu "Học bù") — tick Đi
                        học/Vắng rồi bấm "Lưu điểm danh" như bình thường.
                    </div>
                </div>
                <div class="modal-foot">
                    <button type="button" class="btn btn-outline" onclick="closeModal('hocBuModal')">Huỷ</button>
                    <button type="submit" class="btn btn-primary" id="hb_submit_btn" disabled>
                        <i class="ri-add-line"></i> Thêm vào danh sách
                    </button>
                </div>
            </form>
        </div>
    </div>

    @php
        $hocVienChoHocBuData = $hocViensChoHocBu->map(function ($hv) {
            return [
                'id' => $hv->id,
                'ma_so' => $hv->ma_so,
                'ho_ten' => $hv->ho_ten,
                'avatar_url' => $hv->avatar_url,
            ];
        });
    @endphp
    <script>
        window.__hocVienChoHocBu = @json($hocVienChoHocBuData);
        window.__hocVienShowUrlBase = @json(url('hoc-vien'));
    </script>
@endif