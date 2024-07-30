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
    $stmt = $con->prepare("SELECT
    ws.ws_id ,
    ws.ba_id ,
    ws.ws_startdate ,
    ws.ws_enddate ,
    ws.ws_note ,
    ws.ws_status ,
    b.ba_name ,
    b.ba_lastname ,
    b.ba_certificate ,
    b.ba_email ,
    b.ba_phone ,
    b.ba_idcard ,
    b.ba_namelocation ,
    b.ba_latitude ,
    b.ba_longitude
FROM
    workschedule ws
LEFT JOIN
    barber b ON ws.ba_id = b.ba_id
WHERE
    ws.ws_status = 0 AND 
    ws.ws_enddate <= DATE_ADD(CURRENT_DATE, INTERVAL 1 WEEK) AND
    ws.ws_enddate >= CURRENT_TIMESTAMP
ORDER BY
    ws.ws_enddate ASC
");

    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $Data = array();
        while ($row = $result->fetch_assoc()) {
            $Data[] = array(
                'ba_id' => $row['ba_id'],
                'name' => $row['ba_name'],
                'lastname' => $row['ba_lastname'],
                'phone' => $row['ba_phone'],
                'email' => $row['ba_email'],
                'idcard' => $row['ba_idcard'],
                'certificate' => $row['ba_certificate'],
                'namelocation' => $row['ba_namelocation'],
                'latitude' => $row['ba_latitude'],
                'longitude' => $row['ba_longitude'],
                'ws_id' => $row['ws_id'],
                'startdate' => $row['ws_startdate'],
                'enddate' => $row['ws_enddate'],
                'note' => $row['ws_note'],
                'status' => $row['ws_status'],        
            );
        }
        $response = array(
            'result' => 1,
            'data' => $Data
        );
    } else {
        $response = array(
            'result' => 0,
            'message' => 'ไม่พบข้อมูล'
        );
    }

    $stmt->close();
} else {
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี GET'
    );
}

echo json_encode($response);

exit();
