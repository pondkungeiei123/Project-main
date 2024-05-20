<?php
ob_start();
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2>รายงาน</h2>
            <form id="report_form" action="report_Processing.php" method="post">
                <div class="row">
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="report_type">ประเภทรายงาน:</label>
                            <select id="report_type" name="report_type" class="form-control">
                                <option value="booking">รายงานการจอง</option>
                                <option value="payment">รายงานการชำระเงิน</option>
                                <option value="income">รายงานรายได้</option>
                                <option value="working">รายงานการทำงานของช่างตัดผม</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่เริ่ม:</label>
                            <input type="date" id="date" name="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่สิ้นสุด:</label>
                            <input type="date" id="date" name="date" class="form-control">
                        </div>
                    </div>
                    

                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">ส่งรายงาน</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>

<div id="report_result" class="row mt-4">
    <!-- ที่นี่คือส่วนที่จะแสดงผลรายงาน -->
</div>
</div>

<?php
$content = ob_get_clean();
include '../template/master.php';
?>