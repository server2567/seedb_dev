<style>
    .color-circle {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 8px;
        vertical-align: middle;
        /* จัดให้อยู่แนวเดียวกับข้อความ */
    }

    .nav-pills .nav-link {
        border: 1px dashed #607D8B;
        color: #012970;
        background-color: #fff;
    }
</style>
<ul class="nav nav-pills" id="tabTimework" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link w-100 active" id="form-tab" data-bs-toggle="tab" data-bs-target="#form-attendace" type="button" role="tab" aria-controls="home" aria-selected="true">ตารางรูปแบบการลงเวลาทำงาน</button>
    </li>
    <li class="nav-item ms-1" role="presentation">
        <button class="nav-link w-100" id="setting-tab" data-bs-toggle="tab" data-bs-target="#report-attendace" type="button" role="tab" aria-controls="profile" aria-selected="false">รายงานตารางรูปแบบการลงเวลาทำงาน</button>
    </li>
</ul>
<div class="tab-content pt-2" id="tabTimeworkContent">
    <div class="tab-pane fade show active" id="form-attendace" role="tabpanel" aria-labelledby="form-tab">
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
                                    <label for="select_twag_is_medical" class="form-label">สายงาน</label>
                                    <select class="form-select select2" name="select_twag_is_medical" id="select_twag_is_medical" onchange="filter_data()">
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
                                    <label for="select_twag_type" class="form-label">ประเภทการทำงาน</label>
                                    <select class="form-select select2" name="select_twag_type" id="select_twag_type" onchange="filter_data()">
                                        <option value="all" selected>ทั้งหมด</option>
                                        <option value="1">ปฏิบัติงานเต็มเวลา (Full-Time)</option>
                                        <option value="2">ปฏิบัติงานบางเวลา (Part-Time)</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_twag_active" class="form-label">สถานะการใช้งาน</label>
                                    <select class="form-select select2" class="form-select" id="select_twag_active" name="select_twag_active" onchange="filter_data()">
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
                                        <th class="text-center" width="5%">#</th>
                                        <th class="text-center" width="10%">ชื่อรูปแบบการอบรมภาษาไทย</th>
                                        <th class="text-center" width="20%">เวลาเข้า-ออกงาน</th>
                                        <th class="text-center" width="20%">เวลาเข้างานสาย</th>
                                        <th class="text-center" width="10%">สายงาน</th>
                                        <th class="text-center" width="15%">ประเภทการทำงาน</th>
                                        <th class="text-center" width="20%">สถานะการใช้งาน</th>
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
    <div class="tab-pane fade" id="report-attendace" role="tabpanel" aria-labelledby="form-tab">
        <?php echo $this->load->view($view_dir . 'v_attendance_config_report', '', TRUE); ?>
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
        function filter_data(){
            updateDataTable()
        }
        // Function to update DataTable based on select dropdown values
        function updateDataTable() {
            // Initialize DataTable
            var dataTable = $('#attendange_list').DataTable();

            var twag_type = $('#select_twag_type').val();
            var twag_is_medical = $('#select_twag_is_medical').val();
            var twag_active = $('#select_twag_active').val();
            var medical_types = {
                'M': 'สายการแพทย์',
                'N': 'สายการพยาบาล',
                'SM': 'สายสนับสนุนทางการแพทย์',
                'A': 'สายบริหาร'
            };

            // Make AJAX request to fetch updated data
            $('#attendange_list').DataTable().destroy();

            $('#attendange_list').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "ทั้งหมด"]
                ],
                language: {
                    emptyTable: "ไม่มีรายการในระบบ",
                    info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                    infoEmpty: "แสดงรายการที่ 0 - 0 จากทั้งหมด 0 รายการ",
                    lengthMenu: "_MENU_",
                    search: "ค้นหา:",
                    loadingRecords: "กำลังโหลด...",
                    searchPlaceholder: "ค้นหา...",
                    zeroRecords: "ไม่พบรายการที่ตรงกัน",
                    paginate: {
                        first: "«",
                        last: "»",
                        next: "›",
                        previous: "‹"
                    }
                },
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'print', // ใช้ฟังก์ชัน Print ของ DataTables
                        text: '<i class="bi bi-printer"></i> Print',
                        className: 'btn btn-secondary',
                        title: 'Attendance Report', // ชื่อหัวข้อบนหน้า Print
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt')
                                .prepend('<h3 style="text-align:center;">Attendance Report</h3>');
                        }
                    },
                    {
                        extend: 'excel', // ใช้ฟังก์ชัน Excel ของ DataTables
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                        className: 'btn btn-success',
                        title: 'Attendance_Report', // ชื่อไฟล์ Excel

                    }, {
                        extend: 'pdfHtml5',
                        text: '<i class="bi-file-earmark-pdf-fill"></i> PDF',
                        className: 'btn btn-danger',
                        titleAttr: 'PDF', // Title Tooltip
                        title: 'Report Title', // ชื่อไฟล์ PDF
                        orientation: 'portrait', // แนวตั้ง (หรือใช้ 'landscape' สำหรับแนวนอน)
                        pageSize: 'A4', // ขนาดกระดาษ
                        customize: function(doc) {
                            doc.defaultStyle = {
                                font: 'Roboto', // ฟอนต์ที่รองรับใน pdfmake
                                fontSize: 12 // ขนาดฟอนต์เริ่มต้น
                            };
                            doc.styles.tableHeader = {
                                bold: true,
                                fontSize: 14,
                                color: 'white',
                                fillColor: '#4CAF50', // สีพื้นหลังของ header ตาราง
                                alignment: 'center'
                            };
                        }
                    }
                ],
                ordering: false,
                columnDefs: [{
                    targets: 0, // คอลัมน์ชื่อกลุ่ม
                    visible: false, // ซ่อนคอลัมน์ไว้
                    searchable: true // ให้สามารถค้นหาในคอลัมน์นี้ได้
                }],
                drawCallback: function(settings) {
                    const api = this.api();
                    const rows = api.rows({
                        page: 'current'
                    }).nodes();
                    let lastGroupId  = null;

                    api.rows({
                        page: 'current'
                    }).data().each(function(data, index) {
                        if (lastGroupId !== data.group_id) {
                            // แทรก Group Header พร้อมปุ่มจัดการ
                            console.log(data.twag_is_medical);

                            $(rows)
                                .eq(index)
                                .before(`
                        <tr class="group-row">
                            <td colspan="8" style="background: #f9f9f9; font-weight: bold;">
                                <div class="d-flex justify-content-between align-items-center">
                                    ${data.group_name}
                                    <div>
                                            <button class="btn btn-warning" style="margin-right:5px" title="คลิกเพื่อแก้ไขข้อมูล" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                onclick="window.location.href='<?php echo site_url() . "/" . $controller_dir; ?>attendance_config_form/${data.group_id}'">
                                                <i class="bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" title="คลิกเพื่อลบข้อมูล" data-bs-toggle="tooltip" data-bs-placement="top"
                                                onclick="modal_confirm_delete(this)" 
                                                data-id="${data.group_id}" 
                                                data-topic="กลุ่มรูปแบบการลงเวลาทำงาน" 
                                                data-index="${(index+1)}" 
                                                data-detail="
                                                    <div>
                                                        <h6>ชื่อกลุ่มรูปแบบภาษาไทย</h6>
                                                        <p>${data.group_name}</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>สายงาน</h6>
                                                        <p>${medical_types[data.twag_is_medical]}</p>
                                                    </div>
                                                    <div class='pt-2'>
                                                        <h6>ประเภทการทำงาน</h6>
                                                        <p>${ data.type}</p>
                                                    </div>
                                                    <div>
                                                        <h6>สถานะการใช้งาน</h6>
                                                        <p>${data.twag_active_id == 1 ?
                                        `<i class='bi-circle-fill text-success'></i> เปิดใช้งาน` : `<i class='bi-circle-fill text-danger'></i> ปิดใช้งาน`}</p>
                                                    </div>
                                                ">
                                                <i class="bi-trash"></i>
                                            </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `);
                            lastGroupId = data.group_id;
                        }
                    });
                },
                autoWidth: false,
                ajax: {
                    type: "GET",
                    url: '<?php echo site_url() . "/" . $controller_dir; ?>attendance_config_list',
                    data: {
                        twag_type: twag_type,
                        twag_is_medical: twag_is_medical,
                        twag_active: twag_active
                    },
                    dataSrc: function(data) {
                        const return_data = [];
                        data.forEach((group) => {
                            let group_seq = 1; // เริ่มลำดับใหม่สำหรับกลุ่ม
                            if (group.twag_twac_data && group.twag_twac_data.length > 0) {
                                group.twag_twac_data.forEach((row) => {
                                    const color = row.twac_color;
                                    const name_th = row.twac_name_th + (row.twac_name_abbr_th ? ` (${row.twac_name_abbr_th})` : "");
                                    const colorCircleHTML = `
                            <span class="color-circle" style="background-color: ${color};"></span> ${name_th}
                        `;

                                    return_data.push({
                                        group_name: `${group.twag_name_th} (${group.twag_name_abbr_th})`,
                                        group_id: group.twag_id, // กำหนดค่า group_id
                                        seq: group_seq++,
                                        name: colorCircleHTML,
                                        twag_start_time: `${row.twac_start_time.substring(0, 5)} ถึง ${row.twac_end_time.substring(0, 5)}`,
                                        twag_late_time: row.twac_late_time.substring(0, 5),
                                        twag_is_medical: group.twag_is_medical,
                                        twag_is_medical_text: medical_types[group.twag_is_medical],
                                        type: group.twag_type == 1 ? 'ปฏิบัติงานเต็มเวลา (Full Time)' : 'ปฏิบัติงานบางส่วนเวลา (Part Time)',
                                        twag_active_id: row.twac_active,
                                        twag_active_text: row.twac_active == 1 ?
                                            '<i class="bi-circle-fill text-success"></i> เปิดใช้งาน' : '<i class="bi-circle-fill text-danger"></i> ปิดใช้งาน'
                                    });
                                });
                            } else {
                                // เพิ่มกลุ่มที่ไม่มีข้อมูลย่อย
                                return_data.push({
                                    group_name: `${group.twag_name_th} (${group.twag_name_abbr_th})`,
                                    group_id: group.twag_id,
                                    seq: '',
                                    name: 'ไม่มีข้อมูล',
                                    twag_start_time: '',
                                    twag_late_time: '',
                                    twag_is_medical: '',
                                    twag_is_medical_text: '',
                                    type: '',
                                    twag_active_id: '',
                                    twag_active_text: ''
                                });
                            }
                        });
                        return return_data;
                    }
                },
                columns: [{
                        data: "group_name", // ชื่อกลุ่ม
                        title: "กลุ่ม"
                    },
                    {
                        data: "seq",
                        className: "text-center",
                        title: "#"
                    },
                    {
                        data: "name",
                        title: "ชื่อ"
                    },
                    {
                        data: "twag_start_time",
                        title: "เวลาเริ่มต้น"
                    },
                    {
                        data: "twag_late_time",
                        title: "เวลาสาย"
                    },
                    {
                        data: "twag_is_medical_text",
                        title: "สายงาน"
                    },
                    {
                        data: "type",
                        title: "ประเภทการทำงาน"
                    },
                    {
                        data: "twag_active_text",
                        title: "สถานะการทำงาน",
                        width: '15%'
                    }
                ]
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
                url: '<?php echo site_url() . "/" . $controller_dir; ?>attendance_config_group_delete',
                type: 'POST',
                data: {
                    twag_id: delete_id
                },
                success: function(data) {
                    data = JSON.parse(data);

                    // Hide the modal before making the AJAX call
                    var myModalEl = document.getElementById('modal_confirm_delete_data');
                    var myModal = bootstrap.Modal.getInstance(myModalEl);
                    myModal.hide();

                    if (data.status_response == status_response_success) {
                        dialog_success({
                            'header': text_toast_delete_success_header,
                            'body': text_toast_delete_success_body
                        });
                    } else if (data.status_response == status_response_error) {
                        dialog_error({
                            'header': text_toast_delete_error_header,
                            'body': text_toast_default_error_body
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
        }
    </script>