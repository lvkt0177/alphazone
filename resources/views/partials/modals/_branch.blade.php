<div class="overlay" id="branchModal">
  <div class="modal">
    <div class="modal-head"><h3>Tạo / Sửa Cơ sở</h3><i class="ri-close-line" onclick="closeModal('branchModal')"></i></div>
    <div class="modal-body">
      <div class="form-grid full">
        <div class="field"><label>Tên cơ sở</label><input id="br_name" type="text" placeholder="VD: Liên Nghĩa T3"></div>
        <div class="field"><label>Người phụ trách</label><select id="br_teacher"></select></div>
      </div>
    </div>
    <div class="modal-foot"><button class="btn btn-outline" onclick="closeModal('branchModal')">Huỷ</button><button class="btn btn-primary" onclick="saveBranch()"><i class="ri-save-line"></i> Lưu Cơ sở</button></div>
  </div>
</div>

