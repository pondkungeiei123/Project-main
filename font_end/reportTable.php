<?php
header('Content-Type: application/json; charset=UTF-8');

include "../config.php";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $report_type = $_GET["report_type"];
    $dateStart = $_GET["dateStart"] . " 00:00:00";
    $dateEnd = $_GET["dateEnd"] . " 23:59:59";

    // Debugging: Output date range
    error_log("Date Start: $dateStart");
    error_log("Date End: $dateEnd");

    if ($report_type == 'booking') {
        $stmt = $conn->prepare("SELECT * FROM booking 
                                JOIN customer ON booking.cus_id = customer.cus_id 
                                JOIN hairstlye ON booking.hair_id = hairstlye.hair_id 
                                JOIN barber ON booking.ba_id = barber.ba_id 
                                WHERE bk_startdate >= ? AND bk_enddate <= ?");
        $stmt->bind_param("ss", $dateStart, $dateEnd);
    } elseif ($report_type == 'payment') {
        $stmt = $conn->prepare("SELECT * FROM payment 
                                JOIN booking ON payment.bk_id = booking.bk_id
                                JOIN barber ON booking.ba_id = barber.ba_id 
                                JOIN customer ON booking.cus_id = customer.cus_id 
                                WHERE pm_time >= ? AND pm_time <= ?");
        $stmt->bind_param("ss", $dateStart, $dateEnd);
    } elseif ($report_type == 'barber') {
        $stmt = $conn->prepare("SELECT ba_name, ba_lastname, ba_idcard, ba_namelocation FROM barber");
    } elseif ($report_type == 'customer') {
        $stmt = $conn->prepare("SELECT cm.cus_name, cm.cus_lastname, cm.cus_phone, cm.cus_email, COUNT(pm.pm_id) AS total FROM `payment` AS pm
                                LEFT JOIN booking AS bk ON pm.bk_id = bk.bk_id
                                LEFT JOIN customer AS cm ON bk.cus_id = cm.cus_id
                                GROUP BY cm.cus_id");
    } elseif ($report_type == 'workschedule') {
        $stmt = $conn->prepare("SELECT ba_name, ws_startdate, ws_enddate, ws_status FROM workschedule 
                                JOIN barber ON workschedule.ba_id = barber.ba_id");
    } else {
        $response = array("success" => false, "message" => "Invalid report type");
        echo json_encode($response);
        exit();
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
    } else {
        echo "Error: " . $stmt->error;
    }

    if ($result->num_rows > 0) {
        $number = 1;
        $data = [];
        if ($report_type == 'booking') {
            while ($row = $result->fetch_assoc()) {
                $bk_startdate = DateTime::createFromFormat('Y-m-d H:i:s', $row['bk_startdate']);
                $bk_startdate = $bk_startdate ? $bk_startdate->format('d/m/Y H:i:s') : 'Invalid date';
                $row['number'] = $number++;
                $row['bk_startdate'] = $bk_startdate;
                $row['bk_price'] = number_format($row['bk_price'], 0) . ' บาท';
                $row['cus_name'] = $row['cus_name'] . ' ' . $row['cus_lastname'];
                $row['ba_name'] = $row['ba_name'] . ' ' . $row['ba_lastname'];
                $data[] = $row;
            }
        } elseif ($report_type == 'payment') {
            while ($row = $result->fetch_assoc()) {
                $row['number'] = $number++;
                $bk_startdate = DateTime::createFromFormat('Y-m-d H:i:s', $row['bk_startdate']);
                $bk_startdate = $bk_startdate ? $bk_startdate->format('d/m/Y H:i:s') : 'Invalid date';
                $row['bk_startdate'] = $bk_startdate;
                $pm_time = DateTime::createFromFormat('Y-m-d H:i:s', $row['pm_time']);
                $pm_time = $pm_time ? $pm_time->format('d/m/Y H:i:s') : 'Invalid date';
                $row['pm_time'] = $pm_time;
                $row['pm_amount'] = number_format($row['pm_amount'], 0) . ' บาท';
                $row['cus_name'] = $row['cus_name'] . ' ' . $row['cus_lastname'];
                $row['ba_name'] = $row['ba_name'] . ' ' . $row['ba_lastname'];
                $data[] = $row;
            }
        } elseif ($report_type == 'barber') {
            while ($row = $result->fetch_assoc()) {
                $row['number'] = $number++;
                $data[] = [
                    'number' => $row['number'],
                    'ba_name' => $row['ba_name'],
                    'ba_lastname' => $row['ba_lastname'],
                    'ba_idcard' => $row['ba_idcard'],
                    'ba_namelocation' => $row['ba_namelocation']
                ];
            }
        } elseif ($report_type == 'customer') {
            while ($row = $result->fetch_assoc()) {
                $row['number'] = $number++;
                $data[] = [
                    'number' => $row['number'],
                    'cus_name' => $row['cus_name'],
                    'cus_lastname' => $row['cus_lastname'],
                    'cus_phone' => $row['cus_phone'],
                    'cus_email' => $row['cus_email'],
                    'total' => $row['total']
                ];
            }
        } elseif ($report_type == 'workschedule') {
            while ($row = $result->fetch_assoc()) {
                $row['number'] = $number++;
                $ws_startdate = DateTime::createFromFormat('Y-m-d H:i:s', $row['ws_startdate']);
                $ws_startdate = $ws_startdate ? $ws_startdate->format('d/m/Y H:i:s') : 'Invalid date';
                $ws_enddate = DateTime::createFromFormat('Y-m-d H:i:s', $row['ws_enddate']);
                $ws_enddate = $ws_enddate ? $ws_enddate->format('d/m/Y H:i:s') : 'Invalid date';
                $ws_status = $row['ws_status'] == 1 ? 'พร้อม' : 'ไม่พร้อม';
                $data[] = [
                    'number' => $row['number'],
                    'ba_name' => $row['ba_name'],
                    'ws_startdate' => $ws_startdate,
                    'ws_enddate' => $ws_enddate,
                    'ws_status' => $ws_status
                ];
            }
        }

        $response = array('type' => $report_type, 'data' => $data);
    } else {
        $response = array('type' => $report_type, 'data' => [], 'message' => 'No data found for the given date range');
    }
} else {
    $response = array("success" => false, "message" => "Invalid request method");
}

$conn->close();
echo json_encode($response);
?>
