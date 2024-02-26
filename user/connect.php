

<?php
$servername = "localhost";
$username_db = "root";
$password_db = "";
$database = "barber_app"; 
$con = new mysqli($servername, $username_db, $password_db, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
