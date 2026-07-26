<div class="overlay" id="trialModal">
    <div class="modal">
        <div class="modal-head">
            <h3 id="trialModalTitle">Tạo Học viên Trải nghiệm</h3><i class="ri-close-line"
                onclick="closeModal('trialModal')"></i>
        </div>

        <form id="trialForm" method="POST" action="{{ route('trainghiem.store') }}"
            data-store-url="{{ route('trainghiem.store') }}" data-update-url-base="{{ url('trainghiem') }}">
            @csrf
            <div id="trialMethodField"></div>
            <input type="hidden" name="_editing_id" id="trialEditingId">

            <div class="modal-body">
                <div class="form-grid">
                    <div class="field span-2">
                        <label>Họ tên</label>
                        <input id="tr_name" name="ho_ten" type="text" placeholder="Họ và tên">
                        @error('ho_ten')
                            <div class="badge red trial-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Số điện thoại</label>
                        <input id="tr_phone" name="sdt" type="text" placeholder="09xxxxxxxx">
                        @error('sdt')
                            <div class="badge red trial-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Năm sinh</label>
                        <input id="tr_year" name="nam_sinh" type="number" placeholder="VD: 2017">
                    </div>
                    <div class="field">
                        <label>Ngày trải nghiệm</label>
                        <input id="tr_date" name="ngay_trai_nghiem" type="date">
                        @error('ngay_trai_nghiem')
                            <div class="badge red trial-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field">
                        <label>Trạng thái</label>
                        <select id="tr_status" name="trang_thai">
                            @foreach (\App\Enum\TrangThaiLoaiDangKyTraiNghiem::cases() as $st)
                                <option value="{{ $st->value }}">{{ $st->getLabel() }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if (empty($coSos))
                        <div class="badge red trial-field-error">Không có cơ sở nào để chọn. Vui lòng thêm cơ sở
                            trước.</div>
                    @else
                        <div class="field span-2">
                            <div class="trial-branch-head">
                                <label class="trial-label-flush">Cơ sở (chọn ít nhất 1 cơ sở)</label>
                                <span id="branchCount" class="badge purple trial-branch-count">0 đã chọn</span>
                            </div>

                            <div class="trial-branch-toolbar">
                                <div class="search-mini trial-search-wrap">
                                    <i class="ri-search-line"></i>
                                    <input type="text" id="branchSearch" placeholder="Tìm cơ sở..."
                                        class="trial-branch-search-input">
                                </div>
                                {{-- <button type="button" class="btn btn-light btn-sm" onclick="chonTatCaCoSo(true)">Chọn
                                    tất
                                    cả</button> --}}
                                <button type="button" class="btn btn-light btn-sm" onclick="chonTatCaCoSo(false)">Bỏ
                                    chọn</button>
                            </div>

                            <div id="c_branches"
                                class="trial-branch-chips">
                                @foreach ($coSos->sortBy(fn($cs) => (int) filter_var($cs->ten, FILTER_SANITIZE_NUMBER_INT) ?: $cs->id) as $cs)
                                    <label class="branch-chip" data-name="{{ strtolower($cs->ten) }}">
                                        <input type="checkbox" name="co_so_ids[]" value="{{ $cs->id }}"
                                            class="create-branch-checkbox"
                                            {{ in_array($cs->id, old('co_so_ids', [])) ? 'checked' : '' }}
                                            onchange="capNhatSoLuongCoSo()">
                                        <span>{{ $cs->ten }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('co_so_ids')
                                <div class="badge red trial-field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    <div class="field span-2"><label>Ghi chú</label>
                        <textarea id="tr_note" name="ghi_chu" rows="3" placeholder="Ghi chú thêm..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('trialModal')">Huỷ</button>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>