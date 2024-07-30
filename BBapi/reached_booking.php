<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $stmt = $con->prepare("UPDATE booking SET bk_status = 4 WHERE bk_id = ? ");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $response = array(
                'result' => 1,
                'message' => 'ยืนยันสำเร็จ'
            );
        } else {
            $response = array(
                'result' => 0,
                'message' => 'ยืนยันไม่สำเร็จ'
            );
        }

        $stmt->close();
        $con->close();
    } else {
        $response = array(
            'result' => -1,
            'message' => 'ข้อมูลไม่ครบถ้วน'
        );
    }
} else {
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี POST'
    );
}

echo json_encode($response);
exit();
