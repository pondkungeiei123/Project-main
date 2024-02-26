<?php
require_once '../config.php';

// ตรวจสอบว่ามีการส่งค่า user_id มาหรือไม่
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // ทำการเรียกใช้งาน connection จากไฟล์ config.php
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");

    // ทำการ bind parameter และ execute query
    $stmt->bind_param('i', $userId);
    $stmt->execute();

    // ทำการ fetch ข้อมูล
    $result = $stmt->get_result();

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // นำข้อมูลที่ได้มาใส่ในตัวแปร
        $user_id = $user['user_id'];
        $user_name = $user['user_name'];
        $user_lastname = $user['user_lastname'];
        $cer = $user['user_Certificate'];
        $birthdate = $user['birthdate'];
        $user_email = $user['user_email'];
        $user_age = $user['user_age'];
        $id_card = $user['id_card'];
        $user_address = $user['user_address'];
        $user_tel = $user['user_tel'];
        // ปิด statement
        $stmt->close();
        // แสดงผลลัพธ์
        echo "<div class='row'>
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='user_name'>ชื่อ:</label>
                <input type='text' class='form-control ' value='$user_name' disabled>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='user_lastname'>นามสกุล:</label>
                <input type='text' class='form-control ' value='$user_lastname' disabled>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='birthdate'>วัน-เดือน-ปีเกิด:</label>
                <input type='date' class='form-control ' value='$birthdate' disabled>
            </div> 
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='user_email'>Email:</label>
                <input type='email' class='form-control ' value='$user_email' disabled>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='user_age'>age:</label>
                <input type='text' class='form-control ' value='$user_age' disabled>
            </div>
        </div>    
        <div class='col-md-12'>
            <div class='form-group'>
                <label for='id_card'>หมายเลขบัตรประชาชน:</label>
                <input type='text' class='form-control ' value='$id_card' disabled>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='user_address'>ที่อยู่ปัจจุบัน:</label>
                <input type='text' class='form-control ' value='$user_address' disabled>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='user_tel'>เบอร์ติดต่อ:</label>
                <input type='text' class='form-control ' value='$user_tel' disabled>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label for='user_Certificate'>ใบเซอร์:</label>
                <img src='../asset/Certificate/$cer' style='width:400px;height:400px;'>
            </div>
        </div>
    </div>
   ";
//     echo "<script>
//     function submitForm(userId) {
//         // Add AJAX request to update status
//         var status = 'your_status'; // Set the desired status
        
//         // Use Fetch API to send the status update request
//         fetch('update_status.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/x-www-form-urlencoded',
//             },
//             body: 'user_id=' + userId + '&status=' + status,
//         })
//         .then(response => response.text())
//         .then(data => {
//             // Redirect to list_hs.php after updating status
//             window.location.href = 'list_hs.php';
//         })
//         .catch(error => {
//             console.error('Error updating status:', error);
//         });
//     }
// </script>";
    } else {
        echo "ไม่พบข้อมูลผู้ใช้";
        $stmt->close();
        // หรือจะทำการ redirect หรือทำอย่างอื่นตามที่ต้องการ
    }
} else {
    echo "ไม่ได้ระบุ user_id";
}
?>