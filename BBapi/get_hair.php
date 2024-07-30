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
        $stmt = $con->prepare("SELECT * FROM hairstlye WHERE ba_id = ? ORDER BY hair_id DESC");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $hairData = array();
            while ($row = $result->fetch_assoc()) {
                $hairData[] = array(
                    'id' => $row['hair_id'],
                    'name' => $row['hair_name'],
                    'price' => $row['hair_price'],
                    'photo' => $row['hair_photo'],
                    'ba_id' => $row['ba_id'],
                );
            }

            $response = array(
                'result' => 1,
                'data' => $hairData
            );
        } else {
            $response = array(
                'result' => 0,
                'message' => 'ไม่พบข้อมูลทรงผม'
            );
        }

        // ปิด prepared statement
        $stmt->close();
    } else {
        // กรณีไม่ได้ใช้วิธี GET ในการเรียก API
        $response = array(
            'result' => -2,
            'message' => 'ข้อมูลไม่ครบ'
        );
    }
} else {
    // กรณีไม่ได้ใช้วิธี GET ในการเรียก API
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี GET'
    );
}

echo json_encode($response);

exit();
