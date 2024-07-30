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
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // ใช้ prepared statement เพื่อป้องกัน SQL injection
        $stmt = $con->prepare("SELECT * FROM location WHERE cus_id = ? ORDER BY lo_id DESC ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $locationData = array();
            while ($row = $result->fetch_assoc()) {
                $locationData[] = array(
                    'id' => $row['lo_id'],
                    'name' => $row['lo_name'],
                    'latitude' => $row['lo_latitude'],
                    'longitude' => $row['lo_longitude'],
                    'cus_id' => $row['cus_id'],
                );
            }
            $response = array(
                'result' => 1,
                'data' => $locationData
            );
        } else {
            $response = array(
                'result' => 0,
                'message' => 'ไม่พบข้อมูลที่อยู่'
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
}

echo json_encode($response);

exit();
