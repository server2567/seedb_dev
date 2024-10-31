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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($rc_info) ? 'แก้ไข' : 'เพิ่ม' ?>เชื้อชาติ</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="race_name" class="form-label required">ชื่อเชื้อชาติ (ภาษาไทย)</label>
                            <?php if (!empty($rc_info->race_id)) { ?>
                                <input type="text" name="race[]" id="race_id" value="<?php echo !empty($rc_info) ? $rc_info->race_id : ""; ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="race[]" id="race_name" placeholder="เชื้อชาติภาษาไทย" value="<?php echo !empty($rc_info) ? $rc_info->race_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="race_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน </label>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-9 text-start">
                                    <ul>
                                        <li>
                                            <?php if (!empty($rc_info->race_id)) { ?>
                                                <input type="checkbox" name="race[]" id="race_active" class="form-check-input m-1" value="<?php echo !empty($rc_info) ? $rc_info->race_active : ""; ?>" <?php echo $rc_info->race_active == '1' ? 'checked' : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="race_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Race'">ย้อนกลับ</button>
                            <?php if (!empty($rc_info->race_id)) { ?>
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
        $('[name^="race"]').each(function() {
            var checkbox = document.getElementById('race_active');
            if (this.id != 'race_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.race_id;
        if (!formData.race_name) {
            !formData.race_name ? $('#race_name').get(0).focus() : '';

            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'race/checkValue'; ?>',
            method: 'POST',
            data: {
                race_name: formData['race_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('race_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'คำนำหน้าถูกนี้ใช้งานแล้ว'
                });
                $('#race_name').get(0).focus()
                inputElement.innerHTML = "เชื้อชาตินี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'race/race_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() ?>/hr/base/Race'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="race"]').each(function() {
            var checkbox = document.getElementById('race_active');
            if (this.id != 'race_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        console.log(formData);
        if (!formData.race_name) {
            !formData.race ? $('#race_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'race/checkValue'; ?>',
            method: 'POST',
            data: {
                race_name: formData['race_name'],
                race_id: formData['race_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('race_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'คำนำหน้าถูกนี้ใช้งานแล้ว'
                });
                $('#race_name').get(0).focus()
                inputElement.innerHTML = "เชื้อชาตินี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'race/race_update'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                })
            }
        })
    }
</script>