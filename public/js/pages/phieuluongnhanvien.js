function layGiaTri(hiddenId) {
    const el = document.getElementById(hiddenId);
    return el ? (parseInt(el.value, 10) || 0) : 0;
}

function ganText(id, text) {
    const el = document.getElementById(id);
    if (el) el.textContent = text;
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
            formatMoney(soTien) + 'đ';
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
    const tongKhauTru = bhxh + bhyt + bhtn;

    const troCap = layGiaTri('pl_tro_cap');
    const nangSuat = layGiaTri('pl_nang_suat');
    const thuongKhac = layGiaTri('pl_thuong_khac');
    const congTacPhi = layGiaTri('pl_cong_tac_phi');
    const tamUng = layGiaTri('pl_tam_ung');
    const thueTncn = layGiaTri('pl_thue_tncn');

    const tongThuNhap = luongCoBan + troCap + nangSuat + thuongKhac;

    const thuNhapChiuThue = tongThuNhap - tongKhauTru - tamUng + congTacPhi;

    const luongThucNhan = thuNhapChiuThue - thueTncn;

    ganText('ktLuongCoBanRef', formatMoney(luongCoBan) + ' đ');
    ganText('ktTroCap', formatMoney(troCap) + ' đ');
    ganText('ktNangSuat', formatMoney(nangSuat) + ' đ');
    ganText('ktThuongKhac', formatMoney(thuongKhac) + ' đ');
    ganText('ktTongThuNhap', formatMoney(tongThuNhap) + ' đ');

    ganText('ktBhxh', formatMoney(bhxh) + ' đ');
    ganText('ktBhyt', formatMoney(bhyt) + ' đ');
    ganText('ktBhtn', formatMoney(bhtn) + ' đ');
    ganText('ktTongKhauTru', formatMoney(tongKhauTru) + ' đ');

    ganText('ktTongThuNhap2', formatMoney(tongThuNhap) + ' đ');
    ganText('ktTongKhauTruRef', formatMoney(tongKhauTru) + ' đ');
    ganText('ktTamUngRef', formatMoney(tamUng) + ' đ');
    ganText('ktCongTacPhiRef', formatMoney(congTacPhi) + ' đ');
    ganText('ktTncTthue', formatMoney(thuNhapChiuThue) + ' đ');

    ganText('ktTncTthue2', formatMoney(thuNhapChiuThue) + ' đ');
    ganText('ktThueTncn', formatMoney(thueTncn) + ' đ');
    ganText('ktLuongThucNhan', formatMoney(luongThucNhan) + ' đ');
}

document.addEventListener('DOMContentLoaded', function () {
    if (typeof attachMoneyFormatter !== 'function') return;

    attachMoneyFormatter('pl_tro_cap_display', 'pl_tro_cap');
    attachMoneyFormatter('pl_nang_suat_display', 'pl_nang_suat');
    attachMoneyFormatter('pl_thuong_khac_display', 'pl_thuong_khac');
    attachMoneyFormatter('pl_cong_tac_phi_display', 'pl_cong_tac_phi');
    attachMoneyFormatter('pl_tam_ung_display', 'pl_tam_ung');
    attachMoneyFormatter('pl_giam_tru_display', 'pl_giam_tru');
    attachMoneyFormatter('pl_thue_tncn_display', 'pl_thue_tncn');

    ['pl_tro_cap_display', 'pl_nang_suat_display', 'pl_thuong_khac_display',
        'pl_cong_tac_phi_display', 'pl_tam_ung_display', 'pl_giam_tru_display', 'pl_thue_tncn_display'].forEach(function (id) {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', tinhLai);
    });
});