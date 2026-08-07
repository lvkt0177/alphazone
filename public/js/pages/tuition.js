let tuDotCounter = 1; // Box "Đợt 1" (index 0) đã có sẵn trong HTML; box mới thêm bắt đầu từ index 1

function capNhatTrangThaiHocPhi(isOn) {
  const referrerWrap = document.getElementById('tu_referrer_wrap');

  document.querySelectorAll('.dot-fee-input').forEach(inp => {
    const hidden = document.getElementById(inp.dataset.hiddenId);
    if (!hidden) return;

    if (isOn) {
      inp.dataset.beforeToggle = hidden.value ?? '';
      inp.value = formatMoney(0);
      hidden.value = '0';
      inp.readOnly = true;
    } else {
      inp.readOnly = false;
      const prev = inp.dataset.beforeToggle ?? '';
      inp.value = formatMoney(prev);
      hidden.value = prev;
    }
  });

  if (isOn) {
    referrerWrap.style.display = 'block';
  } else {
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

// ============================================================
// Nhiều đợt thanh toán trong 1 tháng
// ============================================================

function escapeHtmlTu(str) {
  const div = document.createElement('div');
  div.textContent = str ?? '';
  return div.innerHTML;
}

function taoDotBoxElement(idx, data, isSaved) {
  const div = document.createElement('div');
  div.className = 'tuition-dot-box';
  div.dataset.dotIndex = idx;

  const hocPhi = data?.hoc_phi ?? '';
  const dongPhuc = data?.dong_phuc ?? '';
  const dongPhucSize = data?.dong_phuc_size ?? '';
  const ngayDong = data?.ngay_dong ?? '';
  const dotId = data?.id ?? '';

  const mucOptions = (window.__mucDongPhucOptions || [])
    .map(o => `<option value="${o.value}" ${String(o.value) === String(dongPhuc) ? 'selected' : ''}>${escapeHtmlTu(o.label)}</option>`)
    .join('');
  const sizeOptions = (window.__sizeDongPhucOptions || [])
    .map(o => `<option value="${o.value}" ${String(o.value) === String(dongPhucSize) ? 'selected' : ''}>${escapeHtmlTu(o.label)}</option>`)
    .join('');

  const coTheXoa = !!window.__coQuyenXoaHocPhi;
  const delIcon = coTheXoa
    ? `<i class="ri-close-circle-line del tuition-dot-del" data-dot-index="${idx}" data-saved="${isSaved ? '1' : '0'}"></i>`
    : '';

  div.innerHTML = `
    <div class="tuition-dot-head">
      <span class="tuition-dot-title">Đợt ${idx + 1}</span>
      ${delIcon}
    </div>
    <div class="form-grid">
      <div class="field">
        <label>Học phí (đ)</label>
        <input id="tu_dot_fee_${idx}" type="text" inputmode="numeric" autocomplete="off"
          class="dot-fee-input" data-hidden-id="tu_dot_fee_raw_${idx}" placeholder="VD: 500,000" value="${formatMoney(hocPhi)}">
        <input type="hidden" name="dot[${idx}][hoc_phi]" id="tu_dot_fee_raw_${idx}" value="${hocPhi}">
      </div>
      <div class="field">
        <div class="tuition-uniform-row">
          <div class="tuition-uniform-col tuition-uniform-col--muc">
            <label>Đồng phục</label>
            <select id="tu_dot_dongphuc_${idx}" name="dot[${idx}][dong_phuc]">
              <option value="">— Không chọn —</option>
              ${mucOptions}
            </select>
          </div>
          <div class="tuition-uniform-col tuition-uniform-col--size">
            <label>Size quần áo</label>
            <select id="tu_dot_dongphucsize_${idx}" name="dot[${idx}][dong_phuc_size]">
              <option value="">N/A</option>
              ${sizeOptions}
            </select>
          </div>
        </div>
      </div>
      <div class="field span-2">
        <label>Ngày đóng</label>
        <input id="tu_dot_ngaydong_${idx}" name="dot[${idx}][ngay_dong]" type="date" value="${ngayDong}">
      </div>
      <input type="hidden" name="dot[${idx}][id]" id="tu_dot_id_${idx}" value="${dotId}">
    </div>
  `;

  return div;
}

function themDotThanhToan() {
  const idx = tuDotCounter++;
  const box = taoDotBoxElement(idx, null, false);
  document.getElementById('tu_dot_list').appendChild(box);
  attachMoneyFormatter(`tu_dot_fee_${idx}`, `tu_dot_fee_raw_${idx}`);

  if (typeof window.dpRescan === 'function') window.dpRescan();

  if (document.getElementById('tu_gioi_thieu_ban').checked) {
    const feeInput = document.getElementById(`tu_dot_fee_${idx}`);
    const feeHidden = document.getElementById(`tu_dot_fee_raw_${idx}`);
    feeInput.value = formatMoney(0);
    feeHidden.value = '0';
    feeInput.readOnly = true;
  }
}

document.addEventListener('click', function (e) {
  const del = e.target.closest('.tuition-dot-del');
  if (!del) return;

  const idx = del.dataset.dotIndex;
  const box = del.closest('.tuition-dot-box');
  const isSaved = del.dataset.saved === '1';
  const dotIdInput = document.getElementById(`tu_dot_id_${idx}`);
  const dotId = dotIdInput ? dotIdInput.value : '';

  if (isSaved && dotId) {
    const hoTen = document.getElementById('tu_name').value;
    confirmAction(
      'Xoá đợt thanh toán',
      `Bạn có chắc muốn xoá đợt thanh toán này của "${hoTen}"? Hành động này không thể hoàn tác.`,
      () => {
        const form = document.getElementById('tuitionDeleteDotForm');
        form.action = `${window.__hocPhiDestroyDotUrlBase}/${dotId}`;
        form.submit();
      }
    );
  } else {
    box.remove();
  }
});

function openTuitionModal(hocVienId, maSo, hoTen, thang, dotList, gioiThieuBan, nguoiGioiThieuId, duKienSoTien, duKienSoBuoi, duKienTongBuoi) {
  let formattedThang = thang;
  if (thang && thang.includes('-')) {
    const parts = thang.split('-');
    if (parts.length >= 2) {
      formattedThang = `Tháng ${parts[1]}/${parts[0]}`;
    }
  }

  const dangSua = Array.isArray(dotList) && dotList.length > 0;

  document.getElementById('tuitionModalTitle').textContent = (dangSua ? 'Sửa Học phí - ' : 'Tạo Học phí - ') + formattedThang;
  document.getElementById('tu_hoc_vien_id').value = hocVienId;
  document.getElementById('tu_thang').value = thang;
  document.getElementById('tu_code').value = maSo;
  document.getElementById('tu_name').value = hoTen;

  document.querySelectorAll('#tu_dot_list .tuition-dot-box').forEach(el => {
    if (el.dataset.dotIndex !== '0') el.remove();
  });
  tuDotCounter = 1;

  const box0 = dangSua ? (dotList[0] || {}) : {};
  document.getElementById('tu_dot_id_0').value = box0.id ?? '';
  document.getElementById('tu_fee').value = formatMoney(box0.hoc_phi ?? '');
  document.getElementById('tu_fee_raw').value = box0.hoc_phi ?? '';
  document.getElementById('tu_fee').readOnly = false;
  document.getElementById('tu_uniform').value = box0.dong_phuc ?? '';
  document.getElementById('tu_uniform_size').value = box0.dong_phuc_size ?? '';
  document.getElementById('tu_date').value = box0.ngay_dong ?? new Date().toISOString().slice(0, 10);

  const hint = document.getElementById('tu_du_kien_hint');
  if (duKienSoTien !== null && duKienSoTien !== undefined) {
    hint.textContent = `Học phí dự kiến: ${formatMoney(duKienSoTien)} đ (${duKienSoBuoi}/${duKienTongBuoi} buổi)`;
  } else {
    hint.textContent = '';
  }

  if (dangSua && dotList.length > 1) {
    for (let i = 1; i < dotList.length; i++) {
      const box = taoDotBoxElement(i, dotList[i], true);
      document.getElementById('tu_dot_list').appendChild(box);
      attachMoneyFormatter(`tu_dot_fee_${i}`, `tu_dot_fee_raw_${i}`);
      tuDotCounter = i + 1;
    }
    if (typeof window.dpRescan === 'function')
      window.dpRescan();
  }

  clearReferrerSelection();
  if (nguoiGioiThieuId) {
    const found = (window.__hocVienOptions || []).find(o => o.id === Number(nguoiGioiThieuId));
    if (found) setReferrer(found.id, found.ma_so, found.ho_ten);
  }

  const toggle = document.getElementById('tu_gioi_thieu_ban');
  toggle.checked = !!Number(gioiThieuBan);
  capNhatTrangThaiHocPhi(toggle.checked);

  document.getElementById('tu_delete_wrap').style.display = dangSua ? 'block' : 'none';
  document.getElementById('td_hoc_vien_id').value = hocVienId;
  document.getElementById('td_thang').value = thang;

  openModal('tuitionModal');
}

document.addEventListener('DOMContentLoaded', function () {
  attachMoneyFormatter('tu_fee', 'tu_fee_raw');

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
        'Xoá tất cả đợt học phí',
        `Xoá TOÀN BỘ các đợt thanh toán học phí của "${hoTen}" trong tháng này? Học viên sẽ trở về trạng thái Chưa đóng.`,
        () => document.getElementById('tuitionDeleteForm').submit()
      );
    });
  }
});

document.addEventListener('click', function (e) {
  const btn = e.target.closest('.open-tuition-btn');
  if (!btn) return;

  let dotList = [];
  try {
    dotList = JSON.parse(btn.dataset.dotList || '[]');
  } catch (err) {
    dotList = [];
  }

  openTuitionModal(
    Number(btn.dataset.hocVienId),
    btn.dataset.maSo,
    btn.dataset.hoTen,
    btn.dataset.thang,
    dotList,
    btn.dataset.gioiThieuBan,
    btn.dataset.nguoiGioiThieuId || null,
    btn.dataset.duKienSoTien !== '' ? Number(btn.dataset.duKienSoTien) : null,
    btn.dataset.duKienSoBuoi !== '' ? Number(btn.dataset.duKienSoBuoi) : null,
    btn.dataset.duKienTongBuoi !== '' ? Number(btn.dataset.duKienTongBuoi) : null
  );
});