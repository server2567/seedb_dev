<form method="post" class="needs-validation" id="profile_license_form" enctype="multipart/form-data" novalidate>                       
    <input type="hidden" name="ps_id" id="ps_id" value="<?php echo encrypt_id($ps_id); ?>">       
    <input type="hidden" name="licn_id" id="licn_id" value="">    
    <input type="hidden" name="tab_active" id="tab_active" value="4">       
    <div class="row">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="bi bi-postcard icon-menu font-20"></i>จัดการข้อมูลใบประกอบวิชาชีพ
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="licn_voc_id" class="form-label required">ชื่อวิชาชีพ </label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกวิชาชีพ --" name="licn_voc_id" id="licn_voc_id" required>
                                    <option value="">-- เลือกวิชาชีพ--</option>
                                    <?php
                                        foreach($base_vocation_list as $key=>$row){
                                    ?>
                                        <option value="<?php echo $row->voc_id; ?>"><?php echo $row->voc_name; ?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="licn_code" class="form-label required">เลขใบประกอบวิชาชีพ</label>
                                    <input type="text" id="licn_code" name="licn_code" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <div>
                                        <label for="licn_start_date" class="form-label required">วันที่ออกบัตร</label>
                                        <input type="text" id="licn_start_date" name="licn_start_date" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label for="licn_end_date" class="form-label required">วันหมดอายุ</label>
                                    <input type="text" id="licn_end_date" name="licn_end_date" class="form-control">
                                </div>

                                <div class="col-md-6 mt-1 mb-2">
                                    
                                </div>

                                <div class="col-md-6 mt-1 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check_licn_date" name="check_licn_date">
                                        <label for="check_licn_date" class="form-check-label">ตลอดชีพ</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="inputNumber" class="form-label mb-2">แนบไฟล์เอกสารหลักฐาน (.jpg, .png และ .pdf เท่านั้น)</label>
                                    <input class="form-control input-bs-file" type="file" id="licn_attach_file" name="licn_attach_file" accept=".png,.jpg,.pdf">
                                    <div id="show_file_licn_name_edit"></div>
                                </div>
                                <div class="col-md-6">
                                  
                                </div>
                                <div class="mt-3 mb-3 col-md-12">
                                    <!-- <a type="button" class="btn btn-secondary float-start" href="<?php echo site_url()."/".$controller_dir; ?>">ย้อนกลับ</a> -->
                                    <button type="button" class="btn btn-success float-end" id="button_profile_license_save_form" onclick="profile_license_save_form()" title="คลิกเพื่อบันทึกข้อมูล" data-toggle="tooltip" data-bs-placement="top">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="bi bi-table icon-menu font-20"></i>ตารางข้อมูลใบประกอบวิชาชีพ
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table datatable" id="license_list" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>เลขที่ใบประกอบวิชาชีพ</th>
                                        <th>ชื่อวิชาชีพ</th>
                                        <th>วันที่ออกบัตร</th>
                                        <th>วันที่บัตรหมดอายุ</th>
                                        <th>ดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
    var data_license_list_table = $('#license_list').DataTable();
    var licn_id = $('#licn_id').val();
    var tab_active = $('#profile_license_form #tab_active').val();

     // Function to update DataTable based on select dropdown values
     function updateDataTable() {
        var ps_id = $('#ps_id').val();

        // Make AJAX request to fetch updated data
        $.ajax({
            url: '<?php echo site_url()."/".$controller_dir; ?>get_profile_person_license_list',
            type: 'GET',
            data: { 
                ps_id: ps_id
            },
            success: function(data) {
                // Clear existing data_license_list_table data
                data = JSON.parse(data);
                data_license_list_table.clear().draw();

                $(".summary_person").text(data.length);
                // Add new data to data_license_list_table
                data.forEach(function(row, index) {
                    var isFile = "";
                    if(row.licn_attach_file !== null){
                        isFile = `  <button type="button" class="btn btn-primary" data-file-name="${row.licn_attach_file}" 
                                        data-preview-path="<?php echo site_url($this->config->item('hr_dir').'Getpreview?path='.$this->config->item('hr_upload_profile_license').'&doc='); ?>${row.licn_attach_file}" 
                                        data-download-path="<?php echo site_url($this->config->item('hr_dir').'Getdoc?path='.$this->config->item('hr_upload_profile_license').'&doc='); ?>${row.licn_attach_file}&rename=${row.licn_attach_file}"
                                        data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน" data-toggle="tooltip" data-placement="top">
                                        <i class="bi-file-earmark"></i>
                                    </button>`;
                    }

                    var button =    `  <div class="text-center option">`
                                            + isFile +
                                            `
                                            <button type="button" class="btn btn-warning" onclick="get_license_detail_by_id('${row.licn_id}')" title="คลิกเพื่อแก้ไขข้อมูล" data-toggle="tooltip" data-placement="top">
                                                <i class="bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="modal_confirm_delete(this)" title="คลิกเพื่อลบข้อมูล" data-toggle="tooltip" data-bs-placement="top"
                                            data-id="${row.licn_id}" 
                                                data-tab="${tab_active}"
                                                data-table="license" 
                                                data-topic="ใบประกอบวิชาชีพ" 
                                                data-index="${(index+1)}" 
                                                data-detail="
                                                    <div>
                                                        <h6>ใบประกอบวิชาชีพ</h6>
                                                        <p>${row.licn_code}</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>ชื่อวิชาชีพ</h6>
                                                        <p>${row.voc_name}</p>
                                                    </div>
                                                    <div>
                                                        <h6>วันที่ออกบัตร</h6>
                                                        <p>${row.licn_start_date} ถึง ${row.licn_end_date}</p>
                                                    </div>">
                                                <i class="bi-trash"></i>
                                            </button>
                                        </div>
                                    `;
                data_license_list_table.row
                .add([
                        (index+1),
                        '<div class="text-start">' + row.licn_code + '</div>',
                        '<div class="text-center">' + row.voc_name + '</div>',
                        '<div class="text-center">' + row.licn_start_date + '</div>',
                        '<div class="text-center">' + row.licn_end_date + '</div>',
                        button  
                    ]).draw();
                });
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function(xhr, status, error) {
                dialog_error({'header':text_toast_default_error_header, 'body': text_toast_default_error_body});
            }
        });
    }

    // Initial DataTable update
    updateDataTable();

});

