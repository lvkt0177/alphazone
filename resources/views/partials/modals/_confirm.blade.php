<div class="overlay" id="confirmModal">
  <div class="modal" style="max-width:380px;">
    <div class="modal-body" style="text-align:center;padding:30px 24px 10px;">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--orange-bg);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
        <i class="ri-question-line" style="font-size:26px;color:var(--orange);"></i>
      </div>
      <div style="font-weight:800;font-size:16px;margin-bottom:6px;" id="confirmTitle">Xác nhận</div>
      <div class="text-2" id="confirmMsg">Bạn có chắc chắn muốn thực hiện thao tác này?</div>
    </div>
    <div class="modal-foot" style="justify-content:center;">
      <button class="btn btn-outline" onclick="closeModal('confirmModal')">Huỷ</button>
      <button class="btn btn-primary" id="confirmOkBtn">Xác nhận</button>
    </div>
