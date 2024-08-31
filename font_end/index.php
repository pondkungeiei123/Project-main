<?php
ob_start();
?>
<div class="row mt-5">
    <div class="col-md-12 text-center">
    <h3 class="header-title">หน้าตรวจสอบข้อมูล</h3>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <figure class="highcharts-figure">
                <div id="area-container"></div> <!-- สำหรับกราฟพื้นที่ -->
            </figure>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <figure class="highcharts-figure">
                <div id="bar-container"></div> <!-- สำหรับกราฟแท่ง -->
            </figure>
        </div>
        <div class="col-md-6">
            <figure class="highcharts-figure">
                <div id="pie-container"></div> <!-- สำหรับกราฟวงกลม -->
            </figure>
        </div>
    </div>
</div>
<script src="../asset/demo/chart-area-demo.js"></script>
<script src="../asset/demo/chart-bar-demo.js"></script>
<script src="../asset/demo/chart-pie-demo.js"></script>

<?php
$content = ob_get_clean();
include '../template/master.php';
?>
