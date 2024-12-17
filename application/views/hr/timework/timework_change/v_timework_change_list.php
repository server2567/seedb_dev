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
                                <i class="bi-search icon-menu"></i><span> ค้นหารายการเปลี่ยนเวลาตารางการทำงาน</span>
                            </button>
                        </h2>
                        <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                                
                                    <div class="col-md-4">
                                        <label for="twrc_date" class="form-label">ช่วงวันที่</label>
                                        <div class="input-group" id="twrc_date" name="twrc_date">
                                            <input type="text" class="form-control" name="twrc_start_date" id="twrc_start_date" value="">
                                            <span class="input-group-text">ถึง</span>
                                            <input type="text" class="form-control" name="twrc_end_date" id="twrc_end_date" value="">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <label for="twrc_type" class="form-label">ประเภทการวันทำงาน</label>
                                        <select class="select2" name="twrc_type" id="twrc_type">
                                            <option value="-1" disabled>-- เลือกประเภทการวันทำงาน --</option>
                                            <option value="all" selected>ทั้งหมด</option>
                                            <option value="1">วันทำงาน</option>
                                            <option value="0">วันหยุดประจำสัปดาห์ (OFF)</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="twrc_status" class="form-label">สถานะการดำเนินการ</label>
                                        <select class="select2" name="twrc_status" id="twrc_status">
                                            <option value="-1" disabled>-- เลือกสถานะ --</option>
                                            <option value="all" selected>ทั้งหมด</option>
                                            <option value="W">รอผู้อนุมัติดำเนินการ</option>
                                            <option value="Y">อนุมัติ</option>
                                            <option value="N">ไม่อนุมัติ</option>
                                            <option value="C">ยกเลิก</option>
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
                                <i class="bi-table icon-menu"></i><span> ตารางรายการเปลี่ยนเวลาตารางการทำงาน</span><span class="badge bg-success" id="twrc_table_list_count"></span>
                            </button>
                        </h2>
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="btn-option mb-3">
                                    <button class="btn btn-primary" onclick="window.location.href='<?php echo site_url().'/'.$controller_dir.'timework_change_insert/'.encrypt_id($ps_id); ?>'"><i class="bi-plus"></i> ทำเปลี่ยนเวลาตารางการทำงาน </button>
                                </div>
                    
                                <table class="table datatable" id="twrc_table_list" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="5%">#</th>
                                            <th class="text-center" width="20%">วันเวลาเดิม</th>
                                            <th class="text-center" width="20%">วันเวลาใหม่</th>
                                            <th class="text-center" width="20%">เหตุผลการเปลี่ยน</th>
                                            <th class="text-center" width="15%">ประเภท</th>
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
                <h5 class="modal-title">เส้นทางอนุมัติการเปลี่ยนตารางการทำงาน</h5>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded via AJAX -->
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {

    // Set default end date
    const defaultEndDate = new Date(new Date().getFullYear() + 543, 11, 31); // Set default end date as 7 days ahead
    document.getElementById('twrc_end_date').value = formatDateToThai(defaultEndDate);

    // Initial DataTable update
    updateDataTable();

     // Event listeners for select dropdowns
     $('#twrc_start_date, #twrc_end_date , #twrc_type, #twrc_status').on('change', function() {
        // Update DataTable when a select dropdown changes
        updateDataTable();
    });

    // Function to update DataTable based on select dropdown values
    function updateDataTable() {
        // Initialize DataTable
        var dataTable = $('#twrc_table_list').DataTable();

        var twrc_start_date = $('#twrc_start_date').val();
        var twrc_end_date = $('#twrc_end_date').val();
        var twrc_type = $('#twrc_type').val();
        var twrc_status = $('#twrc_status').val();
        
        // Make AJAX request to fetch updated data
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir . "get_timework_change_list_by_param"; ?>',
            type: 'POST',
            data: {
                start_date : twrc_start_date,
                end_date : twrc_end_date,
                twrc_type : twrc_type,
                status : twrc_status
            },
            success: function(response) {
                data = JSON.parse(response);

                // Clear existing DataTable data
                dataTable.clear().draw();

                // // Update summary count
                $("#twrc_table_list_count").text(data.length);

                index = 1;
                data.forEach((item, index) => {

                    
                    var status;

                    if(item.twrc_status == "C"){
                        status = '<span class="badge rounded-pill bg-secondary">ยกเลิก</span>'
                    }
                    else if(item.twrc_status == "Y"){
                        status = '<span class="badge rounded-pill bg-success">อนุมัติ</span>'
                    }
                    else if(item.twrc_status == "N"){
                        status = '<span class="badge rounded-pill bg-danger">ไม่อนุมัติ</span>'
                    }
                    else {
                        status = '<span class="badge rounded-pill bg-primary">รอผู้อนุมัติดำเนินการ</span>'
                    }
                    
                    // Display dates and times based on holiday status
                    let originalDate = item.twrc_start_date + " ถึง " + item.twrc_end_date;
                    let newDate = item.twrc_start_date + " ถึง " + item.twrc_end_date;
                    var type = "";

                    // ถ้าไม่เป็นวันหยุด (twpp_is_holiday != 1) ให้แสดงเวลาสำหรับวันที่เดิม
                    if (item.twpp_is_holiday != "1") {  
                        originalDate = item.twrc_start_date + " เวลา " + item.twrc_start_time + " น. ถึง " + item.twrc_end_date + " เวลา " + item.twrc_end_time + " น.";
                    }

                    // ถ้าไม่เป็นวันหยุด (twrc_is_holiday != 1) ให้แสดงเวลาสำหรับวันที่ใหม่
                    if (item.twrc_is_holiday != "1") {  
                        newDate = item.twrc_start_date + " เวลา " + item.twrc_start_time + " น. ถึง " + item.twrc_end_date + " เวลา " + item.twrc_end_time + " น.";
                    }

                    if(item.twrc_is_holiday == 1){
                        type = "วันทำงาน";
                    }
                    else{
                        type = "วันหยุดประจำสัปดาห์ (OFF)";
                    }

                    // Add new row to DataTable with mapped SQL columns
                    dataTable.row.add([
                        '<div class="text-center option">' + (++index) + '</div>',
                        originalDate, // วันเวลาเดิม
                        newDate, // วันเวลาใหม่
                        item.twrc_reason || '-', // เหตุผลการเปลี่ยน
                        type, // ประเภท
                        '<div class="text-center option">' + status + '</div>', // สถานะ
                        '<div class="text-center option">' + button + '</div>' // ดำเนินการ
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

flatpickr("#twrc_start_date", {
    plugins: [
        new rangePlugin({
            input: "#twrc_end_date"
        })
    ],
    dateFormat: 'd/m/Y',
    locale: 'th',
    defaultDate: [
        new Date(new Date().getFullYear() + 543, 0, 1), // วันแรกของเดือนปัจจุบัน
        new Date(new Date().getFullYear() + 543, 11, 31) // วันสุดท้ายของปีปัจจุบัน
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
            document.getElementById('twrc_start_date').value = formatDateToThai(selectedDates[0]);
        }
        if (selectedDates[1]) {
            document.getElementById('twrc_end_date').value = formatDateToThai(selectedDates[1]);
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

function show_modal_approve_flow(twrc_id) {
    // Trigger the modal to display leave details
    $('#leaveDetailsModal').modal('show');
    
    // Perform AJAX request to fetch data based on twrc_id
    $.ajax({
        url: '<?php echo site_url()."/".$controller_dir; ?>twrc_approve_flow/' + twrc_id, // Replace with your actual URL
        method: 'POST',
        success: function(response) {
            // data = JSON.parse(response);
            // Assuming `response` contains the HTML content for the modal
            $('#leaveDetailsModal .modal-body').html(response);
        },
        error: function() {
            $('#leaveDetailsModal .modal-body').html('<p>Error loading details.</p>');
        }
    });
}
</script>