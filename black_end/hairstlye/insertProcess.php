<?php
// connect.php
include "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    if (isset($_FILES['hair_photo'])) {
        $photo_file = $_FILES['hair_photo']['name'];
        $photo_temp = $_FILES['hair_photo']['tmp_name'];
        $file_info = pathinfo($photo_file);
        $extension = $file_info['extension'];

        // Define the directory to store the files
        $target_directory = "../../asset/Photo/";
        $target_directory .= date("Y-m-d") . "/";

        // Check and create the directory if it doesn't exist
        if (!file_exists($target_directory)) {
            if (!mkdir($target_directory, 0755, true)) {
                echo "Failed to create the directory.";
                exit;
            }
        }

        // Create a new filename
        $random_suffix = uniqid();
        $target_file = $random_suffix . '_' . substr(basename($photo_file), 0, 10) . '.' . $extension;

        // Move the file to the target directory
        if (move_uploaded_file($photo_temp, $target_directory . $target_file)) {
            $target_file = date("Y-m-d") . "/" . $target_file;
    
            $hair_name = $_POST["hair_name"];
            $hair_price = $_POST["hair_price"];
            $name_test = $_POST["name_test"];
            // Handle file upload
    

        $stmt = $conn->prepare("INSERT INTO hairstlye (hair_name, hair_price, hair_photo, name_test) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $hair_name, $hair_price, $target_file, $name_test);

        // Execute the statement
        if ($stmt->execute()) {
            $response = array("success" => true);
        } else {
            $response = array("success" => false, "message" => $stmt->error);
        }
        
        // Close statement
        $stmt->close();
    } else {
        $response = array("success" => false, "message" => "Failed to move uploaded file");
    }
} else {
    $response = array("success" => false, "message" => "No file uploaded");
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
