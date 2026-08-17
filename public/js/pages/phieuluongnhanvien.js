function layGiaTri(hiddenId) {
    const el = document.getElementById(hiddenId);
    return el ? (parseInt(el.value, 10) || 0) : 0;
}

// Đọc trạng thái tích chọn của checkbox khấu trừ Bảo hiểm - mặc định true nếu không tìm thấy phần tử
function layTrangThaiTick(id) {
    const el = document.getElementById(id);
    return el ? el.checked : true;
}

// An toàn hơn document.getElementById(id).textContent = ... - không crash nếu HTML thiếu phần tử này
// (ví dụ do cache trình duyệt cũ, hoặc lệch giữa bản JS/blade khi copy)
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
        'Có: ' + data.so_ngay_co_luong + ' ngày - Không: ' + data.so_ngay_khong_luong + ' ngày';

    const ngayCongChuanInput = document.getElementById('pl_ngay_cong_chuan');
    if (!ngayCongChuanInput.value) {
        ngayCongChuanInput.value = window.__plNgayCongToiThieu || '';
    }

    // Trợ cấp nhập tay hoàn toàn - không lấy từ Chấm công nữa, xoá trắng khi đổi giáo viên
    document.getElementById('pl_tro_cap').value = '';
    document.getElementById('pl_tro_cap_display').value = '';

    // Lưu lại số ngày có lương thực tế của giáo viên đang chọn để tính trừ ngày công thiếu
    window.__plSoNgayCoLuongHienTai = data.so_ngay_co_luong || 0;

    window.__plTienTru1NgayHienTai = data.tien_tru_1_ngay || 0;

    document.getElementById('chuaChonHint').style.display = 'none';
    document.getElementById('formBody').style.display = '';

    tinhLai();
}

function tinhLai() {
    const luongCoBanText = document.getElementById('pl_luong_co_ban').value || '0';
    const luongCoBan = parseInt(unformatMoney(luongCoBanText), 10) || 0;
    const tienTru1Ngay = window.__plTienTru1NgayHienTai || 0;

    const bhxh = layTrangThaiTick('pl_ap_dung_bhxh') ? Math.round(luongCoBan * 0.08) : 0;
    const bhyt = layTrangThaiTick('pl_ap_dung_bhyt') ? Math.round(luongCoBan * 0.015) : 0;
    const bhtn = layTrangThaiTick('pl_ap_dung_bhtn') ? Math.round(luongCoBan * 0.01) : 0;
    const tongKhauTru = bhxh + bhyt + bhtn;

    const troCap = layGiaTri('pl_tro_cap');
    const nangSuat = layGiaTri('pl_nang_suat');
    const thuongKhac = layGiaTri('pl_thuong_khac');
    const congTacPhi = layGiaTri('pl_cong_tac_phi');
    const tamUng = layGiaTri('pl_tam_ung');
    const thueTncn = layGiaTri('pl_thue_tncn');

    const ngayCongChuanEl = document.getElementById('pl_ngay_cong_chuan');
    const ngayCongChuan = ngayCongChuanEl ? (parseInt(ngayCongChuanEl.value, 10) || 0) : 0;
    const soNgayCoLuong = window.__plSoNgayCoLuongHienTai || 0;
    const soNgayThieu = Math.max(0, ngayCongChuan - soNgayCoLuong);
    const truNgayThieu = soNgayThieu * tienTru1Ngay;

    const tongThuNhap = luongCoBan + troCap + nangSuat + thuongKhac - truNgayThieu;

    const thuNhapChiuThue = tongThuNhap - tongKhauTru + tamUng + congTacPhi;

    const luongThucNhan = thuNhapChiuThue - thueTncn;

    ganText('ktLuongCoBanRef', formatMoney(luongCoBan) + ' đ');
    ganText('ktTroCap', formatMoney(troCap) + ' đ');
    ganText('ktNangSuat', formatMoney(nangSuat) + ' đ');
    ganText('ktThuongKhac', formatMoney(thuongKhac) + ' đ');
    ganText('ktTruNgayThieu', formatMoney(truNgayThieu) + ' đ' + (soNgayThieu > 0 ? ' (' + soNgayThieu + ' ngày)' : ''));
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

    ['pl_ap_dung_bhxh', 'pl_ap_dung_bhyt', 'pl_ap_dung_bhtn'].forEach(function (id) {
        const el = document.getElementById(id);
        if (el) el.addEventListener('change', tinhLai);
    });

    const ngayCongChuanEl = document.getElementById('pl_ngay_cong_chuan');
    if (ngayCongChuanEl) ngayCongChuanEl.addEventListener('input', tinhLai);
});