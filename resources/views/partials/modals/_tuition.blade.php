<div class="overlay" id="tuitionModal">
    <div class="modal modal-hoc-phi">
        <div class="modal-head">
            <h3 id="tuitionModalTitle">Tạo Học phí</h3><i class="ri-close-line" onclick="closeModal('tuitionModal')"></i>
        </div>

        <form id="tuitionForm" method="POST" action="{{ route('hocphi.store') }}">
            @csrf
            <input type="hidden" name="hoc_vien_id" id="tu_hoc_vien_id">
            <input type="hidden" name="thang" id="tu_thang">
            <input type="hidden" name="nguoi_gioi_thieu_id" id="tu_referrer_id">
            <input type="hidden" name="dot[0][id]" id="tu_dot_id_0">

            <div class="modal-body">
                @if ($errors->any())
                    <div class="badge red tuition-modal-error-summary">
                        @foreach ($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="form-grid">
                    <div class="field"><label>Mã số</label><input id="tu_code" type="text" readonly></div>
                    <div class="field"><label>Họ tên</label><input id="tu_name" type="text" readonly></div>

                    <div class="field span-2">
                        <label class="tuition-toggle-label">
                            <span class="switch">
                                <input type="checkbox" id="tu_gioi_thieu_ban" name="gioi_thieu_ban" value="1">
                                <span class="switch-track"></span>
                            </span>
                            Giới thiệu bạn (áp dụng chung cho tất cả đợt thanh toán của tháng này)
                        </label>
                    </div>

                    <div class="field span-2 tuition-referrer-wrap" id="tu_referrer_wrap">
                        <label>Học viên giới thiệu</label>
                        <div class="tuition-referrer-search-wrap">
                            <input type="text" id="tu_referrer_search" autocomplete="off"
                                placeholder="Tìm theo Mã số hoặc Họ tên...">
                            <div id="tu_referrer_list" class="tuition-referrer-list"></div>
                        </div>
                    </div>
                </div>

                <div id="tu_dot_list">
                    <div class="tuition-dot-box" data-dot-index="0">
                        <div class="tuition-dot-head">
                            <span class="tuition-dot-title">Đợt 1</span>
                        </div>
                        <div class="form-grid">
                            <div class="field">
                                <label>Học phí (đ)</label>
                                <input id="tu_fee" type="text" inputmode="numeric" autocomplete="off"
                                    class="dot-fee-input" data-hidden-id="tu_fee_raw" placeholder="VD: 500,000">
                                <input type="hidden" name="dot[0][hoc_phi]" id="tu_fee_raw">
                                <div id="tu_du_kien_hint" class="text-2 tuition-du-kien-hint"></div>
                            </div>

                            <div class="field">
                                <div class="tuition-uniform-row">
                                    <div class="tuition-uniform-col tuition-uniform-col--muc">
                                        <label>Đồng phục</label>
                                        <select id="tu_uniform" name="dot[0][dong_phuc]">
                                            <option value="">— Không chọn —</option>
                                            @foreach (\App\Enum\MucDongPhuc::cases() as $muc)
                                                <option value="{{ $muc->value }}">{{ $muc->getLabel() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="tuition-uniform-col tuition-uniform-col--size">
                                        <label>Size quần áo</label>
                                        <select id="tu_uniform_size" name="dot[0][dong_phuc_size]">
                                            <option value="">N/A</option>
                                            @foreach (\App\Enum\SizeDongPhuc::cases() as $size)
                                                <option value="{{ $size->value }}">{{ $size->getLabel() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="field span-2">
                                <label>Ngày đóng</label>
                                <input id="tu_date" name="dot[0][ngay_dong]" type="date">
                            </div>
                        </div>
                    </div>
                    {{-- Các box "Đợt 2", "Đợt 3"... được JS chèn thêm vào đây --}}
                </div>

                <div class="tuition-add-dot-wrap">
                    <button type="button" class="btn btn-outline btn-sm" onclick="themDotThanhToan()">
                        <i class="ri-add-line"></i> Thêm đợt thanh toán
                    </button>
                </div>
            </div>
            <div class="modal-foot tuition-modal-foot">
                <div id="tu_delete_wrap" class="tuition-delete-wrap">
                    @if (hasQuyen('hocphi', 'xoa'))
                        <button type="button" class="btn btn-outline tuition-delete-btn" id="tu_delete_btn">
                            <i class="ri-delete-bin-line"></i> Xoá tất cả đợt
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

        @if (hasQuyen('hocphi', 'xoa'))
            <form id="tuitionDeleteDotForm" method="POST" class="tuition-hidden-form">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>
</div>

<script>
    window.__mucDongPhucOptions = @json(collect(\App\Enum\MucDongPhuc::cases())->map(fn ($m) => ['value' => $m->value, 'label' => $m->getLabel()]));
    window.__sizeDongPhucOptions = @json(collect(\App\Enum\SizeDongPhuc::cases())->map(fn ($s) => ['value' => $s->value, 'label' => $s->getLabel()]));
    window.__hocPhiDestroyDotUrlBase = @json(url('hoc-phi/dot'));
    window.__coQuyenXoaHocPhi = @json(hasQuyen('hocphi', 'xoa'));
</script>