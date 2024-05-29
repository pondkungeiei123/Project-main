<?php

ob_start();
?>
<br>
<div class="row mt-5">
    <div class="col-md-12 text-center">
        <h2> ทรงผม</h2>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                เพิ่มข้อมูล
            </button>
        </div>
    </div>
<!-- Your page-specific content -->

<!-- Add a title here -->
<div class="container">
    <div class="row">
        <div class="col-md-12"> <br>
            <h3> </h3>
            <table class="table table-striped table-hover table-responsive table-bordered">
                <thead>
                    <tr>
                        <th width="5%">ลำดับ</th>
                        <th width="20%">ชื่อทรงผม</th>
                        <th width="20%">ราคา</th>
                        <th width="20%">รูปภาพ</th>
                        <th width="20%">ช่างตัดผม</th>
                        <th width="5%">แก้ไข</th>
                        <th width="5%">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ตรงนี้คือข้อมูลที่ถูกดึงมาแสดงในตาราง -->
                    <?php
                    require_once '../config.php';
                    $stmt = $conn->prepare("SELECT * FROM hairstlye");
                    $stmt->execute();
                    $resultSet = $stmt->get_result();
                    $data = $resultSet->fetch_all(MYSQLI_ASSOC);

                    foreach ($data as $k) {
                    ?>
                    
                        <tr>
                           
                            <td><?= $k['hair_id']; ?></td>
                            <td><?= $k['hair_name']; ?></td>
                            <td><?= $k['hair_price']; ?></td>
                            <td><img src="../asset/Photo/<?= $k['hair_photo']; ?>" width="100" height="100"></td>
                            <td><?= $k['name_test']; ?></td>
                            <td><a href="hairstlye_formEdit.php?id=<?= $k['hair_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                            <td><button type="button" onclick="confirmDeletion('<?= $k['hair_id'] ?>')" class="btn btn-danger btn-circle btn-sm">ลบ</button></td>
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
                    <h5 class="modal-title" id="addUserModalLabel">เพิ่มทรงผม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" method="POST">
                        <div class="form-group">
                            <label for="hair_name">ชื่อทรงผม:</label>
                            <input type="text" class="form-control" name="hair_name" required>
                        </div>
                        <div class="form-group">
                            <label for="hair_price">ราคา:</label>
                            <input type="text" class="form-control" name="hair_price" required>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hair_photo">รูปภาพ:</label>
                                <input type="file" class="form-control" id="hair_photo" name="hair_photo" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name_test">ชื่อช่างตัดผม:</label>
                            <input type="text" class="form-control" name="name_test" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="submitForm()">ส่งข้อมูล </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    function confirmDeletion(id) {
        // Use SweetAlert2 to create a confirmation dialog
        Swal.fire({
            title: 'ต้องการลบจริงมั้ย',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            // If the user clicks "Yes, delete it!"
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: "http://localhost/Project-main/black_end/hairstlye/deleteProcess.php",
                    // Ensure proper validation on the server for ad_id
                    data: {
                        hair_id: id
                    },
                    dataType: "json",
                    success: function(result) {
                        // Display a success message to the user
                        Swal.fire('ลบ!', 'ข้อมูลของคุณถูกลบแล้ว.', 'success').then((result) => {
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
                Swal.fire('ยกเลิก', 'ยกเลิกการลบแล้ว', 'info');
            }
        });
    }

    function submitForm() {
        var formData = new FormData($('#addUserForm')[0]);

        $.ajax({
            method: 'POST',
            url: "http://localhost/Project-main/black_end/hairstlye/insertProcess.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.log(result);
                if (result.success === true) {
                    Swal.fire({
                        title: "เพิ่ม",
                        text: "เพิ่มทรงผมสำเร็จแล้ว",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                    // $('#addUserModal').modal('hide');
                } else {
                // If the user clicks "Cancel" or closes the dialog
                Swal.fire('ยกเลิก', 'ยกเลิกการลบแล้ว', 'info');
            }
        }
        });
    }

    function submitForm() {
        var formData = new FormData($('#addUserForm')[0]);

        $.ajax({
            method: 'POST',
            url: "http://localhost/Project-main/black_end/hairstlye/insertProcess.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                console.log(result);
                if (result.success === true) {
                    Swal.fire({
                        title: "เพิ่ม",
                        text: "เพิ่มทรงผมสำเร็จแล้ว",
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