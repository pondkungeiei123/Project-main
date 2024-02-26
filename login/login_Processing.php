<?php
// include config file
include '../config.php';

// ตรวจสอบการลงชื่อเข้าใช้งานและประมวลผลข้อมูลต่าง ๆ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบการลงชื่อเข้าใช้งาน
    $ad_email = $_POST['email'];
    $password = $_POST['password'];

    // ค้นหาผู้ใช้ในฐานข้อมูล
    $sql = "SELECT * FROM admin_table WHERE ad_email = '$ad_email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['status_login'] = 'success';
            header('Location: ../font_end/index.php'); // ส่งไปยังหน้าหลัก
            exit;
        } else {
            echo $row['ad_password'];
        }
    } else {
        echo 'ไม่พบผู็ใช้';
    }
}
?>