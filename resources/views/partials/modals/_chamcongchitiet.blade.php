<div class="overlay" id="chamCongChiTietModal">
    <div class="modal">
        <div class="modal-head">
            <div>
                <h3 id="cctTieuDe">Chấm công</h3>
                <div class="text-2 cct-phu-de">Chi tiết chấm công của Thầy phụ trách và Cộng tác viên</div>
            </div>
            <i class="ri-close-line" onclick="closeModal('chamCongChiTietModal')"></i>
        </div>

        <div class="modal-body">
            <div class="cct-nhom-label">
                <span class="cc-dot cc-dot--thay"></span>THẦY PHỤ TRÁCH
            </div>
            <div id="cctDanhSachThay" class="cct-danh-sach"></div>

            <div class="cct-nhom-label cct-nhom-label--spaced">
                <span class="cc-dot cc-dot--ctv"></span>CỘNG TÁC VIÊN
            </div>
            <div id="cctDanhSachCtv" class="cct-danh-sach"></div>
        </div>

        <div class="modal-foot">
            <button type="button" class="btn btn-outline" onclick="closeModal('chamCongChiTietModal')">Đóng</button>
        </div>
    </div>
</div>
