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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($place_info->place_id) ? 'แก้ไข' : 'เพิ่ม' ?>สถานศึกษา</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อสถานศึกษา (ภาษาไทย)</label>
                            <?php if (!empty($place_info->place_id)) { ?>
                                <input type="text" name="place[]" id="place_id" value="<?php echo !empty($place_info) ? $place_info->place_id : ""; ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control" name="place[]" id="place_name" placeholder="ชื่อสถานศึกษาภาษาไทย" value="<?php echo !empty($place_info) ? $place_info->place_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="place_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อย่อสถานศึกษา (ภาษาไทย)</label>
                            <input type="text" class="form-control" name="place[]" id="place_abbr" placeholder="ชื่อย่อสถานศึกษาภาษาไทย" value="<?php echo !empty($place_info) ? $place_info->place_abbr : ""; ?>">
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อสถานศึกษา (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="place[]" id="place_name_en" placeholder="ชื่อสถานศึกษาภาษาอังกฤษ" value="<?php echo !empty($place_info) ? $place_info->place_name_en : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อย่อสถานศึกษา (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="place[]" id="place_abbr_en" placeholder="ชื่อย่อสถานศึกษาภาษาอังกฤษ" value="<?php echo !empty($place_info) ? $place_info->place_abbr_en : ""; ?>">
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($place_info->place_id)) { ?>
                                                <input type="checkbox" name="place[]" id="place_active" class="form-check-input m-1" value="<?php echo !empty($place_info) ? $place_info->place_active : ""; ?>" <?php echo !empty($place_info) && $place_info->place_active == '1' ? 'checked' : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="place_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Education_place'">ย้อนกลับ</button>
                            <?php if (!empty($place_info->place_id)) { ?>
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
        $('[name^="place"]').each(function() {
            var checkbox = document.getElementById('place_active');
            if (this.id != 'place_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.place_id;
        if (!formData.place_name || !formData.place_name_en) {
            !formData.place_name ? $('#place_name').get(0).focus() : '';
            !formData.place_name_en ? $('#place_name_en').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'education_place/checkValue'; ?>',
            method: 'POST',
            data: {
                place_name: formData['place_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('place_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'สถานศึกษานี้ถูกใช้งานแล้ว'
                });
                $('#place_name').get(0).focus()
                inputElement.innerHTML = "สถานศึกษานี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'education_place/education_place_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() ?>/hr/base/education_place'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="place"]').each(function() {
            var checkbox = document.getElementById('place_active');
            if (this.id != 'place_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        if (!formData.place_name || !formData.place_name_en) {
            !formData.place_name ? $('#place_name').get(0).focus() : '';
            !formData.place_name_en ? $('#place_name_en').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'education_place/checkValue'; ?>',
            method: 'POST',
            data: {
                place_name: formData['place_name'],
                place_id: formData['place_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('place_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'สถานศึกษานี้ถูกใช้งานแล้ว'
                });
                $('#place_name').get(0).focus()
                inputElement.innerHTML = "สถานศึกษานี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'education_place/education_place_update'; ?>',
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