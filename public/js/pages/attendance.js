function todayIso(){ const d=new Date(); return d.toISOString().slice(0,10); }

function populateAttendanceFilter(){
  document.getElementById('attBranch').innerHTML = branches.map(b=>`<option value="${b.id}">${b.ten}</option>`).join('');
}

function renderAttendance(){
  const branchId = Number(document.getElementById('attBranch').value || branches[0].id);
  const list = students.filter(s=>[s.branch1,s.branch2,s.branch3].includes(branchId));
  document.getElementById('attendanceTbody').innerHTML = list.map(s=>`
    <tr data-sid="${s.id}">
      <td>${s.code}</td>
      <td><div class="cell-user"><img src="${s.avatar}" alt=""><div class="name">${s.name}</div></div></td>
      <td><label class="check-row"><input type="radio" name="att_${s.id}" checked> Đi học</label></td>
      <td><label class="check-row"><input type="radio" name="att_${s.id}"> Vắng</label></td>
      <td><input class="note-input" type="text" placeholder="Ghi chú (nếu có)"></td>
    </tr>`).join('') || '<tr><td colspan="5" class="text-2" style="text-align:center;padding:24px;">Cơ sở này chưa có học viên</td></tr>';
}

function saveAttendance(){
  confirmAction('Lưu điểm danh','Bạn có chắc chắn muốn lưu điểm danh cho ngày đã chọn?', ()=>{
    showToast('Lưu điểm danh thành công!');
  });
}

populateAttendanceFilter();
document.getElementById('attDate').value = todayIso();
document.getElementById('attBranch').addEventListener('change', renderAttendance);
renderAttendance();