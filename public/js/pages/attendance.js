const attendanceForm = document.getElementById('attendanceForm');
let attendanceDirty = false;

if (attendanceForm) {
  attendanceForm.addEventListener('submit', function (e) {
    e.preventDefault();
    confirmAction(
      'Lưu điểm danh',
      'Bạn có chắc chắn muốn lưu điểm danh cho ngày đã chọn?',
      () => { attendanceDirty = false; attendanceForm.submit(); }
    );
  });

  attendanceForm.querySelectorAll('input, textarea').forEach(el => {
    el.addEventListener('change', () => attendanceDirty = true);
  });
}

window.addEventListener('beforeunload', function (e) {
  if (attendanceDirty) {
    e.preventDefault();
    e.returnValue = '';
  }
});

function renderHocBuList(query) {
  const list = document.getElementById('hb_list');
  if (!list) return;
  const options = window.__hocVienChoHocBu || [];
  const q = query.trim().toLowerCase();

  const filtered = options
    .filter(o => !q || o.ma_so.toLowerCase().includes(q) || o.ho_ten.toLowerCase().includes(q))
    .slice(0, 20);

  list.innerHTML = filtered.length
    ? filtered.map(o => `
        <div class="referrer-option" data-id="${o.id}" data-ma-so="${o.ma_so}" data-ho-ten="${o.ho_ten}"
             style="padding:9px 14px;cursor:pointer;font-size:13.5px;border-bottom:1px solid var(--border);">
          <b>${o.ma_so}</b> - ${o.ho_ten}
        </div>`).join('')
    : `<div class="text-2" style="padding:10px 14px;font-size:13px;">Không tìm thấy học viên phù hợp</div>`;

  list.style.display = 'block';
}

function chonHocVienHocBu(id, maSo, hoTen) {
  document.getElementById('hb_hoc_vien_id').value = id;
  document.getElementById('hb_search').value = `${maSo} - ${hoTen}`;
  document.getElementById('hb_list').style.display = 'none';
  document.getElementById('hb_submit_btn').disabled = false;
}

document.addEventListener('DOMContentLoaded', function () {
  const hbSearch = document.getElementById('hb_search');
  if (hbSearch) {
    hbSearch.addEventListener('input', function () {
      document.getElementById('hb_hoc_vien_id').value = '';
      document.getElementById('hb_submit_btn').disabled = true;
      renderHocBuList(this.value);
    });
    hbSearch.addEventListener('focus', function () {
      renderHocBuList(this.value);
    });
  }
});

document.addEventListener('click', function (e) {
  const option = e.target.closest('.referrer-option');
  if (option && document.getElementById('hb_list')?.contains(option)) {
    chonHocVienHocBu(Number(option.dataset.id), option.dataset.maSo, option.dataset.hoTen);
    return;
  }
  if (!e.target.closest('#hb_search') && !e.target.closest('#hb_list')) {
    const list = document.getElementById('hb_list');
    if (list) list.style.display = 'none';
  }
});

function xoaHocVienHocBu(url, hoTen) {
  confirmAction(
    'Xoá học viên học bù',
    `Bạn có chắc muốn xoá ${hoTen} khỏi danh sách học bù ngày này?`,
    () => {
      const form = document.getElementById('deleteHocBuForm');
      form.action = url;
      form.submit();
    }
  );
}