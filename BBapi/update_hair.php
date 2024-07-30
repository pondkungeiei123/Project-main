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
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['ba_id'])) {

        $id = intval($_POST['id']);
        $name = $_POST['name'];
        $price = $_POST['price'];
        $ba_id = $_POST['ba_id'];
        $photo = $_POST['photo'];

        $check_name_query = $con->prepare("SELECT hair_name , hair_id , ba_id FROM hairstlye WHERE hair_name = ? AND hair_id  != ? AND ba_id = ? LIMIT 1");
        $check_name_query->bind_param('sii', $name, $id, $ba_id);
        $check_name_query->execute();

        $name_result = $check_name_query->get_result();

        if ($name_result->num_rows > 0) {
            $response = array(
                'result' => 0,
                'message' => 'มีชื่อทรงผมนี้อยู่แล้ว'
            );
        } else {

            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $oldPhoto = $photo;
                @unlink("hair/$oldPhoto");

                $tmp_name = $_FILES['image']['tmp_name'];
                // Generate a random filename
                $image = uniqid() . '_' . $_FILES['image']['name'];
                $imagePath = 'hair/' . $image;

                move_uploaded_file($tmp_name, $imagePath);

                $photo = $image;
            }

            $stmt = $con->prepare("UPDATE hairstlye SET hair_name = ?, hair_price = ?, hair_photo = ? , ba_id = ? WHERE hair_id  = ? ");
            $stmt->bind_param("sdsii", $name, $price, $photo , $ba_id , $id);

            if ($stmt->execute()) {
                $response = array(
                    'result' => 1,
                    'message' => 'แก้ไขข้อมูลสำเร็จ'
                );
            } else {
                $response = array(
                    'result' => 0,
                    'message' => 'แก้ไขข้อมูลไม่สำเร็จ'
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
