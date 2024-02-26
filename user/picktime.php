<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$job_startdate = isset($_POST['startdate']) ? $_POST['startdate'] : '';
$job_enddate = isset($_POST['enddate']) ? $_POST['enddate'] : '';
$job_note = isset($_POST['note']) ? $_POST['note'] : '';

$sql = "SELECT * FROM jobqueue WHERE user_id = '$user_id'";
$result = mysqli_query($con, $sql);
$count = mysqli_num_rows($result);

if ($count == 0) {
    echo json_encode('Error');
} else {
    $insert = "INSERT INTO jobqueue (user_id, job_startdate, job_enddate, job_note) VALUES ('$user_id','$job_startdate','$job_enddate', '$job_note')";
    $query = mysqli_query($con, $insert);

    if ($query) {
        echo json_encode('Succeed');
    } else {
        echo json_encode(['error' => mysqli_error($con)]);
    }
}

// Stop execution after sending JSON response
exit();
?>
