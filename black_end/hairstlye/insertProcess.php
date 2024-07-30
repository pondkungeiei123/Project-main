<?php
include "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['hair_photo'])) {
        $photo_file = $_FILES['hair_photo']['name'];
        $photo_temp = $_FILES['hair_photo']['tmp_name'];
        $file_info = pathinfo($photo_file);
        $extension = $file_info['extension'];

        $target_directory = "../../BBapi/hair/";
        $target_directory .= date("Y-m-d") . "/";

        if (!file_exists($target_directory)) {
            if (!mkdir($target_directory, 0755, true)) {
                echo "Failed to create the directory.";
                exit;
            }
        }

        $random_suffix = uniqid();
        $target_file = $random_suffix . '_' . substr(basename($photo_file), 0, 10) . '.' . $extension;

        if (move_uploaded_file($photo_temp, $target_directory . $target_file)) {
            $target_file = date("Y-m-d") . "/" . $target_file;

            $hair_name = $_POST["hair_name"];
            $hair_price = $_POST["hair_price"];

            $stmt = $conn->prepare("INSERT INTO hairstlye (hair_name, hair_price, hair_photo) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $hair_name, $hair_price, $target_file);

            if ($stmt->execute()) {
                $response = array("success" => true);
            } else {
                $response = array("success" => false, "message" => $stmt->error);
            }
            
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

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
