<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $con->prepare("SELECT * FROM workschedule WHERE ba_id = ? ORDER BY ws_id DESC ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $Data = array();
            while ($row = $result->fetch_assoc()) {
                $Data[] = array(
                    'id' => $row['ws_id'],
                    'startdate' => $row['ws_startdate'],
                    'enddate' => $row['ws_enddate'],
                    'note' => $row['ws_note'],
                    'status' => $row['ws_status'],
                    'ba_id' => $row['ba_id'],
                );
            }
            $response = array(
                'result' => 1,
                'data' => $Data
            );
        } else {
            $response = array(
                'result' => 0,
                'message' => 'ไม่พบข้อมูลการลงงาน'
            );
        }


        $stmt->close();
    } else {
        $response = array(
            'result' => -2,
            'message' => 'ไม่ใช้วิธี GET'
        );
    }
}

echo json_encode($response);
exit();
