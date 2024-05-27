<?php
// include config file
include '../config.php';
session_start();
// ตรวจสอบการลงชื่อเข้าใช้งานและประมวลผลข้อมูลต่าง ๆ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบการลงชื่อเข้าใช้งาน
    $ad_email = $_POST['email'];
    $password = $_POST['password'];

    // ค้นหาผู้ใช้ในฐานข้อมูล
    $sql = "SELECT * FROM admin WHERE ad_email = ?";
    $stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ad_email);
$stmt->execute();
$result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ad_password = $row['ad_password'];
        if (password_verify($password, $ad_password)) {
            $_SESSION['ad_name'] = $row['ad_name'];
            $_SESSION['ad_id'] = $row['ad_id'];
            $_SESSION['status_login'] = 'success';
            header('Location: ../font_end/index.php'); // ส่งไปยังหน้าหลัก
            exit;
        } else {
            echo "Password Fail";
            exit;
        }
    } else {
        echo "No Email";
        exit;
    }
}
?>       