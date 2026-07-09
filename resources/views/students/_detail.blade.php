<div class="breadcrumb"><a data-view="students">Danh sách Học viên</a> <i class="ri-arrow-right-s-line"></i> <a
        class="active">Chi tiết Học viên</a></div>
<div class="page-head">
    <div class="page-title">Chi tiết Học viên</div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('hocvien.index') }}" class="btn btn-outline"><i class="ri-arrow-left-line"></i> Quay lại</a>
        <button class="btn btn-primary" id="editStudentBtn" data-id="{{ $hocvien->id }}"><i class="ri-edit-line"></i>
            Sửa học viên</button>
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
            <div class="v" id="dtDob">{{ optional($hocvien->ngay_sinh)->format('d/m/Y') }}</div>
        </div>
        <div class="info-item">
            <div class="k">Giới tính</div>
            <div class="v" id="dtGender">
                {{ $hocvien->gioi_tinh->getLabel() ?? '' }}
            </div>
        </div>
        <div class="info-item">
            <div class="k">Số điện thoại</div>
            <div class="v" id="dtPhone">{{ $hocvien->sdt }}</div>
        </div>
        <div class="info-item">
            <div class="k">Trường</div>
            <div class="v" id="dtSchool">{{ $hocvien->truong }}</div>
        </div>
        <div class="info-item">
            <div class="k">Địa chỉ</div>
            <div class="v" id="dtAddress">{{ $hocvien->dia_chi }}</div>
        </div>
        {{--
            GIẢ ĐỊNH: model CoSo có field "ten" để hiển thị tên cơ sở.
            Nếu field thật tên khác (vd: ten_co_so), hãy sửa $coSo->ten bên dưới.
            $hocvien->coSos là quan hệ belongsToMany, tối đa hiển thị 3 cơ sở đầu.
        --}}
        @php $coSoList = $hocvien->coSos; @endphp
        <div class="info-item">
            <div class="k">Cơ sở 1</div>
            <div class="v" id="dtBranch1">{{ optional($coSoList->get(0))->ten }}</div>
        </div>
        <div class="info-item">
            <div class="k">Cơ sở 2</div>
            <div class="v" id="dtBranch2">{{ optional($coSoList->get(1))->ten }}</div>
        </div>
        <div class="info-item">
            <div class="k">Cơ sở 3</div>
            <div class="v" id="dtBranch3">{{ optional($coSoList->get(2))->ten }}</div>
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
            {{-- Điểm danh: làm sau, để trống tbody --}}
            <tbody id="dtAttendanceTbody"></tbody>
        </table>
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
            {{-- Học phí: làm sau, để trống tbody --}}
            <tbody id="dtTuitionTbody"></tbody>
        </table>
    </div>
</div>
