const fakeTeacherNames = ['Nguyễn Văn A','Trần Thị Bích','Lê Văn Cường','Phạm Thị Diễm','Hoàng Văn Em','Đỗ Thị Phượng','Vũ Văn Giang'];
const fakeTeachers = fakeTeacherNames.map((t,i)=>({id:i+1, hoTen:t}));

const tenCoSo = ['Liên Nghĩa T3','Hiệp Thạnh T3','Đinh Văn Tả','Tân Hà','Nam Ban'];
const branches = tenCoSo.map((t,i)=>({id:i+1, ten:t, giaoVienId: fakeTeachers[i%fakeTeachers.length].id}));
function branchLabel(b){ const gv = fakeTeachers.find(t=>t.id===b.giaoVienId); return `${b.ten} - Thầy/Cô ${gv.hoTen}`; }
function branchNameById(id){ const b = branches.find(x=>x.id==id); return b ? branchLabel(b) : '—'; }

const hoTenHV = ['Nguyễn Minh An','Trần Thị Bích Ngọc','Lê Hoàng Bảo','Phạm Gia Hân','Hoàng Đức Huy','Vũ Thị Kim Ngân',
'Đặng Quốc Khánh','Bùi Thị Lan Anh','Đỗ Minh Khôi','Ngô Thị Mai Anh','Dương Anh Tuấn','Lý Thị Ngọc Trâm',
'Phan Văn Nam','Trịnh Thị Hồng Nhung','Đinh Công Sơn','Lâm Thị Thu Thảo','Hồ Văn Phát','Mai Thị Yến Nhi',
'Chu Đình Long','Tô Thị Hạnh Nguyên','Vương Minh Tuệ','Đào Thị Quỳnh Anh','Kiều Văn Đạt','Từ Thị Diễm My'];
const nickHV = ['An','Bích','Bảo','Hân','Huy','Ngân','Khánh','Lan','Khôi','Mai','Tuấn','Ngọc','Nam','Hồng','Sơn','Thu','Phát','Yến','Long','Hạnh','Tuệ','Quỳnh','Đạt','Diễm'];
const truongList = ['TH Lê Văn Tám','THCS Nguyễn Trãi','TH Kim Đồng','THCS Lam Sơn','TH Trần Quốc Toản'];
const diaChiList = ['Liên Nghĩa, Đức Trọng, Lâm Đồng','Hiệp Thạnh, Đức Trọng, Lâm Đồng','Tân Hà, Lâm Hà, Lâm Đồng','Đinh Văn, Lâm Hà, Lâm Đồng','Nam Ban, Lâm Hà, Lâm Đồng'];

const students = hoTenHV.map((name,i)=>{
  const gender = (i%3===0)?'Nữ':(i%5===0?'Nữ':'Nam');
  let status = 'Khách hàng';
  if(i%7===0) status='Tạm nghỉ'; else if(i%11===0) status='Quay lại';
  const b1 = branches[i%branches.length].id;
  const b2 = (i%3===0) ? branches[(i+1)%branches.length].id : '';
  const b3 = (i%8===0) ? branches[(i+2)%branches.length].id : '';
  const year = 2013 + (i%9);
  const month = (i%12)+1;
  const day = (i*3%27)+1;
  return {
    id:i+1, code:'HV'+String(i+1).padStart(3,'0'), name, nickname:nickHV[i],
    dob:`${String(day).padStart(2,'0')}/${String(month).padStart(2,'0')}/${year}`,
    dobIso:`${year}-${String(month).padStart(2,'0')}-${String(day).padStart(2,'0')}`,
    phone:'09'+String(11223344+i*91117).slice(0,8),
    gender, school:truongList[i%truongList.length], address:diaChiList[i%diaChiList.length],
    branch1:b1, branch2:b2, branch3:b3, status,
    avatar:`https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=${['6C5DD3','FF7EB3','2563EB','16A34A','D97706'][i%5]}&color=fff&bold=true`
  };
});

const months = ['Tháng 2/2026','Tháng 3/2026','Tháng 4/2026','Tháng 5/2026','Tháng 6/2026','Tháng 7/2026'];
const CURRENT_MONTH = 'Tháng 7/2026';

const tuitionRecords = students.map((s,i)=>{
  const paid = (i%3!==0);
  return {
    studentId:s.id, month:CURRENT_MONTH, fee: 500000 + (i%4)*100000, uniform: (i%6===0)? 150000:0,
    paid, date: paid ? `${String((i%27)+1).padStart(2,'0')}/07/2026` : ''
  };
});

function tuitionHistory(studentId){
  return months.slice(-4).map((m,i)=>({month:m, fee:500000+((studentId+i)%4)*100000, uniform:(i%2===0)?150000:0, date:`${String(((studentId*i+5)%27)+1).padStart(2,'0')}/${String(2+i).padStart(2,'0')}/2026`}));
}
function attendanceHistory(studentId){
  const s = students.find(x=>x.id===studentId);
  const b = branches.find(x=>x.id===s.branch1);
  const gv = fakeTeachers.find(t=>t.id===b.giaoVienId);
  const out=[];
  for(let i=0;i<8;i++){
    const day = 30-i*3; if(day<1) continue;
    out.push({date:`${String(day).padStart(2,'0')}/06/2026`, status: (i%4===0)?'Vắng':'Đi học', note:(i%4===0)?'Bị ốm':'', place:`${b.ten} - ${gv.hoTen}`});
  }
  return out;
}

const trialStatusList = ['Chưa trải nghiệm','Truy cứu','Đã đăng ký','Không đăng ký'];
const trialNames = ['Đặng Thảo Vy','Trần Nhật Minh','Nguyễn Bảo Châu','Lê Gia Bảo','Phạm Anh Thư','Vũ Đăng Khoa','Hoàng Bảo Ngọc','Đỗ Nhật Nam','Ngô Thảo My','Bùi Đức Anh'];
const trialStudents = trialNames.map((name,i)=>({
  id:i+1, name, year: 2016+(i%7), branch1: branches[i%branches.length].id, branch2: (i%4===0)? branches[(i+2)%branches.length].id : '',
  status: trialStatusList[i%trialStatusList.length], note: (i%3===0)?'Phụ huynh hẹn gọi lại sau':(i%3===1?'Đã tham gia buổi học thử':'')
}));