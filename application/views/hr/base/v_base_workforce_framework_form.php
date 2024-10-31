<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($bwfw_info) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลชั่วโมงการปฏิบัติงาน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-4">
                            <label for="StNameT" class="form-label required">ชื่อรูปแบบปฏิบัติงาน (ภาษาไทย) </label>
                            <?php if (!empty($bwfw_info->bwfw_id)) {  ?>
                                <input type="text" name="workforce_framework[]" id="bwfw_id" value="<?php echo !empty($bwfw_info) ? $bwfw_info->bwfw_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="workforce_framework[]" id="bwfw_name_th" placeholder="ชื่อรูปแบบปฏิบัติงาน (ภาษาไทย)" value="<?php echo !empty($bwfw_info) ? $bwfw_info->bwfw_name_th : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="bwfw_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="StNameT" class="form-label">ชื่อรูปแบบปฏิบัติงาน (ภาษาอังกฤษ) </label>
                            <input type="text" class="form-control mb-1" name="workforce_framework[]" id="bwfw_name_en" placeholder="ชื่อรูปแบบปฏิบัติงาน (ภาษาอังกฤษ)" value="<?php echo !empty($bwfw_info) ? $bwfw_info->bwfw_name_en : ""; ?>" required>
                        </div>
                        <?php
                            // ตรวจสอบว่ามีข้อมูล bwfw_hour หรือไม่
                            if (!empty($bwfw_info)) {
                                // แยกค่า bwfw_hour ออกเป็นชั่วโมงและนาที
                                $time_parts = explode(":", $bwfw_info->bwfw_hour);
                                $hour_value = $time_parts[0];  // ค่าชั่วโมง
                                $minute_value = isset($time_parts[1]) ? $time_parts[1] : 0;  // ค่านาที (ถ้าไม่มี, ให้เป็น 0)
                            } else {
                                // ถ้าไม่มีข้อมูล, กำหนดค่าเริ่มต้นเป็นค่าว่าง
                                $hour_value = 200;
                                $minute_value = 0;
                            }
                        ?>
                        <div class="col-4">
                            <label for="StisHour" class="form-label required">จำนวนเวลาปฏิบัติงาน</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="ชั่วโมง" aria-label="จำนวนชั่วโมง" id="bwfw_time_hour" name="workforce_framework_hour" min="0" value="<?php echo $hour_value; ?>">
                                <span class="input-group-text">ชั่วโมง</span>
                                <input type="number" class="form-control" placeholder="นาที" aria-label="จำนวน นาที" id="bwfw_time_minute" name="workforce_framework_minute" min="0" max="59" value="<?php echo $minute_value; ?>">
                                <span class="input-group-text">นาที</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="StisMedical" class="form-label required">สายงาน</label>
                            <div class="form-check">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="option_bwfw_is_medical" value="M" id="bwfw_is_medical_1" <?php echo !empty($bwfw_info) && $bwfw_info->bwfw_is_medical == "M" ? 'checked' :  'checked' ?>>
                                    <label for="bwfw_is_medical_1" class="form-check-label">สายแพทย์</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="option_bwfw_is_medical" value="N" id="bwfw_is_medical_2" <?php echo !empty($bwfw_info) && $bwfw_info->bwfw_is_medical == "N" ? 'checked' :  '' ?>>
                                    <label for="bwfw_is_medical_2" class="form-check-label">สายการพยาบาล</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="option_bwfw_is_medical" value="SM" id="bwfw_is_medical_3" <?php echo !empty($bwfw_info) && $bwfw_info->bwfw_is_medical == "SM" ? 'checked' :  '' ?>>
                                    <label for="bwfw_is_medical_3" class="form-check-label">สายสนับสนุนทางการแพทย์</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="option_bwfw_is_medical" value="A" id="bwfw_is_medical_4" <?php echo !empty($bwfw_info) && $bwfw_info->bwfw_is_medical == "A" ? 'checked' :  '' ?>>
                                    <label for="bwfw_is_medical_4" class="form-check-label">สายบริหาร</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="option_bwfw_is_medical" value="T" id="bwfw_is_medical_5" <?php echo !empty($bwfw_info) && $bwfw_info->bwfw_is_medical == "T" ? 'checked' :  '' ?>>
                                    <label for="bwfw_is_medical_5" class="form-check-label">สายเทคนิคและบริการ</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="StisType" class="form-label required">ประเภทการทำงาน</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="option_bwfw_type" value="1" id="bwfw_type" <?php echo !empty($bwfw_info) && $bwfw_info->bwfw_type == 1 ? 'checked' :  'checked' ?>>
                                <label for="StActive" class="form-check-label mb-2">ปฏิบัติงานเต็มเวลา (Full Time)</label> <br>
                                <input class="form-check-input" type="radio" name="option_bwfw_type" value="2" id="bwfw_type2" <?php echo !empty($bwfw_info) && $bwfw_info->bwfw_type == 2 ? 'checked' :  '' ?>>
                                <label for="StActive" class="form-check-label">ปฏิบัติงานบางส่วนเวลา (Part Time)</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="StActive" class="form-label">สถานะการใช้งาน</label>
                            <div class="form-check">
                                <?php if (!empty($bwfw_info->bwfw_id)) { ?>
                                    <input class="form-check-input" type="checkbox" name="workforce_framework[]" id="bwfw_active" value="<?php echo !empty($bwfw_info) ? $bwfw_info->bwfw_active : '' ?>" <?php echo !empty($bwfw_info) && $bwfw_info->bwfw_active == '1' ? 'checked' : '' ?>>
                                <?php } else { ?>
                                    <input type="checkbox" id="bwfw_active" class="form-check-input m-1" checked disabled>
                                <?php } ?>
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/workforce_framework'">ย้อนกลับ</button>
                            <?php if (!empty($bwfw_info->bwfw_id)) { ?>
                                <button type="button" onclick="submitEdit()" class="btn btn-success float-end">บันทึก</button>
                            <?php } else { ?>
                                <button type="button" onclick="submitAdd()" class="btn btn-success float-end">บันทึก</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var formData = {};

    function submitAdd() {
        $('[name^="workforce_framework"]').each(function() {
            var checkbox = document.getElementById('bwfw_active');
            if (this.id != 'bwfw_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        const option_bwfw_type = document.querySelectorAll('input[name="option_bwfw_type"]');
        option_bwfw_type.forEach((radio) => {
            if (radio.checked) {
                formData['bwfw_type'] = radio.value;
            }
        });
        const option_bwfw_is_medical = document.querySelectorAll('input[name="option_bwfw_is_medical"]');
        formData['bwfw_is_medical'] = null;
        option_bwfw_is_medical.forEach((radio) => {
            if (radio.checked) {
                formData['bwfw_is_medical'] = radio.value;
            }
        });
      
        delete formData.bwfw_id;
        if (!formData.bwfw_name_th) {
            !formData.bwfw_name_th ? $('#bwfw_name_th').get(0).focus() : '';

            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'workforce_framework/checkValue'; ?>',
            method: 'POST',
            data: {
                bwfw_name_th: formData['bwfw_name_th'],
                bwfw_name_en: formData['bwfw_name_en'],
                bwfw_time_hour: formData['bwfw_time_hour'],
                bwfw_time_minute: formData['bwfw_time_minute'],
                bwfw_type: formData['bwfw_type'],
                bwfw_is_medical: formData['bwfw_is_medical']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('bwfw_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'รูปแบบปฏิบัติงานนี้ถูกใช้งานแล้ว'
                });
                $('#bwfw_name_th').get(0).focus()
                inputElement.innerHTML = "รูปแบบปฏิบัติงานนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'workforce_framework/workforce_framework_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo base_url() ?>index.php/hr/base/workforce_framework'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="workforce_framework"]').each(function() {
            var checkbox = document.getElementById('bwfw_active');
            if (this.id != 'bwfw_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        const option_bwfw_type = document.querySelectorAll('input[name="option_bwfw_type"]');
        option_bwfw_type.forEach((radio) => {
            if (radio.checked) {
                formData['bwfw_type'] = radio.value;
            }
        });
        const option_bwfw_is_medical = document.querySelectorAll('input[name="option_bwfw_is_medical"]');
        formData['bwfw_is_medical'] = null;
        option_bwfw_is_medical.forEach((radio) => {
            if (radio.checked) {
                formData['bwfw_is_medical'] = radio.value;
            }
        });
        if (!formData.bwfw_name_th) {
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'workforce_framework/checkValue'; ?>',
            method: 'POST',
            data: {
                bwfw_name_th: formData['bwfw_name_th'],
                bwfw_name_en: formData['bwfw_name_en'],
                bwfw_id: formData['bwfw_id'],
                bwfw_time_hour: formData['bwfw_time_hour'],
                bwfw_time_minute: formData['bwfw_time_minute'],
                bwfw_type: formData['bwfw_type'],
                bwfw_is_medical: formData['bwfw_is_medical']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('bwfw_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'รูปแบบปฏิบัติงานนี้ถูกใช้งานแล้ว'
                });
                $('#bwfw_name_th').get(0).focus()
                inputElement.innerHTML = "รูปแบบปฏิบัติงานนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'workforce_framework/workforce_framework_update'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo base_url() ?>index.php/hr/base/workforce_framework'
                    }, 1500);
                })
            }
        })
    }
</script>