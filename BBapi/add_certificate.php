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
    // Check if 'ba_id' is set
    if (isset($_POST['ba_id'])) {
        $ba_id = $_POST['ba_id'];

        // Initialize an array to store responses for each image
        $responses = [];

        // Check if there are files uploaded
        if (!empty($_FILES['images']['name'][0]) && $_FILES['images']['error'][0] === UPLOAD_ERR_OK) {
            // Loop through each uploaded file
            for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
                $tmp_name = $_FILES['images']['tmp_name'][$i];
                $image = uniqid() . '_' . $_FILES['images']['name'][$i];
                $imagePath = 'certificate/' . $image;

                // Move uploaded file to specified path
                if (move_uploaded_file($tmp_name, $imagePath)) {
                    // Prepare and execute SQL statement for each image
                    $stmt = $con->prepare("INSERT INTO certificate (ce_photo, ba_id) VALUES (?,?)");
                    $stmt->bind_param("si", $image, $ba_id);

                    if ($stmt->execute()) {
                        $responses[] = array(
                            'result' => 1,
                            'message' => 'เพิ่มรูปภาพสำเร็จ',
                            'image' => $image,
                        );
                    } else {
                        $responses[] = array(
                            'result' => 0,
                            'message' => 'ไม่สามารถเพิ่มรูปภาพ',
                            'image' => $image,
                        );
                    }

                    $stmt->close();
                } else {
                    $responses[] = array(
                        'result' => 0,
                        'message' => 'ผิดพลาดในการอัปโหลดภาพ',
                        'image' => $_FILES['images']['name'][$i],
                    );
                }
            }
        }

        // Check if any responses were collected
        if (!empty($responses)) {
            $response = array(
                'result' => 1,
                'message' => 'บันทึกรูปภาพสำเร็จ',
                'responses' => $responses,
            );
        } else {
            $response = array(
                'result' => 0,
                'message' => 'บันทึกรูปภาพไม่สำเร็จ',
            );
        }

        $con->close();
    } else {
        $response = array(
            'result' => -1,
            'message' => 'ข้อมูลไม่ครบ',
        );
    }
} else {
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี GET',
    );
}

echo json_encode($response);
exit();
