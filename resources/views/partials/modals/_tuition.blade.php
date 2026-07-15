<div class="overlay" id="tuitionModal">
    <div class="modal">
        <div class="modal-head">
            <h3 id="tuitionModalTitle">Tạo Học phí</h3><i class="ri-close-line" onclick="closeModal('tuitionModal')"></i>
        </div>

        <form id="tuitionForm" method="POST" action="{{ route('hocphi.store') }}">
            @csrf
            <input type="hidden" name="hoc_vien_id" id="tu_hoc_vien_id">
            <input type="hidden" name="thang" id="tu_thang">
            <input type="hidden" name="hoc_phi" id="tu_fee_raw">
            <input type="hidden" name="dong_phuc" id="tu_uniform_raw">

            <div class="modal-body">
                <div class="form-grid">
                    <div class="field"><label>Mã số</label><input id="tu_code" type="text" readonly></div>
                    <div class="field"><label>Họ tên</label><input id="tu_name" type="text" readonly></div>
                    <div class="field">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:7px;">
                            <label style="margin:0;">Học phí (đ)</label>
                            <label
                                style="display:flex;align-items:center;gap:6px;font-size:12.5px;font-weight:600;color:var(--text-2);cursor:pointer;">
                                <span class="switch">
                                    <input type="checkbox" id="tu_gioi_thieu_ban" name="gioi_thieu_ban" value="1">
                                    <span class="switch-track"></span>
                                </span>
                                Giới thiệu bạn
                            </label>
                        </div>
                        <input id="tu_fee" type="text" inputmode="numeric" autocomplete="off"
                            placeholder="VD: 500,000">
                        @error('hoc_phi')
                            <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Đồng phục (đ)</label>
                        <input id="tu_uniform" type="text" inputmode="numeric" autocomplete="off"
                            placeholder="VD: 150,000">
                    </div>
                    <div class="field span-2">
                        <label>Ngày đóng</label>
                        <input id="tu_date" name="ngay_dong" type="date">
                        @error('ngay_dong')
                            <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-foot" style="justify-content:space-between;">
                <div id="tu_delete_wrap" style="display:none;">
                    <button type="button" class="btn btn-outline" id="tu_delete_btn"
                        style="color:#dc2626;border-color:#dc2626;">
                        <i class="ri-delete-bin-line"></i> Xoá bản ghi
                    </button>
                </div>
                <div style="display:flex;gap:8px;margin-left:auto;">
                    <button type="button" class="btn btn-outline" onclick="closeModal('tuitionModal')">Huỷ</button>
                    <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu học phí</button>
                </div>
            </div>
        </form>

        <form id="tuitionDeleteForm" method="POST" action="{{ route('hocphi.destroy') }}" style="display:none;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="hoc_vien_id" id="td_hoc_vien_id">
            <input type="hidden" name="thang" id="td_thang">
        </form>
    </div>
</div>
