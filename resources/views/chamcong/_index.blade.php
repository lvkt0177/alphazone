{{-- <div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Chấm công</a>
</div>

<div class="page-head">
    <div class="page-title">Chấm công</div>
</div> --}}

{{-- @if (session('success'))
    <div class="badge green chamcong-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red chamcong-alert-error">{{ session('error') }}</div>
@endif --}}

@php
    $tenThuVi = ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
@endphp

<div class="table-card">
    <div class="cc-thang-nav">
        <a href="{{ route('chamcong.index', ['thang' => $thang->copy()->subMonth()->format('Y-m')]) }}"
            class="btn btn-outline btn-sm">
            <i class="ri-arrow-left-s-line"></i>
        </a>
        <div class="cc-thang-label">Tháng {{ $thang->format('n/Y') }}</div>
        <a href="{{ route('chamcong.index', ['thang' => $thang->copy()->addMonth()->format('Y-m')]) }}"
            class="btn btn-outline btn-sm">
            <i class="ri-arrow-right-s-line"></i>
        </a>
    </div>

    <div class="cc-thu-header">
        <div>Thứ 2</div>
        <div>Thứ 3</div>
        <div>Thứ 4</div>
        <div>Thứ 5</div>
        <div>Thứ 6</div>
        <div>Thứ 7</div>
        <div>Chủ nhật</div>
    </div>

    <div class="cc-calendar-grid">
        @php $offset = $thang->copy()->startOfMonth()->dayOfWeekIso - 1; @endphp
        @for ($i = 0; $i < $offset; $i++)
            <div class="cc-day-empty"></div>
        @endfor

        @foreach ($ngayTrongThang as $item)
            @php
                $ngayIso = $item['ngay']->toDateString();
                $tenTat = $item['ban_ghi_thay']
                    ->map(fn($r) => ['ten' => $r->giaoVien->ho_ten, 'loai' => 'thay'])
                    ->concat($item['ban_ghi_ctv']->map(fn($r) => ['ten' => $r->giaoVien->ho_ten, 'loai' => 'ctv']));
                $tenHienThi = $tenTat->take(5);
                $soDu = $tenTat->count() - $tenHienThi->count();
            @endphp
            <div class="cc-day-card {{ $item['ngay']->isToday() ? 'cc-day-card--today' : '' }}">
                <div class="cc-day-head">
                    <div class="cc-day-so">{{ $item['ngay']->day }}</div>
                    @if (hasQuyen('chamcong', 'them') && !$item['la_tuong_lai'])
                        <button type="button" class="cc-day-add" title="Chấm công ngày này"
                            onclick="openChamCongThemModal({{ Js::from($ngayIso) }}, {{ Js::from($item['ngay']->format('d/m/Y')) }})">
                            <i class="ri-add-line"></i>
                        </button>
                    @endif
                </div>

                <div class="cc-day-names">
                    @forelse ($tenHienThi as $t)
                        <div class="cc-day-name-item cc-day-name-item--{{ $t['loai'] }}">
                            <span class="cc-dot"></span>{{ $t['ten'] }}
                        </div>
                    @empty
                        <div class="text-2 cc-day-trong">Chưa có ai chấm công</div>
                    @endforelse
                    @if ($soDu > 0)
                        <div class="text-2 cc-day-them">+{{ $soDu }}</div>
                    @endif
                </div>

                <button type="button" class="cc-day-xemchitiet"
                    onclick="openChamCongChiTietModal({{ Js::from($ngayIso) }}, {{ Js::from($tenThuVi[$item['ngay']->dayOfWeek] . ', ' . $item['ngay']->format('d/m/Y')) }})">
                    Xem chi tiết
                </button>
            </div>
        @endforeach
    </div>
</div>

<script>
    window.__ccDuLieuThang = {
        @foreach ($ngayTrongThang as $item)
            {{ Js::from($item['ngay']->toDateString()) }}: {
                thay: {!! $item['ban_ghi_thay']->map(
                        fn($r) => [
                            'ten' => $r->giaoVien->ho_ten,
                            'co_di_lam' => $r->co_di_lam,
                            'ghi_chu' => $r->ghi_chu,
                            'id' => $r->id,
                        ],
                    )->values()->toJson() !!},
                ctv: {!! $item['ban_ghi_ctv']->map(
                        fn($r) => [
                            'ten' => $r->giaoVien->ho_ten,
                            'so_gio' => $r->so_gio,
                            'don_gia_gio' => $r->giaoVien->don_gia_gio,
                            'thanh_tien' => (int) round(($r->so_gio ?? 0) * ($r->giaoVien->don_gia_gio ?? 0)),
                            'ho_tro_xang_xe' => $r->ho_tro_xang_xe,
                            'ghi_chu' => $r->ghi_chu,
                            'id' => $r->id,
                        ],
                    )->values()->toJson() !!},
            },
        @endforeach
    };
    window.__ccXoaUrlTemplate = {{ Js::from(route('chamcong.xoa', ['chamcong' => '__ID__'])) }};
    window.__ccCoQuyenXoa = {{ hasQuyen('chamcong', 'xoa') ? 'true' : 'false' }};
    window.__csrfToken = {{ Js::from(csrf_token()) }};
</script>