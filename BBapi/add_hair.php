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
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['ba_id'])  && isset($_POST['photo']) ) {
        $photo = $_POST['photo'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $ba_id = $_POST['ba_id'];

        $check_name_query = $con->prepare("SELECT hair_name,ba_id FROM hairstlye WHERE hair_name = ? AND ba_id = ? LIMIT 1");
        $check_name_query->bind_param('si', $name,$ba_id);
        $check_name_query->execute();

        $name_result = $check_name_query->get_result();

        if ($name_result->num_rows > 0) {
            $response = array(
                'result' => 0,
                'message' => 'มีชื่อทรงผมนี้อยู่แล้ว'
            );
        } else {
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

                $tmp_name = $_FILES['image']['tmp_name'];
                $image = uniqid() . '_' . $_FILES['image']['name'];
                $imagePath = 'hair/' . $image;
                move_uploaded_file($tmp_name, $imagePath);
                $photo = $image;
            }
    
            $stmt = $con->prepare("INSERT INTO hairstlye (hair_name, hair_price ,hair_photo, ba_id) VALUES (? , ? , ?, ?)");
            $stmt->bind_param("sdsi", $name, $price,$photo,$ba_id);
            if ($stmt->execute()) {   
                $response = array(
                    'result' => 1,
                    'message' => 'เพิ่มทรงผมสำเร็จ'
                );
            } else {
               
                $response = array(
                    'result' => 0,
                    'message' => 'เพิ่มทรงผมไม่สำเร็จ'
                );
            }

            $stmt->close();
            $con->close();
        }

        echo json_encode($response);
        exit();
    } else {
        $response = array(
            'result' => -1,
            'message' => 'ข้อมูลไม่ครบถ้วน'
        );
        echo json_encode($response);
        exit();
    }
} else {
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี POST'
    );
    echo json_encode($response);
    exit();
}
