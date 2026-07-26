function previewTienSanBill(input) {
    const box = document.getElementById('ts_bill_preview_box');
    const img = document.getElementById('ts_bill_preview');
    if (input.files && input.files[0]) {
        img.src = URL.createObjectURL(input.files[0]);
        box.style.display = 'flex';
    }
}

function openBillPreview(url) {
    document.getElementById('billPreviewImg').src = url;
    document.getElementById('billPreviewDownload').href = url;
    openModal('billPreviewModal');
}

function openTienSanModal(ts) {
    const form = document.getElementById('tienSanForm');
    const methodField = document.getElementById('tienSanMethodField');

    if (ts && ts.id) {
        document.getElementById('tienSanModalTitle').textContent = 'Sửa Tiền sân';
        form.action = `${form.dataset.updateUrlBase}/${ts.id}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('ts_editing_id').value = ts.id;
    } else {
        document.getElementById('tienSanModalTitle').textContent = 'Tạo Tiền sân';
        form.action = form.dataset.storeUrl;
        methodField.innerHTML = '';
        document.getElementById('ts_editing_id').value = '';
    }

    document.getElementById('ts_coso').value = ts?.co_so_id ?? document.getElementById('ts_coso').options[0]?.value ?? '';
    document.getElementById('ts_date').value = ts?.ngay ? ts.ngay.slice(0, 10) : new Date().toISOString().slice(0, 10);
    document.getElementById('ts_money').value = formatMoney(ts?.so_tien);
    document.getElementById('ts_money_raw').value = ts?.so_tien ?? '';
    document.getElementById('ts_note').value = ts?.ghi_chu ?? '';

    document.getElementById('ts_bill_input').value = '';
    const previewBox = document.getElementById('ts_bill_preview_box');
    const previewImg = document.getElementById('ts_bill_preview');
    if (ts?.bill_url) {
        previewImg.src = ts.bill_url;
        previewBox.style.display = 'flex';
    } else {
        previewImg.src = '';
        previewBox.style.display = 'none';
    }

    openModal('tienSanModal');
}

document.addEventListener('DOMContentLoaded', function () {
    attachMoneyFormatter('ts_money', 'ts_money_raw');
});