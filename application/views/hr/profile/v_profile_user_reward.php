<form method="post" class="needs-validation" id="profile_reward_form" enctype="multipart/form-data" novalidate>      
    <input type="hidden" name="ps_id" id="ps_id" value="<?php echo encrypt_id($ps_id); ?>">       
    <input type="hidden" name="rewd_id" id="rewd_id" value="">    
    <input type="hidden" name="tab_active" id="tab_active" value="7">                   
    <div class="row g-3">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="bx bx-award icon-menu font-20"></i>จัดการข้อมูลรางวัล
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body row">
                            <div class="col-md-12 mb-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="rewd_rwt_id" class="form-label required">ด้านรางวัล</label>
                                        <select class="select2 form-control" id="rewd_rwt_id" name="rewd_rwt_id">
                                            <option value="" selected>-- เลือกด้านรางวัล --</option>
                                            <?php
                                                foreach($base_reward_type_list as $key=>$row){
                                            ?>
                                                <option value="<?php echo $row->rwt_id ; ?>"><?php echo $row->rwt_name . " (" . $row->rwt_name_en . ")"; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="rewd_rwlv_id" class="form-label required">ระดับรางวัล</label>
                                        <select class="select2 form-control" id="rewd_rwlv_id" name="rewd_rwlv_id">
                                            <option value="" selected>-- เลือกระดับรางวัล --</option>
                                            <?php
                                                foreach($base_reward_level_list as $key=>$row){
                                            ?>
                                                <option value="<?php echo $row->rwlv_id ; ?>"><?php echo $row->rwlv_name . " (" . $row->rwlv_name_en . ")"; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="rewd_name_th" class="form-label required">ชื่อรางวัลเชิดชูเกียรติ (ภาษาไทย)</label>
                                <textarea class="form-control" name="rewd_name_th" id="rewd_name_th" placeholder="ชื่อรางวัลเชิดชูเกียรติภาษาไทย"></textarea>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="rewd_name_en" class="form-label required">ชื่อรางวัลเชิดชูเกียรติ (ภาษาอังกฤษ)</label>
                                <textarea class="form-control" name="rewd_name_en" id="rewd_name_en" placeholder="ชื่อชื่อรางวัลเชิดชูเกียรติภาษาอังกฤษ"></textarea>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="rewd_org_th" class="form-label required">หน่วยงานที่มอบรางวัล (ภาษาอังกฤษ)</label>
                                <input type="text" class="form-control" name="rewd_org_th" id="rewd_org_th" placeholder="หน่วยงานที่มอบรางวัลภาษาไทย">
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="rewd_org_en" class="form-label required">หน่วยงานที่มอบรางวัล (ภาษาไทย)</label>
                                <input type="text" class="form-control" name="rewd_org_en" id="rewd_org_en" placeholder="หน่วยงานที่มอบรางวัลภาษาอังกฤษ">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="rewd_year" class="form-label required">ปีพุทธศักราช (พ.ศ.) ที่เริ่มเผยแพร่</label>
                                <input type="number" class="form-control" name="rewd_year" id="rewd_year" value="<?php echo date("Y")+543; ?>">
                            </div>
                            <div class="col-md-6 mt-3">
                              
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="select_reward_date" class="form-label required">ระบุวันที่ได้รับรางวัล</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input class="form-check-input mb-3" type="radio" id="select_reward_date_1" name="select_reward_date" value="1"> ไม่ระบุวันที่ได้รับรางวัล <br>
                                        <input class="form-check-input" type="radio" id="select_reward_date_2" name="select_reward_date" value="2" checked> ระบุวันที่ได้รับรางวัล
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div id="div_reward_date">
                                    <label for="rewd_date" class="form-label required">วันที่ได้รับรางวัล</label>
                                    <input type="text" class="form-control" id="rewd_date" name="rewd_date">
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="inputNumber" class="form-label mb-2">รูปรางวัล (.jpg, .png และ .pdf เท่านั้น)</label>
                                <input class="form-control input-bs-file" type="file" id="rewd_reward_file" name="rewd_reward_file" accept=".png,.jpg,.pdf">
                                <div id="show_rewd_reward_file"></div>
                            </div>
                            <div class="col-md-6  mt-3">
                                <label for="inputNumber" class="form-label mb-2">รูปประกาศนียบัตร (.jpg, .png และ .pdf เท่านั้น)</label>
                                <input class="form-control input-bs-file" type="file" id="rewd_cert_file" name="rewd_cert_file" accept=".png,.jpg,.pdf">
                                <div id="show_rewd_cert_file"></div>
                            </div>
                           
                            <div class="mt-3 mb-3 col-md-12">
                                <!-- <a type="button" class="btn btn-secondary float-start" href="<?php echo site_url()."/".$controller_dir; ?>">ย้อนกลับ</a> -->
                                <button type="button" class="btn btn-success float-end" id="button_profile_reward_save_form" onclick="profile_reward_save_form()" title="คลิกเพื่อบันทึกข้อมูล" data-toggle="tooltip" data-bs-placement="top">บันทึก</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="bi bi-table icon-menu font-20"></i>ตารางข้อมูลรางวัล
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table datatable" id="reward_list" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">ปีเผยแพร่</th>
                                        <th scope="col" class="text-center">ชื่อรางวัล</th>
                                        <th scope="col" class="text-center">หน่วยงานที่มอบรางวัล</th>
                                        <th scope="col" class="text-center">ด้านรางวัล</th>
                                        <th scope="col" class="text-center">ระดับรางวัล</th>
                                        <th scope="col" class="text-center">ไฟล์</th>
                                        <th scope="col" class="text-center">ดำเนินการ</th>
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
    var data_reward_list_table = $('#reward_list').DataTable();
    var tab_active = $('#profile_reward_form #tab_active').val();

     // Function to update DataTable based on select dropdown values
     function updateDataTable() {
        var ps_id = $('#ps_id').val();

        // Make AJAX request to fetch updated data
        $.ajax({
            url: '<?php echo site_url()."/".$controller_dir; ?>get_profile_person_reward_list',
            type: 'GET',
            data: { 
                ps_id: ps_id
            },
            success: function(data) {
                // Clear existing data_reward_list_table data
                data = JSON.parse(data);
                data_reward_list_table.clear().draw();

                $(".summary_person").text(data.length);
                // Add new data to data_reward_list_table
                data.forEach(function(row, index) {
                    var isFile_name = "";
                    var isFile_cerf = "";
                    var buttonFile = "";

                    if (row.rewd_reward_file !== null) {
                        isFile_name = `
                            <a href="#" type="button" class="dropdown-item btn btn-primary" data-file-name="${row.rewd_reward_file}" 
                                data-preview-path="<?php echo site_url($this->config->item('hr_dir').'Getpreview?path='.$this->config->item('hr_upload_profile_reward').'&doc='); ?>${row.rewd_reward_file}" 
                                data-download-path="<?php echo site_url($this->config->item('hr_dir').'Getdoc?path='.$this->config->item('hr_upload_profile_reward').'&doc='); ?>${row.rewd_reward_file}&rename=${row.rewd_reward_file}"
                                data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์รูปรางวัล" data-toggle="tooltip" data-bs-placement="top">
                                รูปรางวัล
                            </a>`;
                    }

                    if (row.rewd_cert_file !== null) {
                        isFile_cerf = `
                            <a href="#" type="button" class="dropdown-item btn btn-primary" data-file-name="${row.rewd_cert_file}" 
                                data-preview-path="<?php echo site_url($this->config->item('hr_dir').'Getpreview?path='.$this->config->item('hr_upload_profile_reward').'&doc='); ?>${row.rewd_cert_file}" 
                                data-download-path="<?php echo site_url($this->config->item('hr_dir').'Getdoc?path='.$this->config->item('hr_upload_profile_reward').'&doc='); ?>${row.rewd_cert_file}&rename=${row.rewd_cert_file}"
                                data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์รูปประกาศนียบัตร" data-toggle="tooltip" data-bs-placement="top">
                                รูปประกาศนียบัตร
                            </a>`;
                    }

                    if (isFile_name != "" || isFile_cerf != "") {
                        buttonFile = `
                            <div class="btn-group" role="group">
                                <button id="btn_reward_${index}" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="คลิกเพื่อดูไฟล์รางวัล" data-toggle="tooltip" data-bs-placement="top">
                                    <i class="bi-file-earmark"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btn_reward_${index}">
                                    ${isFile_name}
                                    ${isFile_cerf}
                                </div>
                            </div>`;  
                    }

                    var button =    `  <div class="text-center option">
                                            <button type="button" class="btn btn-warning" onclick="get_reward_detail_by_id('${row.rewd_id}')" title="คลิกเพื่อแก้ไขข้อมูล" data-toggle="tooltip" data-bs-placement="top">
                                                <i class="bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="modal_confirm_delete(this)" title="คลิกเพื่อลบข้อมูล" data-toggle="tooltip" data-bs-placement="top"
                                                data-id="${row.rewd_id}" 
                                                data-tab="${tab_active}"
                                                data-table="reward" 
                                                data-topic="รางวัล" 
                                                data-index="${(index+1)}" 
                                                data-detail="
                                                    <div>
                                                        <h6>ปีที่เผยแพร่</h6>
                                                        <p>${row.rewd_year}</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>ชื่อรางวัล</h6>
                                                        <p>${replaceQuotes(row.rewd_name_th)} (${replaceQuotes(row.rewd_name_th)})</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>หน่วยงานที่มอบรางวัล</h6>
                                                        <p>${row.rewd_org_th} (${row.rewd_org_th})</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>ด้านรางวัล</h6>
                                                        <p>${row.rwt_name}</p>
                                                    </div>
                                                    <div>
                                                        <h6>ระดับรางวัล</h6>
                                                        <p>${row.rwlv_name}</p>
                                                    </div>">
                                                <i class="bi-trash"></i>
                                            </button>
                                        </div>
                                    `;
                data_reward_list_table.row
                .add([
                        (index+1),
                        row.rewd_year,
                        row.rewd_name_th + " (" +  row.rewd_name_en + ")",
                        row.rewd_org_th + " (" +  row.rewd_org_th + ")",
                        row.rwt_name,
                        row.rwlv_name,
                        buttonFile,
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

function get_reward_detail_by_id(rewd_id) {
    $.ajax({
        url: '<?php echo site_url()."/".$controller_dir; ?>get_reward_detail_by_id/' + rewd_id,
        type: 'POST',
        data: { 
            rewd_id: rewd_id
        },
        success: function(data) {
            data = JSON.parse(data);
            // console.log(data);
            $('#show_rewd_reward_file').html('');
            $('#show_rewd_cert_file').html('');
            if (data.length > 0) {
                var reward = data[0];
                // Set values to HTML elements
                $('#rewd_id').val(reward.rewd_id);
                $('#rewd_rwt_id').val(reward.rewd_rwt_id);
                $('#rewd_rwlv_id').val(reward.rewd_rwlv_id);
                $('#rewd_name_th').text(reward.rewd_name_th);
                $('#rewd_name_en').text(reward.rewd_name_en);
                $('#rewd_org_th').val(reward.rewd_org_th);
                $('#rewd_org_en').val(reward.rewd_org_en);
                $('#rewd_year').val(reward.rewd_year);
                $('#rewd_date').val(reward.rewd_date);

                // Update values of Select2 dropdowns
                $('#rewd_rwt_id').trigger('change'); 
                $('#rewd_rwlv_id').trigger('change'); 


                if(reward.rewd_date = "0000-00-00"){
                     // Check radio buttons based on data
                    $('input[name="select_reward_date"][value="1"]').prop('checked', true); 
                }
                else{
                    $('input[name="select_reward_date"][value="2"]').prop('checked', true); 
                }
               

                var isFile_name = "";
                var isFile_cerf = "";

                if (reward.rewd_reward_file !== null) {
                    isFile_name = `
                        <a href="#" type="button" class="dropdown-item btn btn-primary" data-file-name="${reward.rewd_reward_file}" 
                            data-preview-path="<?php echo site_url($this->config->item('hr_dir').'Getpreview?path='.$this->config->item('hr_upload_profile_reward').'&doc='); ?>${reward.rewd_reward_file}" 
                            data-download-path="<?php echo site_url($this->config->item('hr_dir').'Getdoc?path='.$this->config->item('hr_upload_profile_reward').'&doc='); ?>${reward.rewd_reward_file}&rename=${reward.rewd_reward_file}"
                            data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์รูปรางวัล">
                            ${reward.rewd_reward_file}
                        </a>`;
                    $('#show_rewd_reward_file').html(isFile_name);
                }

                if (reward.rewd_cert_file !== null) {
                    isFile_cerf = `
                        <a href="#" type="button" class="dropdown-item btn btn-primary" data-file-name="${reward.rewd_cert_file}" 
                            data-preview-path="<?php echo site_url($this->config->item('hr_dir').'Getpreview?path='.$this->config->item('hr_upload_profile_reward').'&doc='); ?>${reward.rewd_cert_file}" 
                            data-download-path="<?php echo site_url($this->config->item('hr_dir').'Getdoc?path='.$this->config->item('hr_upload_profile_reward').'&doc='); ?>${reward.rewd_cert_file}&rename=${reward.rewd_cert_file}"
                            data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์รูปประกาศนียบัตร">
                            ${reward.rewd_cert_file}
                        </a>`;
                    $('#show_rewd_cert_file').html(isFile_cerf);
                }

                $('#profile_reward_form #collapseOne').addClass('show');
                $('html, body').animate({scrollTop : 0},0);
            }
        },
        error: function(xhr, status, error) {
            dialog_error({'header':text_toast_default_error_header, 'body': text_toast_default_error_body});
        }
    });
}
// get_reward_detail_by_id

$('input[name="select_reward_date"]').on('change', function() {
    if ($('#select_reward_date_2').is(':checked')) {
        $('#div_reward_date').show();
    } else {
        $('#div_reward_date').hide();
    }
});

function profile_reward_save_form() {
    var form = document.getElementById('profile_reward_form');
    var profile_reward_form = new FormData(form); // Create a FormData object from the form
    var isValid = true;

     // List of fields to exclude from validation
     var excludeFields = ["rewd_date", "rewd_reward_file", "rewd_cert_file"];

    // Validate regular form controls
    $('#profile_reward_form .form-control').each(function() {
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

        if ($('#select_reward_date_2').is(':checked') && fieldName == "rewd_date") {
            if ($(this).val() === '' || $(this).val() === null) {
                isValid = false;
                $(this).removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid').siblings('.invalid-feedback').hide();
            }
        }
    });

    // Validate Select2 elements
    $('#profile_reward_form .form-select').each(function() {
        var fieldName = $(this).attr('name');
        var fieldValue = $(this).val();
       
        if (!excludeFields.includes(fieldName)) {
            if ($(this).val() === '' || $(this).val() === null) {
                $(this).siblings('.select2-container').find('.select2-selection').removeClass('is-valid').addClass('is-invalid');
                $(this).siblings('.invalid-feedback').show();
            } else {
                $(this).siblings('.select2-container').find('.select2-selection').removeClass('is-invalid').addClass('is-valid');
                $(this).siblings('.invalid-feedback').hide();
            }
           
        } else {
            // If there is a value, show as valid
            $(this).siblings('.select2-container').find('.select2-selection').removeClass('is-invalid').addClass('is-valid');
            $(this).siblings('.invalid-feedback').hide();
        }
    });



    // start if isValid
    if (isValid) {
        $.ajax({
            url: '<?php echo site_url()."/".$controller_dir; ?>profile_reward_update',
            type: 'POST',
            data: profile_reward_form,
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


flatpickr("#rewd_date", {
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
            document.getElementById('rewd_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
        } else {
            document.getElementById('rewd_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
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