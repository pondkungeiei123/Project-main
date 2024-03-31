<?php
// connect.php
include "../../config.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $hair_name = $_POST["hair_name"];
    $hair_price = $_POST["hair_price"];

    $stmt = $conn->prepare("INSERT INTO hairstlye (hair_name, hair_price) VALUES (?, ?)");

    if ($stmt) {
        $stmt->bind_param("ss", $hair_name, $hair_price);

        // Execute the statement
        if ($stmt->execute()) {
            $response = array("success" => true);
        } else {
            $response = array("success" => false, "message" => $stmt->error);
        }
        
        // Close statement
        $stmt->close();
    } else {
        $response = array("success" => false, "message" => "Statement preparation failed");
    }
} else {
    $response = array("success" => false, "message" => "Invalid request method");
}

// Close connection
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
