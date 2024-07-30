<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $con->prepare("DELETE FROM location WHERE lo_id = ? ");
        $stmt->bind_param("i", $id);

        
        if ($stmt->execute()) {
            $response = array(
                'result' => 1,
                'message' => 'ลบข้อมูลสำเร็จ'
            );
        } else {
            $response = array(
                'result' => 0,
                'message' => 'ลบข้อมูลไม่สำเร็จ'
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
        'message' => 'ไม่ใช้วิธี GET'
    );
}
echo json_encode($response);
exit();