document.getElementById('check_licn_date').addEventListener('change', function() {
    var licnEndDateInput = document.getElementById('licn_end_date');
    if (this.checked) {
        licnEndDateInput.disabled = true;
    } else {
        licnEndDateInput.disabled = false;
    }
});

function get_license_detail_by_id(licn_id) {
    $.ajax({
        url: '<?php echo site_url()."/".$controller_dir; ?>get_license_detail_by_id/' + licn_id,
        type: 'POST',
        data: { 
            licn_id: licn_id 
        },
        success: function(data) {
            data = JSON.parse(data);
            $('#show_file_licn_name_edit').html('');
            if (data.length > 0) {
                var license = data[0];

                $('#licn_id').val(license.licn_id);
                $('#licn_code').val(license.licn_code);
                $('#licn_start_date').val(license.licn_start_date);
                $('#licn_end_date').val(license.licn_end_date);
                $('#licn_voc_id').val(license.licn_voc_id);

                // Update values of Select2 dropdowns
                $('#licn_voc_id').trigger('change'); 

                if(license.licn_end_date == ""){
                    $('#check_licn_date').prop('checked', true);
                    var licnEndDateInput = document.getElementById('licn_end_date');
                    licnEndDateInput.disabled = true;
                    $('#licn_end_date').val("ตลอดชีพ");  
                }

                // Display attachment file link if available
                if (license.licn_attach_file != null) {
                    var file_name = `
                        <a class="btn btn-link" data-file-name="${license.licn_attach_file}" 
                           data-preview-path="<?php echo site_url($this->config->item('hr_dir').'Getpreview?path='.$this->config->item('hr_upload_profile_license').'&doc='); ?>${license.licn_attach_file}" 
                           data-download-path="<?php echo site_url($this->config->item('hr_dir').'Getdoc?path='.$this->config->item('hr_upload_profile_license').'&doc='); ?>${license.licn_attach_file}&rename=${license.licn_attach_file}"
                           data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน">
                           ${license.licn_attach_file}
                        </a>`;
                    $('#show_file_licn_name_edit').html(file_name);
                }

                $('#profile_license_form #collapseOne').addClass('show');
                $('html, body').animate({ scrollTop: 0 }, 0);
            }
        },
        error: function(xhr, status, error) {
            dialog_error({ header: text_toast_default_error_header, body: text_toast_default_error_body });
        }
    });
}
// get_license_detail_by_id


function profile_license_save_form() {
    var form = document.getElementById('profile_license_form');
    var profile_license_form = new FormData(form); // Create a FormData object from the form
    var isValid = true;
    var isDuplicate = true;

     // List of fields to exclude from validation
     var excludeFields = ["licn_attach_file"];

    // Validate regular form controls
    $('#profile_license_form .form-control').each(function() {
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
    $('#profile_license_form .form-select').each(function() {
        if ($(this).val() === '' || $(this).val() === null) {
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
            url: '<?php echo site_url()."/".$controller_dir; ?>profile_license_update',
            type: 'POST',
            data: profile_license_form,
            contentType: false, // Required for file uploads
            processData: false, // Required for file uploads
            success: function(data) {
                data = JSON.parse(data);
                // console.log(data.data.status_response)
                if (data.data.status_response == status_response_success) {
                    dialog_success({'header': text_toast_save_success_header, 'body': data.data.message_dialog}, data.data.return_url, false);
                } else if (data.data.status_response == status_response_error) {
                    dialog_error({'header':text_toast_default_error_header, 'body': data.data.message_dialog});
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

flatpickr("#licn_start_date", {
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
            document.getElementById('licn_start_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
        } else {
            document.getElementById('licn_start_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
        }
    },
    onMonthChange: function(selectedDates, dateStr, instance) {
        convertYearsToThai();
    },
    onYearChange: function(selectedDates, dateStr, instance) {
        convertYearsToThai();
    }
});

flatpickr("#licn_end_date", {
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
            document.getElementById('licn_end_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
        } else {
            document.getElementById('licn_end_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
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