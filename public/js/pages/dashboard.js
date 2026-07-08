/* Cần load: common.js, fake-data.js, rồi tới file này */
function renderDashboard(){
  const monthSel = document.getElementById('dashMonthSel');
  monthSel.innerHTML = months.map(m=>`<option ${m===CURRENT_MONTH?'selected':''}>${m}</option>`).join('');

  const totalHV = students.length;
  const kh = students.filter(s=>s.status==='Khách hàng').length;
  const tn = students.filter(s=>s.status==='Tạm nghỉ').length;
  const ql = students.filter(s=>s.status==='Quay lại').length;
  const totalFee = tuitionRecords.filter(t=>t.paid).reduce((a,b)=>a+b.fee,0);
  const totalUniform = tuitionRecords.filter(t=>t.paid).reduce((a,b)=>a+b.uniform,0);
  const unpaidCount = tuitionRecords.filter(t=>!t.paid).length;

  const stats = [
    {icon:'ri-group-line', bg:'var(--purple-bg)', color:'var(--purple)', label:'Tổng Học viên', value:totalHV, trend:'up', trendVal:'+8.4%', note:'so với tháng trước'},
    {icon:'ri-money-dollar-circle-line', bg:'var(--green-bg)', color:'var(--green)', label:'Học phí thu được ('+CURRENT_MONTH+')', value:money(totalFee), trend:'up', trendVal:'+12.6%', note:'so với tháng trước'},
    {icon:'ri-t-shirt-line', bg:'var(--blue-bg)', color:'var(--blue)', label:'Đồng phục thu được', value:money(totalUniform), trend:'up', trendVal:'+4.1%', note:'so với tháng trước'},
    {icon:'ri-alarm-warning-line', bg:'var(--red-bg)', color:'var(--red)', label:'Chưa đóng học phí', value:unpaidCount+' học viên', trend:'down', trendVal:'-2.3%', note:'so với tháng trước'},
  ];
  document.getElementById('statGrid').innerHTML = stats.map(s=>`
    <div class="card stat-card">
      <div class="top"><div class="stat-icon" style="background:${s.bg};color:${s.color};"><i class="${s.icon}"></i></div></div>
      <div class="label">${s.label}</div>
      <div class="value">${s.value}</div>
      <span class="trend ${s.trend}"><i class="ri-arrow-${s.trend==='up'?'up':'down'}-line"></i> ${s.trendVal}</span><span class="trend-note">${s.note}</span>
    </div>`).join('');
  document.getElementById('statsGridPage').innerHTML = document.getElementById('statGrid').innerHTML;

  const unpaid = tuitionRecords.filter(t=>!t.paid).slice(0,6).map(t=>{
    const s = students.find(x=>x.id===t.studentId);
    return `<div class="item"><img src="${s.avatar}" alt=""><div class="info"><div class="t">${s.name}</div><div class="s">${s.code} • ${branches.find(b=>b.id===s.branch1).ten}</div></div><span class="badge orange">Chưa đóng</span></div>`;
  }).join('') || '<div class="text-2">Tất cả học viên đã đóng học phí 🎉</div>';
  document.getElementById('unpaidList').innerHTML = unpaid;

  document.getElementById('branchCountList').innerHTML = branches.map(b=>{
    const cnt = students.filter(s=>s.branch1===b.id||s.branch2===b.id||s.branch3===b.id).length;
    return `<div class="item"><div class="stat-icon" style="width:38px;height:38px;font-size:16px;background:var(--primary-light);color:var(--primary);"><i class="ri-building-4-line"></i></div><div class="info"><div class="t">${b.ten}</div><div class="s">Phụ trách: ${fakeTeachers.find(t=>t.id===b.giaoVienId).hoTen}</div></div><span class="amt">${cnt} HV</span></div>`;
  }).join('');

  const ctx = document.getElementById('revenueChart');
  if(ctx){
    new Chart(ctx, { type:'line', data:{ labels: months, datasets:[
        {label:'Học phí', data:[9200000,9800000,10500000,11200000,10900000,totalFee||12100000], borderColor:'#6C5DD3', backgroundColor:'rgba(108,93,211,.12)', fill:true, tension:.4, borderWidth:3, pointRadius:3},
        {label:'Đồng phục', data:[1200000,900000,1500000,1100000,1300000,totalUniform||1450000], borderColor:'#FFA45C', backgroundColor:'rgba(255,164,92,.12)', fill:true, tension:.4, borderWidth:3, pointRadius:3},
      ]}, options:{plugins:{legend:{display:false}}, scales:{y:{ticks:{callback:v=>(v/1000000)+'tr'}, grid:{color:'#F0F1F6'}}, x:{grid:{display:false}}}} });
  }
  const sctx = document.getElementById('statusChart');
  if(sctx){
    new Chart(sctx, {type:'doughnut', data:{labels:['Khách hàng','Tạm nghỉ','Quay lại'], datasets:[{data:[kh,tn,ql], backgroundColor:['#16A34A','#D97706','#2563EB'], borderWidth:0}]}, options:{cutout:'70%', plugins:{legend:{display:false}}}});
  }
  document.getElementById('statusLegend').innerHTML = `
    <div class="legend" style="flex-wrap:wrap;"><span><i class="dot-legend" style="background:#16A34A"></i>Khách hàng (${kh})</span></div>
    <div class="legend" style="flex-wrap:wrap;"><span><i class="dot-legend" style="background:#D97706"></i>Tạm nghỉ (${tn})</span></div>
    <div class="legend" style="flex-wrap:wrap;"><span><i class="dot-legend" style="background:#2563EB"></i>Quay lại (${ql})</span></div>`;

  const s2 = document.getElementById('statusChart2');
  if(s2){
    new Chart(s2, {type:'pie', data:{labels:['Khách hàng','Tạm nghỉ','Quay lại'], datasets:[{data:[kh,tn,ql], backgroundColor:['#16A34A','#D97706','#2563EB'], borderWidth:0}]}, options:{plugins:{legend:{position:'bottom'}}}});
  }
  const bctx = document.getElementById('branchTuitionChart');
  if(bctx){
    new Chart(bctx, {type:'bar', data:{ labels: branches.map(b=>b.ten),
      datasets:[{label:'Học phí thu được', data: branches.map(b=> tuitionRecords.filter(t=>t.paid && students.find(s=>s.id===t.studentId).branch1===b.id).reduce((a,c)=>a+c.fee,0)), backgroundColor:'#6C5DD3', borderRadius:8}]
    }, options:{plugins:{legend:{display:false}}, scales:{y:{ticks:{callback:v=>(v/1000000)+'tr'}, grid:{color:'#F0F1F6'}}, x:{grid:{display:false}}}}});
  }
}

renderDashboard();