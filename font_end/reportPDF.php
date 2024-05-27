
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
$title = array('booking'=>'รายงานการจอง','payment'=>'รายงานการชำระเงิน');
//เริ่มส่วนของ pdf
$dateStart = DateTime::createFromFormat('Y-m-d H:i:s', $dateStart);
$dateEnd = DateTime::createFromFormat('Y-m-d H:i:s', $dateEnd);

$dateEnd->format('d/m/Y');
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
                <p style="text-align: right;font-size:25px;padding-top:-25px">ตั้งแต่วันที่ : '.$dateStart->format('d/m/Y').' ถึง วันที่ : '.$dateStart->format('d/m/Y').'</p>
                <table class="table table-bordered" style="font-size:20px;">';
if ($report_type == 'booking') {
    $tableReport .=  '<thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>วันที่จอง</th>
                        <th>ทรงผมที่ตัด</th>
                        <th>ราคา</th>
                        <th>ลูกค้า</th>
                        <th>ชื่อช่าง</th>
                    </tr>
                </thead>';
} else if ($report_type == 'payment') {
    $tableReport .=  '<thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>วันที่จอง</th>
                        <th>จำนวนเงิน</th>
                        <th>วันที่ชำระ</th>
                        <th>ลูกค้า</th>
                        <th>ชื่อช่าง</th>
                    </tr>
                </thead>';
}

if ($result->num_rows > 0) {
    $number = 1;
    if ($report_type == 'booking') {
        while ($row = $result->fetch_assoc()) {
            $bk_startdate = DateTime::createFromFormat('Y-m-d H:i:s', $row['bk_startdate']);
            $bk_startdate = $bk_startdate ? $bk_startdate->format('d/m/Y') : 'Invalid date';
            $bk_price = number_format($row['bk_price'], 0) . ' บาท';
            $cus_name = $row['cus_name'] . ' ' . $row['cus_lastname'];
            $ba_name = $row['ba_name'] . ' ' . $row['ba_lastname'];

            $tableReport .=  '<tbody>
                            <tr>
                                <td style="text-align:center">' . $number++ . '</td>
                                <td style="padding-left:10px">' . $bk_startdate . '</td>
                                <td style="padding-left:10px">' . $row['hair_name'] . '</td>
                                <td style="text-align:right;padding-right:10px">' . $bk_price . '</td>
                                <td style="padding-left:10px">' . $cus_name . '</td>
                                <td style="padding-left:10px">' . $ba_name . '</td>
                            </tr>
                        </tbody>';
        }
    } elseif ($report_type == 'payment') {
        while ($row = $result->fetch_assoc()) {
            //วันลงงาน
            $bk_startdate = DateTime::createFromFormat('Y-m-d H:i:s', $row['bk_startdate']);
            $bk_startdate = $bk_startdate ? $bk_startdate->format('d/m/Y') : 'Invalid date';

            //วันชำระเงิน
            $pm_time = DateTime::createFromFormat('Y-m-d H:i:s', $row['pm_time']);
            $pm_time = $pm_time ? $pm_time->format('d/m/Y') : 'Invalid date';
            $pm_amount = number_format($row['pm_amount'], 0) . ' บาท';
            $cus_name = $row['cus_name'] . ' ' . $row['cus_lastname'];
            $ba_name = $row['ba_name'] . ' ' . $row['ba_lastname'];
            $tableReport .=  '<tbody>
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
    }
}


$tableReport .= '</table>';





$mpdf->WriteHTML($tableReport);
$mpdf->Output('report.pdf','I');
