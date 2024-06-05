<?php
include '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad_email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL injection
    $sql = "SELECT * FROM admin WHERE ad_email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
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
                header('Location: ../font_end/index.php'); // Redirect to the main page
                exit;
            } else {
                header('Location: ./login.php?error=รหัสผ่านไม่ถูกต้อง');
                exit;
            }
        } else {
            header('Location: ./login.php?error=อีเมลไม่ถูกต้อง');
            exit;
        }
    } else {
        die("Prepare statement failed: " . $conn->error);
    }
}
?>

