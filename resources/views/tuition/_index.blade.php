      <section class="view" id="view-tuition">
        <div class="breadcrumb"><a>Trang chủ</a> <i class="ri-arrow-right-s-line"></i> <a class="active">Học phí</a></div>
        <div class="page-head"><div class="page-title">Quản lý Đóng Học phí</div></div>
        <div class="table-card">
          <div class="table-toolbar">
            <div class="filters">
              <div class="search-mini"><i class="ri-search-line"></i><input id="tuiSearch" type="text" placeholder="Tìm theo Mã số, Họ tên..." oninput="renderTuition(1)"></div>
              <select id="tuiStatusFilter" onchange="renderTuition(1)">
                <option value="">Tất cả trạng thái</option><option>Đã đóng</option><option>Chưa đóng</option>
              </select>
              <select id="tuiMonthFilter" onchange="renderTuition(1)"></select>
            </div>
          </div>
          <table>
            <thead><tr><th>Mã số</th><th>Họ tên</th><th>Cơ sở</th><th>Trạng thái</th><th>Ngày đóng</th><th></th></tr></thead>
            <tbody id="tuitionTbody"></tbody>
          </table>
          <div class="pagination" id="tuitionPager"></div>
        </div>
      </section>

