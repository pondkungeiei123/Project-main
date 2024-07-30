<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers");

require "connect.php";

// Check connection
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password'])) {

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        // Prepare the SQL queries
        $check_phone_query = $con->prepare("SELECT cus_phone FROM customer WHERE cus_phone = ? LIMIT 1");
        $check_email_query = $con->prepare("SELECT cus_email FROM customer WHERE cus_email = ? LIMIT 1");

        // Check if the queries were prepared successfully
        if (!$check_phone_query) {
            die("Prepare failed: (" . $con->errno . ") " . $con->error);
        }
        if (!$check_email_query) {
            die("Prepare failed: (" . $con->errno . ") " . $con->error);
        }

        // Bind parameters
        $check_phone_query->bind_param('s', $phone);
        $check_email_query->bind_param('s', $email);

        // Execute queries
        $check_phone_query->execute();
        $phone_result = $check_phone_query->get_result();

        $check_email_query->execute();
        $email_result = $check_email_query->get_result();

        // Check if phone or email already exists
        if ($phone_result->num_rows > 0) {
            $response = array(
                'result' => 0,
                'message' => 'เบอร์โทรศัพท์นี้มีการใช้งานอยู่แล้ว'
            );
        } else if ($email_result->num_rows > 0) {
            $response = array(
                'result' => 0,
                'message' => 'อีเมลนี้มีการใช้งานอยู่แล้ว'
            );
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the insert statement
            $stmt = $con->prepare("INSERT INTO customer (cus_name, cus_lastname, cus_phone, cus_email, cus_password) VALUES (?, ?, ?, ?, ?)");

            // Check if the statement was prepared successfully
            if (!$stmt) {
                die("Prepare failed: (" . $con->errno . ") " . $con->error);
            }

            // Bind parameters
            $stmt->bind_param("sssss", $firstname, $lastname, $phone, $email, $hashed_password);

            // Execute the statement
            if ($stmt->execute()) {
                $response = array(
                    'result' => 1,
                    'message' => 'การสมัครสมาชิกสำเร็จ'
                );
            } else {
                $response = array(
                    'result' => 0,
                    'message' => 'การสมัครสมาชิกไม่สำเร็จ'
                );
            }

            // Close the statement
            $stmt->close();
        }

        // Close the result sets
        $phone_result->free();
        $email_result->free();

        // Close the connection
        $con->close();

        // Return the response
        echo json_encode($response);
        exit();
    } else {
        $response = array(
            'result' => -1,
            'message' => 'ข้อมูลไม่ครบถ้วน'
        );
        echo json_encode($response);
        exit();
    }
} else {
    $response = array(
        'result' => -2,
        'message' => 'ไม่ใช้วิธี POST'
    );
    echo json_encode($response);
    exit();
}
?>
