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
                        <input type="file" name="avatar" id="f_avatar_input" accept="image/*" class="student-hidden-file-input"
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
                            <div class="badge red student-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field"><label>Họ tên</label><input id="f_name" name="ho_ten" type="text">
                        @error('ho_ten')
                            <div class="badge red student-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field"><label>Nickname</label><input id="f_nickname" name="nickname" type="text">
                    </div>
                    <div class="field"><label>Ngày sinh</label><input id="f_dob" name="ngay_sinh" type="date">
                    </div>
                    <div class="field span-2 student-triple-col">
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
                                <div class="badge red student-field-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label>Cân nặng (kg)</label>
                            <input id="f_weight" name="can_nang" type="number" step="0.1" placeholder="VD: 38.2">
                            @error('can_nang')
                                <div class="badge red student-field-error">{{ $message }}</div>
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
                            <div class="badge red student-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field span-2">
                        <div class="student-branch-head">
                            <label class="student-label-flush">Cơ sở (chọn ít nhất 1)</label>
                            @if (!empty($coSos))
                                <span id="stuBranchCount" class="badge purple student-branch-count">0 đã chọn</span>
                            @endif
                        </div>
                        @if (empty($coSos))
                            <div class="badge red">Chưa có cơ sở nào được tạo. Vui lòng tạo cơ sở trước.</div>
                        @else
                            <div class="student-branch-toolbar">
                                <div class="search-mini student-search-wrap">
                                    <i class="ri-search-line"></i>
                                    <input type="text" id="stuBranchSearch" placeholder="Tìm cơ sở..."
                                        oninput="locCoSoHocVien(this.value)"
                                        class="student-branch-search-input">
                                </div>
                                {{-- <button type="button" class="btn btn-light btn-sm"
                                    onclick="chonTatCaCoSoHocVien(true)">Chọn tất cả</button> --}}
                                <button type="button" class="btn btn-light btn-sm"
                                    onclick="chonTatCaCoSoHocVien(false)">Bỏ chọn</button>
                            </div>

                            <div id="stu_branches"
                                class="student-branch-chips">
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
                            <div class="badge red student-field-error">{{ $message }}</div>
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