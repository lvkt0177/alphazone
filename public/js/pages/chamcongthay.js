function chonCoKhong(id, value) {
    const hidden = document.getElementById('cdl_' + id);
    const tr = hidden.closest('tr');
    const btnCo = tr.querySelector('.chamcong-pill--co');
    const btnKhong = tr.querySelector('.chamcong-pill--khong');

    if (hidden.value === value) {
        hidden.value = '';
        btnCo.classList.remove('active');
        btnKhong.classList.remove('active');
    } else {
        hidden.value = value;
        btnCo.classList.toggle('active', value === '1');
        btnKhong.classList.toggle('active', value === '0');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    if (typeof attachMoneyFormatter !== 'function') return;

    document.querySelectorAll('[id^="htx_display_"]').forEach(function (el) {
        const hiddenId = el.id.replace('htx_display_', 'htx_');
        attachMoneyFormatter(el.id, hiddenId);
    });
});