<?php
include "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $baId = $_POST['hair_id'];
    $stmt = $conn->prepare("SELECT * FROM hairstlye WHERE hair_id = ?");
    $stmt->bind_param("i", $baId);
    $stmt->execute();
    $result = $stmt->get_result();
        // echo 
        //     isset($file_info['extension']);
        //      die("true1 ");
        // // echo 
        // //     isset($_FILES['hair_photo']['tmp_name']);
        // //     die("true2 ");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $hair_id = $_POST['hair_id'];
        $hair_name = $_POST["hair_name"];
        $hair_price = $_POST["hair_price"];
        $name_test = $_POST["name_test"];

        // Check if hair_photo is set and not empty
        if (isset($_FILES['hair_photo']) && $_FILES['hair_photo']['size'] > 0) {
            $certificate_file = $_FILES['hair_photo']['name'];
           
            $certificate_temp = $_FILES['hair_photo']['tmp_name'];
            $file_info = pathinfo($certificate_file);
            $extension = $file_info['extension'];

            // Define target directory
            $target_directory = "../../asset/Photo/";
            echo $target_directory;
            die();
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
            echo $random_suffix;
            die();
            $target_file = $random_suffix . '_' . substr(basename($certificate_file), 0, 10) . '.' . $extension;
            echo $target_file;
            die();

            // Move uploaded file to target location
            if (move_uploaded_file($certificate_temp, $target_directory . $target_file)) {
                $target_file = date("Y-m-d") . "/" . $target_file;
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to move the uploaded file']);
                exit();
            }
        } else {
            // Keep the existing Certificate file if not updated
            $target_file = $row['hair_photo']; // Assuming $row is defined somewhere
        }

        // Update the hairstyle data in the database
        $stmt = $conn->prepare("UPDATE hairstlye SET hair_name = ?, hair_price = ?, hair_photo = ?, name_test = ? WHERE hair_id = ?");
        $stmt->bind_param("ssssi", $hair_name, $hair_price, $target_file, $name_test, $hair_id);

        if ($stmt->execute()) {
            // Redirect to index.php after successful update
            header("Location: ../../font_end/hairstlye.php");
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update hairstyle']);
        }

        $stmt->close();
        $conn->close();
    } else {
        // If it's not a POST method, return error message
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
}
