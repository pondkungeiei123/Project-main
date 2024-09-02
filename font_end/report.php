<?php
ob_start();
?>
<style>
    .form-group {
        padding-bottom: 10px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2>รายงาน</h2>
            <form id="report_form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="report_type">ประเภทรายงาน:</label>
                            <select id="report_type" name="report_type" class="form-control" onchange="checkreporttype(this)">
                                <option value="booking">รายงานการจอง</option>
                                <option value="payment">รายงานการชำระเงิน</option>
                                <option value="workschedule">รายงานตารางลงงาน</option>
                                <option value="barber">รายงานช่างตัดผม</option>
                                <option value="customer">รายงานจำนวนการเข้าใช้บริการ</option>
                            </select>
                        </div>
                    </div>
                    <div id="input_date" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dateStart">วันที่เริ่ม:</label>
                                <input type="date" id="dateStart" name="dateStart" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dateEnd">วันที่สิ้นสุด:</label>
                                <input type="date" id="dateEnd" name="dateEnd" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-end">
            <div class="form-group">
                <button type="button" class="btn btn-primary" onclick="report_result()">ตัวอย่างรายงาน</button>
                <button type="button" class="btn btn-info" onclick="report_pdf()">ปริ้นรายงาน</button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <h2 id="textShow" hidden class="text-center">ไม่พบข้อมูล</h2>
            <table id="report_result" class="table table-striped table-hover table-responsive table-bordered" hidden>
                <thead id="tableHeader"></thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function checkreporttype(e) {
        var report_type = $(e).val();
        if (report_type === "barber" || report_type === "customer") {
            $("#input_date").show();
        } else {
            $("#input_date").show();
        }
        clearPreviousResults();
    }

    function clearPreviousResults() {
        $('#textShow').attr('hidden', true);
        $('#report_result').attr('hidden', true);
        if ($.fn.DataTable.isDataTable('#report_result')) {
            $('#report_result').DataTable().clear().destroy();
        }
        $('#tableHeader').html('');
    }

    function report_result() {
        var form = $('#report_form').serialize();
        var dateStart = $('#dateStart').val() + " 00:00:00";
        var dateEnd = $('#dateEnd').val() + " 23:59:59";
        $.ajax({
            type: "GET",
            url: "reportTable.php",
            data: form + "&dateStartFull=" + encodeURIComponent(dateStart) + "&dateEndFull=" + encodeURIComponent(dateEnd),
            dataType: "JSON",
            success: function(result) {
                console.log(result); // ตรวจสอบผลลัพธ์ที่ได้
                var reportType = result['type'];
                tableHeader(reportType);
                if (!result.data || result.data.length === 0) {
                    $('#textShow').attr('hidden', false);
                    $('#report_result').attr('hidden', true);
                } else {
                    $('#textShow').attr('hidden', true);
                    $('#report_result').attr('hidden', false);

                    var columns = getColumns(reportType);
                    dataTableCreate(result['data'], columns);
                }
            }

        });
    }

    function getColumns(reportType) {
        switch (reportType) {
            case 'booking':
                return [{
                        "data": "number"
                    },
                    {
                        "data": "bk_startdate"
                    },
                    {
                        "data": "hair_name"
                    },
                    {
                        "data": "bk_price"
                    },
                    {
                        "data": "cus_name"
                    },
                    {
                        "data": "ba_name"
                    }
                ];
            case 'payment':
                return [{
                        "data": "number"
                    },
                    {
                        "data": "bk_startdate"
                    },
                    {
                        "data": "pm_amount"
                    },
                    {
                        "data": "pm_time"
                    },
                    {
                        "data": "cus_name"
                    },
                    {
                        "data": "ba_name"
                    }
                ];
            case 'barber':
                return [{
                        "data": "number"
                    },
                    {
                        "data": "ba_name"
                    },
                    {
                        "data": "ba_idcard"
                    },
                    {
                        "data": "ba_namelocation"
                    },
                    {
                        "data": "total_bookings"
                    },
                    {
                        "data": "total_income"
                    }
                ];
            case 'customer':
                return [{
                        "data": "number"
                    },
                    {
                        "data": "cus_name"
                    },
                    {
                        "data": "cus_lastname"
                    },
                    {
                        "data": "cus_phone"
                    },
                    {
                        "data": "cus_email"
                    },
                    {
                        "data": "total_visits"
                    },
                    {
                        "data": "total_amount"
                    }
                ];
            case 'workschedule':
                return [{
                        "data": "number"
                    },
                    {
                        "data": "ba_name"
                    },
                    {
                        "data": "ws_startdate"
                    },
                    {
                        "data": "ws_enddate"
                    },
                    {
                        "data": "ws_status"
                    }
                ];
        }
    }

    function report_pdf() {
        var dataForm = $('#report_form').serialize();

        // Collect table data
        var tableData = [];
        $('#report_result tbody tr').each(function() {
            var row = $(this).find('td').map(function() {
                return $(this).text();
            }).get();
            tableData.push(row);
        });

        // Convert table data to JSON
        var jsonTableData = JSON.stringify(tableData);

        // Create query string
        var queryString = dataForm + '&tableData=' + encodeURIComponent(jsonTableData);

        // Open reportPDF.php with query string
        window.open('reportPDF.php?' + queryString, '_blank');
    }

    function dataTableCreate(data, columns) {
        if ($.fn.DataTable.isDataTable('#report_result')) {
            $('#report_result').DataTable().destroy();
        }
        $('#report_result').DataTable({
            destroy: true,
            "data": data,
            "columns": columns
        });
    }

    function tableHeader(reportType) {
        var html = '';
        switch (reportType) {
            case 'booking':
                html = `
                   <tr>
                    <th>ลำดับ</th>
                    <th>วันที่จอง</th>
                    <th>ทรงผมที่ตัด</th>
                    <th>ราคา</th>
                    <th>ลูกค้า</th>
                    <th>ชื่อช่าง</th>
                   </tr>
               `;
                break;
            case 'payment':
                html = `
                   <tr>
                    <th>ลำดับ</th>
                    <th>วันที่จอง</th>
                    <th>จำนวนเงิน</th>
                    <th>วันที่ชำระ</th>
                    <th>ลูกค้า</th>
                    <th>ชื่อช่าง</th>
                   </tr>
               `;
                break;
            case 'barber':
                html = `
               <tr>
                   <th>ลำดับ</th>
                   <th>ชื่อช่าง</th>
                   <th>บัตรประชาชน</th>
                   <th>ที่ตั้งร้าน</th>
                   <th>จำนวนครั้งที่ตัดผม</th>
                   <th>ค่าใช้จ่ายทั้งหมด</th>
               </tr>
               `;
                break;
            case 'customer':
                html = `
               <tr>
                   <th>ลำดับ</th>
                   <th>ชื่อลูกค้า</th>
                   <th>นามสกุลลูกค้า</th>
                   <th>เบอร์โทรศัพท์</th>
                   <th>อีเมล</th>
                   <th>จำนวนครั้งที่ใช้บริการ</th>
                   <th>ค่าใช้จ่ายทั้งหมด</th>
               </tr>
               `;
                break;
            case 'workschedule':
                html = `
                   <tr>
                       <th>ลำดับ</th>
                       <th>ชื่อช่าง</th>
                       <th>วันที่เวลาลงงาน</th>
                       <th>วันที่เวลาสิ้นสุด</th>
                       <th>สถานะ</th>
                   </tr>
               `;
                break;
        }
        $('#tableHeader').html(html);
    }
</script>

<?php
$content = ob_get_clean();
include '../template/master.php';
?>