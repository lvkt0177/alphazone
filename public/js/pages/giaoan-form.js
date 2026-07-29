(function () {
    let coThayDoiChuaLuu = false;

    window.addEventListener('ga:sodo-changed', function () {
        coThayDoiChuaLuu = true;
    });

    const form = document.querySelector('form.form-card');
    if (form) {
        form.addEventListener('submit', function () {
            coThayDoiChuaLuu = false;
        });
    }
    
    window.addEventListener('beforeunload', function (e) {
        if (!coThayDoiChuaLuu) return;
        e.preventDefault();
        e.returnValue = '';
    });

    document.addEventListener('click', function (e) {
        if (!coThayDoiChuaLuu) return;

        const link = e.target.closest('a[href]');
        if (!link) return;
        if (link.target === '_blank') return;

        const href = link.getAttribute('href');
        if (!href || href.startsWith('#')) return;

        e.preventDefault();
        confirmAction(
            'Rời khỏi trang?',
            'Sơ đồ vừa chỉnh sửa chưa được lưu. Nếu rời trang bây giờ, các thay đổi sẽ bị mất.',
            function () {
                coThayDoiChuaLuu = false;
                window.location.href = href;
            }
        );
    });
})();