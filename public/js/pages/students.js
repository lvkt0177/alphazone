/* Cần load: common.js, fake-data.js, rồi tới file này (dùng cho cả trang danh sách + chi tiết) */
let stuPage = 1; const STU_PAGE_SIZE = 8;

function populateStudentFilters(){
  const branchFilter = document.getElementById('stuBranchFilter');
  if(branchFilter) branchFilter.innerHTML += branches.map(b=>`<option value="${b.id}">${b.ten}</option>`).join('');
  const f1 = document.getElementById('f_branch1');
  if(f1){
    fillSelect(f1, branches, false, branchLabel);
    fillSelect(document.getElementById('f_branch2'), branches, true, branchLabel);
    fillSelect(document.getElementById('f_branch3'), branches, true, branchLabel);
  }
}

function renderStudents(page){
  if(page) stuPage=page;
  const q = document.getElementById('stuSearch').value.trim().toLowerCase();
  const branchF = document.getElementById('stuBranchFilter').value;
  const statusF = document.getElementById('stuStatusFilter').value;
  let list = students.filter(s=>{
    const matchQ = !q || s.code.toLowerCase().includes(q) || s.name.toLowerCase().includes(q);
    const matchB = !branchF || [s.branch1,s.branch2,s.branch3].includes(Number(branchF));
    const matchS = !statusF || s.status===statusF;
    return matchQ && matchB && matchS;
  });
  document.getElementById('stuCount').textContent = `${list.length} học viên`;
  const totalPages = Math.max(1, Math.ceil(list.length/STU_PAGE_SIZE));
  if(stuPage>totalPages) stuPage=totalPages;
  const pageList = list.slice((stuPage-1)*STU_PAGE_SIZE, stuPage*STU_PAGE_SIZE);

  document.getElementById('studentsTbody').innerHTML = pageList.map(s=>`
    <tr>
      <td><span class="code-link" onclick="openStudentDetail(${s.id})">${s.code}</span></td>
      <td><div class="cell-user"><img src="${s.avatar}" alt=""><div><div class="name">${s.name}</div><div class="sub">${s.nickname}</div></div></div></td>
      <td>${s.phone}</td>
      <td>${branches.find(b=>b.id===s.branch1)?.ten||'—'}</td>
      <td>${s.branch2? branches.find(b=>b.id===s.branch2).ten : '—'}</td>
      <td>${s.branch3? branches.find(b=>b.id===s.branch3).ten : '—'}</td>
      <td>${statusBadge(s.status)}</td>
      <td><div class="actions-cell">
        <i class="ri-eye-line" onclick="openStudentDetail(${s.id})"></i>
        <i class="ri-edit-line" onclick="openStudentModal(${s.id})"></i>
        <i class="ri-delete-bin-line del" onclick="confirmAction('Xoá học viên','Bạn có chắc muốn xoá học viên ${s.name}?',()=>showToast('Đã xoá học viên'))"></i>
      </div></td>
    </tr>`).join('') || '<tr><td colspan="8" class="text-2" style="text-align:center;padding:30px;">Không tìm thấy học viên phù hợp</td></tr>';

  let pager = '';
  pager += `<button ${stuPage===1?'disabled':''} onclick="renderStudents(${stuPage-1})">Trước</button>`;
  for(let i=1;i<=totalPages;i++) pager += `<button class="${i===stuPage?'active':''}" onclick="renderStudents(${i})">${i}</button>`;
  pager += `<button ${stuPage===totalPages?'disabled':''} onclick="renderStudents(${stuPage+1})">Sau</button>`;
  document.getElementById('studentsPager').innerHTML = pager;
}

// ⚠️ Ghi chú: showView() bên dưới chỉ là giải pháp tạm — vì module Học viên
// chưa build thật, trang chi tiết còn dùng cách "ẩn/hiện section". Khi tới
// lượt làm Học viên (bước sau), sẽ sửa lại thành điều hướng route thật.
function showView(name){
  const el = document.getElementById('view-'+name);
  if(el) el.classList.add('active');
}

