<style>
    .color-circle {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 8px;
        vertical-align: middle; /* จัดให้อยู่แนวเดียวกับข้อความ */
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหารูปแบบการลงเวลาทำงาน<?php echo $hire_is_medical; ?></span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="get">
                        <div class="col-md-4">
                            <label for="select_twac_is_medical" class="form-label">สายงาน</label>
                            <select class="form-select select2" name="select_twac_is_medical" id="select_twac_is_medical">
                                <option value="all" selected>ทั้งหมด</option>
                                <?php
                                    // Assuming $hire_is_medical is already available as an array
                                    $medical_types = [
                                        'M'  => 'สายการแพทย์',
                                        'N'  => 'สายการพยาบาล',
                                        'SM' => 'สายสนับสนุนทางการแพทย์',
                                        'T'  => 'สายเทคนิคและบริการ',
                                        'A'  => 'สายบริหาร'
                                    ];

                                    // Loop through hire_is_medical and display corresponding options
                                    foreach ($this->session->userdata('hr_hire_is_medical') as $value) {
                                        $type = $value['type'];
                                        if (isset($medical_types[$type])) {
                                            echo '<option value="' . $type . '">' . $medical_types[$type] . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="select_twac_type" class="form-label">ประเภทการทำงาน</label>
                            <select class="form-select select2" name="select_twac_type" id="select_twac_type">
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="1">ปฏิบัติงานเต็มเวลา (Full-Time)</option>
                                <option value="2">ปฏิบัติงานบางเวลา (Part-Time)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="select_twac_active" class="form-label">สถานะการใช้งาน</label>
                            <select class="form-select select2" class="form-select" id="select_twac_active" name="select_twac_active">
                                <option value="all" selected>ทั้งหมด</option>
                                <option value="1">เปิดใช้งาน</option>
                                <option value="2">ปิดใช้งาน</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span> รายการรูปแบบการลงเวลาทำงาน<?php echo $hire_is_medical; ?></span><span class="summary_attendange_config badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="btn-option mb-3">
                        <button class="btn btn-primary" onclick="location.href='<?php echo site_url($controller_dir . 'attendance_config_form'); ?>'">
                            <i class="bi-plus"></i> เพิ่มข้อมูลรูปแบบการลงเวลาทำงาน
                        </button>
                    </div>
                    <table id="attendange_list" class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ชื่อรูปแบบภาษาไทย</th>
                                <th class="text-center">เวลาเข้า-ออกงาน</th>
                                <th class="text-center">เวลาเข้างานสาย</th>
                                <th class="text-center">สายงาน</th>
                                <th class="text-center">ประเภทการทำงาน</th>
                                <th class="text-center">สถานะการใช้งาน</th>
                                <th class="text-center">ดำเนินการ</th>
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

<div class="modal fade" id="modal_confirm_delete_data" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ยืนยันการลบข้อมูล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal_detail">

                </div>
                <input type="hidden" name="modal_delete_id" id="modal_delete_id">
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="confirm_profile_delete_data()">ยืนยัน</button>
            </div>
        </div>
    </div>
</div><!-- End Modal-->

<script>
    $(document).ready(function() {
        // Initial DataTable update
        updateDataTable();
    });

    // Function to update DataTable based on select dropdown values
    function updateDataTable() {
        // Initialize DataTable
        var dataTable = $('#attendange_list').DataTable();

        var twac_type = $('#select_twac_type').val();
        var twac_is_medical = $('#select_twac_is_medical').val();
        var twac_active = $('#select_twac_active').val();

        // Make AJAX request to fetch updated data
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>attendance_config_list',
            type: 'GET',
            data: {
                twac_type: twac_type,
                twac_is_medical: twac_is_medical,
                twac_active: twac_active
            },
            success: function(response) {
                // Parse the response if it's a JSON string
                var data = JSON.parse(response);
                
                // Clear existing DataTable data
                dataTable.clear().draw();

                // Update summary count
                $(".summary_attendange_config").text(data.length);

                // Add new data to DataTable
                data.forEach(function(row, index) {
                    var status_text = "";
                    var status_text_btn = "";
                    if (row.twac_active == 1) {
                        status_text = `<div class='text-center'><i class='bi-circle-fill text-success'></i> เปิดใช้งาน</div>`;
                        status_text_btn = `<i class='bi-circle-fill text-success'></i> เปิดใช้งาน`;
                    } else {
                        status_text = `<div class='text-center'><i class='bi-circle-fill text-danger'></i> ปิดใช้งาน</div>`;
                        status_text_btn = `<i class='bi-circle-fill text-danger'></i> ปิดใช้งาน`;
                    }
                    var color = row.twac_color; // สีที่มาจากฐานข้อมูล
                    var name_th = row.twac_name_th + (row.twac_name_abbr_th ? " (" + row.twac_name_abbr_th + ")" : "");

                    // สร้าง HTML สำหรับวงกลมสีและข้อความ
                    var colorCircleHTML = `
                        <span class="color-circle" style="background-color: ${color};"></span> ${name_th}
                    `;

                    // จากนั้นคุณสามารถใช้ตัวแปร `colorCircleHTML` ในการแสดงผล


                    var button = `
                        <div class="text-center option">
                            <button class="btn btn-warning" title="คลิกเพื่อแก้ไขข้อมูล" data-bs-toggle="tooltip" data-bs-placement="top" 
                                onclick="window.location.href='<?php echo site_url() . "/" . $controller_dir; ?>attendance_config_form/${row.twac_id}'">
                                <i class="bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger" title="คลิกเพื่อลบข้อมูล" data-bs-toggle="tooltip" data-bs-placement="top"
                                onclick="modal_confirm_delete(this)" 
                                data-id="${row.twac_id}" 
                                data-topic="รูปแบบการลงเวลาทำงาน" 
                                data-index="${(index+1)}" 
                                data-detail="
                                    <div>
                                        <h6>ชื่อรูปแบบภาษาไทย</h6>
                                        <p>${row.twac_name_th}</p>
                                    </div>
                                    <div class='pt-2'>
                                        <h6>เวลาเข้า-ออกงาน</h6>
                                        <p>${row.twac_start_time} ถึง ${row.twac_end_time}</p>
                                    </div>
                                    <div class='pt-2'>
                                        <h6>สายงาน</h6>
                                        <p>${row.twac_is_medical_text}</p>
                                    </div>
                                    <div class='pt-2'>
                                        <h6>ประเภทการทำงาน</h6>
                                        <p>${row.twac_type_text}</p>
                                    </div>
                                    <div>
                                        <h6>สถานะการใช้งาน</h6>
                                        <p>${status_text_btn}</p>
                                    </div>
                                ">
                                <i class="bi-trash"></i>
                            </button>
                        </div>
                    `;

                    // Add new row to DataTable
                    dataTable.row.add([
                        (index + 1),
                        colorCircleHTML,
                        "<div class='text-center'>" + row.twac_start_time + " - " + row.twac_end_time + "</div>",
                        "<div class='text-center'>" + row.twac_late_time + "</div>",
                        "<div class='text-center'>" + row.twac_is_medical_text + "</div>",
                        "<div class='text-center'>" + row.twac_type_text + "</div>",
                        status_text,
                        button
                    ]).draw();

                });

                // Initialize tooltips for new buttons
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            error: function(xhr, status, error) {
                // Handle errors
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }


    // Event listeners for select dropdowns
    $('#select_dp_id, #select_twac_type, #select_twac_is_medical, #select_twac_active').on('change', function() {
        // Update DataTable when a select dropdown changes
        updateDataTable();
    });

    function modal_confirm_delete(elements) {
        var id = elements.getAttribute("data-id");
        var topic = elements.getAttribute("data-topic");
        var index = elements.getAttribute("data-index");
        var detail = elements.getAttribute("data-detail");

        // Change modal title
        $('#modal_confirm_delete_data .modal-title').html("ยืนยันการลบข้อมูล" + topic + " (#" + index + ")");
        $('#modal_confirm_delete_data .modal-body .modal_detail').html(detail);

        // set input hidden value
        $('#modal_delete_id').val(id);

        // Show modal
        var myModal = new bootstrap.Modal(document.getElementById('modal_confirm_delete_data'));
        myModal.show();
    }

    function confirm_profile_delete_data() {
        var delete_id = $('#modal_delete_id').val();
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>attendance_config_delete',
            type: 'POST',
            data: {
                twac_id: delete_id
            },
            success: function(data) {
                data = JSON.parse(data);

                // Hide the modal before making the AJAX call
                var myModalEl = document.getElementById('modal_confirm_delete_data');
                var myModal = bootstrap.Modal.getInstance(myModalEl);
                myModal.hide();

                if (data.status_response == status_response_success) {
                    dialog_success({'header': text_toast_delete_success_header, 'body': text_toast_delete_success_body});
                } else if (data.status_response == status_response_error) {
                    dialog_error({'header': text_toast_delete_error_header, 'body': text_toast_default_error_body});
                }

            },
            error: function(xhr, status, error) {
                dialog_error({'header': text_toast_default_error_header, 'body': text_toast_default_error_body});
            }
        });
    }

</script>