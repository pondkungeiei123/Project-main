<?php
include "../../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    
    // ลบข้อมูลผู้ใช้
    $stmt = $conn->prepare("DELETE FROM user_table WHERE user_id  = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $response = array("success" => true);

    } else {
        echo "<p>Failed to delete user</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid request</p>";
}
$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
