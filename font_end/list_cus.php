<?php 
ob_start();
?>

<div class="row mt-5">
    <div class="col-md-12 text-center">
        <h2>รายชื่อลูกค้า</h2>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12"> <br>
            <h3></h3>
            <table class="table table-striped table-hover table-responsive table-bordered">
                <thead>
                    <tr>
                        <th width="50%">ชื่อ</th>
                        <th width="55%">นามสกุล</th>
                        <th width="25%">ดูรายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ตรงนี้คือข้อมูลที่ถูกดึงมาแสดงในตาราง -->
                    <?php
                    require_once '../config.php';
                    $stmt = $conn->prepare("SELECT * FROM customer");
                    $stmt->execute();
                    $resultSet = $stmt->get_result();
                    $data = $resultSet->fetch_all(MYSQLI_ASSOC);
                    foreach ($data as $k) {
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($k['cus_name']); ?></td>
                            <td><?= htmlspecialchars($k['cus_lastname']); ?></td>
                            <td>
                                <button type="button" onclick="showDetails(<?= htmlspecialchars($k['cus_id']); ?>)" class="btn btn-warning btn-sm">ดูรายละเอียด</button>
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

<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- เพิ่มคลาส modal-lg เพื่อขยายขนาด modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">รายละเอียดลูกค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailsContent">
                <!-- ข้อมูลรายละเอียดลูกค้าจะแสดงที่นี่ -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-dialog {
        max-width: 60%; /* ปรับความกว้างของ modal ตามที่ต้องการ */
    }

    #detailsContent table {
        width: 100%; /* ทำให้ตารางขยายเต็มความกว้างของ modal */
    }
</style>

<script>
function showDetails(id) {
    fetch(`get_detailcus.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('detailsContent').innerHTML = `
                    <table class="table table-bordered">
                        <tr><th>ชื่อ</th><td>${data.customer.cus_name}</td></tr>
                        <tr><th>นามสกุล</th><td>${data.customer.cus_lastname}</td></tr>
                        <tr><th>อีเมล</th><td>${data.customer.cus_email}</td></tr>
                        <tr><th>เบอร์โทรศัพท์</th><td>${data.customer.cus_phone}</td></tr>
                        <tr><th>จำนวนการใช้บริการ</th><td>${data.customer.total_visits} ครั้ง</td></tr>
                        <tr><th>รายได้รวม</th><td>${data.customer.total_amount} บาท</td></tr>
                    </table>
                `;
                new bootstrap.Modal(document.getElementById('detailsModal')).show();
            } else {
                alert('ไม่พบข้อมูลลูกค้า');
            }
        });
}
</script>

<?php
$content = ob_get_clean();
include '../template/master.php';
?>
