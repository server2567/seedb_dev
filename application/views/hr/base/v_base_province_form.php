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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($pv_info) ? 'แก้ไข' : 'เพิ่ม' ?>จังหวัด</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">จังหวัด (TH)</label>
                            <?php if (!empty($pv_info->pv_id)) { ?>
                                <input type="text" name="province[]" id="pv_id" value="<?php echo !empty($pv_info) ? $pv_info->pv_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="province[]" id="pv_name" placeholder="จังหวัดภาษาไทย" value="<?php echo !empty($pv_info) ? $pv_info->pv_name : ""; ?>">
                            <div class="d-flex justify-content-end">
                                <label id="pv_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">จังหวัด (EN)</label>
                            <input type="text" class="form-control" name="province[]" id="pv_name_en" placeholder="จังหวัดภาษาอังกฤษ" value="<?php echo !empty($pv_info) ? $pv_info->pv_name_en : ""; ?>">
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($pv_info->pv_id)) { ?>
                                                <input type="checkbox" name="province[]" id="pv_active" class="form-check-input m-1" value="<?php echo !empty($pv_info) ? $pv_info->pv_active : ""; ?>" <?php echo !empty($pv_info) && $pv_info->pv_active == '1' ? 'checked' : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="pv_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/province'">ย้อนกลับ</button>
                            <?php if (!empty($pv_info->pv_id)) { ?>
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
        $('[name^="province"]').each(function() {
            var checkbox = document.getElementById('pv_active');
            if (this.id != 'pv_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.pv_id;
        if (!formData.pv_name) {
            !formData.pv_name ? $('#pv_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        console.log(formData);
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'province/checkValue'; ?>',
            method: 'POST',
            data: {
                pv_name: formData['pv_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('pv_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'จังหวัดนี้ถูกใช้งานแล้ว'
                });
                $('#pv_name').get(0).focus()
                inputElement.innerHTML = "จังหวัดนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>province/province_insert',
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
        var checkbox = document.getElementById('pv_active');
        $('[name^="province"]').each(function() {
            var checkbox = document.getElementById('pv_active');
            if (this.id != 'pv_active') {
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
        if (!formData.pv_name ) {
            !formData.pv_name ? $('#pv_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'province/checkValue'; ?>',
            method: 'POST',
            data: {
                pv_name: formData['pv_name'],
                pv_id: formData['pv_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('pv_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ศาสนาถูกนี้ใช้งานแล้ว'
                });
                $('#pv_name').get(0).focus()
                inputElement.innerHTML = "ศาสนานี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>province/province_update',
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