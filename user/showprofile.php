<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

// Ensure that the variables are defined with default values
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';


$sql = "SELECT * FROM users WHERE user_id = '" . $user_id . "'";
$result = mysqli_query($con, $sql);

if ($result) {
    $resultObj = mysqli_fetch_assoc($result);
        echo json_encode(array(
            "result" => 1,
            "message" => "Success",
            "data" => array(
                'user_name' => $resultObj['user_name'],
                'user_lastname' => $resultObj['user_lastname'],
                'user_phone' => $resultObj['user_phone'],
                'user_email' => $resultObj['user_email']
                
            )
        ));
    
} else {
    // Error in the SQL query
    echo json_encode(['error' => mysqli_error($con)]);
}

// Stop execution after sending JSON response
exit();
?>
