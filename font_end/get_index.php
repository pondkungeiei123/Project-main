<?php
header('Content-Type: application/json; charset=UTF-8');

include "../config.php";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $dateStart = $_GET["dateStartFull"] ?? $_GET["dateStart"] . " 00:00:00";
    $dateEnd = $_GET["dateEndFull"] ?? $_GET["dateEnd"] . " 23:59:59";

    // Debugging: Output date range
    error_log("Date Start: $dateStart");
    error_log("Date End: $dateEnd");

    // Fetch usage data for area chart
    $usageQuery = "SELECT DATE_FORMAT(bk_startdate, '%Y-%m') AS month, COUNT(*) AS usage_count
                    FROM booking
                    WHERE bk_startdate >= ? AND bk_startdate <= ?
                    GROUP BY month";
    $stmt = $conn->prepare($usageQuery);
    $stmt->bind_param("ss", $dateStart, $dateEnd);
    $stmt->execute();
    $result = $stmt->get_result();
    $usageData = [];
    while ($row = $result->fetch_assoc()) {
        $usageData['labels'][] = $row['month'];
        $usageData['data'][] = (int)$row['usage_count'];
    }

    // Fetch annual revenue data for bar chart
    $revenueQuery = "SELECT YEAR(pm_time) AS year, SUM(pm_amount) AS annual_revenue
                    FROM payment
                    WHERE pm_time >= ? AND pm_time <= ?
                    GROUP BY year";
    $stmt = $conn->prepare($revenueQuery);
    $stmt->bind_param("ss", $dateStart, $dateEnd);
    $stmt->execute();
    $result = $stmt->get_result();
    $revenueData = [];
    while ($row = $result->fetch_assoc()) {
        $revenueData['labels'][] = $row['year'];
        $revenueData['data'][] = (float)$row['annual_revenue'];
    }

    // Fetch revenue distribution data for pie chart
    $distributionQuery = "SELECT h.hair_name AS service_type, SUM(p.pm_amount) AS total_revenue
                          FROM payment p
                          JOIN booking b ON p.bk_id = b.bk_id
                          JOIN hairstlye h ON b.hair_id = h.hair_id
                          WHERE p.pm_time >= ? AND p.pm_time <= ?
                          GROUP BY h.hair_name";
    $stmt = $conn->prepare($distributionQuery);
    $stmt->bind_param("ss", $dateStart, $dateEnd);
    $stmt->execute();
    $result = $stmt->get_result();
    $distributionData = [];
    while ($row = $result->fetch_assoc()) {
        $distributionData['labels'][] = $row['service_type'];
        $distributionData['data'][] = (float)$row['total_revenue'];
    }

    $response = array(
        'usage' => $usageData,
        'annualRevenue' => $revenueData,
        'revenueDistribution' => $distributionData
    );
} else {
    $response = array("success" => false, "message" => "Invalid request method");
}

$conn->close();
echo json_encode($response);