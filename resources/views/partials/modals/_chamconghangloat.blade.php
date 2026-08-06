<div class="overlay" id="chamCongThemModal">
    <div class="modal">
        <div class="modal-head">
            <div>
                <h3>Chấm công</h3>
                <div class="text-2 cct-phu-de">Chọn tab tương ứng để chấm công cho từng đối tượng</div>
            </div>
            <i class="ri-close-line" onclick="closeModal('chamCongThemModal')"></i>
        </div>

        <div class="modal-body">
            <div class="cc-tab-switch">
                <div class="cc-tab-item cc-tab-item--active" id="ccTabThayBtn" onclick="ccChonTab('thay')">
                    <div class="cc-tab-title">I. Thầy phụ trách</div>
                    <div class="cc-tab-sub">Có / Không</div>
                </div>
                <div class="cc-tab-item" id="ccTabCtvBtn" onclick="ccChonTab('ctv')">
                    <div class="cc-tab-title">II. Cộng tác viên</div>
                    <div class="cc-tab-sub">Số giờ · Đơn giá</div>
                </div>
            </div>

            <div class="form-grid full">
                <div class="field">
                    <label>Ngày chấm công</label>
                    <input type="text" id="ccNgayHienThi" readonly>
                </div>
            </div>

            <div id="ccPanelThay">
                <div class="form-grid full">
                    <div class="field mt-2">
                        <label>Họ tên</label>
                        <select id="ccThayHoTen">
                            <option value="">-- Chọn Thầy phụ trách --</option>
                        </select>
                    </div>
                </div>

                <div class="field mt-2">
                    <label>Trạng thái</label>
                    <div class="cc-trangthai-switch">
                        <button type="button" class="cc-trangthai-btn cc-trangthai-btn--co cc-trangthai-btn--active"
                            id="ccThayCoBtn" onclick="ccChonTrangThai(true)">
                            <i class="ri-check-line"></i> Có mặt
                        </button>
                        <button type="button" class="cc-trangthai-btn cc-trangthai-btn--khong" id="ccThayKhongBtn"
                            onclick="ccChonTrangThai(false)">
                            <i class="ri-close-line"></i> Không
                        </button>
                    </div>
                </div>

                <div class="form-grid full mt-2">
                    <div class="field">
                        <label>Ghi chú</label>
                        <textarea class="textarea-thay-phu-trach" id="ccThayGhiChu" rows="2" placeholder="Ghi chú thêm (nếu có)..."></textarea>
                    </div>
                </div>

                <button type="button" class="btn btn-outline cc-btn-them" onclick="ccThemVaoDanhSach('thay')">
                    <i class="ri-add-line"></i> Thêm vào danh sách chấm công
                </button>
            </div>

            <div id="ccPanelCtv" style="display:none;">
                <div class="form-grid mt-2">
                    <div class="field">
                        <label>Họ tên</label>
                        <select id="ccCtvHoTen" onchange="ccCapNhatDonGia()">
                            <option value="">-- Chọn Cộng tác viên --</option>
                        </select>
                    </div>
                    <div class="field mt-2">
                        <label>Số giờ</label>
                        <input type="number" id="ccCtvSoGio" min="0" step="0.5" value="0"
                            oninput="ccTinhThanhTien()">
                    </div>
                </div>

                <div class="form-grid mt-2">
                    <div class="field">
                        <label>Đơn giá/giờ</label>
                        <input type="text" id="ccCtvDonGia" readonly>
                        <div class="text-2 cc-hint">Tự động lấy từ Cài đặt Tiền lương</div>
                    </div>
                    <div class="field mt-2">
                        <label>Hỗ trợ xăng xe</label>
                        <input type="number" id="ccCtvXangXe" min="0" value="0">
                    </div>
                </div>

                <div class="form-grid full mt-2">
                    <div class="field">
                        <label>Thành tiền (tạm tính)</label>
                        <input type="text" id="ccCtvThanhTien" readonly>
                    </div>
                </div>

                <div class="form-grid full mt-2">
                    <div class="field">
                        <label>Ghi chú</label>
                        <textarea id="ccCtvGhiChu" rows="2" placeholder="Ghi chú thêm (nếu có)..."></textarea>
                    </div>
                </div>

                <button type="button" class="btn btn-outline cc-btn-them" onclick="ccThemVaoDanhSach('ctv')">
                    <i class="ri-add-line"></i> Thêm vào danh sách chấm công
                </button>
            </div>

            <div class="cc-danhsachcho-label">Danh sách vừa thêm (chưa lưu)</div>
            <div id="ccDanhSachCho" class="cc-danhsachcho">
                <div class="text-2 cc-danhsachcho-trong">Chưa có mục nào — thêm ở form phía trên.</div>
            </div>
        </div>

        <div class="modal-foot">
            <button type="button" class="btn btn-outline" onclick="closeModal('chamCongThemModal')">Huỷ</button>
            <button type="button" class="btn btn-primary" onclick="ccLuuChamCong()">
                <i class="ri-save-line"></i> Lưu chấm công
            </button>
        </div>
    </div>
</div>

<form id="ccLuuForm" method="POST" action="{{ route('chamcong.luuhangloat') }}" style="display:none;">
    @csrf
    <input type="hidden" name="ngay" id="ccLuuNgay">
    <div id="ccLuuRowsContainer"></div>
</form>
