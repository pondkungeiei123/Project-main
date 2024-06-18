<?php
include "../config.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if hair_id is received
if (isset($_GET['hair_id'])) {
    $hair_id = $_GET['hair_id'];
    $stmt = $conn->prepare("
        SELECT h.hair_id, h.hair_name, h.hair_price, h.hair_photo, b.ba_name
        FROM hairstlye h
        JOIN barber b ON h.ba_id = b.ba_id
        WHERE h.hair_id = ?
    ");
    $stmt->bind_param('i', $hair_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hairstyle = $result->fetch_assoc();

    if ($hairstyle) {
        echo json_encode(['success' => true, 'hairstyle' => $hairstyle]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลทรงผม']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ไม่พบ ID ทรงผม']);
}

// Close connection
$conn->close();
?>
