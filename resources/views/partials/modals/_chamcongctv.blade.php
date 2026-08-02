<div class="overlay" id="chamCongCtvModal">
    <div class="modal">
        <div class="modal-head">
            <div>
                <h3 id="ccModalTitle">Chấm công</h3>
                <div class="text-2" id="ccModalNgay"></div>
            </div>
            <i class="ri-close-line" onclick="closeModal('chamCongCtvModal')"></i>
        </div>

        <form id="chamCongCtvForm" method="POST">
            @csrf
            <input type="hidden" name="ngay" id="cc_ngay">

            <div class="modal-body">
                <div class="form-grid full">
                    <div class="field">
                        <label>Đơn giá/giờ</label>
                        <input type="text" id="cc_don_gia_display" readonly>
                    </div>
                    <div class="field">
                        <label>Số giờ</label>
                        <input type="number" name="so_gio" id="cc_so_gio" min="0" max="24" step="0.5"
                            placeholder="0" oninput="capNhatSoTienDuKien()">
                        @error('so_gio')
                            <div class="badge red chamcong-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <div class="chamcong-so-tien-duoc-tinh">Số tiền dự kiến: <strong id="cc_so_tien_du_kien">0
                                đ</strong></div>
                    </div>
                    <div class="field">
                        <label>Hỗ trợ xăng xe</label>
                        <input type="text" id="cc_hotro_display" inputmode="numeric" autocomplete="off"
                            placeholder="0">
                        <input type="hidden" name="ho_tro_xang_xe" id="cc_hotro">
                        @error('ho_tro_xang_xe')
                            <div class="badge red chamcong-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Ghi chú</label>
                        <input type="text" name="ghi_chu" id="cc_ghi_chu" placeholder="Tuỳ chọn...">
                        @error('ghi_chu')
                            <div class="badge red chamcong-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('chamCongCtvModal')">Huỷ</button>
                <button type="button" class="btn btn-outline" id="ccXoaBtn" onclick="xoaChamCongCtv()"
                    style="display:none;color:var(--red);border-color:var(--red);">
                    <i class="ri-delete-bin-line"></i> Xoá chấm công
                </button>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu</button>
            </div>
        </form>

        <form id="chamCongCtvXoaForm" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="ngay" id="cc_xoa_ngay">
        </form>
    </div>
</div>
