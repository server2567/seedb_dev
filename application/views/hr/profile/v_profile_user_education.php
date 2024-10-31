<form method="post" class="needs-validation" id="profile_education_form" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="ps_id" id="ps_id" value="<?php echo encrypt_id($ps_id); ?>">
    <input type="hidden" name="edu_id" id="edu_id" value="">
    <input type="hidden" name="tab_active" id="tab_active" value="3">
    <div class="row">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="bi bi-mortarboard icon-menu font-20"></i>จัดการข้อมูลประวัติการศึกษา
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="edu_edulv_id" class="form-label required">ระดับการศึกษา</label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกระดับการศึกษา --" name="edu_edulv_id" id="edu_edulv_id" required onchange="select_education_level(this.value)">
                                        <option value="">-- เลือกระดับการศึกษา--</option>
                                        <?php
                                        foreach ($base_education_level_list as $key => $row) {
                                        ?>
                                            <option value="<?php echo $row->edulv_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->edulv_name; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edu_edudg_id" class="form-label required">วุฒิการศึกษา</label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกวุฒิการศึกษา --" name="edu_edudg_id" id="edu_edudg_id" required>

                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edu_edumj_id" class="form-label ">สาขาวิชา</label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกสาขาวิชา --" name="edu_edumj_id" id="edu_edumj_id">
                                        <option value="null">-- เลือกสาขาวิชา--</option>
                                        <?php
                                        foreach ($base_education_major_list as $key => $row) {
                                        ?>
                                            <option value="<?php echo $row->edumj_id; ?>"><?php echo $row->edumj_name; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edu_place_id" class="form-label required">สถานศึกษา</label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกสถานศึกษา --" name="edu_place_id" id="edu_place_id" required>
                                        <option value="">-- เลือกสถานศึกษา--</option>
                                        <?php
                                        foreach ($base_place_list as $key => $row) {
                                        ?>
                                            <option value="<?php echo $row->place_id; ?>"><?php echo $row->place_name; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edu_country_id" class="form-label required">ประเทศ</label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกประเทศ --" name="edu_country_id" id="edu_country_id" required>
                                        <option value="">-- เลือกรประเทศ--</option>
                                        <?php
                                        foreach ($base_country_list as $key => $row) {
                                        ?>
                                            <option value="<?php echo $row->country_id; ?>"><?php echo $row->country_name; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edu_start_date" class="form-label required">วันที่เริ่มศึกษา</label>
                                    <input type="text" id="edu_start_date" name="edu_start_date" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edu_start_year" class="form-label">ปีที่เริ่มศึกษา</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-edu_start_year">พ.ศ.</span>
                                        <input type="number" id="edu_start_year" name="edu_start_year" class="form-control" disabled>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check_edu_start_year" name="check_edu_start_year">
                                        <label class="form-check-label" for="check_edu_start_year">
                                            ไม่ระบุวันที่เริ่มการศึกษากรุณาระบุปีที่เริ่ม
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label for="edu_end_date" class="form-label required">วันที่จบศึกษา</label>
                                    <input type="text" id="edu_end_date" name="edu_end_date" class="form-control">
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label for="edu_end_year" class="form-label">ปีที่จบศึกษา</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-edu_end_year">พ.ศ.</span>
                                        <input type="number" id="edu_end_year" name="edu_end_year" class="form-control" disabled>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check_edu_end_year" name="check_edu_end_year">
                                        <label class="form-check-label" for="check_edu_end_year">
                                            ไม่ระบุวันที่เริ่มการศึกษากรุณาระบุปีที่จบ
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-sm-12  mt-1 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edu_highest" name="edu_highest">
                                        <label for="edu_highest" class="form-check-label">วุฒิสูงสุด</label>
                                    </div>
                                </div>
                                <!-- <div class="col-md-sm-12  mt-1 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edu_admid" name="edu_admid">
                                        <label for="edu_admid" class="form-check-label">วุฒิบรรจุราชการ</label>
                                    </div>
                                </div> -->
                                <input class="form-check-input" type="hidden" id="edu_admid" name="edu_admid" value="N">
                                <div class="form-group">
                                    <label class="form-label mb-2 required">ประเภทสาขา</label>
                                    <div id="div_dept_name">
                                        <div><label><input type="radio" class="form-check-input" name="edu_edumjt_id" id="edu_edumjt_id_1" value="1" checked>สาขาทางการแพทย์</label></div><br>
                                        <div><label><input type="radio" class="form-check-input" name="edu_edumjt_id" id="edu_edumjt_id_2" value="2">สาขาอื่นๆ ที่เกี่ยวข้องกับการแพทย์</label></div><br>
                                        <div><label><input type="radio" class="form-check-input" name="edu_edumjt_id" id="edu_edumjt_id_3" value="3">สาขาวิทยาศาสตร์สุขภาพ</label></div><br>
                                        <div><label><input type="radio" class="form-check-input" name="edu_edumjt_id" id="edu_edumjt_id_4" value="4">สาขาอื่นๆ</label></div><br>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="edu_hon_id" class="form-label">เกียรตินิยม</label>
                                    <select class="form-select select2" data-placeholder="-- เลือกเกียรตินิยม --" name="edu_hon_id" id="edu_hon_id" required>
                                        <option value="0">-- เลือกเกียรตินิยม--</option>
                                        <option value="1">เกือบนิยมอันดับ1</option>
                                        <option value="2">เกือบนิยมอันดับ2</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">

                                </div>
                                <div class="col-md-6">
                                    <label for="inputNumber" class="form-label mb-2">แนบไฟล์เอกสารหลักฐาน (.jpg, .png และ .pdf เท่านั้น)</label>
                                    <input class="form-control input-bs-file" type="file" id="edu_attach_file" name="edu_attach_file" accept=".png,.jpg,.pdf">
                                    <div id="show_file_name_edit"></div>
                                </div>
                                <div class="col-md-6">

                                </div>
                                <div class="mt-3 mb-3 col-md-12">
                                    <!-- <a type="button" class="btn btn-secondary float-start" href="<?php echo site_url() . "/" . $controller_dir; ?>">ย้อนกลับ</a> -->
                                    <button type="button" class="btn btn-success float-end" id="button_profile_education_save_form" onclick="profile_education_save_form()" title="คลิกเพื่อบันทึกข้อมูล" data-toggle="tooltip" data-placement="top">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="bi bi-table icon-menu font-20"></i>ตารางข้อมูลประวัติการศึกษา
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-end mt-0 mb-2">
                                <button class="btn btn-primary" id="edu_seq"><i class="bi bi-list"></i></button>
                            </div>
                            <table class="table datatable" id="education_list" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ระดับ</th>
                                        <th>วุฒิการศึกษา</th>
                                        <th>สาขาวิชา</th>
                                        <th>สถานศึกษา</th>
                                        <th>วันที่เริ่มศึกษา</th>
                                        <th>วันที่จบศึกษา</th>
                                        <th>ดำเนินงาน</th>
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
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">จัดเรียงข้อมูลประวัติการศึกษา</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="eduList" class="list-group">
                    <!-- รายการการศึกษาจะแสดงที่นี่ -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveOrder">บันทึกลำดับ</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    $(document).ready(function() {
        var data_education_list_table = $('#education_list').DataTable();
        var edu_edulv_id = $('#edu_edulv_id').val();
        var tab_active = $('#profile_education_form #tab_active').val();
        if (edu_edulv_id) {
            select_education_level(edu_edulv_id);
        }

        $('#check_edu_start_year').change(function(event) {
            var checkbox = event.target;

            if (checkbox.checked) {
                document.getElementById("edu_start_date").setAttribute("disabled", "disabled");
                document.getElementById("edu_start_year").value = "<?php echo date("Y") + 543; ?>";
                document.getElementById("edu_start_year").removeAttribute("disabled");
            } else {
                document.getElementById("edu_start_date").removeAttribute("disabled");
                document.getElementById("edu_start_year").setAttribute("disabled", "disabled");
            }
        });

        $('#check_edu_end_year').change(function(event) {
            var checkbox = event.target;

            if (checkbox.checked) {
                document.getElementById("edu_end_date").setAttribute("disabled", "disabled");
                document.getElementById("edu_end_year").value = "<?php echo date("Y") + 543; ?>";
                document.getElementById("edu_end_year").removeAttribute("disabled");
            } else {
                document.getElementById("edu_end_date").removeAttribute("disabled");
                document.getElementById("edu_end_year").setAttribute("disabled", "disabled");
            }
        });

        // Handle file selection
        $('#edu_attach_file').change(function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : "Choose file";
            $('#edu_attach_file_label').text(fileName);
        });

        // Handle delete button click
        $('#deleteButton').click(function() {
            $('#edu_attach_file').val('');
            $('#edu_attach_file_label').text('Choose file');
        });

        // Handle change button click
        $('#changeButton').click(function() {
            $('#edu_attach_file').click();
        });
        $('#edu_seq').click(function() {
            var ps_id = $('#ps_id').val();

            // Make AJAX request to fetch updated data
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>get_profile_person_education_list',
                type: 'GET',
                data: {
                    ps_id: ps_id
                },
                success: function(data) {
                    data = JSON.parse(data);
                    $('#eduList').empty();
                    // เรียงลำดับข้อมูลตาม edu_seq
                    data.sort(function(a, b) {
                        return a.edu_seq - b.edu_seq;
                    });

                    // เพิ่มข้อมูลไปยังรายการ
                    data.forEach(function(item) {
                        $('#eduList').append(`
                            <li class="list-group-item" data-id="${item.edu_id}">
                                ${item.edulv_name} - ${item.edudg_name} (${(parseInt(item.edu_start_year, 10) + 543)} - ${(parseInt(item.edu_end_year, 10) + 543)})
                            </li>
                        `);
                    });

                    // ทำให้รายการสามารถลากและวางได้ด้วย Sortable.js
                    new Sortable(document.getElementById('eduList'), {
                        animation: 150,
                    });

                    $('#myModal').modal('show');
                }
            })

        })
        $('#saveOrder').click(function() {
            var newOrder = [];
            $('#eduList li').each(function(index) {
                var edu_id = $(this).data('id');
                newOrder.push({
                    edu_id: edu_id,
                    edu_seq: index + 1
                });
            });
            if (newOrder.length > 0) {
                // ส่งข้อมูลลำดับใหม่ผ่าน AJAX
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller_dir; ?>save_new_education_order',
                    type: 'POST',
                    data: {
                        order: newOrder
                    },
                    success: function(data) {
                        // ปิด Modal
                        $('#myModal').modal('hide');
                        data = JSON.parse(data);
                        if (data.data.status_response == status_response_success) {
                            dialog_success({
                                'header': text_toast_save_success_header,
                                'body': data.data.message_dialog
                            }, data.data.return_url, false);
                        } else if (data.data.status_response == status_response_error) {
                            dialog_error({
                                'header': text_toast_default_error_header,
                                'body': data.data.message_dialog
                            });
                        }
                    }
                });
            } else {
                dialog_error({
                    'header': 'เกิดข้อผิดพลาด',
                    'body': 'ไม่มีข้อมูลประวัติการศึกษา'
                });
                $('#myModal').modal('hide');
            }
        });
        // Function to update DataTable based on select dropdown values
        function updateDataTable() {
            var ps_id = $('#ps_id').val();

            // Make AJAX request to fetch updated data
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>get_profile_person_education_list',
                type: 'GET',
                data: {
                    ps_id: ps_id
                },
                success: function(data) {
                    // Clear existing data_education_list_table data
                    data = JSON.parse(data);
                    data_education_list_table.clear().draw();

                    $(".summary_person").text(data.length);
                    // Add new data to data_education_list_table
                    data.forEach(function(row, index) {
                        var isFile = "";
                        if(row.edumj_name == null || row.edumj_name == 0){
                            row.edumj_name = '-'
                        }
                        if (row.edu_attach_file !== null) {
                            isFile = `  <button type="button" class="btn btn-primary" data-file-name="${row.edu_attach_file}" 
                                        data-preview-path="<?php echo site_url($this->config->item('hr_dir') . 'Getpreview?path=' . $this->config->item('hr_upload_profile_education') . '&doc='); ?>${row.edu_attach_file}" 
                                        data-download-path="<?php echo site_url($this->config->item('hr_dir') . 'Getdoc?path=' . $this->config->item('hr_upload_profile_education') . '&doc='); ?>${row.edu_attach_file}&rename=${row.edu_attach_file}"
                                        data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน" data-toggle="tooltip" data-bs-placement="top">
                                        <i class="bi-file-earmark"></i>
                                    </button>`;
                        }

                        var button = `  <div class="text-center option">` +
                            isFile +
                            `
                                            <button type="button" class="btn btn-warning" onclick="get_education_detail_by_id('${row.edu_id}')" title="คลิกเพื่อแก้ไขข้อมูล" data-toggle="tooltip" data-bs-placement="top">
                                                <i class="bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="modal_confirm_delete(this)" title="คลิกเพื่อลบข้อมูล" data-toggle="tooltip" data-bs-placement="top"
                                                data-id="${row.edu_id}" 
                                                data-tab="${tab_active}"
                                                data-table="education" 
                                                data-topic="ประวัติการศึกษา" 
                                                data-index="${(index+1)}" 
                                                data-detail="
                                                    <div>
                                                        <h6>ระดับการศึกษา</h6>
                                                        <p>${row.edulv_name}</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>วุฒิการศึกษา</h6>
                                                        <p>${replaceQuotes(row.edudg_name)} (${replaceQuotes(row.edudg_abbr)})</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>สาขาวิชา</h6>
                                                        <p>${replaceQuotes(row.edumj_name)}</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>สถานศึกษา</h6>
                                                        <p>${replaceQuotes(row.place_name)}</p>
                                                    </div>
                                                    <div>
                                                        <h6>วันที่ศึกษา</h6>
                                                        <p>${row.edu_start_date} ถึง ${row.edu_end_date}</p>
                                                    </div>"
                                                title="คลิกเพื่อลบข้อมูล">
                                                <i class="bi-trash"></i>
                                            </button>
                                        </div>
                                    `;
                        data_education_list_table.row
                            .add([
                                (index + 1),
                                row.edulv_name,
                                row.edudg_name + " (" + row.edudg_abbr + ")",
                                row.edumj_name,
                                row.place_name,
                                row.edu_start_date,
                                row.edu_end_date,
                                button
                            ]).draw();
                    });
                    $('[data-toggle="tooltip"]').tooltip();
                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                }
            });
        }

        // Initial DataTable update
        updateDataTable();

    });

    function get_education_detail_by_id(edu_id) {
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_education_detail_by_id/' + edu_id,
            type: 'POST',
            data: {
                edu_id: edu_id
            },
            success: function(data) {
                data = JSON.parse(data);
                // console.log(data);
                $('#show_file_name_edit').html('');
                if (data.length > 0) {
                    var education = data[0];
                    // Set values to HTML elements
                    $('#edu_id').val(education.edu_id);
                    $('#edu_edulv_id').val(education.edulv_id);
                    $('#edu_edudg_id').val(education.edudg_id);
                    $('#edu_edumj_id').val(education.edumj_id);
                    $('#edu_place_id').val(education.place_id);
                    $('#edu_country_id').val(education.country_id);
                    $('#edu_start_date').val(education.edu_start_date);
                    $('#edu_end_date').val(education.edu_end_date);
                    $('#edu_start_year').val(education.edu_start_year);
                    $('#edu_end_year').val(education.edu_end_year);
                    $('#edu_hon_id').val(education.edu_hon_id);

                    // Update values of Select2 dropdowns
                    $('#edu_edulv_id').trigger('change');
                    $('#edu_edudg_id').trigger('change');
                    $('#edu_edumj_id').trigger('change');
                    $('#edu_place_id').trigger('change');
                    $('#edu_country_id').trigger('change');
                    $('#edu_hon_id').trigger('change');

                    // Update edu_edudg_id based on edu_edulv_id and select the appropriate option
                    select_education_level(education.edulv_id, education.edudg_id);

                    // Check checkboxes based on data
                    $('#edu_highest').prop('checked', education.edu_highest == 'Y');
                    $('#edu_admid').prop('checked', education.edu_admid == 'Y');

                    // Check radio buttons based on data
                    $('input[name="edu_edumjt_id"][value="' + education.edu_edumjt_id + '"]').prop('checked', true);

                    if (education.edu_attach_file != null) {
                        var file_name = ` 
                        <a class="btn btn-link" data-file-name="${education.edu_attach_file}" 
                            data-preview-path="<?php echo site_url($this->config->item('hr_dir') . 'Getpreview?path=' . $this->config->item('hr_upload_profile_education') . '&doc='); ?>${education.edu_attach_file}" 
                            data-download-path="<?php echo site_url($this->config->item('hr_dir') . 'Getdoc?path=' . $this->config->item('hr_upload_profile_education') . '&doc='); ?>${education.edu_attach_file}&rename=${education.edu_attach_file}"
                            data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน">
                            ${education.edu_attach_file}
                        </a>`;
                        $('#show_file_name_edit').html(file_name);
                    }

                    $('#profile_education_form #collapseOne').addClass('show');
                    $('html, body').animate({
                        scrollTop: 0
                    }, 0);
                }
            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }
    // get_education_detail_by_id

    function profile_education_save_form() {
        var form = document.getElementById('profile_education_form');
        var profile_education_form = new FormData(form); // Create a FormData object from the form
        var isValid = true;
        var isDuplicate = true;

        // List of fields to exclude from validation
        var excludeFields = ["edu_edulv_id", "edu_start_year", "edu_end_year", "edu_hon_id", "edu_attach_file"];

        // Validate regular form controls
        $('#profile_education_form .form-control').each(function() {
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
        $('#profile_education_form .form-select').each(function() {
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
                url: '<?php echo site_url() . "/" . $controller_dir; ?>profile_education_update',
                type: 'POST',
                data: profile_education_form,
                contentType: false, // Required for file uploads
                processData: false, // Required for file uploads
                success: function(data) {
                    data = JSON.parse(data);
                    // console.log(data.data.status_response)
                    if (data.data.status_response == status_response_success) {
                        dialog_success({
                            'header': text_toast_save_success_header,
                            'body': data.data.message_dialog
                        }, data.data.return_url, false);
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
        } else {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_invalid_default
            });
        }
        // end if isValid
    }


    function select_education_level(edulv_id, selectedEdudgId = null) {
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_edudg_by_edulv_id',
            type: 'POST',
            data: {
                edulv_id: edulv_id
            },
            dataType: 'json',
            success: function(response) {
                var options = '<option value="">-- เลือกวุฒิการศึกษา--</option>';
                $.each(response, function(index, value) {
                    options += '<option value="' + value.edudg_id + '">' + value.edudg_name + " (" + value.edudg_abbr + ")" + '</option>';
                });
                $('#edu_edudg_id').html(options);

                // If selectedEdudgId is provided, set it as the selected option
                if (selectedEdudgId) {
                    $('#edu_edudg_id').val(selectedEdudgId).trigger('change');
                }
            }
        });
    }

    flatpickr("#edu_start_date", {
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
                document.getElementById('edu_start_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('edu_start_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    flatpickr("#edu_end_date", {
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
                document.getElementById('edu_end_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('edu_end_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
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