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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($edudg_info) ? 'แก้ไข' : 'เพิ่ม' ?>วุฒิการศึกษา</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อวุฒิการศึกษา (ภาษาไทย)</label>
                            <?php if (!empty($edudg_info->edudg_id)) { ?>
                                <input type="text" name="edudg[]" id="edudg_id" value="<?php echo !empty($edudg_info) ? $edudg_info->edudg_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="edudg[]" id="edudg_name" placeholder="ชื่อวุฒิการศึกษาภาษาไทย" value="<?php echo !empty($edudg_info) ? $edudg_info->edudg_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="edudg_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อย่อวุฒิการศึกษา (ภาษาไทย)</label>
                            <input type="text" class="form-control" name="edudg[]" id="edudg_abbr" placeholder="ชื่อย่อวุฒิการศึกษาภาษาไทย" value="<?php echo !empty($edudg_info) ? $edudg_info->edudg_abbr : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อวุฒิการศึกษา (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="edudg[]" id="edudg_name_en" placeholder="ชื่อวุฒิการศึกษาภาษาอังกฤษ" value="<?php echo !empty($edudg_info) ? $edudg_info->edudg_name_en : ""; ?>">
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อย่อวุฒิการศึกษา (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="edudg[]" id="edudg_abbr_en" placeholder="ชื่อย่อวุฒิการศึกษาภาษาอังกฤษ" value="<?php echo !empty($edudg_info) ? $edudg_info->edudg_abbr_en : ""; ?>">
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($edudg_info->edudg_id)) { ?>
                                                <input type="checkbox" name="edudg[]" id="edudg_active" class="form-check-input m-1" value="<?php echo !empty($edudg_info) ? $edudg_info->edudg_active : ""; ?>" <?php echo !empty($edudg_info) && $edudg_info->edudg_active == '1' ? "checked" : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="edudg_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Education_degree'">ย้อนกลับ</button>
                            <?php if (!empty($edudg_info->edudg_id)) { ?>
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
        $('[name^="edudg"]').each(function() {
            var checkbox = document.getElementById('edudg_active');
            if (this.id != 'edudg_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.edudg_id;
        if (!formData.edudg_name || !formData.edudg_abbr) {
            !formData.edudg_name ? $('#edudg_name').get(0).focus() : '';
            !formData.edudg_abbr ? $('#edudg_abbr').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'education_degree/checkValue'; ?>',
            method: 'POST',
            data: {
                edudg_name: formData['edudg_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('edudg_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'วุฒิการศึกษานี้ถูกใช้งานแล้ว'
                });
                $('#edudg_name').get(0).focus()
                inputElement.innerHTML = "วุฒิการศึกษานี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'education_degree/education_degree_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() ?>/hr/base/education_degree'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="edudg"]').each(function() {
            var checkbox = document.getElementById('edudg_active');
            if (this.id != 'edudg_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        if (!formData.edudg_name || !formData.edudg_abbr) {
            !formData.edudg_name ? $('#edudg_name').get(0).focus() : '';
            !formData.edudg_abbr ? $('#edudg_abbr').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'education_degree/checkValue'; ?>',
            method: 'POST',
            data: {
                edudg_name: formData['edudg_name'],
                edudg_id: formData['edudg_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('edudg_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'วุฒิการศึกษานี้ถูกใช้งานแล้ว'
                });
                $('#edudg_name').get(0).focus()
                inputElement.innerHTML = "วุฒิการศึกษานี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'education_degree/education_degree_update'; ?>',
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