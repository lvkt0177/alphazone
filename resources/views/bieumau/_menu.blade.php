<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Biểu mẫu</a>
</div>
<div class="page-head">
    <div class="page-title">Biểu mẫu</div>
</div>

<div class="bieumau-box-grid">
    @foreach ($danhSachLoai as $loai)
        <a href="{{ route('bieumau.index', ['loai' => $loai->value]) }}" class="bieumau-box">
            <div class="bieumau-box-icon"><i class="{{ $loai->getIcon() }}"></i></div>
            <div class="bieumau-box-title">{{ $loai->getLabel() }}</div>
        </a>
    @endforeach
</div>