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

// Giải thích ngắn gọn theo đúng bậc thuế luỹ tiến 5 bậc (Luật 109/2025/QH15, áp dụng từ 2026)
function moTaBacThueTncn(tntt) {
    if (tntt <= 0) return 'TNTT = 0đ → không phát sinh thuế.';

    let bac, thueSuat, tru;
    if (tntt <= 10000000) { bac = 1; thueSuat = 5; tru = 0; }
    else if (tntt <= 30000000) { bac = 2; thueSuat = 10; tru = 500000; }
    else if (tntt <= 60000000) { bac = 3; thueSuat = 20; tru = 3500000; }
    else if (tntt <= 100000000) { bac = 4; thueSuat = 30; tru = 9500000; }
    else { bac = 5; thueSuat = 35; tru = 14500000; }

    const thue = tinhThueTncnJs(tntt);
    const phanTru = tru > 0 ? (' − ' + formatMoney(tru) + 'đ') : '';

    return 'Gợi ý — Bậc ' + bac + ' (' + thueSuat + '%): ' + formatMoney(tntt) + 'đ × ' + thueSuat + '%' +
        phanTru + ' = ' + formatMoney(thue) + 'đ';
}

function layGiaTri(hiddenId) {
    const el = document.getElementById(hiddenId);
    return el ? (parseInt(el.value, 10) || 0) : 0;
}

// An toàn hơn document.getElementById(id).textContent = ... — không crash nếu HTML thiếu phần tử này
// (ví dụ do cache trình duyệt cũ, hoặc lệch giữa bản JS/blade khi copy)
function ganText(id, text) {
    const el = document.getElementById(id);
    if (el) el.textContent = text;
}

let daTuSuaThueTncn = false;

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

    // Thuế TNCN: nhập tay — tự điền gợi ý CHỈ KHI admin chưa từng tự gõ (không ghi đè số đã lưu/đã sửa)
    const goiYThueTncn = tinhThueTncnJs(tntt);
    if (!daTuSuaThueTncn) {
        document.getElementById('pl_thue_tncn').value = goiYThueTncn;
        // document.getElementById('pl_thue_tncn_display').value = formatMoney(goiYThueTncn);
    }
    const thueTncn = layGiaTri('pl_thue_tncn');

    const goiYEl = document.getElementById('plGoiYThueTncn');
    if (goiYEl) goiYEl.textContent = moTaBacThueTncn(tntt);

    const luongThucNhan = thuNhapChiuThue + congTacPhi - tamUng - thueTncn;

    ganText('ktLuongCoBanRef', formatMoney(luongCoBan) + ' đ');
    ganText('ktTroCap', formatMoney(troCap) + ' đ');
    ganText('ktNangSuat', formatMoney(nangSuat) + ' đ');
    ganText('ktThuongKhac', formatMoney(thuongKhac) + ' đ');
    ganText('ktTongThuNhap', formatMoney(tongThuNhap) + ' đ');

    ganText('ktBhxh', formatMoney(bhxh) + ' đ');
    ganText('ktBhyt', formatMoney(bhyt) + ' đ');
    ganText('ktBhtn', formatMoney(bhtn) + ' đ');

    ganText('ktTongThuNhap2', formatMoney(tongThuNhap) + ' đ');
    ganText('ktTongKhauTruRef', formatMoney(tongKhauTru) + ' đ');
    ganText('ktTncTthue', formatMoney(thuNhapChiuThue) + ' đ');
    ganText('ktCongTacPhi', formatMoney(congTacPhi) + ' đ');
    ganText('ktTamUng', formatMoney(tamUng) + ' đ');
    ganText('ktTntt', formatMoney(tntt) + ' đ');
    ganText('ktThueTncn', formatMoney(thueTncn) + ' đ');
    ganText('ktLuongThucNhan', formatMoney(luongThucNhan) + ' đ');
}

document.addEventListener('DOMContentLoaded', function () {
    if (typeof attachMoneyFormatter !== 'function') return;

    // Nếu ô Thuế TNCN đã có sẵn giá trị lúc trang vừa load (trang Sửa, đọc từ phiếu đã lưu)
    // thì coi như "đã tự sửa" luôn từ đầu — tuyệt đối không tự động ghi đè số đã lưu.
    const thueTncnHidden = document.getElementById('pl_thue_tncn');
    if (thueTncnHidden && parseInt(thueTncnHidden.value, 10) > 0) {
        daTuSuaThueTncn = true;
    }

    attachMoneyFormatter('pl_tro_cap_display', 'pl_tro_cap');
    attachMoneyFormatter('pl_nang_suat_display', 'pl_nang_suat');
    attachMoneyFormatter('pl_thuong_khac_display', 'pl_thuong_khac');
    attachMoneyFormatter('pl_tong_khau_tru_display', 'pl_tong_khau_tru');
    attachMoneyFormatter('pl_cong_tac_phi_display', 'pl_cong_tac_phi');
    attachMoneyFormatter('pl_tam_ung_display', 'pl_tam_ung');
    attachMoneyFormatter('pl_giam_tru_display', 'pl_giam_tru');
    attachMoneyFormatter('pl_thue_tncn_display', 'pl_thue_tncn');

    const thueTncnDisplay = document.getElementById('pl_thue_tncn_display');
    if (thueTncnDisplay) {
        thueTncnDisplay.addEventListener('input', function () {
            daTuSuaThueTncn = true;
            tinhLai();
        });
    }

    // Gắn SAU attachMoneyFormatter để đảm bảo đọc đúng giá trị hidden vừa được cập nhật
    ['pl_tro_cap_display', 'pl_nang_suat_display', 'pl_thuong_khac_display', 'pl_tong_khau_tru_display',
        'pl_cong_tac_phi_display', 'pl_tam_ung_display', 'pl_giam_tru_display'].forEach(function (id) {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', tinhLai);
    });
});