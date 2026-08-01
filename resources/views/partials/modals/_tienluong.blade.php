<div class="overlay" id="tienLuongModal">
    <div class="modal">
        <div class="modal-head">
            <h3 id="tlModalTitle">Sửa lương</h3><i class="ri-close-line" onclick="closeModal('tienLuongModal')"></i>
        </div>

        <form id="tienLuongForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="_editing_id" id="tl_editing_id">
            <input type="hidden" name="_ho_ten" id="tl_ho_ten">
            <input type="hidden" name="_field" id="tl_field">
            <input type="hidden" name="_label" id="tl_label">

            <div class="modal-body">
                <div class="form-grid full">
                    <div class="field">
                        <label id="tl_field_label">Giá trị</label>
                        <input type="number" min="0" id="tl_value" placeholder="0">
                        @error('luong_co_ban')
                            <div class="badge red tienluong-field-error">{{ $message }}</div>
                        @enderror
                        @error('don_gia_gio')
                            <div class="badge red tienluong-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('tienLuongModal')">Huỷ</button>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>