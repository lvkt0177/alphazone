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
                            <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field"><label>Năm sinh</label><input id="tr_year" name="nam_sinh" type="number"
                            placeholder="VD: 2017"></div>
                    <div class="field">
                        <label>Trạng thái</label>
                        <select id="tr_status" name="trang_thai">
                            @foreach (\App\Enum\TrangThaiLoaiDangKyTraiNghiem::cases() as $st)
                                <option value="{{ $st->value }}">{{ $st->getLabel() }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if (empty($coSos))
                        <div class="badge red" style="margin-top:6px;">Không có cơ sở nào để chọn. Vui lòng thêm cơ sở
                            trước.</div>
                    @else
                        <div class="field span-2">
                            <div
                                style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                                <label style="margin:0;">Cơ sở (chọn ít nhất 1 cơ sở)</label>
                                <span id="branchCount" class="badge purple" style="font-size:12px;">0 đã chọn</span>
                            </div>

                            <div style="display:flex;gap:8px;margin-bottom:10px;">
                                <div style="position:relative;flex:1;">
                                    <i class="ri-search-line"
                                        style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--text-2);font-size:15px;"></i>
                                    <input type="text" id="branchSearch" placeholder="Tìm cơ sở..."
                                        style="width:100%;padding:8px 12px 8px 32px;border:1px solid var(--border);border-radius:9px;background:var(--bg);">
                                </div>
                                <button type="button" class="btn btn-light btn-sm" onclick="chonTatCaCoSo(true)">Chọn
                                    tất
                                    cả</button>
                                <button type="button" class="btn btn-light btn-sm" onclick="chonTatCaCoSo(false)">Bỏ
                                    chọn</button>
                            </div>

                            <div id="c_branches"
                                style="display:flex;flex-wrap:wrap;gap:8px;padding:12px 14px;border:1px solid var(--border);border-radius:10px;background:var(--bg);">
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
                                <div class="badge red" style="margin-top:6px;">{{ $message }}</div>
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

@push('scripts')
    <script src="{{ asset('js/modals/branches-modal.js') }}"></script>
@endpush