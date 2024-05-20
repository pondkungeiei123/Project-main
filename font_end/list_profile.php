<?php
ob_start();
?>
<!-- Your page-specific content -->
<h2> รายชื่อช่างตัดผม</h2> <!-- Add a title here -->
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
                    $stmt = $conn->prepare("SELECT * FROM barber");
                    $stmt->execute();
                    $resultSet = $stmt->get_result();
                    $data = $resultSet->fetch_all(MYSQLI_ASSOC);

                    foreach ($data as $k) {
                    ?>
                        <tr>
                            <td><?= $k['ba_id']; ?></td>
                            <td><?= $k['ba_name']; ?></td>
                            <td><?= $k['ba_lastname']; ?></td>
                            <td><a href="hs_formEdit.php?id=<?= $k['ba_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                            <td><button type="button" onclick="confirmDeletion('<?= $k['ba_id'] ?>')" class="btn btn-danger btn-sm">ลบ</button></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">เพิ่มข้อมูลช่างตัดผม</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " style="max-height: 5000px; overflow-y: auto;">
                <form id="resumeForm" action="/black_end/hs/insertProcess.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ba_name">ชื่อ:</label>
                                <input type="text" class="form-control " id="ba_name" name="ba_name" required>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_lastname">นามสกุล:</label>
                                <input type="text" class="form-control " id="ba_lastname" name="ba_lastname" required>
                            </div>
                        </div>

                        <div class=" col-md-5 ">
                            <div class="form-group">
                                <label for="ba_birthdate">วัน-เดือน-ปีเกิด:</label>
                                <input type="date" class="form-control" id="ba_birthdate" name="ba_birthdate" required>
                            </div>
                        </div>
                        <div class=" col-md-3 ">
                            <div class="form-group">
                                <label for="ba_age">อายุ:</label>
                                <input type="text " class="form-control" id="ba_age" name="ba_age" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="ba_gender">เพศ:</label>
                                <select class="form-select" id="ba_gender" name="ba_gender" required>
                                    <option value="male">ชาย</option>
                                    <option value="female">หญิง</option>
                                </select>
                            </div>
                        </div>
                        <div class=" col-md-12 ">
                            <div class="form-group">
                                <label for="ba_idcard">หมายเลขบัตรประชาชน:</label>
                                <input type="text" class="form-control" id="ba_idcard" name="ba_idcard" required>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_email">Email:</label>
                                <input type="email" class="form-control " id="ba_email" name="ba_email" required>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_password">password:</label>
                                <input type="password" class="form-control " id="ba_password" name="ba_password" required>
                            </div>
                        </div>

                        <div class=" col-md-12 ">
                            <div class="form-group">
                                <label for="ba_address">ที่อยู่ปัจจุบัน:</label>
                                <textarea id="ba_address" class="form-control" name="ba_address" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_nationality">สัญชาติ:</label>
                                <input type="text" class="form-control" id="ba_nationality" name="ba_nationality" required>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_religion">ศาสนา:</label>
                                <input type="text" class="form-control" id="ba_religion" name="ba_religion" required>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_phone">เบอร์ติดต่อ:</label>
                                <input type="text" class="form-control" id="ba_phone" name="ba_phone" required>
                            </div>
                        </div>

                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="ba_certificate">ส่งใบเซอร์:</label>
                                <input type="file" class="form-control" id="ba_certificate" name="ba_certificate" accept="image/*">
                            </div>
                        </div>
                    </div>

                </form>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="button" class="btn btn-success" onclick="submitForm()">ส่งใบสมัคร</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Include SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Function to handle the confirmation dialog for deletion
    function confirmDeletion(id) {
        // Use SweetAlert2 to create a confirmation dialog
        Swal.fire({
            title: 'ต้องการลบหรือไม่!',
            text: 'คุณต้องการที่จะลบหรือไปไม่!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่ ต้องการลบ',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            // If the ba clicks "Yes, delete it!"
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: "http://localhost/Project-main/black_end/hs/deleteProcess.php",
                    data: {
                        ba_id: id
                    },
                    dataType: "json",
                    success: function(result) {
                        // Display a success message to the ba
                        Swal.fire('Deleted!', 'Your data has been deleted.', 'success').then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Display a ba-friendly error message
                        Swal.fire('Error', 'An error occurred while deleting data.', 'error');
                        console.error("Ajax request failed:", status, error);
                        console.log(xhr.responseText);
                    }
                });
            } else {
                // If the ba clicks "Cancel" or closes the dialog
                Swal.fire('ยกเลิกสำเร็จ');
            }
        });
    }

    // Function to handle the form submission for adding a new ba
    function submitForm() {
    var formData = new FormData($('#resumeForm')[0]);

    $.ajax({
        method: 'POST',
        url: "http://localhost/Project-main/black_end/hs/insertProcess.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(result) {
            console.log(result);  // 
            if (result.success === true) {
                Swal.fire({
                    title: "เพิ่มสำเร็จ",
                    text: "เพิ่มผู้ใช้เรียบร้อยแล้ว",
                    icon: "success"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    title: "เพิ่มไม่สำเร็จ",
                    text: "เพิ่มผู้ใช้ไม่เรียบร้อยแล้ว: " + result.message,
                    icon: "error"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    };
                });
            }
        },
        error: function(xhr, status, error) {
            console.error("Ajax request failed:", status, error);
            console.log(xhr.responseText);
        }
    });
}
</script>
<!-- ... -->
<?php
$content = ob_get_clean();
include '../template/master.php';
?>