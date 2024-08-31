document.addEventListener('DOMContentLoaded', function() {
  // กำหนด period เป็น 'yearly' เพื่อดึงข้อมูลรายปี
  return fetch('/Project-main/font_end/get_daily_revenue.php?period=yearly')
      .then(response => response.json())
      .then(data => {
          // หากไม่มีข้อมูลให้แสดงข้อความ
          if (data.length === 0) {
              console.warn('No data available for the selected period.');
              return;
          }
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
