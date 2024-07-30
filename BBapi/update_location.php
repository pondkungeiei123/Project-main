<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die(json_encode(array('result' => 0, 'message' => 'Connection error:' . mysqli_connect_error())));
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required data is provided
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['cus_id'])) {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $cus_id = $_POST['cus_id'];
        $latitude = doubleval($_POST['latitude']);
        $longitude = doubleval($_POST['longitude']);


        $stmt = $con->prepare("UPDATE  location  SET  cus_id =?, lo_name =?, lo_latitude =?, lo_longitude =? WHERE lo_id =? ");
        $stmt->bind_param("isddi", $cus_id, $name, $latitude, $longitude, $id);

        if ($stmt->execute()) {
            // Send the result back to the application
            $response = array(
                'result' => 1,
                'message' => 'แก้ไขข้อมูลสำเร็จ'
            );
        } else {
            // If there's an error in updating data
            $response = array(
                'result' => 0,
                'message' => 'แก้ไขข้อมูลไม่สำเร็จ'
            );
        }

        // Close prepared statement
        $stmt->close();


        // Close MySQL connection
        $con->close();
    } else {
        // If data is incomplete
        $response = array(
            'result' => -1,
            'message' => 'ข้อมูลไม่ครบถ้วน'
        );
    }
} else {
    // If not using POST method to send data
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี POST'
    );
}
echo json_encode($response);

exit();
