<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($spcl_info) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลตำแหน่งงานเฉพาะทาง</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อตำแหน่งงานเฉพาะ (ภาษาไทย)</label>
                            <?php if (!empty($spcl_info->spcl_id)) { ?>
                                <input type="text" name="special[]" id="spcl_id" value="<?php echo !empty($spcl_info) ? $spcl_info->spcl_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="special[]" id="spcl_name" placeholder="ชื่อตำแหน่งงานเฉพาะทางภาษาไทย" value="<?php echo !empty($spcl_info) ? $spcl_info->spcl_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="spcl_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อตำแหน่งงานเฉพาะแบบย่อ (ภาษาไทย)</label>
                            <input type="text" class="form-control" name="special[]" id="spcl_name_abbr" placeholder="ชื่อตำแหน่งงานเฉพาะทางแบบย่อภาษาไทย" value="<?php echo !empty($spcl_info) ? $spcl_info->spcl_name_abbr : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StNameE" class="form-label ">ชื่อตำแหน่งงานเฉพาะ (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="special[]" id="spcl_name_en" placeholder="ชื่อตำแหน่งงานเฉพาะทางภาษาอังกฤษ" value="<?php echo !empty($spcl_info) ? $spcl_info->spcl_name_en : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label ">ชื่อตำแหน่งงานเฉพาะแบบย่อ (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="special[]" id="spcl_name_abbr_en" placeholder="ชื่อตำแหน่งงานเฉพาะทางแบบย่อภาษาอังกฤษ" value="<?php echo !empty($spcl_info) ? $spcl_info->spcl_name_abbr_en : ""; ?>" required>
                        </div>
                        <!-- <div class="col-6">
                            <label for="StNameE" class="form-label required">กลุ่มตำแหน่งงาน</label>
                            <select class="select2" name="spcl_" id="">
                                <option value="" disabled selected>-- กรุณาเลือกกลุ่มตำแหน่ง --</option>
                                <?php if (!empty($hire_info)) { ?>
                                    <?php foreach ($hire_info as $value) { ?>
                                        <option value="<?= $value->hire_id ?>" <?= !empty($spcl_info) && $spcl_info->spcl_id == $value->hire_id ? 'selected': '' ?>><?= $value->hire_name ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div> -->
                        <div class="col-6">
                            <label for="StActive" class="form-label">สถานะการใช้งาน</label>
                            <div class="form-check">
                                <?php if (!empty($spcl_info->spcl_id)) { ?>
                                    <input class="form-check-input" type="checkbox" name="special[]" id="spcl_active" value="<?php echo !empty($spcl_info) ? $spcl_info->spcl_active : '' ?>" <?php echo !empty($spcl_info) &&  $spcl_info->spcl_active == '1' ? 'checked' : '' ?>>
                                <?php } else { ?>
                                    <input type="checkbox" id="spcl_active" class="form-check-input m-1" checked disabled>
                                <?php } ?>
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/special_position'">ย้อนกลับ</button>
                            <?php if (!empty($spcl_info->spcl_id)) { ?>
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
        $('[name^="special"]').each(function() {
            var checkbox = document.getElementById('spcl_active');
            if (this.id != 'spcl_active') {
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
        delete formData.spcl_id;
        if (!formData.spcl_name || !formData.spcl_name_abbr) {
            !formData.spcl_name ? $('#spcl_name').get(0).focus() : '';
            !formData.spcl_abbr ? $('#spcl_name_abbr').get(0).focus() : '';

            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'special_position/checkValue'; ?>',
            method: 'POST',
            data: {
                spcl_name: formData['spcl_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('spcl_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ตำแหน่งงานเฉพาะนี้ถูกใช้งานแล้ว'
                });
                $('#spcl_name').get(0).focus()
                inputElement.innerHTML = "ตำแหน่งงานเฉพาะนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'special_position/special_position_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() . '/' . $controller . 'special_position'?>'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="special"]').each(function() {
            var checkbox = document.getElementById('spcl_active');
            if (this.id != 'spcl_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
            console.log(this.id);
        });
        if (!formData.spcl_name || !formData.spcl_name_abbr) {
            !formData.spcl_name ? $('#spcl_name').get(0).focus() : '';
            !formData.spcl_abbr ? $('#spcl_name_abbr').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'special_position/checkValue'; ?>',
            method: 'POST',
            data: {
                spcl_name: formData['spcl_name'],
                spcl_id: formData['spcl_id'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('spcl_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ตำแหน่งงานเฉพาะนี้ถูกใช้งานแล้ว'
                });
                $('#spcl_name').get(0).focus()
                inputElement.innerHTML = "ตำแหน่งงานเฉพาะนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'special_position/special_position_update'; ?>',
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