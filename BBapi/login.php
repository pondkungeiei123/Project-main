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
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['roll'])) {
        // ดึงข้อมูลจากการส่งเข้ามา
        $email = $_POST['email'];
        $password = $_POST['password'];
        $roll = $_POST['roll'];

        // ตรวจสอบว่าเป็นลูกค้าหรือไม่
        if ($roll == 'Customer') {
            $stmt = $con->prepare("SELECT * FROM customer WHERE cus_email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $table = "cus";
        } else if ($roll == 'Barber') {
            // ตรวจสอบว่าเป็นบาร์เบอร์หรือไม่
            $stmt = $con->prepare("SELECT * FROM barber WHERE ba_email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $table = "ba";
        } else if ($roll == 'Admin') {
            // ตรวจสอบว่าเป็นบาร์เบอร์หรือไม่
            $stmt = $con->prepare("SELECT * FROM admin WHERE ad_email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $table = "ad";
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row[$table.'_password'])) {
                $response = array(
                    'result' => 1,
                    'message' => 'เข้าสู่ระบบสำเร็จ'
                );
            } else {
                $response = array(
                    'result' => 0,
                    'message' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'
                );
            }
        } else {
            $response = array(
                'result' => 0,
                'message' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'
            );
        }

        // ปิด prepared statement
        $stmt->close();
    } else {
        // กรณีข้อมูลไม่ครบถ้วน
        $response = array(
            'result' => -1,
            'message' => 'ข้อมูลไม่ครบถ้วน'
        );
    }
} else {
    // กรณีไม่ได้ใช้วิธี POST ในการส่งข้อมูล
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี POST'
    );
}

echo json_encode($response);
exit();
