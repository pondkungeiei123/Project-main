<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
include "../config.php"; 

if ($conn->connect_error) {
    die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

$period = isset($_GET['period']) ? $_GET['period'] : 'daily'; // ค่าปริยายเป็น 'daily'

$current_year = date('Y'); // ปีปัจจุบัน (เช่น 2567)

$sql_daily = "
    SELECT DATE(pm_time) as date, SUM(pm_amount) as total_revenue
    FROM payment
    WHERE YEAR(pm_time) = $current_year AND pm_time >= CURDATE() - INTERVAL 7 DAY
    GROUP BY DATE(pm_time)
    ORDER BY DATE(pm_time)
";

$sql_weekly = "
    SELECT YEARWEEK(pm_time, 1) as week, SUM(pm_amount) as total_revenue
    FROM payment
    WHERE YEAR(pm_time) = $current_year AND pm_time >= CURDATE() - INTERVAL 1 MONTH
    GROUP BY YEARWEEK(pm_time, 1)
    ORDER BY YEARWEEK(pm_time, 1)
";

$sql_monthly = "
    SELECT DATE_FORMAT(pm_time, '%Y-%m') as month, SUM(pm_amount) as total_revenue
    FROM payment
    WHERE YEAR(pm_time) = $current_year AND pm_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) 
    GROUP BY DATE_FORMAT(pm_time, '%Y-%m')
    ORDER BY DATE_FORMAT(pm_time, '%Y-%m')
";

$sql_yearly = "
    SELECT YEAR(pm_time) as year, SUM(pm_amount) as total_revenue
    FROM payment
    GROUP BY YEAR(pm_time)
    ORDER BY YEAR(pm_time)
";

$sql = ($period === 'yearly') ? $sql_yearly : 
        ($period === 'monthly' ? $sql_monthly : 
        ($period === 'weekly' ? $sql_weekly : $sql_daily));
$result = $conn->query($sql);

$data = [];
$dates = [];
$revenues = [];

if ($period === 'yearly') {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'name' => $row['year'],
                'y' => (float)$row['total_revenue']
            ];
        }
    }
    echo json_encode($data);
} else {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dates[] = ($period === 'monthly') ? $row['month'] :
                      ($period === 'weekly' ? 'Week ' . $row['week'] : $row['date']);
            $revenues[] = $row['total_revenue'];
        }
    }

    $data = [];
    for ($i = 0; $i < count($dates); $i++) {
        $data[] = [
            'name' => $dates[$i],
            'y' => (float)$revenues[$i]
        ];
    }

    echo json_encode([
        'dates' => $dates,
        'revenues' => $revenues
    ]);
}

$conn->close();
?>
