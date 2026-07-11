function formatMoney(value) {
  const raw = String(value ?? '').replace(/[^\d]/g, '');
  return raw ? Number(raw).toLocaleString('en-US') : '';
}

function unformatMoney(value) {
  return String(value ?? '').replace(/[^\d]/g, '');
}

function attachMoneyFormatter(displayId, hiddenId) {
  const el = document.getElementById(displayId);
  const hidden = document.getElementById(hiddenId);
  if (!el || !hidden) return;

  el.addEventListener('input', function () {
    const cursorPos = this.selectionStart;
    const oldLength = this.value.length;

    const raw = unformatMoney(this.value);
    const formatted = formatMoney(raw);

    this.value = formatted;
    hidden.value = raw;

    const diff = formatted.length - oldLength;
    const newPos = Math.max(0, cursorPos + diff);
    this.setSelectionRange(newPos, newPos);
  });
}

function openTuitionModal(hocVienId, maSo, hoTen, thang, hocPhi, dongPhuc, ngayDong) {
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

  document.getElementById('tu_fee').value = formatMoney(hocPhi);
  document.getElementById('tu_fee_raw').value = hocPhi ?? '';

  document.getElementById('tu_uniform').value = formatMoney(dongPhuc);
  document.getElementById('tu_uniform_raw').value = dongPhuc ?? '';

  document.getElementById('tu_date').value = ngayDong ?? new Date().toISOString().slice(0, 10);

  const isEditing = hocPhi !== null;
  document.getElementById('tu_delete_wrap').style.display = isEditing ? 'block' : 'none';
  document.getElementById('td_hoc_vien_id').value = hocVienId;
  document.getElementById('td_thang').value = thang;

  openModal('tuitionModal');
}

document.addEventListener('DOMContentLoaded', function () {
  attachMoneyFormatter('tu_fee', 'tu_fee_raw');
  attachMoneyFormatter('tu_uniform', 'tu_uniform_raw');

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
    btn.dataset.ngayDong || null
  );
});