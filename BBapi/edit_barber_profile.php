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
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['idcard']) && isset($_POST['namelocation']) && isset($_POST['latitude']) && isset($_POST['longitude'])) {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $idcard = $_POST['idcard'];
        $certificate = $_POST['certificate'];
        $namelocation = $_POST['namelocation'];
        $latitude = doubleval($_POST['latitude']);
        $longitude = doubleval($_POST['longitude']);

        $check_email_query = $con->prepare("SELECT ba_email FROM barber WHERE ba_email = ? AND ba_id != ? ");
        $check_email_query->bind_param('si', $email, $id);
        $check_email_query->execute();

        $email_result = $check_email_query->get_result();

        if ($email_result->num_rows > 0) {
            $response = array(
                'result' => 0,
                'message' => 'มีอีเมลนี้อยู่แล้ว'
            );
        } else {
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $oldPhoto = $certificate;
                @unlink("uploads/$oldPhoto");

                $tmp_name = $_FILES['image']['tmp_name'];
                // Generate a random filename
                $image = uniqid() . '_' . $_FILES['image']['name'];
                $imagePath = 'uploads/' . $image;

                move_uploaded_file($tmp_name, $imagePath);

                $certificate = $image;
            }

            if ($password === '') {
                $stmt = $con->prepare("UPDATE  barber  SET  ba_name = ? , ba_lastname = ? , ba_phone =?, ba_email =? , ba_idcard =?, ba_certificate = ? , ba_namelocation = ? , ba_latitude = ? , ba_longitude = ? WHERE ba_id  = ? ");
                $stmt->bind_param("sssssssddi", $name, $lastname, $phone, $email, $idcard, $certificate, $namelocation, $latitude, $longitude, $id);
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $con->prepare("UPDATE  barber  SET  ba_name = ? , ba_lastname = ? , ba_phone =?, ba_email =? , ba_password = ? , ba_idcard =?, ba_certificate =?, ba_namelocation =?, ba_latitude =?, ba_longitude =? WHERE ba_id  = ? ");
                $stmt->bind_param("ssssssssddi", $name, $lastname, $phone, $email, $hashed_password, $idcard, $certificate, $namelocation, $latitude, $longitude, $id);
            }

            if ($stmt->execute()) {
                $stmtData = $con->prepare("SELECT * FROM barber WHERE ba_email = ?");
                $stmtData->bind_param("s", $email);
                $stmtData->execute();

                $resultData = $stmtData->get_result();
                if ($resultData->num_rows > 0) {
                    $row = $resultData->fetch_assoc();
                    $barberData = array(
                        'id' => $row['ba_id'],
                        'name' => $row['ba_name'],
                        'lastname' => $row['ba_lastname'],
                        'phone' => $row['ba_phone'],
                        'email' => $row['ba_email'],
                        'idcard' => $row['ba_idcard'],
                        'certificate' => $row['ba_certificate'],
                        'namelocation' => $row['ba_namelocation'],
                        'latitude' => $row['ba_latitude'],
                        'longitude' => $row['ba_longitude'],
                    );
                    $response = array(
                        'result' => 1,
                        'message' => 'แก้ไขข้อมูลสำเร็จ',
                        'data' => $barberData
                    );
                } else {
                    $response = array(
                        'result' => 0,
                        'message' => 'ไม่พบข้อมูลช่างตัดผม'
                    );
                }
            } else {
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
