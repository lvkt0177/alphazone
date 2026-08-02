let ccDonGiaHienTai = 0;

function formatNgayHienThi(ngay) {
    const parts = String(ngay).split('-');
    if (parts.length !== 3) return ngay;
    return parts[2] + '/' + parts[1] + '/' + parts[0];
}

function openChamCongCtvModal(id, hoTen, ngay, donGia, soGio, hoTro, ghiChu, postUrl, deleteUrl, daTonTai) {
    ccDonGiaHienTai = donGia || 0;

    document.getElementById('ccModalTitle').textContent = (daTonTai ? 'Chỉnh sửa chấm công — ' : 'Chấm công — ') + hoTen;
    document.getElementById('ccModalNgay').textContent = 'Ngày ' + formatNgayHienThi(ngay);

    document.getElementById('cc_ngay').value = ngay;
    document.getElementById('cc_don_gia_display').value = formatMoney(donGia) + ' đ/giờ';

    document.getElementById('cc_so_gio').value = soGio === null || soGio === undefined ? '' : soGio;

    const hotroRaw = hoTro === null || hoTro === undefined ? '' : String(hoTro);
    document.getElementById('cc_hotro').value = hotroRaw;
    document.getElementById('cc_hotro_display').value = formatMoney(hotroRaw);

    document.getElementById('cc_ghi_chu').value = ghiChu || '';

    document.getElementById('chamCongCtvForm').action = postUrl;
    document.getElementById('chamCongCtvXoaForm').action = deleteUrl;
    document.getElementById('cc_xoa_ngay').value = ngay;

    document.getElementById('ccXoaBtn').style.display = daTonTai ? '' : 'none';

    capNhatSoTienDuKien();

    openModal('chamCongCtvModal');
}

function capNhatSoTienDuKien() {
    const soGio = parseFloat(document.getElementById('cc_so_gio').value) || 0;
    const soTien = Math.round(soGio * ccDonGiaHienTai);
    document.getElementById('cc_so_tien_du_kien').textContent = formatMoney(soTien) + ' đ';
}

function xoaChamCongCtv() {
    if (typeof confirmAction !== 'function') return;

    confirmAction('Xoá chấm công', 'Bạn có chắc muốn xoá bản ghi chấm công này?', function () {
        document.getElementById('chamCongCtvXoaForm').submit();
    });
}

document.addEventListener('DOMContentLoaded', function () {
    if (typeof attachMoneyFormatter === 'function') {
        attachMoneyFormatter('cc_hotro_display', 'cc_hotro');
    }
});