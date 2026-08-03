<div class="breadcrumb">
    <a href="{{ route('phieuluongctv.index') }}">Phiếu lương Cộng tác viên</a>
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
        <div class="phieuluong-box-title">Chọn cộng tác viên</div>
        <div class="phieuluong-danhsach-chon" id="dsChonGiaoVien">
            @forelse ($giaoViens as $gv)
                <div class="phieuluong-chon-item" data-id="{{ $gv->id }}"
                    onclick="chonGiaoVien({{ $gv->id }})">
                    {{ $gv->ho_ten }}
                </div>
            @empty
                <div class="text-2 phieuluong-empty-row">Tất cả CTV đã có phiếu lương tháng này</div>
            @endforelse
        </div>
    </div>

    <div class="table-card phieuluong-box-form">
        <div class="phieuluong-box-title">Thông tin phiếu lương</div>

        <form method="POST" action="{{ route('phieuluongctv.store') }}" id="phieuLuongForm">
            @csrf
            <input type="hidden" name="giao_vien_id" id="pl_giao_vien_id">
            <input type="hidden" name="thang" value="{{ $thang->format('Y-m') }}">

            <div class="phieuluong-chon-hint text-2" id="chuaChonHint">Bấm chọn 1 CTV ở bên trái để bắt đầu nhập
                phiếu lương</div>

            <div class="phieuluong-form-body" id="formBody" style="display:none;">
                <div class="form-grid full">
                    <div class="field">
                        <label>Tên</label>
                        <input type="text" id="pl_ten" readonly>
                    </div>
                    <div class="field">
                        <label>Mã nhân viên</label>
                        <input type="text" id="pl_ma_nv" readonly>
                    </div>
                    <div class="field">
                        <label>Tổng số giờ dạy (từ Chấm công)</label>
                        <input type="text" id="pl_tong_so_gio" readonly>
                    </div>
                    <div class="field">
                        <label>Đơn giá/giờ (Config)</label>
                        <input type="text" id="pl_don_gia" readonly>
                    </div>
                    <div class="field">
                        <label>Khấu trừ</label>
                        <input type="text" id="pl_khau_tru_display" inputmode="numeric" autocomplete="off"
                            placeholder="0">
                        <input type="hidden" name="khau_tru" id="pl_khau_tru">
                        @error('khau_tru')
                            <div class="badge red phieuluong-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="phieuluong-ketqua-box">
                    <div class="phieuluong-ketqua-row"><span>Thành tiền</span><b id="ktThanhTien">0 đ</b></div>
                    <div class="phieuluong-ketqua-row phieuluong-ketqua-final"><span>Thực nhận</span><b
                            id="ktThucNhan">0 đ</b></div>
                </div>

                <div class="phieuluong-form-actions">
                    <a href="{{ route('phieuluongctv.index', ['thang' => $thang->format('Y-m')]) }}"
                        class="btn btn-outline">Huỷ</a>
                    <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu phiếu lương</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    window.__plDuLieuGiaoVien = @json($duLieuGiaoVien);
</script>
