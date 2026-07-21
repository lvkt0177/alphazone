@extends('layouts.admin')
@section('title', 'Thêm Học viên')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/student.css') }}">
    @endpush
    <div class="breadcrumb">
        <a href="{{ route('hocvien.index') }}">Danh sách Học viên</a> <i class="ri-arrow-right-s-line"></i> <a
            class="active">Thêm Học viên</a>
    </div>
    <div class="page-head">
        <div class="page-title">Thêm Học viên mới</div>
    </div>

    <div style="display:grid;grid-template-columns:1.4fr 1fr;gap:20px;align-items:start;">

        <form class="form-card" method="POST" action="{{ route('hocvien.store') }}" enctype="multipart/form-data"
            id="createStudentForm">
            @csrf
            <input type="hidden" name="tu_trai_nghiem_id" id="tu_trai_nghiem_id" value="{{ old('tu_trai_nghiem_id') }}">

            <div class="avatar-upload">
                <div class="box"><img id="createAvatarPreview"
                        src="https://ui-avatars.com/api/?name=Hoc+Vien&background=EFEAFB&color=6C5DD3&bold=true"
                        alt=""></div>
                <div>
                    <input type="file" name="avatar" id="createAvatarInput" accept="image/*" style="display:none"
                        onchange="previewCreateAvatar(this)">
                    <button type="button" class="btn btn-light btn-sm"
                        onclick="document.getElementById('createAvatarInput').click()"><i class="ri-upload-2-line"></i> Tải
                        ảnh lên</button>
                    <div class="hint">jpg, png, tối đa 2MB (không bắt buộc)</div>
                </div>
            </div>

            <div id="tuTraiNghiemBanner" style="display:none;margin-bottom:16px;">
                <div class="badge purple"
                    style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;">
                    <span>Đang tạo từ Học viên trải nghiệm: <b id="tuTraiNghiemName"></b></span>
                    <span style="cursor:pointer;" onclick="boChonTraiNghiem()"><i class="ri-close-line"></i></span>
                </div>
            </div>

            <div class="form-grid">
                <div class="field"><label>Mã số</label>
                    <input name="ma_so" value="{{ old('ma_so') }}" type="text" id="c_ma_so" autocomplete="off"
                        oninput="goiYMaSo(this.value)" data-suggest-url="{{ route('hocvien.goiymaso') }}">
                    <div id="maSoHint" class="text-2" style="font-size:12px;margin-top:5px;min-height:16px;"></div>
                    @error('ma_so')
                        <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field"><label>Họ tên</label><input id="c_name" name="ho_ten" value="{{ old('ho_ten') }}"
                        type="text">
                    @error('ho_ten')
                        <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field"><label>Nickname</label><input name="nickname" value="{{ old('nickname') }}"
                        type="text"></div>
                <div class="field"><label>Ngày sinh</label><input id="c_dob" name="ngay_sinh"
                        value="{{ old('ngay_sinh') }}" type="date"></div>
                <div class="field"><label>Giới tính</label>
                    <select name="gioi_tinh">
                        @foreach (\App\Enum\GioiTinh::cases() as $g)
                            <option value="{{ $g->value }}" {{ old('gioi_tinh') == $g->value ? 'selected' : '' }}>
                                {{ $g->getLabel() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field"><label>Số điện thoại</label><input name="sdt" value="{{ old('sdt') }}"
                        type="text">
                    @error('sdt')
                        <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field"><label>Trường</label><input name="truong" value="{{ old('truong') }}" type="text">
                </div>
                <div class="field span-2"><label>Địa chỉ</label><input name="dia_chi" value="{{ old('dia_chi') }}"
                        type="text"></div>
                <div class="field span-2">
                    <label>Ghi chú</label>
                    <textarea name="ghi_chu" rows="3" placeholder="Ghi chú về học viên">{{ old('ghi_chu') }}</textarea>
                    @error('ghi_chu')
                        <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field span-2">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <label style="margin:0;">Cơ sở (chọn ít nhất 1 cơ sở)</label>
                        <span id="branchCount" class="badge purple" style="font-size:12px;">0 đã chọn</span>
                    </div>

                    <div style="display:flex;gap:8px;margin-bottom:10px;">
                        <div style="position:relative;flex:1;">
                            <i class="ri-search-line"
                                style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--text-2);font-size:15px;"></i>
                            <input type="text" id="branchSearch" placeholder="Tìm cơ sở..."
                                style="width:100%;padding:8px 12px 8px 32px;border:1px solid var(--border);border-radius:9px;background:var(--bg);">
                        </div>
                        {{-- <button type="button" class="btn btn-light btn-sm" onclick="chonTatCaCoSo(true)">Chọn tất
                            cả</button> --}}
                        <button type="button" class="btn btn-light btn-sm" onclick="chonTatCaCoSo(false)">Bỏ
                            chọn</button>
                    </div>

                    <div id="c_branches"
                        style="display:flex;flex-wrap:wrap;gap:8px;padding:12px 14px;border:1px solid var(--border);border-radius:10px;background:var(--bg);">
                        @foreach ($coSos->sortBy(fn($cs) => (int) filter_var($cs->ten, FILTER_SANITIZE_NUMBER_INT) ?: $cs->id) as $cs)
                            <label class="branch-chip" data-name="{{ strtolower($cs->ten) }}">
                                <input type="checkbox" name="co_so_ids[]" value="{{ $cs->id }}"
                                    class="create-branch-checkbox"
                                    {{ in_array($cs->id, old('co_so_ids', [])) ? 'checked' : '' }}
                                    onchange="capNhatSoLuongCoSo()">
                                <span>{{ $cs->ten }} - {{ $cs->giaoVien->ho_ten ?? 'N/A' }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('co_so_ids')
                        <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field"><label>Trạng thái</label>
                    <select name="trang_thai">
                        @foreach (\App\Enum\TrangThaiHocVien::cases() as $st)
                            <option value="{{ $st->value }}"
                                {{ old('trang_thai', 1) == $st->value ? 'selected' : '' }}>{{ $st->getLabel() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Tạo học viên</button>
                <a href="{{ route('hocvien.index') }}" class="btn btn-outline">Huỷ</a>
            </div>
        </form>

        <div class="card">
            <div class="card-head">
                <h3><i class="ri-user-star-line"></i> Chọn từ Học viên trải nghiệm</h3>
            </div>
            <div class="search-mini" style="position:relative;margin-bottom:14px;">
                <i class="ri-search-line"
                    style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--text-2);font-size:15px;"></i>
                <input type="text" id="traiNghiemSearch" placeholder="Tìm theo tên..." oninput="locTraiNghiem()"
                    style="width:100%;padding:9px 13px 9px 32px;border:1px solid var(--border);border-radius:9px;background:var(--bg);">
            </div>
            <div class="row-list" id="traiNghiemList" style="max-height:520px;overflow-y:auto;">
                @forelse ($traiNghiems as $t)
                    <div class="item tn-item" data-name="{{ strtolower($t->ho_ten) }}" style="cursor:pointer;"
                        onclick='chonTraiNghiem(@json($t))'>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($t->ho_ten) }}&background=FFA45C&color=fff&bold=true"
                            alt="">
                        <div class="info">
                            <div class="t">{{ $t->ho_ten }}</div>
                            <div class="s">{{ $t->nam_sinh ?? '—' }} •
                                {{ $t->coSos->pluck('ten')->join(', ') ?: 'Chưa xếp cơ sở' }}</div>
                        </div>
                        <span class="badge {{ $t->trang_thai->getBadge() }}">{{ $t->trang_thai->getLabel() }}</span>
                    </div>
                @empty
                    <div class="text-2" style="text-align:center;padding:20px;">Không có học viên trải nghiệm nào chưa
                        đăng ký</div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/pages/students-create.js') }}"></script>
        <script src="{{ asset('js/modals/branches-modal.js') }}"></script>
    @endpush
@endsection
