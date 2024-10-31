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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($ps_info->psst_id) ? 'แก้ไข' : 'เพิ่ม' ?>สถานภาพ</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <input type="text" name="person_status[]" id="psst_id" hidden value="<?= !empty($ps_info->psst_id) ? $ps_info->psst_id : ''   ?>">
                            <label for="StNameT" class="form-label required">ชื่อสถานภาพ (ภาษาไทย)</label>
                            <input type="text" class="form-control mb-1" name="person_status[]" id="psst_name" placeholder="ชื่อสถานภาพภาษาไทย" value="<?php echo !empty($ps_info) ? $ps_info->psst_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="psst_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label">ชื่อสถานภาพ (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="person_status[]" id="psst_name_en" placeholder="ชื่อสถานภาพภาษาอังกฤษ" value="<?php echo !empty($ps_info) ? $ps_info->psst_name_en : ""; ?>" required>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($ps_info->psst_id)) { ?>
                                                <input type="checkbox" name="person_status[]" id="psst_active" class="form-check-input m-1" value="<?php echo !empty($ps_info) ? $ps_info->psst_active : ""; ?>" <?php echo $ps_info->psst_active == '1' ? 'checked' : ""; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="psst_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Person_status'">ย้อนกลับ</button>
                            <?php if (!empty($ps_info->psst_id)) { ?>
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
        $('[name^="person_status"]').each(function() {
            var checkbox = document.getElementById('psst_active');
            if (this.id != 'psst_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.psst_id
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'person_status/checkValue'; ?>',
            method: 'POST',
            data: {
                psst_name: formData['psst_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('psst_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'สถานภาพนี้ถูกใช้งานแล้ว'
                });
                $('#psst_name').get(0).focus()
                inputElement.innerHTML = "สถานภาพนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                if (!formData.psst_name) {
                    !formData.psst_name ? $('#psst_name').get(0).focus() : '';
                 

                    dialog_error({
                        'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                        'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
                    });
                    return false;
                }
                $.ajax({
                    url: 'person_status_insert',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                       window.location.href = '<?php echo site_url() . '/' . $controller . 'Person_status'?>'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="person_status"]').each(function() {
            var checkbox = document.getElementById('psst_active');
            if (this.id != 'psst_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        if (!formData.psst_name ) {
            !formData.psst_name ? $('#psst_name').get(0).focus() : '';
          
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'person_status/checkValue'; ?>',
            method: 'POST',
            data: {
                psst_name: formData['psst_name'],
                psst_id: formData['psst_id']
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('psst_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'สภานภาพนี้ถูกใช้งานแล้ว'
                });
                $('#psst_name').get(0).focus()
                inputElement.innerHTML = "สถานภาพนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'person_status/person_status_update'; ?>',
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