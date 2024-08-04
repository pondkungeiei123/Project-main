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

$tableData = isset($_GET['tableData']) ? json_decode($_GET['tableData'], true) : [];

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

if (!empty($tableData)) {
    $number = 1;
    foreach ($tableData as $row) {
        $tableReport .= '<tbody>
                            <tr>';
        foreach ($row as $cell) {
            $tableReport .= '<td style="padding-left:10px">' . htmlspecialchars($cell) . '</td>';
        }
        $tableReport .= '  </tr>
                        </tbody>';
    }
}

$tableReport .= '</table>';
$mpdf->WriteHTML($tableReport);
$mpdf->Output('report.pdf', 'I');
?>
