<?php
include "../../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hair_id = $_POST['hair_id'];
    $hair_name = $_POST["hair_name"];
    $hair_price = $_POST["hair_price"];


    // ตรวจสอบว่ามีการอัปเดตข้อมูลในฐานข้อมูลหรือไม่
    $stmt = $conn->prepare("UPDATE hairstlye SET hair_name = ?, hair_price = ? WHERE hair_id = ?");
    $stmt->bind_param("ssi", $hair_name, $hair_price,  $hair_id);

    if ($stmt->execute()) {
        // ทำการ redirect ไปที่ index.php หลังจากอัปเดตข้อมูลสำเร็จ
        header("Location: ../../font_end/hairstlye.php");
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update ad']);
    }

    $stmt->close();
    $conn->close();
} else {
    // ถ้าไม่ใช่เมธอด POST ก็ไม่ต้องทำอะไร
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
