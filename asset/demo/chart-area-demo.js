// ฟังก์ชันดึงข้อมูลจาก PHP และแปลงข้อมูล
function fetchDailyData() {
    return fetch('/Project-main/font_end/get_daily_revenue.php?period=daily') // ใช้เส้นทาง PHP ที่ถูกต้อง
        .then(response => response.json())
        .then(data => {
            // แปลงวันที่เป็น timestamp และสร้างอาร์เรย์ [timestamp, รายได้]
            return data.dates.map((date, index) => [new Date(date).getTime(), Number(data.revenues[index])]);
        });
}

// สร้างกราฟเมื่อข้อมูลโหลดเสร็จ
document.addEventListener('DOMContentLoaded', function () {
    fetchDailyData().then(data => {
        Highcharts.chart('area-container', {
            chart: {
                type: 'areaspline'
            },
            title: {
                text: 'กราฟแสดงรายวัน'
            },
            xAxis: {
                type: 'datetime',
                title: {
                    text: 'วันที่'
                }
            },
            yAxis: {
                title: {
                    text: 'รายได้ (บาท)'
                },
                min: 0
            },
            series: [{
                name: 'รายได้',
                data: data,
                color: '#FF7F50' // เปลี่ยนสีของกราฟที่นี่
            }]
        });
    }).catch(error => console.error('Error:', error));
});
