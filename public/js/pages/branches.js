/* Module Cơ sở đã lên thật — KHÔNG cần fake-data.js nữa */
function openBranchModal(id, ten, giaoVienId){
  const form = document.getElementById('branchForm');
  const methodField = document.getElementById('branchMethodField');

  if(id){
    document.getElementById('branchModalTitle').textContent = 'Sửa Cơ sở';
    form.action = `${form.dataset.updateUrlBase}/${id}`;
    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('br_name').value = ten || '';
    document.getElementById('br_teacher').value = giaoVienId || '';
  } else {
    document.getElementById('branchModalTitle').textContent = 'Tạo Cơ sở';
    form.action = form.dataset.storeUrl;
    methodField.innerHTML = '';
    document.getElementById('br_name').value = '';
    document.getElementById('br_teacher').selectedIndex = 0;
  }
  openModal('branchModal');
}