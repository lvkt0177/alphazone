let tuFeeBeforeToggle = '';

function capNhatTrangThaiHocPhi(isOn) {
  const feeInput = document.getElementById('tu_fee');
  const feeRaw = document.getElementById('tu_fee_raw');
  const referrerWrap = document.getElementById('tu_referrer_wrap');

  if (isOn) {
    tuFeeBeforeToggle = feeRaw.value;
    feeInput.value = formatMoney(0);
    feeRaw.value = '0';
    feeInput.readOnly = true;
    referrerWrap.style.display = 'block';
  } else {
    feeInput.readOnly = false;
    feeInput.value = formatMoney(tuFeeBeforeToggle);
    feeRaw.value = tuFeeBeforeToggle;
    feeInput.focus();
    referrerWrap.style.display = 'none';
    clearReferrerSelection();
  }
}

function clearReferrerSelection() {
  document.getElementById('tu_referrer_id').value = '';
  document.getElementById('tu_referrer_search').value = '';
  document.getElementById('tu_referrer_list').style.display = 'none';
}

function setReferrer(id, maSo, hoTen) {
  document.getElementById('tu_referrer_id').value = id;
  document.getElementById('tu_referrer_search').value = `${maSo} - ${hoTen}`;
  document.getElementById('tu_referrer_list').style.display = 'none';
}

function renderReferrerList(query) {
  const list = document.getElementById('tu_referrer_list');
  const options = window.__hocVienOptions || [];
  const q = query.trim().toLowerCase();
  const currentId = Number(document.getElementById('tu_hoc_vien_id').value);

  const filtered = options
    .filter(o => o.id !== currentId)
    .filter(o => !q || o.ma_so.toLowerCase().includes(q) || o.ho_ten.toLowerCase().includes(q))
    .slice(0, 20);

  list.innerHTML = filtered.length
    ? filtered.map(o => `
        <div class="referrer-option tuition-referrer-option" data-id="${o.id}" data-ma-so="${o.ma_so}" data-ho-ten="${o.ho_ten}">
          <b>${o.ma_so}</b> - ${o.ho_ten}
        </div>`).join('')
    : `<div class="text-2 tuition-referrer-empty">Không tìm thấy học viên phù hợp</div>`;

  list.style.display = 'block';
}

function openTuitionModal(hocVienId, maSo, hoTen, thang, hocPhi, dongPhuc, ngayDong, gioiThieuBan, nguoiGioiThieuId) {
  let formattedThang = thang;
  if (thang && thang.includes('-')) {
    const parts = thang.split('-');
    if (parts.length >= 2) {
      formattedThang = `Tháng ${parts[1]}/${parts[0]}`;
    }
  }

  document.getElementById('tuitionModalTitle').textContent = (hocPhi !== null) ? 'Sửa Học phí - ' + formattedThang : 'Tạo Học phí - ' + formattedThang;
  document.getElementById('tu_hoc_vien_id').value = hocVienId;
  document.getElementById('tu_thang').value = thang;
  document.getElementById('tu_code').value = maSo;
  document.getElementById('tu_name').value = hoTen;

  tuFeeBeforeToggle = hocPhi ?? '';
  document.getElementById('tu_fee').value = formatMoney(hocPhi);
  document.getElementById('tu_fee_raw').value = hocPhi ?? '';
  document.getElementById('tu_fee').readOnly = false;

  document.getElementById('tu_uniform').value = formatMoney(dongPhuc);
  document.getElementById('tu_uniform_raw').value = dongPhuc ?? '';

  document.getElementById('tu_date').value = ngayDong ?? new Date().toISOString().slice(0, 10);

  clearReferrerSelection();
  if (nguoiGioiThieuId) {
    const found = (window.__hocVienOptions || []).find(o => o.id === Number(nguoiGioiThieuId));
    if (found) setReferrer(found.id, found.ma_so, found.ho_ten);
  }

  const toggle = document.getElementById('tu_gioi_thieu_ban');
  toggle.checked = !!Number(gioiThieuBan);
  capNhatTrangThaiHocPhi(toggle.checked);

  const isEditing = hocPhi !== null;
  document.getElementById('tu_delete_wrap').style.display = isEditing ? 'block' : 'none';
  document.getElementById('td_hoc_vien_id').value = hocVienId;
  document.getElementById('td_thang').value = thang;

  openModal('tuitionModal');
}

document.addEventListener('DOMContentLoaded', function () {
  attachMoneyFormatter('tu_fee', 'tu_fee_raw');
  attachMoneyFormatter('tu_uniform', 'tu_uniform_raw');

  const gioiThieuBanToggle = document.getElementById('tu_gioi_thieu_ban');
  if (gioiThieuBanToggle) {
    gioiThieuBanToggle.addEventListener('change', function () {
      capNhatTrangThaiHocPhi(this.checked);
    });
  }

  const referrerSearch = document.getElementById('tu_referrer_search');
  if (referrerSearch) {
    referrerSearch.addEventListener('input', function () {
      document.getElementById('tu_referrer_id').value = '';
      renderReferrerList(this.value);
    });
    referrerSearch.addEventListener('focus', function () {
      renderReferrerList(this.value);
    });
  }

  document.addEventListener('click', function (e) {
    const option = e.target.closest('.referrer-option');
    if (option) {
      setReferrer(Number(option.dataset.id), option.dataset.maSo, option.dataset.hoTen);
      return;
    }
    if (!e.target.closest('#tu_referrer_wrap')) {
      const list = document.getElementById('tu_referrer_list');
      if (list) list.style.display = 'none';
    }
  });

  const deleteBtn = document.getElementById('tu_delete_btn');
  if (deleteBtn) {
    deleteBtn.addEventListener('click', function () {
      const hoTen = document.getElementById('tu_name').value;
      confirmAction(
        'Xoá bản ghi học phí',
        `Xoá bản ghi học phí của "${hoTen}"? Học viên sẽ trở về trạng thái Chưa đóng cho tháng này.`,
        () => document.getElementById('tuitionDeleteForm').submit()
      );
    });
  }
});

document.addEventListener('click', function (e) {
  const btn = e.target.closest('.open-tuition-btn');
  if (!btn) return;

  openTuitionModal(
    Number(btn.dataset.hocVienId),
    btn.dataset.maSo,
    btn.dataset.hoTen,
    btn.dataset.thang,
    btn.dataset.hocPhi ? Number(btn.dataset.hocPhi) : null,
    btn.dataset.dongPhuc ? Number(btn.dataset.dongPhuc) : null,
    btn.dataset.ngayDong || null,
    btn.dataset.gioiThieuBan,
    btn.dataset.nguoiGioiThieuId || null
  );
});