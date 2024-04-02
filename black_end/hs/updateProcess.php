<?php
// updateProcess.php
include "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $stmt = $conn->prepare("SELECT * FROM user_table WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
   
    if ($result->num_rows > 0) {
        // Fetch the existing user data
        $row = $result->fetch_assoc();

        // Update user data based on the form inputs
        $user_phone = $_POST['user_phone'];
        $user_latitude = $_POST['user_latitude'];
        $user_longitude = $_POST['user_longitude'];

        // Check if the Certificate file is being updated
        if (isset($_FILES['user_Certificate']) && $_FILES['user_Certificate']['size'] > 0) {
            $certificate_file = $_FILES['user_Certificate']['name'];
            $certificate_temp = $_FILES['user_Certificate']['tmp_name'];
            $file_info = pathinfo($certificate_file);
            $extension = $file_info['extension'];

            // Define target directory
            $target_directory = "../../asset/Certificate/";
            $target_directory .= date("Y-m-d") . "/";

            // Check and create directory if not exists
            if (!file_exists($target_directory)) {
                if (!mkdir($target_directory, 0755, true)) {
                    echo json_encode(['success' => false, 'message' => 'Failed to create the directory']);
                    exit();
                }
            }

            // Generate new file name
            $random_suffix = uniqid();
            $target_file = $random_suffix . '_' . substr(basename($certificate_file), 0, 10) . '.' . $extension;

            // Move uploaded file to target location
            if (move_uploaded_file($certificate_temp, $target_directory . $target_file)) {
                $target_file = date("Y-m-d") . "/" . $target_file;
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to move the uploaded file']);
                exit();
            }
        } else {
            // Keep the existing Certificate file if not updated
            $target_file = $row['user_Certificate'];
        }

        // Update the user data in the database
        $stmt_update = $conn->prepare("UPDATE user_table SET user_phone=?, user_latitude=?, user_longitude=?, user_Certificate=? WHERE user_id=?");
        $stmt_update->bind_param("ssssi", $user_phone, $user_latitude, $user_longitude, $target_file, $userId);

        if ($stmt_update->execute()) {
            // Redirect to list_hs.php after updating the data successfully
            header("Location: ../../font_end/list_hs.php");
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update customer']);
        }

        $stmt_update->close();
        $conn->close();
    } else {
        // If it's not a POST method, do nothing
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
}
?>
