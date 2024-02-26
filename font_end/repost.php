<?php
ob_start();
?>

<!-- เนื้อหาเฉพาะหน้าของคุณ -->
<br>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>ค้นหารายงาน</h2>
                <form>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="income">รายได้ที่ทำได้ต่อวัน:</label>
                                <select id="income" name="income" class="form-control">
                                    <option value="">เลือกรายได้ที่ทำได้ต่อวัน</option>
                                    <option value="low">น้อยกว่า 500 บาทต่อวัน</option>
                                    <option value="medium">500 - 1000 บาทต่อวัน</option>
                                    <option value="high">มากกว่า 1000 บาทต่อวัน</option>
                                    <!-- เพิ่มตัวเลือกตามที่ต้องการ -->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="booking_queue">คิวการจอง:</label>
                                <select id="booking_queue" name="booking_queue" class="form-control">
                                    <option value="">เลือกคิวการจอง</option>
                                    <option value="available">มีที่ว่าง</option>
                                    <option value="full">เต็ม</option>
                                    <!-- เพิ่มตัวเลือกตามที่ต้องการ -->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="payment">การชำระเงิน:</label>
                                <select id="payment" name="payment" class="form-control">
                                    <option value="">เลือกการชำระเงิน</option>
                                    <option value="credit_card">บัตรเครดิต</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="bank_transfer">การโอนเงินผ่านธนาคาร</option>
                                    <!-- เพิ่มตัวเลือกตามที่ต้องการ -->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="button" onclick="get_repost()" class="btn btn-primary">ส่งรายงาน</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- สร้างคอลัมน์ที่สองสำหรับ col-md-6 ข้างบน -->
        <div class="col-md-12">
            <!-- ทำสิ่งที่คุณต้องการในคอลัมน์นี้ -->
        </div>
    </div>
    <script>
        function get_repost(){
            let val_sel = $("#income").val();
            console.log(val_sel);
            if(val_sel == 'low'){

            }else if(val_sel == 'medium'){

            }else if(val_sel == 'high'){

            }
            let val_queue = $("#booking_queue").val();
            console.log(val_queue);
            if(val_queue == 'available'){

            }else if(val_queue == 'full'){}

        }
    
    </script>
</body>
<!-- ... -->

<?php
$content = ob_get_clean();
include '../template/master.php';
?>
