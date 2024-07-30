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
                                <option value="workschedule">รายงานตารางทำงาน</option>
                                <option value="barber">รายงานช่างตัดผม</option>
                                <option value="customer">รายงานลูกค้า</option>
                                <!-- <option value="hairstyle">รายงานทรงผม</option> -->
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
                <thead id="tableHeader">
                </thead>
                <tbody id="tableBody">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
   function checkreporttype(e){
       console.log($(e).val());
       var report_type = $(e).val();
       if (report_type == "barber" || report_type == "customer" || report_type == "hairstyle"){
           $("#input_date").hide();
       } else {
           $("#input_date").show();
       }
       clearPreviousResults();
   }

   function clearPreviousResults() {
       // ซ่อนข้อความและตารางแสดงผลก่อนหน้านี้
       $('#textShow').attr('hidden', true);
       $('#report_result').attr('hidden', true);
       // ลบข้อมูลใน DataTable ถ้ามี
       if ($.fn.DataTable.isDataTable('#report_result')) {
           $('#report_result').DataTable().clear().destroy();
       }
       // ล้างหัวตาราง
       $('#tableHeader').html('');
   }

   function report_result() {
       var form = $('#report_form').serialize();
       $.ajax({
           type: "GET",
           url: "reportTable.php",
           data: form,
           dataType: "JSON",
           success: function(result) {
               var reportType = result['type'];
               tableHeader(reportType);
               if (!result.data || result.data.length == 0) {
                   $('#textShow').attr('hidden', false);
                   $('#report_result').attr('hidden', true);
               } else {
                   $('#textShow').attr('hidden', true);
                   $('#report_result').attr('hidden', false);

                   var columns = [];
                   if (reportType == 'booking') {
                       columns = [{
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
                   } else if (reportType == 'payment') {
                       columns = [{
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
                   } else if (reportType == 'barber') {
                       columns = [{
                               "data": "number"
                           },
                           {
                               "data": "ba_name"
                           },
                           {
                               "data": "ba_lastname"
                           },
                           {
                               "data": "ba_idcard"
                           },
                           {
                               "data": "ba_namelocation"
                           }
                       ];
                   } else if (reportType == 'customer') {
                       columns = [{
                               "data": "number"
                           },
                           {
                               "data": "cus_name"
                           },
                           {
                               "data": "cus_lastname"
                           },
                           {
                               "data": "cus_email"
                           }
                       ];
                   } else if (reportType == 'workschedule') {
                       columns = [{
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
                   
                   dataTableCreate(result['data'], columns);
               }
           }
       });
   }

   function report_pdf() {
       var dataForm = $('#report_form').serialize();
       window.open('reportPDF.php?' + dataForm, '_blank');
   }

   function dataTableCreate(data, columns) {
       console.log(data);
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
       if (reportType == 'booking') {
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
       } else if (reportType == 'payment') {
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
       } else if (reportType == 'barber') {
           html = `
               <tr>
                   <th>ลำดับ</th>
                   <th>ชื่อช่าง</th>
                   <th>นามสกุล</th>
                   <th>บัตรประชาชน</th>
                   <th>ที่ตั้งร้าน</th>
               </tr>
           `;
       } else if (reportType == 'customer') {
           html = `
               <tr>
                   <th>ลำดับ</th>
                   <th>ชื่อลูกค้า</th>
                   <th>นามสกุล</th>
                   <th>อีเมล</th>
               </tr>
           `;
       } else if (reportType == 'workschedule') {
           html = `
               <tr>
                   <th>ลำดับ</th>
                   <th>ชื่อช่าง</th>
                   <th>วันที่เริ่มงาน</th>
                   <th>วันที่สิ้นสุด</th>
                   <th>สถานะ</th>
               </tr>
           `;
       } 
    //    else if (reportType == 'hairstyle') {
    //        html = `
    //            <tr>
    //                <th>ลำดับ</th>
    //                <th>ชื่อทรงผม</th>
    //                <th>รายละเอียดทรงผม</th>
    //                <th>ราคา</th>
    //            </tr>
    //        `;
    //    }
       $('#tableHeader').html(html);
   }
</script>

<?php
$content = ob_get_clean();
include '../template/master.php';
?>
ผ