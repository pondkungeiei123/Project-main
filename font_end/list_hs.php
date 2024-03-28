<?php
ob_start();
?>
<!-- Your page-specific content -->
<br>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fe9f6005">
    <h2> รายชื่อช่างตัดผม</h2>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                    เพิ่มข้อมูล
                </button>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
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
                    $stmt = $conn->prepare("SELECT * FROM user_table");
                    $stmt->execute();
                    $resultSet = $stmt->get_result();
                    $data = $resultSet->fetch_all(MYSQLI_ASSOC);

                    foreach ($data as $k) {
                    ?>
                        <tr>
                            <td><?= $k['user_id']; ?></td>
                            <td><?= $k['user_name']; ?></td>
                            <td><?= $k['user_lastname']; ?></td>
                            <td><a href="hs_formEdit.php?id=<?= $k['user_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                            <td><button type="button" onclick="confirmDeletion('<?= $k['user_id'] ?>')" class="btn btn-danger btn-sm">ลบ</button></td>
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
                                <label for="user_name">ชื่อ:</label>
                                <input type="text" class="form-control " id="user_name" name="user_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_lastname">นามสกุล:</label>
                                <input type="text" class="form-control " id="user_lastname" name="user_lastname" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user_idcard">หมายเลขบัตรประชาชน:</label>
                                <input type="text" class="form-control" id="user_idcard" name="user_idcard" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_email">Email:</label>
                                <input type="email" class="form-control " id="user_email" name="user_email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_password">password:</label>
                                <input type="password" class="form-control " id="user_password" name="user_password" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user_address">ที่อยู่ปัจจุบัน:</label>
                                <textarea id="user_address" class="form-control" name="user_address" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_phone">เบอร์ติดต่อ:</label>
                                <input type="text" class="form-control" id="user_phone" name="user_phone" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_Certificate">ส่งใบเซอร์:</label>
                                <input type="file" class="form-control" id="user_Certificate" name="user_Certificate" accept="image/*">
                            </div>
                        </div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d491062.2582593816!2d103.47779549053939!3d15.939224907901758!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3117e5d2164cb387%3A0x102b54113604a50!2z4Lij4LmJ4Lit4Lii4LmA4Lit4LmH4LiU!5e0!3m2!1sth!2sth!4v1711518132877!5m2!1sth!2sth" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_namelocation">ชื่อสถานที่:</label>
                                <input type="text" class="form-control" id="user_namelocation" name="user_namelocation" required>
                            </div>
                        </div>
                        <!-- <div id="map" style="height: 400px; width: 100%;"></div> ปรับขนาดแผนที่ -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_latitude">ละติจูด:</label>
                                <input type="text" class="form-control" id="user_latitude" name="user_latitude" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_longtitude">ลองจิจูด:</label>
                                <input type="text" class="form-control" id="user_longtitude" name="user_longtitude" required>
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
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
<script>
    var map;
    var marker;

    function initMap() {
        var defaultLocation = {lat: 13.7563, lng: 100.5018}; // ตำแหน่งเริ่มต้น (กรุงเทพมหานคร)
        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation,
            zoom: 13
        });

        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function(event) {
            document.getElementById('user_latitude').value = event.latLng.lat();
            document.getElementById('user_longitude').value = event.latLng.lng();
        });
    }

    // Function to handle the form submission for adding a new user
    function submitForm() {
        // ส่งข้อมูลฟอร์มผ่าน AJAX
    }
</script>
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
            // If the user clicks "Yes, delete it!"
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: "http://localhost/Project-main/black_end/hs/deleteProcess.php",
                    data: {
                        user_id: id
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
                        console.log(xhr.responseText);
                    }
                });
            } else {
                // If the user clicks "Cancel" or closes the dialog
                Swal.fire('ยกเลิกสำเร็จ');
            }
        });
    }

    // Function to handle the form submission for adding a new user
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