/* ============================================================
   HÀM DÙNG CHUNG CHO TOÀN BỘ TRANG ADMIN
   Load ở layouts/admin.blade.php — KHÔNG phụ thuộc dữ liệu module nào.
============================================================ */
function money(n) { return n.toLocaleString('vi-VN') + ' đ'; }

function statusBadge(status) {
    const map = { 'Khách hàng': 'green', 'Tạm nghỉ': 'orange', 'Quay lại': 'blue' };
    return `<span class="badge ${map[status] || 'gray'}">${status}</span>`;
}

function trialBadge(status) {
    const map = { 'Đã đăng ký': 'green', 'Truy cứu': 'purple', 'Không đăng ký': 'red', 'Chưa trải nghiệm': 'gray' };
    return `<span class="badge ${map[status] || 'gray'}">${status}</span>`;
}

function showToast(msg) {
    const wrap = document.getElementById('toastWrap');
    const t = document.createElement('div');
    t.className = 'toast';
    t.innerHTML = `<i class="ri-checkbox-circle-fill"></i> ${msg}`;
    wrap.appendChild(t);
    setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateX(30px)'; t.style.transition = '.3s'; setTimeout(() => t.remove(), 300); }, 2600);
}

function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }

function confirmAction(title, msg, onOk) {
    document.getElementById('confirmTitle').textContent = title;
    document.getElementById('confirmMsg').textContent = msg;
    const btn = document.getElementById('confirmOkBtn');
    const newBtn = btn.cloneNode(true); btn.parentNode.replaceChild(newBtn, btn);
    newBtn.addEventListener('click', () => { closeModal('confirmModal'); onOk(); });
    openModal('confirmModal');
}

/**
 * Đổ dữ liệu vào 1 <select>. labelFn nhận 1 item, trả về chuỗi hiển thị —
 * để common.js không cần biết cấu trúc dữ liệu riêng của từng module.
 */
function fillSelect(sel, list, includeEmpty, labelFn) {
    sel.innerHTML = (includeEmpty ? '<option value="">— Không —</option>' : '')
        + list.map(o => `<option value="${o.id}">${labelFn(o)}</option>`).join('');
}