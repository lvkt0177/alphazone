function openTeacherModal(id, hoTen, ngaySinh, sdt){
  const form = document.getElementById('teacherForm');
  const methodField = document.getElementById('teacherMethodField');

  document.getElementById('teacherEditingId').value = id || '';

  if (id) {
    document.getElementById('teacherModalTitle').textContent = 'Sửa Giáo viên';
    form.action = `${form.dataset.updateUrlBase}/${id}`;
    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
  } else {
    document.getElementById('teacherModalTitle').textContent = 'Tạo Giáo viên';
    form.action = form.dataset.storeUrl;
    methodField.innerHTML = '';
  }

  document.getElementById('gv_name').value = hoTen || '';
  document.getElementById('gv_dob').value = ngaySinh || '';
  document.getElementById('gv_phone').value = sdt || '';

  openModal('teacherModal');
}