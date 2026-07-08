<div class="overlay" id="trialModal">
  <div class="modal">
    <div class="modal-head"><h3>Tạo / Sửa Học viên Trải nghiệm</h3><i class="ri-close-line" onclick="closeModal('trialModal')"></i></div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="field span-2"><label>Họ tên</label><input id="tr_name" type="text" placeholder="Họ và tên"></div>
        <div class="field"><label>Năm sinh</label><input id="tr_year" type="number" placeholder="VD: 2017"></div>
        <div class="field"><label>Trạng thái</label>
          <select id="tr_status"><option>Chưa trải nghiệm</option><option>Truy cứu</option><option>Đã đăng ký</option><option>Không đăng ký</option></select>
        </div>
        <div class="field"><label>Cơ sở 1</label><select id="tr_branch1"></select></div>
        <div class="field"><label>Cơ sở 2</label><select id="tr_branch2"><option value="">— Không —</option></select></div>
        <div class="field span-2"><label>Ghi chú</label><textarea id="tr_note" rows="3" placeholder="Ghi chú thêm..."></textarea></div>
      </div>
    </div>
    <div class="modal-foot"><button class="btn btn-outline" onclick="closeModal('trialModal')">Huỷ</button><button class="btn btn-primary" onclick="saveTrial()"><i class="ri-save-line"></i> Lưu</button></div>
  </div>
</div>

