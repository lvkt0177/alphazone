<div class="breadcrumb">
    <a href="{{ route('hocvien.index') }}">Danh sách Học viên</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Chi tiết Học viên</a>
</div>

<div class="page-head">
    <div class="page-title">Chi tiết Học viên</div>
    <div class="student-header-actions">
        <a href="{{ route('hocvien.index') }}" class="btn btn-outline"><i class="ri-arrow-left-line"></i> Quay lại</a>
        {{-- <button type="button" class="btn btn-primary" id="editStudentBtn"><i class="ri-edit-line"></i>
            Sửa học viên</button> --}}
    </div>
</div>

<div class="card student-detail-card">
    <div class="detail-head">
        <img class="detail-avatar" id="dtAvatar" src="{{ $hocvien->avatar_url }}" alt="{{ $hocvien->ho_ten }}">
        <div class="student-detail-name-wrap">
            <div class="detail-name" id="dtName">{{ $hocvien->ho_ten }}</div>
            <div class="detail-sub" id="dtCode">{{ $hocvien->ma_so }}</div>
            <div id="dtStatusBadge" class="student-status-badge-wrap">
                <span class="badge {{ $hocvien->trang_thai->getBadge() }}">{{ $hocvien->trang_thai->getLabel() }}</span>
            </div>
        </div>
    </div>
    <div class="info-grid">
        <div class="info-item">
            <div class="k">Ngày sinh</div>
            <div class="v" id="dtDob">{{ optional($hocvien->ngay_sinh)->format('d/m/Y') ?? '—' }}</div>
        </div>
        <div class="info-item">
            <div class="k">Giới tính</div>
            <div class="v" id="dtGender">{{ $hocvien->gioi_tinh->getLabel() }}</div>
        </div>
        <div class="info-item">
            <div class="k">Chiều cao / Cân nặng</div>
            <div class="v" id="dtGender">
                @if ($hocvien->chieu_cao || $hocvien->can_nang)
                    <span class="v">
                        @if ($hocvien->chieu_cao)
                            {{ number_format($hocvien->chieu_cao, 1) }} cm
                        @endif
                        @if ($hocvien->chieu_cao && $hocvien->can_nang)
                            /
                        @endif
                        @if ($hocvien->can_nang)
                            {{ number_format($hocvien->can_nang, 1) }} kg
                        @endif
                    </span>
                @endif
            </div>
        </div>
        <div class="info-item">
            <div class="k">Số điện thoại</div>
            <div class="v" id="dtPhone">{{ $hocvien->sdt ?? '—' }}</div>
        </div>
        <div class="info-item">
            <div class="k">Trường</div>
            <div class="v" id="dtSchool">{{ $hocvien->truong ?? '—' }}</div>
        </div>
        <div class="info-item">
            <div class="k">Địa chỉ</div>
            <div class="v" id="dtAddress">{{ $hocvien->dia_chi ?? '—' }}</div>
        </div>

        @php $coSoList = $hocvien->coSos; @endphp
        <div class="info-item">
            <div class="k">Cơ sở 1</div>
            <div class="v" id="dtBranch1">{{ optional($coSoList->get(0))->ten ?? '—' }}</div>
        </div>
        <div class="info-item">
            <div class="k">Cơ sở 2</div>
            <div class="v" id="dtBranch2">{{ optional($coSoList->get(1))->ten ?? '—' }}</div>
        </div>
        <div class="info-item">
            <div class="k">Cơ sở 3</div>
            <div class="v" id="dtBranch3">{{ optional($coSoList->get(2))->ten ?? '—' }}</div>
        </div>
    </div>
</div>

@if ($hocvien->ghi_chu)
    <div class="card student-detail-card">
        <div class="k student-note-label">Ghi chú</div>
        <div class="v student-note-value">{{ $hocvien->ghi_chu }}</div>
    </div>
@endif

