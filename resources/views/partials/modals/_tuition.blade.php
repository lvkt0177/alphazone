<div class="overlay" id="tuitionModal">
  <div class="modal">
    <div class="modal-head"><h3>Tạo / Sửa Học phí</h3><i class="ri-close-line" onclick="closeModal('tuitionModal')"></i></div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="field"><label>Mã số</label><input id="tu_code" type="text" readonly></div>
        <div class="field"><label>Họ tên</label><input id="tu_name" type="text" readonly></div>
        <div class="field"><label>Học phí (đ)</label><input id="tu_fee" type="number" placeholder="VD: 500000"></div>
        <div class="field"><label>Đồng phục (đ)</label><input id="tu_uniform" type="number" placeholder="VD: 150000"></div>
        <div class="field span-2"><label>Ngày đóng</label><input id="tu_date" type="date"></div>
      </div>
    </div>
    <div class="modal-foot"><button class="btn btn-outline" onclick="closeModal('tuitionModal')">Huỷ</button><button class="btn btn-primary" onclick="saveTuition()"><i class="ri-save-line"></i> Lưu học phí</button></div>
  </div>
</div>

