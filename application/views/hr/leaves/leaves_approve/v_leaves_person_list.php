<style>
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

    #profile_picture {
        margin-top: -115px;
        border-radius: 5px;
        max-width: 100%;
        /* ปรับให้ขนาดของภาพไม่เกินขนาด container */
        max-height: 200px;
        /* จำกัดความสูงสูงสุด */
        object-fit: cover;
        /* ปรับให้ภาพพอดีกรอบและคงอัตราส่วน */
        height: auto;
        /* ให้ความสูงปรับตามความกว้างโดยอัตโนมัติ */
        box-shadow: 0px 2px 20px rgba(1, 41, 112, 0.1);
    }

    .action-buttons {
        gap: 10px;
        /* เพิ่มระยะห่างระหว่างปุ่ม */
    }

    .action-btn {
        padding: 10px 20px;
        /* เพิ่มความกว้างของปุ่ม */

        font-weight: bold;
        /* เน้นข้อความให้ชัดเจน */
        transition: all 0.3s ease-in-out;
        /* เพิ่มเอฟเฟกต์เมื่อโฮเวอร์ */
    }

    .action-btn:disabled {
        opacity: 0.5;
        /* ลดความชัดเจนเมื่อปุ่มถูกปิดใช้งาน */
        cursor: not-allowed;
        /* เปลี่ยน cursor เมื่อปิดใช้งาน */
    }

    .action-btn:hover:not(:disabled) {
        transform: scale(1.1);
        /* ขยายปุ่มเมื่อโฮเวอร์ */
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        /* เพิ่มเงา */
    }

    .btn-success {
        background-color: #28a745;
        /* สีพื้นหลังอนุมัติ */
        border: none;
        /* ลบขอบ */
    }

    .btn-success:hover {
        background-color: #218838;
        /* สีเมื่อโฮเวอร์ */
    }

    .btn-danger {
        background-color: #dc3545;
        /* สีพื้นหลังไม่อนุมัติ */
        border: none;
        /* ลบขอบ */
    }

    .btn-danger:hover {
        background-color: #c82333;
        /* สีเมื่อโฮเวอร์ */
    }
</style>
<div class="col-md-12">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-search icon-menu"></i><span> ค้นหารายการลา</span>
                            </button>
                        </h2>
                        <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">

                                    <div class="col-md-4">
                                        <label for="leaves_date" class="form-label">ช่วงวันที่</label>
                                        <div class="input-group" id="leaves_date" name="leaves_date">
                                            <input type="text" class="form-control" name="leaves_start_date" id="leaves_start_date" value="">
                                            <span class="input-group-text">ถึง</span>
                                            <input type="text" class="form-control" name="leaves_end_date" id="leaves_end_date" value="">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="leaves_type" class="form-label">ประเภทการลา</label>
                                        <select class="select2" name="leaves_type" id="leaves_type">
                                            <option value="-1" disabled>-- เลือกประเภทการลา --</option>
                                            <option value="all" selected>ทั้งหมด</option>
                                            <option value="1">ลาป่วย</option>
                                            <option value="2">ลาวันหยุดตามประเพณี</option>
                                            <option value="3">ลาวันหยุดพักผ่อน</option>
                                            <option value="4">ลากิจได้รับค่าจ้าง</option>
                                            <option value="5">ลากิจไม่รับค่าจ้าง</option>
                                            <option value="6">ลาคลอดบุตร</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="leaves_status" class="form-label">สถานะการอนุมัติ</label>
                                        <select class="select2" name="leaves_status" id="leaves_status">
                                            <option value="-1" disabled>-- เลือกสถานะ --</option>
                                            <option value="all">ทั้งหมด</option>
                                            <option value="W" selected>รอดำเนินการ</option>
                                            <option value="Y">อนุมัติ</option>
                                            <option value="N">ไม่อนุมัติ</option>
                                        </select>
                                    </div>

                                    <!-- <div class="col-12">
                                    <div class="col-md-12 text-end"><button class="btn btn-secondary"><i class="bi bi-x-lg"></i> เคลียข้อมูล</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"><i class="bi bi-search"></i> ค้นหา</button></div>

                                    </div> -->
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
                                <i class="bi-table icon-menu"></i><span> ตารางรายการแสดงข้อมูลอนุมัติการลา</span><span class="badge bg-success" id="leaves_table_list_count"></span>
                            </button>
                        </h2>
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <!-- Action buttons above the table -->

                                <div class="action-buttons d-flex justify-content-left align-items-center mt-3 mb-5">
                                    <!-- ปุ่มอนุมัติ -->
                                    <button id="approve_selected" class="btn btn-success action-btn me-3 btn-lg" disabled
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="อนุมัติรายการที่เลือก">
                                        <i class="bi bi-check-circle me-1"></i> อนุมัติ
                                    </button>
                                    <!-- ปุ่มไม่อนุมัติ -->
                                    <button id="disapprove_selected" class="btn btn-danger action-btn btn-lg" disabled
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="ไม่อนุมัติรายการที่เลือก">
                                        <i class="bi bi-x-circle me-1"></i> ไม่อนุมัติ
                                    </button>
                                </div>


                                <table class="table datatable" id="leaves_table_list" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="5%">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="header_checkbox">
                                                </div>
                                            </th>
                                            <th class="text-center" width="5%">#</th>
                                            <th class="text-center" width="20%">ผู้ทำเรื่องการลา</th>
                                            <th class="text-center" width="15%">วันที่ลา</th>
                                            <th class="text-center" width="20%">รายละเอียดการลา</th>
                                            <th class="text-center" width="15%">ประเภทการลา</th>
                                            <th class="text-center" width="10%">สถานะ</th>
                                            <th class="text-center" width="10%">ดำเนินการ</th>
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
    </div>
