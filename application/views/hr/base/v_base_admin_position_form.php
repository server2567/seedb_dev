<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($admin_info) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลตำแหน่งการบริหารงาน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อตำแหน่งการบริหารงาน (ภาษาไทย)</label>
                            <?php if (!empty($admin_info->admin_id)) { ?>
                                <input type="text" name="admin[]" id="admin_id" value="<?php echo !empty($admin_info) ? $admin_info->admin_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="admin[]" id="admin_name" placeholder="ชื่อตำแหน่งบริหารงานภาษาไทย" value="<?php echo !empty($admin_info) ? $admin_info->admin_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="admin_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อย่อตำแหน่งการบริหารงาน (ภาษาไทย)</label>
                            <input type="text" class="form-control" name="admin[]" id="admin_name_abbr" placeholder="ชื่อย่อตำแหน่งบริหารงานภาษาไทย" value="<?php echo !empty($admin_info) ? $admin_info->admin_name_abbr : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StNameE" class="form-label ">ชื่อตำแหน่งการบริหารงาน (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="admin[]" id="admin_name_en" placeholder="ชื่อตำแหน่งบริหารงานภาษาอังกฤษ" value="<?php echo !empty($admin_info) ? $admin_info->admin_name_en : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StNameE" class="form-label ">ชื่อย่อตำแหน่งการบริหารงาน (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="admin[]" id="admin_name_abbr_en" placeholder="ชื่อย่อตำแหน่งบริหารงานภาษาอังกฤษ" value="<?php echo !empty($admin_info) ? $admin_info->admin_name_abbr_en : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StActive" class="form-label">สถานะการใช้งาน</label>
                            <div class="form-check">
                                <?php if (!empty($admin_info->admin_id)) { ?>
                                    <input class="form-check-input" type="checkbox" name="admin[]" id="admin_active" <?php echo !empty($admin_info) &&  $admin_info->admin_active == '1' ? 'checked' : '' ?>>
                                <?php } else { ?>
                                    <input type="checkbox" id="admin_active" class="form-check-input m-1" checked disabled>
                                <?php } ?>
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Admin_position'">ย้อนกลับ</button>
                            <?php if (!empty($admin_info->admin_id)) { ?>
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
        $('[name^="admin"]').each(function() {
            var checkbox = document.getElementById('admin_active');
            if (this.id != 'admin_active') {
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
        delete formData.admin_id;
        if (!formData.admin_name || !formData.admin_name_abbr) {
            !formData.admin_name ? $('#admin_name').get(0).focus() : '';
            !formData.admin_abbr ? $('#admin_name_abbr').get(0).focus() : '';

            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'admin_position/checkValue'; ?>',
            method: 'POST',
            data: {
                admin_name: formData['admin_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('admin_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ตำแหน่งงานบริหารงานนี้ถูกใช้งานแล้ว'
                });
                $('#admin_name').get(0).focus()
                inputElement.innerHTML = "ตำแหน่งงานบริหารงานนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'admin_position/admin_position_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() . '/' . $controller . 'admin_position'?>'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="admin"]').each(function() {
            var checkbox = document.getElementById('admin_active');
            if (this.id != 'admin_active') {
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
        if (!formData.admin_name || !formData.admin_name_abbr) {
            !formData.admin_name ? $('#admin_name').get(0).focus() : '';
            !formData.admin_abbr ? $('#admin_name_abbr').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'admin_position/checkValue'; ?>',
            method: 'POST',
            data: {
                admin_name: formData['admin_name'],
                admin_id: formData['admin_id'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('admin_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ตำแหน่งงานบริหารงานนี้ถูกใช้งานแล้ว'
                });
                $('#admin_name').get(0).focus()
                inputElement.innerHTML = "ตำแหน่งงานบริหารงานนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'admin_position/admin_position_update'; ?>',
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