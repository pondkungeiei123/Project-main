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
    // ตรวจสอบว่าข้อมูลที่ส่งมาครบถ้วนหรือไม่
    if (isset($_GET['id']) && isset($_GET['photo']) ) {
        $id = $_GET['id'];
        $photo = $_GET['photo'];

        $stmt = $con->prepare("DELETE FROM workings WHERE wo_id = ? ");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $oldPhoto = $photo;
            @unlink("uploads/$oldPhoto");

            $response = array(
                'result' => 1,
                'message' => 'ลบรูปภาพสำเร็จ'
            );
        } else {
            $response = array(
                'result' => 0,
                'message' => 'ลบรูปภาพไม่สำเร็จ'
            );
        }

        // ปิด prepared statement
        $stmt->close();

        // ปิดการเชื่อมต่อ MySQL
        $con->close();
    } else {
        // กรณีข้อมูลไม่ครบถ้วน
        $response = array(
            'result' => -1,
            'message' => 'ข้อมูลไม่ครบถ้วน'
        );
    }
} else {
    // กรณีไม่ได้ใช้วิธี GET ในการส่งข้อมูล
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี GET'
    );
}
echo json_encode($response);
exit();
