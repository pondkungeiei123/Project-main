<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่าข้อมูลที่ส่งมาครบถ้วนหรือไม่
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['lastname']) &&  isset($_POST['email']) && isset($_POST['password'])) {

        $id = intval($_POST['id']);
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $check_email_query = $con->prepare("SELECT ad_email FROM admin WHERE ad_email = ? AND ad_id  != ? LIMIT 1");
        $check_email_query->bind_param('si', $email, $id);
        $check_email_query->execute();

        $email_result = $check_email_query->get_result();

        if ($email_result->num_rows > 0) {
            $response = array(
                'result' => 0,
                'message' => 'มีอีเมลนี้อยู่แล้ว'
            );
        } else {
            // ใช้ prepared statement เพื่อป้องกัน SQL injection
            if ($password === '') {
                $stmt = $con->prepare("UPDATE admin SET ad_name = ?, ad_lastname = ?, ad_email = ? WHERE ad_id  = ? ");
                $stmt->bind_param("sssi", $name, $lastname, $email, $id);
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $con->prepare("UPDATE admin SET ad_name = ?, ad_lastname = ?, ad_email = ?, ad_password = ? WHERE ad_id  = ? ");
                $stmt->bind_param("ssssi", $name, $lastname, $email, $hashed_password, $id);
            }
            
            if ($stmt->execute()) {
                // ส่งข้อมูลผลลัพธ์กลับให้กับแอปพลิเคชัน
                $response = array(
                    'result' => 1,
                    'message' => 'แก้ไขข้อมูลสำเร็จ'
                );
            } else {
                // กรณีมีข้อผิดพลาดในการเพิ่มข้อมูล
                $response = array(
                    'result' => 0,
                    'message' => 'แก้ไขข้อมูลไม่สำเร็จ'
                );
            }

            // ปิด prepared statement
            $stmt->close();

            // ปิดการเชื่อมต่อ MySQL
            $con->close();
        }

        echo json_encode($response);
        exit();
    } else {
        // กรณีข้อมูลไม่ครบถ้วน
        $response = array(
            'result' => -1,
            'message' => 'ข้อมูลไม่ครบถ้วน'
        );
        echo json_encode($response);
        exit();
    }
} else {
    // กรณีไม่ได้ใช้วิธี POST ในการส่งข้อมูล
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี POST'
    );
    echo json_encode($response);
    exit();
}
