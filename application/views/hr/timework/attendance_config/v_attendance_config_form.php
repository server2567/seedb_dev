<style>
.selected-color-box {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid #9fb4bf;
    display: inline-block;
    cursor: pointer;
    background-color: #fff;
}

.color-options {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

.color-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid #9fb4bf;
    cursor: pointer;
    transition: border 0.3s;
}

.color-circle:hover {
    border: 2px solid #000;
}

.modal-dialog-centered {
    max-width: 300px;
}

.btn-outline-secondary {
    padding: 6px 12px;
}



</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($row_twac) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลรูปแบบการลงเวลางาน<?php echo $hire_is_medical; ?></span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" id="attendange_form" novalidate>

                        <input type="hidden" name="twac_id" id="twac_id" value="<?php echo !empty($row_twac) ? encrypt_id($row_twac->twac_id) : "" ?>">

                        <div class="col-md-6 mt-3">
                            <label for="twac_name_th" class="form-label required">ชื่อรูปแบบการลงเวลางาน (ภาษาไทย) </label>
                            <input type="text" class="form-control mb-1" name="twac_name_th" id="twac_name_th" placeholder="ชื่อรูปแบบการลงเวลางาน (ภาษาไทย)" value="<?php echo !empty($row_twac) ? $row_twac->twac_name_th : ""; ?>" required>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="twac_name_abbr_th" class="form-label required">ชื่อย่อรูปแบบการลงเวลางาน (ภาษาไทย) </label>
                            <input type="text" class="form-control mb-1" name="twac_name_abbr_th" id="twac_name_abbr_th" placeholder="ชื่อย่อรูปแบบการลงเวลางาน (ภาษาไทย)" value="<?php echo !empty($row_twac) ? $row_twac->twac_name_abbr_th : ""; ?>" required>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="twac_time_work" class="form-label required">เวลาเข้า-ออกงาน</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="เวลาเข้างาน" aria-label="เวลาเข้างาน" id="twac_start_time" name="twac_start_time" value="">
                                <span class="input-group-text">ถึง</span>
                                <input type="text" class="form-control" placeholder="เวลาออกงาน" aria-label="เวลาออกงาน" id="twac_end_time" name="twac_end_time" value="">
                            </div>
                        </div>
                        
                        <div class="col-md-3 mt-3">
                            <label for="twac_late_time" class="form-label required">เวลาเข้างานสาย</label>
                            <input type="text" class="form-control" placeholder="เวลาเข้างานสาย" aria-label="เวลาเข้างานสาย" id="twac_late_time" name="twac_late_time" value="">
                        </div>
                        <div class="col-md-3 mt-3">
                            <label for="twac_time_color" class="form-label required">สี</label>
                            <div class="d-flex align-items-center">
                                <div class="selected-color-box" id="selectedColorBox" style="background-color: <?php echo !empty($row_twac) ? $row_twac->twac_color : "#388E3C"; ?>;" data-bs-toggle="modal" data-bs-target="#colorPickerModal"></div>
                                <input type="hidden" id="twac_color" name="twac_color" value="<?php echo !empty($row_twac) ? $row_twac->twac_color : "#388E3C"; ?>">
                            </div>
                        </div>


                        <?php
                            // Available options
                            $medical_types = [
                                'M'  => 'สายแพทย์',
                                'N'  => 'สายการพยาบาล',
                                'SM' => 'สายสนับสนุนทางการแพทย์',
                                'A'  => 'สายบริหาร',
                                'T'  => 'สายเทคนิคและบริการ'
                            ];

                            // Fetch available options from session
                            $available_types = $this->session->userdata('hr_hire_is_medical');
                            $available_types_array = array_column($available_types, 'type'); // Extract types from session

                        ?>

                        <div class="col-md-4 mt-3">
                            <label for="option_twac_is_medical" class="form-label required">สายงาน</label>
                            <div class="form-check">
                                <?php $first = true; // Flag to check the first option ?>
                                <?php foreach ($medical_types as $key => $label) : ?>
                                    <?php if (in_array($key, $available_types_array)) : // Only show the options that exist in session ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="option_twac_is_medical" value="<?php echo $key; ?>" 
                                                id="twac_is_medical_<?php echo $key; ?>" 
                                                <?php
                                                    // Check if the current option should be checked
                                                    echo !empty($row_twac) && $row_twac->twac_is_medical == $key 
                                                        ? 'checked' 
                                                        : ($first && empty($row_twac->twac_is_medical) ? 'checked' : '');
                                                ?>>
                                            <label for="twac_is_medical_<?php echo $key; ?>" class="form-check-label"><?php echo $label; ?></label>
                                        </div>
                                        <?php $first = false; // After the first iteration, this will be set to false ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>


                        <div class="col-md-4 mt-3">
                            <label for="option_twac_type" class="form-label required">ประเภทการทำงาน</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="option_twac_type" value="1" id="twac_type" <?php echo !empty($row_twac) && $row_twac->twac_type == 1 ? 'checked' :  'checked' ?>>
                                <label for="option_twac_type" class="form-check-label mb-2">ปฏิบัติงานเต็มเวลา (Full Time)</label> <br>
                                <input class="form-check-input" type="radio" name="option_twac_type" value="2" id="twac_type2" <?php echo !empty($row_twac) && $row_twac->twac_type == 2 ? 'checked' :  '' ?>>
                                <label for="option_twac_type" class="form-check-label">ปฏิบัติงานบางส่วนเวลา (Part Time)</label>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="twac_active" class="form-label">สถานะการใช้งาน</label>
                            <div class="form-check">
                                <?php if (!empty($row_twac->twac_id)) { ?>
                                    <input class="form-check-input" type="checkbox" name="twac_active" id="twac_active" value="<?php echo !empty($row_twac) ? $row_twac->twac_active : '' ?>" <?php echo !empty($row_twac) && $row_twac->twac_active == '1' ? 'checked' : '' ?>>
                                <?php } else { ?>
                                    <input type="checkbox" id="twac_active" name="twac_active" class="form-check-input m-1" checked disabled>
                                <?php } ?>
                                <label for="twac_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="location.href='<?php echo site_url($controller_dir); ?>'">ย้อนกลับ</button>
                            <?php if (!empty($row_twac->twac_id)) { ?>
                                <button type="button" onclick="submitForm('insert')" class="btn btn-success float-end">บันทึก</button>
                            <?php } else { ?>
                                <button type="button" onclick="submitForm('update')" class="btn btn-success float-end">บันทึก</button>
                            <?php } ?>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal สำหรับเลือกสี -->
