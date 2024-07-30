<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

if (!$con) {
    die(json_encode(array('result' => 0, 'message' => 'Connection error:' . mysqli_connect_error())));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['cus_id'])) {

        $name = $_POST['name'];
        $cus_id = $_POST['cus_id'];
        $latitude = doubleval($_POST['latitude']);
        $longitude = doubleval($_POST['longitude']);


        $stmt = $con->prepare("INSERT INTO  location ( cus_id ,  lo_name ,  lo_latitude ,  lo_longitude ) VALUES (?,?,?,?)");
        $stmt->bind_param("isdd", $cus_id, $name, $latitude, $longitude);

        if ($stmt->execute()) {

            $response = array(
                'result' => 1,
                'message' => 'เพิ่มข้อมูลสำเร็จ'
            );
        } else {

            $response = array(
                'result' => 0,
                'message' => 'เพิ่มข้อมูลไม่สำเร็จ'
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
