<?php
include "../config.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if id is received
if (isset($_GET['id'])) {
    $cus_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT cm.cus_name, cm.cus_lastname, cm.cus_email, cm.cus_phone,
                            COUNT(pm.pm_id) AS total_visits,
                            SUM(pm.pm_amount) AS total_amount
                            FROM `customer` AS cm
                            LEFT JOIN booking AS bk ON cm.cus_id = bk.cus_id
                            LEFT JOIN payment AS pm ON bk.bk_id = pm.bk_id
                            WHERE cm.cus_id = ?
                            GROUP BY cm.cus_id");
    $stmt->bind_param("i", $cus_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    if ($customer) {
        echo json_encode(['success' => true, 'customer' => $customer]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}

// Close connection
$conn->close();
?>
