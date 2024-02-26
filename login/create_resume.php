<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Resume</title>
    <link href="../asset/bootstrap-5.3.2-dist/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h2>Create Resume</h2>
            </div>
            <div class="card-body">
                <form id="resumeForm" action="../black_end/hs/insertProcess.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_name">ชื่อ:</label>
                                <input type="text" class="form-control " id="user_name" name="user_name" required>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_lastname">นามสกุล:</label>
                                <input type="text" class="form-control " id="user_lastname" name="user_lastname" required>
                            </div>
                        </div>

                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="birthdate">วัน-เดือน-ปีเกิด:</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_age">อายุ:</label>
                                <input type="text " class="form-control" id="user_age" name="user_age" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_gender">เพศ:</label>
                                <select class="form-select" id="user_gender" name="user_gender" required>
                                    <option value="male">ชาย</option>
                                    <option value="female">หญิง</option>
                                </select>
                            </div>
                        </div>
                        <div class=" col-md-4 ">
                            <div class="form-group">
                                <label for="id_card">หมายเลขบัตรประชาชน:</label>
                                <input type="text" class="form-control" id="id_card" name="id_card" required>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_email">Email:</label>
                                <input type="email" class="form-control " id="user_email" name="user_email" required>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_password">password:</label>
                                <input type="password" class="form-control " id="user_password" name="user_password" required>
                            </div>
                        </div>
      
                        <div class=" col-md-8 ">
                            <div class="form-group">
                                <label for="user_address">ที่อยู่ปัจจุบัน:</label>
                                <textarea id="user_address" class="form-control" name="user_address" rows="3" required></textarea>
                            </div>
                        </div>
                        
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_nationality">สัญชาติ:</label>
                                <input type="text" class="form-control" id="user_nationality" name="user_nationality" required>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_religion">ศาสนา:</label>
                                <input type="text" class="form-control" id="user_religion" name="user_religion" required>
                            </div>
                        </div>
                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_tel">เบอร์ติดต่อ:</label>
                                <input type="text" class="form-control" id="user_tel" name="user_tel" required>
                            </div>
                        </div>

                        <div class=" col-md-6 ">
                            <div class="form-group">
                                <label for="user_Certificate">ส่งใบเซอร์:</label>
                                <input type="file" class="form-control" id="user_Certificate" name="user_Certificate" accept="image/*">
                            </div>
                        </div>
                    </div>
                    
                </form>
                
            </div>
            <div class="card-footer text-end">
                        <button type="button" class="btn btn-success" onclick="submitForm()">ส่งใบสมัคร</button>
                </div>
        </div>
    </div>

</body>
<script src="../asset/bootstrap-5.3.2-dist/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function submitForm() {
        document.getElementById('resumeForm').submit();
        // ทำการส่งค่าแบบ Ajax หรือในที่นี้คุณสามารถใช้โค้ดที่คุณมีแล้ว
        // เมื่อสำเร็จ, ให้แสดง SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'สมัครเรียบร้อยแล้ว',
            text: 'ขอบคุณที่สมัครงานกับเรา!',
            showConfirmButton: false,
            timer: 2000 // หน่วยเป็นมิลลิวินาที (ในที่นี้คือ 2 วินาที)
        }).then((result) => {
            // หลังจาก SweetAlert ปิดลง, ทำการ redirect ไปที่หน้า login
            if (result.dismiss === Swal.DismissReason.timer) {
                window.location.href = '../login/login.php';
            }
        });
    }
</script>
</html>