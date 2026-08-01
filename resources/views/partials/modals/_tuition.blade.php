<div class="overlay" id="tuitionModal">
    <div class="modal modal-hoc-phi">
        <div class="modal-head">
            <h3 id="tuitionModalTitle">Tạo Học phí</h3><i class="ri-close-line" onclick="closeModal('tuitionModal')"></i>
        </div>

        <form id="tuitionForm" method="POST" action="{{ route('hocphi.store') }}">
            @csrf
            <input type="hidden" name="hoc_vien_id" id="tu_hoc_vien_id">
            <input type="hidden" name="thang" id="tu_thang">
            <input type="hidden" name="hoc_phi" id="tu_fee_raw">
            <input type="hidden" name="nguoi_gioi_thieu_id" id="tu_referrer_id">

            <div class="modal-body">
                <div class="form-grid">
                    <div class="field"><label>Mã số</label><input id="tu_code" type="text" readonly></div>
                    <div class="field"><label>Họ tên</label><input id="tu_name" type="text" readonly></div>
                    <div class="field">
                        <div class="tuition-fee-head">
                            <label class="tuition-label-flush">Học phí (đ)</label>
                            <label class="tuition-toggle-label">
                                <span class="switch">
                                    <input type="checkbox" id="tu_gioi_thieu_ban" name="gioi_thieu_ban" value="1">
                                    <span class="switch-track"></span>
                                </span>
                                Giới thiệu bạn
                            </label>
                        </div>
                        <input id="tu_fee" type="text" inputmode="numeric" autocomplete="off"
                            placeholder="VD: 500,000">
                        <div id="tu_du_kien_hint" class="text-2 tuition-du-kien-hint"></div>
                        @error('hoc_phi')
                            <div class="badge red tuition-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="tuition-uniform-row">
                            <div class="tuition-uniform-col tuition-uniform-col--muc">
                                <label>Đồng phục</label>
                                <select id="tu_uniform" name="dong_phuc">
                                    <option value="">— Không chọn —</option>
                                    @foreach (\App\Enum\MucDongPhuc::cases() as $muc)
                                        <option value="{{ $muc->value }}">{{ $muc->getLabel() }}</option>
                                    @endforeach
                                </select>
                                @error('dong_phuc')
                                    <div class="badge red tuition-field-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="tuition-uniform-col tuition-uniform-col--size">
                                <label>Size quần áo</label>
                                <select id="tu_uniform_size" name="dong_phuc_size">
                                    <option value="">N/A</option>
                                    @foreach (\App\Enum\SizeDongPhuc::cases() as $size)
                                        <option value="{{ $size->value }}">{{ $size->getLabel() }}</option>
                                    @endforeach
                                </select>
                                @error('dong_phuc_size')
                                    <div class="badge red tuition-field-error mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="field span-2 tuition-referrer-wrap" id="tu_referrer_wrap">
                        <label>Học viên giới thiệu</label>
                        <div class="tuition-referrer-search-wrap">
                            <input type="text" id="tu_referrer_search" autocomplete="off"
                                placeholder="Tìm theo Mã số hoặc Họ tên...">
                            <div id="tu_referrer_list"
                                class="tuition-referrer-list"></div>
                        </div>
                        @error('nguoi_gioi_thieu_id')
                            <div class="badge red tuition-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field span-2">
                        <label>Ngày đóng</label>
                        <input id="tu_date" name="ngay_dong" type="date">
                        @error('ngay_dong')
                            <div class="badge red tuition-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-foot tuition-modal-foot">
                <div id="tu_delete_wrap" class="tuition-delete-wrap">
                    @if (hasQuyen('hocphi', 'xoa'))
                        <button type="button" class="btn btn-outline tuition-delete-btn" id="tu_delete_btn">
                            <i class="ri-delete-bin-line"></i> Xoá bản ghi
                        </button>
                    @endif
                </div>
                <div class="tuition-modal-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal('tuitionModal')">Huỷ</button>
                    <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu học phí</button>
                </div>
            </div>
        </form>

        <form id="tuitionDeleteForm" method="POST" action="{{ route('hocphi.destroy') }}" class="tuition-hidden-form">
            @csrf
            @method('DELETE')
            <input type="hidden" name="hoc_vien_id" id="td_hoc_vien_id">
            <input type="hidden" name="thang" id="td_thang">
        </form>
    </div>
</div>