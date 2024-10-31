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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($ct_info) ? 'แก้ไข' : 'เพิ่ม' ?>ประเทศ</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อประเทศ (ภาษาไทย)</label>
                            <?php if (!empty($ct_info->country_id)) { ?>
                                <input type="text" name="country[]" id="country_id" value="<?php echo !empty($ct_info) ? $ct_info->country_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="country[]" id="country_name" placeholder="ประเทศภาษาไทย" value="<?php echo !empty($ct_info) ? $ct_info->country_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="country_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อประเทศ (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="country[]" id="country_name_en" placeholder="ประเทศภาษาอังกฤษ" value="<?php echo !empty($ct_info) ?  $ct_info->country_name_en : ""; ?>">
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($ct_info->country_id)) { ?>
                                                <input type="checkbox" name="country[]" id="country_active" class="form-check-input m-1" value="<?php echo !empty($ct_info) ? $ct_info->country_active : ""; ?>" <?php echo !empty($ct_info) && $ct_info->country_active == '1' ? 'checked' : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="country_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/country'">ย้อนกลับ</button>
                            <?php if (!empty($ct_info->country_id)) { ?>
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
        $('[name^="country"]').each(function() {
            var checkbox = document.getElementById('country_active');
            if (this.id != 'country_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.country_id;
        if (!formData.country_name) {
            !formData.country_name ? $('#country_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        console.log(formData);
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'country/checkValue'; ?>',
            method: 'POST',
            data: {
                country_name: formData['country_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('country_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ประเทศนี้ถูกใช้งานแล้ว'
                });
                $('#country_name').get(0).focus()
                inputElement.innerHTML = "ประเทศนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>country/country_insert',
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
        var checkbox = document.getElementById('country_active');
        $('[name^="country"]').each(function() {
            var checkbox = document.getElementById('country_active');
            if (this.id != 'country_active') {
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
        if (!formData.country_name ) {
            !formData.country_name ? $('#country_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'country/checkValue'; ?>',
            method: 'POST',
            data: {
                country_name: formData['country_name'],
                country_id: formData['country_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('country_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ประเทศถูกนี้ใช้งานแล้ว'
                });
                $('#country_name').get(0).focus()
                inputElement.innerHTML = "ประเทศนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>country/country_update',
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