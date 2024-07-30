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
        $barberId = $_POST['ba_id'];
        $current_date = date('Y-m-d');
        
        // เช็คว่าวันที่ที่ต้องการอัพเดทเป็นวันนี้หรือไม่
        $stmt_date = $con->prepare("SELECT Date(bk_startdate) FROM booking WHERE bk_id = ?");
        $stmt_date->bind_param("i", $id);
        $stmt_date->execute();
        $stmt_date->bind_result($bk_startdate);
        $stmt_date->fetch();
        $stmt_date->close();
        
        if ($bk_startdate !== $current_date) {
            $response = array(
                'result' => -3,
                'message' => 'วันที่จองไม่ตรงกับวันนี้'
            );
        } else {
            $stmt_status = $con->prepare("SELECT bk_status FROM booking b
            LEFT JOIN workschedule ws
            ON ws.ws_id = b.ws_id
            WHERE ws.ba_id = ? AND
            b.bk_status = 3");
            $stmt_status->bind_param("i", $barberId);
            $stmt_status->execute();
            $stmt_status->bind_result($bk_status);
            $stmt_status->fetch();
            $stmt_status->close();
            
            if ($bk_status == 3) {
                $response = array(
                    'result' => -4,
                    'message' => 'คุณมีการจองที่กำลังเดินทางอยู่แล้ว'
                );
            } else {
                $stmt_update = $con->prepare("UPDATE booking SET bk_status = 3 WHERE bk_id = ? ");
                $stmt_update->bind_param("i", $id);
                if ($stmt_update->execute()) {
                    $response = array(
                        'result' => 1,
                        'message' => 'อัพเดพสถานะสำเร็จ'
                    );
                } else {
                    $response = array(
                        'result' => 0,
                        'message' => 'อัพเดพสถานะไม่สำเร็จ'
                    );
                }

                $stmt_update->close();
            }
        }
        
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

