<?php
// เชื่อมต่อฐานข้อมูล
include "../../config.php";

// ตรวจสอบว่ามีข้อมูลที่รับมาจากหน้า list_hs.php หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีไฟล์ Certificate ถูกอัปโหลดมาหรือไม่
    if (isset($_FILES['user_Certificate'])) {
        $certificate_file = $_FILES['user_Certificate']['name'];
        $certificate_temp = $_FILES['user_Certificate']['tmp_name'];
        $file_info = pathinfo($certificate_file);
        $extension = $file_info['extension'];

        // กำหนดที่เก็บไฟล์
        $target_directory = "../../asset/Certificate/";
        $target_directory .= date("Y-m-d") . "/";

        // ตรวจสอบและสร้างไดเร็กทอรี
        if (!file_exists($target_directory)) {
            if (!mkdir($target_directory, 0755, true)) {
                echo "Failed to create the directory.";
                exit;
            }
        }

        // สร้างชื่อไฟล์ใหม่
        $random_suffix = uniqid();
        $target_file = $random_suffix . '_' . substr(basename($certificate_file), 0, 10) . '.' . $extension;

        // ย้ายไฟล์ไปยังที่ที่กำหนด
        if (move_uploaded_file($certificate_temp, $target_directory . $target_file)) {
            $target_file = date("Y-m-d") . "/" . $target_file;

            // รับข้อมูลจากฟอร์ม
            $user_name = $_POST['user_name'];
            $user_lastname = $_POST['user_lastname'];
            $user_birthdate = $_POST['user_birthdate'];
            $user_age = $_POST['user_age'];
            $user_gender = $_POST['user_gender'];
            $user_idcard = $_POST['user_idcard'];
            $user_email = $_POST['user_email'];
            $user_password = $_POST['user_password'];
            $user_nationality = $_POST['user_nationality'];
            $user_religion = $_POST['user_religion'];
            $user_phone = $_POST['user_phone'];

            // SQL สำหรับเพิ่มข้อมูล
            $sql = "INSERT INTO user_table (user_name, user_lastname, user_birthdate, user_age, user_gender, user_idcard, user_email, user_password,  user_nationality, user_religion, user_phone, user_Certificate)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // เตรียมคำสั่ง SQL
            $stmt = $conn->prepare($sql);

            // ผูกค่าพารามิเตอร์
            $stmt->bind_param(
                "ssssssssssss",
                $user_name,
                $user_lastname,
                $user_birthdate,
                $user_age,
                $user_gender,
                $user_idcard,
                $user_email,
                $user_password,
                $user_nationality,
                $user_religion,
                $user_phone,
                $target_file
            );

            // ทำการ execute คำสั่ง SQL
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
    }
}        
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>