<div class="breadcrumb">
    <a href="{{ route('phieuluongctv.index', ['thang' => $thang->format('Y-m')]) }}">Phiếu lương Cộng tác viên</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Sửa phiếu — {{ $phieu->ho_ten_snapshot }}</a>
</div>
<div class="page-head">
    <div class="page-title">Sửa phiếu lương — {{ $phieu->ho_ten_snapshot }} — Tháng {{ $thang->format('m/Y') }}</div>
</div>

<div class="table-card phieuluong-box-form phieuluong-box-form--single">
    <form method="POST" action="{{ route('phieuluongctv.update', $phieu) }}" id="phieuLuongForm">
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
                <label>Tổng số giờ dạy (đã chốt lúc tạo phiếu)</label>
                <input type="text" value="{{ rtrim(rtrim(number_format($phieu->tong_so_gio, 1), '0'), '.') }} giờ"
                    readonly>
            </div>
            <div class="field">
                <label>Đơn giá/giờ (đã chốt lúc tạo phiếu)</label>
                <input type="text" value="{{ number_format($phieu->don_gia, 0, ',', '.') }} đ/giờ" readonly>
            </div>
            <div class="field">
                <label>Khấu trừ</label>
                <input type="text" id="pl_khau_tru_display" inputmode="numeric" autocomplete="off"
                    value="{{ number_format($phieu->khau_tru ?? 0, 0, ',', '.') }}">
                <input type="hidden" name="khau_tru" id="pl_khau_tru" value="{{ $phieu->khau_tru }}">
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
            <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        ctvDonGiaHienTai = {{ $phieu->don_gia }};
        ctvSoGioHienTai = {{ $phieu->tong_so_gio }};
        ctvTinhLai();
    });
</script>