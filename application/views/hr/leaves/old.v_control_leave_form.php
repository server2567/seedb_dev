<?php
/*
	* v_leaves_form_input_1
	* หน้าจอแบบฟอร์มการลาป่วย
	* @input leave_type_id = 1
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-16
	*/
?>
<style>
    .form-check {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .table,
    tr,
    td,
    th {
        vertical-align: middle;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-receipt icon-menu"></i><span> แบบฟอร์มทำเรื่องการลาป่วย</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show mb-3">
                <div class="accordion-body">

                    <!-- Start Leaves Form -->
                    <form id="leaves_form_input" class="needs-validation" method="post" action="<?php echo site_url() . "/" . $controller; ?>leaves_save">



                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="leaves_location_create" class="form-label">เขียนที่</label></div>
                            <div class="col-md-4">
                                <select name="" class="select2" id=""></select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="leaves_location_create" class="form-label">เหตุปฏิบัติราชการ</label></div>
                            <div class="col-md-4">
                                <select name="" class="select2" id=""></select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="leaves_location_create" class="form-label">ชนิดการลา</label></div>
                            <div class="col-md-4">
                                <select name="" class="select2" id=""></select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="leaves_location_create" class="form-label">อายุเริ่มต้นที่ได้รับสิทธิ์การลา</label></div>
                            <div class="col-md-2">
                                <input type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">ปี</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">เดือน</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">วัน</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="leaves_location_create" class="form-label">อายุสิ้นสุดที่ได้รับสิทธิ์การลา</label></div>
                            <div class="col-md-2">
                                <input type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">ปี</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">เดือน</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">วัน</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="leaves_create_date" class="form-label">จำนวนครั้งที่ลาได้</label></div>
                            <div class="col-md-4">
                                <input type="number" id="leaves_create_date" name="leaves_create_date" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input">
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="leaves_create_date" class="form-label">จำนวนวันที่ลาได้ต่อปี</label></div>
                            <div class="col-md-4">
                                <input type="number" id="leaves_create_date" name="leaves_create_date" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input">
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="leaves_create_date" class="form-label">จำนวนวันที่ลาได้ในแต่ละครั้ง</label></div>
                            <div class="col-md-4">
                                <input type="number" id="leaves_create_date" name="leaves_create_date" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input">
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="leaves_create_date" class="form-label">จำนวนวันที่ลาได้ต่อปี รวมกับจำนวนวันสะสม สูงสุด</label></div>
                            <div class="col-md-4">
                                <input type="number" id="leaves_create_date" name="leaves_create_date" class="form-control" value="">
                            </div>
                        </div>
                        <!-- เขียนที่ -->

                        <!-- วันที่ -->

                        <!-- สิ้นสุดการอนุมัติ -->
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="">ประเภทการนับวันเวลา</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="form-check-input" name="date"><label for="" class="form-label">วันทำการ</label>&nbsp;&nbsp;&nbsp;<input type="radio" class="form-check-input" name="date"><label for="" class="form-label">วันปกติ</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="">สถานะการได้รับเงินเดือน</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="form-check-input" name="salary"><label for="">ได้รับเงินเดือน</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="salary" class="form-check-input"><label for="" class="form-label">ไม่ได้รับเงินเดือน</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="leaves_create_date" class="form-label">จำนวนวันที่อนุญาตให้ลาล่วงหน้า</label></div>
                            <div class="col-md-4">
                                <input type="number" id="leaves_create_date" name="leaves_create_date" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input">
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="leaves_create_date" class="form-label">จำนวนวันที่อนุญาตให้ลาย้อนหลัง</label></div>
                            <div class="col-md-4">
                                <input type="number" id="leaves_create_date" name="leaves_create_date" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input">
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="">สถานะการได้รับเงินเดือน</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="form-check-input" name="sex"><label for="">ไม่ระบุ</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="sex" class="form-check-input"><label for="" class="form-label">ชาย</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="sex" class="form-check-input"><label for="" class="form-label">หญิง</label>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url() . '/' . $controller . 'control_leaves'; ?>'"> ย้อนกลับ</button>
                                <button type="button" class="btn btn-success float-end" onclick="leaves_save_form()">บันทึก</button>
                            </div>
                        </div>
                        <!-- button action form -->
                    </form>
                    <!-- End Leaves Form -->

                </div>
            </div>
        </div>
    </div>
</div>