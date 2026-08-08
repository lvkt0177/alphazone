@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/dashboard.css') }}?v={{ @filemtime(public_path('css/pages/dashboard.css')) ?: time() }}">
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
            <div class="value">
                @if (hasQuyen('dashboard', 'xem'))
                    {{ number_format($tongHocPhi, 0, ',', '.') }} đ
                @else
                    ******
                @endif
            </div>
        </div>
        <div class="card stat-card">
            <div class="top">
                <div class="stat-icon dashboard-icon--blue"><i class="ri-t-shirt-line"></i>
                </div>
            </div>
            <div class="label">Đồng phục thu được (Tháng {{ $thangHienTai->format('n/Y') }})</div>
            <div class="value">
                @if (hasQuyen('dashboard', 'xem'))
                    {{ number_format($tongDongPhuc, 0, ',', '.') }} đ
                @else
                    ******
                @endif
            </div>
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
            <div class="value">{{ $soChuaDong }} &nbsp;học viên</div>
        </div>
        <div class="card stat-card">
            <div class="top">
                <div class="stat-icon dashboard-icon--orange"><i
                        class="ri-basketball-line"></i></div>
            </div>
            <div class="label">Tiền sân tháng {{ $thangHienTai->format('n/Y') }}</div>
            <div class="value">
                @if (hasQuyen('dashboard', 'xem'))
                    {{ number_format($tongTienSan, 0, ',', '.') }} đ
                @else
                    ******
                @endif
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="card card-hoc-vien-trai-nghiem" >
            <div class="card-head">
                <h3><i class="ri-calendar-check-line"></i> Học viên Trải nghiệm hôm nay ({{ now()->format('d/m/Y') }})</h3>
                <a href="{{ route('trainghiem.index') }}" class="btn btn-light btn-sm">Xem tất cả</a>
            </div>
            <div style="display:flex;flex-direction:column;">
                @forelse ($traiNghiemHomNay as $tn)
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:9px 0;border-bottom:1px solid var(--border);">
                        <div style="display:flex;align-items:baseline;gap:8px;min-width:0;overflow:hidden;">
                            <span style="font-weight:700;font-size:13.5px;white-space:nowrap;">{{ $tn->ho_ten }}</span>
                            <span style="color:var(--text-2);font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $tn->sdt ?? 'Chưa có Số điện thoại' }} · {{ $tn->coSos->pluck('ten')->join(', ') ?: '—' }}</span>
                        </div>
                        <span class="badge {{ $tn->trang_thai->getBadge() }}" style="font-size:11px;padding:3px 9px;flex-shrink:0;">{{ $tn->trang_thai->getLabel() }}</span>
                    </div>
                @empty
                    <div class="text-2">Không có</div>
                @endforelse
            </div>
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
                <span class="badge teal">{{ $coSos->sum('hoc_viens_count') }} HV</span>
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
                <span class="badge orange">
                    @if (hasQuyen('dashboard', 'xem'))
                        {{ number_format($tienSanTheoDiaDiem->sum('tong_tien_san'), 0, ',', '.') }} đ
                    @else
                        ******
                    @endif
                </span>
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
                        <span class="amt dashboard-amt-bold">
                            @if (hasQuyen('dashboard', 'xem'))
                                {{ number_format($dd->tong_tien_san ?? 0, 0, ',', '.') }} đ
                            @else
                                ******
                            @endif
                        </span>
                    </div>

                    @foreach ($dd->coSos as $cs)
                        <div class="item dashboard-item-indent">
                            <div class="info">
                                <div class="s dashboard-sub-name">{{ $cs->ten }}</div>
                            </div>
                            <span class="amt dashboard-sub-amt">
                                @if (hasQuyen('dashboard', 'xem'))
                                    {{ number_format($cs->tong_tien_san ?? 0, 0, ',', '.') }} đ
                                @else
                                    ******
                                @endif
                            </span>
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
                trangThaiLabels: @json($thongKeTrangThai->pluck('label')),
                trangThaiData: @json($thongKeTrangThai->pluck('total')),
            };
        </script>
        <script src="{{ asset('js/pages/dashboard.js') }}"></script>
    @endpush
@endsection