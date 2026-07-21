document.addEventListener('click', function (e) {
  const btn = e.target.closest('.edit-student-btn');
  if (!btn) return;
  try {
    const hv = JSON.parse(btn.dataset.student);
    openStudentModal(hv);
  } catch (err) {
    console.error('Không đọc được dữ liệu học viên:', err);
  }
});

function previewStudentAvatar(input){
  if (input.files && input.files[0]) {
    document.getElementById('stuFormAvatarPreview').src = URL.createObjectURL(input.files[0]);
  }
}

function locCoSoHocVien(keyword) {
  const kw = (keyword || '').trim().toLowerCase();
  document.querySelectorAll('#stu_branches .branch-chip').forEach(chip => {
    const match = chip.dataset.name.includes(kw);
    chip.style.display = match ? '' : 'none';
  });
}

function chonTatCaCoSoHocVien(checked) {
  document.querySelectorAll('#stu_branches .branch-chip').forEach(chip => {
    if (chip.style.display !== 'none') {
      const cb = chip.querySelector('.stu-branch-checkbox');
      if (cb) cb.checked = checked;
    }
  });
  capNhatSoLuongCoSoHocVien();
}

function capNhatSoLuongCoSoHocVien() {
  const badge = document.getElementById('stuBranchCount');
  if (!badge) return;
  const count = document.querySelectorAll('.stu-branch-checkbox:checked').length;
  badge.textContent = `${count} đã chọn`;
}

function openStudentModal(hv){
  const form = document.getElementById('studentForm');
  form.action = `${form.dataset.updateUrlBase}/${hv.id}`;
  document.getElementById('studentEditingId').value = hv.id;

  document.getElementById('f_code').value = hv.ma_so || '';
  document.getElementById('f_name').value = hv.ho_ten || '';
  document.getElementById('f_nickname').value = hv.nickname || '';
  document.getElementById('f_dob').value = hv.ngay_sinh ? hv.ngay_sinh.slice(0,10) : '';
  document.getElementById('f_gender').value = hv.gioi_tinh;
  document.getElementById('f_phone').value = hv.sdt || '';
  document.getElementById('f_school').value = hv.truong || '';
  document.getElementById('f_address').value = hv.dia_chi || '';
  document.getElementById('f_note').value = hv.ghi_chu || '';
  document.getElementById('f_status').value = hv.trang_thai;
  document.getElementById('stuFormAvatarPreview').src = hv.avatar_url;

  const searchInput = document.getElementById('stuBranchSearch');
  if (searchInput) searchInput.value = '';
  locCoSoHocVien('');

  document.querySelectorAll('.stu-branch-checkbox').forEach(cb => cb.checked = false);
  (hv.co_sos || []).forEach(cs => {
    const cb = document.querySelector(`.stu-branch-checkbox[value="${cs.id}"]`);
    if (cb) cb.checked = true;
  });
  capNhatSoLuongCoSoHocVien();

  openModal('studentModal');
}