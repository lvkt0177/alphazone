let ctvDonGiaHienTai = 0;
let ctvSoGioHienTai = 0;

function renderCtvLichSuNgay(chiTietNgay, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    if (!chiTietNgay || chiTietNgay.length === 0) {
        container.innerHTML = '<div class="text-2">Không có dữ liệu ngày đi làm trong tháng</div>';
        return;
    }

    let html = '<div class="ctv-lichsu-title"><span>Lịch sử các ngày trong tháng</span><span>(🟢 Có đi làm / ⚪ Nghỉ)</span></div>';
    html += '<div class="ctv-ngay-grid">';

    chiTietNgay.forEach((item) => {
        const activeClass = item.co_lam ? 'ctv-ngay-cell--active' : 'ctv-ngay-cell--inactive';
        const titleAttr = `Ngày ${item.ngay}: ${item.co_lam ? item.so_gio + ' giờ dạy' + (item.ho_tro_xang_xe ? ', Xăng xe: ' + formatMoney(item.ho_tro_xang_xe) : '') : 'Không làm'}`;
        html += `<div class="ctv-ngay-cell ${activeClass}" title="${titleAttr}">`;
        html += `<div class="ctv-ngay-so">${item.ngay}</div>`;
        html += `<div class="ctv-ngay-gio">${item.co_lam ? item.so_gio + 'h' : '-'}</div>`;
        html += `</div>`;
    });

    html += '</div>';
    container.innerHTML = html;
}

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

    const troCap = data.tro_cap || 0;
    document.getElementById('pl_tro_cap').value = troCap;
    document.getElementById('pl_tro_cap_display').value = formatMoney(troCap);

    renderCtvLichSuNgay(data.chi_tiet_ngay, 'ctvLichSuNgayContainer');

    ctvDonGiaHienTai = data.don_gia || 0;
    ctvSoGioHienTai = data.tong_so_gio || 0;

    document.getElementById('chuaChonHint').style.display = 'none';
    document.getElementById('formBody').style.display = '';

    ctvTinhLai();
}

function ctvTinhLai() {
    const troCap = parseInt(document.getElementById('pl_tro_cap').value, 10) || 0;
    const khauTru = parseInt(document.getElementById('pl_khau_tru').value, 10) || 0;
    const thanhTien = Math.round(ctvSoGioHienTai * ctvDonGiaHienTai);
    const thucNhan = thanhTien + troCap - khauTru;

    document.getElementById('ktThanhTien').textContent = formatMoney(thanhTien) + ' đ';
    document.getElementById('ktTroCap').textContent = formatMoney(troCap) + ' đ';
    document.getElementById('ktKhauTru').textContent = formatMoney(khauTru) + ' đ';
    document.getElementById('ktThucNhan').textContent = formatMoney(thucNhan) + ' đ';
}

document.addEventListener('DOMContentLoaded', function () {
    if (typeof attachMoneyFormatter !== 'function') return;

    attachMoneyFormatter('pl_tro_cap_display', 'pl_tro_cap');
    attachMoneyFormatter('pl_khau_tru_display', 'pl_khau_tru');

    ['pl_tro_cap_display', 'pl_khau_tru_display'].forEach(function (id) {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', ctvTinhLai);
    });
});
