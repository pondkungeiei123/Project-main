<?php
require_once __DIR__ . '../../vendor/autoload.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [ // lowercase letters only in font key
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf',
        ]
    ],
    'default_font' => 'sarabun'
]);
include "../config.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$dateStart = $_GET["dateStart"] . " 00:00:00";
$dateEnd = $_GET["dateEnd"] . " 00:00:00";
$report_type = $_GET['report_type'];

if ($report_type == 'booking') {
    $stmt = $conn->prepare("SELECT * FROM booking 
                            JOIN customer ON booking.cus_id = customer.cus_id 
                            JOIN hairstlye ON 
                            .hair_id = hairstlye.hair_id 
                            JOIN barber ON booking.ba_id = barber.ba_id 
                            WHERE bk_startdate  >= ? AND bk_enddate <= ?");
} elseif ($report_type == 'payment') {
    $stmt = $conn->prepare("SELECT * FROM payment 
                            JOIN booking ON payment.bk_id = booking.bk_id
                            JOIN barber ON booking.ba_id = barber.ba_id 
                            JOIN customer ON booking.cus_id = customer.cus_id 
                            WHERE pm_time >= ? AND pm_time <= ?");
} elseif ($report_type == 'barber') {
    $stmt = $conn->prepare("SELECT * FROM barber");
} elseif ($report_type == 'customer') {
    $stmt = $conn->prepare("SELECT * FROM customer");
} elseif ($report_type == 'workschedule') {
    $stmt = $conn->prepare("SELECT *, TIMESTAMPDIFF(HOUR, ws_startdate, ws_enddate) AS total_time FROM workschedule 
                            JOIN barber ON workschedule.ba_id = barber.ba_id 
                            WHERE ws_startdate >= ? AND ws_enddate <= ?");
}

if ($report_type != 'barber' && $report_type != 'customer') {
    $stmt->bind_param("ss", $dateStart, $dateEnd);
}
$stmt->execute();
$result = $stmt->get_result();
$title = array(
    'booking' => 'รายงานการจอง',
    'payment' => 'รายงานการชำระเงิน',
    'barber' => 'รายงานช่างตัดผม',
    'customer' => 'รายงานลูกค้า',
    'workschedule' => 'รายงานตารางทำงาน'
);

$dateStart = DateTime::createFromFormat('Y-m-d H:i:s', $dateStart);
$dateEnd = DateTime::createFromFormat('Y-m-d H:i:s', $dateEnd);

$tableReport = '<style>
                    table, td, th {
                        border: 1px solid;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                </style>
                <p style="text-align: center;font-size:30px">'.$title[$report_type].'</p>
                <p style="text-align: right;font-size:25px;padding-top:-25px">ตั้งแต่วันที่ : '.$dateStart->format('d/m/Y').' ถึง วันที่ : '.$dateEnd->format('d/m/Y').'</p>
                <table class="table table-bordered" style="font-size:20px;">';

if ($report_type == 'booking') {
    $tableReport .= '<thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>วันที่จอง</th>
                            <th>ทรงผมที่ตัด</th>
                            <th>ราคา</th>
                            <th>ลูกค้า</th>
                            <th>ชื่อช่าง</th>
                        </tr>
                    </thead>';
} elseif ($report_type == 'payment') {
    $tableReport .= '<thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>วันที่จอง</th>
                            <th>จำนวนเงิน</th>
                            <th>วันที่ชำระ</th>
                            <th>ลูกค้า</th>
                            <th>ชื่อช่าง</th>
                        </tr>
                    </thead>';
} elseif ($report_type == 'barber') {
    $tableReport .= '<thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อช่าง</th>
                            <th>นามสกุล</th>
                            <th>บัตรประชาชน</th>
                            <th>ที่ตั้งร้าน</th>
                        </tr>
                    </thead>';
} elseif ($report_type == 'customer') {
    $tableReport .= '<thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อลูกค้า</th>
                            <th>นามสกุล</th>
                            <th>อีเมล</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>';
} elseif ($report_type == 'workschedule') {
    $tableReport .= '<thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อช่าง</th>
                            <th>วันที่เริ่มงาน</th>
                            <th>วันที่สิ้นสุด</th>
                            <th>จำนวนชั่วโมง</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>';
}

if ($result->num_rows > 0) {
    $number = 1;
    while ($row = $result->fetch_assoc()) {
        if ($report_type == 'booking' || $report_type == 'payment') {
            $bk_startdate = DateTime::createFromFormat('Y-m-d H:i:s', $row['bk_startdate']);
            $bk_startdate = $bk_startdate ? $bk_startdate->format('d/m/Y') : 'Invalid date';
            $cus_name = $row['cus_name'] . ' ' . $row['cus_lastname'];
            $ba_name = $row['ba_name'] . ' ' . $row['ba_lastname'];
            if ($report_type == 'booking') {
                $bk_price = number_format($row['bk_price'], 0) . ' บาท';
                $tableReport .= '<tbody>
                                    <tr>
                                        <td style="text-align:center">' . $number++ . '</td>
                                        <td style="padding-left:10px">' . $bk_startdate . '</td>
                                        <td style="padding-left:10px">' . $row['hair_name'] . '</td>
                                        <td style="text-align:right;padding-right:10px">' . $bk_price . '</td>
                                        <td style="padding-left:10px">' . $cus_name . '</td>
                                        <td style="padding-left:10px">' . $ba_name . '</td>
                                    </tr>
                                </tbody>';
            } elseif ($report_type == 'payment') {
                $pm_time = DateTime::createFromFormat('Y-m-d H:i:s', $row['pm_time']);
                $pm_time = $pm_time ? $pm_time->format('d/m/Y') : 'Invalid date';
                $pm_amount = number_format($row['pm_amount'], 0) . ' บาท';
                $tableReport .= '<tbody>
                                    <tr>
                                        <td style="text-align:center">' . $number++ . '</td>
                                        <td style="padding-left:10px">' . $bk_startdate . '</td>
                                        <td style="text-align:right;padding-right:10px">' . $pm_amount . '</td>
                                        <td style="padding-left:10px">' . $pm_time . '</td>
                                        <td style="padding-left:10px">' . $cus_name . '</td>
                                        <td style="padding-left:10px">' . $ba_name . '</td>
                                    </tr>
                                </tbody>';
            }
        } elseif ($report_type == 'barber') {
            $tableReport .= '<tbody>
                                <tr>
                                    <td style="text-align:center">' . $number++ . '</td>
                                    <td style="padding-left:10px">' . $row['ba_name'] . '</td>
                                    <td style="padding-left:10px">' . $row['ba_lastname'] . '</td>
                                    <td style="padding-left:10px">' . $row['ba_idcard'] . '</td>
                                    <td style="padding-left:10px">' . $row['ba_namelocation'] . '</td>
                                </tr>
                            </tbody>';
        } elseif ($report_type == 'customer') {
            $status = $row['cus_status'] == 'active' ? 'ปกติ' : 'ยกเลิก';
            $tableReport .= '<tbody>
                                <tr>
                                    <td style="text-align:center">' . $number++ . '</td>
                                    <td style="padding-left:10px">' . $row['cus_name'] . '</td>
                                    <td style="padding-left:10px">' . $row['cus_lastname'] . '</td>
                                    <td style="padding-left:10px">' . $row['cus_email'] . '</td>
                                    <td style="padding-left:10px">' . $status . '</td>
                                </tr>
                            </tbody>';
        } elseif ($report_type == 'workschedule') {
            $ws_startdate = DateTime::createFromFormat('Y-m-d H:i:s', $row['ws_startdate']);
            $ws_startdate = $ws_startdate ? $ws_startdate->format('d/m/Y H:i') : 'Invalid date';
            $ws_enddate = DateTime::createFromFormat('Y-m-d H:i:s', $row['ws_enddate']);
            $ws_enddate = $ws_enddate ? $ws_enddate->format('d/m/Y H:i') : 'Invalid date';
            $ws_status = $row['ws_status'] == 'completed' ? 'เสร็จสิ้น' : 'ระหว่างดำเนินการ';
            $tableReport .= '<tbody>
                                <tr>
                                    <td style="text-align:center">' . $number++ . '</td>
                                    <td style="padding-left:10px">' . $row['ba_name'] . ' ' . $row['ba_lastname'] . '</td>
                                    <td style="padding-left:10px">' . $ws_startdate . '</td>
                                    <td style="padding-left:10px">' . $ws_enddate . '</td>
                                    <td style="padding-left:10px">' . $row['total_time'] . ' ชั่วโมง</td>
                                    <td style="padding-left:10px">' . $ws_status . '</td>
                                </tr>
                            </tbody>';
        }
    }
}

$tableReport .= '</table>';
$mpdf->WriteHTML($tableReport);
$mpdf->Output('report.pdf', 'I');
?>
