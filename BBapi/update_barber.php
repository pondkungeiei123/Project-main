<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die(json_encode(array('result' => 0, 'message' => 'Connection error:' . mysqli_connect_error())));
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required data is provided
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

        // $check_phone_query = $con->prepare("SELECT ba_phone FROM barber WHERE ba_phone = ? AND ba_id != ? ");
        // $check_phone_query->bind_param('si', $phone , $id );
        // $check_phone_query->execute();

        // $check_idcard_query = $con->prepare("SELECT ba_idcard FROM barber WHERE ba_idcard = ? AND ba_id != ? LIMIT 1");
        // $check_idcard_query->bind_param('si', $idcard, $id);
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
                $oldPhoto = $certificate;
                @unlink("uploads/$oldPhoto");

                $tmp_name = $_FILES['image']['tmp_name'];
                // Generate a random filename
                $image = uniqid() . '_' . $_FILES['image']['name'];
                $imagePath = 'uploads/' . $image;

                move_uploaded_file($tmp_name, $imagePath);

                $certificate = $image;
            }

            // Use prepared statement to prevent SQL injection
            if ($password === '') {
                $stmt = $con->prepare("UPDATE  barber  SET  ba_name = ? , ba_lastname = ? , ba_phone =?, ba_email =? , ba_idcard =?, ba_certificate = ? , ba_namelocation = ? , ba_latitude = ? , ba_longitude = ? WHERE ba_id  = ? ");
                $stmt->bind_param("sssssssddi", $name, $lastname, $phone, $email, $idcard, $certificate, $namelocation, $latitude, $longitude, $id);
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $con->prepare("UPDATE  barber  SET  ba_name = ? , ba_lastname = ? , ba_phone =?, ba_email =? , ba_password = ? , ba_idcard =?, ba_certificate =?, ba_namelocation =?, ba_latitude =?, ba_longitude =? WHERE ba_id  = ? ");
                $stmt->bind_param("ssssssssddi", $name, $lastname, $phone, $email, $hashed_password, $idcard, $certificate, $namelocation, $latitude, $longitude, $id);
            }

            if ($stmt->execute()) {
                // Send the result back to the application
                $response = array(
                    'result' => 1,
                    'message' => 'แก้ไขข้อมูลสำเร็จ'
                );
            } else {
                // If there's an error in updating data
                $response = array(
                    'result' => 0,
                    'message' => 'แก้ไขข้อมูลไม่สำเร็จ'
                );
            }

            // Close prepared statement
            $stmt->close();
        }

        // Close MySQL connection
        $con->close();
    } else {
        // If data is incomplete
        $response = array(
            'result' => -1,
            'message' => 'ข้อมูลไม่ครบถ้วน'
        );
    }
} else {
    // If not using POST method to send data
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี POST'
    );
}
echo json_encode($response);

exit();
