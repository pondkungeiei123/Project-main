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
        $response = array("success" => false, "message" => "email นี้มีอยุ่ในระบบแล้ว");
        $stmt->close();
        $conn->close();
        echo json_encode($response);
        exit;
    }

    if (!isset($_FILES['ba_certificate']) || empty($_FILES['ba_certificate']['name'][0])) {
        $response = array("success" => false, "message" => "ยังไม่ได้ใส่ใบเซอร์");
        echo json_encode($response);
        exit;
    }

    $ba_name = $_POST['ba_name'];
    $ba_lastname = $_POST['ba_lastname'];
    $ba_idcard = $_POST['ba_idcard'];
    $ba_password = $_POST['ba_password'];
    $ba_phone = $_POST['ba_phone'];
    $ba_namelocation = $_POST['ba_namelocation'];
    $ba_latitude = isset($_POST['ba_latitude']) ? $_POST['ba_latitude'] : 0.0;
    $ba_longitude = isset($_POST['ba_longitude']) ? $_POST['ba_longitude'] : 0.0;

    $target_directory = "../../asset/Certificate/" . date("Y-m-d") . "/";
    if (!file_exists($target_directory)) {
        if (!mkdir($target_directory, 0755, true)) {
            $response = array("success" => false, "message" => "Failed to create the directory.");
            echo json_encode($response);
            exit;
        }
    }

    $certificate_files = [];
    if (isset($_FILES['ba_certificate'])) {
        foreach ($_FILES['ba_certificate']['name'] as $key => $certificate_file) {
            $certificate_temp = $_FILES['ba_certificate']['tmp_name'][$key];
            $file_info = pathinfo($certificate_file);
            $extension = $file_info['extension'];
            $random_suffix = uniqid();
            $target_file = $random_suffix . '_' . substr(basename($certificate_file), 0, 10) . '.' . $extension;

            if (move_uploaded_file($certificate_temp, $target_directory . $target_file)) {
                $certificate_files[] = date("Y-m-d") . "/" . $target_file;
            } else {
                $response = array("success" => false, "message" => "Failed to move uploaded file");
                echo json_encode($response);
                exit;
            }
        }
    }

    $certificate_files_json = json_encode($certificate_files);

    $sql = "INSERT INTO barber (ba_name, ba_lastname, ba_idcard, ba_email, ba_password, ba_phone, ba_latitude, ba_longitude, ba_certificate, ba_namelocation)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
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
        $certificate_files_json,
        $ba_namelocation
    );

    if ($stmt->execute()) {
        $response = array("success" => true, "message" => "บันทึกข้อมูลสำเร็จ");
    } else {
        $response = array("success" => false, "message" => "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error);
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
}
