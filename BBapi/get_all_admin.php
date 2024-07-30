<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // ใช้ prepared statement เพื่อป้องกัน SQL injection
    $stmt = $con->prepare("SELECT * FROM admin ORDER BY ad_id DESC");
    $stmt->execute();

    // ดึงข้อมูลลูกค้า
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $adminData = array();
        while ($row = $result->fetch_assoc()) {
            $adminData[] = array(
                'id' => $row['ad_id'],
                'name' => $row['ad_name'],
                'lastname' => $row['ad_lastname'],
                'email' => $row['ad_email'],
            );
        }
        $response = array(
            'result' => 1,
            'data' => $adminData
        );
    } else {
        $response = array(
            'result' => 0,
            'message' => 'ไม่พบข้อมูลผู้ดูแลระบบ'
        );
    }

    // ปิด prepared statement
    $stmt->close();
} else {
    // กรณีไม่ได้ใช้วิธี GET ในการเรียก API
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี GET'
    );
}

echo json_encode($response);

exit();
