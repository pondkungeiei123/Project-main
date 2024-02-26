<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die(json_encode(["error" => "Connection error: " . mysqli_connect_error()]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
        $tmp_name = $_FILES['image']['tmp_name']; 
        
        // Generate a random filename
        $image = uniqid() . '_' . $_FILES['image']['name']; 
        $imagePath = 'uploads/'.$image;
        
        move_uploaded_file($tmp_name, $imagePath);

        // Validate user input
        $sql = "INSERT INTO grouppicture (up_picture, user_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $image, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["message" => "Image uploaded successfully"]);
        } else {
            throw new Exception("Error executing SQL statement");
        }

        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}

// Close the database connection
mysqli_close($con);
