// ฟังก์ชันดึงข้อมูลจาก PHP และแปลงข้อมูล
function fetchMonthlyData() {
    return fetch('/Project-main/font_end/get_daily_revenue.php?period=monthly')
        .then(response => response.json())
        .then(data => {
            return {
                months: data.dates,
                revenueData: data.revenues
            };
        });
}

document.addEventListener('DOMContentLoaded', function () {
    fetchMonthlyData().then(data => {
        // กำหนดสีที่ต้องการ
        const colors = [
         '#7fc6c4', '#8de4a5', '#b89ad6', '#7d7d7d', '#f8c54e'
        ];

        Highcharts.chart('bar-container', {
            chart: {
                type: 'column', // ใช้ 'column' แทน 'bar'
            },
            title: {
                text: 'กราฟแสดงรายได้ต่อเดือน'
            },
            xAxis: {
                categories: data.months, // แสดงเดือนบนแกน X
                title: {
                    text: 'เดือน'
                },
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'รายได้ (บาท)'
                },
                min: 0,
                gridLineWidth: 1,
                tickAmount: 5
            },
            tooltip: {
                shared: true,
                headerFormat: '<span style="font-size:12px"><b>{point.x}</b></span><br>',
                pointFormat: '{series.name}: <b>{point.y}</b><br>'
            },
            series: [{
                name: 'รายได้',
                data: data.revenueData.map((revenue, index) => ({
                    y: parseFloat(revenue),
                    color: colors[index % colors.length] // ใช้สีจากอาร์เรย์
                })),
                colorByPoint: true // ใช้สีที่กำหนดไว้ในข้อมูล
            }],
            legend: {
                enabled: false
            }
        });
    }).catch(error => console.error('Error:', error));
});
