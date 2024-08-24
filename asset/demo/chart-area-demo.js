// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// สร้างฟังก์ชันสำหรับสร้างวันที่ย้อนหลัง 14 วัน
function getLast14Days() {
    var result = [];
    for (var i=13; i>=0; i--) {
        var d = new Date();
        d.setDate(d.getDate() - i);
        result.push(d.toLocaleDateString('th-TH', {month: 'short', day: 'numeric'}));
    }
    return result;
}

// สร้างข้อมูลสมมติสำหรับรายได้รายวัน
function generateRandomData() {
    var result = [];
    for (var i=0; i<14; i++) {
        result.push(Math.floor(Math.random() * 5000) + 1000);
    }
    return result;
}

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: getLast14Days(),
    datasets: [{
      label: "รายได้ (บาท)",
      lineTension: 0.3,
      backgroundColor: "rgba(75, 192, 192, 0.2)",
      borderColor: "rgba(75, 192, 192, 1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(75, 192, 192, 1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(75, 192, 192, 1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: generateRandomData(),
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 6000,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: true
    },
    tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          var label = data.datasets[tooltipItem.datasetIndex].label || '';
          if (label) {
            label += ': ';
          }
          label += tooltipItem.yLabel.toFixed(0).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' บาท';
          return label;
        }
      }
    }
  }
});