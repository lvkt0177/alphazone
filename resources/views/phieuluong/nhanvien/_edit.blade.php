<div class="breadcrumb">
    <a href="{{ route('phieuluongnhanvien.index', ['thang' => $thang->format('Y-m')]) }}">Phiếu lương Nhân viên chính
        thức</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Sửa phiếu — {{ $phieu->ho_ten_snapshot }}</a>
</div>
<div class="page-head">
    <div class="page-title">Sửa phiếu lương — {{ $phieu->ho_ten_snapshot }} — Tháng {{ $thang->format('m/Y') }}</div>
</div>

<div class="table-card phieuluong-box-form phieuluong-box-form--single">
    <form method="POST" action="{{ route('phieuluongnhanvien.update', $phieu) }}" id="phieuLuongForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="thang" value="{{ $thang->format('Y-m') }}">

        <div class="form-grid full">
            <div class="field">
                <label>Tên</label>
                <input type="text" value="{{ $phieu->ho_ten_snapshot }}" readonly>
            </div>
            <div class="field">
                <label>Mã nhân viên</label>
                <input type="text" value="{{ $phieu->ma_nhan_vien_snapshot }}" readonly>
            </div>
            <div class="field">
                <label>Lương cơ bản (đã chốt lúc tạo phiếu)</label>
                <input type="text" id="pl_luong_co_ban"
                    value="{{ number_format($phieu->luong_co_ban, 0, ',', '.') }} đ" readonly>
            </div>
            <div class="field">
                <label>Ngày công (đã chốt lúc tạo phiếu)</label>
                <input type="text"
                    value="Có: {{ $phieu->so_ngay_co_luong }} ngày — Không: {{ $phieu->so_ngay_khong_luong }} ngày"
                    readonly>
            </div>
            <div class="field">
                <label>Ngày công chuẩn / tháng</label>
                <input type="number" name="ngay_cong_chuan" min="1" max="31"
                    value="{{ old('ngay_cong_chuan', $phieu->ngay_cong_chuan) }}">
                @error('ngay_cong_chuan')
                    <div class="badge red phieuluong-field-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="field">
                <label>Ngày tháng năm chốt phiếu</label>
                <input type="date" name="ngay_chot"
                    value="{{ old('ngay_chot', $phieu->ngay_chot?->toDateString()) }}">
                @error('ngay_chot')
                    <div class="badge red phieuluong-field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label>Trợ cấp xăng xe, điện thoại (tham khảo)</label>
                <input type="text" id="pl_tro_cap_display" inputmode="numeric" autocomplete="off"
                    value="{{ number_format($phieu->tro_cap ?? 0, 0, ',', '.') }}">
                <input type="hidden" name="tro_cap" id="pl_tro_cap" value="{{ $phieu->tro_cap }}">
            </div>
            <div class="field">
                <label>Năng suất công việc (tham khảo)</label>
                <input type="text" id="pl_nang_suat_display" inputmode="numeric" autocomplete="off"
                    value="{{ number_format($phieu->nang_suat ?? 0, 0, ',', '.') }}">
                <input type="hidden" name="nang_suat" id="pl_nang_suat" value="{{ $phieu->nang_suat }}">
            </div>
            <div class="field">
                <label>Thưởng khác (tham khảo)</label>
                <input type="text" id="pl_thuong_khac_display" inputmode="numeric" autocomplete="off"
                    value="{{ number_format($phieu->thuong_khac ?? 0, 0, ',', '.') }}">
                <input type="hidden" name="thuong_khac" id="pl_thuong_khac" value="{{ $phieu->thuong_khac }}">
            </div>

            <div class="field">
                <label>Tổng thu nhập <span class="phieuluong-required">*</span></label>
                <input type="text" id="pl_tong_thu_nhap_display" inputmode="numeric" autocomplete="off"
                    value="{{ number_format($phieu->tong_thu_nhap, 0, ',', '.') }}">
                <input type="hidden" name="tong_thu_nhap" id="pl_tong_thu_nhap" value="{{ $phieu->tong_thu_nhap }}">
                @error('tong_thu_nhap')
                    <div class="badge red phieuluong-field-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="field">
                <label>Tổng khấu trừ (Bảo hiểm...) <span class="phieuluong-required">*</span></label>
                <input type="text" id="pl_tong_khau_tru_display" inputmode="numeric" autocomplete="off"
                    value="{{ number_format($phieu->tong_khau_tru, 0, ',', '.') }}">
                <input type="hidden" name="tong_khau_tru" id="pl_tong_khau_tru" value="{{ $phieu->tong_khau_tru }}">
                @error('tong_khau_tru')
                    <div class="badge red phieuluong-field-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="field">
                <label>Công tác phí</label>
                <input type="text" id="pl_cong_tac_phi_display" inputmode="numeric" autocomplete="off"
                    value="{{ number_format($phieu->cong_tac_phi ?? 0, 0, ',', '.') }}">
                <input type="hidden" name="cong_tac_phi" id="pl_cong_tac_phi" value="{{ $phieu->cong_tac_phi }}">
            </div>
            <div class="field">
                <label>Tạm ứng</label>
                <input type="text" id="pl_tam_ung_display" inputmode="numeric" autocomplete="off"
                    value="{{ number_format($phieu->tam_ung ?? 0, 0, ',', '.') }}">
                <input type="hidden" name="tam_ung" id="pl_tam_ung" value="{{ $phieu->tam_ung }}">
            </div>
            <div class="field">
                <label>Giảm trừ gia cảnh</label>
                <input type="text" id="pl_giam_tru_display" inputmode="numeric" autocomplete="off"
                    value="{{ number_format($phieu->giam_tru_gia_canh ?? 0, 0, ',', '.') }}">
                <input type="hidden" name="giam_tru_gia_canh" id="pl_giam_tru"
                    value="{{ $phieu->giam_tru_gia_canh }}">
            </div>
        </div>

        <div class="phieuluong-ketqua-box">
            <div class="phieuluong-ketqua-row"><span>BHXH (8%)</span><b id="ktBhxh">0 đ</b></div>
            <div class="phieuluong-ketqua-row"><span>BHYT (1.5%)</span><b id="ktBhyt">0 đ</b></div>
            <div class="phieuluong-ketqua-row"><span>BHTN (1%)</span><b id="ktBhtn">0 đ</b></div>
            <div class="phieuluong-ketqua-row"><span>Thu nhập chịu thuế</span><b id="ktTncTthue">0 đ</b></div>
            <div class="phieuluong-ketqua-row"><span>TNTT</span><b id="ktTntt">0 đ</b></div>
            <div class="phieuluong-ketqua-row"><span>Thuế TNCN</span><b id="ktThueTncn">0 đ</b></div>
            <div class="phieuluong-ketqua-row phieuluong-ketqua-final"><span>Lương thực nhận</span><b
                    id="ktLuongThucNhan">0 đ</b></div>
        </div>

        <div class="phieuluong-form-actions">
            <a href="{{ route('phieuluongnhanvien.index', ['thang' => $thang->format('Y-m')]) }}"
                class="btn btn-outline">Huỷ</a>
            <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinhLai();
    });
</script>
