<div class="breadcrumb">
    <a href="{{ route('hocvien.index') }}">Danh sách Học viên</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Chi tiết Học viên</a>
</div>

<div class="page-head">
    <div class="page-title">Chi tiết Học viên</div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('hocvien.index') }}" class="btn btn-outline"><i class="ri-arrow-left-line"></i> Quay lại</a>
        {{-- <button type="button" class="btn btn-primary" id="editStudentBtn"><i class="ri-edit-line"></i>
            Sửa học viên</button> --}}
    </div>
</div>

<div class="card" style="margin-bottom:20px;">
    <div class="detail-head">
        <img class="detail-avatar" id="dtAvatar" src="{{ $hocvien->avatar_url }}" alt="{{ $hocvien->ho_ten }}">
        <div style="flex:1;min-width:220px;">
            <div class="detail-name" id="dtName">{{ $hocvien->ho_ten }}</div>
            <div class="detail-sub" id="dtCode">{{ $hocvien->ma_so }}</div>
            <div id="dtStatusBadge" style="margin-top:10px;">
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
                            <span class="badge {{ $dd->trang_thai->getBadge() }}">
                                {{ $dd->trang_thai->getLabel() }}
                            </span>
                        </td>
                        <td>{{ $dd->ghi_chu ?? '—' }}</td>
                        <td>{{ $dd->coSo->ten }} - {{ $dd->giaoVien->ho_ten ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-2" style="text-align:center;padding:24px;">
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
                <span style="opacity:.5;padding:8px 14px;">Trước</span>
            @endif
            @for ($i = 1; $i <= $diemDanhs->lastPage(); $i++)
                <a href="{{ $diemDanhs->url($i) }}"
                    class="{{ $i == $diemDanhs->currentPage() ? 'active' : '' }}">{{ $i }}</a>
            @endfor
            @if ($diemDanhs->hasMorePages())
                <a href="{{ $diemDanhs->nextPageUrl() }}">Sau</a>
            @else
                <span style="opacity:.5;padding:8px 14px;">Sau</span>
            @endif
        </div>
    </div>

    <div class="tab-panel" id="tabHocphi">
        <table>
            <thead>
                <tr>
                    <th>Tháng</th>
                    <th>Học phí</th>
                    <th>Đồng phục</th>
                    <th>Ngày đóng</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hocPhis as $hp)
                    <tr>
                        <td>Tháng {{ $hp->thang->format('n/Y') }}</td>
                        <td>
                            {{ number_format($hp->hoc_phi, 0, ',', '.') }} đ
                            @if ($hp->gioi_thieu_ban)
                                <span class="badge purple" style="margin-left:6px;">
                                    Giới thiệu
                                    bạn{{ $hp->nguoiGioiThieu ? ' bởi ' . $hp->nguoiGioiThieu->ma_so . ' - ' . $hp->nguoiGioiThieu->ho_ten : '' }}
                                </span>
                            @endif
                        </td>
                        <td>{{ $hp->dong_phuc ? number_format($hp->dong_phuc, 0, ',', '.') . ' đ' : '—' }}</td>
                        <td>{{ $hp->ngay_dong->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-2" style="text-align:center;padding:24px;">Chưa có dữ liệu học
                            phí</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">
            @if (!$hocPhis->onFirstPage())
                <a href="{{ $hocPhis->previousPageUrl() }}">Trước</a>
            @else
                <span style="opacity:.5;padding:8px 14px;">Trước</span>
            @endif
            @for ($i = 1; $i <= $hocPhis->lastPage(); $i++)
                <a href="{{ $hocPhis->url($i) }}"
                    class="{{ $i == $hocPhis->currentPage() ? 'active' : '' }}">{{ $i }}</a>
            @endfor
            @if ($hocPhis->hasMorePages())
                <a href="{{ $hocPhis->nextPageUrl() }}">Sau</a>
            @else
                <span style="opacity:.5;padding:8px 14px;">Sau</span>
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
