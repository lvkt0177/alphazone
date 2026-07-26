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
        <div class="referrer-option attendance-referrer-option" data-id="${o.id}" data-ma-so="${o.ma_so}" data-ho-ten="${o.ho_ten}">
          <b>${o.ma_so}</b> - ${o.ho_ten}
        </div>`).join('')
    : `<div class="text-2 attendance-referrer-empty">Không tìm thấy học viên phù hợp</div>`;

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

  // Case 1 fix: "Thêm vào danh sách" không còn gửi form lên server nữa.
  // Chỉ vẽ thêm 1 dòng trên giao diện; dữ liệu chỉ thực sự được lưu khi bấm "Lưu điểm danh".
  const hbForm = document.getElementById('hocBuForm');
  if (hbForm) {
    hbForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const id = Number(document.getElementById('hb_hoc_vien_id').value);
      if (!id) return;
      themHocVienHocBuPending(id);
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

// Xoá học viên học bù ĐÃ LƯU thật trong DB (bản ghi diem_danh đã tồn tại từ trước) -> vẫn gọi API xoá như cũ.
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

// ============================================================
// Thêm học viên học bù CHỈ TRÊN GIAO DIỆN — chưa ghi vào DB.
// Học viên chỉ thật sự được ghi vào bảng diem_danhs khi bấm "Lưu điểm danh".
// Nếu F5 hoặc rời trang mà chưa Lưu, dòng vừa thêm sẽ mất (đúng như dự kiến).
// ============================================================

function escapeHtml(str) {
  const div = document.createElement('div');
  div.textContent = str ?? '';
  return div.innerHTML;
}

function themHocVienHocBuPending(id) {
  const list = window.__hocVienChoHocBu || [];
  const idx = list.findIndex(o => o.id === id);
  if (idx === -1) return;

  const hv = list[idx];
  list.splice(idx, 1); // bỏ khỏi danh sách để chọn thêm lần sau

  appendPendingHocBuRow(hv);
  capNhatHbEmptyMsg();

  closeModal('hocBuModal');
  document.getElementById('hb_search').value = '';
  document.getElementById('hb_hoc_vien_id').value = '';
  document.getElementById('hb_submit_btn').disabled = true;
}

function appendPendingHocBuRow(hv) {
  const tbody = document.getElementById('attendanceTbody');
  if (!tbody) return;

  const emptyRow = document.getElementById('attendanceEmptyRow');
  if (emptyRow) emptyRow.remove();

  const maSo = escapeHtml(hv.ma_so);
  const hoTen = escapeHtml(hv.ho_ten);

  const tr = document.createElement('tr');
  tr.className = 'attendance-row-hocbu';
  tr.innerHTML = `
    <td><a href="${window.__hocVienShowUrlBase}/${hv.id}" class="code-link">${maSo}</a></td>
    <td>
      <div class="cell-user"><img src="${hv.avatar_url}" alt="">
        <div class="attendance-user-info">
          <div class="name">${hoTen}</div>
          <div class="attendance-hocbu-meta">
            <span class="badge orange attendance-hocbu-badge">Học bù</span>
            <i class="ri-close-circle-line del attendance-hocbu-del"></i>
          </div>
        </div>
      </div>
    </td>
    <td>
      <input type="hidden" name="diem_danh[${hv.id}][hoc_vien_id]" value="${hv.id}">
      <input type="hidden" name="diem_danh[${hv.id}][hoc_bu]" value="1">
      <label class="check-row">
        <input type="radio" name="diem_danh[${hv.id}][trang_thai]" value="1" checked> Đi học
      </label>
    </td>
    <td>
      <label class="check-row">
        <input type="radio" name="diem_danh[${hv.id}][trang_thai]" value="2"> Vắng
      </label>
    </td>
    <td>
      <textarea class="note-input auto-grow" name="diem_danh[${hv.id}][ghi_chu]" rows="1" maxlength="150"
        placeholder="Ghi chú (nếu có)"></textarea>
    </td>
  `;

  tr.querySelector('.attendance-hocbu-del').addEventListener('click', () => xoaHocVienHocBuPending(tr, hv));
  tr.querySelectorAll('input, textarea').forEach(el => {
    el.addEventListener('change', () => attendanceDirty = true);
  });

  const noteInput = tr.querySelector('textarea.auto-grow');
  if (noteInput) {
    const resize = () => {
      noteInput.style.height = 'auto';
      noteInput.style.height = Math.min(noteInput.scrollHeight, 110) + 'px';
    };
    noteInput.addEventListener('input', resize);
  }

  tbody.appendChild(tr);
  attendanceDirty = true;
}

function xoaHocVienHocBuPending(tr, hv) {
  tr.remove();
  window.__hocVienChoHocBu = window.__hocVienChoHocBu || [];
  window.__hocVienChoHocBu.push(hv);
  capNhatHbEmptyMsg();
}

function capNhatHbEmptyMsg() {
  const msg = document.getElementById('hbEmptyMsg');
  if (!msg) return;
  const conLai = (window.__hocVienChoHocBu || []).length;
  msg.classList.toggle('attendance-hidden', conLai > 0);
}