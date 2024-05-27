<?php
// connect.php
header('Content-Type: application/json; charset=UTF-8');

include "../config.php";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $report_type = $_GET["report_type"];
    $dateStart = $_GET["dateStart"] . " 00:00:00";
    $dateEnd = $_GET["dateEnd"] . " 00:00:00";
    if ($report_type == 'booking') {
        $stmt = $conn->prepare("SELECT * FROM booking 
                                JOIN customer ON booking.cus_id = customer.cus_id 
                                JOIN hairstlye ON booking.hair_id = hairstlye.hair_id 
                                JOIN barber ON booking.ba_id = barber.ba_id 
                                WHERE bk_startdate  >= ? AND bk_enddate <= ? ");
    } elseif ($report_type == 'payment') {
        $stmt = $conn->prepare("SELECT * FROM payment 
        JOIN booking ON payment.bk_id = booking.bk_id
        JOIN barber ON booking.ba_id = barber.ba_id 
        JOIN customer ON booking.cus_id = customer.cus_id 
        WHERE pm_time >= ? AND pm_time <= ? ");
    }


    $stmt->bind_param("ss", $dateStart, $dateEnd);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $number = 1;
        if($report_type == 'booking'){
            while($row = $result->fetch_assoc()) {
                $bk_startdate = DateTime::createFromFormat('Y-m-d H:i:s', $row['bk_startdate']);
                $bk_startdate = $bk_startdate ? $bk_startdate->format('d/m/Y') : 'Invalid date';
                $row['number'] = $number++;
                $row['bk_startdate'] = $bk_startdate;
                $row['bk_price'] = number_format($row['bk_price'],0).' บาท';
                $row['cus_name'] = $row['cus_name'].' '.$row['cus_lastname'];
                $row['ba_name'] = $row['ba_name'].' '.$row['ba_lastname'];
                $data[] = $row;
            }
        }elseif($report_type == 'payment'){
            while($row = $result->fetch_assoc()) {
                $row['number'] = $number++;
                //วันลงงาน
                $bk_startdate = DateTime::createFromFormat('Y-m-d H:i:s', $row['bk_startdate']);
                $bk_startdate = $bk_startdate ? $bk_startdate->format('d/m/Y') : 'Invalid date';
                $row['bk_startdate'] = $bk_startdate;
                //วันชำระเงิน
                $pm_time = DateTime::createFromFormat('Y-m-d H:i:s', $row['pm_time']);
                $pm_time = $pm_time ? $pm_time->format('d/m/Y') : 'Invalid date';
                $row['pm_time'] = $pm_time;
                $row['pm_amount'] = number_format($row['pm_amount'],0).' บาท';
                $row['cus_name'] = $row['cus_name'].' '.$row['cus_lastname'];
                $row['ba_name'] = $row['ba_name'].' '.$row['ba_lastname'];
                $data[] = $row;
            }
        }
        
        $response = array('type' => $report_type,'data' => $data);
    }else{
        $response = "";
    }
    

} else {
    $response = array("success" => false, "message" => "Invalid request method");
}

// Close connection
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
