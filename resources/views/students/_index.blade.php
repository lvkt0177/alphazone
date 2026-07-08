      <section class="view" id="view-students">
        <div class="breadcrumb"><a>Trang chủ</a> <i class="ri-arrow-right-s-line"></i> <a class="active">Danh sách Học viên</a></div>
        <div class="page-head">
          <div class="page-title">Danh sách Học viên</div>
          <button class="btn btn-primary" onclick="openStudentModal()"><i class="ri-add-line"></i> Thêm Học viên</button>
        </div>
        <div class="table-card">
          <div class="table-toolbar">
            <div class="filters">
              <div class="search-mini"><i class="ri-search-line"></i><input id="stuSearch" type="text" placeholder="Tìm theo Mã số, Họ tên..." oninput="renderStudents(1)"></div>
              <select id="stuBranchFilter" onchange="renderStudents(1)"><option value="">Tất cả Cơ sở</option></select>
              <select id="stuStatusFilter" onchange="renderStudents(1)">
                <option value="">Tất cả trạng thái</option>
                <option>Khách hàng</option><option>Tạm nghỉ</option><option>Quay lại</option>
              </select>
            </div>
            <div class="text-2" id="stuCount" style="font-size:13px;"></div>
          </div>
          <div style="overflow-x:auto;">
          <table>
            <thead><tr><th>Mã số</th><th>Họ tên</th><th>Số điện thoại</th><th>Cơ sở 1</th><th>Cơ sở 2</th><th>Cơ sở 3</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody id="studentsTbody"></tbody>
          </table>
          </div>
          <div class="pagination" id="studentsPager"></div>
        </div>
      </section>

