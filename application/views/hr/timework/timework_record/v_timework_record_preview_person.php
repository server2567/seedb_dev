<!-- กำหนดสไตล์ของส่วนต่าง ๆ เช่น timeline และ sidebar title -->
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
    .btn-custom {
        margin: 5px;
        padding: 10px 20px;
        border-radius: 5px;
    }
    .space-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>


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
                        <div class="card card-dashed">
                            <?php
                            if (count($person_department_topic) == 1) {
                                $head = $person_department_topic[0];
                                $row = $person_department_detail[0];
                            ?>
                                <div class="text-center mt-4">
                                    <h3 class="mb-3"><?php echo $head->dp_name_th; ?></h3>
                                </div>
                                <div class="card-body pb-2">
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
                                                                // หาก stde_name_th มีแค่ตัวเดียว
                                                                echo '<ul class="mb-0"><li>' . $position2[$stde_admin['stdp_po_id']-1] . $stde_admin['stde_name_th'][0] . '</li></ul>';
                                                            } else {
                                                                // หาก stde_name_th มีหลายตัว
                                                                echo '<ul class="mb-0"><li>' . $position[$stde_admin['stdp_po_id']] . '<br>';
                                                                $names_list = implode('<br> - ', $stde_admin['stde_name_th']);
                                                                echo '- ' . $names_list . '</li></ul>';
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo '-'; // แสดง - ถ้าไม่มีข้อมูล
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
                            <?php
                            } else {
                            ?>
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
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-hospital font-30"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">ตำแหน่งในการบริหาร</h5>
                                                        <div> <?php
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
                                                                                // หาก stde_name_th มีแค่ตัวเดียว
                                                                                echo '<ul class="mb-0"><li>' . $position2[$stde_admin['stdp_po_id'] - 1] . $stde_admin['stde_name_th'][0] . '</li></ul>';
                                                                            } else {
                                                                                // หาก stde_name_th มีหลายตัว
                                                                                echo '<ul class="mb-0"><li>' . $position[$stde_admin['stdp_po_id']] . '<br>';
                                                                                $names_list = implode('<br> - ', $stde_admin['stde_name_th']);
                                                                                echo '- ' . $names_list . '</li></ul>';
                                                                            }
                                                                        }
                                                                    }
                                                                } else {
                                                                    echo '-'; // แสดง - ถ้าไม่มีข้อมูล
                                                                }
                                                                ?></div>
                                                    </div>
                                                </div>
                                                <!-- <div class="d-flex align-items-start mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-h-square font-30"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted small mb-1">ตำแหน่งในการบริหาร</h5>
                                                        <div>
                                                            <?php
                                                            if (isset($row->admin_position) && $row->admin_position != "") {
                                                                $admin_names = [];
                                                                foreach (json_decode($row->admin_position) as $admin) {
                                                                    if (!empty($admin->admin_name)) {
                                                                        $admin_names[] = $admin->admin_name;
                                                                    }
                                                                }
                                                                if (!empty($admin_names)) {
                                                                    echo implode('<br>', $admin_names);
                                                                } else {
                                                                    echo "-";
                                                                }
                                                            } else {
                                                                echo "-";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div> -->
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
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <!-- <div class="btn-option text-center">
                            <a class="btn btn-primary" href="../Personal_dashboard/generate_CV" target="_blank"> <i class="bi-dowload"></i> Download CV </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
          
            <div class="card">
                <div class="accordion">
                    <!-- Accordion สำหรับค้นหารายชื่อบุคลากร -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-search icon-menu"></i>ค้นหารายการลงเวลาทำงาน
                            </button>
                        </h2>
                        <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <form class="row g-3" method="get">

                                    <!-- ช่วงวันที่ -->
                                    <div class="col-md-6" id="div_filter_select_date">
                                        <label for="filter_select_date" class="form-label">ช่วงวันที่</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="filter_select_date" placeholder="เลือกเวลาเริ่มต้น">
                                        </div>
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
                                <i class="bi-reception-4 icon-menu"></i><span> รายการลงเวลาทำงาน
                            </button>
                        </h2>
                            
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <!-- <div class="d-flex justify-content-end mb-2 mt-2">
                                    <button class="btn btn-secondary me-2" title="คลิกเพื่อ Print" data-bs-toggle="tooltip" data-bs-placement="top"  onclick="export_print_person('<?php echo encrypt_id($row_profile->ps_id); ?>','0')">
                                        <span><i class="bi-printer"></i> Print</span>
                                    </button>
                                    <button class="btn btn-success me-2" title="คลิกเพื่อส่งออกเอกสาร Excel" data-bs-toggle="tooltip" data-bs-placement="top"  onclick="export_excel_person('<?php echo encrypt_id($row_profile->ps_id); ?>','0')">
                                        <span><i class="bi-file-earmark-excel-fill"></i> Excel</span>
                                    </button>
                                    <button class="btn btn-danger" title="คลิกเพื่อส่งออกเอกสาร PDF" data-bs-toggle="tooltip" data-bs-placement="top"  onclick="export_pdf_person('<?php echo encrypt_id($row_profile->ps_id); ?>','0')">
                                        <span><i class="bi-file-earmark-pdf-fill"></i> PDF</span>
                                    </button>
                                </div> -->
                                <table id="timework_record_list" class="table table-striped table-bordered table-hover datatables" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="10%">#</th>
                                            <th class="text-center" width="25%">ชื่อ - นามสกุล</th>
                                            <th class="text-center" width="20%">รหัสบุคลากร</th>
                                            <th class="text-center" width="20%">รหัสจับคู่เครื่องลงเวลาทำงาน</th>
                                            <th class="text-center" width="10%">วันที่</th>
                                            <th class="text-center" width="15%">เวลา</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <!-- ข้อมูลจะถูกเติมด้วย DataTable -->
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
    document.addEventListener('DOMContentLoaded', function() {
    
        // ใช้ off เพื่อแน่ใจว่ามีการผูกเหตุการณ์เพียงครั้งเดียว
    $('#filter_select_date, #filter_select_hire_is_medical, #filter_select_hire_type, #filter_select_status_id, #filter_select_dp_id').off('change').on('change', function() {
        
        initializeDataTableTimeworkRecord();
        
    });

    // Initialize Flatpickr with date range and min/max dates
    flatpickr("#filter_select_date", {
        mode: 'range',
        dateFormat: 'd/m/Y',
        locale: 'th',
        defaultDate: [
            new Date(new Date().getFullYear() +543, new Date().getMonth(), 1), // วันแรกของเดือนปัจจุบัน
            new Date(new Date().getFullYear() +543, new Date().getMonth() + 1, 0) // วันสุดท้ายของเดือนปัจจุบัน
        ],
        onReady: function(selectedDates, dateStr, instance) {
            // addMonthNavigationListeners();
            // convertYearsToThai();
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
            
            if (selectedDates[0]) {
                document.getElementById(`filter_select_date`).value = formatDateToThai(selectedDates[0]);
            }
            if (selectedDates[1]) {
                document.getElementById(`filter_select_date`).value += ' ถึง ' + formatDateToThai(selectedDates[1]);
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    initializeDataTableTimeworkRecord();

    $('[data-bs-toggle="tooltip"]').tooltip();
});

// ฟังก์ชันแปลงปี พ.ศ. เป็น ค.ศ.
function convertToChristianYear(date_th) {
    // ตรวจสอบว่าค่า date_th ไม่เป็น undefined หรือไม่ใช่ค่าว่าง
    if (!date_th || date_th.trim() === "") {
    // console.log("Invalid date: empty or undefined");
    return null; // หรือส่งคืนค่าที่เหมาะสม เช่น null หรือ string แจ้งข้อผิดพลาด
    }

    // แยกวัน เดือน ปีจากรูปแบบวันที่ที่ส่งเข้ามา
    var parts = date_th.split('/');

    // ตรวจสอบว่า parts มี 3 ส่วน (วัน/เดือน/ปี)
    if (parts.length !== 3) {
    // console.log("Invalid date format");
    return null; // หรือส่งคืนค่าที่เหมาะสม เช่น null หรือ string แจ้งข้อผิดพลาด
    }

    var day = parts[0];
    var month = parts[1];
    var year = parseInt(parts[2]) - 543; // แปลง พ.ศ. เป็น ค.ศ.

    // ส่งคืนวันที่ในรูปแบบ ค.ศ. (YYYY-MM-DD)
    return year + '-' + month + '-' + day;
}

function initializeDataTableTimeworkRecord() {
    var date = $('#filter_select_date').val();

    // แยกวันที่เริ่มต้นและสิ้นสุด
    var dates = date.split(' ถึง ');
    var start_date_th = dates[0];
    var end_date_th = dates[1];

    // แปลง start_date และ end_date เป็นรูปแบบ Y-m-d
    var start_date = convertToChristianYear(start_date_th);
    var end_date = convertToChristianYear(end_date_th);

    $("#timework_record_list").DataTable({
        initComplete: function() {
            // ปุ่มการจัดการ
        },
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "ทั้งหมด"]
        ],
        language: {
        decimal: "",
        emptyTable: "ไม่มีรายการในระบบ",
        info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
        infoEmpty: "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
        infoFiltered: "(filtered from _MAX_ total entries)",
        infoPostFix: "",
        thousands: ",",
        lengthMenu: "_MENU_",
        loadingRecords: "Loading...",
        processing: "",
        search: "",
        searchPlaceholder: 'ค้นหา...',
        zeroRecords: "ไม่พบรายการ",
        paginate: {
            first: "«",
            last: "»",
            next: "›",
            previous: "‹"
        },
        aria: {
            orderable: "Order by this column",
            orderableReverse: "Reverse order this column"
        },
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'print',
                text: '<i class="bi-file-earmark-fill"></i> Print',
                titleAttr: 'Print',
                title: 'รายการข้อมูล'
            },
            {
                extend: 'excel',
                text: '<i class="bi-file-earmark-excel-fill"></i> Excel',
                titleAttr: 'Excel',
                title: 'รายการข้อมูล'
            },
            {
                extend: 'pdf',
                text: '<i class="bi-file-earmark-pdf-fill"></i> PDF',
                titleAttr: 'PDF',
                title: 'รายการข้อมูล',
                "customize": function (doc) {
                    doc.defaultStyle = { font: 'THSarabun' };
                }
            },
        ],
        "ordering": false,
        "columnDefs": [
            { "visible": false, "targets": [1] } // ซ่อนคอลัมน์ "ชื่อ - นามสกุล" ในการจัดกลุ่ม
        ],
        "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;

            // จัดกลุ่มโดยคอลัมน์ "ชื่อ - นามสกุล"
            api.column(1, { page: 'current' }).data().each(function(group, i) {
                // console.log(group);
                if (last !== group) {
                    // var buttonHtml = `
                    //     <button class="btn btn-danger btn-sm" style="float: right;" title="คลิกเพื่อส่งออกเอกสาร PDF" data-bs-toggle="tooltip" data-bs-placement="top"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</button>
                    //     <button class="btn btn-success btn-sm me-2" style="float: right;" title="คลิกเพื่อส่งออกเอกสาร Excel" data-bs-toggle="tooltip" data-bs-placement="top"><i class="bi bi-file-earmark-excel-fill"></i> Excel</button>
                    //     <button class="btn btn-secondary btn-sm me-2" style="float: right;" title="คลิกเพื่อ Print" data-bs-toggle="tooltip" data-bs-placement="top"><i class="bi bi-printer-fill"></i> Print</button>
                    // `;
                    
                    $(rows).eq(i).before(
                        // '<tr class="group"><td colspan="4" style="background: #e0e0e0; font-weight: bold;" style="justify-content: space-between; align-items: center;">' + group + '</td></tr>'
                        '<tr class="group"><td colspan="6" style="background: #e0e0e0">' + group + '</td></tr>'
                    );
                    last = group;
                }
            });
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        bDestroy: true, // ลบ DataTable เดิมเมื่อมีการ reinitialize ใหม่
        ajax: {
            type: "POST",
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_timework_record_by_person_id',
            data: {
                ps_id: '<?php echo $encrypt_ps_id; ?>',
                start_date: start_date,
                end_date: end_date
            },
            dataSrc: function(data) {
                var return_data = new Array();

                data.forEach(function(row, index) {
                    // console.log("row", row.pf_name + row.ps_fname);
                    var seq = index + 1;


                    var button = `
                        <div class="space-between"><b> ${row.pf_name + " " + row.ps_fname + " " + row.ps_lname} </b>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-warning btn-sm me-2" title="คลิกเพื่อแก้ไขข้อมูล" data-bs-toggle="tooltip" data-bs-placement="top" onclick="view_timework_person_record_detail('${row.twpc_ps_id}')">
                                    <i class="bi-pencil"></i>
                                </button>
                            </div>
                        </div>
                    `;

                    var button = `
                        <div class="space-between"><b> ${row.pf_name + " " + row.ps_fname + " " + row.ps_lname} </b>
                            
                        </div>
                    `;

                    // Return data to push into array
                    return_data.push({
                        "seq": seq, // ลำดับ
                        "button": button, // ปุ่มดำเนินการ
                        "twpc_ps_code": row.twpc_ps_code,
                        "twpc_mc_code": row.twpc_mc_code,
                        "twpc_date": row.twpc_date_text,
                        "twpc_time": row.twpc_time_text
                    
                    });
                });
                return return_data;
            } //end dataSrc
        }, //end ajax
        "columns": [
            {
                "data": "seq",
                className: "text-center"
            },
            { "data": "button" },
            { "data": "twpc_ps_code", className: "text-center" },
            { "data": "twpc_mc_code", className: "text-center" },
            { "data": "twpc_date", className: "text-center" },
            { "data": "twpc_time" }
        ]
    });
}



</script>