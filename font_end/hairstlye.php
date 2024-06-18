<?php
ob_start();
?>
<br>
<div class="row mt-5">
    <div class="col-md-12 text-center">
        <h2>ทรงผม</h2>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12"><br>
            <h3></h3>
            <table class="table table-striped table-hover table-responsive table-bordered">
                <thead>
                    <tr>
                        <th width="20%">ชื่อทรงผม</th>
                        <th width="20%">ราคา</th>
                        <th width="20%">รูปภาพ</th>
                        <th width="20%">ช่างตัดผม</th>
                        <th width="10%">รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once '../config.php';
                    $stmt = $conn->prepare("
                        SELECT h.hair_id, h.hair_name, h.hair_price, h.hair_photo, b.ba_name
                        FROM hairstlye h
                        JOIN barber b ON h.ba_id = b.ba_id
                    ");
                    $stmt->execute();
                    $resultSet = $stmt->get_result();
                    $data = $resultSet->fetch_all(MYSQLI_ASSOC);

                    foreach ($data as $k) {
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($k['hair_name']); ?></td>
                            <td><?= htmlspecialchars($k['hair_price']); ?></td>
                            <td><img src="../asset/Photo/<?= htmlspecialchars($k['hair_photo']); ?>" width="100" height="100"></td>
                            <td><?= htmlspecialchars($k['ba_name']); ?></td>
                            <td><button type="button" onclick="showHairDetails(<?= htmlspecialchars($k['hair_id']); ?>)" class="btn btn-warning btn-sm">ดูรายละเอียด</button></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="hairDetailsModal" tabindex="-1" aria-labelledby="hairDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hairDetailsModalLabel">รายละเอียดทรงผม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="hairDetailsContent">
                <!-- ข้อมูลรายละเอียดทรงผมจะแสดงที่นี่ -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
function showHairDetails(hair_id) {
    fetch(`getHairStyleDetail.php?hair_id=${hair_id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('hairDetailsContent').innerHTML = `
                    <table class="table table-bordered">
                        <tr><th>ชื่อทรงผม</th><td>${data.hairstyle.hair_name}</td></tr>
                        <tr><th>ราคา</th><td>${data.hairstyle.hair_price}</td></tr>
                        <tr><th>รูปภาพ</th><td><img src="../asset/Photo/${data.hairstyle.hair_photo}" width="100" height="100"></td></tr>
                        <tr><th>ช่างตัดผม</th><td>${data.hairstyle.ba_name}</td></tr>
                    </table>
                `;
                new bootstrap.Modal(document.getElementById('hairDetailsModal')).show();
            } else {
                alert('ไม่พบข้อมูลทรงผม');
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
        });
}
</script>

<?php
$content = ob_get_clean();
include '../template/master.php';
?>
