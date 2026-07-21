<div class="breadcrumb">
    <a>Trang chủ</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Học phí</a>
</div>

<div class="page-head">
    <div class="page-title">Quản lý Đóng Học phí</div>
</div>

@if (session('success'))
    <div class="badge green" style="display:block;padding:10px 14px;margin-bottom:16px;">{{ session('success') }}</div>
@endif

<div class="table-card">
    <form method="GET" action="{{ route('hocphi.index') }}" class="table-toolbar">
        <div class="filters" style="align-items:flex-end;">
            <div class="field" style="margin:0;min-width:220px;">
                <label style="font-size:12.5px;margin-bottom:5px;">Tìm kiếm</label>
                <div class="search-mini">
                    <i class="ri-search-line"></i>
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Tìm theo Mã số, Họ tên, SĐT...">
                </div>
            </div>

            <div class="field" style="margin:0;min-width:200px;">
                <label style="font-size:12.5px;margin-bottom:5px;">Cơ sở</label>
                <select name="co_so_id" onchange="this.form.submit()">
                    <option value="">Tất cả Cơ sở</option>
                    @foreach ($coSos as $cs)
                        <option value="{{ $cs->id }}" {{ request('co_so_id') == $cs->id ? 'selected' : '' }}>
                            {{ $cs->ten }} - {{ $cs->giaoVien->ho_ten ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field" style="margin:0;min-width:170px;">
                <label style="font-size:12.5px;margin-bottom:5px;">Trạng thái đóng</label>
                <select name="trang_thai_dong" onchange="this.form.submit()">
                    <option value="">Tất cả trạng thái</option>
                    <option value="da_dong" {{ request('trang_thai_dong') == 'da_dong' ? 'selected' : '' }}>Đã đóng
                    </option>
                    <option value="chua_dong" {{ request('trang_thai_dong') == 'chua_dong' ? 'selected' : '' }}>Chưa
                        đóng</option>
                </select>
            </div>

            <div class="field" style="margin:0;min-width:150px;">
                <label style="font-size:12.5px;margin-bottom:5px;">Tháng</label>
                <select name="thang" onchange="this.form.submit()">
                    @foreach ($danhSachThang as $t)
                        <option value="{{ $t['value'] }}"
                            {{ $thang->format('Y-m') == $t['value'] ? 'selected' : '' }}>{{ $t['label'] }}</option>
                    @endforeach
                </select>
            </div>

            @if (request()->hasAny(['q', 'co_so_id', 'trang_thai_dong', 'thang']))
                <a href="{{ route('hocphi.index') }}" class="btn btn-outline btn-sm">Làm mới bộ lọc</a>
            @endif
        </div>

        <div class="text-2" style="font-size:13px;">{{ $hocViens->total() }} học viên — đang xem Tháng
            {{ $thang->format('n/Y') }}</div>

    </form>

    <div class="text-2" style="font-size:14px;margin:-8px 0 14px;">
        Tháng {{ $thang->format('n/Y') }}:
        <strong>{{ $countDaDong }}</strong> {{ \App\Enum\TrangThaiHocPhi::DA_DONG->getLabel() }}
        ·
        <strong>{{ $countChuaDong }}</strong> {{ \App\Enum\TrangThaiHocPhi::CHUA_DONG->getLabel() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Họ tên</th>
                <th>Cơ sở</th>
                <th>Học phí</th>
                <th class="trang-thai-hoc-phi">Trạng thái</th>
                <th>Ngày đóng</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hocViens as $hv)
                @php $rec = $hv->hocPhis->first(); @endphp
                <tr>
                    <td><a href="{{ route('hocvien.show', $hv) }}" class="code-link">{{ $hv->ma_so }}</a></td>
                    <td>
                        <div class="cell-user"><img src="{{ $hv->avatar_url }}" alt="">
                            <div class="name">{{ $hv->ho_ten }}</div>
                        </div>
                    </td>
                    <td>
                        @if ($hv->coSos->isNotEmpty())
                            @foreach ($hv->coSos as $coSo)
                                <div>{{ $coSo->ten }} - {{ $coSo->giaoVien->ho_ten ?? 'N/A' }}</div>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($rec)
                            {{ number_format($rec->hoc_phi, 0, ',', '.') }} đ
                        @else
                            —
                        @endif
                    <td>
                        @if ($rec)
                            <span class="badge green">Đã đóng</span>
                            @if ($rec->gioi_thieu_ban)
                                <span class="badge purple" style="margin-top:4px;">
                                    Giới thiệu
                                    bạn{{ $rec->nguoiGioiThieu ? ' bởi ' . $rec->nguoiGioiThieu->ho_ten : '' }}
                                </span>
                            @endif
                        @else
                            <span class="badge red">Chưa đóng</span>
                        @endif
                    </td>
                    <td>{{ $rec ? $rec->ngay_dong->format('d/m/Y') : '—' }}</td>
                    <td>
                        <button type="button"
                            class="btn btn-sm {{ $rec ? 'btn-warning' : 'btn-primary' }} open-tuition-btn"
                            data-hoc-vien-id="{{ $hv->id }}" data-ma-so="{{ $hv->ma_so }}"
                            data-ho-ten="{{ $hv->ho_ten }}" data-thang="{{ $thang->format('Y-m-d') }}"
                            data-hoc-phi="{{ $rec->hoc_phi ?? '' }}" data-dong-phuc="{{ $rec->dong_phuc ?? '' }}"
                            data-ngay-dong="{{ $rec?->ngay_dong?->format('Y-m-d') }}"
                            data-gioi-thieu-ban="{{ $rec->gioi_thieu_ban ?? 0 }}"
                            data-nguoi-gioi-thieu-id="{{ $rec->nguoi_gioi_thieu_id ?? '' }}">
                            <i class="ri-edit-line"></i> {{ $rec ? 'Sửa' : 'Tạo' }} học phí
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-2" style="text-align:center;padding:30px;">Không có học viên nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        @if (!$hocViens->onFirstPage())
            <a href="{{ $hocViens->previousPageUrl() }}">Trước</a>
        @else
            <span style="opacity:.5;padding:8px 14px;">Trước</span>
        @endif
        @for ($i = 1; $i <= $hocViens->lastPage(); $i++)
            <a href="{{ $hocViens->url($i) }}"
                class="{{ $i == $hocViens->currentPage() ? 'active' : '' }}">{{ $i }}</a>
        @endfor
        @if ($hocViens->hasMorePages())
            <a href="{{ $hocViens->nextPageUrl() }}">Sau</a>
        @else
            <span style="opacity:.5;padding:8px 14px;">Sau</span>
        @endif
    </div>
</div>

@push('modals')
    @include('partials.modals._tuition')
@endpush

@if ($errors->any() && old('hoc_vien_id'))
    @php $errHv = $hocViens->firstWhere('id', (int) old('hoc_vien_id')); @endphp
    @if ($errHv)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                openTuitionModal(
                    {{ $errHv->id }},
                    {{ Js::from($errHv->ma_so) }},
                    {{ Js::from($errHv->ho_ten) }},
                    {{ Js::from(old('thang')) }},
                    {{ old('hoc_phi') !== null ? (int) old('hoc_phi') : 'null' }},
                    {{ old('dong_phuc') !== null ? (int) old('dong_phuc') : 'null' }},
                    {{ Js::from(old('ngay_dong')) }},
                    {{ old('gioi_thieu_ban') ? 1 : 0 }},
                    {{ old('nguoi_gioi_thieu_id') ? (int) old('nguoi_gioi_thieu_id') : 'null' }}
                );
            });
        </script>
    @endif
@endif
