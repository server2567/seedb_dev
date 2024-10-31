<style>
    ul {
        list-style-type: none;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($re_info) ? 'แก้ไข' : 'เพิ่ม' ?>สถานะปัจจุบัน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อสถานะปัจจุบันของบุคลากร</label>
                            <?php if (!empty($re_info->retire_id)) { ?>
                                <input type="text" name="retire[]" id="retire_id" value="<?php echo !empty($re_info) ? $re_info->retire_id : ""; ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="retire[]" id="retire_name" placeholder="สถานะปัจจุบันภาษาไทย" value="<?php echo !empty($re_info) ? $re_info->retire_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="retire_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label required">สถานะการปฏิบัติงาน</label>
                            <select name="retire[]" id="retire_ps_status" class="form-select">
                                <option value="all" disabled selected>-- กรุณาเลือกสถานะ --</option>
                                <option value="1" <?= !empty($re_info) && $re_info->retire_ps_status == '1' ? 'selected': '' ?>>ปฏิบัติงานอยู่</option>
                                <option value="2"  <?= !empty($re_info) && $re_info->retire_ps_status == '2' ? 'selected': '' ?>>ออกจากหน้าที่</option>
                            </select>
                        </div>
                        <div class="col-6">
                        <label for="StAbbrT" class="form-label required">สถานะการลงเวลาทำงาน</label> <br>
                            <input type="radio" name="option" id="scan" value="Y" class="form-check-input" <?= !empty($re_info) && $re_info->retire_timestamp == 'Y' ? 'checked': '' ?>>
                            <label for="StAbbrT" class="form-label ">ต้องสแกนนิ้วมือ</label><br>
                            <input type="radio" name="option" id="scan" value="N" class="form-check-input" <?= !empty($re_info) && $re_info->retire_timestamp == 'N' ? 'checked': '' ?>>
                            <label for="StAbbrT" class="form-label ">ไม่ต้องสแกนนิ้วมือ</label>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-3">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($re_info->retire_id)) { ?>
                                                <input type="checkbox" name="retire[]" id="retire_active" class="form-check-input m-1" value="<?php echo !empty($re_info) ? $re_info->retire_active : ""; ?>" <?php echo !empty($re_info) && $re_info->retire_active == '1' ? 'checked' : ''; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="retire_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/retire'">ย้อนกลับ</button>
                            <?php if (!empty($re_info->retire_id)) { ?>
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
        $('[name^="retire"]').each(function() {
            var checkbox = document.getElementById('retire_active');
            if (this.id != 'retire_active') {
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
                formData['retire_timestamp'] = radio.value;
            }
        });
        delete formData.retire_id;
        console.log(formData);
        if (!formData.retire_name || formData.retire_ps_status == 'all') {
            !formData.retire_name ? $('#retire_name').get(0).focus() : '';
            formData.retire_ps_status == 'all' ? $('#retire_ps_status').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'retire/checkValue'; ?>',
            method: 'POST',
            data: {
                retire_name: formData['retire_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('retire_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'สถานะปัจจุบันนี้ถูกใช้งานแล้ว'
                });
                $('#retire_name').get(0).focus()
                inputElement.innerHTML = "สถานะปัจจุบันนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'retire/retire_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() . '/' . $controller . 'retire'?>'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="retire"]').each(function() {
            var checkbox = document.getElementById('retire_active');
            if (this.id != 'retire_active') {
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
                formData['retire_timestamp'] = radio.value;
            }
        });
        if (!formData.retire_name || formData.retire_ps_status == 'all') {
            !formData.retire_name ? $('#retire_name').get(0).focus() : '';
            formData.retire_ps_status == 'all' ? $('#retire_ps_status').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        console.log(formData);
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'retire/checkValue'; ?>',
            method: 'POST',
            data: {
                retire_name: formData['retire_name'],
                retire_id: formData['retire_id'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('retire_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'สถานะปัจจุบันนี้ถูกใช้งานแล้ว'
                });
                $('#retire_name').get(0).focus()
                inputElement.innerHTML = "สถานะปัจจุบันนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'retire/retire_update'; ?>',
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