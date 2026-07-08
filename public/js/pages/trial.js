function populateTrialFilters(){
  fillSelect(document.getElementById('tr_branch1'), branches, false, branchLabel);
  fillSelect(document.getElementById('tr_branch2'), branches, true, branchLabel);
}

function renderTrial(){
  document.getElementById('trialTbody').innerHTML = trialStudents.map(t=>`
    <tr>
      <td><div class="cell-user"><img src="https://ui-avatars.com/api/?name=${encodeURIComponent(t.name)}&background=FFA45C&color=fff&bold=true" alt=""><div class="name">${t.name}</div></div></td>
      <td>${t.year}</td>
      <td>${branches.find(b=>b.id===t.branch1).ten}</td>
      <td>${t.branch2? branches.find(b=>b.id===t.branch2).ten : '—'}</td>
      <td>—</td>
      <td>${trialBadge(t.status)}</td>
      <td class="text-2">${t.note||'—'}</td>
      <td><div class="actions-cell"><i class="ri-edit-line" onclick="openTrialModal(${t.id})"></i></div></td>
    </tr>`).join('');
}
function openTrialModal(id){
  if(id){
    const t = trialStudents.find(x=>x.id===id);
    document.getElementById('tr_name').value=t.name;
    document.getElementById('tr_year').value=t.year;
    document.getElementById('tr_status').value=t.status;
    document.getElementById('tr_branch1').value=t.branch1;
    document.getElementById('tr_branch2').value=t.branch2||'';
    document.getElementById('tr_note').value=t.note||'';
  } else {
    document.getElementById('tr_name').value='';
    document.getElementById('tr_year').value='';
    document.getElementById('tr_status').value='Chưa trải nghiệm';
    document.getElementById('tr_branch1').value=branches[0].id;
    document.getElementById('tr_branch2').value='';
    document.getElementById('tr_note').value='';
  }
  openModal('trialModal');
}
function saveTrial(){
  if(!document.getElementById('tr_name').value.trim()){ showToast('Vui lòng nhập Họ tên'); return; }
  closeModal('trialModal');
  showToast('Lưu học viên trải nghiệm thành công!');
}

populateTrialFilters();
renderTrial();