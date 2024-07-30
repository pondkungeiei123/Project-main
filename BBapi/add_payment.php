<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['bk_id'])  && isset($_POST['amount'])  && isset($_POST['ws_id']) ) {    
        $bk_id = $_POST['bk_id'];
        $ws_id = $_POST['ws_id'];
        $amount = $_POST['amount'];   

            $stmt = $con->prepare("INSERT INTO  payment  (pm_amount ,  pm_status ,  bk_id ) VALUES ( ? , 0 , ?)");
            $stmt->bind_param("ii", $amount, $bk_id);
           
            if ($stmt->execute()) {               
                $stmtUpdateBooking = $con->prepare("UPDATE booking SET bk_status = 5 WHERE bk_id = ? ");
                $stmtUpdateBooking->bind_param("i", $bk_id);

                $stmtUpdateWorkSchedule = $con->prepare("UPDATE workschedule SET ws_status = 0 WHERE ws_id = ? ");
                $stmtUpdateWorkSchedule->bind_param("i", $ws_id);

                if ($stmtUpdateBooking->execute() && $stmtUpdateWorkSchedule->execute()) {
                    $response = array(
                        'result' => 1,
                        'message' => 'ยืนยันการชำระเงินสำเร็จ'
                    );

                }else{
                    $response = array(
                        'result' => 0,
                        'message' => 'ไม่สามารถอัพเดทสถานะการจองและตารางลงงานได้'
                    );
                }
              
            } else {
               
                $response = array(
                    'result' => 0,
                    'message' => 'ยืนยันการชำระเงินไม่สำเร็จ'
                );
            }
           
            $stmt->close();

           
            $con->close();
           
    } else {      
        $response = array(
            'result' => -1,
            'message' => 'ข้อมูลไม่ครบถ้วน'
        );
     
    }
} else {
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี POST'
    );
  
}

echo json_encode($response);
exit();

