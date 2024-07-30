<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$user_lastname = $_POST['user_lastname'];
$user_phone = $_POST['user_phone'];
$user_email = $_POST['user_email'];


$updatedData = fetchUpdatedData($user_id, $con);
// สร้าง statement
$stmt = $con->prepare("UPDATE user_table SET user_name = ?, user_lastname = ?, user_phone = ?, user_email = ? WHERE user_id = ?");

// กำหนดค่าพารามิเตอร์
$stmt->bind_param("sssss", $user_name, $user_lastname, $user_phone, $user_email, $user_id);

// ประมวลผลคำสั่ง SQL
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'User updated successfully', 'data' => $updatedData]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $con->error]);
}

// ปิด statement
$stmt->close();

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($con);

function fetchUpdatedData($user_id, $con) {
    $stmt = $con->prepare("SELECT * FROM user_table WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ดึงข้อมูลและแปลงให้เป็น String
        $data = $result->fetch_assoc();
        $data['user_id'] = (string)$data['user_id'];
        return $data;
    }

    return null;
}


