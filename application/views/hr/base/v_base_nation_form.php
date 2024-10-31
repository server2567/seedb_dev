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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($nt_info) ? 'แก้ไข' : 'เพิ่ม' ?>สัญชาติ</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อสัญชาติ (ภาษาไทย)</label>
                            <input type="text" name="nation[]" id="nation_id" value="<?php echo !empty($nt_info) ? $nt_info->nation_id : ""; ?>" hidden>
                            <input type="text" class="form-control mb-1" name="nation[]" id="nation_name" placeholder="สัญชาติภาษาไทย" value="<?php echo !empty($nt_info) ? $nt_info->nation_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="nt_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label required">ชื่อสัญชาติ (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="nation[]" id="nation_name_en" placeholder="สัญชาติภาษาอังกฤษ" value="<?php echo !empty($nt_info) ? $nt_info->nation_name_en : ""; ?>" required>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($nt_info->nation_id)) { ?>
                                                <input type="checkbox" name="nation[]" id="nation_active" class="form-check-input m-1" value="<?php echo !empty($nt_info) ? $nt_info->nation_active : ""; ?>" <?php echo !empty($nt_info) && $nt_info->nation_active == '1' ? "checked" : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="nation_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Nation'">ย้อนกลับ</button>
                            <?php if (!empty($nt_info->nation_id)) { ?>
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
        $('[name^="nation"]').each(function() {
            var checkbox = document.getElementById('nation_active');
            if (this.id != 'nation_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.nation_id;
        if (!formData.nation_name || !formData.nation_name_en) {
            !formData.nation_name ? $('#nation_name').get(0).focus() : '';
            !formData.nation_name_en ? $('#nation_name_en').get(0).focus() : '';

            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'nation/checkValue'; ?>',
            method: 'POST',
            data: {
                nation_name: formData['nation_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('nt_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'คำนำหน้าถูกนี้ใช้งานแล้ว'
                });
                $('#nation_name').get(0).focus()
                inputElement.innerHTML = "สัญชาตินี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'nation/nation_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() . '/' . $controller . 'Nation'?>'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="nation"]').each(function() {
            var checkbox = document.getElementById('nation_active');
            if (this.id != 'nation_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        if (!formData.nation_name || !formData.nation_name_en) {
            !formData.nation_name ? $('#nation_name').get(0).focus() : '';
            !formData.nation_name_en ? $('#nation_name_en').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'nation/checkValue'; ?>',
            method: 'POST',
            data: {
                nation_name: formData['nation_name'],
                nation_id : formData['nation_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('nt_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'คำนำหน้าถูกนี้ใช้งานแล้ว'
                });
                $('#nation_name').get(0).focus()
                inputElement.innerHTML = "สัญชาตินี้ถูกใช้งานแล้ว";
                return false;
            } else {
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'nation/nation_update'; ?>',
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