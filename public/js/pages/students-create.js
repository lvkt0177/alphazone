function locTraiNghiem() {
    const q = document.getElementById('traiNghiemSearch').value.trim().toLowerCase();
    document.querySelectorAll('.tn-item').forEach(el => {
        el.style.display = el.dataset.name.includes(q) ? 'flex' : 'none';
    });
}

function chonTraiNghiem(t) {
    document.getElementById('tu_trai_nghiem_id').value = t.id;
    document.getElementById('c_name').value = t.ho_ten;
    if (t.nam_sinh) document.getElementById('c_dob').value = `${t.nam_sinh}-01-01`;

    document.querySelectorAll('.create-branch-checkbox').forEach(cb => cb.checked = false);
    (t.co_sos || []).forEach(cs => {
        const cb = document.querySelector(`.create-branch-checkbox[value="${cs.id}"]`);
        if (cb) cb.checked = true;
    });

    document.getElementById('tuTraiNghiemName').textContent = t.ho_ten;
    document.getElementById('tuTraiNghiemBanner').style.display = 'block';
}

function boChonTraiNghiem() {
    document.getElementById('tu_trai_nghiem_id').value = '';
    document.getElementById('tuTraiNghiemBanner').style.display = 'none';
}

function previewCreateAvatar(input) {
    if (input.files && input.files[0]) {
        document.getElementById('createAvatarPreview').src = URL.createObjectURL(input.files[0]);
    }
}