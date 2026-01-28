document.addEventListener('DOMContentLoaded', function() {
    const chartTypeSelect = document.getElementById('chartType');
    const downloadButton = document.getElementById('downloadChart');
    let chart = null;

    // Fetch summary data and generate chart
    fetchSummaryData();

    chartTypeSelect.addEventListener('change', function() {
        fetchSummaryData();
    });

    downloadButton.addEventListener('click', function() {
        if (chart) {
            const link = document.createElement('a');
            link.href = chart.toBase64Image();
            link.download = 'chart.png';
            link.click();
        }
    });

    function fetchSummaryData() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_summary.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                try {
                    const summary = JSON.parse(xhr.responseText);
                    if (summary.status === 'success') {
                        const income = parseFloat(summary.income).toFixed(2);
                        const expense = parseFloat(summary.expense).toFixed(2);
                        const remaining = parseFloat(summary.remaining).toFixed(2);
                        generateChart(income, expense, remaining);
                    } else {
                        console.error('Error fetching summary.');
                    }
                } catch (e) {
                    console.error('Error parsing summary data.');
                }
            }
        };
        xhr.send();
    }

    function generateChart(income, expense, remaining) {
        const ctx = document.getElementById('summaryChart').getContext('2d');

        if (chart) {
            chart.destroy();
        }

        chart = new Chart(ctx, {
            type: chartTypeSelect.value,
            data: {
                labels: ['Income', 'Expenses', 'Remaining'],
                datasets: [{
                    label: 'Amount (₹)',
                    data: [income, expense, remaining],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(153, 102, 255, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
