<?php
// เชื่อมต่อฐานข้อมูล
include "../../config.php";

// ตรวจสอบว่ามีข้อมูลที่รับมาจากหน้า list_hs.php หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีไฟล์ Certificate ถูกอัปโหลดมาหรือไม่
    if (isset($_FILES['ba_certificate'])) {
        $certificate_file = $_FILES['ba_certificate']['name'];
        $certificate_temp = $_FILES['ba_certificate']['tmp_name'];
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
            $ba_name = $_POST['ba_name'];
            $ba_lastname = $_POST['ba_lastname'];
            $ba_idcard = $_POST['ba_idcard'];
            $ba_email = $_POST['ba_email'];
            $ba_password = $_POST['ba_password'];
            $ba_phone = $_POST['ba_phone'];
            $ba_namelocation = $_POST['ba_namelocation'];

            // ตรวจสอบว่ามีข้อมูล ba_longitude และ ba_latitude ที่ถูกส่งมาหรือไม่
            $ba_latitude = isset($_POST['ba_latitude']) ? $_POST['ba_latitude'] : 0.0;
            $ba_longitude = isset($_POST['ba_longitude']) ? $_POST['ba_longitude'] : 0.0;

            // SQL สำหรับเพิ่มข้อมูล
           $sql = "INSERT INTO barber (ba_name, ba_lastname, ba_idcard, ba_email, ba_password, ba_phone, ba_latitude, ba_longitude, ba_certificate, ba_namelocation)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            // เตรียมคำสั่ง SQL
            $stmt = $conn->prepare($sql);

            // ผูกค่าพารามิเตอร์
            $stmt->bind_param(
                "ssssssssss",
                $ba_name,
                $ba_lastname,
                $ba_idcard,
                $ba_email,
                $ba_password,
                $ba_phone,
                $ba_latitude,
                $ba_longitude,
                $target_file,
                $ba_namelocation
            );

            // ทำการ execute คำสั่ง SQL
            if ($stmt->execute()) {
                $response = array("success" => true, "message" => "บันทึกข้อมูลสำเร็จ");
            } else {
                $response = array("success" => false, "message" => "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error);
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

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();

// ส่งผลลัพธ์ในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
