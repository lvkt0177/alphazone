@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/dashboard.css') }}">
    @endpush

    <div class="page-head">
        <div>
            <div class="page-title">Bảng điều khiển</div>
            <div class="text-2 dashboard-subtitle">Thống kê tổng quan tháng {{ $thangHienTai->format('n/Y') }}</div>
        </div>
    </div>

    <div class="stat-grid">
        <div class="card stat-card">
            <div class="top">
                <div class="stat-icon dashboard-icon--green"><i
                        class="ri-money-dollar-circle-line"></i></div>
            </div>
            <div class="label">Học phí thu được (Tháng {{ $thangHienTai->format('n/Y') }})</div>
            <div class="value">{{ number_format($tongHocPhi, 0, ',', '.') }} đ</div>
        </div>
        <div class="card stat-card">
            <div class="top">
                <div class="stat-icon dashboard-icon--blue"><i class="ri-t-shirt-line"></i>
                </div>
            </div>
            <div class="label">Đồng phục thu được (Tháng {{ $thangHienTai->format('n/Y') }})</div>
            <div class="value">{{ number_format($tongDongPhuc, 0, ',', '.') }} đ</div>
        </div>
        <div class="card stat-card">
            <div class="top">
                <div class="stat-icon dashboard-icon--purple"><i
                        class="ri-group-line"></i></div>
            </div>
            <div class="label">Tổng Học viên</div>
            <div class="value">{{ $thongKeTrangThai->sum('total') }}</div>
        </div>
        <div class="card stat-card">
            <div class="top">
                <div class="stat-icon dashboard-icon--red"><i
                        class="ri-alarm-warning-line"></i></div>
            </div>
            <div class="label">Chưa đóng học phí tháng này</div>
            <div class="value">{{ $soChuaDong }} học viên</div>
        </div>
        <div class="card stat-card">
            <div class="top">
                <div class="stat-icon dashboard-icon--orange"><i
                        class="ri-basketball-line"></i></div>
            </div>
            <div class="label">Tiền sân tháng {{ $thangHienTai->format('n/Y') }}</div>
            <div class="value">{{ number_format($tongTienSan, 0, ',', '.') }} đ</div>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-head">
                <h3><i class="ri-line-chart-line"></i> Doanh thu Học phí &amp; Đồng phục (6 tháng gần nhất)</h3>
            </div>
            <div class="legend">
                <span><i class="dot-legend dashboard-legend-dot--fee"></i>Học phí</span>
                <span><i class="dot-legend dashboard-legend-dot--uniform"></i>Đồng phục</span>
            </div>
            <canvas id="revenueChart" height="230"></canvas>
        </div>

        <div class="card">
            <div class="card-head">
                <h3><i class="ri-pie-chart-2-line"></i> Trạng thái Học viên</h3>
            </div>
            <canvas id="statusChart" height="220"></canvas>
            <div class="dashboard-status-legend-wrap">
                @foreach ($thongKeTrangThai as $tk)
                    <div class="legend dashboard-status-legend-row">
                        <span><span class="badge {{ $tk['badge'] }} dashboard-status-badge">{{ $tk['label'] }}</span>
                            {{ $tk['total'] }} học viên</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid-2 dashboard-grid-2col">
        <div class="card">
            <div class="card-head">
                <h3><i class="ri-alarm-warning-line"></i> Học viên chưa đóng học phí tháng này</h3>
                <a href="{{ route('hocphi.index', ['trang_thai_dong' => 'chua_dong']) }}" class="btn btn-light btn-sm">Xem
                    tất cả</a>
            </div>
            <div class="row-list">
                @forelse ($danhSachChuaDong as $hv)
                    <div class="item">
                        <img src="{{ $hv->avatar_url }}" alt="">
                        <div class="info">
                            <div class="t">{{ $hv->ho_ten }}</div>
                            <div class="s">{{ $hv->ma_so }} • {{ $hv->coSos->pluck('ten')->join(', ') ?: '—' }}
                            </div>
                        </div>
                        <span class="badge red">Chưa đóng</span>
                    </div>
                @empty
                    <div class="text-2">Tất cả học viên đã đóng học phí tháng này 🎉</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <h3><i class="ri-building-4-line"></i> Số lượng Học viên theo Cơ sở</h3>
                <span class="badge purple">{{ $coSos->sum('hoc_viens_count') }} HV</span>
            </div>
            <div class="row-list">
                @forelse ($coSos as $cs)
                    <div class="item">
                        <div class="stat-icon dashboard-icon-sm dashboard-icon--primary">
                            <i class="ri-building-4-line"></i>
                        </div>
                        <div class="info">
                            <div class="t">{{ $cs->ten }}</div>
                            <div class="s">Phụ trách: {{ $cs->giaoVien->ho_ten ?? 'N/A' }}</div>
                        </div>
                        <span class="amt">{{ $cs->hoc_viens_count }} HV</span>
                    </div>
                @empty
                    <div class="text-2">Chưa có Cơ sở nào</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid-2 dashboard-grid-2col">
        <div class="card">
            <div class="card-head">
                <h3><i class="ri-basketball-line"></i> Tiền sân theo Địa điểm (tháng này)</h3>
                <span class="badge orange">{{ number_format($tienSanTheoDiaDiem->sum('tong_tien_san'), 0, ',', '.') }}
                    đ</span>
            </div>
            <div class="row-list">
                @forelse ($tienSanTheoDiaDiem as $dd)
                    <div class="item dashboard-item-centered">
                        <div class="stat-icon dashboard-icon-sm dashboard-icon--orange">
                            <i class="ri-basketball-line"></i>
                        </div>
                        <div class="info">
                            <div class="t">{{ $dd->ten }}</div>
                            <div class="s">{{ $dd->coSos->count() }} cơ sở</div>
                        </div>
                        <span class="amt dashboard-amt-bold">{{ number_format($dd->tong_tien_san ?? 0, 0, ',', '.') }} đ</span>
                    </div>

                    @foreach ($dd->coSos as $cs)
                        <div class="item dashboard-item-indent">
                            <div class="info">
                                <div class="s dashboard-sub-name">{{ $cs->ten }}</div>
                            </div>
                            <span class="amt dashboard-sub-amt">{{ number_format($cs->tong_tien_san ?? 0, 0, ',', '.') }}
                                đ</span>
                        </div>
                    @endforeach
                @empty
                    <div class="text-2">Chưa có Địa điểm nào</div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.__dashboardData = {
                thangLabels: @json($bieuDoThang->pluck('label')),
                hocPhi: @json($bieuDoThang->pluck('hoc_phi')),
                dongPhuc: @json($bieuDoThang->pluck('dong_phuc')),
                trangThaiLabels: @json($thongKeTrangThai->pluck('label')),
                trangThaiData: @json($thongKeTrangThai->pluck('total')),
            };
        </script>
        <script src="{{ asset('js/pages/dashboard.js') }}"></script>
    @endpush
@endsection