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
        $userId = $_POST['user_id'];
        $user_birthdate = $_POST['user_birthdate'];
        $user_gender = $_POST['user_gender'];
        $user_idcard = $_POST['user_idcard'];
        $user_age = $_POST['user_age'];
        $user_phone = $_POST['user_phone'];

        // Check if the Certificate file is being updated
        if (isset($_FILES['user_Certificate']) && $_FILES['user_Certificate']['size'] > 0) {
            // Handle Certificate file update similar to the insert process

            // ... (Refer to your existing code for handling file upload and move)
        } else {
            // Keep the existing Certificate file if not updated
            $target_file = $row['user_Certificate'];
        }

        // Update the user data in the database
        $stmt_update = $conn->prepare("UPDATE user_table SET  user_birthdate=?, 
                                       user_gender=?, user_idcard=?,  
                                       user_age=?, user_phone=?, 
                                       user_Certificate=? WHERE user_id=?");

        $stmt_update->bind_param(
            "ssssssi",
            $user_birthdate,
            $user_gender,
            $user_idcard,
            $user_age,
            $user_phone,
            $target_file,
            $userId
        );


        if ($stmt_update->execute()) {
            // ทำการ redirect ไปที่ index.php หลังจากอัปเดตข้อมูลสำเร็จ
            header("Location: ../../font_end/list_hs.php");
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update cus']);
        }

        $stmt_update->close();
        $conn->close();
    } else {
        // ถ้าไม่ใช่เมธอด POST ก็ไม่ต้องทำอะไร
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
}
