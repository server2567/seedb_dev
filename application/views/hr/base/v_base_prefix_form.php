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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($pf_info->pf_id) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลคำนำหน้าชื่อ</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">คำนำหน้าชื่อ (ภาษาไทย)</label>
                            <?php if (!empty($pf_info->pf_id)) { ?>
                                <input type="text" class="form-control" name="pf_info[]" id="pf_id" placeholder="ไอดีคำหน้าชื่อ" value="<?php echo !empty($pf_info) ? $pf_info->pf_id : ""; ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="pf_info[]" id="pf_name" placeholder="คำนำหน้าชื่อภาษาไทย" value="<?php echo !empty($pf_info) ? $pf_info->pf_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="pf_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="StAbbrT" class="form-label">คำนำหน้าชื่อ (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="pf_info[]" id="pf_name_en" placeholder="คำนำหน้าชื่อภาษาอังกฤษ" value="<?php echo !empty($pf_info) ? $pf_info->pf_name_en : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อย่อคำนำหน้าชื่อ (ภาษาไทย)</label>
                            <?php if (!empty($pf_info->pf_id)) { ?>
                                <input type="text" class="form-control" name="pf_info[]" id="pf_id" placeholder="ไอดีคำหน้าชื่อ" value="<?php echo !empty($pf_info) ? $pf_info->pf_id : ""; ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control" name="pf_info[]" id="pf_name_abbr" placeholder="คำนำหน้าชื่อภาษาไทย" value="<?php echo !empty($pf_info) ? $pf_info->pf_name_abbr : ""; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="StAbbrT" class="form-label">ชื่อย่อคำนำหน้าชื่อ (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="pf_info[]" id="pf_name_abbr_en" placeholder="คำนำหน้าชื่อภาษาอังกฤษ" value="<?php echo !empty($pf_info) ? $pf_info->pf_name_abbr_en : ""; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="StAbbrT" class="form-label required">เพศ</label>
                            <select name="pf_info[]" class="form-select" id="pf_gd_id">
                                <option value="none" disabled selected>--- เลือกเพศ ---</option>
                                <?php if (isset($gd_info)) { ?>
                                    <?php foreach ($gd_info as $gd) : ?>
                                        <option value="<?php echo $gd->gd_id ?>" <?php echo !empty($pf_info) && $pf_info->pf_gd_id == $gd->gd_id ? "selected" : ""; ?>><?php echo $gd->gd_name ?></option>
                                    <?php endforeach ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                            <ul>
                                <li>
                                    <?php if (!empty($pf_info->pf_id)) { ?>
                                        <input type="checkbox" name="pf_info[]" id="pf_active" class="form-check-input m-1" value="<?php echo !empty($pf_info) ? $pf_info->pf_active : ""; ?>" <?php echo !empty($pf_info) && $pf_info->pf_active == '1' ? "checked" : ""; ?>>
                                    <?php } else { ?>
                                        <input type="checkbox" id="pf_active" class="form-check-input m-1" checked disabled>
                                    <?php } ?>
                                    <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Prefix'">ย้อนกลับ</button>
                            <?php if (!empty($pf_info->pf_id)) { ?>
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
    document.getElementById('pf_name').addEventListener('input', function(event) {
        validateInput(event, 'pf_name');
    });

    document.getElementById('pf_name_en').addEventListener('input', function(event) {
        validateInput(event, 'pf_name_en');
    });

    function validateInput(event, inputId) {
        var value = event.target.value;
        if (inputId == "pf_name_en") {
            var pattern = /^[A-Za-z\s]*$/;
        } else {
            var pattern = /^[A-Za-zก-๏\s]*$/;
        }

        if (!pattern.test(value)) {
            Swal.fire({
                icon: 'error',
                title: 'ข้อมูลไม่ถูกต้อง',
                text: 'กรุณากรอกเฉพาะตัวอักษรภาษาไทยหรืออังกฤษเท่านั้น'
            });
            if (inputId == "pf_name_en") {
                event.target.value = value.replace(/[^A-Za-z\s]/g, '');
            } else {
                event.target.value = value.replace(/[^A-Za-zก-๏\s]/g, '');
            } // ลบตัวอักษรที่ไม่ใช่อักษรภาษาไทยหรืออังกฤษ
        }
    }

    function submitAdd() {
        $('[name^="pf_info"]').each(function() {
            var checkbox = document.getElementById('pf_active');
            if (this.id != 'pf_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        if (!formData.pf_name || !formData.pf_name_abbr || formData.pf_gd_id == 'none') {
            !formData.pf_name ? $('#pf_name').get(0).focus() : '';
            !formData.pf_name_abbr ? $('#pf_name_abbr').get(0).focus() : '';
            !formData.pf_gd_id ? $('#pf_gd_id').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'prefix/checkValue'; ?>',
            method: 'POST',
            data: {
                pf_name: formData['pf_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('pf_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'คำนำหน้าถูกนี้ใช้งานแล้ว'
                });
                $('#pf_name').get(0).focus()
                inputElement.innerHTML = "คำนำหน้านี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'prefix/prefix_insert'; ?>',
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

    function submitEdit() {
        $('[name^="pf_info[]"]').each(function() {
            var checkbox = document.getElementById('pf_active');
            if (this.id != 'pf_active') {
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
        if (!formData.pf_name || !formData.pf_name_abbr || formData.pf_gd_id == 'none') {
            !formData.pf_name ? $('#pf_name').get(0).focus() : '';
            !formData.pf_name_abbr ? $('#pf_name_abbr').get(0).focus() : '';
            !formData.pf_gd_id ? $('#pf_gd_id').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'prefix/checkValue'; ?>',
            method: 'POST',
            data: {
                pf_name: formData['pf_name'],
                pf_id: formData['pf_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('pf_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'คำนำหน้าถูกนี้ใช้งานแล้ว'
                });
                $('#pf_name').get(0).focus()
                inputElement.innerHTML = "คำนำหน้านี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'prefix/prefix_update'; ?>',
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