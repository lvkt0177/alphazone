function openTienLuongModal(id, hoTen, field, label, giaTriHienTai, updateUrl) {
    const form = document.getElementById('tienLuongForm');
    const valueInput = document.getElementById('tl_value');

    document.getElementById('tlModalTitle').textContent = 'Sửa ' + label + ' — ' + hoTen;
    document.getElementById('tl_editing_id').value = id || '';
    document.getElementById('tl_ho_ten').value = hoTen || '';
    document.getElementById('tl_field').value = field || '';
    document.getElementById('tl_label').value = label || '';
    document.getElementById('tl_field_label').textContent = label || 'Giá trị';

    valueInput.name = field; 
    valueInput.value = giaTriHienTai === null || giaTriHienTai === undefined ? '' : giaTriHienTai;

    form.action = updateUrl;

    openModal('tienLuongModal');
}