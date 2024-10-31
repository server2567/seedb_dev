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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($ap_info) ? 'แก้ไข' : 'เพิ่ม' ?>อำเภอ</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url(); ?>index.php/ums/Base_position/add">
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">จังหวัด (TH)</label>
                            <?php if (!empty($ap_info->amph_id)) { ?>
                                <input type="text" name="amphur[]" id="amph_id" value="<?php echo !empty($ap_info) ? $ap_info->amph_id : "" ?>" hidden>
                            <?php } ?>
                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกจังหวัด --" onchange="updatePvNameEn()" name="amphur[]" id="amph_pv_id" required>
                                <option value="all" selected disabled>กรุณาเลือกจังหวัด</option>
                                <?php if ($pv_info) { ?>
                                    <?php foreach ($pv_info as $item) { ?>
                                        <option value="<?php echo $item->pv_id ?>" data-pv_name_en="<?php echo $item->pv_name_en; ?>" <?php echo !empty($ap_info) && $item->pv_id == $ap_info->amph_pv_id ? 'selected' : '';  ?>><?php echo $item->pv_name ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">จังหวัด (EN)</label>
                            <input type="text" class="form-control" name="amphur[]" id="pv_name_en" placeholder="จังหวัดภาษาอังกฤษ" disabled value="">
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">อำเภอ (TH)</label>
                            <input type="text" class="form-control" name="amphur[]" id="amph_name" placeholder="อำเภอภาษาไทย" value="<?php echo !empty($ap_info) ? $ap_info->amph_name : ""; ?>">
                            <div class="d-flex justify-content-end">
                                <label id="amph_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">อำเภอ (EN)</label>
                            <input type="text" class="form-control" name="amphur[]" id="amph_name_en" placeholder="อำเภอภาษาอังกฤษ" value="<?php echo !empty($ap_info) ? $ap_info->amph_name_en : ""; ?>">
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($ap_info->amph_id)) { ?>
                                                <input class="form-check-input" type="checkbox" name="amphur[]" id="amph_active" value="<?php echo !empty($ap_info) ? $ap_info->amph_active : ""; ?>" <?php echo !empty($ap_info) && $ap_info->amph_active == '1' ? 'checked' : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="amph_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/amphur'">ย้อนกลับ</button>
                            <?php if (!empty($ap_info->amph_id)) { ?>
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

    function updatePvNameEn() {
        const amphSelect = document.getElementById('amph_pv_id');
        const pvNameEnInput = document.getElementById('pv_name_en');
        const selectedOption = amphSelect.options[amphSelect.selectedIndex];
        const pvNameEn = selectedOption.getAttribute('data-pv_name_en');
        pvNameEnInput.value = pvNameEn || '';
        // console.log(amph_id);
    }

    // เรียกฟังก์ชัน updateAmphNameEn เมื่อหน้าเว็บโหลดเสร็จ เพื่อเซ็ตค่าเริ่มต้น
    document.addEventListener('DOMContentLoaded', function() {
        updatePvNameEn();
    });

    function submitAdd() {
        $('[name^="amphur"]').each(function() {
            var checkbox = document.getElementById('amph_active');
            if (this.id != 'amph_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.amph_id;
        if (!formData.amph_name || !formData.amph_pv_id || formData.amph_pv_id == 'all') {
            !formData.amph_name ? $('#amph_name').get(0).focus() : '';
            !formData.amph_pv_id ? $('#amph_pv_id').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        console.log(formData);
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'amphur/checkValue'; ?>',
            method: 'POST',
            data: {
                amph_name: formData['amph_name'],
                amph_pv_id: formData['amph_pv_id'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('amph_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'อำเภอนี้ถูกใช้งานแล้ว'
                });
                $('#amph_name').get(0).focus()
                inputElement.innerHTML = "อำเภอนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>amphur/amphur_insert',
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
        var checkbox = document.getElementById('amph_active');
        $('[name^="amphur"]').each(function() {
            if (this.id != 'amph_active') {
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
        if (!formData.amph_name || !formData.amph_pv_id || formData.amph_pv_id == 'all') {
            !formData.amph_name ? $('#amph_name').get(0).focus() : '';
            !formData.amph_pv_id ? $('#amph_pv_id').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'amphur/checkValue'; ?>',
            method: 'POST',
            data: {
                amph_name: formData['amph_name'],
                amph_id: formData['amph_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('amph_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ศาสนาถูกนี้ใช้งานแล้ว'
                });
                $('#amph_name').get(0).focus()
                inputElement.innerHTML = "ศาสนานี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>amphur/amphur_update',
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