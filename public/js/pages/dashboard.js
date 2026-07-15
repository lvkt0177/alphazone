document.addEventListener('DOMContentLoaded', function () {
    const data = window.__dashboardData;
    if (!data) return;

    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: data.thangLabels,
                datasets: [
                    { label: 'Học phí', data: data.hocPhi, borderColor: '#6C5DD3', backgroundColor: 'rgba(108,93,211,.12)', fill: true, tension: .4, borderWidth: 3, pointRadius: 3 },
                    { label: 'Đồng phục', data: data.dongPhuc, borderColor: '#FFA45C', backgroundColor: 'rgba(255,164,92,.12)', fill: true, tension: .4, borderWidth: 3, pointRadius: 3 },
                ]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { ticks: { callback: v => (v / 1000000) + 'tr' }, grid: { color: '#F0F1F6' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: data.trangThaiLabels,
                datasets: [{ data: data.trangThaiData, backgroundColor: ['#16A34A', '#D97706', '#2563EB'], borderWidth: 0 }]
            },
            options: { cutout: '70%', plugins: { legend: { display: false } } }
        });
    }
});