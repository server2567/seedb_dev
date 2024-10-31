<style>
    .card-header {
        background-color: #cfe2ff;
        border-color: #cfe2ff;
    }
</style>

<!-- Card with header and footer -->
<div class="card">
    <div class="card-header">
        <i class="bi-people icon-menu"></i><span> <b>เพิ่มรายชื่อบุคลากร</b></span>
    </div>
    <div class="card-body">
        <form method="post" class="needs-validation" id="profile_form_input" enctype="multipart/form-data" novalidate>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="pos_dp_id" class="form-label required">หน่วยงาน</label>
                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="pos_dp_id[]" id="pos_dp_id" multiple required>
                        <?php
                        foreach ($base_ums_department_list as $key => $row) {
                        ?>
                            <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="pos_dp_id" class="form-label required">ประเภทบุคลากร</label>
                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกประเภทบุคลากร --" name="pos_hire_id" id="pos_hire_id" required>
                        <?php
                        foreach ($base_hire_list as $key => $row) {
                        ?>
                            <option value="<?php echo $row->hire_id; ?>"><?php echo $row->hire_name." ".$row->hire_is_medical_label; ?></option>

                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="ps_pf_id" class="form-label required">คำนำหน้า</label>
                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกคำนำหน้า --" name="ps_pf_id" id="ps_pf_id" required>
                        <?php
                        foreach ($base_prefix_list as $key => $row) {
                        ?>
                            <option value="<?php echo $row->pf_id; ?>"><?php echo $row->pf_name; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                   
                </div>
                <div class="col-md-6 mt-4 ps_fname_div">
                    <label for="ps_fname" class="form-label required">ชื่อ (ภาษาไทย)</label>
                    <input type="text" class="form-control" name="ps_fname" id="ps_fname" placeholder="ชื่อ (ภาษาไทย)" value="" required>
                </div>
                <div class="col-md-6 mt-4 ps_lname_div">
                    <label for="ps_lname" class="form-label required">นามสกุล (ภาษาไทย)</label>
                    <input type="text" class="form-control" name="ps_lname" id="ps_lname" placeholder="นามสกุล (ภาษาไทย)" value="" required>
                </div>
                <div class="col-md-6">
                    <label for="ps_fname_en" class="form-label required">ชื่อ (ภาษาอังกฤษ)</label>
                    <input type="text" class="form-control" name="ps_fname_en" id="ps_fname_en" placeholder="ชื่อ (ภาษาอังกฤษ)" value="" required>
                </div>
                <div class="col-md-6">
                    <label for="ps_lname_en" class="form-label required">นามสกุล (ภาษาอังกฤษ)</label>
                    <input type="text" class="form-control" name="ps_lname_en" id="ps_lname_en" placeholder="นามสกุล (ภาษาอังกฤษ)" value="" required>
                </div>
                <div class="col-md-6">
                    <label for="ps_nickname" class="form-label">ชื่อเล่น (ภาษาไทย)</label>
                    <input type="text" class="form-control" name="ps_nickname" id="ps_nickname" placeholder="ชื่อเล่น (ภาษาไทย)" value="">
                </div>
                <div class="col-md-6">
                    <label for="ps_nickname_en" class="form-label">ชื่อเล่น (ภาษาอังกฤษ)</label>
                    <input type="text" class="form-control" name="ps_nickname_en" id="ps_nickname_en" placeholder="ชื่อเล่น (ภาษาอังกฤษ)" value="">
                </div>
                <div class="col-md-6">
                    <label for="psd_gd_id" class="form-label required">เพศ</label>
                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกเพศ--" name="psd_gd_id" id="psd_gd_id" required>
                        <?php
                        foreach ($base_gender_list as $key => $row) {
                        ?>
                            <option value="<?php echo $row->gd_id; ?>"><?php echo $row->gd_name; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6 psd_id_card_no_div">
                    <label for="psd_id_card_no" class="form-label required">เลขบัตรประชาชน</label>
                    <input type="text" class="form-control" name="psd_id_card_no" id="psd_id_card_no" placeholder="เลขบัตรประชาชน" maxlength="17" value="" required>
                </div>
                <div class="col-md-6">
                    <label for="psd_birthdate" class="form-label ">วันเกิด</label>
                    <input type="text" class="form-control" name="psd_birthdate" id="psd_birthdate" placeholder="วันเกิด">
                </div>
                <div class="col-md-6">
                    <label for="psd_email" class="form-label required">E-mail</label>
                    <input type="email" class="form-control" name="psd_email" id="psd_email" placeholder="E-mail" value="" required>
                </div>
                <div class="col-md-6">
                    <label for="psd_picture" class="form-label">รูปประจำตัว</label>
                    <input type="file" class="form-control input-bs-file" name="psd_picture" id="psd_picture" accept=".png,.jpg" placeholder="รูปประจำตัว" onchange="displaySelectedImage(event, 'selected-image')">
                    <div class="d-flex justify-content-center">
                        <img id="selected-image" class="d-none" src="" style="width: 300px;" />
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="psd_desc" class="form-label">หมายเหตุ</label>
                    <textarea class="form-control" name="psd_desc" id="psd_desc" placeholder="หมายเหตุ" rows="4" value=""></textarea>
                </div>
            </div>

        </form>
    </div>
    <div class="card-footer">
        <div class="mt-3 mb-3 col-md-12">
            <a type="button" class="btn btn-secondary float-start" href="<?php echo site_url() . "/" . $controller_dir; ?>" title="คลิกเพื่อย้อนกลับ" data-toggle="tooltip" data-placement="top">ย้อนกลับ</a>
            <button type="button" class="btn btn-success float-end" onclick="profile_save_form()" title="คลิกเพื่อบันทึกข้อมูล" data-toggle="tooltip" data-placement="top">บันทึก</button>
        </div>
    </div>
</div>
<!-- End Card with header and footer -->



<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function profile_save_form() {
        var form = document.getElementById('profile_form_input');
        var profile_form_data = new FormData(form); // Create a FormData object from the form

        var isValid = true;
        var isDuplicate = true;

        // List of fields to exclude from validation
        var excludeFields = ["psd_birthdate", "psd_picture", "psd_desc", "ps_nickname", "ps_nickname_en"];


        // Validate regular form controls
        $('#profile_form_input .form-control').each(function() {
            var fieldName = $(this).attr('name');

            if (!excludeFields.includes(fieldName)) {
                if ($(this).val() === '' || $(this).val() === null) {
                    isValid = false;
                    $(this).removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
                } else {
                    $(this).removeClass('is-invalid').addClass('is-valid').siblings('.invalid-feedback').hide();
                }
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid').siblings('.invalid-feedback').hide();
            }
        });

        // Validate Select2 elements
        $('#profile_form_input .form-select').each(function() {
            var fieldName = $(this).attr('name');
            var fieldValue = $(this).val();

            if (fieldValue === '' || fieldValue === null) {
                isValid = false;
                $(this).siblings('.select2-container').find('.select2-selection').removeClass('is-valid').addClass('is-invalid');
                $(this).siblings('.invalid-feedback').show();
            } else {
                // If there is a value, show as valid
                $(this).siblings('.select2-container').find('.select2-selection').removeClass('is-invalid').addClass('is-valid');
                $(this).siblings('.invalid-feedback').hide();
            }
        });

        // start if isValid
        if (isValid) {
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>profile_insert',
                type: 'POST',
                data: profile_form_data,
                contentType: false, // Required for file uploads
                processData: false, // Required for file uploads
                success: function(data) {
                    data = JSON.parse(data);
                    // console.log(data.data.status_response)
                    if (data.data.status_response == status_response_success) {
                        dialog_success({
                            'header': text_toast_save_success_header,
                            'body': data.data.message_dialog
                        }, null, true);
                    } else if (data.data.status_response == status_response_error) {
                        dialog_error({
                            'header': text_toast_default_error_header,
                            'body': data.data.message_dialog
                        });
                        $(".ps_fname_div #ps_fname").removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
                        $(".ps_fname_div .invalid-feedback").text(data.data.message_dialog);

                        $(".ps_lname_div #ps_lname").removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
                        $(".ps_lname_div .invalid-feedback").text(data.data.message_dialog);

                        $(".psd_id_card_no_div #psd_id_card_no").removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
                        $(".psd_id_card_no_div .invalid-feedback").text(data.data.message_dialog);
                    }

                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                }
            });
        } else {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_invalid_default
            });
        }
        // end if isValid
    }

    document.addEventListener('DOMContentLoaded', () => {
        const numberInput = document.getElementById('psd_id_card_no');

        numberInput.addEventListener('input', (e) => {
            const cursorPosition = numberInput.selectionStart;
            const rawValue = numberInput.value.replace(/\D/g, ''); // Remove any non-digit characters
            const previousFormattedValue = numberInput.value;
            const formattedValue = formatNumber(rawValue);

            numberInput.value = formattedValue;

            adjustCursorPosition(numberInput, cursorPosition, previousFormattedValue, formattedValue);
        });

        function formatNumber(value) {
            if (value.length === 0) {
                return '';
            }

            const part1 = value.substring(0, 1);
            const part2 = value.substring(1, 5);
            const part3 = value.substring(5, 10);
            const part4 = value.substring(10, 12);
            const part5 = value.substring(12, 13);

            let formatted = part1;
            if (part2) formatted += ' ' + part2;
            if (part3) formatted += ' ' + part3;
            if (part4) formatted += ' ' + part4;
            if (part5) formatted += ' ' + part5;

            return formatted;
        }

        function adjustCursorPosition(input, originalPosition, previousValue, currentValue) {
            // Calculate the cursor position based on changes in the value
            let formattedOriginalPos = formatNumber(previousValue.substring(0, originalPosition).replace(/\D/g, '')).length;

            // Count spaces added or removed
            let spacesBefore = (previousValue.substring(0, formattedOriginalPos).match(/ /g) || []).length;
            let spacesAfter = (currentValue.substring(0, formattedOriginalPos).match(/ /g) || []).length;

            // Adjust the position based on space differences
            let newPosition = originalPosition + (spacesAfter - spacesBefore);

            setTimeout(() => {
                input.setSelectionRange(newPosition, newPosition);
            }, 0);
        }
    });

    function displaySelectedImage(event, elementId) {
        const selected_image = document.getElementById(elementId);
        const fileInput = event.target;

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            const file = fileInput.files[0];

            reader.onload = function(e) {
                selected_image.value = file.name;
                selected_image.src = e.target.result;
                selected_image.classList.remove('d-none');
            }

            reader.readAsDataURL(fileInput.files[0]);
        } else {
            selected_image.value = ''; // Clear the input value

            // Manually trigger the change event to handle the UI update
            const event = new Event('change');
            selected_image.dispatchEvent(event);

            // selected_image.src = e.target.result;
            selected_image.classList.add('d-none');
        }
    }

    flatpickr("#psd_birthdate", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
        onReady: function(selectedDates, dateStr, instance) {
            // addMonthNavigationListeners();
            // convertYearsToThai();
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
            if (!selectedDates || selectedDates.length === 0) { // ถ้ายังไม่ได้เลือกวันที่
                document.getElementById('psd_birthdate').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('psd_birthdate').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    function addMonthNavigationListeners() {
        const calendar = document.querySelector('.flatpickr-calendar');
        if (calendar) {
            const prevButton = calendar.querySelector('.flatpickr-prev-month');
            const nextButton = calendar.querySelector('.flatpickr-next-month');
            if (prevButton && nextButton) {
                prevButton.addEventListener('click', function() {
                    setTimeout(convertYearsToThai, 0);
                });
                nextButton.addEventListener('click', function() {
                    setTimeout(convertYearsToThai, 0);
                });
            }
        }
    }

    function convertYearsToThai() {
        const calendar = document.querySelector('.flatpickr-calendar');
        if (!calendar) return;

        const years = calendar.querySelectorAll('.cur-year, .numInput');
        years.forEach(function(yearInput) {
            convertToThaiYear(yearInput);
        });

        const yearDropdowns = calendar.querySelectorAll('.flatpickr-monthDropdown-months');
        yearDropdowns.forEach(function(monthDropdown) {
            if (monthDropdown) {
                monthDropdown.querySelectorAll('option').forEach(function(option) {
                    convertToThaiYearDropdown(option);
                });
            }
        });

        const currentYearElement = calendar.querySelector('.flatpickr-current-year');
        if (currentYearElement) {
            const currentYear = parseInt(currentYearElement.textContent);
            if (currentYear < 2500) {
                currentYearElement.textContent = currentYear + 543;
            }
        }
    }

    function convertToThaiYear(yearInput) {
        const currentYear = parseInt(yearInput.value);
        if (currentYear < 2500) { // Convert to B.E. only if not already converted
            yearInput.value = currentYear + 543;
        }
    }

    function convertToThaiYearDropdown(option) {
        const year = parseInt(option.textContent);
        if (year < 2500) { // Convert to B.E. only if not already converted
            option.textContent = year + 543;
        }
    }

    function formatDateToThai(date) {
        const d = new Date(date);
        const year = d.getFullYear();
        const month = ('0' + (d.getMonth() + 1)).slice(-2);
        const day = ('0' + d.getDate()).slice(-2);
        return `${day}/${month}/${year}`;
    }
</script>