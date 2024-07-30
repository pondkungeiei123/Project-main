<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ba_id']) && isset($_POST['startdate']) && isset($_POST['enddate']) && isset($_POST['note']) && isset($_POST['status'])) {

        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        $note = $_POST['note'];
        $status = $_POST['status'];
        $ba_id = $_POST['ba_id'];

        $checkQuery = "SELECT * FROM workschedule WHERE ba_id = ? AND ((ws_startdate >= ? AND ws_startdate < ?) OR (ws_enddate > ? AND ws_enddate <= ?))";
        $checkStmt = $con->prepare($checkQuery);
        $checkStmt->bind_param("issss", $ba_id, $startdate, $enddate, $startdate, $enddate);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $response = array(
                'result' => -3,
                'message' => 'เวลาซ้อนทับกัน กรุณาเลือกเวลาอื่น'
            );
        } else {
          
            $stmt = $con->prepare("INSERT INTO  workschedule (ba_id, ws_startdate, ws_enddate, ws_note , ws_status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isssi", $ba_id, $startdate, $enddate, $note, $status);

            if ($stmt->execute()) {
                $response = array(
                    'result' => 1,
                    'message' => 'เพิ่มข้อมูลสำเร็จ'
                );
            } else {
                $response = array(
                    'result' => 0,
                    'message' => 'เพิ่มข้อมูลไม่สำเร็จ'
                );
            }

            $stmt->close();
        }

        $checkStmt->close();
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