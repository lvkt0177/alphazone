function populateBranchTeacherSelect(){
  document.getElementById('br_teacher').innerHTML = fakeTeachers.map(t=>`<option value="${t.id}">${t.hoTen}</option>`).join('');
}

function renderBranches(){
  document.getElementById('branchesTbody').innerHTML = branches.map((b,i)=>{
    const cnt = students.filter(s=>s.branch1===b.id||s.branch2===b.id||s.branch3===b.id).length;
    return `<tr>
      <td>${i+1}</td>
      <td style="font-weight:700;">${b.ten}</td>
      <td>${fakeTeachers.find(t=>t.id===b.giaoVienId).hoTen}</td>
      <td><span class="badge purple">${cnt} học viên</span></td>
      <td><div class="actions-cell"><i class="ri-edit-line" onclick="openBranchModal(${b.id})"></i><i class="ri-delete-bin-line del" onclick="confirmAction('Xoá cơ sở','Bạn có chắc muốn xoá cơ sở ${b.ten}?',()=>showToast('Đã xoá cơ sở'))"></i></div></td>
    </tr>`;
  }).join('');
}
function openBranchModal(id){
  if(id){
    const b = branches.find(x=>x.id===id);
    document.getElementById('br_name').value=b.ten;
    document.getElementById('br_teacher').value=b.giaoVienId;
  } else {
    document.getElementById('br_name').value='';
    document.getElementById('br_teacher').value=fakeTeachers[0].id;
  }
  openModal('branchModal');
}
function saveBranch(){
  if(!document.getElementById('br_name').value.trim()){ showToast('Vui lòng nhập Tên cơ sở'); return; }
  closeModal('branchModal');
  showToast('Lưu cơ sở thành công!');
  renderBranches();
}

populateBranchTeacherSelect();
renderBranches();