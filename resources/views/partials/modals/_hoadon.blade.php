<div class="overlay" id="hoaDonModal">
    <div class="modal">
        <div class="modal-head">
            <h3>Sửa hóa đơn</h3><i class="ri-close-line" onclick="closeModal('hoaDonModal')"></i>
        </div>

        <form id="hoaDonForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="_editing_id" id="hd_editing_id">

            <div class="modal-body">
                <div class="form-grid full">
                    <div class="field">
                        <label>Tên hóa đơn</label>
                        <input type="text" name="ten" id="hd_ten" placeholder="Tên hóa đơn">
                        @error('ten')
                            <div class="badge red hoadon-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Thay file khác (bỏ trống nếu giữ nguyên file cũ)</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx">
                        @error('file')
                            <div class="badge red hoadon-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Ngày tạo</label>
                        <input type="date" name="ngay_tao" id="hd_ngay_tao">
                        @error('ngay_tao')
                            <div class="badge red hoadon-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('hoaDonModal')">Huỷ</button>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>