let currentStudentId=null;
function openStudentDetail(id){
  currentStudentId=id;
  const s = students.find(x=>x.id===id);
  document.getElementById('dtAvatar').src = s.avatar;
  document.getElementById('dtName').textContent = `${s.name} (${s.nickname})`;
  document.getElementById('dtCode').textContent = `Mã số: ${s.code}`;
  document.getElementById('dtStatusBadge').innerHTML = statusBadge(s.status);
  document.getElementById('dtDob').textContent = s.dob;
  document.getElementById('dtGender').textContent = s.gender;
  document.getElementById('dtPhone').textContent = s.phone;
  document.getElementById('dtSchool').textContent = s.school;
  document.getElementById('dtAddress').textContent = s.address;
  document.getElementById('dtBranch1').textContent = branchNameById(s.branch1);
  document.getElementById('dtBranch2').textContent = s.branch2? branchNameById(s.branch2):'—';
  document.getElementById('dtBranch3').textContent = s.branch3? branchNameById(s.branch3):'—';

  document.getElementById('dtAttendanceTbody').innerHTML = attendanceHistory(id).map(a=>`
    <tr><td>${a.date}</td><td>${a.status==='Đi học'?'<span class="badge green">Đi học</span>':'<span class="badge red">Vắng</span>'}</td><td>${a.note||'—'}</td><td>${a.place}</td></tr>
  `).join('');
  document.getElementById('dtTuitionTbody').innerHTML = tuitionHistory(id).map(t=>`
    <tr><td>${t.month}</td><td>${money(t.fee)}</td><td>${t.uniform?money(t.uniform):'—'}</td><td>${t.date}</td></tr>
  `).join('');

  document.getElementById('editStudentBtn').onclick = ()=>openStudentModal(id);
  showView('studentDetail');
}

document.querySelectorAll('.tab-btn').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    const parent = btn.parentElement.parentElement;
    parent.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
    parent.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(btn.dataset.tab).classList.add('active');
  });
});

function openStudentModal(id){
  document.getElementById('fromTrialSelect').innerHTML = '<option value="">— Chọn học viên trải nghiệm —</option>' + trialStudents.map(t=>`<option value="${t.id}">${t.name}</option>`).join('');
  if(id){
    const s = students.find(x=>x.id===id);
    document.getElementById('studentModalTitle').textContent='Sửa Học viên';
    document.getElementById('f_code').value=s.code;
    document.getElementById('f_name').value=`${s.name} (${s.nickname})`;
    document.getElementById('f_dob').value=s.dobIso;
    document.getElementById('f_phone').value=s.phone;
    document.getElementById('f_gender').value=s.gender;
    document.getElementById('f_school').value=s.school;
    document.getElementById('f_address').value=s.address;
    document.getElementById('f_branch1').value=s.branch1;
    document.getElementById('f_branch2').value=s.branch2||'';
    document.getElementById('f_branch3').value=s.branch3||'';
    document.getElementById('f_status').value=s.status;
    document.getElementById('stuFormAvatar').src=s.avatar;
  } else {
    document.getElementById('studentModalTitle').textContent='Thêm Học viên';
    ['f_code','f_name','f_phone','f_school','f_address'].forEach(id=>document.getElementById(id).value='');
    document.getElementById('f_dob').value='';
    document.getElementById('f_code').value = 'HV'+String(students.length+1).padStart(3,'0');
    document.getElementById('f_gender').value='Nam';
    document.getElementById('f_branch1').value=branches[0].id;
    document.getElementById('f_branch2').value='';
    document.getElementById('f_branch3').value='';
    document.getElementById('f_status').value='Khách hàng';
    document.getElementById('stuFormAvatar').src='https://ui-avatars.com/api/?name=Hoc+Vien&background=EFEAFB&color=6C5DD3&bold=true';
  }
  openModal('studentModal');
}
function fillFromTrial(){
  const id = document.getElementById('fromTrialSelect').value;
  if(!id) return;
  const t = trialStudents.find(x=>x.id==id);
  document.getElementById('f_name').value = t.name;
  document.getElementById('f_dob').value = `${t.year}-01-01`;
  document.getElementById('f_branch1').value = t.branch1;
  if(t.branch2) document.getElementById('f_branch2').value = t.branch2;
  document.getElementById('stuFormAvatar').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(t.name)}&background=6C5DD3&color=fff&bold=true`;
}
function saveStudent(){
  if(!document.getElementById('f_name').value.trim()){ showToast('Vui lòng nhập Họ tên học viên'); return; }
  closeModal('studentModal');
  showToast('Lưu học viên thành công!');
  renderStudents();
}

populateStudentFilters();
if(document.getElementById('studentsTbody')) renderStudents(1);