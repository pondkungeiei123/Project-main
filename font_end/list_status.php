<?php

ob_start();
?>
<link href="../asset/bootstrap-5.3.2-dist/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Your page-specific content -->
<h2> รายชื่อลูกค้า</h2> <!-- Add a title here -->
<div class="container">
    <div class="row">
        <div class="col-md-12"> <br>
            <h3> </h3>
            <table class="table table-striped table-hover table-responsive table-bordered">
                <thead>
                    <tr>
                        <th width="5%">ลำดับ</th>
                        <th width="40%">user</th>
                        <th width="5%">ตรวจสอบ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ตรงนี้คือข้อมูลที่ถูกดึงมาแสดงในตาราง -->
                    <?php
                    require_once '../config.php';
                    $stmt = $conn->prepare("SELECT * FROM users where status = 0");
                    $stmt->execute();
                    $resultSet = $stmt->get_result();
                    $data = $resultSet->fetch_all(MYSQLI_ASSOC);

                    foreach ($data as $k) {
                    ?>
                        <tr>
                            <td><?= $k['user_id']; ?></td>
                            <td><?= $k['user_email']; ?></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" onclick="openModal('<?= $k['user_id']; ?>')">ตรวจสอบสถานะ</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Status Modal -->
<div class="modal fade" id="Modal_status" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">รายละเอียดสถานะ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="statusModalForm" method="POST">

                </form>
                <!-- Status details will be loaded here -->
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class='col-md-12'>
                        <button type='button' class='btn btn-primary' onclick='submitForm()'>ยืนยันการตรวจสอบ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../asset/bootstrap-5.3.2-dist/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

<script>
    function openModal(id) {
        var userId = id;
        let url = '../black_end/hs/updateProcess.php?id=' + userId
        // Send AJAX request to status.php
        $.ajax({
            type: 'GET',
            url: 'status.php',
            data: {
                user_id: userId
            },
            success: function(data) {
                // Update modal body with status details
                $('#statusModalForm').attr('action', url);
                $('#statusModalForm').html(data);
                $('#Modal_status').modal('show');
                $('#statusModalForm').attr('action', url);
            },
            error: function() {
                alert('Error fetching status details.');
            }
        });
    }
    function submitForm(){
        $('#statusModalForm').submit();
    }
</script>

<?php
$content = ob_get_clean();
include '../template/master.php';
?>