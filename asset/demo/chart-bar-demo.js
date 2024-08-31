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
                data: data.revenueData.map(revenue => parseFloat(revenue)), // แปลงข้อมูลเป็นตัวเลข
                color: 'rgba(2,117,216,1)'
            }],
            legend: {
                enabled: false
            }
        });
    }).catch(error => console.error('Error:', error));
  });
  