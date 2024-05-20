<?php
include "../../config.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['ad_id'];
    if ($userId != $_SESSION['ad_id']) {
        $stmt = $conn->prepare("DELETE FROM admin WHERE ad_id = ?");
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            $response = array("success" => true);
        } else {
            echo "<p>Failed to delete user</p>";
        }
        $stmt->close();
    } else {
        $response = array("success" => false);
    }
} else {
    echo "<p>Invalid request</p>";
}
$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
