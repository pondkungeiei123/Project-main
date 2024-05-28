<?php

ob_start();
?>


<div class="row mt-5">
    <div class="col-md-12 text-center">
        <h2> รายชื่อผู้ใช้งานระบบ</h2>
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
    <div class="row">
        <div class="col-md-12"> <br>
            <h3> </h3>
            <table class="table table-striped table-hover table-responsive table-bordered">
                <thead>
                    <tr>
                        <th width="5%">ลำดับ</th>
                        <th width="40%">ชื่อ</th>
                        <th width="45%">นามสกุล</th>
                        <th colspan="2">แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ตรงนี้คือข้อมูลที่ถูกดึงมาแสดงในตาราง -->
                    <?php
                    require_once '../config.php';
                    $stmt = $conn->prepare("SELECT * FROM admin");
                    $stmt->execute();
                    $resultSet = $stmt->get_result();
                    $data = $resultSet->fetch_all(MYSQLI_ASSOC);
                    foreach ($data as $k) {
                    ?>
                        <tr>
                            <td><?= $k['ad_id']; ?></td>
                            <td><?= $k['ad_name']; ?></td>
                            <td><?= $k['ad_lastname']; ?></td>
                            <td>
                                <a href="ad_formEdit.php?id=<?= $k['ad_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                                <!-- <button type="button" onclick="edit('<?= $k['ad_id'] ?>')" class="btn btn-warning btn-sm">แก้ไข</button> -->
                                <button type="button" onclick="confirmDeletion('<?= $k['ad_id'] ?>')" class="btn btn-danger btn-circle btn-sm">ลบ</button>
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

<div class="modal fade" id="addUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModal">รายชื่อผู้ใช้งานระบบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="POST">
                    <div class="form-group">
                        <label for="ad_name">ชื่อ:</label>
                        <input type="text" class="form-control" id="ad_name" name="ad_name" required>
                    </div>
                    <div class="form-group">
                        <label for="ad_lastname">นามสกุล:</label>
                        <input type="text" class="form-control" id="ad_lastname" name="ad_lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="ad_email">Email:</label>
                        <input type="email" class="form-control" id="ad_email" name="ad_email" required>
                    </div>
                    <div class="form-group">
                        <label for="ad_password">Password:</label>
                        <input type="password" class="form-control" id="ad_password" name="ad_password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submitForm()">เพิ่มพนักงาน</button>
            </div>
        </div>
    </div>
</div>


<script>
    function confirmDeletion(id) {
        // Use SweetAlert2 to create a confirmation dialog
        Swal.fire({
            title: 'ต้องการลบจริงมั้ย?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: "http://localhost/Project-main/black_end/ad/deleteProcess.php",
                    data: {
                        ad_id: id
                    },
                    dataType: "json",
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire('ลบ!', 'ข้อมูลของคุณถูกลบแล้ว.', 'success').then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Error', 'ไม่สามารถลบได้เนื่องจากมีการใช้งานอยู่', 'error').then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    },
                });

            } else {
                Swal.fire('ยกเลิก', 'ยกเลิกการลบแล้ว', 'info');
            }
        });
    }

    function submitForm() {
        
        var ad_name = $('#ad_name').val();
        var ad_lastname = $('#ad_lastname').val();
        var ad_email = $('#ad_email').val();
        var ad_password = $('#ad_password').val();
        if (ad_name != "" && ad_lastname != "" && ad_email != "" && ad_password) {
            var formData = new FormData($('#addUserForm')[0]);
            $.ajax({
                method: 'POST',
                url: "http://localhost/Project-main/black_end/ad/insertProcess.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(result) {
                    console.log(result);
                    if (result.success === true) {
                        Swal.fire({
                            title: "เพิ่ม",
                            text: "เพิ่มรายการสำเร็จ",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: result.message,
                            icon: "error"
                        });
                    }
                },
                
            });
        } else {
            Swal.fire({
                title: "กรอกข้อมูลไม่ครบถ้วน",
                icon: "warning"
            });
        }

    }
</script>
<!-- ... -->
<?php
$content = ob_get_clean();
include '../template/master.php';
?>