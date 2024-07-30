<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php"; // Assuming this file contains the database connection

if (!$con) {
    die(json_encode(array(
        "result" => 0,
        "message" => "Connection error",
        "error" => mysqli_connect_error()
    )));
}

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

$sql = "SELECT js.* , ct.cus_name AS cname , ct.cus_phone AS phone ,cl.cus_namelocation AS nameLocation, 
cl.cus_latitude as clatitude , cl.cus_longtitude as clongtitude , ut.user_latitude AS ulatitude ,
ut.user_longtitude AS ulongtitude 
 FROM jobschedule AS js
        LEFT JOIN customer_table AS ct ON js.cus_id = ct.cus_id 
        LEFT JOIN customer_location AS cl ON js.cus_locationid = cl.cus_locationid 
        LEFT JOIN user_table AS ut ON js.user_id = ut.user_id 
        WHERE js.user_id = ?";

$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = array(
                "jobsc_id" => $row["jobsc_id"],
                "cus_name" => $row["cname"],
                "cus_phone" => $row["phone"],
                "jobsc_startdate" => $row["jobsc_startdate"],
                "jobsc_enddate" => $row["jobsc_enddate"],
                "cus_latitude" => $row["clatitude"],
                "user_latitude" => $row["ulatitude"],
                "cus_longitude" => $row["clongtitude"],
                "user_longitude" => $row["ulongtitude"],
                "namelocation" => $row["nameLocation"]
            );
        }

        echo json_encode(array(
            "result" => 1,
            "message" => "Success",
            "data" => $data
        ));
    } else {
        echo json_encode(array(
            "result" => 0,
            "message" => "No data found",
            "data" => array()
        ));
    }
} else {
    echo json_encode(array(
        "result" => 0,
        "message" => "Query error",
        "error" => mysqli_error($con)
    ));
}

mysqli_close($con);
exit();
