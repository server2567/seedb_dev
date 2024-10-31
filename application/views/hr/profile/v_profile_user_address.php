<form method="post" class="needs-validation" id="profile_address_form" enctype="multipart/form-data" novalidate>       
    <input type="hidden" name="ps_id" id="ps_id" value="<?php echo encrypt_id($ps_id); ?>">      
    <input type="hidden" name="tab_active" id="tab_active" value="2">   
         
    <input type="hidden" id="psd_addcur_selected_province" value="<?php echo isset($row_profile) ? $row_profile->psd_addcur_pv_id : ""; ?>">
    <input type="hidden" id="psd_addcur_selected_amphur" value="<?php echo isset($row_profile) ? $row_profile->psd_addcur_amph_id : ""; ?>">
    <input type="hidden" id="psd_addcur_selected_district" value="<?php echo isset($row_profile) ? $row_profile->psd_addcur_dist_id : ""; ?>">

    <input type="hidden" id="psd_addhome_selected_province" value="<?php echo isset($row_profile) ? $row_profile->psd_addhome_pv_id : ""; ?>">
    <input type="hidden" id="psd_addhome_selected_amphur" value="<?php echo isset($row_profile) ? $row_profile->psd_addhome_amph_id : ""; ?>">
    <input type="hidden" id="psd_addhome_selected_district" value="<?php echo isset($row_profile) ? $row_profile->psd_addhome_dist_id : ""; ?>">

    <div class="row">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accord_addcur">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_addcur" aria-expanded="false" aria-controls="collapse_addcur">
                            <i class="ri-map-pin-line icon-menu font-20"></i>จัดการข้อมูลที่อยู่ตามทะเบียนบ้าน
                        </button>
                    </h2>
                    <div id="collapse_addcur" class="accordion-collapse collapse show" aria-labelledby="accord_addcur" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="psd_addcur_no" class="form-label required">ที่อยู่</label>
                                    <textarea class="form-control" name="psd_addcur_no" id="psd_addcur_no" placeholder="กรอกที่อยู่" rows="4"><?php echo isset($row_profile) ? $row_profile->psd_addcur_no : ""; ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="psd_addcur_pv_id" class="form-label required">จังหวัด</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกจังหวัด --" name="psd_addcur_pv_id" id="psd_addcur_pv_id">
                                        <option value="">-- จังหวัด--</option>
                                        <?php
                                            foreach($base_province_list as $key=>$row){
                                        ?>
                                            <option value="<?php echo $row->pv_id; ?>" <?php echo (isset($row_profile) && $row_profile->psd_addcur_pv_id == $row->pv_id ? "selected": ""); ?>><?php echo $row->pv_name; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="psd_addcur_amph_id" class="form-label required">อำเภอ</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกอำเภอ --" name="psd_addcur_amph_id" id="psd_addcur_amph_id">
                                        <option value="">-- เลือกอำเภอ--</option>
                                       
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="psd_addcur_dist_id" class="form-label required">ตำบล</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกตำบล --" name="psd_addcur_dist_id" id="psd_addcur_dist_id">
                                        <option value="">-- เลือกตำบล--</option>
                                        
                                    </select>
                                </div>
                               
                                <div class="col-md-6 mt-3">
                                    <label for="psd_addcur_zipcode" class="form-label required">รหัสไปรษณีย์</label>
                                    <input type="text" class="form-control" id="psd_addcur_zipcode" name="psd_addcur_zipcode" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="accord_addhome">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_addhome" aria-expanded="false" aria-controls="collapse_addhome">
                            <i class="ri-map-pin-line icon-menu font-20"></i>จัดการข้อมูลที่อยู่ปัจจุบัน
                        </button>
                    </h2>
                    <div id="collapse_addhome" class="accordion-collapse collapse show" aria-labelledby="accord_addhome" data-bs-parent="#accord_addhome">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="psd_addhome_no" class="form-label required">ที่อยู่</label>
                                    <textarea class="form-control" name="psd_addhome_no" id="psd_addhome_no" placeholder="กรอกที่อยู่" rows="4"><?php echo isset($row_profile) ? $row_profile->psd_addhome_no : ""; ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="psd_addhome_pv_id" class="form-label required">จังหวัด</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกจังหวัด --" name="psd_addhome_pv_id" id="psd_addhome_pv_id">
                                        <option value="">-- จังหวัด--</option>
                                        <?php
                                            foreach($base_province_list as $key=>$row){
                                        ?>
                                            <option value="<?php echo $row->pv_id; ?>" <?php echo (isset($row_profile) && $row_profile->psd_addhome_pv_id == $row->pv_id ? "selected": ""); ?>><?php echo $row->pv_name; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="psd_addhome_amph_id" class="form-label required">อำเภอ</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกอำเภอ --" name="psd_addhome_amph_id" id="psd_addhome_amph_id">
                                        <option value="">-- เลือกอำเภอ--</option>
                                       
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="psd_addhome_dist_id" class="form-label required">ตำบล</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกตำบล --" name="psd_addhome_dist_id" id="psd_addhome_dist_id">
                                        <option value="">-- เลือกตำบล--</option>
                                        
                                    </select>
                                </div>
                               
                                <div class="col-md-6 mt-3">
                                    <label for="psd_addhome_zipcode" class="form-label required">รหัสไปรษณีย์</label>
                                    <input type="text" class="form-control" id="psd_addhome_zipcode" name="psd_addhome_zipcode" value="">
                                </div>

                                <div class="mt-3 mb-3 col-md-12">
                                    <!-- <a type="button" class="btn btn-secondary float-start" href="<?php echo site_url()."/".$controller_dir; ?>">ย้อนกลับ</a> -->
                                    <button type="button" class="btn btn-success float-end" id="button_profile_address_save_form" onclick="profile_address_save_form()" title="คลิกเพื่อบันทึกข้อมูล" data-toggle="tooltip" data-placement="top">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function profile_address_save_form() {
    var form = document.getElementById('profile_address_form');
    var profile_address_form = new FormData(form); // Create a FormData object from the form
    var isValid = true;

    // Validate regular form controls
    $('#profile_address_form .form-control').each(function() {
        if ($(this).val() === '' || $(this).val() === null) {
            isValid = false;
            $(this).removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid').siblings('.invalid-feedback').hide();
        }
    });

    // Validate Select2 elements
    $('#profile_address_form .form-select').each(function() {
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
            url: '<?php echo site_url()."/".$controller_dir; ?>profile_address_update',
            type: 'POST',
            data: profile_address_form,
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

// Function to update Amphur
function updateAmphur(pv_id, amphurSelectId, districtSelectId, selectedAmphurId) {
    if (pv_id) {
        $.ajax({
            url: '<?php echo site_url()."/".$controller_dir; ?>get_amph_by_pv_id',
            type: 'POST',
            data: { pv_id: pv_id },
            success: function(response) {
                response = JSON.parse(response);
                $(amphurSelectId).empty().append('<option value="">-- เลือกอำเภอ --</option>');
                $(districtSelectId).empty().append('<option value="">-- เลือกตำบล --</option>');

                $.each(response, function(index, amphur) {
                    var selected = (amphur.amph_id == selectedAmphurId) ? 'selected' : '';
                    $(amphurSelectId).append('<option value="' + amphur.amph_id + '" ' + selected + '>' + amphur.amph_name + '</option>');
                });

                if (response.length > 0) {
                    $(amphurSelectId).val(selectedAmphurId).trigger('change');
                }
            }
        });
    } else {
        $(amphurSelectId).html('<option value="">-- เลือกอำเภอ --</option>');
        $(districtSelectId).html('<option value="">-- เลือกตำบล --</option>');
    }
}

// Function to update District
function updateDistrict(amph_id, districtSelectId, selectedDistrictId) {
    if (amph_id) {
        $.ajax({
            url: '<?php echo site_url()."/".$controller_dir; ?>get_dist_by_amph_id',
            type: 'POST',
            data: { amph_id: amph_id },
            success: function(response) {
                response = JSON.parse(response);
                $(districtSelectId).empty().append('<option value="">-- เลือกตำบล --</option>');

                $.each(response, function(index, district) {
                    var selected = (district.dist_id == selectedDistrictId) ? 'selected' : '';
                    $(districtSelectId).append('<option value="' + district.dist_id + '" ' + selected + '>' + district.dist_name + '</option>');
                });

                if (response.length > 0) {
                    $(districtSelectId).val(selectedDistrictId).trigger('change');
                }
            }
        });
    } else {
        $(districtSelectId).html('<option value="">-- เลือกตำบล --</option>');
    }
}

 // Function to update Postal Code based on District selection
 function updatePostalCode(dist_id, zipcodeInputId) {
    if (dist_id) {
        $.ajax({
            url: '<?php echo site_url()."/".$controller_dir; ?>get_postal_code_by_dist_id',
            type: 'POST',
            data: { dist_id: dist_id },
            success: function(response) {
                response = JSON.parse(response);  
                if (response && response.dist_pos_code) {
                    $(zipcodeInputId).val(response.dist_pos_code);
                } else {
                    $(zipcodeInputId).val('');
                }
            }
        });
    } else {
        $(zipcodeInputId).val('');
    }
}

$(document).ready(function() {

    // Initial loading of selected provinces when page loads
    $('#psd_addcur_pv_id').val($('#psd_addcur_selected_province').val()).trigger('change');
    $('#psd_addhome_pv_id').val($('#psd_addhome_selected_province').val()).trigger('change');

    // When selecting a province (First set)
    $('#psd_addcur_pv_id').change(function() {
        var pv_id = $(this).val();
        var selectedAmphurId = $('#psd_addcur_selected_amphur').val();
        updateAmphur(pv_id, '#psd_addcur_amph_id', '#psd_addcur_dist_id', selectedAmphurId);
    });

    // When selecting an amphur (First set)
    $('#psd_addcur_amph_id').change(function() {
        var amph_id = $(this).val();
        var selectedDistrictId = $('#psd_addcur_selected_district').val();
        updateDistrict(amph_id, '#psd_addcur_dist_id', selectedDistrictId);
    });

    // When selecting an dist (First set)
    $('#psd_addcur_dist_id').change(function() {
        var dist_id = $(this).val();
        updatePostalCode(dist_id, '#psd_addcur_zipcode');
    });

    // When selecting a province (Second set)
    $('#psd_addhome_pv_id').change(function() {
        var pv_id = $(this).val();
        var selectedAmphurId = $('#psd_addhome_selected_amphur').val();
        updateAmphur(pv_id, '#psd_addhome_amph_id', '#psd_addhome_dist_id', selectedAmphurId);
    });

    // When selecting an amphur (Second set)
    $('#psd_addhome_amph_id').change(function() {
        var amph_id = $(this).val();
        var selectedDistrictId = $('#psd_addhome_selected_district').val();
        // updateDistrict(amph_id, '#psd_addhome_dist_id', selectedDistrictId);
        updateDistrict(amph_id, '#psd_addhome_dist_id', selectedDistrictId, '#psd_addhome_zipcode');
    });

     // When selecting an dist (Second set)
     $('#psd_addhome_dist_id').change(function() {
        var dist_id = $(this).val();
        updatePostalCode(dist_id, '#psd_addhome_zipcode');
    });
});


    // Initial loading of selected provinces when page loads
    $('#psd_addcur_pv_id').val($('#psd_addcur_selected_province').val()).trigger('change');
    $('#psd_addhome_pv_id').val($('#psd_addhome_selected_province').val()).trigger('change');

    // When selecting a province (First set)
    $('#psd_addcur_pv_id').change(function() {
        var pv_id = $(this).val();
        var selectedAmphurId = $('#psd_addcur_selected_amphur').val();
        updateAmphur(pv_id, '#psd_addcur_amph_id', '#psd_addcur_dist_id', selectedAmphurId);
    });

    // When selecting an amphur (First set)
    $('#psd_addcur_amph_id').change(function() {
        var amph_id = $(this).val();
        var selectedDistrictId = $('#psd_addcur_selected_district').val();
        updateDistrict(amph_id, '#psd_addcur_dist_id', selectedDistrictId);
    });

    // When selecting an dist (First set)
    $('#psd_addcur_dist_id').change(function() {
        var dist_id = $(this).val();
        updatePostalCode(dist_id, '#psd_addcur_zipcode');
    });

    // When selecting a province (Second set)
    $('#psd_addhome_pv_id').change(function() {
        var pv_id = $(this).val();
        var selectedAmphurId = $('#psd_addhome_selected_amphur').val();
        updateAmphur(pv_id, '#psd_addhome_amph_id', '#psd_addhome_dist_id', selectedAmphurId);
    });

    // When selecting an amphur (Second set)
    $('#psd_addhome_amph_id').change(function() {
        var amph_id = $(this).val();
        var selectedDistrictId = $('#psd_addhome_selected_district').val();
        updateDistrict(amph_id, '#psd_addhome_dist_id', selectedDistrictId);
    });

    // When selecting an dist (Second set)
    $('#psd_addhome_dist_id').change(function() {
        var dist_id = $(this).val();
        updatePostalCode(dist_id, '#psd_addhome_zipcode');
    });



</script>