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

  attendanceForm.querySelectorAll('input').forEach(el => {
    el.addEventListener('change', () => attendanceDirty = true);
  });
}

window.addEventListener('beforeunload', function (e) {
  if (attendanceDirty) {
    e.preventDefault();
    e.returnValue = '';
  }
});