<?php
/*
	* v_control_leaves_form_common
	* หน้าจอแบบฟอร์มข้อมูลกฏการลา
	* @input leave_type_id = 1
	* $output -
	* @author Patcharapol  Sirimaneechot
	* @Create Date 2567-10-07
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
<?php
    if ($action_code == 'update') {
        $leave_control = $leave_control[0];
        // print_r($leave_control);
        // print_r($leave);
    }
?>
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
                    <?php 
                        if ($action_code == "add") {
                            $url = site_url() . "/" . $controller_dir . "control_leaves/control_leave_store"; 
                        } else if ($action_code == "update") {
                            $url = site_url() . "/" . $controller_dir . "control_leaves/control_leave_update_store/" . encrypt_id($leave_control['ctrl_id']); 
                        }
                                    
                        ?>
                    <!-- <form id="leaves_form_input" class="needs-validation novalidate" method="post" action="<?php // echo $url; ?>"> -->
                    <!-- <form id="leaves_form_input" method="post" action="<? //echo $url; ?>"> -->
                    <form id="leaves_form_input" class="needs-validation was-validated" novalidate="" method="post" action="<?= $url; ?>">
                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="ctrl_hire_id" class="form-label">สายปฏิบัติงาน</label></div>
                            <div class="col-md-4">
                                <select name="ctrl_hire_id" class="select2" id="ctrl_hire_id">
                                    <option value="-1" disabled>-- เลือกสายปฏิบัติงาน --</option>
                                    <!-- <?php 
                                        foreach ($hire_is_medical as $h) {
                                            if ($action_code == 'update') {
                                                if ($h['code'] == $leave_control['code']) {
                                                    echo "<option selected value=".$h['code'].">".$h['detail']."</option>";
                                                } else {
                                                    echo "<option value=".$h['code'].">".$h['detail']."</option>";
                                                }
                                            } else {
                                                echo "<option value=".$h['code'].">".$h['detail']."</option>";
                                            }
                                        }
                                    ?> -->
                                    <?php
                                        // Assuming $hire_is_medical is already available as an array
                                        $medical_types = [
                                            'M'  => 'สายการแพทย์',
                                            'N'  => 'สายการพยาบาล',
                                            'SM' => 'สายสนับสนุนทางการแพทย์',
                                            'T'  => 'สายเทคนิคและบริการ',
                                            'A'  => 'สายบริหาร'
                                        ];

                                        // Loop through hire_is_medical and display corresponding options
                                        foreach ($this->session->userdata('hr_hire_is_medical') as $value) {
                                            $type = $value['type'];
                                            $selected = "";
                                            if ($action_code == 'update') {
                                                if ($type == $leave_control['ctrl_hire_id']) {
                                                    $selected = "selected";
                                                }
                                                else{
                                                    $selected = "";
                                                }
                                            }
                                            echo '<option value="' . $type . '" '.$selected.'>' . $medical_types[$type] . '</option>';
                                        }
                                    ?>
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
                            <div class="col-md-3 text-start"><label for="ctrl_leave_id" class="form-label">ประเภทการลา</label></div>
                            <div class="col-md-4">
                                <select name="ctrl_leave_id" class="select2" id="ctrl_leave_id">
                                    <option value="-1" disabled>-- เลือกประเภทการลา --</option>
                                    <?php 
                                        if ($action_code == 'update' || $action_code == 'add') {
                                            foreach ($leave as $l) {
                                                if ($l['leave_id'] == $leave_control['ctrl_leave_id']) {
                                                    echo "<option selected value=".$l['leave_id'].">".$l['leave_name']."</option>";
                                                } else {
                                                    echo "<option value=".$l['leave_id'].">".$l['leave_name']."</option>";
                                                }
                                            }
                                        } else {
                                            echo "<option value=".$l['leave_id'].">".$l['leave_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="ctrl_start_age" class="form-label">อายุเริ่มต้นที่ได้รับสิทธิ์การลา</label></div>
                            <div class="col-md-2">
                                <?php if ($action_code == 'update') { ?>
                                    <div class="input-group">
                                        <input max=99 value="<?= $leave_control['ctrl_start_age_y']; ?>" name="ctrl_start_age_y" required min="0" type="number" class="form-control">
                                        <span class="input-group-text" id="basic-addon2">ปี</span>
                                    </div>
                                <?php } else { ?>
                                    <div class="input-group">
                                        <input max=99 value=0 name="ctrl_start_age_y" required min="0" type="number" class="form-control">
                                        <span class="input-group-text" id="basic-addon2">ปี</span>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- <div class="col-md-1">
                                <label class="form-label">ปี</label>
                            </div> -->
                            <div class="col-md-2">
                                <?php if ($action_code == 'update') { ?>
                                    <div class="input-group">
                                        <input max=11 value="<?= $leave_control['ctrl_start_age_m']; ?>" name="ctrl_start_age_m" required min="0" type="number" class="form-control">
                                        <span class="input-group-text" id="basic-addon2">เดือน</span>
                                    </div>
                                <?php } else { ?>
                                    <div class="input-group">
                                        <input max=11 value=0 name="ctrl_start_age_m" required min="0" type="number" class="form-control">
                                        <span class="input-group-text" id="basic-addon2">เดือน</span>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- <div class="col-md-1">
                                <label class="form-label">เดือน</label>
                            </div> -->
                            <div class="col-md-2">
                                <?php if ($action_code == 'update') { ?>
                                    <div class="input-group">
                                        <input max=29 value="<?= $leave_control['ctrl_start_age_d']; ?>" name="ctrl_start_age_d" required min="0" type="number" class="form-control">
                                        <!-- <input max=99 value="<?= $leave_control['ctrl_start_age_d']; ?>" name="ctrl_start_age_d" required min="0" type="number" class="form-control"> -->
                                        <span class="input-group-text" id="basic-addon2">วัน</span>
                                    </div>
                                <?php } else { ?>
                                    <div class="input-group">
                                        <input max=29 value=0 name="ctrl_start_age_d" required min="0" type="number" class="form-control">
                                        <!-- <input max=99 value=0 name="ctrl_start_age_d" required min="0" type="number" class="form-control"> -->
                                        <span class="input-group-text" id="basic-addon2">วัน</span>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- <div class="col-md-1">
                                <label class="form-label">วัน</label>
                            </div> -->
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 text-start"><label for="ctrl_end_age" class="form-label">อายุสิ้นสุดที่ได้รับสิทธิ์การลา</label></div>
                            <div class="col-md-2">
                                <?php if ($action_code == 'update') { ?>
                                    <div class="input-group">
                                        <input max=99 value="<?= $leave_control['ctrl_end_age_y']; ?>" name="ctrl_end_age_y" required min="0" type="number" class="form-control">
                                        <span class="input-group-text" id="basic-addon2">ปี</span>
                                    </div>
                                <?php } else { ?>
                                    <div class="input-group">
                                        <input max=99 value=0 name="ctrl_end_age_y" required min="0" type="number" class="form-control">
                                        <span class="input-group-text" id="basic-addon2">ปี</span>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- <div class="col-md-1">
                                <label class="form-label">ปี</label>
                            </div> -->
                            <div class="col-md-2">
                                <?php if ($action_code == 'update') { ?>
                                    <div class="input-group">
                                        <input max=99 value="<?= $leave_control['ctrl_end_age_m']; ?>" name="ctrl_end_age_m" required min="0" type="number" class="form-control">
                                        <span class="input-group-text" id="basic-addon2">เดือน</span>
                                    </div>
                                <?php } else { ?>
                                    <div class="input-group">
                                        <input max=99 value=0 name="ctrl_end_age_m" required min="0" type="number" class="form-control">
                                        <span class="input-group-text" id="basic-addon2">เดือน</span>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- <div class="col-md-1">
                                <label class="form-label">เดือน</label>
                            </div> -->
                            <div class="col-md-2">
                                <?php if ($action_code == 'update') { ?>
                                    <div class="input-group">
                                        <input max=30 value="<?= $leave_control['ctrl_end_age_d']; ?>" name="ctrl_end_age_d" required min="0" type="number" class="form-control">
                                        <!-- <input max=99 value="<?= $leave_control['ctrl_end_age_d']; ?>" name="ctrl_end_age_d" required min="0" type="number" class="form-control"> -->
                                        <span class="input-group-text" id="basic-addon2">วัน</span>
                                    </div>
                                <?php } else { ?>
                                    <div class="input-group">
                                        <input max=30 value=0 name="ctrl_end_age_d" required min="0" type="number" class="form-control">
                                        <!-- <input max=99 value=0 name="ctrl_end_age_d" required min="0" type="number" class="form-control"> -->
                                        <span class="input-group-text" id="basic-addon2">วัน</span>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- <div class="col-md-1">
                                <label class="form-label">วัน</label>
                            </div> -->
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_time_per_year" class="form-label">จำนวนครั้งที่ลาได้</label></div>
                            <div class="col-md-8">
                                <!-- <input min="0" type="number" id="ctrl_time_per_year" name="ctrl_time_per_year" class="form-control" value=""> -->
                                <?php if ($action_code == 'update') { ?>
                                    <input id="ctrl_time_per_year" min="0" type="number"  
                                        name="ctrl_time_per_year" 
                                        value="<?php echo $leave_control['ctrl_time_per_year']; ?>" 
                                        class="form-control">
                                        <!-- onload="checkIsSettedUnlimited('ctrl_time_per_year', this.value)" > -->
                                <?php } else { ?>
                                    <input value="-99" id="ctrl_time_per_year" min="0" type="number"  
                                        name="ctrl_time_per_year" 
                                        class="form-control">
                                <?php } ?>
                                
                            </div>
                            <div class="col-md-1">
                                
                                <?php 
                                    /*
                                    if ((int)$leave_control['ctrl_time_per_year'] == -99) { 
                                        echo `
                                            <input checked="true" type="checkbox" class="form-check-input" id="set_unlimited_ctrl_time_per_year" onclick="changeInputUI('ctrl_time_per_year', this.checked)" >
                                            <script>
                                                changeInputUI('ctrl_time_per_year', document.getElementById(set_unlimited_ctrl_time_per_year).checked);
                                            </script>
                                            `;
                                    } else {
                                        echo `
                                            <input type="checkbox" class="form-check-input" id="set_unlimited_ctrl_time_per_year" onclick="changeInputUI('ctrl_time_per_year', this.checked)" >
                                            `;
                                    }
                                    */
                                ?>
                                <!-- <input  id="set_unlimited_ctrl_time_per_year" 
                                        value="<?php // echo $leave_control['ctrl_time_per_year']; ?>" 
                                        type="checkbox" class="form-check-input" 
                                        onload="checkIsSettedUnlimited('ctrl_time_per_year', this.checked)" 
                                        onclick="changeInputUI('ctrl_time_per_year', this.checked)" > -->

                                <input type="checkbox" class="form-check-input" id="set_unlimited_ctrl_time_per_year" onclick="changeInputUI('ctrl_time_per_year', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_day_per_year" class="form-label">จำนวนวันที่ลาได้ต่อปี</label></div>
                            <div class="col-md-8">
                                <?php if($action_code == "update") { ?>
                                    <input value="<?= $leave_control['ctrl_day_per_year']; ?>" min="0" type="number" id="ctrl_day_per_year" name="ctrl_day_per_year" class="form-control">
                                <?php } else { ?>
                                    <input value=0 min="0" type="number" id="ctrl_day_per_year" name="ctrl_day_per_year" class="form-control">
                                <?php } ?>
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input"  id="set_unlimited_ctrl_day_per_year" onclick="changeInputUI('ctrl_day_per_year', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_hour_per_year" class="form-label">จำนวนชั่วโมงที่ลาได้ต่อปี</label></div>
                            <div class="col-md-8">
                                <?php if($action_code == "update") { ?>
                                    <input value="<?= $leave_control['ctrl_hour_per_year']; ?>" min="0" type="number" id="ctrl_hour_per_year" name="ctrl_hour_per_year" class="form-control">
                                <?php } else { ?>
                                    <input value=0 min="0" type="number" id="ctrl_hour_per_year" name="ctrl_hour_per_year" class="form-control">
                                <?php } ?>
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input"  id="set_unlimited_ctrl_hour_per_year" onclick="changeInputUI('ctrl_hour_per_year', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_minute_per_year" class="form-label">จำนวนนาทีที่ลาได้ต่อปี</label></div>
                            <div class="col-md-8">
                                <?php if($action_code == "update") { ?>
                                    <input value="<?= $leave_control['ctrl_minute_per_year']; ?>" min="0" type="number" id="ctrl_minute_per_year" name="ctrl_minute_per_year" class="form-control">
                                <?php } else { ?>
                                    <input value=0 min="0" type="number" id="ctrl_minute_per_year" name="ctrl_minute_per_year" class="form-control">
                                <?php } ?>
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input"  id="set_unlimited_ctrl_minute_per_year" onclick="changeInputUI('ctrl_minute_per_year', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_date_per_time" class="form-label">จำนวนวันที่ลาได้ในแต่ละครั้ง</label></div>
                            <div class="col-md-8">
                                <?php if($action_code == "update") { ?>
                                    <input value="<?= $leave_control['ctrl_date_per_time']; ?>" min="0" type="number" id="ctrl_date_per_time" name="ctrl_date_per_time" class="form-control" value="">
                                <?php } else { ?>
                                    <input value=0 min="0" type="number" id="ctrl_date_per_time" name="ctrl_date_per_time" class="form-control" value="">
                                <?php } ?>
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input" id="set_unlimited_ctrl_date_per_time" onclick="changeInputUI('ctrl_date_per_time', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_pack_per_year" class="form-label">จำนวนวันสะสมสูงสุด</label></div>
                            <div class="col-md-8">
                                <?php if($action_code == "update") { ?>
                                    <input value="<?= $leave_control['ctrl_pack_per_year']; ?>" min="0" type="number" id="ctrl_pack_per_year" name="ctrl_pack_per_year" class="form-control" value="">
                                <?php } else { ?>
                                    <input value=0 min="0" type="number" id="ctrl_pack_per_year" name="ctrl_pack_per_year" class="form-control" value="">
                                <?php } ?>
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
                            <div class="col-md-9">
                            <?php if ($action_code == "update") { ?>
                                    <?php if ($leave_control['ctrl_money'] == 'Y') { ?>
                                        <input required checked="true" value="Y" type="radio" class="form-check-input" name="ctrl_money"><label for="">ได้รับเงินเดือน</label>&nbsp;&nbsp;&nbsp;
                                        <input value="N" type="radio" name="ctrl_money" class="form-check-input"><label for="" class="form-label">ไม่ได้รับเงินเดือน</label>
                                    <?php } else if ($leave_control['ctrl_money'] == 'N')  { ?>
                                        <input required value="Y" type="radio" class="form-check-input" name="ctrl_money"><label for="">ได้รับเงินเดือน</label>&nbsp;&nbsp;&nbsp;
                                        <input checked="true"  value="N" type="radio" name="ctrl_money" class="form-check-input"><label for="" class="form-label">ไม่ได้รับเงินเดือน</label>
                                    <?php } else { ?>
                                        <input required value="Y" type="radio" class="form-check-input" name="ctrl_money"><label for="">ได้รับเงินเดือน</label>&nbsp;&nbsp;&nbsp;
                                        <input value="N" type="radio" name="ctrl_money" class="form-check-input"><label for="" class="form-label">ไม่ได้รับเงินเดือน</label>
                                    <?php } ?>
                                    <?php } else { ?>
                                        <input checked="true" required value="Y" type="radio" class="form-check-input" name="ctrl_money"><label for="">ได้รับเงินเดือน</label>&nbsp;&nbsp;&nbsp;
                                        <!-- <input required value="Y" type="radio" class="form-check-input" name="ctrl_money"><label for="">ได้รับเงินเดือน</label>&nbsp;&nbsp;&nbsp; -->
                                        <input value="N" type="radio" name="ctrl_money" class="form-check-input"><label for="" class="form-label">ไม่ได้รับเงินเดือน</label>
                                    <?php } ?>
                                <!-- <input value="Y" type="radio" class="form-check-input" name="ctrl_money"><label for="">ได้รับเงินเดือน</label>&nbsp;&nbsp;&nbsp;
                                <input value="N" type="radio" name="ctrl_money" class="form-check-input"><label for="" class="form-label">ไม่ได้รับเงินเดือน</label> -->
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_day_before" class="form-label">จำนวนวันที่อนุญาตให้ลาล่วงหน้า</label></div>
                            <div class="col-md-8">
                                <?php if ($action_code == "update") { ?>
                                    <input value="<?= $leave_control['ctrl_day_before']; ?>" min="0" type="number" id="ctrl_day_before" name="ctrl_day_before" class="form-control" >
                                <?php } else { ?>
                                    <input value=0 min="0" type="number" id="ctrl_day_before" name="ctrl_day_before" class="form-control" >
                                <?php } ?>
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input"  id="set_unlimited_ctrl_day_before" onclick="changeInputUI('ctrl_day_before', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 "><label for="ctrl_day_after" class="form-label">จำนวนวันที่อนุญาตให้ลาย้อนหลัง</label></div>
                            <div class="col-md-8">
                                <?php if ($action_code == "update") { ?>
                                    <input value="<?= $leave_control['ctrl_day_after']; ?>"min="0" type="number" id="ctrl_day_after" name="ctrl_day_after" class="form-control" >
                                <?php } else { ?>
                                    <input value=0 min="0" type="number" id="ctrl_day_after" name="ctrl_day_after" class="form-control" >
                                <?php } ?>
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-check-input" id="set_unlimited_ctrl_day_after" onclick="changeInputUI('ctrl_day_after', this.checked)" >
                                <label for="" class="form-label">ไม่จำกัด</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="เพศ">เพศ</label>
                            </div>
                            <div class="col-md-4">
                                <?php if ($action_code == 'update') { ?>
                                    <?php if ((int)$leave_control['ctrl_gd_id'] == 1) { ?>
                                        <input required checked="true" value="1" type="radio" class="form-check-input" name="ctrl_gd_id"><label for="">ไม่ระบุ</label>&nbsp;&nbsp;&nbsp;
                                        <input value="2" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">ชาย</label>&nbsp;&nbsp;&nbsp;
                                        <input value="3" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">หญิง</label>
                                    <?php } else if ((int)$leave_control['ctrl_gd_id'] == 2) { ?>
                                        <input required value="1" type="radio" class="form-check-input" name="ctrl_gd_id"><label for="">ไม่ระบุ</label>&nbsp;&nbsp;&nbsp;
                                        <input checked="true" value="2" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">ชาย</label>&nbsp;&nbsp;&nbsp;
                                        <input value="3" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">หญิง</label>
                                    <?php } else if ((int)$leave_control['ctrl_gd_id'] == 3) { ?>
                                        <input required value="1" type="radio" class="form-check-input" name="ctrl_gd_id"><label for="">ไม่ระบุ</label>&nbsp;&nbsp;&nbsp;
                                        <input value="2" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">ชาย</label>&nbsp;&nbsp;&nbsp;
                                        <input checked="true" value="3" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">หญิง</label>
                                    <?php } else { ?>
                                        <input required value="1" type="radio" class="form-check-input" name="ctrl_gd_id"><label for="">ไม่ระบุ</label>&nbsp;&nbsp;&nbsp;
                                        <input value="2" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">ชาย</label>&nbsp;&nbsp;&nbsp;
                                        <input value="3" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">หญิง</label>
                                    <?php } ?>
                                <?php } else { ?>
                                            <input checked="true" required value="1" type="radio" class="form-check-input" name="ctrl_gd_id"><label for="">ไม่ระบุ</label>&nbsp;&nbsp;&nbsp;
                                            <!-- <input required value="1" type="radio" class="form-check-input" name="ctrl_gd_id"><label for="">ไม่ระบุ</label>&nbsp;&nbsp;&nbsp; -->
                                            <input value="2" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">ชาย</label>&nbsp;&nbsp;&nbsp;
                                            <input value="3" type="radio" name="ctrl_gd_id" class="form-check-input"><label for="" class="form-label">หญิง</label>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="">ประเภทบุคลากร</label>
                            </div>
                            <div class="col-md-9">
                            <?php if ($action_code == "update") { ?>
                                    <?php if ($leave_control['ctrl_hire_type'] == '1') { ?>
                                        <input required checked="true" value="1" type="radio" class="form-check-input" name="ctrl_hire_type"><label for="">ปฏิบัติงานเต็มเวลา (Full-Time)</label>&nbsp;&nbsp;&nbsp;
                                        <input value="2" type="radio" name="ctrl_hire_type" class="form-check-input"><label for="" class="form-label">ปฏิบัติงานบางเวลา (Part-Time)</label>
                                    <?php } else if ($leave_control['ctrl_hire_type'] == '2')  { ?>
                                        <input required value="1" type="radio" class="form-check-input" name="ctrl_hire_type"><label for="">ปฏิบัติงานเต็มเวลา (Full-Time)</label>&nbsp;&nbsp;&nbsp;
                                        <input checked="true"  value="2" type="radio" name="ctrl_hire_type" class="form-check-input"><label for="" class="form-label">ปฏิบัติงานบางเวลา (Part-Time)</label>
                                    <?php } else { ?>
                                        <input required value="1" type="radio" class="form-check-input" name="ctrl_hire_type"><label for="">ปฏิบัติงานเต็มเวลา (Full-Time)</label>&nbsp;&nbsp;&nbsp;
                                        <input value="2" type="radio" name="ctrl_hire_type" class="form-check-input"><label for="" class="form-label">ปฏิบัติงานบางเวลา (Part-Time)</label>
                                    <?php } ?>
                                    <?php } else { ?>
                                        <input checked="true" required value="1" type="radio" class="form-check-input" name="ctrl_hire_type"><label for="">ปฏิบัติงานเต็มเวลา (Full-Time)</label>&nbsp;&nbsp;&nbsp;
                                        <input value="2" type="radio" name="ctrl_hire_type" class="form-check-input"><label for="" class="form-label">ปฏิบัติงานบางเวลา (Part-Time)</label>
                                    <?php } ?>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url() . '/' . $controller . 'control_leaves'; ?>'"> ย้อนกลับ</button>
                                <button type="submit" id="submit-form-button" class="btn btn-success float-end">บันทึก</button>
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

        // console.log(inputElement.value);
        // console.log(checkboxElement.checked);

        if (Number(inputElement.value) == -99) {
            checkboxElement.checked = true;
            changeInputUI(targetInputElementId, true);
        } else {
            checkboxElement.checked = false;
        }
    }
    checkIsSettedUnlimited('ctrl_time_per_year', 'set_unlimited_ctrl_time_per_year');
    checkIsSettedUnlimited('ctrl_day_per_year', 'set_unlimited_ctrl_day_per_year');
    checkIsSettedUnlimited('ctrl_hour_per_year', 'set_unlimited_ctrl_hour_per_year');
    checkIsSettedUnlimited('ctrl_minute_per_year', 'set_unlimited_ctrl_minute_per_year');
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



    /**
   * Initiate Bootstrap validation check
   */
  let btn = document.querySelector('#submit-form-button');
  let myform = document.querySelector('#leaves_form_input');

//   btn.addEventListener('click', function(event) {
    myform.addEventListener('submit', function(event) {
    
    if (!myform.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
    }
    else {
        // form.submit();
        myform.classList.add('was-validated');
        dialog_success({'header': text_toast_save_success_header, 'body': text_toast_save_success_body});
        setTimeout(() => {
            window.location.href='<?php echo site_url() . "/" . $controller_dir . "control_leaves"; ?>';
        }, 1400);

        
    }
    
    // myform.classList.add('was-validated')


    // // window.location.replace('<?php // echo site_url() . "/" . $controller_dir . "control_leaves"; ?>?nocache=' + (new Date()).getTime());
    // window.location.href='<?php // echo site_url() . "/" . $controller_dir . "control_leaves"; ?>';
  }, false);

    
</script>
