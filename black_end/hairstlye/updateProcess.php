<?php
include "../../config.php";

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
        $hair_price = $_POST["hair_price"];
 

        // Update the hairstyle data in the database
        $stmt = $conn->prepare("UPDATE hairstlye SET  hair_price = ? WHERE hair_id = ?");
        $stmt->bind_param("si",  $hair_price , $hair_id);

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
