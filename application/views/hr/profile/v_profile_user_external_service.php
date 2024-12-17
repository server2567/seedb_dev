<form method="post" class="needs-validation" id="profile_external_service_form" enctype="multipart/form-data" novalidate>      
    <input type="hidden" name="ps_id" id="ps_id" value="<?php echo encrypt_id($ps_id); ?>">       
    <input type="hidden" name="pexs_id" id="pexs_id" value="">    
    <input type="hidden" name="tab_active" id="tab_active" value="8">                   
    <div class="row g-3">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="bi bi-box-arrow-up-left icon-menu font-20"></i>จัดการข้อมูลบริการหน่วยงานภายนอก
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body row">

                            <div class="col-md-12 mb-2">
                                <label for="pexs_name_th" class="form-label required">เรื่องบริการหน่วยงานภายนอก</label>
                                <textarea class="form-control" name="pexs_name_th" id="pexs_name_th" placeholder="เรื่องบริการหน่วยงานภายนอก"></textarea>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="pexs_rwt_id" class="form-label required">วันที่</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="pexs_date" name="pexs_date">
                                            <span class="input-group-text"><input type="checkbox" class="form-check-input" id="check_pexs_date" name="check_pexs_date">ไม่ระบุ</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pexs_exts_id" class="form-label required">ประเภทบริการหน่วยงานภายนอก</label>
                                        <select class="select2 form-control" id="pexs_exts_id" name="pexs_exts_id">
                                            <option value="" selected>-- เลือกประเภทบริการหน่วยงานภายนอก --</option>
                                            <?php
                                                foreach($base_external_service_list as $key=>$row){
                                            ?>
                                                <option value="<?php echo $row->exts_id ; ?>"><?php echo $row->exts_name_th . ($row->exts_name_en == "" || $row->exts_name_en == "-" ? "" : " (" . $row->exts_name_en . ")"); ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3 mb-2">
                                <div class="row">
                                    <div class="col-md-9">
                                        <label for="pexs_place_id" class="form-label required">สถานที่/หน่วยงาน</label>
                                        <select class="select2 form-control" id="pexs_place_id" name="pexs_place_id" placeholder="สถานที่/หน่วยงาน">

                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="button_add_place" class="form-label"></label>
                                        <div class="d-flex align-items-center justify-content-center mx-auto" style="margin-top: 12px;">
                                            <button type="button" class="btn btn-outline-primary" id="button_add_place" title="คลิกเพื่อบันทึกเพิ่มข้อมูลสถานที่/หน่วยงาน" data-bs-toggle="modal" data-bs-target="#addPlaceModal">
                                                เพิ่มข้อมูลสถานที่/หน่วยงาน
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-4">
                                <label for="inputNumber" class="form-label mb-2">แนบไฟล์เอกสารหลักฐาน (.jpg, .png และ .pdf เท่านั้น)</label>
                                <input class="form-control input-bs-file" type="file" id="pexs_attach_file" name="pexs_attach_file" accept=".png,.jpg,.pdf">
                                <div id="show_file_name_pexs"></div>
                            </div>
                            <div class="col-md-6 mt-4">
                                
                            </div>

                            <div class="mt-5 mb-3 col-md-12">
                                <!-- <a type="button" class="btn btn-secondary float-start" href="<?php echo site_url()."/".$controller_dir; ?>">ย้อนกลับ</a> -->
                                <button type="button" class="btn btn-success float-end" id="button_profile_external_service_save_form" onclick="profile_external_service_save_form()" title="คลิกเพื่อบันทึกข้อมูล" data-toggle="tooltip" data-bs-placement="top">บันทึก</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="bi bi-table icon-menu font-20"></i>ตารางข้อมูลบริการหน่วยงานภายนอก
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table datatable" id="external_service_list" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">เรื่อง</th>
                                        <th scope="col" class="text-center">ประเภท</th>
                                        <th scope="col" class="text-center">วันที่</th>
                                        <th scope="col" class="text-center">สถานที่</th>
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

<!-- Modal Structure -->
<div class="modal fade" id="addPlaceModal" tabindex="-1" aria-labelledby="addPlaceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPlaceModalLabel">เพิ่มข้อมูลสถานที่/หน่วยงาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" novalidate>
                    <div class="col-6">
                        <label for="place_name" class="form-label required">ชื่อสถานที่/หน่วยงาน (ภาษาไทย)</label>
                        <input type="text" class="form-control" name="place[]" id="place_name" placeholder="ชื่อสถานที่/หน่วยงานภาษาไทย" value="" required>
                        <div class="d-flex justify-content-end">
                            <label id="place_msg" style="color:red; font-size:small;"></label>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="place_abbr" class="form-label">ชื่อย่อสถานที่/หน่วยงาน (ภาษาไทย)</label>
                        <input type="text" class="form-control" name="place[]" id="place_abbr" placeholder="ชื่อย่อสถานที่/หน่วยงานภาษาไทย" value="">
                    </div>
                    <div class="col-6">
                        <label for="place_name_en" class="form-label required">ชื่อสถานที่/หน่วยงาน (ภาษาอังกฤษ)</label>
                        <input type="text" class="form-control" name="place[]" id="place_name_en" placeholder="ชื่อสถานที่/หน่วยงานภาษาอังกฤษ" value="" required>
                    </div>
                    <div class="col-6">
                        <label for="place_abbr_en" class="form-label">ชื่อย่อสถานที่/หน่วยงาน (ภาษาอังกฤษ)</label>
                        <input type="text" class="form-control" name="place[]" id="place_abbr_en" placeholder="ชื่อย่อสถานที่/หน่วยงานภาษาอังกฤษ" value="">
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-3">
                                <label for="StDesc" class="form-label">สถานะการใช้งาน</label>
                            </div>
                            <div class="col-9">
                                <ul style="list-style-type: none;">
                                    <li>
                                        <input type="checkbox" id="place_active" class="form-check-input m-1" checked disabled>
                                        <label for="gridCheck1" class="form-check-label">ใช้งาน</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="คลิกปิดหน้าต่าง" data-toggle="tooltip" data-placement="top">ปิด</button>
                        <button type="button" onclick="add_place_modal()" class="btn btn-success float-end" title="คลิกเพื่อบันทึกข้อมูล" data-toggle="tooltip" data-placement="top">บันทึก</button>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary">บันทึกข้อมูล</button>
            </div> -->
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
    var data_external_service_list_table = $('#external_service_list').DataTable();
    var tab_active = $('#profile_external_service_form #tab_active').val();

     // Function to update DataTable based on select dropdown values
     function updateDataTable() {
        var ps_id = $('#ps_id').val();

        // Make AJAX request to fetch updated data
        $.ajax({
            url: '<?php echo site_url()."/".$controller_dir; ?>get_profile_person_external_service_list',
            type: 'GET',
            data: { 
                ps_id: ps_id
            },
            success: function(data) {
                // Clear existing data_external_service_list_table data
                data = JSON.parse(data);
                data_external_service_list_table.clear().draw();

                $(".summary_person").text(data.length);
                // Add new data to data_external_service_list_table
                data.forEach(function(row, index) {
                    var isFile = "";

                    if(row.pexs_attach_file != "" && row.pexs_attach_file != null) {
                        isFile = `<button type="button" class="btn btn-primary" data-file-name="${row.pexs_attach_file}" 
                                        data-preview-path="<?php echo site_url($this->config->item('hr_dir').'Getpreview?path='.$this->config->item('hr_upload_profile_external_service').'&doc='); ?>${row.pexs_attach_file}" 
                                        data-download-path="<?php echo site_url($this->config->item('hr_dir').'Getdoc?path='.$this->config->item('hr_upload_profile_external_service').'&doc='); ?>${row.pexs_attach_file}&rename=${row.pexs_attach_file}"
                                        data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน" data-toggle="tooltip" data-bs-placement="top">
                                        <i class="bi-file-earmark"></i>
                                    </button>`;
                    }

                    var button = `
                        <div class="text-center option">
                            ${isFile}
                            <button type="button" class="btn btn-warning" onclick="get_external_service_detail_by_id('${row.pexs_id}')" title="คลิกเพื่อแก้ไขข้อมูล" data-toggle="tooltip" data-bs-placement="top">
                                <i class="bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger" onclick="modal_confirm_delete(this)" title="คลิกเพื่อลบข้อมูล" data-toggle="tooltip" data-bs-placement="top"
                                data-id="${row.pexs_id}" 
                                data-tab="${tab_active}"
                                data-table="external_service" 
                                data-topic="บริการหน่วยงานภายนอก" 
                                data-index="${index + 1}" 
                                data-detail="<div>
                                                <h6>เรื่อง</h6>
                                                <p>${replaceQuotes(row.pexs_name_th)}</p>
                                            </div>
                                            <div class='pt-2'>
                                                <h6>ประเภท</h6>
                                                <p>${replaceQuotes(row.exts_name_th)}</p>
                                            </div>
                                            <div class='pt-2'>
                                                <h6>วันที่</h6>
                                                <p>${row.pexs_date}</p>
                                            </div>
                                            <div>
                                                <h6>สถานที่/หน่วยงาน</h6>
                                                <p>${replaceQuotes(row.place_name)}</p>
                                            </div>"
                            >
                                <i class="bi-trash"></i>
                            </button>
                        </div>
                    `;
                data_external_service_list_table.row
                .add([
                        (index+1),
                        row.pexs_name_th,
                        row.exts_name_th,
                        row.pexs_date,
                        row.place_name,
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

    loadPlaceOptions();

});

document.getElementById('check_pexs_date').addEventListener('change', function () {
    const pexsDateInput = document.getElementById('pexs_date');
    if (this.checked) {
        pexsDateInput.disabled = true; // Disable the input field
        pexsDateInput.value = "";     // Clear the text
    } else {
        pexsDateInput.disabled = false; // Enable the input field

        // Get the current date
        const now = new Date();

        // Format the date in Thai format (day/month/year + 543)
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = now.getFullYear() + 543;

        // Set the formatted date
        pexsDateInput.value = `${day}/${month}/${year}`;
    }
});


function add_place_modal(){
    var formData = {};

    $('[name^="place"]').each(function() {
        var checkbox = document.getElementById('place_active');
        if (this.id != 'place_active') {
            formData[this.id] = this.value;
        } else {
            if (checkbox.checked) {
                formData[this.id] = '1'
            } else {
                formData[this.id] = '0'
            }
        }
    });
    delete formData.place_id;
    if (!formData.place_name || !formData.place_name_en) {
        !formData.place_name ? $('#place_name').get(0).focus() : '';
        !formData.place_name_en ? $('#place_name_en').get(0).focus() : '';
        dialog_error({
            'header': 'ไม่สามารถเพิ่มข้อมูลได้',
            'body': 'กรุณากรอกข้อมูลสถานที่/หน่วยงานให้ครบถ้วน'
        });
        return false;
    }
    $.ajax({
        url: '<?php echo site_url() . '/' . $this->config->item('hr_dir')."base/" . 'Education_place/checkValue'; ?>',
        method: 'POST',
        data: {
            place_name: formData['place_name'],
        }
    }).done(function(returnedData) {
        var data = JSON.parse(returnedData)
        var inputElement = document.getElementById('place_msg');
        if (data.status_response == 1) {
            dialog_error({
                'header': 'ไม่สามารถเพิ่มข้อมูลได้',
                'body': 'สถานที่/หน่วยงานนี้ถูกใช้งานแล้ว'
            });
            $('#place_name').get(0).focus()
            inputElement.innerHTML = "สถานที่/หน่วยงานนี้ถูกใช้งานแล้ว";
            return false;
        } else {
            inputElement.innerHTML = "";
            $.ajax({
                url: '<?php echo site_url() . '/' . $this->config->item('hr_dir')."base/" . 'Education_place/education_place_insert'; ?>',
                method: 'POST',
                data: formData
            }).done(function(returnedData) {
                dialog_success({
                    'header': 'ดำเนินการเสร็จสิ้น',
                    'body': 'เพิ่มข้อมูลสถานที่/หน่วยงานเสร็จสิ้น'
                });
                $('#addPlaceModal').modal('hide');
                loadPlaceOptions();
            })
        }
    })
}

function get_external_service_detail_by_id(pexs_id) {
    $.ajax({
        url: '<?php echo site_url()."/".$controller_dir; ?>get_external_service_detail_by_id/' + pexs_id,
        type: 'POST',
        data: { pexs_id: pexs_id },
        success: function(data) {
            data = JSON.parse(data);
            if (data.length > 0) {
                var service = data[0];

                // Set values to HTML elements
                $('#pexs_id').val(service.pexs_id);
                $('#pexs_exts_id').val(service.pexs_exts_id).trigger('change');
                $('#pexs_name_th').val(service.pexs_name_th);

                if(service.pexs_date == "ไม่ระบุ"){
                    const checkPexsDate = document.getElementById('check_pexs_date');
                    const pexsDateInput = document.getElementById('pexs_date');

                    // Set checkbox as checked
                    checkPexsDate.checked = true;

                    // Disable the input field
                    pexsDateInput.disabled = true;

                    // Clear the input field value
                    pexsDateInput.value = "";
                }
                else{
                    $('#pexs_date').val(service.pexs_date);
                }
                
                $('#pexs_place_id').val(service.pexs_place_id).trigger('change');

                // Display attached file if available
                if (service.pexs_attach_file) {
                    $('#show_file_name_pexs').html(`
                        <a class="btn btn-link" data-file-name="${service.pexs_attach_file}" 
                            href="<?php echo site_url($this->config->item('hr_dir').'Getdoc?path='.$this->config->item('hr_upload_profile_external_service').'&doc='); ?>${service.pexs_attach_file}&rename=${service.pexs_attach_file}" 
                        data-preview-path="<?php echo site_url($this->config->item('hr_dir').'Getpreview?path='.$this->config->item('hr_upload_profile_external_service').'&doc='); ?>${service.pexs_attach_file}"
                        data-download-path="<?php echo site_url($this->config->item('hr_dir').'Getdoc?path='.$this->config->item('hr_upload_profile_external_service').'&doc='); ?>${service.pexs_attach_file}" 
                        data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน">
                            ${service.pexs_attach_file}
                        </a>`);
                }

                // Expand the accordion section
                $('#profile_external_service_form #collapseOne').addClass('show');
                $('html, body').animate({scrollTop: 0}, 0);
            }
        },
        error: function(xhr, status, error) {
            dialog_error({'header': text_toast_default_error_header, 'body': text_toast_default_error_body});
        }
    });
}

 // Function to populate the select box
 function loadPlaceOptions() {
    $.ajax({
        url: '<?php echo site_url()."/".$controller_dir; ?>get_hr_base_place_data',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var $select = $('#pexs_place_id');
            $select.empty(); // Clear existing options
            $select.append('<option value="" selected>-- เลือกประเภทบริการหน่วยงานภายนอก --</option>');
            
            $.each(data, function(key, value) {
                $select.append('<option value="' + value.place_id + '">' + value.place_name + '</option>');
            });
        },
        error: function(xhr, status, error) {
            dialog_error({'header':text_toast_default_error_header, 'body': text_toast_default_error_body});
        }
    });
}

function profile_external_service_save_form() {
    var form = document.getElementById('profile_external_service_form');
    var profile_external_service_form = new FormData(form); // Create a FormData object from the form
    var isValid = true;

     // List of fields to exclude from validation
     var excludeFields = ["pexs_date", "pexs_attach_file"];

    // Validate regular form controls
    $('#profile_external_service_form .form-control').each(function() {
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
    $('#profile_external_service_form .form-select').each(function() {
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
            url: '<?php echo site_url()."/".$controller_dir; ?>profile_external_service_update',
            type: 'POST',
            data: profile_external_service_form,
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


flatpickr("#pexs_date", {
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
            document.getElementById('pexs_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
        } else {
            document.getElementById('pexs_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
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