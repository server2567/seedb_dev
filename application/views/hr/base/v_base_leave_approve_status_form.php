<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($exts_info) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลประเภทบริการหน่วยงาน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-6">
                            <label for="StNameT" class="form-label required">ชื่อหน้าที่ของผู้อนุมัติ </label>
                            <input type="text" class="form-control mb-1" name="leave_approve[]" id="last_name" placeholder="ชื่อหน้าที่ของผู้อนุมัติ " value="<?php echo !empty($leave_approve) ? $leave_approve->last_name : ""; ?>" required>
                            <div class="d-flex justify-content-end">
                                <label id="last_msg" style="color:red; font-size:small;"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label">ชื่อทางการ </label>
                            <input type="text" class="form-control mb-1" name="leave_approve[]" id="last_mean" placeholder="ชื่อทางการ" value="<?php echo !empty($leave_approve) ? $leave_approve->last_mean : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label">ชื่อเมื่ออนุมัติ </label>
                            <input type="text" class="form-control mb-1" name="leave_approve[]" id="last_yes" placeholder="ชื่อเมื่อไม่อนุมัติ" value="<?php echo !empty($leave_approve) ? $leave_approve->last_no : ""; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="StNameT" class="form-label">ชื่อเมื่อไม่อนุมัติ </label>
                            <input type="text" class="form-control mb-1" name="leave_approve[]" id="last_no" placeholder="รายละเอียดเพิ่มเติม" value="<?php echo !empty($leave_approve) ? $leave_approve->last_mean : ""; ?>" required>
                        </div>
                        <div class="col-8">
                            <label for="StNameT" class="form-label">รายละเอียดเพิ่มเติม </label>
                            <textarea class="form-control" name="leave_approve[]" id="last_desc" value="<?php echo !empty($leave_approve) ? $leave_approve->last_desc : ""; ?>" rows="3" required> <?php echo !empty($leave_approve) ? $leave_approve->last_desc : ""; ?></textarea>
                        </div>
                        <div class="col-4">
                            <label for="StActive" class="form-label">สถานะการใช้งาน</label>
                            <div class="form-check">
                                <?php if (!empty($leave_approve->last_id)) { ?>
                                    <input class="form-check-input" type="checkbox" name="leave_approve[]" id="last_active" value="<?php echo !empty($leave_approve) ? $leave_approve->last_active : '' ?>" <?php echo !empty($leave_approve) && $leave_approve->last_active == '1' ? 'checked' : '' ?>>
                                <?php } else { ?>
                                    <input type="checkbox" id="last_active" class="form-check-input m-1" checked disabled>
                                <?php } ?>
                                <label for="StActive" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/base/Leave_approve'">ย้อนกลับ</button>
                            <?php if (!empty($leave_approve->last_id)) { ?>
                                <button type="button" onclick="submitForm(<?= $leave_approve->last_id ?>)" class="btn btn-success float-end">บันทึก</button>
                            <?php } else { ?>
                                <button type="button" onclick="submitForm()" class="btn btn-success float-end">บันทึก</button>
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

    function submitForm(id = null) {
        formData.last_id = id
        $('[name^="leave_approve"]').each(function() {
            var checkbox = document.getElementById('last_active');
            if (this.id != 'last_active') {
                formData[this.id] = this.value;
            } else {
                if (checkbox.checked) {
                    formData[this.id] = '1'
                } else {
                    formData[this.id] = '0'
                }
            }
        });
        if (!formData.last_name) {
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'กรุณากรอกข้อมูลให้ครบถ้วน'
            });
            return false;
        }
        $.ajax({
            url: '<?php echo site_url() . '/' . $controller . 'Leave_approve/checkValue'; ?>',
            method: 'POST',
            data: {
                last_id: formData['last_id'],
                last_name: formData['last_name'],
            }
        }).done(function(returnedData) {
            var data = JSON.parse(returnedData)
            var inputElement = document.getElementById('last_msg');
            if (data.status_response == 1) {
                dialog_error({
                    'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                    'body': 'ประเภทบริการนี้ถูกใช้งานแล้ว'
                });
                $('#exts_name_th').get(0).focus()
                inputElement.innerHTML = "สถานะการอนุมัตินี้ถูกใช้งานแล้ว";
                return false;
            } else {
                inputElement.innerHTML = "";
                $.ajax({
                    url: '<?php echo site_url() . '/' . $controller . 'Leave_approve/submit_leave_approve'; ?>',
                    method: 'POST',
                    data: formData
                }).done(function(returnedData) {
                    dialog_success({
                        'header': 'ดำเนินการเสร็จสิ้น',
                        'body': 'บันทึกข้อมูลเสร็จสิ้น'
                    });
                    setTimeout(function() {
                        window.location.href = '<?php echo base_url() ?>index.php/hr/base/Leave_approve'
                    }, 1500);
                })
            }
        })
    }
</script>