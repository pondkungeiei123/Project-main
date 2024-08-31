document.addEventListener('DOMContentLoaded', function() {
    fetch('/Project-main/font_end/get_daily_revenue.php?period=yearly')
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                console.warn('No data available for the selected period.');
                return;
            }

            // กำหนดสีที่ต้องการ
            const colors = [
                '#7fc6c4', '#8de4a5', '#b89ad6', '#7d7d7d', '#f8c54e'
            ];

            data.forEach((item, index) => {
                item.color = colors[index % colors.length];
            });

            Highcharts.chart('pie-container', {
                chart: {
                    type: 'pie',
                },
                title: {
                    text: 'กราฟแสดงรายได้ต่อปี'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'รายได้',
                    colorByPoint: true,
                    data: data
                }]
            });
        })
        .catch(error => console.error('Error:', error));
});
