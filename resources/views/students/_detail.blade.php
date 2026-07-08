      <section class="view" id="view-studentDetail">
        <div class="breadcrumb"><a data-view="students">Danh sách Học viên</a> <i class="ri-arrow-right-s-line"></i> <a class="active">Chi tiết Học viên</a></div>
        <div class="page-head">
          <div class="page-title">Chi tiết Học viên</div>
          <div style="display:flex;gap:10px;">
            <button class="btn btn-outline" data-view="students"><i class="ri-arrow-left-line"></i> Quay lại</button>
            <button class="btn btn-primary" id="editStudentBtn"><i class="ri-edit-line"></i> Sửa học viên</button>
          </div>
        </div>
        <div class="card" style="margin-bottom:20px;">
          <div class="detail-head">
            <img class="detail-avatar" id="dtAvatar" src="" alt="">
            <div style="flex:1;min-width:220px;">
              <div class="detail-name" id="dtName"></div>
              <div class="detail-sub" id="dtCode"></div>
              <div id="dtStatusBadge" style="margin-top:10px;"></div>
            </div>
          </div>
          <div class="info-grid">
            <div class="info-item"><div class="k">Ngày sinh</div><div class="v" id="dtDob"></div></div>
            <div class="info-item"><div class="k">Giới tính</div><div class="v" id="dtGender"></div></div>
            <div class="info-item"><div class="k">Số điện thoại</div><div class="v" id="dtPhone"></div></div>
            <div class="info-item"><div class="k">Trường</div><div class="v" id="dtSchool"></div></div>
            <div class="info-item"><div class="k">Địa chỉ</div><div class="v" id="dtAddress"></div></div>
            <div class="info-item"><div class="k">Cơ sở 1</div><div class="v" id="dtBranch1"></div></div>
            <div class="info-item"><div class="k">Cơ sở 2</div><div class="v" id="dtBranch2"></div></div>
            <div class="info-item"><div class="k">Cơ sở 3</div><div class="v" id="dtBranch3"></div></div>
          </div>
        </div>

        <div class="table-card">
          <div class="tabs">
            <div class="tab-btn active" data-tab="tabDiemdanh">Bảng Điểm danh</div>
            <div class="tab-btn" data-tab="tabHocphi">Bảng Học phí</div>
          </div>
          <div class="tab-panel active" id="tabDiemdanh">
            <table>
              <thead><tr><th>Ngày</th><th>Điểm danh</th><th>Ghi chú</th><th>Cơ sở / Giáo viên</th></tr></thead>
              <tbody id="dtAttendanceTbody"></tbody>
            </table>
          </div>
          <div class="tab-panel" id="tabHocphi">
            <table>
              <thead><tr><th>Tháng</th><th>Học phí</th><th>Đồng phục</th><th>Ngày đóng</th></tr></thead>
              <tbody id="dtTuitionTbody"></tbody>
            </table>
          </div>
        </div>
      </section>

