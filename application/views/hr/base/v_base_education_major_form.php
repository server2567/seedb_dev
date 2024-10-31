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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($edumj_info) ? 'แก้ไข' : 'เพิ่ม' ?>สาขาวิชา</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อสาขาวิชา (ภาษาไทย)</label>
                            <?php if (!empty($edumj_info->edumj_id)) { ?>
                                <input type="text" name="edumj[]" id="edumj_id" value="<?php echo !empty($edumj_info) ? $edumj_info->edumj_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="edumj[]" id="edumj_name" placeholder="ชื่อสาขาวิชาภาษาไทย" value="<?php echo !empty($edumj_info) ? $edumj_info->edumj_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="edumj_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อสาขาวิชา (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="edumj[]" id="edumj_name_en" placeholder="ชื่อสาขาวิชาภาษาอังกฤษ" value="<?php echo !empty($edumj_info) ? $edumj_info->edumj_name_en : ""; ?>">
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($edumj_info->edumj_id)) { ?>
                                                <input type="checkbox" name="edumj[]" id="edumj_active" class="form-check-input m-1" value="<?php echo !empty($edumj_info) ? $edumj_info->edumj_active : ""; ?>" <?php echo !empty($edumj_info) && $edumj_info->edumj_active == '1' ? 'checked' : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="edumj_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Education_major'">ย้อนกลับ</button>
                            <?php if (!empty($edumj_info->edumj_id)) { ?>
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
        $('[name^="edumj"]').each(function() {
            var checkbox = document.getElementById('edumj_active');
            if (this.id != 'edumj_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.edumj_id;
        if (!formData.edumj_name) {
            !formData.edumj_name ? $('#edumj_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'education_major/checkValue'; ?>',
            method: 'POST',
            data: {
                edumj_name: formData['edumj_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('edumj_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'สาขาวิชานี้ถูกใช้งานแล้ว'
                });
                $('#edumj_name').get(0).focus()
                inputElement.innerHTML = "สาขาวิชานี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'education_major/education_major_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() . '/' . $controller . 'education_major'?>'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="edumj"]').each(function() {
            var checkbox = document.getElementById('edumj_active');
            if (this.id != 'edumj_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        if (!formData.edumj_name) {
            !formData.edumj_name ? $('#edumj_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'education_major/checkValue'; ?>',
            method: 'POST',
            data: {
                edumj_name: formData['edumj_name'],
                edumj_id: formData['edumj_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('edumj_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'สาขาวิชานี้ถูกใช้งานแล้ว'
                });
                $('#edumj_name').get(0).focus()
                inputElement.innerHTML = "สาขานี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'education_major/education_major_update'; ?>',
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