<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

$ba_id = $_POST['ba_id'];
$ba_name = $_POST['ba_name'];
$ba_lastname = $_POST['ba_lastname'];
$ba_phone = $_POST['ba_phone'];
$ba_email = $_POST['ba_email'];


$updatedData = fetchUpdatedData($ba_id, $con);
// สร้าง statement
$stmt = $con->prepare("UPDATE barber SET ba_name = ?, ba_lastname = ?, ba_phone = ?, ba_email = ? WHERE ba_id = ?");

// กำหนดค่าพารามิเตอร์
$stmt->bind_param("sssss", $ba_name, $ba_lastname, $ba_phone, $ba_email, $ba_id);

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

function fetchUpdatedData($ba_id, $con) {
    $stmt = $con->prepare("SELECT * FROM barber WHERE ba_id = ?");
    $stmt->bind_param("s", $ba_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ดึงข้อมูลและแปลงให้เป็น String
        $data = $result->fetch_assoc();
        $data['ba_id'] = (string)$data['ba_id'];
        return $data;
    }

    return null;
}


