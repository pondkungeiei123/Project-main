<?php
header('Content-Type: application/json; charset=UTF-8');
include "../../config.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['ad_id'];
    if ($userId == $_SESSION['ad_id']) {
        $response = array("success" => false);
        echo json_encode($response);
        exit;
    }
    $stmt = $conn->prepare("DELETE FROM admin WHERE ad_id = ?");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        $response = array("success" => true);
        $stmt->close();
    } else {
        $response = array("success" => false, "message" => "Statement preparation failed");
    }
} else {
    $response = array("success" => false, "message" => "Invalid request method");
}
$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
