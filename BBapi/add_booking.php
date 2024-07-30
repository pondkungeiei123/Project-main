<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ws_id']) && isset($_POST['cus_id']) && isset($_POST['lo_id']) && isset($_POST['startdate'])  && isset($_POST['hair_id'])&& isset($_POST['price']) && isset($_POST['status']) && isset($_POST['ba_id']) ) {

        $ws_id = $_POST['ws_id'];
        $cus_id = $_POST['cus_id'];
        $hair_id = $_POST['hair_id'];
        $lo_id = $_POST['lo_id'];
        $startdate = $_POST['startdate'];
        $status = $_POST['status'];
        $price = $_POST['price'];
        $ba_id = $_POST['ba_id'];

        $stmt_check = $con->prepare("SELECT * FROM booking WHERE cus_id = ? AND lo_id = ? AND DATE(bk_startdate) = ? AND bk_status != 5");
        $stmt_check->bind_param("iis", $cus_id, $lo_id, $startdate);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            $response = array(
                'result' => 0,
                'message' => 'วันที่คุณเลือกมีการจองคิวช่างตัดผมไว้อยู่แล้ว'
            );
        } else {
            $stmt = $con->prepare("INSERT INTO  booking (bk_startdate , bk_enddate , ws_id ,  cus_id ,  hair_id ,  lo_id , bk_price , bk_status , ba_id) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? )");
            $stmt->bind_param("ssiiiidii", $startdate, $startdate , $ws_id, $cus_id, $hair_id, $lo_id,$price , $status , $ba_id);         

            if ($stmt->execute()) {
                $stmtUpdate = $con->prepare("UPDATE  workschedule  SET ws_status = 1 WHERE  ws_id = ?  ");
                $stmtUpdate->bind_param("i", $ws_id);
                if($stmtUpdate->execute()) {
                    $response = array(
                        'result' => 1,
                        'message' => 'ทำการจองคิวสำเร็จ'
                    );
                }          

            } else {
                $response = array(
                    'result' => 0,
                    'message' => 'จองคิวไม่สำเร็จ'
                );
            }

            $stmt->close();
            $con->close();
        }

        $stmt_check->close();
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
