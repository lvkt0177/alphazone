@if ($buoc === 'caphoc')
    <div class="breadcrumb">
        <a>Trang chủ</a>
        <i class="ri-arrow-right-s-line"></i>
        <a class="active">Giáo án</a>
    </div>
    <div class="page-head">
        <div class="page-title">Giáo án — Chọn Cấp học</div>
    </div>

    <div class="giaoan-box-grid">
        @foreach (\App\Enum\CapHocGiaoAn::cases() as $ch)
            <a href="{{ route('giaoan.menu', ['cap_hoc' => $ch->value]) }}" class="giaoan-box">
                <i class="{{ $ch->getIcon() }} giaoan-box-icon"></i>
                <div class="giaoan-box-title">{{ $ch->getLabel() }}</div>
            </a>
        @endforeach
    </div>
@endif

@if ($buoc === 'loaigame')
    <div class="breadcrumb">
        <a href="{{ route('giaoan.menu') }}">Giáo án</a>
        <i class="ri-arrow-right-s-line"></i>
        <a class="active">{{ $capHoc->getLabel() }}</a>
    </div>
    <div class="page-head">
        <div class="page-title">{{ $capHoc->getLabel() }} — Chọn Loại game</div>
        <a href="{{ route('giaoan.menu') }}" class="btn btn-outline"><i class="ri-arrow-left-line"></i> Quay lại</a>
    </div>

    <div class="giaoan-box-grid">
        @foreach ($dsLoaiGame as $lg)
            <a href="{{ route('giaoan.menu', ['cap_hoc' => $capHoc->value, 'loai_game' => $lg->value]) }}"
                class="giaoan-box">
                <div class="giaoan-box-title">{{ $lg->getLabelCoSo() }}</div>
            </a>
        @endforeach
    </div>
@endif

@if ($buoc === 'chude')
    <div class="breadcrumb">
        <a href="{{ route('giaoan.menu') }}">Giáo án</a>
        <i class="ri-arrow-right-s-line"></i>
        <a href="{{ route('giaoan.menu', ['cap_hoc' => $capHoc->value]) }}">{{ $capHoc->getLabel() }}</a>
        <i class="ri-arrow-right-s-line"></i>
        <a class="active">{{ $loaiGame->getLabel() }}</a>
    </div>
    <div class="page-head">
        <div class="page-title">{{ $capHoc->getLabel() }} — {{ $loaiGame->getLabel() }} — Chọn Chủ đề</div>
        <a href="{{ route('giaoan.menu', ['cap_hoc' => $capHoc->value]) }}" class="btn btn-outline"><i
                class="ri-arrow-left-line"></i> Quay lại</a>
    </div>

    <div class="giaoan-box-grid">
        @foreach ($dsChuDe as $cd)
            <a href="{{ route('giaoan.menu', ['cap_hoc' => $capHoc->value, 'loai_game' => $loaiGame->value, 'chu_de' => $cd->value]) }}"
                class="giaoan-box giaoan-box--chude">
                <div class="giaoan-box-title">{{ $cd->getLabelCoSo() }}</div>
            </a>
        @endforeach
    </div>
@endif