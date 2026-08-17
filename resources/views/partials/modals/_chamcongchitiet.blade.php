<div class="overlay" id="chamCongChiTietModal">
    <div class="modal">
        <div class="modal-head">
            <div class="cct-head-info">
                <span class="cct-head-icon"><i class="ri-calendar-check-line"></i></span>
                <div>
                    <h3 id="cctTieuDe">Chấm công</h3>
                    <div class="text-2 cct-phu-de">Chi tiết chấm công phân theo Chức danh và Cộng tác viên</div>
                </div>
            </div>
            <i class="ri-close-line cct-close" onclick="closeModal('chamCongChiTietModal')"></i>
        </div>

        <div class="modal-body">
            <div id="cctNhomTheoChucDanh"></div>

            <div class="cct-section">
                <div class="cct-nhom-label">
                    <span class="cc-dot cc-dot--ctv"></span>Cộng tác viên
                </div>
                <div id="cctDanhSachCtv" class="cct-danh-sach"></div>
            </div>
        </div>

        <div class="modal-foot">
            <button type="button" class="btn btn-outline" onclick="closeModal('chamCongChiTietModal')">Đóng</button>
        </div>
    </div>
</div>