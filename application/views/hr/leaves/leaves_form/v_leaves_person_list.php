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
</style>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            <div class="section profile">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-body profile-card">
                        <div class="d-flex flex-column align-items-center">
                            <img id="profile_picture" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . ($row_profile->psd_picture != '' ? $row_profile->psd_picture : "default.png")); ?>">
                            <h2 class="mb-3 mt-4"><?php echo $row_profile->pf_name_abbr . $row_profile->ps_fname . " " . $row_profile->ps_lname; ?></h2>
                        </div>
                        <div class="card card-dashed">
                            <?php if (count($person_department_topic) == 1) {
                                $head = $person_department_topic[0];
                                $row = $person_department_detail[0];
                            ?>
                                <div class="text-center mt-4">
                                    <h3 class="mb-3"><?php echo $head->dp_name_th; ?></h3>
                                </div>
                                <div class="card-body pb-2">
                                    <!-- Personnel Details Section -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="card-icon me-3">
                                            <i class="bi-credit-card-2-front font-30"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-muted small mb-1">รหัสประจำตัวบุคลากร</h5>
                                            <div><?php echo (isset($row->pos_ps_code) ? $row->pos_ps_code : "-"); ?></div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="card-icon me-3">
                                            <i class="bi-person-square font-30"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-muted small mb-1">ประเภทบุคลากร</h5>
                                            <div><?php echo (isset($row->hire_name) ? $row->hire_name : "-"); ?></div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="card-icon me-3">
                                            <i class="bi-hospital font-30"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="text-muted small mb-1">ตำแหน่งในการบริหาร</h5>
                                            <div>
                                                <?php
                                                $position[] = '';
                                                foreach ($base_structure_position as $stpo_key => $value) {
                                                    $position[] = $value->stpo_name;
                                                    $position2[] = $value->stpo_used;
                                                }
                                                if (!empty($person_department_detail[0]->stde_admin_position)) {
                                                    foreach ($person_department_detail[0]->stde_admin_position as $key2 => $stde_admin) {
                                                        if ($stde_admin['stdp_po_id'] == 0) {
                                                            echo '<ul class="mb-0"><li>' . implode('</li><li>', $stde_admin['stde_name_th']) . '</li></ul>';
                                                        } else {
                                                            if (count($stde_admin['stde_name_th']) == 1) {
                                                                echo '<ul class="mb-0"><li>' . $position2[$stde_admin['stdp_po_id'] - 1] . $stde_admin['stde_name_th'][0] . '</li></ul>';
                                                            } else {
                                                                echo '<ul class="mb-0"><li>' . $position[$stde_admin['stdp_po_id']] . '<br>';
                                                                $names_list = implode('<br> - ', $stde_admin['stde_name_th']);
                                                                echo '- ' . $names_list . '</li></ul>';
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="card-icon me-3">
                                            <i class="bi-clipboard2-pulse font-30"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-muted small mb-1">ตำแหน่งปฏิบัติงาน</h5>
                                            <div><?php echo (isset($row->alp_name) ? $row->alp_name : "-"); ?></div>
                                        </div>
                                    </div>
                                    <?php if ($row->hire_is_medical == "M") { ?>
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="card-icon me-3">
                                                <i class="bi-journal-medical font-30"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="text-muted small mb-1">ตำแหน่งงานเฉพาะทาง</h5>
                                                <div>
                                                    <?php
                                                    if (isset($row->spcl_position) && !empty($row->spcl_position)) {
                                                        $spcl_names = [];
                                                        $spcl_positions = json_decode($row->spcl_position);
                                                        if (json_last_error() == JSON_ERROR_NONE && is_array($spcl_positions)) {
                                                            foreach ($spcl_positions as $special) {
                                                                if (!empty($special->spcl_name)) {
                                                                    $spcl_names[] = $special->spcl_name;
                                                                }
                                                            }
                                                        }
                                                        if (!empty($spcl_names)) {
                                                            echo implode(', ', $spcl_names);
                                                        } else {
                                                            echo "-";
                                                        }
                                                    } else {
                                                        echo "-";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <!-- Multiple Departments -->
                                <ul class="nav nav-pills mb-3" id="department-tab" role="tablist">
                                    <?php foreach ($person_department_topic as $key => $row) { ?>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link <?php echo ($key == 0 ? "active" : ""); ?>" id="department-<?php echo $row->dp_id; ?>-tab" data-bs-toggle="tab" data-bs-target="#department-<?php echo $row->dp_id; ?>" type="button" role="tab" aria-controls="department-<?php echo $row->dp_id; ?>" aria-selected="<?php echo ($key == 0 ? "true" : "false"); ?>">
                                                <?php echo $row->dp_name_th; ?>
                                            </button>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <div class="tab-content" id="department-tab-content">
                                    <?php foreach ($person_department_detail as $key => $row) { ?>
                                        <div class="tab-pane fade <?php echo ($key == 0 ? "show active" : ""); ?>" id="department-<?php echo $row->pos_dp_id; ?>" role="tabpanel" aria-labelledby="department-<?php echo $row->pos_dp_id; ?>-tab">
                                            <div class="card-body pb-2">
                                                <!-- Department Detail Content -->
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-credit-card-2-front font-30"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">รหัสประจำตัวบุคลากร</h5>
                                                        <div><?php echo (isset($row->pos_ps_code) ? $row->pos_ps_code : "-"); ?></div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-person-square font-30"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">ประเภทบุคลากร</h5>
                                                        <div><?php echo (isset($row->hire_name) ? $row->hire_name : "-"); ?></div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-hospital font-30"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted small mb-1">ตำแหน่งในการบริหาร</h5>
                                                        <div>
                                                            <?php
                                                            $position[] = '';
                                                            foreach ($base_structure_position as $stpo_key => $value) {
                                                                $position[] = $value->stpo_name;
                                                                $position2[] = $value->stpo_used;
                                                            }
                                                            if (!empty($person_department_detail[$key]->stde_admin_position)) {
                                                                foreach ($person_department_detail[$key]->stde_admin_position as $key2 => $stde_admin) {
                                                                    if ($stde_admin['stdp_po_id'] == 0) {
                                                                        echo '<ul class="mb-0"><li>' . implode('</li><li>', $stde_admin['stde_name_th']) . '</li></ul>';
                                                                    } else {
                                                                        if (count($stde_admin['stde_name_th']) == 1) {
                                                                            echo '<ul class="mb-0"><li>' . $position2[$stde_admin['stdp_po_id'] - 1] . $stde_admin['stde_name_th'][0] . '</li></ul>';
                                                                        } else {
                                                                            echo '<ul class="mb-0"><li>' . $position[$stde_admin['stdp_po_id']] . '<br>';
                                                                            $names_list = implode('<br> - ', $stde_admin['stde_name_th']);
                                                                            echo '- ' . $names_list . '</li></ul>';
                                                                        }
                                                                    }
                                                                }
                                                            } else {
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-clipboard2-pulse font-30"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">ตำแหน่งปฏิบัติงาน</h5>
                                                        <div><?php echo (isset($row->alp_name) ? $row->alp_name : "-"); ?></div>
                                                    </div>
                                                </div>
                                                <?php if ($row->hire_is_medical == "M") { ?>
                                                    <div class="d-flex align-items-start mb-3">
                                                        <div class="card-icon me-3">
                                                            <i class="bi-journal-medical font-30"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="text-muted small mb-1">ตำแหน่งงานเฉพาะทาง</h5>
                                                            <div>
                                                                <?php
                                                                if (isset($row->spcl_position)) {
                                                                    $spcl_names = array_map(function ($special) {
                                                                        return $special->spcl_name;
                                                                    }, json_decode($row->spcl_position));
                                                                    echo implode(', ', $spcl_names);
                                                                } else {
                                                                    echo "-";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
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
                                        <label for="leaves_status" class="form-label">สถานะการลา</label>
                                        <select class="select2" name="leaves_status" id="leaves_status">
                                            <option value="-1" disabled>-- เลือกสถานะ --</option>
                                            <option value="all" selected>ทั้งหมด</option>
                                            <option value="number"><i class="bi-circle-fill text-primary"></i> รอดำเนินการ</option>
                                            <!-- <option value="W"><i class="bi-circle-fill text-primary"></i> บันทึกฉบับร่าง</option> -->
                                            <option value="Y"><i class="bi-circle-fill text-success"></i> สิ้นสุดการอนุมัติ</option>
                                            <option value="N"><i class="bi-circle-fill text-danger"></i> ไม่อนุมัติ</option>
                                            <option value="C"><i class="bi-circle-fill text-secondary"></i> ยกเลิกการลา</option>
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
                                <i class="bi-table icon-menu"></i><span> ตารางรายการแสดงข้อมูลการลา</span><span class="badge bg-success" id="leaves_table_list_count"></span>
                            </button>
                        </h2>
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="btn-option mb-3">
                                    <button class="btn btn-primary" onclick="window.location.href='<?php echo site_url().'/'.$controller_dir.'leaves_type/'.encrypt_id($ps_id); ?>'"><i class="bi-plus"></i> ทำเรื่องการลา </button>
                                </div>
                    
                                <table class="table datatable" id="leaves_table_list" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="10%">#</th>
                                            <th class="text-center" width="20%">วันที่ลา</th>
                                            <th class="text-center" width="30%">รายละเอียดการลา</th>
                                            <th class="text-center" width="15%">ประเภทการลา</th>
                                            <th class="text-center" width="15%">สถานะการลา</th>
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


<script>

$(document).ready(function() {

    // Set default end date
    const defaultEndDate = new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()); // Set default end date as 7 days ahead
    document.getElementById('leaves_end_date').value = formatDateToThai(defaultEndDate);

    // Initial DataTable update
    updateDataTable();

     // Event listeners for select dropdowns
     $('#leaves_start_date, #leaves_end_date , #leaves_type, #leaves_status').on('change', function() {
        // Update DataTable when a select dropdown changes
        updateDataTable();
    });

    // Function to update DataTable based on select dropdown values
    function updateDataTable() {
        // Initialize DataTable
        var dataTable = $('#leaves_table_list').DataTable();

        var leaves_start_date = $('#leaves_start_date').val();
        var leaves_end_date = $('#leaves_end_date').val();
        var leaves_type = $('#leaves_type').val();
        var leaves_status = $('#leaves_status').val();
        
        // Make AJAX request to fetch updated data
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir . "get_leaves_list_by_param"; ?>',
            type: 'POST',
            data: {
                ps_id : '<?php echo encrypt_id($ps_id); ?>',
                start_date : leaves_start_date,
                end_date : leaves_end_date,
                leave_id : leaves_type,
                status : leaves_status
            },
            success: function(response) {
                data = JSON.parse(response);

                // Clear existing DataTable data
                dataTable.clear().draw();

                // // Update summary count
                $("#leaves_table_list_count").text(data.length);

                index = 1;
                data.forEach((item, index) => {
                    
                    var button = `
                        <div class="text-center option">
                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
                        </div>
                    `;

                    var status;

                    if(item.lhis_status == "C"){
                        status = '<span class="badge rounded-pill bg-secondary">ยกเลิกการลา</span>'
                    }
                    else if(item.lhis_status == "Y"){
                        status = '<span class="badge rounded-pill bg-success">สิ้นสุดการอนุมัติ</span>'
                    }
                    else if(item.lhis_status == "N"){
                        status = '<span class="badge rounded-pill bg-danger">ไม่อนุมัติ</span>'
                    }
                    else if(item.lhis_status == "W"){
                        status = '<span class="badge rounded-pill bg-primary">บันทึกฉบับร่าง</span>'
                    }
                    else {
                        status = '<span class="badge rounded-pill bg-warning">รอดำเนินการ</span>'
                    }

                    // Add new row to DataTable
                    dataTable.row.add([
                            '<div class="text-center option">' + (++index) + '</div>',
                            item.lhis_start_date + " ถึง " + item.lhis_end_date,
                            item.lhis_topic,
                            item.leave_name,
                            '<div class="text-center option">' + status + '</div>',
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
});

flatpickr("#leaves_start_date", {
    plugins: [
        new rangePlugin({
            input: "#leaves_end_date"
        })
    ],
    dateFormat: 'd/m/Y',
    locale: 'th',
    defaultDate: [
        new Date(new Date().getFullYear() + 543, 0, 1), // วันแรกของเดือนปัจจุบัน
        new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()) // วันสุดท้ายของเดือนปัจจุบัน
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
    if (currentYear < 2500) { // Convert to B.E. only if not already converted
        yearInput.value = currentYear + 543;
    }
}

function convertToThaiYearDropdown(option) {
    const year = parseInt(option.textContent);
    if (year < 2500) { // Convert to B.E. only if not already converted
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
</script>


        <!-- Main Modal -->
        <div class="modal modal-lg" id="mainModal" aria-labelledby="mainModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mainModalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="mainModalBody">
                    </div>
                    <div class="modal-footer" id="mainModalFooter">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Modal -->