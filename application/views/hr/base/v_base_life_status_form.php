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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($ls_info->psst_id) ? 'แก้ไข' : 'เพิ่ม' ?>สถานะการมีชีวิต</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" action="">
                        <div class="col-6">
                            <input type="text" name="life_status[]" id="psst_id" hidden value="<?= !empty($ls_info->psst_id) ? $ls_info->psst_id : ''   ?>">
                            <label for="StNameT" class="form-label required">ชื่อสถานะการมีชีวิต (ภาษาไทย)</label>
                            <input type="text" class="form-control" name="life_status[]" id="psst_name" placeholder="สถานะการมีชีวิตภาษาไทย" value="<?php echo !empty($ls_info) ? $ls_info->psst_name : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label required">ชื่อสถานะการมีชีวิต (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="life_status[]" id="psst_name_en" placeholder="สถานะการมีชีวิตภาษาอังกฤษ" value="<?php echo !empty($ls_info) ? $ls_info->psst_name_en : ""; ?>" required>
                        </div>
                        <?php if (!empty($ls_info->psst_id)) { ?>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-2">
                                        <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                    </div>
                                    <div class="col-10">
                                        <ul>
                                            <li>
                                                <input type="checkbox" name="life_status[]" id="psst_active" class="form-check-input m-1" value="<?php echo !empty($ls_info) ? $ls_info->psst_active : ""; ?>" <?php echo !empty($ls_info->psst_active) ? "checked" : ""; ?>>
                                                <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Profile/get_life_status'">ย้อนกลับ</button>
                            <?php if (!empty($ls_info->psst_id)) { ?>
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
        $('[name^="life_status"]').each(function() {
            formData[this.id] = this.value;
        });
        unset(formData['psst_id'])
        if (!formData.psst_name || !formData.psst_name_en) {
            !formData.psst_name ? $('#psst_name').get(0).focus() : '';
            !formData.psst_name_en ? $('#psst_name_en').get(0).focus() : '';

            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: 'life_status_insert',
            method: 'POST',
            data: formData
        }).done(function(returnedData) {
            dialog_success({
                'header': 'ดำเนินการเสร็จสิ้น',
                'body': 'บันทึกข้อมูลเสร็จสิ้น'
            });
            setTimeout(function() {
                window.location.href = '<?php echo site_url() . '/' . $controller . 'Profile/get_life_status'?>'
            }, 1500);
        })
    }

    function submitEdit() {
        $('[name^="life_status"]').each(function() {
            formData[this.id] = this.value;
        });
        if (!formData.psst_name || !formData.psst_name_en) {
            !formData.psst_name ? $('#psst_name').get(0).focus() : '';
            !formData.psst_name_en ? $('#psst_name_en').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '../life_status_update',
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
</script>