<?php
// connect.php
header('Content-Type: application/json; charset=UTF-8');

include "../../config.php";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_email = $_POST["ad_email"];
    //ดึงข้อมูล email
    $stmt = $conn->prepare("SELECT ad_email FROM admin WHERE ad_email = ?");
    $stmt->bind_param("s", $ad_email);
    $stmt->execute();
    $email = $stmt->get_result();
    //เช็คเมล

    if ($email->num_rows > 0) {
        $response = array("success" => false, "message" => "email นี้มีอยุ่ในระบบแล้ว");
        $stmt->close();
        $conn->close();
        echo json_encode($response);
        exit;
    }

    $ad_name = $_POST["ad_name"];
    $ad_lastname = $_POST["ad_lastname"];
    $ad_password = password_hash($_POST["ad_password"], PASSWORD_DEFAULT); 
    $stmt = $conn->prepare("INSERT INTO admin (ad_name, ad_lastname, ad_email, ad_password) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $ad_name, $ad_lastname, $ad_email, $ad_password);
        if ($stmt->execute()) {
            $response = array("success" => true);
        } else {
            $response = array("success" => false, "message" => $stmt->error);
        }
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
