let ccTabHienTai = 'thay';
let ccNgayDangChon = null;
let ccTrangThaiThayHienTai = true;
let ccDanhSachCho = [];

function formatTien(n) {
    return (n || 0).toLocaleString('en-US') + 'đ';
}

// ===== Modal Chấm công (thêm hàng loạt) =====

function openChamCongThemModal(ngayIso, ngayHienThi) {
    ccNgayDangChon = ngayIso;
    ccDanhSachCho = [];

    document.getElementById('ccNgayHienThi').value = ngayHienThi;

    const selThay = document.getElementById('ccThayHoTen');
    selThay.innerHTML = '<option value="">-- Chọn Thầy phụ trách --</option>';
    (window.__ccThayOptions || []).forEach((gv) => {
        const opt = document.createElement('option');
        opt.value = gv.id;
        opt.textContent = gv.ho_ten;
        selThay.appendChild(opt);
    });

    const selCtv = document.getElementById('ccCtvHoTen');
    selCtv.innerHTML = '<option value="">-- Chọn Cộng tác viên --</option>';
    (window.__ccCtvOptions || []).forEach((gv) => {
        const opt = document.createElement('option');
        opt.value = gv.id;
        opt.textContent = gv.ho_ten;
        selCtv.appendChild(opt);
    });

    ccResetFormThay();
    ccResetFormCtv();
    ccChonTab('thay');
    ccRenderDanhSachCho();

    openModal('chamCongThemModal');
}

function ccChonTab(loai) {
    ccTabHienTai = loai;

    document.getElementById('ccTabThayBtn').classList.toggle('cc-tab-item--active', loai === 'thay');
    document.getElementById('ccTabCtvBtn').classList.toggle('cc-tab-item--active', loai === 'ctv');
    document.getElementById('ccPanelThay').style.display = loai === 'thay' ? '' : 'none';
    document.getElementById('ccPanelCtv').style.display = loai === 'ctv' ? '' : 'none';
}

function ccChonTrangThai(coDiLam) {
    ccTrangThaiThayHienTai = coDiLam;
    document.getElementById('ccThayCoBtn').classList.toggle('cc-trangthai-btn--active', coDiLam);
    document.getElementById('ccThayKhongBtn').classList.toggle('cc-trangthai-btn--active', !coDiLam);
}

function ccCapNhatDonGia() {
    const id = document.getElementById('ccCtvHoTen').value;
    const gv = (window.__ccCtvOptions || []).find((g) => String(g.id) === String(id));
    document.getElementById('ccCtvDonGia').value = gv && gv.don_gia_gio !== null ? formatTien(gv.don_gia_gio) : 'Chưa cấu hình';
    ccTinhThanhTien();
}

function ccTinhThanhTien() {
    const soGio = parseFloat(document.getElementById('ccCtvSoGio').value) || 0;
    const id = document.getElementById('ccCtvHoTen').value;
    const gv = (window.__ccCtvOptions || []).find((g) => String(g.id) === String(id));
    const donGia = gv && gv.don_gia_gio !== null ? gv.don_gia_gio : 0;
    document.getElementById('ccCtvThanhTien').value = formatTien(Math.round(soGio * donGia));
}

function ccResetFormThay() {
    document.getElementById('ccThayHoTen').value = '';
    document.getElementById('ccThayGhiChu').value = '';
    ccChonTrangThai(true);
}

function ccResetFormCtv() {
    document.getElementById('ccCtvHoTen').value = '';
    document.getElementById('ccCtvSoGio').value = '0';
    document.getElementById('ccCtvDonGia').value = '';
    document.getElementById('ccCtvXangXe').value = '0';
    document.getElementById('ccCtvThanhTien').value = formatTien(0);
    document.getElementById('ccCtvGhiChu').value = '';
}

function ccThemVaoDanhSach(loai) {
    if (loai === 'thay') {
        const id = document.getElementById('ccThayHoTen').value;
        if (!id) return;

        const gv = (window.__ccThayOptions || []).find((g) => String(g.id) === String(id));
        const item = {
            loai: 'thay',
            giao_vien_id: id,
            ten: gv ? gv.ho_ten : '',
            co_di_lam: ccTrangThaiThayHienTai,
            ghi_chu: document.getElementById('ccThayGhiChu').value,
        };

        ccDanhSachCho = ccDanhSachCho.filter((r) => !(r.loai === 'thay' && String(r.giao_vien_id) === String(id)));
        ccDanhSachCho.push(item);
        ccResetFormThay();
    } else {
        const id = document.getElementById('ccCtvHoTen').value;
        if (!id) return;

        const gv = (window.__ccCtvOptions || []).find((g) => String(g.id) === String(id));
        const soGio = parseFloat(document.getElementById('ccCtvSoGio').value) || 0;
        const donGia = gv && gv.don_gia_gio !== null ? gv.don_gia_gio : 0;

        const item = {
            loai: 'ctv',
            giao_vien_id: id,
            ten: gv ? gv.ho_ten : '',
            so_gio: soGio,
            don_gia_gio: donGia,
            thanh_tien: Math.round(soGio * donGia),
            ho_tro_xang_xe: parseInt(document.getElementById('ccCtvXangXe').value, 10) || 0,
            ghi_chu: document.getElementById('ccCtvGhiChu').value,
        };

        ccDanhSachCho = ccDanhSachCho.filter((r) => !(r.loai === 'ctv' && String(r.giao_vien_id) === String(id)));
        ccDanhSachCho.push(item);
        ccResetFormCtv();
    }

    ccRenderDanhSachCho();
}

function ccXoaKhoiDanhSachCho(index) {
    ccDanhSachCho.splice(index, 1);
    ccRenderDanhSachCho();
}

