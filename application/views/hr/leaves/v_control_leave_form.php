<?php
/*
	* v_control_leaves_edit_form
	* หน้าจอแบบฟอร์มข้อมูลควบคุมการลา
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
                    <i class="bi-receipt icon-menu"></i><span><?= $action; ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show mb-3">
                <div class="accordion-body">

                    <!-- Start Leaves Form -->
                    <!-- <form id="leaves_form_input" class="needs-validation" method="post" action="<?php // echo site_url() . "/" . $controller; ?>leaves_save"> -->
                    <?php $url = site_url() . "/" . $controller_dir . "control_leaves/control_leave_store"; ?>
                    <!-- <form id="leaves_form_input" class="needs-validation" method="post" action="<?= $url; ?>"> -->
                    <form id="leaves_form_input" method="post" action="<?= $url; ?>">
                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="ctrl_hire_id" class="form-label">ประเภทบุคลากร</label></div>
                            <div class="col-md-4">
                                <select name="ctrl_hire_id" class="select2" id="ctrl_hire_id">
                                    <option value="-1" disabled>-- ประเภทบุคลากร --</option>
                                    <option value="M" selected>สายแพทย์</option>
                                    <option value="N" >สายการพยาบาล</option>
                                    <option value="SM" >สายสนับสนุนทางการแพทย์</option>
                                    <option value="A" >สายบริหาร</option>
                                    <option value="T" >สายเทคนิคและบริการ</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="leaves_location_create" class="form-label">เหตุปฏิบัติราชการ</label></div>
                            <div class="col-md-4">
                                <select name="" class="select2" id=""></select>
                            </div>
                        </div> -->
                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="ctrl_lt_id" class="form-label">ชนิดการลา</label></div>
                            <div class="col-md-4">
                                <select name="ctrl_lt_id" class="select2" id="ctrl_lt_id">
                                    <option value="-1" disabled>-- ชนิดการลา --</option>
                                    <?php 
                                        foreach ($leave_type as $l) {
                                            echo "<option value=".$l['lt_id'].">".$l['lt_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="ctrl_start_age" class="form-label">อายุเริ่มต้นที่ได้รับสิทธิ์การลา</label></div>
                            <div class="col-md-2">
                                <input name="ctrl_start_age_y" required min="0" type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">ปี</label>
                            </div>
                            <div class="col-md-2">
                                <input name="ctrl_start_age_m" required min="0" type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">เดือน</label>
                            </div>
                            <div class="col-md-2">
                                <input name="ctrl_start_age_d" required min="0" type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">วัน</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="ctrl_end_age" class="form-label">อายุสิ้นสุดที่ได้รับสิทธิ์การลา</label></div>
                            <div class="col-md-2">
                                <input name="ctrl_end_age_y" required min="0" type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">ปี</label>
                            </div>
                            <div class="col-md-2">
                                <input name="ctrl_end_age_m" required min="0" type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">เดือน</label>
                            </div>
                            <div class="col-md-2">
                                <input name="ctrl_end_age_d" required min="0" type="number" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">วัน</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_time_per_year" class="form-label">จำนวนครั้งที่ลาได้</label></div>
                            <div class="col-md-4">
                                <input min="0" type="number" id="ctrl_time_per_year" name="ctrl_time_per_year" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input" id="set_unlimited_ctrl_time_per_year" onclick="changeInputUI('ctrl_time_per_year', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_day_per_year" class="form-label">จำนวนวันที่ลาได้ต่อปี</label></div>
                            <div class="col-md-4">
                                <input min="0" type="number" id="ctrl_day_per_year" name="ctrl_day_per_year" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input" id="set_unlimited_ctrl_day_per_year" onclick="changeInputUI('ctrl_day_per_year', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_date_per_time" class="form-label">จำนวนวันที่ลาได้ในแต่ละครั้ง</label></div>
                            <div class="col-md-4">
                                <input min="0" type="number" id="ctrl_date_per_time" name="ctrl_date_per_time" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input"  id="set_unlimited_ctrl_date_per_time" onclick="changeInputUI('ctrl_date_per_time', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_pack_per_year" class="form-label">จำนวนวันสะสมสูงสุด</label></div>
                            <div class="col-md-4">
                                <input min="0" type="number" id="ctrl_pack_per_year" name="ctrl_pack_per_year" class="form-control" value="">
                            </div>
                        </div>
                        <!-- เขียนที่ -->

                        <!-- วันที่ -->

                        <!-- สิ้นสุดการอนุมัติ -->
                        <!-- <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="">ประเภทการนับวันเวลา</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="form-check-input" name="date"><label for="" class="form-label">วันทำการ</label>&nbsp;&nbsp;&nbsp;<input type="radio" class="form-check-input" name="date"><label for="" class="form-label">วันปกติ</label>
                            </div>
                        </div> -->
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="">สถานะการได้รับเงินเดือน</label>
                            </div>
                            <div class="col-md-4">
                                <input value="Y" type="radio" class="form-check-input" name="ctrl_money"><label for="">ได้รับเงินเดือน</label>&nbsp;&nbsp;&nbsp;
                                <input value="N" type="radio" name="ctrl_money" class="form-check-input"><label for="" class="form-label">ไม่ได้รับเงินเดือน</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_day_before" class="form-label">จำนวนวันที่อนุญาตให้ลาล่วงหน้า</label></div>
                            <div class="col-md-4">
                                <input min="0" type="number" id="ctrl_day_before" name="ctrl_day_before" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input" id="set_unlimited_ctrl_day_before" onclick="changeInputUI('ctrl_day_before', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_day_after" class="form-label">จำนวนวันที่อนุญาตให้ลาย้อนหลัง</label></div>
                            <div class="col-md-4">
                                <input min="0" type="number" id="ctrl_day_after" name="ctrl_day_after" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input" id="set_unlimited_ctrl_day_after" onclick="changeInputUI('ctrl_day_after', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="เพศ"></label>
                            </div>
                            <div class="col-md-4">
                                <input value="0" type="radio" class="form-check-input" name="ctrl_gd_id"><label for="">ไม่ระบุ</label>&nbsp;&nbsp;&nbsp;
                                <input value="1" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">ชาย</label>&nbsp;&nbsp;&nbsp;
                                <input value="2" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">หญิง</label>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url() . '/' . $controller . 'control_leaves'; ?>'"> ย้อนกลับ</button>
                                <button type="submit" class="btn btn-success float-end">บันทึก</button>
                                <!-- <button type="button" onclick="submitForm('insert')" class="btn btn-success float-end">บันทึก</button> -->
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

<script>
    function checkIsSettedUnlimited(targetInputElementId, targetCheckboxElementId) {
        let inputElement = document.getElementById(targetInputElementId);
        let checkboxElement = document.getElementById(targetCheckboxElementId);

        console.log(inputElement.value);
        console.log(checkboxElement.checked);

        if (Number(inputElement.value) == -99) {
            checkboxElement.checked = true;
            changeInputUI(targetInputElementId, true);
        } else {
            checkboxElement.checked = false;
        }
    }
    checkIsSettedUnlimited('ctrl_time_per_year', 'set_unlimited_ctrl_time_per_year');
    checkIsSettedUnlimited('ctrl_day_per_year', 'set_unlimited_ctrl_day_per_year');
    checkIsSettedUnlimited('ctrl_date_per_time', 'set_unlimited_ctrl_date_per_time');
    checkIsSettedUnlimited('ctrl_day_before', 'set_unlimited_ctrl_day_before');
    checkIsSettedUnlimited('ctrl_day_after', 'set_unlimited_ctrl_day_after');

    function changeInputUI(targetInputElementId, checked) {
        let element = document.getElementById(targetInputElementId);
        // console.log(targetInputElementId);
        // console.log(checked);
        // console.log(element.style.color);

        if (checked) {
            element.style.color = "transparent";
            element.value = -99;
            element.disabled = true;
            // console.log(element.value);
        } else {
            element.style.color = "#212529";
            element.value = 0;
            element.disabled = false;
            // console.log(element.value);
        }
    }
</script>

<script>
    function submitForm(actionType) {
        var form = $('#leaves_form_input')[0];

        var form_leaves_form_input = new FormData(form);
        // form_leaves_form_input.append('action', actionType);

        console.log(form_leaves_form_input);

        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir . "control_leaves/control_leave_store"; ?>',
            type: 'POST',
            data: form_leaves_form_input,
            success: function(response) {
                console.log(response);
            }
            // data: form_leaves_form_input,
            // processData: false,
            // contentType: false,
            // success: function(response) {
            //     var data = JSON.parse(response);
            //     if (data.status_response == status_response_success) {
            //         dialog_success({'header': text_toast_save_success_header, 'body': data.message_dialog}, data.return_url, false);
            //     } else if (data.status_response == status_response_error) {
            //         dialog_error({'header':text_toast_default_error_header, 'body': data.message_dialog});
            //     } 
            // },
            // error: function(xhr, status, error) {
            //     dialog_error({'header': text_toast_default_error_header, 'body': text_toast_default_error_body});
            // }
        });
    }
</script>