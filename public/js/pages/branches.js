function toggleDiaDiemMoi(value) {
  const wrap = document.getElementById('br_diadiem_moi_wrap');
  wrap.style.display = value === 'new' ? 'block' : 'none';
  if (value !== 'new') document.getElementById('br_diadiem_moi').value = '';
}

function openBranchModal(id, ten, giaoVienId, diaDiemId) {
  const form = document.getElementById('branchForm');
  const methodField = document.getElementById('branchMethodField');

  document.getElementById('branchEditingId').value = id || '';

  if (id) {
    document.getElementById('branchModalTitle').textContent = 'Sửa Cơ sở';
    form.action = `${form.dataset.updateUrlBase}/${id}`;
    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
  } else {
    document.getElementById('branchModalTitle').textContent = 'Tạo Cơ sở';
    form.action = form.dataset.storeUrl;
    methodField.innerHTML = '';
  }

  document.getElementById('br_name').value = ten || '';
  document.getElementById('br_teacher').value = giaoVienId || '';

  document.getElementById('br_diadiem').value = diaDiemId ?? '';
  toggleDiaDiemMoi(document.getElementById('br_diadiem').value);

  openModal('branchModal');
}