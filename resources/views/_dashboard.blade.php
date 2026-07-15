      <section class="view active" id="view-dashboard">
          <div class="page-head">
              <div>
                  <div class="page-title">Bảng điều khiển</div>
                  <div class="text-2" style="margin-top:4px;">Tổng quan hoạt động trung tâm AlphaZone</div>
              </div>
              <select class="select" id="dashMonthSel"></select>
          </div>

          <div class="stat-grid" id="statGrid"></div>

          <div class="grid-2">
              <div class="card">
                  <div class="card-head">
                      <h3><i class="ri-line-chart-line"></i> Doanh thu Học phí &amp; Đồng phục</h3>
                      <select class="select">
                          <option>6 tháng gần nhất</option>
                      </select>
                  </div>
                  <div class="legend">
                      <span><i class="dot-legend" style="background:#6C5DD3"></i>Học phí</span>
                      <span><i class="dot-legend" style="background:#FFA45C"></i>Đồng phục</span>
                  </div>
                  <canvas id="revenueChart" height="230"></canvas>
              </div>
              <div class="card">
                  <div class="card-head">
                      <h3><i class="ri-pie-chart-2-line"></i> Trạng thái Học viên</h3>
                  </div>
                  <canvas id="statusChart" height="220"></canvas>
                  <div id="statusLegend" style="margin-top:16px;"></div>
              </div>
          </div>

          <div class="grid-2" style="grid-template-columns:1fr 1fr;">
              <div class="card">
                  <div class="card-head">
                      <h3><i class="ri-alarm-warning-line"></i> Học viên chưa đóng học phí tháng này</h3><a
                          class="btn btn-light btn-sm" data-view="tuition">Xem tất cả</a>
                  </div>
                  <div class="row-list" id="unpaidList"></div>
              </div>
              <div class="card">
                  <div class="card-head">
                      <h3><i class="ri-building-4-line"></i> Số lượng theo Cơ sở</h3>
                  </div>
                  <div class="row-list" id="branchCountList"></div>
              </div>
          </div>
      </section>
