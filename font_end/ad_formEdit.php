<?php

ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูล</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>แก้ไขข้อมูล</h2>

        <?php
        // ตรวจสอบว่ามีพารามิเตอร์ id ที่ถูกส่งมาหรือไม่
        if (isset($_GET['id'])) {
            $adId = $_GET['id'];

            require_once '../config.php';

            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $stmt = $conn->prepare("SELECT * FROM admin_table WHERE ad_id = ?");
            $stmt->bind_param("i", $adId);
            $stmt->execute();
            $result = $stmt->get_result();

            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if ($result->num_rows > 0) {
                $adData = $result->fetch_assoc();
        ?>
                <form action="../black_end/ad/updateProcess.php" method="POST">
                    <input type="hidden" name="ad_id" value="<?= $adData['ad_id']; ?>">
                    <div class="form-group">
                        <label for="ad_name">ชื่อ:</label>
                        <input type="text" class="form-control" name="ad_name" value="<?= $adData['ad_name']; ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="ad_lastname">นามสกุล:</label>
                        <input type="text" class="form-control" name="ad_lastname" value="<?= $adData['ad_lastname']; ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="ad_email">Email:</label>
                        <input type="email" class="form-control" name="ad_email" value="<?= $adData['ad_email']; ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="ad_password">Password:</label>
                        <input type="password" class="form-control" name="ad_password" required>
                    </div>

                    <button type="button" class="btn btn-primary" id="submitBtn">ยืนยันการแก้ไข</button>

                </form>


    </div>
    <script>
        // When the submit button is clicked
        document.getElementById('submitBtn').addEventListener('click', function(event) {
            // Prevent the default form submission
            event.preventDefault();
            // Show the SweetAlert2 confirmation
            Swal.fire({
                icon: 'success',
                title: 'การแก้ไขเสร็จสมบูรณ์',
                showConfirmButton: false,
                timer: 1500 // Close after 1.5 seconds
            }).then((result) => {
                // If the user clicks on "OK", submit the form
                if (result.dismiss === Swal.DismissReason.timer) {
                    document.querySelector('form').submit();
                }
            });
        });
    </script>
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