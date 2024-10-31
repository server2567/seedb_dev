<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($exts_info) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลประเภทบริการหน่วยงาน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อประเภทบริการ (ภาษาไทย) </label>
                            <?php if (!empty($exts_info->exts_id)) { ?>
                                <input type="text" name="External_service[]" id="exts_id" value="<?php echo !empty($exts_info) ? $exts_info->exts_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="External_service[]" id="exts_name_th" placeholder="ชื่อประเภทบริการ (ภาษาไทย)" value="<?php echo !empty($exts_info) ? $exts_info->exts_name_th : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="exts_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label">ชื่อประเภทบริการ (ภาษาอังกฤษ) </label>
                            <input type="text" class="form-control mb-1" name="External_service[]" id="exts_name_en" placeholder="ชื่อประเภทบริการ (ภาษาอังกฤษ)" value="<?php echo !empty($exts_info) ? $exts_info->exts_name_en : ""; ?>" required>
                        </div>
                        <div class="col-4">
                            <label for="StActive" class="form-label">สถานะการใช้งาน</label>
                            <div class="form-check">
                                <?php if (!empty($exts_info->exts_id)) { ?>
                                    <input class="form-check-input" type="checkbox" name="External_service[]" id="exts_active" value="<?php echo !empty($exts_info) ? $exts_info->exts_active : '' ?>" <?php echo !empty($exts_info) && $exts_info->exts_active == '1' ? 'checked' : '' ?>>
                                <?php } else { ?>
                                    <input type="checkbox" id="exts_active" class="form-check-input m-1" checked disabled>
                                <?php } ?>
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/External_service'">ย้อนกลับ</button>
                            <?php if (!empty($exts_info->exts_id)) { ?>
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
        $('[name^="External_service"]').each(function() {
            var checkbox = document.getElementById('exts_active');
            if (this.id != 'exts_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
      
        delete formData.exts_id;
        if (!formData.exts_name_th) {
            !formData.exts_name_th ? $('#exts_name_th').get(0).focus() : '';

            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'External_service/checkValue'; ?>',
            method: 'POST',
            data: {
                exts_name_th: formData['exts_name_th'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('exts_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ประเภทบริการนี้ถูกใช้งานแล้ว'
                });
                $('#exts_name_th').get(0).focus()
                inputElement.innerHTML = "ประเภทบริการนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'External_service/external_service_type_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo base_url() ?>index.php/hr/base/External_service'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="External_service"]').each(function() {
            var checkbox = document.getElementById('exts_active');
            if (this.id != 'exts_active') {
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
                formData['exts_type'] = radio.value;
            }
        });
        const radios2 = document.querySelectorAll('input[name="typeOption"]');
        formData['exts_is_medical'] = null;
        radios2.forEach((radio) => {
            if (radio.checked) {
                formData['exts_is_medical'] = radio.value;
            }
        });
        if (!formData.exts_name_th) {
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'External_service/checkValue'; ?>',
            method: 'POST',
            data: {
                exts_name_th: formData['exts_name_th'],
                exts_id: formData['exts_id'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('exts_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ประเภทบริการนี้ถูกใช้งานแล้ว'
                });
                $('#exts_name_th').get(0).focus()
                inputElement.innerHTML = "ประเภทบริการนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'External_service/external_service_type_update'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo base_url() ?>index.php/hr/base/External_service'
                    }, 1500);
                })
            }
        })
    }
</script>