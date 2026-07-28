document.addEventListener('DOMContentLoaded', function () {
    const data = window.__dashboardData;
    if (!data) return;

    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: data.trangThaiLabels,
                datasets: [{ data: data.trangThaiData, backgroundColor: ['#16A34A', '#D97706', '#2563EB'], borderWidth: 0 }]
            },
            options: {
                cutout: '70%',
                aspectRatio: 1.8,
                plugins: { legend: { display: false } },
            }
        });
    }
});