<style>
    .card-header {
        background-color: #cfe2ff;
        border-color: #cfe2ff;
    }

    .card-tabs ul.nav-tabs {
        border-top-right-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
        border-top-left-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
    }

    .card-tabs li button.nav-link,
    .card-tabs .nav-item-left {
        padding: 14px 1.25rem;
    }

    .card-tabs .nav-tabs {
        font-weight: bold;
    }

    .card-tabs .card-body {
        padding: 0 1.25rem var(--bs-card-spacer-y) 1.25rem;
    }

    .card form button.accordion-button:not(.collapsed) {
        color: var(--bs-primary);
    }

    .card {
        margin-bottom: 15px;
    }

    .badge-number {
        position: absolute;
        top: 0;
        right: 0;
        transform: translate(0%, -50%);
    }

    .nav-pills .nav-link {
        /* box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1); */
        border: 1px dashed #607D8B;
        color: #012970;
        margin: 8px;
    }


    .card-dashed {
        box-shadow: none;
        border: 1px dashed #607D8B;
        color: #012970;
    }

    .card-solid {
        box-shadow: none;
    }


    .card-icon {
        font-size: 32px;
        line-height: 0;
        width: 70px;
        /* height: 70px; */
        flex-shrink: 0;
        flex-grow: 0;
    }

    .card-solid.border-primary-subtle {
        border: 2px dashed;
    }

    .small {
        font-size: 14px;
    }

    #profile_picture {
        margin-top: -100px;
        border-radius: 5px;
        /* width: 250px !important;  */
        max-width: 300px;
        height: 200px !important;
        /* max-height: 200px; */
        /* box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1); */
    }

    .dataTable th {
        color: var(--tp-font-color);
        text-align: center !important;
    }

    .modal {
        color: #000;
    }

    .list-group-item {
        font-weight: bold;
        color: #212529 !important;
    }

    .list-group-item.active {
        z-index: 2;
        background-color: #fff !important;
        border: 3px solid #86b7fe;
    }

    .rounded-pill {
        padding: 12px;
    }
</style>

