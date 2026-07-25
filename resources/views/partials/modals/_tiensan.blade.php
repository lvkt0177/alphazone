<div class="overlay" id="tienSanModal">
    <div class="modal">
        <div class="modal-head">
            <h3 id="tienSanModalTitle">Tạo Tiền sân</h3><i class="ri-close-line" onclick="closeModal('tienSanModal')"></i>
        </div>

        <form id="tienSanForm" method="POST" enctype="multipart/form-data" data-store-url="{{ route('tiensan.store') }}"
            data-update-url-base="{{ url('tiensan') }}">
            @csrf
            <div id="tienSanMethodField"></div>
            <input type="hidden" name="_editing_id" id="ts_editing_id">
            <input type="hidden" name="so_tien" id="ts_money_raw">

            <div class="modal-body">
                <div class="form-grid full">
                    <div class="field">
                        <label>Cơ sở</label>
                        <select name="co_so_id" id="ts_coso">
                            @if (empty($coSos))
                                <option value="">Không có cơ sở nào</option>
                            @else
                                @foreach ($coSos as $cs)
                                    <option value="{{ $cs->id }}">{{ $cs->ten }} -
                                        {{ $cs->giaoVien->ho_ten ?? 'N/A' }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('co_so_id')
                            <div class="badge red tiensan-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Ngày</label>
                        <input type="date" name="ngay" id="ts_date">
                        @error('ngay')
                            <div class="badge red tiensan-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Số tiền (đ)</label>
                        <input type="text" id="ts_money" inputmode="numeric" autocomplete="off"
                            placeholder="VD: 500,000">
                        @error('so_tien')
                            <div class="badge red tiensan-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Ghi chú</label>
                        <textarea name="ghi_chu" id="ts_note" rows="2" class="auto-grow note-input" placeholder="Ghi chú (nếu có)"></textarea>
                    </div>
                    <div class="field">
                        <label>Bill (ảnh)</label>
                        <div class="avatar-upload tiensan-bill-upload">
                            <div class="box tiensan-bill-preview-box" id="ts_bill_preview_box">
                                <img id="ts_bill_preview" src="" alt="">
                            </div>
                            <div>
                                <input type="file" name="bill" id="ts_bill_input" accept="image/*"
                                    class="tiensan-hidden-file-input" onchange="previewTienSanBill(this)">
                                <button type="button" class="btn btn-light btn-sm"
                                    onclick="document.getElementById('ts_bill_input').click()">
                                    <i class="ri-upload-2-line"></i> Tải Bill lên
                                </button>
                                <div class="hint">jpg, png, tối đa 5MB. Để trống nếu không đổi ảnh.</div>
                            </div>
                        </div>
                        @error('bill')
                            <div class="badge red tiensan-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('tienSanModal')">Huỷ</button>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu Tiền sân</button>
            </div>
        </form>
    </div>
</div>