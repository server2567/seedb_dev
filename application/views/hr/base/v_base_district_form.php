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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($dt_info) ? 'แก้ไข' : 'เพิ่ม' ?>ตำบล</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/Base_position/add">
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อจังหวัด (ภาษาไทย)</label>
                            <?php if (!empty($dt_info->dist_id)) { ?>
                                <input type="text" name="dist[]" id="dist_id" value="<?php echo !empty($dt_info) ? $dt_info->dist_id : "" ?>" hidden>
                            <?php } ?>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกจังหวัด --" name="dist[]" id="dist_pv_id" onchange="updatePvNameEn(<?php echo !empty($dt_info) ? $dt_info->dist_amph_id : '' ?>)" required>
                                <option value="all" selected disabled>กรุณาเลือกจังหวัด</option>
                                <?php if ($pv_info) { ?>
                                    <?php foreach ($pv_info as $item) { ?>
                                        <option value="<?php echo $item->pv_id ?>" data-pv_name_en="<?php echo $item->pv_name_en; ?>" <?php echo !empty($dt_info) && $item->pv_id == $dt_info->dist_pv_id ? 'selected' : '';  ?>><?php echo $item->pv_name ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อจังหวัด (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="pv_name_en" id="pv_name_en" placeholder="จังหวัดภาษาอังกฤษ" disabled value="">
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่ออำเภอ (ภาษาไทย)</label>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกอำเภอ --" name="dist[]" id="dist_amph_id" onchange="updateAmphNameEn()" required>

                            </select>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่ออำเภอ (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="amph_name_en" id="amph_name_en" placeholder="อำเภอภาษาอังกฤษ" disabled value="<?php echo !empty($edit) ? $edit['StAbbrT'] : ""; ?>">
                        </div>
                        <div class="col-4">
                            <label for="StNameT" class="form-label required">ชื่อตำบล (ภาษาไทย)</label>
                            <input type="text" class="form-control mb-1" name="dist[]" id="dist_name" placeholder="ตำบลภาษาไทย" value="<?php echo !empty($dt_info) ? $dt_info->dist_name : ""; ?>">
                            <div class="d-flex justify-content-end">
                                <label id="dist_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="StAbbrT" class="form-label">ชื่อตำบล (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="dist[]" id="dist_name_en" placeholder="ตำบลภาษาอังกฤษ" value="<?php echo !empty($dt_info) ? $dt_info->dist_name_en : ""; ?>">
                        </div>
                        <div class="col-4">
                            <label for="StAbbrT" class="form-label">รหัสไปรษณี (Zipcode)</label>
                            <input type="text" class="form-control" name="dist[]" id="dist_pos_code" placeholder="รหัสไปรษณี" value="<?php echo !empty($dt_info) ? $dt_info->dist_pos_code : ""; ?>">
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($dt_info->dist_id)) { ?>
                                                <input class="form-check-input" type="checkbox" name="dist[]" id="dist_active" value="<?php echo !empty($dt_info) ? $dt_info->dist_active : ""; ?>" <?php echo !empty($dt_info) && $dt_info->dist_active == '1' ? 'checked' : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="dist_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/district'">ย้อนกลับ</button>
                            <?php if (!empty($dt_info->dist_id)) { ?>
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

    function updateAmphNameEn() {
        const distSelect = document.getElementById('dist_amph_id');
        const selectedOption = distSelect.options[distSelect.selectedIndex];
        const amphNameEnInput = document.getElementById('amph_name_en');
        const amphNameEn = selectedOption.getAttribute('data-amph_name_en');
        amphNameEnInput.value = amphNameEn || '';
    }

    function updatePvNameEn(amph_id) {
        const distSelect = document.getElementById('dist_pv_id');
        const amphNameEnInput = document.getElementById('pv_name_en');
        const selectedOption = distSelect.options[distSelect.selectedIndex];
        const amphNameEn = selectedOption.getAttribute('data-pv_name_en');
        amphNameEnInput.value = amphNameEn || '';
        // console.log(amph_id);
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'District/get_amphur'; ?>',
            method: 'POST',
            data: {
                pv_id: distSelect.value
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var amph_select = document.getElementById('dist_amph_id');
            amph_select.innerHTML = '<option value="all" selected disabled>กรุณาเลือกอำเภอ</option>';
            data.forEach(function(item) {
                var option = document.createElement('option');
                option.value = item.amph_id;
                option.textContent = item.amph_name;
                option.setAttribute('data-amph_name_en', item.amph_name_en);
                if (item.amph_id == amph_id) {
                    option.selected = true;
                }
                amph_select.appendChild(option);
            });
            updateAmphNameEn()
        })
    }

    // เรียกฟังก์ชัน updateAmphNameEn เมื่อหน้าเว็บโหลดเสร็จ เพื่อเซ็ตค่าเริ่มต้น
    document.addEventListener('DOMContentLoaded', function() {
        updatePvNameEn(<?php echo !empty($dt_info) ? $dt_info->dist_amph_id : '' ?>);
    });

    function submitAdd() {
        var checkbox = document.getElementById('dist_active');
        $('[name^="dist"]').each(function() {
            if (this.id != 'dist_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.dist_id;
        if (!formData.dist_name || !formData.dist_pv_id || !formData.dist_amph_id || formData.dist_amph_id == 'all') {
            !formData.dist_name ? $('#dist_name').get(0).focus() : '';
            !formData.dist_pv_id ? $('#dist_pv_id').get(0).focus() : '';
            !formData.dist_amph_id ? $('#dist_amph_id').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        console.log(formData);
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'district/checkValue'; ?>',
            method: 'POST',
            data: {
                dist_amph_id: formData['dist_amph_id'],
                dist_pv_id: formData['dist_pv_id'],
                dist_name: formData['dist_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('dist_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ตำบลนี้ถูกใช้งานแล้ว'
                });
                $('#dist_name').get(0).focus()
                inputElement.innerHTML = "ตำบลนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>district/district_insert',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() ?>/hr/base/district'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        var checkbox = document.getElementById('dist_active');
        $('[name^="dist"]').each(function() {
            if (this.id != 'dist_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        if (!formData.dist_name || !formData.dist_pv_id || !formData.dist_amph_id || formData.dist_amph_id == 'all' || formData.dist_pv_id == 'all') {
            !formData.dist_name ? $('#dist_name').get(0).focus() : '';
            !formData.dist_pv_id ? $('#dist_pv_id').get(0).focus() : '';
            !formData.dist_amph_id ? $('#dist_amph_id').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'district/checkValue'; ?>',
            method: 'POST',
            data: {
                dist_name: formData['dist_name'],
                dist_amph_id: formData['dist_amph_id'],
                dist_pv_id: formData['dist_pv_id'],
                dist_id: formData['dist_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('dist_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ตำบลถูกนี้ใช้งานแล้ว'
                });
                $('#dist_name').get(0).focus()
                inputElement.innerHTML = "ตำบลนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>district/district_update',
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