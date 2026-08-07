<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Hóa đơn đầu vào</a>
</div>
<div class="page-head">
    <div class="page-title">Hóa đơn đầu vào</div>
</div>

<div class="hoadon-box-grid">
    @foreach ($danhSachLoai as $loai)
        <a href="{{ route('hoadon.dauvao.index', ['loai' => $loai->value]) }}" class="hoadon-box hoadon-box--img">
            <img src="{{ asset($loai->getAnh()) }}" alt="{{ $loai->getLabel() }}" class="hoadon-box-img">
            <div class="hoadon-box-title">{{ $loai->getLabel() }}</div>
        </a>
    @endforeach
</div>