<div class="table-card">
    <div class="tabs">
        <div class="tab-btn active" data-tab="tabDiemdanh">Bảng Điểm danh</div>
        <div class="tab-btn" data-tab="tabHocphi">Bảng Học phí</div>
    </div>

    <div class="tab-panel active" id="tabDiemdanh">
        <table>
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Điểm danh</th>
                    <th>Ghi chú</th>
                    <th>Cơ sở / Giáo viên</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($diemDanhs as $dd)
                    <tr>
                        <td>{{ $dd->ngay->format('d/m/Y') }}</td>
                        <td>
                            <span
                                class="badge {{ $dd->trang_thai->getBadge() }}">{{ $dd->trang_thai->getLabel() }}</span>
                            @if ($dd->hoc_bu)
                                <span class="badge orange student-hocbu-tag">Học bù tại
                                    {{ $dd->coSo->ten }}</span>
                            @endif
                        </td>
                        <td>{{ $dd->ghi_chu ?? '—' }}</td>
                        <td>{{ $dd->coSo->ten }} - {{ $dd->giaoVien->ho_ten ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-2 student-empty-row">
                            Chưa có dữ liệu điểm danh
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">
            @if (!$diemDanhs->onFirstPage())
                <a href="{{ $diemDanhs->previousPageUrl() }}">Trước</a>
            @else
                <span class="student-page-disabled">Trước</span>
            @endif
            @for ($i = 1; $i <= $diemDanhs->lastPage(); $i++)
                <a href="{{ $diemDanhs->url($i) }}"
                    class="{{ $i == $diemDanhs->currentPage() ? 'active' : '' }}">{{ $i }}</a>
            @endfor
            @if ($diemDanhs->hasMorePages())
                <a href="{{ $diemDanhs->nextPageUrl() }}">Sau</a>
            @else
                <span class="student-page-disabled">Sau</span>
            @endif
        </div>
    </div>

    <div class="tab-panel" id="tabHocphi">
        <table>
            <thead>
                <tr>
                    <th>Tháng</th>
                    <th>Học phí</th>
                    <th>Học phí dự kiến</th>
                    <th>Đồng phục</th>
                    <th>Ngày đóng</th>
                </tr>
            </thead>
            <tbody>
                @if ($hocPhis->onFirstPage())
                    @foreach ($duKienThangChuaToi as $dk)
                        <tr class="student-hocphi-dukien-row">
                            <td>Tháng {{ $dk['thang']->format('n/Y') }}
                                <span class="badge blue student-dukien-tag">Sắp tới</span>
                            </td>
                            <td class="text-2">-</td>
                            <td>
                                @if ($dk['so_tien'] !== null)
                                    {{ number_format($dk['so_tien'], 0, ',', '.') }} đ
                                    <span class="text-2">({{ $dk['so_buoi_da_hoc'] }}/{{ $dk['tong_so_buoi'] }}
                                        buổi)</span>
                                @else
                                    <span class="text-2">-</span>
                                @endif
                            </td>
                            <td class="text-2">-</td>
                            <td class="text-2">-</td>
                        </tr>
                    @endforeach
                @endif
                @forelse ($hocPhis as $thangRow)
                    @php
                        $thangKey = $thangRow->thang->format('Y-m-d');
                        $nhomHp = $hocPhiGroups->get($thangKey, collect());
                        $hpDauTien = $nhomHp->first();
                        $dk = $duKienTheoThang[$thangRow->thang->format('Y-m')] ?? null;
                    @endphp
                    <tr>
                        <td>Tháng {{ $thangRow->thang->format('n/Y') }}</td>
                        <td>
                            @foreach ($nhomHp as $hp)
                                <div>{{ $nhomHp->count() > 1 ? ' ' : '' }}{{ number_format($hp->hoc_phi, 0, ',', '.') }} đ</div>
                            @endforeach
                            @if ($hpDauTien && $hpDauTien->gioi_thieu_ban)
                                <span class="badge teal student-giothieu-tag">
                                    Giới thiệu{{ $hpDauTien->nguoiGioiThieu ? ' ' . $hpDauTien->nguoiGioiThieu->ma_so . ' - ' . $hpDauTien->nguoiGioiThieu->ho_ten : '' }}
                                </span>
                            @endif
                        </td>
                        <td class="text-2">
                            @if ($dk)
                                {{ number_format($dk['so_tien'], 0, ',', '.') }} đ
                                ({{ $dk['so_buoi_da_hoc'] }}/{{ $dk['tong_so_buoi'] }})
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @forelse ($nhomHp as $hp)
                                <div>
                                    {{ $nhomHp->count() > 1 ? '' : '' }}{{ isset($hp->dong_phuc) ? (\App\Enum\MucDongPhuc::tryFrom($hp->dong_phuc)?->getLabel() ?? '') : '-' }}
                                    @if ($hp->dong_phuc_size)
                                        (Size {{ $hp->dong_phuc_size }})
                                    @endif
                                </div>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>
                            @forelse ($nhomHp as $hp)
                                <div>{{ $nhomHp->count() > 1 ? '' : '' }}{{ $hp->ngay_dong->format('d/m/Y') }}</div>
                            @empty
                                -
                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-2 student-empty-row">Chưa có dữ liệu học
                            phí</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">
            @if (!$hocPhis->onFirstPage())
                <a href="{{ $hocPhis->previousPageUrl() }}">Trước</a>
            @else
                <span class="student-page-disabled">Trước</span>
            @endif
            @for ($i = 1; $i <= $hocPhis->lastPage(); $i++)
                <a href="{{ $hocPhis->url($i) }}"
                    class="{{ $i == $hocPhis->currentPage() ? 'active' : '' }}">{{ $i }}</a>
            @endfor
            @if ($hocPhis->hasMorePages())
                <a href="{{ $hocPhis->nextPageUrl() }}">Sau</a>
            @else
                <span class="student-page-disabled">Sau</span>
            @endif
        </div>
    </div>
</div>

<script>
    const editBtn = document.getElementById('editStudentBtn');
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            openStudentModal(@json($hocvien));
        });
    }

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));

            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });
</script>