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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($ct_info) ? 'แก้ไข' : 'เพิ่ม' ?>ประเภทพัฒนาบุคลากร</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อประเภทพัฒนาบุคลากร (ภาษาไทย)</label>
                            <?php if (!empty($ct_info->devb_id)) { ?>
                                <input type="text" name="develop[]" id="devb_id" value="<?php echo !empty($ct_info) ? $ct_info->devb_id : "" ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="develop[]" id="devb_name" placeholder="ประเภทพัฒนาบุคลากรภาษาไทย" value="<?php echo !empty($ct_info) ? $ct_info->devb_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="devb_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อประเภทพัฒนาบุคลากร (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="develop[]" id="devb_name_en" placeholder="ประเภทพัฒนาบุคลากรภาษาอังกฤษ" value="<?php echo !empty($ct_info) ?  $ct_info->devb_name_en : ""; ?>">
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($ct_info->devb_id)) { ?>
                                                <input type="checkbox" name="develop[]" id="devb_active" class="form-check-input m-1" value="<?php echo !empty($ct_info) ? $ct_info->devb_active : ""; ?>" <?php echo !empty($ct_info) && $ct_info->devb_active == '1' ? 'checked' : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="devb_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/develop_type'">ย้อนกลับ</button>
                            <?php if (!empty($ct_info->devb_id)) { ?>
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
        $('[name^="develop"]').each(function() {
            var checkbox = document.getElementById('devb_active');
            if (this.id != 'devb_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.devb_id;
        if (!formData.devb_name) {
            !formData.devb_name ? $('#devb_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        console.log(formData);
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'develop_type/checkValue'; ?>',
            method: 'POST',
            data: {
                devb_name: formData['devb_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('devb_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ประเภทพัฒนาบุคลากรนี้ถูกใช้งานแล้ว'
                });
                $('#devb_name').get(0).focus()
                inputElement.innerHTML = "ประเภทพัฒนาบุคลากรนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>develop_type/develop_type_insert',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() ?>/hr/base/develop_type'
                    }, 1500);i
                })
            }
        })
    }

    function submitEdit() {
        var checkbox = document.getElementById('devb_active');
        $('[name^="develop"]').each(function() {
            var checkbox = document.getElementById('devb_active');
            if (this.id != 'devb_active') {
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
        if (!formData.devb_name) {
            !formData.devb_name ? $('#devb_name').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'develop_type/checkValue'; ?>',
            method: 'POST',
            data: {
                devb_name: formData['devb_name'],
                devb_id: formData['devb_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('devb_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ประเภทพัฒนาบุคลากรถูกนี้ใช้งานแล้ว'
                });
                $('#devb_name').get(0).focus()
                inputElement.innerHTML = "ประเภทพัฒนาบุคลากรนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller; ?>develop_type/develop_type_update',
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