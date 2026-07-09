document.addEventListener('DOMContentLoaded', function () {
    const toastElement = document.getElementById('session-toast');
    if (toastElement) {
        const successMessage = toastElement.getAttribute('data-success');
        if (successMessage) {
            showToast(successMessage);
        }
    }
});