<script>
    var checkType1 = 'False'
    var checkType2 = 'False'
    var isChanged = true;
    var dataArray = []
    $(document).ready(function() {
        $(".list-group-item").click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 0);
        });

        var showDiv = $('#div_add_department').data('show');

        // Hide card_add_department initially
        $("#card_add_department").hide();

        if (showDiv > 0) {
            $('#div_add_department').removeClass('d-none');
        } else {
            $('#div_add_department').addClass('d-none');
        }

        $('[data-toggle="tooltip"]').tooltip();
        $('.multi1').change(function() {
            checkType1 = 'True';
        });
        $('.multi2').change(function() {
            checkType2 = 'True';
        });
    });

    function add_department() {
        var pos_ps_id = $('#pos_ps_id').val();

        $("#div_add_department").fadeOut(300, function() {
            $(this).addClass('d-none');
        });
        $("#card_add_department").fadeIn(300);

        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_all_ums_department',
            type: 'POST',
            data: {
                ps_id: pos_ps_id
            },
            success: function(data) {
                data = JSON.parse(data);

                // Clear existing options
                $('#pos_dp_id').empty();

                // Add default option
                $('#pos_dp_id').append($('<option>', {
                    value: '',
                    text: '-- เลือกหน่วยงาน--'
                }));

                // Add options from data
                $.each(data, function(index, item) {
                    $('#pos_dp_id').append($('<option>', {
                        value: item.dp_id,
                        text: item.dp_name_th
                    }));
                });


            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });

    }

    function show_position_history_modal(ps_id) {
        if (!ps_id) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
            return;
        }

        // Clear any existing tabs and content
        $('#position_dp_tab').empty();
        $('#position_dp_tabContent').empty();

        // Fetch and populate modal content based on ps_id
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_position_history',
            type: 'GET',
            data: {
                ps_id: ps_id
            },
            success: function(data) {
                // Assuming response is an array of objects with properties: dp_id, dp_name_th, and history_detail
                data = JSON.parse(data);
                // console.log(data);
                var mainTabsHtml = '';
                var subTabsHtml = '';

                $.each(data, function(index, tab) {
                    var tabId = tab.dp_id;
                    // console.log(index);

                    mainTabsHtml += `
                        <li class="nav-item" role="presentation">
                            <a class="nav-link ${index === 0 ? 'active' : ''}" id="${tabId}-tab" data-bs-toggle="tab" href="#${tabId}" role="tab" aria-controls="${tabId}" aria-selected="${index === 0 ? 'true' : 'false'}">${tab.dp_name_th}</a>
                        </li>
                    `;

                    subTabsHtml += `
                        <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                            <div class="tab-content mb-5 mt-3" id="detailsG3-${tabId}-Content">
                                <div class="tab-pane fade show active" id="${tabId}-all" role="tabpanel" aria-labelledby="${tabId}-all-tab">
                                    <table class="table datatable" id="detailTable_position_history_${tabId}-all" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="row" class="text-center">#</th>
                                                <th class="text-center"  width='30%'>ข้อมูลที่ทำการแก้ไข</th>
                                                <th class="text-center">วันที่เริ่่มมีผลข้อมูล</th>
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
                    `;
                });
                $('#position_dp_tab').html(mainTabsHtml);
                $('#position_dp_tabContent').html(subTabsHtml);

                // Initialize DataTables for each tab and subtab
                $.each(data, function(index, tab) {
                    var excludeVars = ['hipos_id', 'hipos_pos_hire_id', 'hipos_pos_retire_id', 'hipos_start_date', 'hipos_end_date', 'ps_update_user', 'hipos_update_date'];
                    var tabId = tab.dp_id;
                    var allTabId = tabId + '-all';
                    var columns = [{
                            data: null,
                            className: 'text-center',
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'additional_info',
                            className: 'text-start',
                            render: function(data, type, row) {
                                return data;
                            }
                        },
                        {
                            data: 'hipos_start_date',
                            className: 'text-center'
                        },
                        {
                            data: 'hipos_end_date',
                            className: 'text-center'
                        },
                        {
                            data: 'ps_update_user',
                            className: 'text-center'
                        },
                        {
                            data: 'hipos_update_date',
                            className: 'text-center'
                        }
                    ];

                    function formatAdditionalInfo(data) {
                        var additionalInfo = [];
                        var name_key = {
                            'hipos_pos_ps_code': 'รหัสประจำตัวบุคลากร',
                            'ps_hire_name': 'ประเภทบุคลกร',
                            'ps_admin_name': 'ตำแหน่งในการบริหาร',
                            'ps_spcl_name': 'ตำแหน่งงานเฉพาะทาง',
                            'hipos_pos_work_start_date': 'วันที่เริ่มปฏิบัติงาน',
                            'hipos_pos_work_end_date': 'วันที่สิ้นสุดปฏิบัติงาน',
                            'ps_alp_name': 'ตำแหน่งปฏิบัติงาน',
                            'ps_retire_name': 'สถานะการทำงาน',
                            'hipos_pos_out_desc': 'เหตุผลการลาออกจากการปฏิบัติงาน',
                            'hipos_pos_attach_file': 'แนบไฟล์เอกสารหลักฐาน'
                        };
                        // ตรวจสอบทุกตัวแปรในข้อมูล
                        $.each(data, function(key, value) {
                            if ($.inArray(key, excludeVars) === -1) {
                                additionalInfo.push(name_key[key] + ' : ' + value);
                            }
                        });

                        return additionalInfo.join('<br>');
                    }

                    // จัดการข้อมูลเพื่อรวมค่าที่ไม่ใช่ตัวแปรที่กำหนด
                    var formattedData = $.map(tab.value, function(item) {
                        return $.extend({}, item, {
                            additional_info: formatAdditionalInfo(item) == '' ? '-' : formatAdditionalInfo(item)
                        });
                    });
                    initializeDataTable('#detailTable_position_history_' + allTabId, formattedData, columns);
                });

                $('#position-history-modal').modal('show');
            },
            error: function() {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }

    function cancel_department() {
        $("#card_add_department").fadeOut(300, function() {
            $("#div_add_department").removeClass('d-none').fadeIn(300);
        });
    }

    function confirm_department() {
        var pos_ps_id = $('#pos_ps_id').val();
        var dp_id = $('#pos_dp_id').val();
        var dp_name = $('#pos_dp_id').find('option:selected').text();


        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>insert_person_position',
            type: 'POST',
            data: {
                ps_id: pos_ps_id,
                dp_id: dp_id
            },
            success: function(data) {
                data = JSON.parse(data);
                // console.log(data);
                if (data.data.status_response == status_response_success) {
                    $("#card_add_department").fadeOut(300, function() {
                        // $("#div_add_department").removeClass('d-none').fadeIn(300);
                    });

                    var list_item = $('<li>', {
                        role: 'tab',
                        'data-bs-toggle': 'tab',
                        'data-bs-target': '#tab-dp-' + dp_id + '',
                        class: 'list-group-item',
                        'aria-selected': 'false'
                    }).text(dp_name);

                    $('#list_group_department').append(list_item);

                    // // Append new <div> element
                    // var newTabPane = $('<div>', {
                    //     class: 'tab-pane fade row g-1',
                    //     'data-bs-target': '#tab-dp-'+dp_id+'',
                    //     role: 'tabpanel',
                    //     'aria-labelledby': 'tab-' + dp_id
                    // }).html(data.data.v_profile_official_detail);
                    // $('#tab_department').append(newTabPane); 
                    dialog_success({
                        'header': text_toast_save_success_header,
                        'body': data.data.message_dialog
                    }, '', true);

                } else if (data.data.status_response == status_response_error) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                }
            },
            error: function(xhr, status, error) {
                // console.log(error);
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }

    function profile_save_form(dp_id) {
        var form = document.getElementById('profile_official_form_' + dp_id);
        var profile_official_form = new FormData(form); // Create a FormData object from the form
        var isValid = true;
        if (isChanged == false) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'กรุณาระบุวันที่เริ่มปฏิบัติงานใหม่อีกครั้ง'
            });
            return 0;
        }
        // List of fields to exclude from validation
        var excludeFields = [
            "pos_work_end_date_" + dp_id,
            "pos_desc_" + dp_id,
            "pos_attach_file_" + dp_id,
            "pos_out_desc_" + dp_id
        ];

        // Validate regular form controls
        $('#profile_official_form_' + dp_id + ' .form-control').each(function() {
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
        $('#profile_official_form_' + dp_id + ' .form-select').each(function() {
            var fieldName = $(this).attr('name');
            var fieldValue = $(this).val();
            if(fieldName == 'pos_trail_day_'+dp_id){
                console.log(fieldValue);
                
            }
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
            var posAdminIds = [];
            var postSpclId = [];
            for (var pair of profile_official_form.entries()) {
                if (pair[0] === ('pos_admin_id_' + dp_id)) {
                    posAdminIds.push(pair[1]);
                } else if (pair[0] === ('pos_spcl_id_' + dp_id)) {
                    postSpclId.push(pair[1]);
                }
            }
            // Remove existing entries
            profile_official_form.delete('pos_admin_id_' + dp_id);
            profile_official_form.delete('pos_spcl_id_' + dp_id);
            // Add the new array entry back to FormData
            profile_official_form.append('pos_admin_id_' + dp_id, JSON.stringify(posAdminIds));
            profile_official_form.append('pos_spcl_id_' + dp_id, JSON.stringify(postSpclId));
            profile_official_form.append('check_type1', checkType1);
            profile_official_form.append('check_type2', checkType2);
            profile_official_form.append('dataArray', JSON.stringify(dataArray));
            // for (var pair of profile_official_form.entries()) {
            //     console.log(pair[0] + ': ' + pair[1]);
            // }
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>profile_official_update',
                type: 'POST',
                data: profile_official_form,
                contentType: false, // Required for file uploads
                processData: false, // Required for file uploads
                success: function(data) {
                    data = JSON.parse(data);
                    // console.log(data.data.status_response)
                    if (data.data.status_response == status_response_success) {
                        dialog_success({
                                'header': text_toast_save_success_header,
                                'body': data.data.message_dialog
                            },
                            data.data.return_url, false
                        );

                        var row = data.data.ps_position;
                        var status = "";
                        if (row.pos_status == 1) {
                            status = '<span class="badge bg-success rounded-pill font-10">ปฏิบัติงานอยู่</span>';
                        } else {
                            status = '<span class="badge bg-danger rounded-pill font-10">ออกจากหน้าที่</span>';
                        }
                        $('#tab-' + row.dp_id).html(row.dp_name_th + status);
                    } else if (data.data.status_response == status_response_error) {
                        dialog_error({
                            'header': text_toast_default_error_header,
                            'body': data.data.message_dialog
                        });
                    }

                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                }
            });
            checkType1 = 'False'
            checkType2 = 'False'
        } else {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_invalid_default
            });
        }

    }

    function changeStatus(dp_id, value, defalu_value = null) {
        var splitValues = value.split(",");
        var result = splitValues[1];
        if (result == 2) {
            $("#div_pos_work_end_date_" + dp_id).show();
            $("#div_pos_attach_file_" + dp_id).show();
            $("#div_pos_out_desc_" + dp_id).show();
            $('#check_status_' + dp_id).html('')
            isChanged = true
        } else {
            $("#div_pos_work_end_date_" + dp_id).hide();
            $("#div_pos_attach_file_" + dp_id).hide();
            $("#div_pos_out_desc_" + dp_id).hide();
            if (defalu_value != null) {
                if (defalu_value == 2) {
                    $('#check_status_' + dp_id).html('* กรุณาระบุวันที่เริ่มปฏิบัติงานใหม่อีกครั้ง')
                    isChanged = false
                    $('#pos_work_start_date_' + dp_id).on('change', function() {
                        isChanged = true; // Set flag to true when the selection is changed
                    });
                } else {
                    $('#check_status_' + dp_id).html('')
                    isChanged = true
                }
            }
        }
    }

    function changeHire(hire_id, dp_id) {
        if (hire_id == 23) {
            $("#div_pos_trial_day_" + dp_id).show();
        } else {
            $("#div_pos_trial_day_" + dp_id).hide()
        }
    }

    function addMonthNavigationListeners2() {
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

    function convertYearsToThai2() {
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

    function convertToThaiYear2(yearInput) {
        const currentYear = parseInt(yearInput.value);
        if (currentYear < 2500) { // Convert to B.E. only if not already converted
            yearInput.value = currentYear + 543;
        }
    }

    function convertToThaiYearDropdown2(option) {
        const year = parseInt(option.textContent);
        if (year < 2500) { // Convert to B.E. only if not already converted
            option.textContent = year + 543;
        }
    }

    function formatDateToThai2(date) {
        const d = new Date(date);
        const year = d.getFullYear();
        const month = ('0' + (d.getMonth() + 1)).slice(-2);
        const day = ('0' + d.getDate()).slice(-2);
        return `${day}/${month}/${year}`;
    }
</script>
<?php $data['row_position'] = $person_department_detail; ?>
<input type="hidden" name="pos_ps_id" id="pos_ps_id" value="<?php echo encrypt_id($ps_id); ?>">
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            <!-- profile data / contacts -->
            <div class="section profile">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-body profile-card">
                        <div class="d-flex flex-column align-items-center">
                            <img id="profile_picture" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . ($row_profile->psd_picture != '' ? $row_profile->psd_picture : "default.png")); ?>">
                            <h2 class="mb-3 mt-4"><?php echo $row_profile->pf_name_abbr . $row_profile->ps_fname . " " . $row_profile->ps_lname; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-group list-group-alternate mb-n" id="list_group_department">
                <?php
                if (count($person_department_topic) == 1) {
                    $row = $person_department_topic[0];
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center active" type="button" role="tab" data-bs-toggle="tab" data-bs-target="#tab-dp-<?php echo $row->dp_id; ?>">
                        <?php
                        echo $row->dp_name_th;
                        if ($row->pos_status == 1) {
                            echo '<span class="badge bg-success rounded-pill font-10">ปฏิบัติงานอยู่</span>';
                        } else {
                            echo '<span class="badge bg-danger rounded-pill font-10">ออกจากหน้าที่</span>';
                        }
                        ?>
                    </li>
                <?php } else { ?>
                    <?php foreach ($person_department_topic as $key => $row) { ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo ($key == 0 ? 'active' : '') ?>" id="tab-<?php echo $row->dp_id; ?>" data-bs-toggle="tab" data-bs-target="#tab-dp-<?php echo $row->dp_id; ?>" type="button" role="tab" aria-controls="tab-dp-<?php echo $row->dp_id; ?>" aria-selected="<?php echo ($key == 0 ? 'true' : 'false') ?>">
                            <?php
                            echo $row->dp_name_th;
                            if ($row->pos_status == 1) {
                                echo '<span class="badge bg-success rounded-pill font-10">ปฏิบัติงานอยู่</span>';
                            } else {
                                echo '<span class="badge bg-danger rounded-pill font-10">ออกจากหน้าที่</span>';
                            }
                            ?>
                        </li>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="mt-3 mb-3 col-md-12 d-flex justify-content-center align-items-center d-none" id="div_add_department" data-show="<?php echo $add_department_list->num_rows(); ?>">
                <button type="button" class="btn btn-primary" id="btn_add_department" onclick="add_department()" title="คลิกเพื่อเพิ่มหน่วยงาน" data-toggle="tooltip" data-bs-placement="top">
                    <i class="bi-plus"></i> เพิ่มหน่วยงาน
                </button>
            </div>

            <div class="card mt-3" id="card_add_department">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="pos_dp_id" class="form-label required">หน่วยงาน</label>
                            <select class="form-select select2" data-placeholder="-- เลือกหน่วยงาน --" name="pos_dp_id" id="pos_dp_id">
                                <option value="">-- เลือกหน่วยงาน--</option>

                            </select>
                        </div>
                        <div class="mt-2 mb-2 col-md-12" id="div_confirm_department">
                            <button type="button" class="btn btn-danger float-start" id="btn_cancel_department" onclick="cancel_department()" title="คลิกเพื่อยกเลิกหน่วยงาน" data-toggle="tooltip" data-bs-placement="top">ยกเลิก</button>
                            <button type="button" class="btn btn-success float-end" id="btn_confirm_department" onclick="confirm_department()" title="คลิกเพื่อยืนยันหน่วยงาน" data-toggle="tooltip" data-bs-placement="top">ยืนยัน</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content" id="tab_department">

                <?php
                if (count($person_department_topic) == 1) {
                    $row = $person_department_topic[0];
                    $data['dp_id'] = $row->dp_id;
                    $data['pos_id'] = $row->pos_id;
                    $data['dp_name'] = $row->dp_name_th;
                ?>
                    <div class="tab-pane fade row g-1 show active" data-bs-target="#tab-dp-<?php echo $row->dp_id; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $row->dp_id; ?>">
                        <?php echo $this->load->view($view_dir . 'v_profile_official_detail', $data, true); ?>
                    </div>
                <?php } else { ?>
                    <?php
                    foreach ($person_department_topic as $key => $row) {
                        $data['dp_id'] = $row->dp_id;
                        $data['pos_id'] = $row->pos_id;
                        $data['dp_name'] = $row->dp_name_th;
                    ?>
                        <div class="tab-pane fade row g-1 <?php echo ($key == 0 ? 'show active' : '') ?>" id="tab-dp-<?php echo $row->dp_id; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $row->dp_id; ?>">
                            <?php echo $this->load->view($view_dir . 'v_profile_official_detail', $data, true); ?>
                        </div>
                    <?php } ?>
                <?php } ?>

            </div>

        </div>
    </div>
</div>



<!-- Modal for position-history-modal -->
<div class="modal fade" id="position-history-modal" tabindex="-1" aria-labelledby="position-history-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="position-history-modalLabel">ประวัติการเปลี่ยนข้อมูลการทำงาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs d-flex" id="position_dp_tab" role="tablist">

                </ul>
                <div class="tab-content" id="position_dp_tabContent">

                </div>
            </div>
        </div>
    </div>
</div>