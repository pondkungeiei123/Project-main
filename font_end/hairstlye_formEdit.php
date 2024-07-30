<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hairstyle</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
        <h2>แก้ไขทรงผม</h2>

        <?php
        if (isset($_GET['id'])) {
            $hair_id = $_GET['id'];

            require_once '../config.php';

            $stmt = $conn->prepare("
                SELECT h.hair_id, h.hair_name, h.hair_price, h.hair_photo, b.ba_name
                FROM hairstlye h
                JOIN barber b ON h.ba_id = b.ba_id
                WHERE h.hair_id = ?
            ");
            $stmt->bind_param("i", $hair_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $adData = $result->fetch_assoc();
        ?>
                <form action="../black_end/hairstlye/updateProcess.php" method="POST" enctype="multipart/form-data" id="updateForm">
                    <input type="hidden" name="hair_id" value="<?= $adData['hair_id']; ?>">
                    <div class="form-group">
                        <label for="hair_name">ชื่อทรงผม:</label>
                        <input type="text" class="form-control" name="hair_name" value="<?= $adData['hair_name']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="hair_price">ราคา:</label>
                        <input type="text" class="form-control" name="hair_price" value="<?= $adData['hair_price']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for='hair_photo'>รูปทรงผม:</label>
                        <img src='../asset/Photo/<?= $adData['hair_photo']; ?>' style='width:400px;height:400px;'>
                        <div class="mt-2">
                            <label for="new_hair_photo">อัปโหลดรูปใหม่:</label>
                            <input type="file" class="form-control" name="new_hair_photo" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ba_name">ช่างตัดผม:</label>
                        <input type="text" class="form-control" name="ba_name" value="<?= $adData['ba_name']; ?>" disabled>
                    </div>
                    <button type="button" class="btn btn-primary" id="submitBtn">ยืนยันการแก้ไข</button>
                    <a href="./hairstlye.php" class="btn btn-secondary">ย้อนกลับ</a>
                </form>
    </div>
    <script>
        document.getElementById('submitBtn').addEventListener('click', function(event) {
            event.preventDefault();

            // Get form inputs
            const hairPrice = document.querySelector('input[name="hair_price"]').value.trim();

            // Check if all required fields are filled
            if (hairPrice === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'ข้อมูลไม่ครบถ้วน',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน'
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'การแก้ไขเสร็จสมบูรณ์',
                    showConfirmButton: false,
                    timer: 1000
                }).then((result) => {
                    document.getElementById('updateForm').submit();
                });
            }
        });
    </script>
<?php
            } else {
                echo "<p>User not found</p>";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "<p>Invalid ID</p>";
        }
?>
</body>

</html>
<?php
$content = ob_get_clean();
include '../template/masterblack.php';
?>
