function capNhatSoLuongCoSo() {
    const soDaChon = document.querySelectorAll('.create-branch-checkbox:checked').length;
    document.getElementById('branchCount').textContent = soDaChon + ' đã chọn';
}

function chonTatCaCoSo(chon) {
    document.querySelectorAll('#c_branches .branch-chip:not(.hidden) .create-branch-checkbox')
        .forEach(cb => cb.checked = chon);
    capNhatSoLuongCoSo();
}

document.getElementById('branchSearch')?.addEventListener('input', function () {
    const q = this.value.trim().toLowerCase();
    document.querySelectorAll('#c_branches .branch-chip').forEach(chip => {
        chip.classList.toggle('hidden', q !== '' && !chip.dataset.name.includes(q));
    });
});

capNhatSoLuongCoSo();