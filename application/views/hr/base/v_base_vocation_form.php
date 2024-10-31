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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($voc_info) ? 'แก้ไข' : 'เพิ่ม' ?>ชื่อประเภทวิชาชีพ</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อประเภทวิชาชีพ (ภาษาไทย)</label>
                            <?php if (!empty($voc_info->voc_id)) { ?>
                                <input type="text" name="vocation[]" id="voc_id" value="<?php echo !empty($voc_info) ? $voc_info->voc_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="vocation[]" id="voc_name" placeholder="ชื่อประเภทวิชาชีพภาษาไทย" value="<?php echo !empty($voc_info) ? $voc_info->voc_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="voc_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">สิทธิในการรับเงินไม่ทำเวชปฏิบัติ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="option" value="Y" id="voc_done" <?php echo !empty($voc_info) && $voc_info->voc_done == 'Y' ? 'checked' :  '' ?>>
                                <label for="StActive" class="form-check-label mb-2">มี</label> <br>
                                <input class="form-check-input" type="radio" name="option" value="N" id="voc_done2" <?php echo !empty($voc_info) && $voc_info->voc_done == 'N' ? 'checked' :  '' ?>>
                                <label for="StActive" class="form-check-label">ไม่มี</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($voc_info->voc_id)) { ?>
                                                <input type="checkbox" name="vocation[]" id="voc_active" class="form-check-input m-1" value="<?php echo !empty($voc_info) ? $voc_info->voc_active : ""; ?>" <?php echo !empty($voc_info) && $voc_info->voc_active == '1' ? 'checked' : ''; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="voc_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/vocation'">ย้อนกลับ</button>
                            <?php if (!empty($voc_info->voc_id)) { ?>
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
        $('[name^="vocation"]').each(function() {
            var checkbox = document.getElementById('voc_active');
            if (this.id != 'voc_active') {
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
        formData['voc_done'] = ''
        radios.forEach((radio) => {
            if (radio.checked) {
                formData['voc_done'] = radio.value;
            }
        });
        delete formData.voc_id;
        if (!formData.voc_name || !formData.voc_done) {
            !formData.voc_name ? $('#voc_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'vocation/checkValue'; ?>',
            method: 'POST',
            data: {
                voc_name: formData['voc_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('voc_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'วิชาชีพนี้ถูกใช้งานแล้ว'
                });
                $('#voc_name').get(0).focus()
                inputElement.innerHTML = "วิชาชีพนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'vocation/vocation_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() ?>/hr/base/vocation'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="vocation"]').each(function() {
            var checkbox = document.getElementById('voc_active');
            if (this.id != 'voc_active') {
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
                formData['voc_done'] = radio.value;
            }
        });
        if (!formData.voc_name) {
            !formData.voc_name ? $('#voc_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        console.log(formData);
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'vocation/checkValue'; ?>',
            method: 'POST',
            data: {
                voc_name: formData['voc_name'],
                voc_id: formData['voc_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('voc_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'วิชาชีพนี้ถูกใช้งานแล้ว'
                });
                $('#voc_name').get(0).focus()
                inputElement.innerHTML = "วิชาชีพนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'vocation/vocation_update'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                })
            }
        })
    }
</script>