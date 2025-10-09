<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Line Chart -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Monthly Revenue Trend</h2>
        <canvas id="revenueChart" height="200"></canvas>
    </div>

    <!-- Pie Chart -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Invoice Status Distribution</h2>
        <canvas id="invoiceChart" height="200"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Line chart (Revenue)
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Revenue ($)',
                    data: @json($chartValues),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Pie chart (Invoice status)
        const invoiceCtx = document.getElementById('invoiceChart').getContext('2d');
        new Chart(invoiceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Paid', 'Pending', 'Unpaid'],
                datasets: [{
                    data: [{{ $paidCount }}, {{ $pendingCount }}, {{ $overdueCount }}],
                    backgroundColor: ['#16a34a', '#facc15', '#dc2626'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    });
</script>
