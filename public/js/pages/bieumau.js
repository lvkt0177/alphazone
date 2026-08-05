function openBieuMauEditModal(id, ten, updateUrl) {
    const form = document.getElementById('bieuMauForm');
    document.getElementById('bm_editing_id').value = id || '';
    document.getElementById('bm_ten').value = ten || '';
    form.action = updateUrl;
    openModal('bieuMauModal');
}

function openBieuMauMauTrongModal(uploadUrl) {
    document.getElementById('bieuMauMauTrongForm').action = uploadUrl;
    openModal('bieuMauMauTrongModal');
}