<div class="modal fade" id="colorPickerModal" tabindex="-1" aria-labelledby="colorPickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="colorPickerModalLabel">เลือกสี</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="color-picker">
                    <div class="color-options d-flex flex-wrap">
                        <!-- สีเขียวเข้ม -->
                        <button class="color-circle" style="background-color: #388E3C;" data-color="#388E3C"></button>
                        <!-- สีส้มเข้ม -->
                        <button class="color-circle" style="background-color: #F57C00;" data-color="#F57C00"></button>
                        <!-- สีฟ้าเข้ม -->
                        <button class="color-circle" style="background-color: #1565C0;" data-color="#1565C0"></button>
                        <!-- สีม่วงเข้ม -->
                        <button class="color-circle" style="background-color: #6A1B9A;" data-color="#6A1B9A"></button>
                        <!-- สีแดงเข้ม -->
                        <button class="color-circle" style="background-color: #D32F2F;" data-color="#D32F2F"></button>
                        <!-- สีเทาเข้ม -->
                        <button class="color-circle" style="background-color: #424242;" data-color="#424242"></button>
                        <!-- สีดำ -->
                        <button class="color-circle" style="background-color: #000000;" data-color="#000000"></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
    // ฟังก์ชันสำหรับจัดการการเลือกสี
    document.querySelectorAll('.color-circle').forEach(function(button) {
        button.addEventListener('click', function() {
            const twac_color = this.getAttribute('data-color');
            
            // เปลี่ยนสีของกล่องที่แสดงสีที่เลือก
            document.getElementById('selectedColorBox').style.backgroundColor = twac_color;
            
            // กำหนดค่าสีที่เลือกลงใน hidden input เพื่อใช้งานในฟอร์ม
            document.getElementById('twac_color').value = twac_color;

            // ปิด Modal หลังจากเลือกสี
            var modal = bootstrap.Modal.getInstance(document.getElementById('colorPickerModal'));
            modal.hide();
        });
    });


    $(document).ready(function() {
        // Initialize flatpickr for start, end, and late time fields
        flatpickr(`#twac_start_time`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: "<?php echo !empty($row_twac) ? $row_twac->twac_start_time : '08:00'; ?>"
        });

        flatpickr(`#twac_end_time`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: "<?php echo !empty($row_twac) ? $row_twac->twac_end_time : '17:00'; ?>"
        });

        flatpickr(`#twac_late_time`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: "<?php echo !empty($row_twac) ? $row_twac->twac_late_time : '08:01'; ?>"
        });

    });
    
    function submitForm(actionType) {
        var form = $('#attendange_form')[0];
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        var form_attendance_config = new FormData(form);
        form_attendance_config.append('action', actionType);

        $.ajax({
            url: '<?php echo site_url($controller_dir . "attendance_config_save"); ?>',
            type: 'POST',
            data: form_attendance_config,
            processData: false,
            contentType: false,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status_response == status_response_success) {
                    dialog_success({'header': text_toast_save_success_header, 'body': data.message_dialog}, data.return_url, false);
                } else if (data.status_response == status_response_error) {
                    dialog_error({'header':text_toast_default_error_header, 'body': data.message_dialog});
                } 
            },
            error: function(xhr, status, error) {
                dialog_error({'header': text_toast_default_error_header, 'body': text_toast_default_error_body});
            }
        });
    }
</script>
