function openTrialModal(id, hoTen, namSinh, trangThai, ghiChu, coSoIds) {
  const form = document.getElementById('trialForm');
  const methodField = document.getElementById('trialMethodField');

  document.getElementById('trialEditingId').value = id || '';
  document.querySelectorAll('.tr-branch-checkbox').forEach(cb => cb.checked = false);

  if (id) {
    document.getElementById('trialModalTitle').textContent = 'Sửa Học viên Trải nghiệm';
    form.action = `${form.dataset.updateUrlBase}/${id}`;
    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
  } else {
    document.getElementById('trialModalTitle').textContent = 'Tạo Học viên Trải nghiệm';
    form.action = form.dataset.storeUrl;
    methodField.innerHTML = '';
  }

  document.getElementById('tr_name').value = hoTen || '';
  document.getElementById('tr_year').value = namSinh || '';
  document.getElementById('tr_status').value = trangThai || 3; // mặc định Chưa trải nghiệm
  document.getElementById('tr_note').value = ghiChu || '';
  (coSoIds || []).forEach(csId => {
    const cb = document.querySelector(`.tr-branch-checkbox[value="${csId}"]`);
    if (cb) cb.checked = true;
  });

  openModal('trialModal');
}