      <section class="view" id="view-attendance">
        <div class="breadcrumb"><a>Trang chủ</a> <i class="ri-arrow-right-s-line"></i> <a class="active">Điểm danh</a></div>
        <div class="page-head"><div class="page-title">Điểm danh Học viên</div></div>
        <div class="table-card">
          <div class="attendance-toolbar">
            <div class="filters">
              <select id="attBranch" onchange="renderAttendance()"></select>
              <input type="date" id="attDate" class="filters-date">
            </div>
            <button class="btn btn-primary" onclick="saveAttendance()"><i class="ri-save-line"></i> Lưu điểm danh</button>
          </div>
          <table>
            <thead><tr><th>Mã số</th><th>Họ tên</th><th style="width:130px;">Đi học</th><th style="width:130px;">Vắng</th><th>Ghi chú</th></tr></thead>
            <tbody id="attendanceTbody"></tbody>
          </table>
        </div>
      </section>

