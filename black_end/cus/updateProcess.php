<?php
include "../../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cus_name = $_POST["cus_name"];
    $cus_lastname = $_POST["cus_lastname"];
    $cus_email = $_POST["cus_email"];
    $cus_password = password_hash($_POST["cus_password"], PASSWORD_DEFAULT); // Hash the password
    $cus_phone = $_POST["cus_phone"];
    // $cus_gender = $_POST["cus_gender"];
    // $cus_address = $_POST["cus_address"];
    // $cus_age = $_POST["cus_age"];
    // Add additional fields as needed

    // ตรวจสอบว่ามีการอัปเดตข้อมูลในฐานข้อมูลหรือไม่
    // $stmt = $conn->prepare("UPDATE customer SET cus_name = ?, cus_lastname = ?, cus_email = ?, cus_password = ?, cus_gender = ?, cus_address = ?, cus_tel = ?, cus_age = ? WHERE cus_id = ?");
    // $stmt->bind_param("ssssssssi", $cusName, $cusLastname, $cusEmail, $cusPassword, $cusGender, $cusAddress, $cusTel, $cusAge, $cusId);

    $stmt = $conn->prepare("UPDATE customer_table SET cus_name=?, cus_lastname=?, cus_email=?, cus_password=?, cus_phone=? WHERE cus_id=?");
    $stmt->bind_param("sssssi", $cus_name, $cus_lastname, $cus_email, $cus_password, $cus_phone, $cus_id);


    if ($stmt->execute()) {
        // ทำการ redirect ไปที่ index.php หลังจากอัปเดตข้อมูลสำเร็จ
        header("Location: ../../font_end/list_cus.php");
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update cus']);
    }

    $stmt->close();
    $conn->close();
} else {
    // ถ้าไม่ใช่เมธอด POST ก็ไม่ต้องทำอะไร
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
