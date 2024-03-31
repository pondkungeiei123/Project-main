<?php
include "../../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hair_id = $_POST['hair_id'];
    
    // ลบข้อมูลผู้ใช้
    $stmt = $conn->prepare("DELETE FROM hairstlye WHERE hair_id = ?");
    $stmt->bind_param("i", $hair_id);

    if ($stmt->execute()) {
        $response = array("success" => true);
        // ทำการ redirect ไปที่ index.php หลังจากลบข้อมูลสำเร็จ
    } else {
        $response = array("success" => false, "message" => "Failed to delete user");
    }

    $stmt->close();
} else {
    $response = array("success" => false, "message" => "Invalid request");
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
