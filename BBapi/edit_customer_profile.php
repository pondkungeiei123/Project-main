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
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['phone'])  && isset($_POST['password'])) {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        $check_email_query = $con->prepare("SELECT cus_email FROM customer WHERE cus_email = ? AND cus_id != ? ");
        $check_email_query->bind_param('si', $email, $id);
        $check_email_query->execute();

        $email_result = $check_email_query->get_result();

        if ($email_result->num_rows > 0) {
            $response = array(
                'result' => 0,
                'message' => 'มีอีเมลนี้อยู่แล้ว'
            );
        } else {
            if ($password === '') {
                $stmt = $con->prepare("UPDATE customer SET cus_name=?,cus_lastname=?,cus_phone=?,cus_email=? WHERE cus_id = ? ");
                $stmt->bind_param("ssssi", $name, $lastname, $phone, $email, $id);
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $con->prepare("UPDATE  customer  SET cus_name = ? , cus_lastname = ? , cus_phone = ? , cus_email = ? , cus_password = ?  WHERE cus_id = ? ");
                $stmt->bind_param("sssssi", $name, $lastname, $phone, $email, $hashed_password, $id);
            }
            if ($stmt->execute()) {
                $stmtData = $con->prepare("SELECT * FROM customer WHERE cus_email = ?");
                $stmtData->bind_param("s", $email);
                $stmtData->execute();
                $resultData = $stmtData->get_result();
                if ($resultData->num_rows > 0) {
                    $rowData = $resultData->fetch_assoc();
                    $customerData = array(
                        'id' => $rowData['cus_id'],
                        'name' => $rowData['cus_name'],
                        'lastname' => $rowData['cus_lastname'],
                        'email' => $rowData['cus_email'],
                        'phone' => $rowData['cus_phone']
                    );
                    $response = array(
                        'result' => 1,
                        'message' => 'แก้ไขข้อมูลสำเร็จ',
                        'data' => $customerData,
                    );

                } else {
                    $response = array(
                        'result' => 0,
                        'message' => 'ไม่พบข้อมูลลูกค้า'
                    );
                }
            } else {

                $response = array(
                    'result' => 0,
                    'message' => 'แก้ไขข้อมูลไม่สำเร็จ'
                );
            }
            $stmt->close();
        }
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
