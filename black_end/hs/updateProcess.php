<?php
// updateProcess.php
include "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $baId = $_POST['ba_id'];
    $stmt = $conn->prepare("SELECT * FROM barber LEFT JOIN certificate ON barber.ba_id = certificate.ba_id WHERE barber.ba_id = ?");
    $stmt->bind_param("i", $baId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ba_phone = $_POST['ba_phone'];
        $ba_latitude = $_POST['ba_latitude'];
        $ba_longitude = $_POST['ba_longitude'];

        // เริ่มต้นกับ ce_photo ที่มีอยู่ในฐานข้อมูล
        $relative_path = $row['ce_photo'];

        if (isset($_FILES['ce_photo']) && $_FILES['ce_photo']['size'] > 0) {
            $certificate_file = $_FILES['ce_photo']['name'];
            $certificate_temp = $_FILES['ce_photo']['tmp_name'];
            $file_info = pathinfo($certificate_file);
            $extension = $file_info['extension'];

            $target_directory = "../../BBapi/certificate/";

            if (!file_exists($target_directory)) {
                if (!mkdir($target_directory, 0755, true)) {
                    echo json_encode(['success' => false, 'message' => 'Failed to create the directory']);
                    exit();
                }
            }

            $random_suffix = uniqid();
            $target_file = $target_directory . $random_suffix . '_' . substr(basename($certificate_file), 0, 10) . '.' . $extension;

            if (move_uploaded_file($certificate_temp, $target_file)) {
                $relative_path = $random_suffix . '_' . substr(basename($certificate_file), 0, 10) . '.' . $extension;
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to move the uploaded file']);
                exit();
            }
        }

        // อัปเดตข้อมูลในตาราง certificate
        $stmt_update = $conn->prepare("UPDATE certificate SET ce_photo=? WHERE ba_id=?");
        $stmt_update->bind_param("si", $relative_path, $baId);

        if ($stmt_update->execute()) {
            // อัปเดตข้อมูลในตาราง barber
            $stmt_barber_update = $conn->prepare("UPDATE barber SET ba_phone=?, ba_latitude=?, ba_longitude=? WHERE ba_id=?");
            $stmt_barber_update->bind_param("sssi", $ba_phone, $ba_latitude, $ba_longitude, $baId);
            $stmt_barber_update->execute();

            header("Location: ../../font_end/list_hs.php");
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update certificate']);
        }

        $stmt_update->close();
        $stmt_barber_update->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
}
?>
