function openTeacherModal(id, hoTen, maNhanVien, cccd, ngaySinh, sdt, chucDanh){
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
  document.getElementById('gv_manv').value = maNhanVien || '';
  document.getElementById('gv_cccd').value = cccd || '';
  document.getElementById('gv_dob').value = ngaySinh || '';
  document.getElementById('gv_phone').value = sdt || '';
  document.getElementById('gv_chucdanh').value = chucDanh || '1';

  openModal('teacherModal');
}

function openQuyenModal(giaoVienId, hoTen, quyenData) {
  const form = document.getElementById('quyenForm');

  document.getElementById('quyenGvName').textContent = hoTen || '';
  form.action = `${form.dataset.saveUrlBase}/${giaoVienId}/quyen`;

  form.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);

  (quyenData || []).forEach(row => {
    ['xem', 'them', 'sua', 'xoa'].forEach(hanhDong => {
      if (row[hanhDong]) {
        const cb = document.getElementById(`qgv_${row.chuc_nang_id}_${hanhDong}`);
        if (cb) cb.checked = true;
      }
    });
  });

  openModal('quyenModal');
}