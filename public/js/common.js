function money(n) { return n.toLocaleString('vi-VN') + ' đ'; }

function statusBadge(status) {
    const map = { 'Khách hàng': 'green', 'Tạm nghỉ': 'orange', 'Quay lại': 'blue' };
    return `<span class="badge ${map[status] || 'gray'}">${status}</span>`;
}

function trialBadge(status) {
    const map = { 'Đã đăng ký': 'green', 'Truy cứu': 'purple', 'Không đăng ký': 'red', 'Chưa trải nghiệm': 'gray' };
    return `<span class="badge ${map[status] || 'gray'}">${status}</span>`;
}

function showToast(msg, type = 'success') {
    const wrap = document.getElementById('toastWrap');
    const t = document.createElement('div');
    t.className = `toast ${type === 'error' ? 'toast-error' : ''}`;
    t.innerHTML = `<i class="${type === 'error' ? 'ri-error-warning-fill' : 'ri-checkbox-circle-fill'}"></i> ${msg}`;
    wrap.appendChild(t);
    setTimeout(() => {
        t.style.opacity = '0';
        t.style.transform = 'translateX(30px)';
        t.style.transition = '.3s';
        setTimeout(() => t.remove(), 2000);
    }, 2600);
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

function fillSelect(sel, list, includeEmpty, labelFn) {
    sel.innerHTML = (includeEmpty ? '<option value="">— Không —</option>' : '')
        + list.map(o => `<option value="${o.id}">${labelFn(o)}</option>`).join('');
}

function initAutoGrowTextareas() {
    document.querySelectorAll('textarea.auto-grow').forEach(el => {
        const resize = () => {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 110) + 'px';
        };
        el.addEventListener('input', resize);
        resize();
    });
}
document.addEventListener('DOMContentLoaded', initAutoGrowTextareas);

document.addEventListener('submit', function (e) {
    const form = e.target.closest('.confirm-delete-form');
    if (!form) return;

    e.preventDefault();
    confirmAction(
        form.dataset.confirmTitle || 'Xác nhận',
        form.dataset.confirmMessage || 'Bạn có chắc chắn muốn thực hiện thao tác này?',
        () => form.submit()
    );
});