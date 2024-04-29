<?php

ob_start();
?>
<!-- Your page-specific content -->
<br>
<h2> รายชื่อลูกค้า</h2> <!-- Add a title here -->
<div class="container">
    <div class="row">
        <div class="col-md-12"> <br>
            <h3> </h3>
            <table class="table table-striped table-hover table-responsive table-bordered">
                <thead>
                    <tr>
                        <th width="5%">ลำดับ</th>
                        <th width="40%">ชื่อ</th>
                        <th width="45%">นามสกุล</th>
                        <th width="5%">แก้ไข</th>
                        <th width="5%">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ตรงนี้คือข้อมูลที่ถูกดึงมาแสดงในตาราง -->
                    <?php
                    require_once '../config.php';
                    $stmt = $conn->prepare("SELECT * FROM customer_table");
                    $stmt->execute();
                    $resultSet = $stmt->get_result();
                    $data = $resultSet->fetch_all(MYSQLI_ASSOC);

                    foreach ($data as $k) {
                    ?>
                        <tr>
                            <td><?= $k['cus_id']; ?></td>
                            <td><?= $k['cus_name']; ?></td>
                            <td><?= $k['cus_lastname']; ?></td>
                            <td><a href="cus_formEdit.php?id=<?= $k['cus_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                            <td><button type="button" onclick="confirmDeletion('<?= $k['cus_id'] ?>')" class="btn btn-danger btn-sm">ลบ</ิ>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">เพิ่มข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="POST">
                    <div class="form-group">
                        <label for="cus_name">ชื่อ:</label>
                        <input type="text" class="form-control" name="cus_name" required>
                    </div>
                    <div class="form-group">
                        <label for="cus_lastname">นามสกุล:</label>
                        <input type="text" class="form-control" name="cus_lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="cus_email">Email:</label>
                        <input type="email" class="form-control" name="cus_email" required>
                    </div>
                    <div class="form-group">
                        <label for="cus_password">Password:</label>
                        <input type="password" class="form-control" name="cus_password" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="cus_gender">เพศ:</label>
                        <select class="form-control" name="cus_gender" required>
                            <option value="male">ชาย</option>
                            <option value="female">หญิง</option>
                        </select>
                    </div> -->
                    <!-- <div class="form-group">
                        <label for="cus_address">ที่อยู่:</label>
                        <textarea class="form-control" name="cus_address" rows="3" required></textarea>
                    </div> -->
                    <div class="form-group">
                        <label for="cus_phone">เบอร์โทรศัพท์:</label>
                        <input type="tel" class="form-control" name="cus_phone" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="cus_age">อายุ:</label>
                        <input type="number" class="form-control" name="cus_age" required>
                    </div> -->
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDeletion(id) {
        // Use SweetAlert2 to create a confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            // If the user clicks "Yes, delete it!"
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: "http://localhost/Project-main/black_end/cus/deleteProcess.php",
                    // Ensure proper validation on the server for cus_id
                    data: {
                        cus_id: id
                    },
                    dataType: "json",
                    success: function(result) {
                        // Display a success message to the user
                        Swal.fire('Deleted!', 'Your data has been deleted.', 'success').then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Display a user-friendly error message
                        Swal.fire('Error', 'An error occurred while deleting data.', 'error');
                        console.error("Ajax request failed:", status, error);
                        console.log(xhr.responseText); // Log the entire response for debugging
                    }
                });

            } else {
                // If the user clicks "Cancel" or closes the dialog
                Swal.fire('Cancelled', 'Your data is safe :)', 'info');
            }
        });
    }

    function submitForm() {
        var formData = new FormData($('#addUserForm')[0]);

        $.ajax({
            method: 'POST',
            url: "http://localhost/Project-main/black_end/cus/insertProcess.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.log(result);
                if (result.success === true) {
                    Swal.fire({
                        title: "Success",
                        text: "User added successfully",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                    // $('#addUserModal').modal('hide');
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Error: " + result.message,
                        icon: "error"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Ajax request failed:", status, error);
                console.log(xhr.responseText); // บันทึกการตอบสนองทั้งหมด
            }
        });
    }
</script>
<!-- ... -->
<?php
$content = ob_get_clean();
include '../template/master.php';
?>