<div class="overlay" id="studentModal">
    <div class="modal wide">
        <div class="modal-head">
            <h3>Sửa Học viên</h3><i class="ri-close-line" onclick="closeModal('studentModal')"></i>
        </div>

        <form id="studentForm" method="POST" enctype="multipart/form-data" data-update-url-base="{{ url('hoc-vien') }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_editing_id" id="studentEditingId">

            <div class="modal-body">
                <div class="avatar-upload">
                    <div class="box"><img id="stuFormAvatarPreview" src="" alt=""></div>
                    <div>
                        <input type="file" name="avatar" id="f_avatar_input" accept="image/*" style="display:none"
                            onchange="previewStudentAvatar(this)">
                        <button type="button" class="btn btn-light btn-sm"
                            onclick="document.getElementById('f_avatar_input').click()"><i class="ri-upload-2-line"></i>
                            Đổi ảnh</button>
                        <div class="hint">jpg, png, tối đa 5MB. Để trống nếu không đổi ảnh.</div>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="field"><label>Mã số</label><input id="f_code" name="ma_so" type="text">
                        @error('ma_so')
                            <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field"><label>Họ tên</label><input id="f_name" name="ho_ten" type="text">
                        @error('ho_ten')
                            <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field"><label>Nickname</label><input id="f_nickname" name="nickname" type="text">
                    </div>
                    <div class="field"><label>Ngày sinh</label><input id="f_dob" name="ngay_sinh" type="date">
                    </div>
                    <div class="field span-2" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">
                        <div>
                            <label>Giới tính</label>
                            <select id="f_gender" name="gioi_tinh">
                                @foreach (\App\Enum\GioiTinh::cases() as $g)
                                    <option value="{{ $g->value }}">{{ $g->getLabel() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Chiều cao (cm)</label>
                            <input id="f_height" name="chieu_cao" type="number" step="0.1"
                                placeholder="VD: 145.5">
                            @error('chieu_cao')
                                <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label>Cân nặng (kg)</label>
                            <input id="f_weight" name="can_nang" type="number" step="0.1" placeholder="VD: 38.2">
                            @error('can_nang')
                                <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="field"><label>Số điện thoại</label><input id="f_phone" name="sdt" type="text">
                    </div>
                    <div class="field"><label>Trường</label><input id="f_school" name="truong" type="text"></div>
                    <div class="field span-2"><label>Địa chỉ</label><input id="f_address" name="dia_chi" type="text">
                    </div>
                    <div class="field span-2">
                        <label>Ghi chú</label>
                        <textarea id="f_note" name="ghi_chu" rows="3" placeholder="Ghi chú về học viên..."></textarea>
                        @error('ghi_chu')
                            <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field span-2">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                            <label style="margin:0;">Cơ sở (chọn ít nhất 1)</label>
                            @if (!empty($coSos))
                                <span id="stuBranchCount" class="badge purple" style="font-size:12px;">0 đã chọn</span>
                            @endif
                        </div>
                        @if (empty($coSos))
                            <div class="badge red">Chưa có cơ sở nào được tạo. Vui lòng tạo cơ sở trước.</div>
                        @else
                            <div style="display:flex;gap:8px;margin-bottom:10px;">
                                <div style="position:relative;flex:1;">
                                    <i class="ri-search-line"
                                        style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--text-2);font-size:15px;"></i>
                                    <input type="text" id="stuBranchSearch" placeholder="Tìm cơ sở..."
                                        oninput="locCoSoHocVien(this.value)"
                                        style="width:100%;padding:8px 12px 8px 32px;border:1px solid var(--border);border-radius:9px;background:var(--bg);">
                                </div>
                                {{-- <button type="button" class="btn btn-light btn-sm"
                                    onclick="chonTatCaCoSoHocVien(true)">Chọn tất cả</button> --}}
                                <button type="button" class="btn btn-light btn-sm"
                                    onclick="chonTatCaCoSoHocVien(false)">Bỏ chọn</button>
                            </div>

                            <div id="stu_branches"
                                style="display:flex;flex-wrap:wrap;gap:8px;padding:12px 14px;border:1px solid var(--border);border-radius:10px;background:var(--bg);">
                                @foreach ($coSos->sortBy(fn($cs) => (int) filter_var($cs->ten, FILTER_SANITIZE_NUMBER_INT) ?: $cs->id) as $cs)
                                    <label class="branch-chip" data-name="{{ strtolower($cs->ten) }}">
                                        <input type="checkbox" name="co_so_ids[]" value="{{ $cs->id }}"
                                            class="stu-branch-checkbox" onchange="capNhatSoLuongCoSoHocVien()">
                                        <span>{{ $cs->ten }} - {{ $cs->giaoVien->ho_ten ?? 'N/A' }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                        @error('co_so_ids')
                            <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field"><label>Trạng thái</label>
                        <select id="f_status" name="trang_thai">
                            @foreach (\App\Enum\TrangThaiHocVien::cases() as $st)
                                <option value="{{ $st->value }}">{{ $st->getLabel() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('studentModal')">Huỷ</button>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu học viên</button>
            </div>
        </form>
    </div>
</div>
