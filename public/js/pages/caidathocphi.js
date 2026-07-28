function openCaiDatHocPhiModal(id, soLuongCoSo, hocPhi, tongSoBuoi) {
    const form = document.getElementById('caiDatHocPhiForm');
    const methodField = document.getElementById('caiDatHocPhiMethodField');

    document.getElementById('cdhp_editing_id').value = id || '';

    if (id) {
        document.getElementById('caiDatHocPhiModalTitle').textContent = 'Sửa cấu hình';
        form.action = `${form.dataset.updateUrlBase}/${id}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
    } else {
        document.getElementById('caiDatHocPhiModalTitle').textContent = 'Thêm cấu hình';
        form.action = form.dataset.storeUrl;
        methodField.innerHTML = '';
    }

    document.getElementById('cdhp_so_luong').value = soLuongCoSo ?? '';
    document.getElementById('cdhp_hoc_phi').value = hocPhi ?? '';
    document.getElementById('cdhp_tong_buoi').value = tongSoBuoi ?? '';

    openModal('caiDatHocPhiModal');
}