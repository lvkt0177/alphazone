<div class="breadcrumb">
    <a href="{{ route('phieuluongnhanvien.index') }}">Phiếu lương Nhân viên chính thức</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Tạo phiếu</a>
</div>
<div class="page-head">
    <div class="page-title">Tạo phiếu lương — Tháng {{ $thang->format('m/Y') }}</div>
</div>

@if ($errors->any())
    <div class="badge red phieuluong-alert-error">Vui lòng kiểm tra lại thông tin đã nhập.</div>
@endif

<div class="phieuluong-2box">
    <div class="table-card phieuluong-box-chon">
        <div class="phieuluong-box-title">Chọn giáo viên (Thầy phụ trách)</div>
        <div class="phieuluong-danhsach-chon" id="dsChonGiaoVien">
            @forelse ($giaoViens as $gv)
                <div class="phieuluong-chon-item" data-id="{{ $gv->id }}"
                    onclick="chonGiaoVien({{ $gv->id }})">
                    {{ $gv->ho_ten }}
                </div>
            @empty
                <div class="text-2 phieuluong-empty-row">Tất cả Thầy phụ trách đã có phiếu lương tháng này</div>
            @endforelse
        </div>
    </div>

    <div class="table-card phieuluong-box-form">
        <div class="phieuluong-box-title">Thông tin phiếu lương</div>

        <form method="POST" action="{{ route('phieuluongnhanvien.store') }}" id="phieuLuongForm">
            @csrf
            <input type="hidden" name="giao_vien_id" id="pl_giao_vien_id">
            <input type="hidden" name="thang" value="{{ $thang->format('Y-m') }}">

            <div class="phieuluong-chon-hint text-2" id="chuaChonHint">Bấm chọn 1 giáo viên ở bên trái để bắt đầu
                nhập phiếu lương</div>

            <div class="phieuluong-form-body" id="formBody" style="display:none;">
                <div class="form-row-3">
                    <div class="field">
                        <label>Tên</label>
                        <input type="text" id="pl_ten" readonly>
                    </div>
                    <div class="field">
                        <label>Mã nhân viên</label>
                        <input type="text" id="pl_ma_nv" readonly>
                    </div>
                    <div class="field">
                        <label>Lương cơ bản</label>
                        <input type="text" id="pl_luong_co_ban" readonly>
                    </div>
                </div>

                <div class="form-row-3 mt-3">
                    <div class="field">
                        <label>Ngày công (Có / Không — từ Chấm công)</label>
                        <input type="text" id="pl_ngay_cong" readonly>
                    </div>
                    <div class="field">
                        <label>Ngày công chuẩn / tháng</label>
                        <input type="number" name="ngay_cong_chuan" id="pl_ngay_cong_chuan" min="1"
                            max="31">
                        @error('ngay_cong_chuan')
                            <div class="badge red phieuluong-field-error">{{ $message }}</div>
                        @enderror
                        <div class="text-2 phieuluong-goi-y" id="plGoiYTruNgay"></div>
                    </div>
                    <div class="field">
                        <label>Ngày tháng năm chốt phiếu</label>
                        <input type="date" name="ngay_chot" value="{{ old('ngay_chot', now()->toDateString()) }}">
                        @error('ngay_chot')
                            <div class="badge red phieuluong-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row-3 mt-3">
                    <div class="field">
                        <label>Trợ cấp xăng xe, điện thoại (tự động cộng dồn từ Chấm công)</label>
                        <input type="text" id="pl_tro_cap_display" inputmode="numeric" autocomplete="off"
                            placeholder="0">
                        <input type="hidden" name="tro_cap" id="pl_tro_cap">
                    </div>
                    <div class="field">
                        <label>Năng suất công việc</label>
                        <input type="text" id="pl_nang_suat_display" inputmode="numeric" autocomplete="off"
                            placeholder="0">
                        <input type="hidden" name="nang_suat" id="pl_nang_suat">
                    </div>
                    <div class="field">
                        <label>Thưởng khác</label>
                        <input type="text" id="pl_thuong_khac_display" inputmode="numeric" autocomplete="off"
                            placeholder="0">
                        <input type="hidden" name="thuong_khac" id="pl_thuong_khac">
                    </div>
                </div>

                <div class="form-row-3 mt-3">
                    <div class="field">
                        <label>Công tác phí</label>
                        <input type="text" id="pl_cong_tac_phi_display" inputmode="numeric" autocomplete="off"
                            placeholder="0">
                        <input type="hidden" name="cong_tac_phi" id="pl_cong_tac_phi">
                    </div>
                    <div class="field">
                        <label>Tạm ứng</label>
                        <input type="text" id="pl_tam_ung_display" inputmode="numeric" autocomplete="off"
                            placeholder="0">
                        <input type="hidden" name="tam_ung" id="pl_tam_ung">
                    </div>
                    <div class="field">
                        <label>Giảm trừ gia cảnh</label>
                        <input type="text" id="pl_giam_tru_display" inputmode="numeric" autocomplete="off"
                            placeholder="0">
                        <input type="hidden" name="giam_tru_gia_canh" id="pl_giam_tru">
                    </div>
                </div>

                <div class="form-grid full mt-3">
                    <div class="field">
                        <label>Thuế TNCN (tự nhập)</label>
                        <input type="text" id="pl_thue_tncn_display" inputmode="numeric" autocomplete="off"
                            placeholder="0">
                        <input type="hidden" name="thue_tncn" id="pl_thue_tncn">
                        @error('thue_tncn')
                            <div class="badge red phieuluong-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="phieuluong-ketqua-box mt-3">
                    <div class="phieuluong-ketqua-label">Tổng thu nhập = Lương cơ bản + Trợ cấp + Năng suất + Thưởng
                        khác</div>
                    <div class="phieuluong-ketqua-row"><span>Lương cơ bản</span><b id="ktLuongCoBanRef">0 đ</b></div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-cong">
                        <span>+ Trợ cấp xăng xe</span><b id="ktTroCap">0 đ</b>
                    </div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-cong">
                        <span>+ Năng suất công việc</span><b id="ktNangSuat">0 đ</b>
                    </div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-cong">
                        <span>+ Thưởng khác</span><b id="ktThuongKhac">0 đ</b>
                    </div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-final">
                        <span>= Tổng thu nhập</span><b id="ktTongThuNhap">0 đ</b>
                    </div>
                </div>

                <div class="phieuluong-ketqua-box phieuluong-ketqua-box--thamkhao">
                    <div class="phieuluong-ketqua-label">Các khoản khấu trừ Bảo hiểm</div>
                    <div class="phieuluong-ketqua-row"><span>BHXH (8%)</span><b id="ktBhxh">0 đ</b></div>
                    <div class="phieuluong-ketqua-row"><span>BHYT (1.5%)</span><b id="ktBhyt">0 đ</b></div>
                    <div class="phieuluong-ketqua-row"><span>BHTN (1%)</span><b id="ktBhtn">0 đ</b></div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-final">
                        <span>= Tổng khấu trừ</span><b id="ktTongKhauTru">0 đ</b>
                    </div>
                </div>

                <div class="phieuluong-ketqua-box">
                    <div class="phieuluong-ketqua-label">Thu nhập chịu thuế = Tổng thu nhập − Tổng khấu trừ − Tạm
                        ứng + Công tác phí</div>
                    <div class="phieuluong-ketqua-row"><span>Tổng thu nhập</span><b id="ktTongThuNhap2">0 đ</b></div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-tru">
                        <span>− Tổng khấu trừ (Bảo hiểm)</span><b id="ktTongKhauTruRef">0 đ</b>
                    </div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-tru">
                        <span>− Tạm ứng</span><b id="ktTamUngRef">0 đ</b>
                    </div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-cong">
                        <span>+ Công tác phí</span><b id="ktCongTacPhiRef">0 đ</b>
                    </div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-final">
                        <span>= Thu nhập chịu thuế</span><b id="ktTncTthue">0 đ</b>
                    </div>
                </div>

                <div class="phieuluong-ketqua-box">
                    <div class="phieuluong-ketqua-label">Lương thực nhận = Thu nhập chịu thuế − Thuế TNCN</div>
                    <div class="phieuluong-ketqua-row"><span>Thu nhập chịu thuế</span><b id="ktTncTthue2">0 đ</b>
                    </div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-tru">
                        <span>− Thuế TNCN</span><b id="ktThueTncn">0 đ</b>
                    </div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-final">
                        <span>= Lương thực nhận</span><b id="ktLuongThucNhan">0 đ</b>
                    </div>
                </div>

                <div class="phieuluong-form-actions">
                    <a href="{{ route('phieuluongnhanvien.index', ['thang' => $thang->format('Y-m')]) }}"
                        class="btn btn-outline">Huỷ</a>
                    <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu phiếu
                        lương</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    window.__plDuLieuGiaoVien = @json($duLieuGiaoVien);
    window.__plNgayCongToiThieu = {{ $caiDat->ngay_cong_toi_thieu }};
    window.__plTienTru1Ngay = {{ $caiDat->tien_tru_1_ngay }};
</script>