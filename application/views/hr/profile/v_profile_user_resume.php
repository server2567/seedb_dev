<form method="post" class="needs-validation" id="profile_resume_form" enctype="multipart/form-data" novalidate>      
    <input type="hidden" name="ps_id" id="ps_id" value="<?php echo encrypt_id($ps_id); ?>">  
    <input type="hidden" name="tab_active" id="tab_active" value="1">   

    <div class="row">
        <div class="col-md-12">
            <div class="accordion" id="accordionResume">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="HeadingResume">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseResume" aria-expanded="false" aria-controls="collapseResume">
                            <i class="bi-file-person icon-menu font-20"></i>จัดการข้อมูลส่วนตัว
                        </button>
                    </h2>
                    <div id="collapseResume" class="accordion-collapse collapse show" aria-labelledby="HeadingResume" data-bs-parent="#accordionResume">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <a href="javascript:void(0);" class="float-end" id="btn_person_history" data-bs-toggle="modal" data-bs-target="#person-history-modal">ประวัติการเปลี่ยนข้อมูลส่วนตัว </a>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="ps_pf_id" class="form-label required">คำนำหน้า</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกคำนำหน้า --" name="ps_pf_id" id="ps_pf_id" required>
                                      
                                    </select>
                                </div>
                                <div class="col-md-6 mt-2">
                                   
                                </div>
                                <div class="col-md-6 mt-4">
                                    <label for="ps_fname" class="form-label required">ชื่อ (ภาษาไทย)</label>
                                    <input type="text" class="form-control" name="ps_fname" id="ps_fname" placeholder="ชื่อ (ภาษาไทย)" value="<?php echo isset($row_profile) ? $row_profile->ps_fname : ""; ?>" required>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <label for="ps_lname" class="form-label required">นามสกุล (ภาษาไทย)</label>
                                    <input type="text" class="form-control" name="ps_lname" id="ps_lname" placeholder="นามสกุล (ภาษาไทย)" value="<?php echo isset($row_profile) ? $row_profile->ps_lname : ""; ?>" required>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="ps_fname_en" class="form-label required">ชื่อ (ภาษาอังกฤษ)</label>
                                    <input type="text" class="form-control" name="ps_fname_en" id="ps_fname_en" placeholder="ชื่อ (ภาษาอังกฤษ)" value="<?php echo isset($row_profile) ? $row_profile->ps_fname_en : ""; ?>" required>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="ps_lname_en" class="form-label required">นามสกุล (ภาษาอังกฤษ)</label>
                                    <input type="text" class="form-control" name="ps_lname_en" id="ps_lname_en" placeholder="นามสกุล (ภาษาอังกฤษ)" value="<?php echo isset($row_profile) ? $row_profile->ps_lname_en : ""; ?>" required>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="ps_nickname" class="form-label">ชื่อเล่น (ภาษาไทย)</label>
                                    <input type="text" class="form-control" name="ps_nickname" id="ps_nickname" placeholder="ชื่อเล่น (ภาษาไทย)" value="<?php echo isset($row_profile) ? $row_profile->ps_nickname : ""; ?>">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="ps_nickname_en" class="form-label">ชื่อเล่น (ภาษาอังกฤษ)</label>
                                    <input type="text" class="form-control" name="ps_nickname_en" id="ps_nickname_en" placeholder="ชื่อเล่น (ภาษาอังกฤษ)" value="<?php echo isset($row_profile) ? $row_profile->ps_nickname_en : ""; ?>">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="psd_gd_id" class="form-label required">เพศ</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกเพศ --" name="psd_gd_id" id="psd_gd_id" onchange="change_prefix_by_gd_id(<?php echo (isset($row_profile) && $row_profile->ps_pf_id ? $row_profile->ps_pf_id : 0); ?>, value)" required>
                                        <option value="">-- เลือกเพศ--</option>
                                        <?php
                                            foreach($base_gender_list as $key=>$row){
                                        ?>
                                            <option value="<?php echo $row->gd_id; ?>" <?php echo (isset($row_profile) && $row_profile->psd_gd_id == $row->gd_id ? "selected": ""); ?>><?php echo $row->gd_name; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="psd_id_card_no" class="form-label required">เลขบัตรประชาชน</label>
                                    <input type="text" class="form-control" name="psd_id_card_no" id="psd_id_card_no" placeholder="เลขบัตรประชาชน" value="<?php echo isset($row_profile) ? $row_profile->psd_id_card_no : ""; ?>" required>
                                </div>
                                <div class="col-md-6 mt-2">

                                    <label for="psd_birthdate" class="form-label required">วันเกิด</label>
                                    <input type="text" class="form-control" name="psd_birthdate" id="psd_birthdate" value="" placeholder="วันเกิด">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="psd_blood_id" class="form-label">หมู่เลือด</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกหมู่เลือด --" name="psd_blood_id" id="psd_blood_id">
                                        <option value="">-- เลือกหมู่เลือด--</option>
                                        <?php
                                            foreach($base_blood_list as $key=>$row){
                                        ?>
                                            <option value="<?php echo $row->blood_id; ?>" <?php echo (isset($row_profile) && $row_profile->psd_blood_id == $row->blood_id ? "selected": ""); ?>><?php echo $row->blood_name; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="psd_reli_id" class="form-label">ศาสนา</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกศาสนา --" name="psd_reli_id" id="psd_reli_id">
                                        <option value="">-- เลือกศาสนา--</option>
                                        <?php
                                            foreach($base_religion_list as $key=>$row){
                                        ?>
                                            <option value="<?php echo $row->reli_id; ?>" <?php echo (isset($row_profile) && $row_profile->psd_reli_id == $row->reli_id ? "selected": ""); ?>><?php echo $row->reli_name; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="psd_race_id" class="form-label">เชื้อชาติ</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกเชื้อชาติ --" name="psd_race_id" id="psd_race_id">
                                        <option value="">-- เลือกเชื้อชาติ--</option>
                                        <?php
                                            foreach($base_race_list as $key=>$row){
                                        ?>
                                            <option value="<?php echo $row->race_id; ?>" <?php echo (isset($row_profile) && $row_profile->psd_race_id == $row->race_id ? "selected": ""); ?>><?php echo $row->race_name; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <label for="psd_nation_id" class="form-label">สัญชาติ</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกสัญชาติ --" name="psd_nation_id" id="psd_nation_id">
                                        <option value="">-- เลือกสัญชาติ--</option>
                                        <?php
                                            foreach($base_nation_list as $key=>$row){
                                        ?>
                                            <option value="<?php echo $row->nation_id; ?>" <?php echo (isset($row_profile) && $row_profile->psd_nation_id == $row->nation_id ? "selected": ""); ?>><?php echo $row->nation_name; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <label for="psd_psst_id" class="form-label required">สถานภาพ</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกสถานภาพ--" name="psd_psst_id" id="psd_psst_id">
                                        <option value="">-- เลือกสถานภาพ--</option>
                                        <?php
                                            foreach($base_person_status_list as $key=>$row){
                                        ?>
                                            <option value="<?php echo $row->psst_id; ?>" <?php echo (isset($row_profile) && $row_profile->psd_psst_id == $row->psst_id ? "selected": ""); ?>><?php echo $row->psst_name; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <label for="psd_email" class="form-label required">E-mail</label>
                                    <input type="email" class="form-control" name="psd_email" id="psd_email" placeholder="E-mail" value="<?php echo isset($row_profile) ? $row_profile->psd_email : ""; ?>" required>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <label for="psd_facebook" class="form-label ">Facebook</label>
                                    <input type="text" class="form-control" name="psd_facebook" id="psd_facebook" placeholder="Facebook" value="<?php echo isset($row_profile) ? $row_profile->psd_facebook : ""; ?>">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="psd_line" class="form-label ">Line ID</label>
                                    <input type="text" class="form-control" name="psd_line" id="psd_line" placeholder="Line ID" value="<?php echo isset($row_profile) ? $row_profile->psd_line : ""; ?>">
                                </div>
                                <div class="col-md-6 mt-2">
                                    
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="psd_cellphone" class="form-label required">เบอร์โทรศัพท์มือถือ</label>
                                    <input type="text" class="form-control" name="psd_cellphone" id="psd_cellphone" placeholder="เบอร์โทรศัพท์มือถือ" required value="<?php echo isset($row_profile) ? $row_profile->psd_cellphone : ""; ?>">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="psd_phone" class="form-label ">เบอร์โทรศัพท์บ้าน</label>
                                    <input type="text" class="form-control" name="psd_phone" id="psd_phone" placeholder="เบอร์โทรศัพท์บ้าน" required value="<?php echo isset($row_profile) ? $row_profile->psd_phone : ""; ?>">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="psd_ex_phone" class="form-label ">เบอร์โทรภายใน</label>
                                    <input type="text" class="form-control" name="psd_ex_phone" id="psd_ex_phone" placeholder="เบอร์โทรภายใน" required value="<?php echo isset($row_profile) ? $row_profile->psd_ex_phone : ""; ?>">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="psd_work_phone" class="form-label ">เบอร์โทรศัพท์ที่ทำงาน</label>
                                    <input type="text" class="form-control" name="psd_work_phone" id="psd_work_phone" placeholder="เบอร์โทรศัพท์ที่ทำงาน" required value="<?php echo isset($row_profile) ? $row_profile->psd_work_phone : ""; ?>">
                                </div>
                                
                                <div class="col-md-6 mt-2">
                                    <label for="psd_picture" class="form-label required">รูปประจำตัว</label>
                                    <input type="file" class="form-control input-bs-file" accept=".png,.jpg" data-url="<?php echo site_url($this->config->item('hr_dir')."getFile?type=".$this->config->item('hr_profile_dir')."profile_picture&image=".($row_profile->psd_picture!=''?$row_profile->psd_picture:"default.png"));?>" 
                                        name="psd_picture" id="psd_picture" onchange="displaySelectedImage(event, 'selected-image')">
                                    <div class="d-flex justify-content-center">
                                        <img id="selected-image" class="" src="<?php echo site_url($this->config->item('hr_dir')."getFile?type=".$this->config->item('hr_profile_dir')."profile_picture&image=".($row_profile->psd_picture!=''?$row_profile->psd_picture:"default.png"));?>" style="width: 300px;" />
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="psd_desc" class="form-label">หมายเหตุ</label>
                                    <textarea class="form-control" name="psd_desc" id="psd_desc" placeholder="หมายเหตุ" rows="4"><?php echo isset($row_profile) ? $row_profile->psd_desc : ""; ?></textarea>
                                </div>
                                <div class="mt-3 mb-3 col-md-12">
                                    <!-- <a type="button" class="btn btn-secondary float-start" href="<?php echo site_url()."/".$controller_dir; ?>">ย้อนกลับ</a> -->
                                    <button type="button" class="btn btn-success float-end" id="button_profile_save_form" onclick="profile_save_form()" title="บันทึก" data-toggle="tooltip" data-placement="top">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>              
</form>

<!-- Modal for person-history-modal -->
<div class="modal fade" id="person-history-modal" tabindex="-1" aria-labelledby="person-history-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="person-history-modalLabel">ประวัติการเปลี่ยนข้อมูลส่วนตัว</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table datatable" id="detailTable_person_history" width="100%">
                    <thead>
                        <tr>
                            <th scope="row" class="text-center">#</th>
                            <th class="text-center">คำนำหน้า</th>
                            <th class="text-center">ชื่อ (ภาษาไทย)</th>
                            <th class="text-center">นามสกุล (ภาษาไทย)</th>
                            <th class="text-center">ชื่อ (ภาษาอังกฤษ)</th>
                            <th class="text-center">นามสกุล (ภาษาอังกฤษ)</th>
                            <th class="text-center">ชื่อเล่น (ภาษาไทย)</th>
                            <th class="text-center">ชื่อเล่น (ภาษาอังกฤษ)</th>
                            <th class="text-center">วันที่เริ่มมีผลข้อมูล</th>
                            <th class="text-center">วันที่สิ้นสุดผลข้อมูล</th>
                            <th class="text-center">ผู้ดำเนินการแก้ไข</th>
                            <th class="text-center">วันที่แก้ไขข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {
    const numberInput = $('#psd_id_card_no');

    // Format the initial value if it exists
    formatInputValue(numberInput);

    show_person_history_modal();

    // Listen for input events to format the value as the user types
    numberInput.on('input', function(e) {
        const cursorPosition = numberInput[0].selectionStart;
        const rawValue = numberInput.val().replace(/\D/g, ''); // Remove any non-digit characters
        const previousFormattedValue = numberInput.val();
        const formattedValue = formatNumber(rawValue);

        numberInput.val(formattedValue);

        adjustCursorPosition(numberInput[0], cursorPosition, previousFormattedValue, formattedValue);
    });

    function formatInputValue(input) {
        const rawValue = input.val().replace(/\D/g, ''); // Remove any non-digit characters
        const formattedValue = formatNumber(rawValue);
        input.val(formattedValue);
    }

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

        setTimeout(function() {
            input.setSelectionRange(newPosition, newPosition);
        }, 0);
    }

    change_prefix_by_gd_id(<?php echo (isset($row_profile) && $row_profile->ps_pf_id ? $row_profile->ps_pf_id : 0); ?>, <?php echo (isset($row_profile) && $row_profile->psd_gd_id ? $row_profile->psd_gd_id: ""); ?>);
});

function show_person_history_modal() {
    // Fetch and populate modal content based on ps_id
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_person_history',
        type: 'GET',
        data: { ps_id: "<?php echo encrypt_id($ps_id); ?>" },
        success: function(data) {
            // Assuming response is an array of objects with properties: dp_id, dp_name_th, and history_detail
            data = JSON.parse(data);
            // console.log(data);

            // Initialize DataTables with the received data
            var columns = [
                { data: null, className: 'text-center', render: function(data, type, row, meta) {
                    return meta.row + 1;
                }},
                { data: 'pf_name', className: 'text-center' },
                { data: 'hips_ps_fname', className: 'text-center' },
                { data: 'hips_ps_lname', className: 'text-center' },
                { data: 'hips_ps_fname_en', className: 'text-center' },
                { data: 'hips_ps_lname_en', className: 'text-center' },
                { data: 'hips_ps_nickname', className: 'text-center' },
                { data: 'hips_ps_nickname_en', className: 'text-center' },
                { data: 'hips_start_date', className: 'text-center' },
                { data: 'hips_end_date', className: 'text-center' },
                { data: 'ps_update_user', className: 'text-center' },
                { data: 'hips_update_date', className: 'text-center' }
            ];

            initializeDataTable('#detailTable_person_history', data, columns);

        },
        error: function() {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}

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

function change_prefix_by_gd_id(pf_id, gd_id){

    if (gd_id) {
        $.ajax({
            url: '<?php echo site_url()."/".$controller_dir; ?>get_hr_base_prefix_data',
            type: 'POST',
            data: { gd_id: gd_id },
            success: function(response) {
                response = JSON.parse(response);
                $("#ps_pf_id").empty();
               

                $.each(response, function(index, row) {
                    var selected = (row.pf_id == pf_id) ? 'selected' : '';
                    $("#ps_pf_id").append('<option value="' + row.pf_id + '" ' + selected + '>' + row.pf_name + '</option>');
                });

                if (response.length > 0) {
                    $("#ps_pf_id").val(pf_id).trigger('change');
                }
            }
        });
    } else {
        $("#ps_pf_id").html('<option value="">-- เลือกคำนำหน้าชื่อ --</option>');
    }
}

function profile_save_form() {
    var form = document.getElementById('profile_resume_form');
    var profile_resume_form = new FormData(form); // Create a FormData object from the form
    var isValid = true;
    var isDuplicate = true;

    // console.log("profile_resume_form", profile_resume_form);
     // List of fields to exclude from validation
     var excludeFields = ["psd_blood_id", "psd_reli_id", "psd_race_id", "psd_nation_id","psd_picture", "psd_desc", "ps_nickname", "ps_nickname_en", 
                         "psd_facebook", "psd_line", "psd_phone","psd_ex_phone", "psd_work_phone"];

    // Validate regular form controls
    $('#profile_resume_form .form-control').each(function() {
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
    $('#profile_resume_form .form-select').each(function() {
        var fieldName = $(this).attr('name');
        var fieldValue = $(this).val();
        if (!excludeFields.includes(fieldName)) {
            if (fieldValue === '' || fieldValue === null) {
                isValid = false;
                $(this).siblings('.select2-container').find('.select2-selection').removeClass('is-valid').addClass('is-invalid');
                $(this).siblings('.invalid-feedback').show();
            } else {
                // If there is a value, show as valid
                $(this).siblings('.select2-container').find('.select2-selection').removeClass('is-invalid').addClass('is-valid');
                $(this).siblings('.invalid-feedback').hide();
            }
        }
    });



    // start if isValid
    if (isValid) {
        $.ajax({
            url: '<?php echo site_url()."/".$controller_dir; ?>profile_resume_update',
            type: 'POST',
            data: profile_resume_form,
            contentType: false, // Required for file uploads
            processData: false, // Required for file uploads
            success: function(data) {
                data = JSON.parse(data);
                // console.log(data.data.status_response)
                if (data.data.status_response == status_response_success) {
                    dialog_success({'header': text_toast_save_success_header, 'body': data.data.message_dialog}, data.data.return_url, false);
                } else if (data.data.status_response == status_response_error) {
                    dialog_error({'header':text_toast_default_error_header, 'body': data.data.message_dialog});
                    $(".ps_fname_div #ps_fname").removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
                    $(".ps_fname_div .invalid-feedback").text(data.data.message_dialog);

                    $(".ps_lname_div #ps_lname").removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
                    $(".ps_lname_div .invalid-feedback").text(data.data.message_dialog);

                    $(".psd_id_card_no_div #psd_id_card_no").removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
                    $(".psd_id_card_no_div .invalid-feedback").text(data.data.message_dialog);
                } 

            },
            error: function(xhr, status, error) {
                dialog_error({'header':text_toast_default_error_header, 'body': text_toast_default_error_body});
            }
        });
    }
    else{
        dialog_error({'header':text_toast_default_error_header, 'body': text_invalid_default});
    }
    // end if isValid
}

flatpickr("#psd_birthdate", {
    dateFormat: 'd/m/Y',
    locale: 'th',
    // defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
    defaultDate: "<?php echo isset($row_profile) ? date('d/m/Y', strtotime($row_profile->psd_birthdate . ' +543 years')) : date('d/m/Y'); ?>",
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

</script>
