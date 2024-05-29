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
        <h2>เเก้ไขทรงผม</h2>

        <?php
        // Check if the 'id' parameter is set
        if (isset($_GET['id'])) {
            $hair_id = $_GET['id'];

            require_once '../config.php';

            // Retrieve user data from the database
            $stmt = $conn->prepare("SELECT * FROM hairstlye WHERE hair_id = ?");
            $stmt->bind_param("i", $hair_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if data exists
            if ($result->num_rows > 0) {
                $adData = $result->fetch_assoc();
        ?>
                <form action="../black_end/hairstlye/updateProcess.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="hair_id" value="<?= $adData['hair_id']; ?>">
                    <div class="form-group">
                        <label for="hair_name">ชื่อทรงผม:</label>
                        <input type="text" class="form-control" name="hair_name" value="<?= $adData['hair_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hair_price">ราคา:</label>
                        <input type="text" class="form-control" name="hair_price" value="<?= $adData['hair_price']; ?>" required>
                    </div>
                    <div class=" form-group ">
                            <div class="form-group">
                                <label for='hair_photo'>รูปทรงผม:</label>
                                <?php
                                echo "<img src='../asset/Photo/" . $adData['hair_photo'] . "' style='width:400px;height:400px;'>";
                                ?>

                            </div>
                        </div>

                    <div class="form-group">
                        <label for="name_test">ช่างตัดผม:</label>
                        <input type="text" class="form-control" name="name_test" value="<?= $adData['name_test']; ?>">
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