<?php
// include config file
include '../config.php';

// ตรวจสอบว่ามีการส่งข้อมูล POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบข้อมูลจากฟอร์ม
    $email = $_POST['Email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // เพิ่มตรวจสอบความถูกต้องของข้อมูลได้ตามที่ต้องการ
    if ($password !== $confirm_password) {
        // กรณีรหัสผ่านไม่ตรงกัน
        echo "รหัสผ่านไม่ตรงกัน";
    } else {
        // ถ้าข้อมูลถูกต้อง, ทำการเพิ่มข้อมูลในฐานข้อมูล
        // เพิ่มรหัสผ่านเข้ารหัสก่อนบันทึกลงในฐานข้อมูล
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // ทำการเพิ่มข้อมูลลงในฐานข้อมูล
        $sql = "INSERT INTO users (user_email, user_password) VALUES ('$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            // เมื่อเพิ่มข้อมูลสำเร็จ
            echo "ลงทะเบียนสำเร็จ";
            // หรือสามารถเปลี่ยนเส้นทางไปยังหน้า Login ได้
             header('Location: login.php');
             exit;
        } else {
            // กรณีเกิดข้อผิดพลาดในการเพิ่มข้อมูล
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .signup-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: auto;
        }

        .signup-container h2 {
            text-align: center;
        }

        .signup-form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group button {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="signup-container">
        <h2>Signup</h2>
        <form class="signup-form" action="" method="post">
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="text" id="Email" name="Email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="form-group">
                <button type="submit">Signup</button>
            </div>
        </form>
    </div>

</body>
</html>
