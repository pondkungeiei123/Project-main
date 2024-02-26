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
    $cus_name = $_POST["cus_name"];
    $cus_lastname = $_POST["cus_lastname"];
    $cus_email = $_POST["cus_email"];
    $cus_password = password_hash($_POST["cus_password"], PASSWORD_DEFAULT); // Hash the password
    $cus_phone = $_POST["cus_phone"];
    // $cus_gender = $_POST["cus_gender"];
    // $cus_address = $_POST["cus_address"];
    // $cus_age = $_POST["cus_age"];
    // Add additional fields as needed

    // Prepare and bind the SQL statement
    // $stmt = $conn->prepare("INSERT INTO customer_table (cus_name, cus_lastname, cus_email, cus_password, cus_gender, cus_address, cus_tel, cus_age) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    // $stmt->bind_param("sssssssi", $cus_name, $cus_lastname, $cus_email, $cus_password, $cus_gender, $cus_address, $cus_tel, $cus_age);

    $stmt = $conn->prepare("INSERT INTO customer_table (cus_name, cus_lastname, cus_email, cus_password, cus_phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $cus_name, $cus_lastname, $cus_email, $cus_password, $cus_phone);
    // Execute the statement
    if ($stmt->execute()) {
        $response = array("success" => true);
    } else {
        $response = array("success" => false, "message" => $conn->error);
    }

    // Close statement
    $stmt->close();
} else {
    $response = array("success" => false, "message" => "Invalid request method");
}

// Close connection
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
