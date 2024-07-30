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

$sql = "SELECT * FROM jobqueue WHERE
 user_id = ? 
 AND (job_startdate BETWEEN ? AND ?
       OR job_enddate BETWEEN ? AND ?
       OR (? BETWEEN job_startdate AND job_enddate
           AND ? BETWEEN job_startdate AND job_enddate))";

// Use prepared statement to prevent SQL injection
$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sssssss", $user_id, $job_startdate, $job_enddate, $job_startdate, $job_enddate, $job_startdate, $job_enddate);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_num_rows($result);

    mysqli_stmt_close($stmt);

    if ($count == 0) {
        // Perform the insertion if there are no conflicting records
        $insert = "INSERT INTO jobqueue (user_id, job_startdate, job_enddate, job_note) VALUES (?, ?, ?, ?)";
        $stmtInsert = mysqli_prepare($con, $insert);

        if ($stmtInsert) {
            mysqli_stmt_bind_param($stmtInsert, "ssss", $user_id, $job_startdate, $job_enddate, $job_note);
            mysqli_stmt_execute($stmtInsert);
            mysqli_stmt_close($stmtInsert);
            echo json_encode('Succeed');
        } else {
            echo json_encode(['error' => mysqli_error($con)]);
        }
    } else {
        echo json_encode('Error');
    }
} else {
    echo json_encode(['error' => mysqli_error($con)]);
}

// Stop execution after sending JSON response
exit();
?>