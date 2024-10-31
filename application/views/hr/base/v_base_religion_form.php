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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($rl_info) ? 'แก้ไข' : 'เพิ่ม' ?>ศาสนา</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อศาสนา (ภาษาไทย)</label>
                            <input type="text" name="religion[]" id="reli_id" value="<?php echo !empty($rl_info) ? $rl_info->reli_id : ""; ?>" hidden>
                            <input type="text" class="form-control mb-1" name="religion[]" id="reli_name" placeholder="เชื้อชาติภาษาไทย" value="<?php echo !empty($rl_info) ? $rl_info->reli_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="reli_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อศาสนา (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="religion[]" id="reli_name_en" placeholder="เชื้อชาติภาษาอังกฤษ" value="<?php echo !empty($rl_info) ? $rl_info->reli_name_en : ""; ?>">
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($rl_info->reli_id)) { ?>
                                                <input type="checkbox" name="religion[]" id="reli_active" class="form-check-input m-1" value="<?php echo !empty($rl_info) ? $rl_info->reli_active : ""; ?>" <?php echo !empty($rl_info->reli_active) && $rl_info->reli_active == '1'  ? 'checked' : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="reli_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Religion'">ย้อนกลับ</button>
                            <?php if (!empty($rl_info->reli_id)) { ?>
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
        $('[name^="religion"]').each(function() {
            var checkbox = document.getElementById('reli_active');
            if (this.id != 'reli_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.reli_id;
        if (!formData.reli_name) {
            !formData.reli_name ? $('#reli_name').get(0).focus() : '';

            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'religion/checkValue'; ?>',
            method: 'POST',
            data: {
                reli_name: formData['reli_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('reli_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ศาสนานี้ถูกใช้งานแล้ว'
                });
                $('#reli_name').get(0).focus()
                inputElement.innerHTML = "ศาสนานี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'religion/religion_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() ?>/hr/base/Religion'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="religion"]').each(function() {
            var checkbox = document.getElementById('reli_active');
            if (this.id != 'reli_active') {
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
        if (!formData.reli_name) {
            !formData.reli ? $('#reli_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'religion/checkValue'; ?>',
            method: 'POST',
            data: {
                reli_name: formData['reli_name'],
                reli_id: formData['reli_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('reli_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ศาสนาถูกนี้ใช้งานแล้ว'
                });
                $('#reli_name').get(0).focus()
                inputElement.innerHTML = "ศาสนานี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'religion/religion_update'; ?>',
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