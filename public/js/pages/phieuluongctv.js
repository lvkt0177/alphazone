let ctvDonGiaHienTai = 0;
let ctvSoGioHienTai = 0;

function chonGiaoVien(id) {
    const data = (window.__plDuLieuGiaoVien || {})[id];
    if (!data) return;

    document.querySelectorAll('.phieuluong-chon-item').forEach(function (el) {
        el.classList.toggle('active', el.dataset.id === String(id));
    });

    document.getElementById('pl_giao_vien_id').value = id;
    document.getElementById('pl_ten').value = data.ho_ten || '';
    document.getElementById('pl_ma_nv').value = data.ma_nhan_vien || '';
    document.getElementById('pl_tong_so_gio').value = (data.tong_so_gio || 0) + ' giờ';
    document.getElementById('pl_don_gia').value = formatMoney(data.don_gia || 0) + ' đ/giờ';

    ctvDonGiaHienTai = data.don_gia || 0;
    ctvSoGioHienTai = data.tong_so_gio || 0;

    document.getElementById('chuaChonHint').style.display = 'none';
    document.getElementById('formBody').style.display = '';

    ctvTinhLai();
}

function ctvTinhLai() {
    const khauTru = parseInt(document.getElementById('pl_khau_tru').value, 10) || 0;
    const thanhTien = Math.round(ctvSoGioHienTai * ctvDonGiaHienTai);
    const thucNhan = thanhTien - khauTru;

    document.getElementById('ktThanhTien').textContent = formatMoney(thanhTien) + ' đ';
    document.getElementById('ktThucNhan').textContent = formatMoney(thucNhan) + ' đ';
}

document.addEventListener('DOMContentLoaded', function () {
    if (typeof attachMoneyFormatter !== 'function') return;

    attachMoneyFormatter('pl_khau_tru_display', 'pl_khau_tru');

    const khauTruDisplay = document.getElementById('pl_khau_tru_display');
    if (khauTruDisplay) khauTruDisplay.addEventListener('input', ctvTinhLai);
});