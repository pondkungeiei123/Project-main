<?php
header('Content-Type: application/json; charset=UTF-8');
include "../../config.php";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ba_email = $_POST["ba_email"];
    $stmt = $conn->prepare("SELECT ba_email FROM barber WHERE ba_email = ?");
    $stmt->bind_param("s", $ba_email);
    $stmt->execute();
    $email = $stmt->get_result();

    if ($email->num_rows > 0) {
        $response = array("success" => false, "message" => "Email นี้มีอยู่ในระบบแล้ว");
        $stmt->close();
        $conn->close();
        echo json_encode($response);
        exit;
    }

    if (!isset($_FILES['ce_photo']) || empty($_FILES['ce_photo']['name'][0])) {
        $response = array("success" => false, "message" => "ยังไม่ได้ใส่ใบเซอร์");
        echo json_encode($response);
        exit;
    }

    $ba_name = $_POST['ba_name'];
    $ba_lastname = $_POST['ba_lastname'];
    $ba_idcard = $_POST['ba_idcard'];
    $ba_password = password_hash($_POST["ba_password"], PASSWORD_DEFAULT);
    $ba_phone = $_POST['ba_phone'];
    $ba_namelocation = $_POST['ba_namelocation'];
    $ba_latitude = isset($_POST['ba_latitude']) ? $_POST['ba_latitude'] : 0.0;
    $ba_longitude = isset($_POST['ba_longitude']) ? $_POST['ba_longitude'] : 0.0;

    $sql = "INSERT INTO barber (ba_name, ba_lastname, ba_idcard, ba_email, ba_password, ba_phone, ba_latitude, ba_longitude, ba_namelocation)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssss",
        $ba_name,
        $ba_lastname,
        $ba_idcard,
        $ba_email,
        $ba_password,
        $ba_phone,
        $ba_latitude,
        $ba_longitude,
        $ba_namelocation
    );

    if ($stmt->execute()) {
        $ba_id = $stmt->insert_id; // Get the ID of the newly inserted barber

        $target_directory = "../../../BBapi/certificate/";

        // ตรวจสอบว่าไดเรกทอรีมีอยู่แล้วหรือไม่
        if (!file_exists($target_directory)) {
            // ถ้าไดเรกทอรียังไม่มี, สร้างไดเรกทอรี
            if (!mkdir($target_directory, 0755, true)) {
                $response = array("success" => false, "message" => "Failed to create the directory.");
                echo json_encode($response);
                exit;
            }
        }

        $certificate_files = [];
        if (isset($_FILES['ce_photo'])) {
            foreach ($_FILES['ce_photo']['name'] as $key => $certificate_file) {
                $certificate_temp = $_FILES['ce_photo']['tmp_name'][$key];
                $file_info = pathinfo($certificate_file);
                $extension = $file_info['extension'];
                $random_suffix = uniqid();
                $target_file = $random_suffix . '_' . substr(basename($certificate_file), 0, 10) . '.' . $extension;

                if (move_uploaded_file($certificate_temp, $target_directory . $target_file)) {
                    $certificate_files[] = $target_file;
                } else {
                    $response = array("success" => false, "message" => "Failed to move uploaded file");
                    echo json_encode($response);
                    exit;
                }
            }
        }

        foreach ($certificate_files as $cert_file) {
            $stmt = $conn->prepare("INSERT INTO certificate (ce_photo, ba_id) VALUES (?, ?)");
            $stmt->bind_param("si", $cert_file, $ba_id);
            $stmt->execute();
        }

        $response = array("success" => true, "message" => "บันทึกข้อมูลสำเร็จ");
    } else {
        $response = array("success" => false, "message" => "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error);
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
}
?>
