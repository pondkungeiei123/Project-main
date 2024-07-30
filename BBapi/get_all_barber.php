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
    $stmt = $con->prepare("SELECT * FROM barber ORDER BY ba_id DESC ");
    $stmt->execute();

    // ดึงข้อมูลลูกค้า
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $barberData = array();
        while ($row = $result->fetch_assoc()) {
            $barberData[] = array(
                'id' => $row['ba_id'],
                'name' => $row['ba_name'],
                'lastname' => $row['ba_lastname'],
                'phone' => $row['ba_phone'],
                'email' => $row['ba_email'],
                'idcard' => $row['ba_idcard'],
                'certificate' => $row['ba_certificate'],
                'namelocation' => $row['ba_namelocation'],
                'latitude' => $row['ba_latitude'],
                'longitude' => $row['ba_longitude'],
            );
        }
        $response = array(
            'result' => 1,
            'data' => $barberData
        );
    } else {
        $response = array(
            'result' => 0,
            'message' => 'ไม่พบข้อมูลช่างตัดผม'
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
