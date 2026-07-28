<div class="overlay" id="caiDatHocPhiModal">
    <div class="modal">
        <div class="modal-head">
            <h3 id="caiDatHocPhiModalTitle">Thêm cấu hình</h3><i class="ri-close-line"
                onclick="closeModal('caiDatHocPhiModal')"></i>
        </div>

        <form id="caiDatHocPhiForm" method="POST" action="{{ route('caidathocphi.store') }}"
            data-store-url="{{ route('caidathocphi.store') }}" data-update-url-base="{{ url('caidathocphi') }}">
            @csrf
            <div id="caiDatHocPhiMethodField"></div>
            <input type="hidden" name="_editing_id" id="cdhp_editing_id">

            <div class="modal-body">
                <div class="form-grid full">
                    <div class="field">
                        <label>Số lượng Cơ sở</label>
                        <input id="cdhp_so_luong" name="so_luong_co_so" type="number" min="1"
                            placeholder="VD: 3">
                        @error('so_luong_co_so')
                            <div class="badge red caidathocphi-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Học phí (đ)</label>
                        <input id="cdhp_hoc_phi" name="hoc_phi" type="number" min="0" placeholder="VD: 1100000">
                        @error('hoc_phi')
                            <div class="badge red caidathocphi-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Tổng số buổi/tháng</label>
                        <input id="cdhp_tong_buoi" name="tong_so_buoi" type="number" min="1" placeholder="VD: 12">
                        @error('tong_so_buoi')
                            <div class="badge red caidathocphi-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('caiDatHocPhiModal')">Huỷ</button>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu cấu hình</button>
            </div>
        </form>
    </div>
</div>