<?php
ob_start();
?>
<br>
<div class="row mt-5">
    <div class="col-md-12 text-center">
        <h2>ทรงผม</h2>
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHairModal">
            เพิ่มทรงผม
        </button> -->
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
                        <!-- <th width="10%">รายละเอียด</th> -->
                        <!-- <th width="10%">ลบ</th> -->
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
                            <td><img src="../../BBapi/hair/<?= htmlspecialchars($k['hair_photo']); ?>" width="100" height="100"></td>
                            <td><?= htmlspecialchars($k['ba_name']); ?></td>
                            <!-- <td><button type="button" onclick="showHairDetails(<?= htmlspecialchars($k['hair_id']); ?>)" class="btn btn-warning btn-sm">ดูรายละเอียด</button></td> -->
                            <!-- <td><button type="button" onclick="confirmDeletion('<?= $k['hair_id'] ?>')" class="btn btn-danger btn-circle btn-sm">ลบ</button></td> -->
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal สำหรับเพิ่มข้อมูล -->
<div class="modal fade" id="addHairModal" tabindex="-1" aria-labelledby="addHairModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHairModalLabel">เพิ่มทรงผม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addHairForm">
                    <div class="mb-3">
                        <label for="hair_name" class="form-label">ชื่อทรงผม</label>
                        <input type="text" class="form-control" id="hair_name" name="hair_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="hair_price" class="form-label">ราคา</label>
                        <input type="number" class="form-control" id="hair_price" name="hair_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="hair_photo" class="form-label">รูปภาพ</label>
                        <input type="file" class="form-control" id="hair_photo" name="hair_photo" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal สำหรับดูรายละเอียดทรงผม -->
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
                    url: "http://localhost/Project-main/black_end/hairstlye/deleteProcess.php",
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

document.getElementById('addHairForm').onsubmit = function(event) {
    event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ

    const formData = new FormData(this);

    fetch('insertProcess.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('เกิดข้อผิดพลาดในการเพิ่มข้อมูล');
    });
};

function showHairDetails(hair_id) {
    fetch(`getHairStyleDetail.php?hair_id=${hair_id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('hairDetailsContent').innerHTML = `
                    <table class="table table-bordered">
                        <tr><th>ชื่อทรงผม</th><td>${data.hairstyle.hair_name}</td></tr>
                        <tr><th>ราคา</th><td>${data.hairstyle.hair_price}</td></tr>
                        <tr><th>รูปภาพ</th><td><img src="../../BBapi/hair/${data.hairstyle.hair_photo}" width="100" height="100"></td></tr>
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
function deleteHair(hair_id) {
    fetch('deleteProcess.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ hair_id: hair_id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('ลบ!', 'ข้อมูลของคุณถูกลบแล้ว.', 'success').then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
    });
}

</script>

<?php
$content = ob_get_clean();
include '../template/master.php';
?>
