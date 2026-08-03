function tinhThueTncnJs(tntt) {
    if (tntt <= 0) return 0;
    let thue;
    if (tntt <= 10000000) thue = tntt * 0.05;
    else if (tntt <= 30000000) thue = tntt * 0.10 - 500000;
    else if (tntt <= 60000000) thue = tntt * 0.20 - 3500000;
    else if (tntt <= 100000000) thue = tntt * 0.30 - 9500000;
    else thue = tntt * 0.35 - 14500000;
    return Math.round(Math.max(0, thue));
}

function layGiaTri(hiddenId) {
    const el = document.getElementById(hiddenId);
    return el ? (parseInt(el.value, 10) || 0) : 0;
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
    document.getElementById('pl_luong_co_ban').value = formatMoney(data.luong_co_ban || 0) + ' đ';
    document.getElementById('pl_ngay_cong').value =
        'Có: ' + data.so_ngay_co_luong + ' ngày — Không: ' + data.so_ngay_khong_luong + ' ngày';

    const ngayCongChuanInput = document.getElementById('pl_ngay_cong_chuan');
    if (!ngayCongChuanInput.value) {
        ngayCongChuanInput.value = window.__plNgayCongToiThieu || '';
    }

    const troCap = data.tro_cap || 0;
    document.getElementById('pl_tro_cap').value = troCap;
    document.getElementById('pl_tro_cap_display').value = formatMoney(troCap);

    document.getElementById('chuaChonHint').style.display = 'none';
    document.getElementById('formBody').style.display = '';

    capNhatGoiYTruNgay(data.so_ngay_co_luong);
    tinhLai();
}

function capNhatGoiYTruNgay(soNgayCoLuong) {
    const toiThieu = window.__plNgayCongToiThieu || 0;
    const tienTru = window.__plTienTru1Ngay || 0;
    const el = document.getElementById('plGoiYTruNgay');
    if (!el) return;

    if (soNgayCoLuong < toiThieu && tienTru > 0) {
        const soNgayThieu = toiThieu - soNgayCoLuong;
        const soTien = soNgayThieu * tienTru;
        el.textContent = 'Thiếu ' + soNgayThieu + ' ngày × ' + formatMoney(tienTru) + 'đ = ' +
            formatMoney(soTien) + 'đ (gợi ý cộng vào Tổng khấu trừ nếu cần)';
    } else {
        el.textContent = '';
    }
}

function tinhLai() {
    const luongCoBanText = document.getElementById('pl_luong_co_ban').value || '0';
    const luongCoBan = parseInt(unformatMoney(luongCoBanText), 10) || 0;

    const bhxh = Math.round(luongCoBan * 0.08);
    const bhyt = Math.round(luongCoBan * 0.015);
    const bhtn = Math.round(luongCoBan * 0.01);

    const troCap = layGiaTri('pl_tro_cap');
    const nangSuat = layGiaTri('pl_nang_suat');
    const thuongKhac = layGiaTri('pl_thuong_khac');
    const tongKhauTru = layGiaTri('pl_tong_khau_tru');
    const congTacPhi = layGiaTri('pl_cong_tac_phi');
    const tamUng = layGiaTri('pl_tam_ung');
    const giamTru = layGiaTri('pl_giam_tru');

    // Tổng thu nhập = Lương cơ bản + Trợ cấp + Năng suất + Thưởng khác (tự động, không nhập tay)
    const tongThuNhap = luongCoBan + troCap + nangSuat + thuongKhac;

    const thuNhapChiuThue = tongThuNhap - tongKhauTru;
    const tntt = Math.max(0, thuNhapChiuThue - giamTru);
    const thueTncn = tinhThueTncnJs(tntt);
    // Không cộng lại Trợ cấp ở đây — đã nằm sẵn trong Tổng thu nhập, tránh tính trùng
    const luongThucNhan = thuNhapChiuThue + congTacPhi - tamUng - thueTncn;

    document.getElementById('ktLuongCoBanRef').textContent = formatMoney(luongCoBan) + ' đ';
    document.getElementById('ktTroCap').textContent = formatMoney(troCap) + ' đ';
    document.getElementById('ktNangSuat').textContent = formatMoney(nangSuat) + ' đ';
    document.getElementById('ktThuongKhac').textContent = formatMoney(thuongKhac) + ' đ';
    document.getElementById('ktTongThuNhap').textContent = formatMoney(tongThuNhap) + ' đ';

    document.getElementById('ktBhxh').textContent = formatMoney(bhxh) + ' đ';
    document.getElementById('ktBhyt').textContent = formatMoney(bhyt) + ' đ';
    document.getElementById('ktBhtn').textContent = formatMoney(bhtn) + ' đ';

    document.getElementById('ktTongThuNhap2').textContent = formatMoney(tongThuNhap) + ' đ';
    document.getElementById('ktTongKhauTruRef').textContent = formatMoney(tongKhauTru) + ' đ';
    document.getElementById('ktTncTthue').textContent = formatMoney(thuNhapChiuThue) + ' đ';
    document.getElementById('ktCongTacPhi').textContent = formatMoney(congTacPhi) + ' đ';
    document.getElementById('ktTamUng').textContent = formatMoney(tamUng) + ' đ';
    document.getElementById('ktTntt').textContent = formatMoney(tntt) + ' đ';
    document.getElementById('ktThueTncn').textContent = formatMoney(thueTncn) + ' đ';
    document.getElementById('ktLuongThucNhan').textContent = formatMoney(luongThucNhan) + ' đ';
}

document.addEventListener('DOMContentLoaded', function () {
    if (typeof attachMoneyFormatter !== 'function') return;

    attachMoneyFormatter('pl_tro_cap_display', 'pl_tro_cap');
    attachMoneyFormatter('pl_nang_suat_display', 'pl_nang_suat');
    attachMoneyFormatter('pl_thuong_khac_display', 'pl_thuong_khac');
    attachMoneyFormatter('pl_tong_khau_tru_display', 'pl_tong_khau_tru');
    attachMoneyFormatter('pl_cong_tac_phi_display', 'pl_cong_tac_phi');
    attachMoneyFormatter('pl_tam_ung_display', 'pl_tam_ung');
    attachMoneyFormatter('pl_giam_tru_display', 'pl_giam_tru');

    // Gắn SAU attachMoneyFormatter để đảm bảo đọc đúng giá trị hidden vừa được cập nhật
    ['pl_tro_cap_display', 'pl_nang_suat_display', 'pl_thuong_khac_display', 'pl_tong_khau_tru_display',
        'pl_cong_tac_phi_display', 'pl_tam_ung_display', 'pl_giam_tru_display'].forEach(function (id) {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', tinhLai);
    });
});