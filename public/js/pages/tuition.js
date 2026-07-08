let tuiPage = 1; const TUI_PAGE_SIZE = 8;

function populateTuitionMonthFilter(){
  document.getElementById('tuiMonthFilter').innerHTML = months.slice().reverse().map(m=>`<option ${m===CURRENT_MONTH?'selected':''}>${m}</option>`).join('');
}

function renderTuition(page){
  if(page) tuiPage=page;
  const q = document.getElementById('tuiSearch').value.trim().toLowerCase();
  const statusF = document.getElementById('tuiStatusFilter').value;
  let list = tuitionRecords.map(t=>({...t, student: students.find(s=>s.id===t.studentId)})).filter(t=>{
    const matchQ = !q || t.student.code.toLowerCase().includes(q) || t.student.name.toLowerCase().includes(q);
    const matchS = !statusF || (statusF==='Đã đóng'? t.paid : !t.paid);
    return matchQ && matchS;
  });
  const totalPages = Math.max(1, Math.ceil(list.length/TUI_PAGE_SIZE));
  if(tuiPage>totalPages) tuiPage=totalPages;
  const pageList = list.slice((tuiPage-1)*TUI_PAGE_SIZE, tuiPage*TUI_PAGE_SIZE);

  document.getElementById('tuitionTbody').innerHTML = pageList.map(t=>`
    <tr>
      <td><span class="code-link" onclick="openStudentDetail(${t.student.id})">${t.student.code}</span></td>
      <td><div class="cell-user"><img src="${t.student.avatar}" alt=""><div class="name">${t.student.name}</div></div></td>
      <td>${[t.student.branch1,t.student.branch2,t.student.branch3].filter(Boolean).map(id=>branches.find(b=>b.id===id).ten).join(', ')}</td>
      <td>${t.paid? '<span class="badge green">Đã đóng</span>' : '<span class="badge red">Chưa đóng</span>'}</td>
      <td>${t.date || '—'}</td>
      <td><button class="btn btn-light btn-sm" onclick="openTuitionModal(${t.student.id})"><i class="ri-edit-line"></i> ${t.paid?'Sửa':'Tạo'} học phí</button></td>
    </tr>`).join('') || '<tr><td colspan="6" class="text-2" style="text-align:center;padding:30px;">Không có dữ liệu</td></tr>';

  let pager='';
  pager += `<button ${tuiPage===1?'disabled':''} onclick="renderTuition(${tuiPage-1})">Trước</button>`;
  for(let i=1;i<=totalPages;i++) pager += `<button class="${i===tuiPage?'active':''}" onclick="renderTuition(${i})">${i}</button>`;
  pager += `<button ${tuiPage===totalPages?'disabled':''} onclick="renderTuition(${tuiPage+1})">Sau</button>`;
  document.getElementById('tuitionPager').innerHTML = pager;
}
function openTuitionModal(studentId){
  const s = students.find(x=>x.id===studentId);
  const rec = tuitionRecords.find(t=>t.studentId===studentId);
  document.getElementById('tu_code').value = s.code;
  document.getElementById('tu_name').value = s.name;
  document.getElementById('tu_fee').value = rec.fee;
  document.getElementById('tu_uniform').value = rec.uniform;
  document.getElementById('tu_date').value = todayIso();
  document.getElementById('tuitionModal').dataset.sid = studentId;
  openModal('tuitionModal');
}
function saveTuition(){
  closeModal('tuitionModal');
  showToast('Lưu thông tin học phí thành công!');
  renderTuition();
}

populateTuitionMonthFilter();
renderTuition(1);