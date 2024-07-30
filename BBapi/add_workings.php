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
    if (isset($_POST['ba_id']) && isset($_POST['photo'])) {
        // ดึงข้อมูลจากการส่งเข้ามา
        $photo = $_POST['photo'];
        $ba_id = $_POST['ba_id'];

        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

            $tmp_name = $_FILES['image']['tmp_name'];
            $image = uniqid() . '_' . $_FILES['image']['name'];
            $imagePath = 'uploads/' . $image;
            move_uploaded_file($tmp_name, $imagePath);
            $photo = $image;
        }

        $stmt = $con->prepare("INSERT INTO workings(wo_photo, ba_id) VALUES (?,?)");
        $stmt->bind_param("si", $photo, $ba_id);

        if ($stmt->execute()) {
            $response = array(
                'result' => 1,
                'message' => 'เพิ่มรูปภาพสำเร็จ'
            );
        } else {

            $response = array(
                'result' => 0,
                'message' => 'เพิ่มรูปภาพไม่สำเร็จ'
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
