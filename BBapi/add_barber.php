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
    if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['phone']) && isset($_POST['idcard'])  && isset($_POST['namelocation']) && isset($_POST['latitude']) && isset($_POST['longitude'])) {
        // ดึงข้อมูลจากการส่งเข้ามา
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $idcard = $_POST['idcard'];
        $certificate = $_POST['certificate'];
        $namelocation = $_POST['namelocation'];
        $latitude = doubleval($_POST['latitude']);
        $longitude = doubleval($_POST['longitude']);

        $check_email_query = $con->prepare("SELECT ba_email FROM barber WHERE ba_email = ? LIMIT 1");
        $check_email_query->bind_param('s', $email);
        $check_email_query->execute();

        // $check_phone_query = $con->prepare("SELECT ba_phone FROM barber WHERE ba_phone = ? LIMIT 1");
        // $check_phone_query->bind_param('s', $phone);
        // $check_phone_query->execute();

        // $check_idcard_query = $con->prepare("SELECT ba_idcard FROM barber WHERE ba_idcard = ? LIMIT 1");
        // $check_idcard_query->bind_param('s', $idcard);
        // $check_idcard_query->execute();

        $email_result = $check_email_query->get_result();
        // $phone_result = $check_phone_query->get_result();
        // $idcard_result = $check_idcard_query->get_result();

        if ($email_result->num_rows > 0) {
            $response = array(
                'result' => 0,
                'message' => 'มีอีเมลนี้อยู่แล้ว'
            );
        } 
        // else if ($phone_result->num_rows > 0) {
        //     $response = array(
        //         'result' => 0,
        //         'message' => 'มีเบอร์โทรศัพท์นี้อยู่แล้ว'
        //     );
        // } else if ($idcard_result->num_rows > 0) {
        //     $response = array(
        //         'result' => 0,
        //         'message' => 'มีรหัสบัตรประชาชนนี้อยู่แล้ว'
        //     );
        // } 
        else {
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

                $tmp_name = $_FILES['image']['tmp_name'];
                $image = uniqid() . '_' . $_FILES['image']['name'];
                $imagePath = 'uploads/' . $image;
                move_uploaded_file($tmp_name, $imagePath);
                $certificate = $image;
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $con->prepare("INSERT INTO barber(ba_name, ba_lastname, ba_phone, ba_email, ba_password, ba_idcard, ba_certificate, ba_namelocation, ba_latitude, ba_longitude) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssssdd", $name, $lastname, $phone, $email, $hashed_password, $idcard, $certificate, $namelocation, $latitude, $longitude);
            // ทำการเพิ่มข้อมูลลูกค้า
            if ($stmt->execute()) {
                // ส่งข้อมูลผลลัพธ์กลับให้กับแอปพลิเคชัน
                $response = array(
                    'result' => 1,
                    'message' => 'เพิ่มข้อมูลสำเร็จ'
                );
            } else {
                // กรณีมีข้อผิดพลาดในการเพิ่มข้อมูล
                $response = array(
                    'result' => 0,
                    'message' => 'เพิ่มข้อมูลไม่สำเร็จ'
                );
            }

            // ปิด prepared statement
            $stmt->close();

            // ปิดการเชื่อมต่อ MySQL
            $con->close();
        }
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
