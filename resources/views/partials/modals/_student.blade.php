<div class="overlay" id="studentModal">
  <div class="modal wide">
    <div class="modal-head"><h3 id="studentModalTitle">Thêm Học viên</h3><i class="ri-close-line" onclick="closeModal('studentModal')"></i></div>
    <div class="modal-body">
      <div class="avatar-upload">
        <div class="box"><img id="stuFormAvatar" src="https://ui-avatars.com/api/?name=Hoc+Vien&background=EFEAFB&color=6C5DD3&bold=true" alt=""></div>
        <div>
          <button class="btn btn-light btn-sm"><i class="ri-upload-2-line"></i> Tải ảnh lên</button>
          <div class="hint">Định dạng jpg, png. Tối đa 2MB.</div>
        </div>
      </div>
      <div class="small-note" style="margin-bottom:14px;"><b>Tạo từ Học viên trải nghiệm:</b> <select id="fromTrialSelect" onchange="fillFromTrial()" style="margin-left:8px;padding:6px 10px;border-radius:8px;border:1px solid var(--border);"><option value="">— Chọn học viên trải nghiệm —</option></select></div>
      <div class="form-grid">
        <div class="field"><label>Mã số</label><input id="f_code" type="text" placeholder="VD: HV025"></div>
        <div class="field"><label>Họ tên + Nickname</label><input id="f_name" type="text" placeholder="Nguyễn Văn A (Bin)"></div>
        <div class="field"><label>Ngày tháng năm sinh</label><input id="f_dob" type="date"></div>
        <div class="field"><label>Số điện thoại</label><input id="f_phone" type="text" placeholder="09xxxxxxxx"></div>
        <div class="field"><label>Giới tính</label><select id="f_gender"><option>Nam</option><option>Nữ</option></select></div>
        <div class="field"><label>Trường</label><input id="f_school" type="text" placeholder="Tên trường"></div>
        <div class="field span-2"><label>Địa chỉ</label><input id="f_address" type="text" placeholder="Địa chỉ liên hệ"></div>
        <div class="field"><label>Cơ sở 1</label><select id="f_branch1"></select></div>
        <div class="field"><label>Cơ sở 2</label><select id="f_branch2"><option value="">— Không —</option></select></div>
        <div class="field"><label>Cơ sở 3</label><select id="f_branch3"><option value="">— Không —</option></select></div>
        <div class="field"><label>Trạng thái</label><select id="f_status"><option>Khách hàng</option><option>Tạm nghỉ</option><option>Quay lại</option></select></div>
      </div>
    </div>
    <div class="modal-foot"><button class="btn btn-outline" onclick="closeModal('studentModal')">Huỷ</button><button class="btn btn-primary" onclick="saveStudent()"><i class="ri-save-line"></i> Lưu học viên</button></div>
  </div>
</div>

