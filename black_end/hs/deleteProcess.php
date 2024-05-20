<?php
include "../../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baId = $_POST['ba_id'];
    
    // ลบข้อมูลผู้ใช้
    $stmt = $conn->prepare("DELETE FROM barber WHERE ba_id  = ?");
    $stmt->bind_param("i", $baId);

    if ($stmt->execute()) {
        $response = array("success" => true);

    } else {
        echo "<p>Failed to delete ba</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid request</p>";
}
$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
