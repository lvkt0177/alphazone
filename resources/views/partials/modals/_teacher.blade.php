<div class="overlay" id="teacherModal">
  <div class="modal">
    <div class="modal-head"><h3 id="teacherModalTitle">Tạo Giáo viên</h3><i class="ri-close-line" onclick="closeModal('teacherModal')"></i></div>

    <form id="teacherForm" method="POST"
          action="{{ route('giaovien.store') }}"
          data-store-url="{{ route('giaovien.store') }}"
          data-update-url-base="{{ url('giaovien') }}">
      @csrf
      <div id="teacherMethodField"></div>

      <div class="modal-body">
        <div class="form-grid full">
          <div class="field"><label>Họ tên Giáo viên</label><input id="gv_name" name="ho_ten" type="text" placeholder="Họ và tên"></div>
          <div class="field"><label>Ngày sinh</label><input id="gv_dob" name="ngay_sinh" type="date"></div>
          <div class="field"><label>Số điện thoại</label><input id="gv_phone" name="sdt" type="text" placeholder="09xxxxxxxx"></div>
        </div>
        @error('ho_ten') <div class="badge red" style="margin-top:10px;">{{ $message }}</div> @enderror
      </div>
      <div class="modal-foot">
        <button type="button" class="btn btn-outline" onclick="closeModal('teacherModal')">Huỷ</button>
        <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu Giáo viên</button>
      </div>
    </form>
  </div>
</div>