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
                    <div class="col-md-12 ">
                        <div class="form-group">
                            <label for="report_type">ประเภทรายงาน:</label>
                            <select id="report_type" name="report_type" class="form-control">
                                <option value="booking">รายงานการจอง</option>
                                <option value="payment">รายงานการชำระเงิน</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">วันที่เริ่ม:</label>
                            <input type="date" id="dateStart" name="dateStart" class="form-control" value="<?php echo date("Y-m-d") ?>">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">วันที่สิ้นสุด:</label>
                            <input type="date" id="dateEnd" name="dateEnd" class="form-control" value="<?php echo date("Y-m-d") ?>">
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
            <h2 id="textShow" hidden class="text-center"> ไม่พบข้อมูล </h2>
            <table id="report_result" class="table table-striped table-hover table-responsive table-bordered" hidden>
                <thead id="tableHeder">
                    
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    function report_result() {
        var form = $('#report_form').serialize();
        $.ajax({
            type: "GET",
            url: "reportTable.php",
            data: form,
            dataType: "JSON",
            success: function(result) {
                if (result.length == 0) {
                    $('#textShow').attr('hidden', false);
                    $('#report_result').attr('hidden', true);

                } else {
                    var reportType = result['type'];
                    $('#textShow').attr('hidden', true);
                    $('#report_result').attr('hidden', false);
                    tableHeader(reportType);
                    if(reportType == 'booking'){
                        var columns = [
                            { "data": "number" },
                            { "data": "bk_startdate" },
                            { "data": "hair_name" },
                            { "data": "bk_price" },
                            { "data": "cus_name" },
                            { "data": "ba_name" }
                        ];
                    }else if(reportType == 'payment'){
                        var columns = [
                            { "data": "number" },
                            { "data": "bk_startdate" },
                            { "data": "pm_amount" },
                            { "data": "pm_time" },
                            { "data": "cus_name" },
                            { "data": "ba_name" }
                        ];
                    }
                    dataTableCreate(result['data'],columns);
                }
            }
        });
    }
    function report_pdf(){
        var dataForm = $('#report_form').serialize();
        window.open('reportPDF.php?' + dataForm, '_blank');
    }
    function dataTableCreate(result,columns) {
        var dataTable = $('#report_result').DataTable();
        if ($.fn.DataTable.isDataTable('#report_result')) {
            dataTable.destroy();
        }
        $('#report_result').DataTable({
            "data": result, // Assuming result is already in the correct format
            "columns": columns
        });
    }
    function tableHeader(reportType){
        if(reportType == 'booking'){
            var html = `
                <tr>
                    <th>ลำดับ</th>
                    <th>วันที่จอง</th>
                    <th>ทรงผมที่ตัด</th>
                    <th>ราคา</th>
                    <th>ลูกค้า</th>
                    <th>ชื่อช่าง</th>
                </tr>
            `;
        }else if(reportType == 'payment'){
            var html = `
                <tr>
                    <th>ลำดับ</th>
                    <th>วันที่จอง</th>
                    <th>จำนวนเงิน</th>
                    <th>วันที่ชำระ</th>
                    <th>ลูกค้า</th>
                    <th>ชื่อช่าง</th>
                </tr>
            `;
        }
        $('#tableHeder').html(html);
        
    }
</script>

<?php
$content = ob_get_clean();
include '../template/master.php';
?>