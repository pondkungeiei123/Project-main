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

        $stmt = $con->prepare("SELECT b.*, l.*, ba.ba_name, ba.ba_lastname, ba.ba_phone, ba.ba_namelocation, ba.ba_latitude , ba.ba_longitude , h.hair_name, h.hair_price, ws.ws_startdate, ws.ws_enddate 
                       FROM booking b
                       INNER JOIN workschedule ws ON ws.ws_id = b.ws_id
                       INNER JOIN barber ba ON ba.ba_id = b.ba_id
                       INNER JOIN hairstlye h ON h.hair_id = b.hair_id
                       INNER JOIN location l ON l.lo_id = b.lo_id
                       WHERE b.cus_id = ? AND ws.ws_enddate >= CURRENT_TIMESTAMP AND
                       b.bk_status != 5
                       ORDER BY ws.ws_enddate ASC");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $Data = array();
            while ($row = $result->fetch_assoc()) {
                $Data[] = array(
                    'bk_id' => $row['bk_id'],
                    'cus_id' => $row['cus_id'],
                    'price' => $row['bk_price'],
                    'status' => $row['bk_status'],
                    'ws_id' => $row['ws_id'],
                    'lo_id' => $row['lo_id'],
                    'hair_id' => $row['hair_id'],
                    'bk_startdate' => $row['bk_startdate'],
                    'bk_enddate' => $row['bk_enddate'],
                    'latitude' => $row['lo_latitude'],
                    'longitude' => $row['lo_longitude'],
                    'namelocation' => $row['lo_name'],
                    'ba_id' => $row['ba_id'],
                    'ba_name' => $row['ba_name'],
                    'ba_lastname' => $row['ba_lastname'],
                    'ba_phone' => $row['ba_phone'],
                    'ba_namelocation' => $row['ba_namelocation'],
                    'ba_latitude' => $row['ba_latitude'],
                    'ba_longitude' => $row['ba_longitude'],
                    'hair_price' => $row['hair_price'],
                    'hair_name' => $row['hair_name'],
                    'ws_startdate' => $row['ws_startdate'],
                    'ws_enddate' => $row['ws_enddate'],
                );
            }

            $response = array(
                'result' => 1,
                'data' => $Data
            );
        } else {
            $response = array(
                'result' => 0,
                'message' => 'ไม่พบข้อมูลการจองคิว'
            );
        }


        $stmt->close();
    } else {
        $response = array(
            'result' => -1,
            'message' => 'ไม่ได้ระบุ id'
        );
    }
} else {
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี GET'
    );
}

echo json_encode($response);

exit();