</div>

<!-- Modal for leave details -->
<div class="modal fade" id="leaveDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เส้นทางอนุมัติการลา</h5>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">ยืนยันการดำเนินการ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>วันที่ลา</th>
                            <th>รายละเอียด</th>
                            <th>ประเภทการลา</th>
                            <th>ความคิดเห็น</th>
                        </tr>
                    </thead>
                    <tbody id="previewModalBody"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input id="previewModalAction" type="hidden">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button id="confirmAction" type="button" class="btn btn-primary">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {

        // Check if DataTable is already initialized, then initialize or re-use the instance
        let dataTable;
        if (!$.fn.DataTable.isDataTable('#leaves_table_list')) {
            dataTable = $('#leaves_table_list').DataTable({
                "columnDefs": [{
                        "orderable": false,
                        "targets": 0
                    } // Disable sorting for the checkbox column
                ]
            });
            
        } else {
            dataTable = $('#leaves_table_list').DataTable();
        }

        // Set default end date
        const defaultEndDate = new Date(new Date().getFullYear() + 543, 11, 31);
        document.getElementById('leaves_end_date').value = formatDateToThai(defaultEndDate);

        // Event listeners for select dropdowns
        $('#leaves_start_date, #leaves_end_date , #leaves_type, #leaves_status').on('change', function() {
            updateDataTable();
        });

        // "Select All" functionality for header checkbox
        $('#header_checkbox').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('input[type="checkbox"].row-checkbox').prop('checked', isChecked);
            toggleActionButtons();
        });

        // Toggle Approve/Disapprove buttons based on selection
        $(document).on('change', 'input[type="checkbox"].row-checkbox', function() {
            toggleActionButtons();
            checkSelectAllStatus();
        });

        function toggleActionButtons() {
            const selectedCount = $('input[type="checkbox"].row-checkbox:checked').length;
            $('#approve_selected, #disapprove_selected').prop('disabled', selectedCount === 0);
        }

        function checkSelectAllStatus() {
            // Update "Select All" checkbox based on individual selections
            const allSelected = $('input[type="checkbox"].row-checkbox').length === $('input[type="checkbox"].row-checkbox:checked').length;
            $('#header_checkbox').prop('checked', allSelected);
        }

        // // Approve selected rows
        // $('#approve_selected').on('click', function() {
        //     const selectedIds = getSelectedIds();
        //     if (selectedIds.length > 0) {
        //         processApproval(selectedIds, 'approve');
        //     }
        // });

        // // Disapprove selected rows
        // $('#disapprove_selected').on('click', function() {
        //     const selectedIds = getSelectedIds();
        //     if (selectedIds.length > 0) {
        //         processApproval(selectedIds, 'disapprove');
        //     }
        // });

        function getSelectedIds() {
            return $('input[type="checkbox"].row-checkbox:checked').map(function() {
                return $(this).data('id');
            }).get();
        }

        function processApproval(ids, action, comments) {
            // console.log("ids", ids);

            console.log("comments", comments);
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir . "update_leave_status"; ?>',
                type: 'POST',
                data: {
                    ids: ids,
                    action: action,
                    comments: comments // ส่งความคิดเห็นไปพร้อมกัน
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    // alert(response.message);
                    if (data.status_response == status_response_success) {
                        dialog_success({
                            'header': text_toast_save_success_header,
                            'body': data.message_dialog
                        });
                    } else if (data.status_response == status_response_error) {
                        dialog_error({
                            'header': text_toast_default_error_header,
                            'body': data.message_dialog
                        });
                    }

                    updateDataTable();
                },
                error: function() {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'กรุณาเลือกข้อมูลก่อนดำเนินการ'
                    });
                }
            });
        }

        $('#approve_selected, #disapprove_selected').on('click', function() {
            const action = $(this).attr('id') === 'approve_selected' ? 'approve' : 'disapprove';
            const selectedIds = getSelectedIds();
            const selectedData = getSelectedData(selectedIds);

            if (selectedData.length > 0) {
                showPreviewModal(selectedData, action);
            } else {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': 'กรุณาเลือกข้อมูลก่อนดำเนินการ'
                });
            }
        });

        function getSelectedData(ids) {
            const selectedData = [];
            ids.forEach((id) => {
                const row = dataTable.row($(`input[data-id="${id}"]`).closest('tr')).data();
                selectedData.push({
                    id: id,
                    name: row[2],
                    leaveDate: row[3],
                    detail: row[4],
                    leaveType: row[5],
                });
            });
            return selectedData;
        }

        function showPreviewModal(data, action) {
            console.log(data);
            let modalBody = '';
            data.forEach((item, index) => {
                modalBody += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.name}</td>
                    <td>${item.leaveDate}</td>
                    <td>${item.detail}</td>
                    <td>${item.leaveType}</td>
                    <td>
                        <input type="text" class="form-control lafw-comment" 
                           data-id="${item.id}" 
                           placeholder="กรอกความคิดเห็น">
                    </td>
                </tr>
            `;
            });
            $('#previewModalLabel').text("ยืนยันการดำเนินการ" + (action === 'approve' ? 'อนุมัติ' : 'ไม่อนุมัติ'));
            $('#previewModalBody').html(modalBody);
            $('#previewModalAction').val(action === 'approve' ? 'อนุมัติ' : 'ไม่อนุมัติ');
            $('#previewModal').modal('show');
        }

        // // เมื่อผู้ใช้ยืนยันการดำเนินการ
        // $('#confirmAction').on('click', function () {
        //     const action = $('#previewModalAction').text() === action;
        //     const selectedIds = getSelectedIds();

        //     processApproval(selectedIds, action);
        //     $('#previewModal').modal('hide');
        // });

        $('#confirmAction').on('click', function() {
            const action = $('#previewModalAction').val();
            const selectedIds = getSelectedIds();

            // รวบรวมความคิดเห็น
            const comments = {};
            $('.lafw-comment').each(function() {
                const id = $(this).data('id');
                const comment = $(this).val();
                comments[id] = comment; // เก็บความคิดเห็นแต่ละรายการ
            });

            processApproval(selectedIds, action, comments);
            $('#previewModal').modal('hide');
        });


        // Update DataTable based on selected filters
        function updateDataTable() {
            const leaves_start_date = $('#leaves_start_date').val();
            const leaves_end_date = $('#leaves_end_date').val();
            const leaves_type = $('#leaves_type').val();
            const leaves_status = $('#leaves_status').val();
            const table = $('#leaves_table_list').DataTable(); // Ensure your table is initialized as DataTable

            if (leaves_status != 'W') {
                // Show column 0
                table.column(0).visible(false);
            } else {
                // Hide column 0
                table.column(0).visible(true);
            }
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir . "get_leaves_list_by_param"; ?>',
                type: 'POST',
                data: {
                    ps_id: '<?php echo encrypt_id($ps_id); ?>',
                    start_date: leaves_start_date,
                    end_date: leaves_end_date,
                    leave_id: leaves_type,
                    status: leaves_status
                },
                success: function(response) {
                    const data = JSON.parse(response);

                    dataTable.clear().draw();
                    $("#leaves_table_list_count").text(data.length);

                    data.forEach((item, index) => {
                        // ตรวจสอบสถานะ หากเป็น 'W' ให้แสดง Checkbox
                        const checkbox = leaves_status === 'W' ?
                            `<div class="form-check"><input type="checkbox" class="row-checkbox form-check-input" data-id="${item.lhis_id}" /> </div>` :
                            '';

                        const status = getStatusBadge(item.lafw_status);
                        const buttons = getActionButtons(item, index);

                        const button_edit = leaves_status === 'W' ? `<button class="btn btn-info" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/leaves/Leaves_approve/get_leave_form_detail/${item.lhis_id}'" 
                                            title="คลิกเพื่อดูรายละเอียด" data-bs-toggle="tooltip" data-bs-placement="top"><i class="bi bi-search"></i></button>` : '';

                        dataTable.row.add([
                            `<div class="text-center">${checkbox}</div>`,
                            `<div class="text-center">${index + 1}</div>`,
                            item.pf_name + item.ps_fname + " " + item.ps_lname,
                            item.lhis_start_date + " ถึง " + item.lhis_end_date,
                            item.lhis_topic,
                            item.leave_name,
                            `<div class="text-center">${status}</div>`,
                            `<div class="text-center">${buttons}${button_edit}</div>`
                        ]).draw();
                    });

                    $('[data-bs-toggle="tooltip"]').tooltip();
                },
                error: function() {
                    // alert('Error loading data');
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'กรุณาเลือกข้อมูลก่อนดำเนินการ'
                    });
                }
            });
        }

        function getStatusBadge(status) {
            switch (status) {
                case "Y":
                    return '<span class="badge rounded-pill bg-success">อนุมัติ</span>';
                case "N":
                    return '<span class="badge rounded-pill bg-danger">ไม่อนุมัติ</span>';
                case "W":
                    return '<span class="badge rounded-pill bg-warning">รอดำเนินการ</span>';
                default:
                    return '';
            }
        }

        function getActionButtons(item, index) {
            let button_flow = item.lafw_id ? `<a href="#" class="dropdown-item btn btn-primary" onclick="show_modal_approve_flow('${item.lhis_id}')">เส้นทางอนุมัติ</a>` : '';
            let button_file = item.lhis_attach_file ? `
            <a href="#" class="dropdown-item btn btn-primary" data-file-name="${item.lhis_attach_file}" 
            data-preview-path="<?php echo site_url($this->config->item('hr_dir') . 'Getpreview?path=' . $this->config->item('hr_upload_leaves') . '&doc='); ?>${item.lhis_attach_file}" 
            data-download-path="<?php echo site_url($this->config->item('hr_dir') . 'Getdoc?path=' . $this->config->item('hr_upload_leaves') . '&doc='); ?>${item.lhis_attach_file}&rename=${item.lhis_attach_file}"
            data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" 
            title="คลิกเพื่อดูไฟล์เอกสาร" data-toggle="tooltip" data-bs-placement="top">
            ไฟล์เอกสาร
            </a>` : '';
            let button_info = `<a href="#" class="dropdown-item btn btn-primary" onclick="window.open('<?php echo base_url() ?>index.php/hr/leaves/Leaves_report/generate_report_leaves/${item.lhis_id}', '_blank')">รายงาน</a>`;

            return `
            <div class="btn-group" role="group">
                <button id="btn_leave_${index}" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="คลิกเพื่อดูรายละเอียด" data-toggle="tooltip" data-bs-placement="top">
                    <i class="bi-file-earmark"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="btn_leave_${index}">
                    ${button_flow}
                    ${button_file}
                    ${button_info}
                </div>
            </div>
        `;
        }



        flatpickr("#leaves_start_date", {
            plugins: [
                new rangePlugin({
                    input: "#leaves_end_date"
                })
            ],
            dateFormat: 'd/m/Y',
            locale: 'th',
            defaultDate: [
                new Date(new Date().getFullYear() + 543, 0, 1),
                new Date(new Date().getFullYear() + 543, 11, 31)
            ],
            onReady: function(selectedDates, dateStr, instance) {
                addMonthNavigationListeners();
                convertYearsToThai();
            },
            onOpen: function(selectedDates, dateStr, instance) {
                convertYearsToThai();
            },
            onValueUpdate: function(selectedDates, dateStr, instance) {
                convertYearsToThai();
                if (selectedDates[0]) {
                    document.getElementById('leaves_start_date').value = formatDateToThai(selectedDates[0]);
                }
                if (selectedDates[1]) {
                    document.getElementById('leaves_end_date').value = formatDateToThai(selectedDates[1]);
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
            if (currentYear < 2500) {
                yearInput.value = currentYear + 543;
            }
        }

        function convertToThaiYearDropdown(option) {
            const year = parseInt(option.textContent);
            if (year < 2500) {
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

        updateDataTable();
    });

    function show_modal_approve_flow(lhis_id) {
        $('#leaveDetailsModal').modal('show');

        $.ajax({
            url: '<?php echo site_url() . "/" . $this->config->item('hr_dir') . $this->config->item('hr_leaves_dir') . "leaves_form/leaves_approve_flow/"; ?>' + lhis_id,
            method: 'POST',
            success: function(response) {
                $('#leaveDetailsModal .modal-body').html(response);
            },
            error: function() {
                $('#leaveDetailsModal .modal-body').html('<p>Error loading details.</p>');
            }
        });
    }
</script>