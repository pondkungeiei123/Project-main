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
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #fe9f602e;
            margin: 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>เเก้ไขช่างตัดผม</h2>

        <?php
        // ตรวจสอบว่ามีพารามิเตอร์ id ที่ถูกส่งมาหรือไม่
        if (isset($_GET['id'])) {
            $baId = $_GET['id'];

            require_once '../config.php';

            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $stmt = $conn->prepare("SELECT * FROM barber WHERE ba_id = ?");
            $stmt->bind_param("i", $baId);
            $stmt->execute();
            $result = $stmt->get_result();

            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if ($result->num_rows > 0) {
                $baData = $result->fetch_assoc();
        ?>
                <form action="../black_end/hs/updateProcess.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="ba_id" value="<?= $baData['ba_id']; ?>">
                    <div class="row">
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_name">ชื่อ:</label>
                                <input type="text" class="form-control" name="ba_name" value="<?= $baData['ba_name']; ?>" required readonly>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_lastname">นามสกุล:</label>
                                <input type="text" class="form-control" name="ba_lastname" value="<?= $baData['ba_lastname']; ?>" required readonly>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_email">Email:</label>
                                <input type="email" class="form-control" name="ba_email" value="<?= $baData['ba_email']; ?>" required readonly>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_password">Password:</label>
                                <input type="password" class="form-control" name="ba_password" required disabled>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_phone">เบอร์โทรศัพท์:</label>
                                <input type="phone" class="form-control" name="ba_phone" value="<?= $baData['ba_phone']; ?>" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ba_namelocation">ชื่อสถานที่:</label>
                                <input type="text" class="form-control" id="ba_namelocation" name="ba_namelocation" value="<?= isset($baData['ba_namelocation']) ? $baData['ba_namelocation'] : ''; ?>" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ba_longitude">ลองจิจูด:</label>
                                <input type="text" class="form-control" id="ba_longitude" name="ba_longitude" value="<?= isset($baData['ba_longitude']) ? $baData['ba_longitude'] : ''; ?>" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ba_longitude">ลองจิจูด:</label>
                                <input type="text" class="form-control" id="ba_longitude" name="ba_longitude" value="<?= isset($baData['ba_longitude']) ? $baData['ba_longitude'] : ''; ?>" required readonly>
                            </div>
                        </div>

                        <div class=" col-md-12 ">
                            <div class="form-group">
                                <label for='ba_certificate'>ใบเซอร์:</label>
                                <?php
                                echo "<img src='../asset/Certificate/" . $baData['ba_certificate'] . "' style='width:400px;heigh:400px;'>";
                                ?>

                            </div>
                        </div>

                        <button type="button" class="btn btn-primary" id="submitBtn">ยืนยันการแก้ไข</button>
                        <a href="./list_hs.php" class="btn btn-secondary">ย้อนกลับ</a>

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
                // If the ba clicks on "OK", submit the form
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
            echo "<p>Invalid ba ID</p>";
        }
?>

</body>

</html>
<?php
$content = ob_get_clean();
include '../template/masterblack.php';
?>