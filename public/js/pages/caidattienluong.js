function openTienLuongModal(id, hoTen, field, label, giaTriHienTai, updateUrl) {
    const form = document.getElementById('tienLuongForm');
    const valueHidden = document.getElementById('tl_value');
    const valueDisplay = document.getElementById('tl_value_display');

    document.getElementById('tlModalTitle').textContent = 'Sửa ' + label + ' — ' + hoTen;
    document.getElementById('tl_editing_id').value = id || '';
    document.getElementById('tl_ho_ten').value = hoTen || '';
    document.getElementById('tl_field').value = field || '';
    document.getElementById('tl_label').value = label || '';
    document.getElementById('tl_field_label').textContent = label || 'Giá trị';

    valueHidden.name = field;
    const raw = giaTriHienTai === null || giaTriHienTai === undefined ? '' : String(giaTriHienTai);
    valueHidden.value = raw;
    valueDisplay.value = typeof formatMoney === 'function' ? formatMoney(raw) : raw;

    form.action = updateUrl;

    openModal('tienLuongModal');
}

document.addEventListener('DOMContentLoaded', function () {
    if (typeof attachMoneyFormatter === 'function') {
        attachMoneyFormatter('tl_value_display', 'tl_value');
        attachMoneyFormatter('tl_tru_ngay_display', 'tl_tru_ngay');
    }
});