function ccRenderDanhSachCho() {
    const box = document.getElementById('ccDanhSachCho');
    box.innerHTML = '';

    if (ccDanhSachCho.length === 0) {
        box.innerHTML = '<div class="text-2 cc-danhsachcho-trong">Chưa có mục nào — thêm ở form phía trên.</div>';
        return;
    }

    ccDanhSachCho.forEach((item, index) => {
        const row = document.createElement('div');
        row.className = 'cc-danhsachcho-item';

        const info = document.createElement('div');
        if (item.loai === 'thay') {
            info.innerHTML = '<b>' + item.ten + '</b><div class="text-2">Thầy PT · '
                + (item.co_di_lam ? 'Có mặt' : 'Không') + '</div>';
        } else {
            info.innerHTML = '<b>' + item.ten + '</b><div class="text-2">CTV · ' + item.so_gio + ' giờ × '
                + formatTien(item.don_gia_gio) + ' = ' + formatTien(item.thanh_tien) + '</div>';
        }

        const xoaBtn = document.createElement('i');
        xoaBtn.className = 'ri-close-line cc-danhsachcho-xoa';
        xoaBtn.onclick = () => ccXoaKhoiDanhSachCho(index);

        row.appendChild(info);
        row.appendChild(xoaBtn);
        box.appendChild(row);
    });
}

function ccLuuChamCong() {
    if (ccDanhSachCho.length === 0) return;

    document.getElementById('ccLuuNgay').value = ccNgayDangChon;

    const container = document.getElementById('ccLuuRowsContainer');
    container.innerHTML = '';

    ccDanhSachCho.forEach((item, i) => {
        const fields = {
            'loai': item.loai,
            'giao_vien_id': item.giao_vien_id,
            'ghi_chu': item.ghi_chu || '',
        };

        if (item.loai === 'thay') {
            fields['co_di_lam'] = item.co_di_lam ? '1' : '0';
        } else {
            fields['so_gio'] = item.so_gio;
            fields['ho_tro_xang_xe'] = item.ho_tro_xang_xe;
        }

        Object.keys(fields).forEach((key) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `rows[${i}][${key}]`;
            input.value = fields[key];
            container.appendChild(input);
        });
    });

    document.getElementById('ccLuuForm').submit();
}

// ===== Modal Xem chi tiết =====

function openChamCongChiTietModal(ngayIso, tieuDeText) {
    document.getElementById('cctTieuDe').textContent = 'Chấm công ' + tieuDeText;

    const du_lieu = (window.__ccDuLieuThang || {})[ngayIso] || { thay: [], ctv: [] };
    const coQuyenXoa = window.__ccCoQuyenXoa;

    const boxThay = document.getElementById('cctDanhSachThay');
    boxThay.innerHTML = '';
    if (du_lieu.thay.length === 0) {
        boxThay.innerHTML = '<div class="text-2 cct-trong">Chưa có ai chấm công</div>';
    }
    du_lieu.thay.forEach((r) => {
        boxThay.appendChild(ccTaoDongChiTietThay(r, coQuyenXoa));
    });

    const boxCtv = document.getElementById('cctDanhSachCtv');
    boxCtv.innerHTML = '';
    if (du_lieu.ctv.length === 0) {
        boxCtv.innerHTML = '<div class="text-2 cct-trong">Chưa có ai chấm công</div>';
    }
    du_lieu.ctv.forEach((r) => {
        boxCtv.appendChild(ccTaoDongChiTietCtv(r, coQuyenXoa));
    });

    openModal('chamCongChiTietModal');
}

function ccTaoDongChiTietThay(r, coQuyenXoa) {
    const row = document.createElement('div');
    row.className = 'cct-item';

    const badge = r.co_di_lam
        ? '<span class="badge green">Có mặt</span>'
        : '<span class="badge red">Không</span>';

    row.innerHTML = '<div class="cct-item-head"><b>' + r.ten + '</b>' + badge
        + (coQuyenXoa ? '<i class="ri-delete-bin-line cct-item-xoa" data-id="' + r.id + '"></i>' : '') + '</div>'
        + (r.ghi_chu ? '<div class="text-2 cct-item-ghichu">' + r.ghi_chu + '</div>' : '');

    if (coQuyenXoa) {
        row.querySelector('.cct-item-xoa').onclick = () => ccXoaMuc(r.id);
    }

    return row;
}

function ccTaoDongChiTietCtv(r, coQuyenXoa) {
    const row = document.createElement('div');
    row.className = 'cct-item';

    row.innerHTML = '<div class="cct-item-head"><b>' + r.ten + '</b><span class="badge blue">' + r.so_gio + ' giờ</span>'
        + (coQuyenXoa ? '<i class="ri-delete-bin-line cct-item-xoa" data-id="' + r.id + '"></i>' : '') + '</div>'
        + '<div class="text-2 cct-item-chitiet">Đơn giá/giờ: ' + formatTien(r.don_gia_gio)
        + '&nbsp;&nbsp;Thành tiền: ' + formatTien(r.thanh_tien)
        + '&nbsp;&nbsp;Xăng xe: ' + formatTien(r.ho_tro_xang_xe) + '</div>'
        + (r.ghi_chu ? '<div class="text-2 cct-item-ghichu">' + r.ghi_chu + '</div>' : '');

    if (coQuyenXoa) {
        row.querySelector('.cct-item-xoa').onclick = () => ccXoaMuc(r.id);
    }

    return row;
}

function ccXoaMuc(id) {
    confirmAction('Xoá chấm công', 'Bạn có chắc chắn muốn xoá mục chấm công này?', () => {
        const url = window.__ccXoaUrlTemplate.replace('__ID__', id);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.style.display = 'none';

        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = window.__csrfToken || '';
        form.appendChild(token);

        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);

        document.body.appendChild(form);
        form.submit();
    });
}