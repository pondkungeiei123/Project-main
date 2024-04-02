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
        <h2>เเก้ไขช่างตัดผม</h2>

        <?php
        // ตรวจสอบว่ามีพารามิเตอร์ id ที่ถูกส่งมาหรือไม่
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];

            require_once '../config.php';

            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $stmt = $conn->prepare("SELECT * FROM user_table WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if ($result->num_rows > 0) {
                $userData = $result->fetch_assoc();
        ?>
                <form action="../black_end/hs/updateProcess.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?= $userData['user_id']; ?>">
                    <div class="row">
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_name">ชื่อ:</label>
                                <input type="text" class="form-control" name="user_name" value="<?= $userData['user_name']; ?>" required readonly>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_lastname">นามสกุล:</label>
                                <input type="text" class="form-control" name="user_lastname" value="<?= $userData['user_lastname']; ?>" required readonly>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_email">Email:</label>
                                <input type="email" class="form-control" name="user_email" value="<?= $userData['user_email']; ?>" required readonly>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_password">Password:</label>
                                <input type="password" class="form-control" name="user_password" required disabled>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_phone">เบอร์โทรศัพท์:</label>
                                <input type="phone" class="form-control" name="user_phone" value="<?= $userData['user_phone']; ?>" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_namelocation">ชื่อสถานที่:</label>
                                <input type="text" class="form-control" id="user_namelocation" name="user_namelocation" value="<?= isset($userData['user_namelocation']) ? $userData['user_namelocation'] : ''; ?>" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_longitude">ลองจิจูด:</label>
                                <input type="text" class="form-control" id="user_longitude" name="user_longitude" value="<?= isset($userData['user_longitude']) ? $userData['user_longitude'] : ''; ?>" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_longitude">ลองจิจูด:</label>
                                <input type="text" class="form-control" id="user_longitude" name="user_longitude" value="<?= isset($userData['user_longitude']) ? $userData['user_longitude'] : ''; ?>" required readonly>
                            </div>
                        </div>

                        <div class=" col-md-12 ">
                            <div class="form-group">
                                <label for='user_Certificate'>ใบเซอร์:</label>
                                <?php
                                echo "<img src='../asset/Certificate/" . $userData['user_Certificate'] . "' style='width:400px;heigh:400px;'>";
                                ?>

                            </div>
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

</body>

</html>
<?php
$content = ob_get_clean();
include '../template/masterblack.php';
?>