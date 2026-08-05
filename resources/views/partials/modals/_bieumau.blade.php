<div class="overlay" id="bieuMauModal">
    <div class="modal">
        <div class="modal-head">
            <h3>Sửa biểu mẫu</h3><i class="ri-close-line" onclick="closeModal('bieuMauModal')"></i>
        </div>

        <form id="bieuMauForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="_editing_id" id="bm_editing_id">

            <div class="modal-body">
                <div class="form-grid full">
                    <div class="field">
                        <label>Tên biểu mẫu</label>
                        <input type="text" name="ten" id="bm_ten" placeholder="Tên biểu mẫu">
                        @error('ten')
                            <div class="badge red bieumau-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Thay file khác (bỏ trống nếu giữ nguyên file cũ)</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx">
                        @error('file')
                            <div class="badge red bieumau-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('bieuMauModal')">Huỷ</button>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>

<div class="overlay" id="bieuMauMauTrongModal">
    <div class="modal">
        <div class="modal-head">
            <h3>Mẫu trống</h3><i class="ri-close-line" onclick="closeModal('bieuMauMauTrongModal')"></i>
        </div>

        <form id="bieuMauMauTrongForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_mau_trong" value="1">

            <div class="modal-body">
                <div class="form-grid full">
                    <div class="field">
                        <label>File mẫu trống (pdf, doc, docx, xls, xlsx — tối đa 30MB)</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx">
                        @error('file')
                            <div class="badge red bieumau-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('bieuMauMauTrongModal')">Huỷ</button>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>