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
            $cusId = $_GET['id'];

            require_once '../config.php';

            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $stmt = $conn->prepare("SELECT * FROM customer_table WHERE cus_id = ?");
            $stmt->bind_param("i", $cusId);
            $stmt->execute();
            $result = $stmt->get_result();

            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if ($result->num_rows > 0) {
                $cusData = $result->fetch_assoc();
        ?>
                <form action="../black_end/cus/updateProcess.php" method="POST">
                    <input type="hidden" name="cus_id" value="<?= $cusData['cus_id']; ?>">
                    <div class="form-group">
                        <label for="cus_name">ชื่อ:</label>
                        <input type="text" class="form-control" name="cus_name" value="<?= $cusData['cus_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cus_lastname">นามสกุล:</label>
                        <input type="text" class="form-control" name="cus_lastname" value="<?= $cusData['cus_lastname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cus_email">Email:</label>
                        <input type="email" class="form-control" name="cus_email" value="<?= $cusData['cus_email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cus_password">Password:</label>
                        <input type="password" class="form-control" name="cus_password" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="cus_gender">เพศ:</label>
                        <select class="form-control" name="cus_gender" required>
                            <option value="male" <?= ($cusData['cus_gender'] === 'male') ? 'selected' : ''; ?>>ชาย</option>
                            <option value="female" <?= ($cusData['cus_gender'] === 'female') ? 'selected' : ''; ?>>หญิง</option>
                        </select>
                    </div> -->
                    <!-- <div class="form-group">
                        <label for="cus_address">ที่อยู่:</label>
                        <textarea class="form-control" name="cus_address" rows="3" required><?= $cusData['cus_address']; ?></textarea>
                    </div> -->
                    <div class="form-group">
                        <label for="cus_phone">เบอร์โทรศัพท์:</label>
                        <input type="tel" class="form-control" name="cus_phone" value="<?= $cusData['cus_phone']; ?>" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="cus_age">อายุ:</label>
                        <input type="number" class="form-control" name="cus_age" value="<?= $cusData['cus_age']; ?>" required>
                    </div> -->
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