<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($hire_info) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลประเภทบุคลากร</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อประเภทบุคลากร </label>
                            <?php if (!empty($hire_info->hire_id)) { ?>
                                <input type="text" name="hire[]" id="hire_id" value="<?php echo !empty($hire_info) ? $hire_info->hire_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="hire[]" id="hire_name" placeholder="ชื่อประเภทบุคลากร" value="<?php echo !empty($hire_info) ? $hire_info->hire_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="hire_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StNameE" class="form-label required">ชื่อย่อประเภทบุคคลากร</label>
                            <input type="text" class="form-control" name="hire[]" id="hire_abbr" placeholder="ชื่อย่อประเภทบุคคลากร" value="<?php echo !empty($hire_info) ? $hire_info->hire_abbr : ""; ?>" required>
                        </div>
                        <div class="col-4">
                            <label for="StActive" class="form-label required">ประเภทการปฏิบัติงาน</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="option" value="1" id="hire_type" <?php echo !empty($hire_info) && $hire_info->hire_type == 1 ? 'checked' :  '' ?>>
                                <label for="StActive" class="form-check-label mb-2">ปฏิบัติงานเต็มเวลา (Full Time)</label> <br>
                                <input class="form-check-input" type="radio" name="option" value="2" id="hire_type2" <?php echo !empty($hire_info) && $hire_info->hire_type == 2 ? 'checked' :  '' ?>>
                                <label for="StActive" class="form-check-label">ปฏิบัติงานบางส่วนเวลา (Part Time)</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="StActive" class="form-label required">สายบุคลากร</label>
                            <div class="form-check">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="typeOption" value="M" id="hire_is_medical_1" <?php echo !empty($hire_info) && $hire_info->hire_is_medical == "M" ? 'checked' :  '' ?>>
                                    <label for="hire_is_medical_1" class="form-check-label">สายการแพทย์</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="typeOption" value="N" id="hire_is_medical_2" <?php echo !empty($hire_info) && $hire_info->hire_is_medical == "N" ? 'checked' :  '' ?>>
                                    <label for="hire_is_medical_2" class="form-check-label">สายการพยาบาล</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="typeOption" value="SM" id="hire_is_medical_3" <?php echo !empty($hire_info) && $hire_info->hire_is_medical == "SM" ? 'checked' :  '' ?>>
                                    <label for="hire_is_medical_3" class="form-check-label">สายสนับสนุนทางการแพทย์</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="typeOption" value="A" id="hire_is_medical_4" <?php echo !empty($hire_info) && $hire_info->hire_is_medical == "A" ? 'checked' :  '' ?>>
                                    <label for="hire_is_medical_4" class="form-check-label">สายบริหาร</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="typeOption" value="T" id="hire_is_medical_5" <?php echo !empty($hire_info) && $hire_info->hire_is_medical == "T" ? 'checked' :  '' ?>>
                                    <label for="hire_is_medical_5" class="form-check-label">สายเทคนิคและบริการ</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="StActive" class="form-label">สถานะการใช้งาน</label>
                            <div class="form-check">
                                <?php if (!empty($hire_info->hire_id)) { ?>
                                    <input class="form-check-input" type="checkbox" name="hire[]" id="hire_active" value="<?php echo !empty($hire_info) ? $hire_info->hire_active : '' ?>" <?php echo !empty($hire_info) && $hire_info->hire_active == '1' ? 'checked' : '' ?>>
                                <?php } else { ?>
                                    <input type="checkbox" id="hire_active" class="form-check-input m-1" checked disabled>
                                <?php } ?>
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/hire'">ย้อนกลับ</button>
                            <?php if (!empty($hire_info->hire_id)) { ?>
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
        $('[name^="hire"]').each(function() {
            var checkbox = document.getElementById('hire_active');
            if (this.id != 'hire_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        const radios = document.querySelectorAll('input[name="option"]');
        formData['hire_type'] = null;
        radios.forEach((radio) => {
            if (radio.checked) {
                formData['hire_type'] = radio.value;
            }
        });
        const radios2 = document.querySelectorAll('input[name="typeOption"]');
        formData['hire_is_medical'] = null;
        radios2.forEach((radio) => {
            if (radio.checked) {
                formData['hire_is_medical'] = radio.value;
            }
        });
        delete formData.hire_id;
        if (!formData.hire_name || !formData.hire_abbr || formData.hire_type == null) {
            !formData.hire_name ? $('#hire_name').get(0).focus() : '';
            !formData.hire_abbr ? $('#hire_abbr').get(0).focus() : '';
            !formData.hire_type ? $('#hire_type').get(0).focus() : '';

            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'hire/checkValue'; ?>',
            method: 'POST',
            data: {
                hire_name: formData['hire_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('hire_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ประเภทบุคลากรนี้ถูกใช้งานแล้ว'
                });
                $('#hire_name').get(0).focus()
                inputElement.innerHTML = "ประเภทบุคลากรนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'hire/hire_type_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() . '/' . $controller . 'hire'?>'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="hire"]').each(function() {
            var checkbox = document.getElementById('hire_active');
            if (this.id != 'hire_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        const radios = document.querySelectorAll('input[name="option"]');
        radios.forEach((radio) => {
            if (radio.checked) {
                formData['hire_type'] = radio.value;
            }
        });
        const radios2 = document.querySelectorAll('input[name="typeOption"]');
        formData['hire_is_medical'] = null;
        radios2.forEach((radio) => {
            if (radio.checked) {
                formData['hire_is_medical'] = radio.value;
            }
        });
        if (!formData.hire_name || !formData.hire_abbr) {
            !formData.hire_name ? $('#hire_name').get(0).focus() : '';
            !formData.hire_abbr ? $('#hire_abbr').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'hire/checkValue'; ?>',
            method: 'POST',
            data: {
                hire_name: formData['hire_name'],
                hire_id: formData['hire_id'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('hire_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ประเภทบุคลากรนี้ถูกใช้งานแล้ว'
                });
                $('#hire_name').get(0).focus()
                inputElement.innerHTML = "ประเภทบุคลากรนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'hire/hire_type_update'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    // setTimeout(function() {
                    //     location.reload();
                    // }, 1500);
                })
            }
        })
    }
</script>