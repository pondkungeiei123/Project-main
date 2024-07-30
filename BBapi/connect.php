<?php
$db_name = "bb_app";
$db_user = "root";
$db_pass = "";
$db_host = "localhost";

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}else{
 //echo "success";
}