<?php
include "../../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hair_id = $_POST['hair_id'];
    $hair_price = $_POST["hair_price"];

    // Prepare the SQL statement for updating hairstyle data
    $stmt = $conn->prepare("UPDATE hairstlye SET hair_price = ? WHERE hair_id = ?");
    $stmt->bind_param("si", $hair_price, $hair_id);

    // Check if a new image has been uploaded
    if (isset($_FILES['new_hair_photo']) && $_FILES['new_hair_photo']['error'] === UPLOAD_ERR_OK) {
        // Process the uploaded image
        $file_tmp = $_FILES['new_hair_photo']['tmp_name'];
        $file_name = $_FILES['new_hair_photo']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_new_name = uniqid() . '.' . $file_ext; // Create a unique file name

        // Move the uploaded file to the desired location
        $target_directory = '../../BBapi/hair/';
        if (move_uploaded_file($file_tmp, $target_directory . $file_new_name)) {
            // Update the hair_photo column in the database
            $stmt_update_photo = $conn->prepare("UPDATE hairstlye SET hair_photo = ? WHERE hair_id = ?");
            $stmt_update_photo->bind_param("si", $file_new_name, $hair_id);
            $stmt_update_photo->execute();
            $stmt_update_photo->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
            exit();
        }
    }

    // Execute the update for the price
    if ($stmt->execute()) {
        // Redirect to hairstlye.php after successful update
        header("Location: ../../font_end/hairstlye.php");
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update hairstyle']);
    }

    $stmt->close();
} else {
    // If it's not a POST method, return error message
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
