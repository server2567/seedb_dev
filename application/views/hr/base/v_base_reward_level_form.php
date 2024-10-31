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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($rwlv_info) ? 'แก้ไข' : 'เพิ่ม' ?>ระดับรางวัล</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อระดับรางวัล (ภาษาไทย)</label>
                            <?php if (!empty($rwlv_info->rwlv_id)) { ?>
                                <input type="text" name="rlevel[]" id="rwlv_id" value="<?php echo !empty($rwlv_info) ? $rwlv_info->rwlv_id : ""; ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control mb-1" name="rlevel[]" id="rwlv_name" placeholder="ระดับรางวัลภาษาไทย" value="<?php echo !empty($rwlv_info) ? $rwlv_info->rwlv_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="rwlv_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label required">ชื่อระดับรางวัล (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="rlevel[]" id="rwlv_name_en" placeholder="ระดับรางวัลภาษาอังกฤษ" value="<?php echo !empty($rwlv_info) ? $rwlv_info->rwlv_name_en : ""; ?>" required>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($rwlv_info->rwlv_id)) { ?>
                                                <input type="checkbox" name="rlevel[]" id="rwlv_active" class="form-check-input m-1" value="<?php echo !empty($rwlv_info) ? $rwlv_info->rwlv_active : ""; ?>" <?php echo !empty($rwlv_info) && $rwlv_info->rwlv_active == '1' ? 'checked' : ''; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="rwlv_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/reward_level'">ย้อนกลับ</button>
                            <?php if (!empty($rwlv_info->rwlv_id)) { ?>
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
        $('[name^="rlevel"]').each(function() {
            var checkbox = document.getElementById('rwlv_active');
            if (this.id != 'rwlv_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.rwlv_id;
        if (!formData.rwlv_name || !formData.rwlv_name_en) {
            !formData.rwlv_name ? $('#rwlv_name').get(0).focus() : '';
            !formData.rwlv_name_en ? $('#rwlv_name_en').get(0).focus() : '';

            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'reward_level/checkValue'; ?>',
            method: 'POST',
            data: {
                rwlv_name: formData['rwlv_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('rwlv_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ระดับรางวัลนี้ถูกใช้งานแล้ว'
                });
                $('#rwlv_name').get(0).focus()
                inputElement.innerHTML = "ระดับรางวัลนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'reward_level/reward_level_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() ?>/hr/base/reward_level'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="rlevel"]').each(function() {
            var checkbox = document.getElementById('rwlv_active');
            if (this.id != 'rwlv_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        if (!formData.rwlv_name || !formData.rwlv_name_en) {
            !formData.rwlv_name ? $('#rwlv_name').get(0).focus() : '';
            !formData.rwlv_name_en ? $('#rwlv_name_en').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        console.log(formData);
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'reward_level/checkValue'; ?>',
            method: 'POST',
            data: {
                rwlv_name: formData['rwlv_name'],
                rwlv_id: formData['rwlv_id'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('rwlv_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ระดับรางวัลนี้ถูกใช้งานแล้ว'
                });
                $('#rwlv_name').get(0).focus()
                inputElement.innerHTML = "ระดับรางวัลนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'reward_level/reward_level_update'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    // setTimeout(function() {
                    //     location.reload();
                    // }, 1500);
                })
            }
        })
    }
</script>