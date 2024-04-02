<?php

ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Edit User</h2>

        <?php
        // ตรวจสอบว่ามีพารามิเตอร์ id ที่ถูกส่งมาหรือไม่
        if (isset($_GET['id'])) {
            $hair_id = $_GET['id'];

            require_once '../config.php';

            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $stmt = $conn->prepare("SELECT * FROM hairstlye WHERE hair_id = ?");
            $stmt->bind_param("i", $hair_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if ($result->num_rows > 0) {
                $adData = $result->fetch_assoc();
        ?>
                <form action="../black_end/hairstlye/updateProcess.php" method="POST">
                    <input type="hidden" name="hair_id" value="<?= $adData['hair_id']; ?>">
                    <div class="form-group">
                        <label for="hair_name">ชื่อทรงผม:</label>
                        <input type="text" class="form-control" name="hair_name" value="<?= $adData['hair_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hair_price">ราคา:</label>
                        <input type="text" class="form-control" name="hair_price" value="<?= $adData['hair_price']; ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">ยืนยันการเเก้ไข</button>
                </form>
        <?php
            } else {
                echo "<p>User not found</p>";
            }

            // ปิดการเชื่อมต่อ
            $stmt->close();
            $conn->close();
        } else {
            echo "<p>Invalid user ID</p>";
        }
        ?>

    </div>

</body>

</html>
<?php
$content = ob_get_clean();
include '../template/masterblack.php';
?>