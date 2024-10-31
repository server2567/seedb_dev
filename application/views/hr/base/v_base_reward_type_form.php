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
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($rwt_info) ? 'แก้ไข' : 'เพิ่ม' ?>ด้านรางวัล</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อด้านรางวัล (ภาษาไทย)</label>
                            <?php if (!empty($rwt_info->rwt_id)) { ?>
                                <input type="text" name="rtype[]" id="rwt_id" value="<?php echo !empty($rwt_info) ? $rwt_info->rwt_id : ""; ?>" hidden>
                            <?php } ?>
                            <input type="text" class="form-control" name="rtype[]" id="rwt_name" placeholder="ด้านรางวัลภาษาไทย" value="<?php echo !empty($rwt_info) ? $rwt_info->rwt_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="rwt_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StAbbrT" class="form-label required">ชื่อด้านรางวัล (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="rtype[]" id="rwt_name_en" placeholder="ด้านรางวัลภาษาอังกฤษ" value="<?php echo !empty($rwt_info) ? $rwt_info->rwt_name_en : ""; ?>" required>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                                </div>
                                <div class="col-10">
                                    <ul>
                                        <li>
                                            <?php if (!empty($rwt_info->rwt_id)) { ?>
                                                <input type="checkbox" name="rtype[]" id="rwt_active" class="form-check-input m-1" value="<?php echo !empty($rwt_info) ? $rwt_info->rwt_active : ""; ?>" <?php echo !empty($rwt_info) && $rwt_info->rwt_active == '1' ? 'checked' : ''; ?>>
                                            <?php } else { ?>
                                                <input type="checkbox" id="rwt_active" class="form-check-input m-1" checked disabled>
                                            <?php } ?>
                                            <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/reward_type'">ย้อนกลับ</button>
                            <?php if (!empty($rwt_info->rwt_id)) { ?>
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
        $('[name^="rtype"]').each(function() {
            var checkbox = document.getElementById('rwt_active');
            if (this.id != 'rwt_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        delete formData.rwt_id;
        if (!formData.rwt_name || !formData.rwt_name_en) {
            !formData.rwt_name ? $('#rwt_name').get(0).focus() : '';
            !formData.rwt_name_en ? $('#rwt_name_en').get(0).focus() : '';

            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'reward_type/checkValue'; ?>',
            method: 'POST',
            data: {
                rwt_name: formData['rwt_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('rwt_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ด้านรางวัลนี้ถูกใช้งานแล้ว'
                });
                $('#rwt_name').get(0).focus()
                inputElement.innerHTML = "ด้านรางวัลนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'reward_type/reward_type_insert'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo site_url() ?>/hr/base/reward_type'
                    }, 1500);
                })
            }
        })
    }

    function submitEdit() {
        $('[name^="rtype"]').each(function() {
            var checkbox = document.getElementById('rwt_active');
            if (this.id != 'rwt_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        if (!formData.rwt_name || !formData.rwt_name_en) {
            !formData.rwt_name ? $('#rwt_name').get(0).focus() : '';
            !formData.rwt_name_en ? $('#rwt_name_en').get(0).focus() : '';
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        console.log(formData);
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'reward_type/checkValue'; ?>',
            method: 'POST',
            data: {
                rwt_name: formData['rwt_name'],
                rwt_id: formData['rwt_id'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('rwt_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ด้านรางวัลนี้ถูกใช้งานแล้ว'
                });
                $('#rwt_name').get(0).focus()
                inputElement.innerHTML = "ด้านรางวัลนี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'reward_type/reward_type_update'; ?>',
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