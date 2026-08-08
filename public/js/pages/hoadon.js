function openHoaDonEditModal(id, ten, updateUrl) {
    const form = document.getElementById('hoaDonForm');
    document.getElementById('hd_editing_id').value = id || '';
    document.getElementById('hd_ten').value = ten || '';
    form.action = updateUrl;
    openModal('hoaDonModal');
}