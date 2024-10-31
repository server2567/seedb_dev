<!-- ลิงก์ไปยังสไตล์ชีทและไฟล์สคริปต์ -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "assets/plugins/event-calendar/event-calendar.min.css"; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "assets/plugins/event-calendar/event-calendar-global.css"; ?>">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/event-calendar/event-calendar.min.js"></script>

<!-- กำหนดสไตล์ของส่วนต่าง ๆ เช่น timeline และ sidebar title -->
<style>
    .ec-timeline .ec-time,
    .ec-timeline .ec-line {
        width: 50px;
    }

    .ec-sidebar-title {
        display: flex;
        justify-content: center;
        /* จัดกึ่งกลางในแนวนอน */
        align-items: center;
        /* จัดกึ่งกลางในแนวตั้ง */
        height: 100%;
        /* กำหนดความสูงเพื่อให้ Flexbox ทำงาน */
        text-align: center;
        /* จัดข้อความให้อยู่ตรงกลาง */
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

<input type="hidden" id="twpp_status" name="twpp_status" value="<?php echo $twpp_status; ?>">
<input type="hidden" id="twpp_ps_id" name="twpp_ps_id" value="<?php echo $ps_id; ?>">

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
                    <!-- Accordion ค้นหารายการตารางแพทย์ออกตรวจ -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-search icon-menu"></i><span> ค้นหารายการตารางแพทย์ออกตรวจ</span>
                            </button>
                        </h2>
                        <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <!-- ฟอร์มการค้นหาแบบฟิลเตอร์ -->
                                <form class="row g-3" method="get">
                                    <!-- หน่วยงาน -->
                                    <div class="col-md-6">
                                        <label for="fillter_select_dp_id" class="form-label">หน่วยงาน</label>
                                        <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="fillter_select_dp_id" id="fillter_select_dp_id">
                                            <?php foreach ($person_department_topic as $key => $row) { ?>
                                                <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <!-- ประเภทตารางแพทย์ออกตรวจ -->
                                    <div class="col-md-6" id="div_filter_select_public">
                                        <label for="filter_select_public" class="form-label">ประเภทตารางแพทย์ออกตรวจ</label>
                                        <select class="form-select select2" id="filter_select_public" name="filter_select_public">
                                            <option value="0" selected>ตารางแพทย์ออกตรวจภายใน (In)</option>
                                            <option value="1">ตารางแพทย์ออกตรวจภายนอก (Public)</option>
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
                                <i class="bi-calendar-plus icon-menu font-26"></i>จัดการตารางแพทย์ออกตรวจภายใน<span class="summary_nornal_work_list badge bg-success ms-2"></span>
                            </button>
                        </h2>
                        <div class="d-flex justify-content-end mb-2 mt-2 me-4 ms-4">
                            <button class="btn btn-secondary me-2" title="คลิกเพื่อ Print" data-bs-toggle="tooltip" data-bs-placement="top" onclick="export_print_person('<?php echo encrypt_id($row_profile->ps_id); ?>')">
                                <span><i class="bi-printer"></i> Print</span>
                            </button>
                            <button class="btn btn-success me-2" title="คลิกเพื่อส่งออกเอกสาร Excel" data-bs-toggle="tooltip" data-bs-placement="top" onclick="export_excel_person('<?php echo encrypt_id($row_profile->ps_id); ?>')">
                                <span><i class="bi-file-earmark-excel-fill"></i> Excel</span>
                            </button>
                            <button class="btn btn-danger" title="คลิกเพื่อส่งออกเอกสาร PDF" data-bs-toggle="tooltip" data-bs-placement="top" onclick="export_pdf_person('<?php echo encrypt_id($row_profile->ps_id); ?>')">
                                <span><i class="bi-file-earmark-pdf-fill"></i> PDF</span>
                            </button>
                        </div>
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <!-- พื้นที่สำหรับปฏิทิน -->
                                <div id="event_calendar"></div>
                                <div class="d-flex justify-content-end align-items-end mt-3" style="height: 100%;">
                                    <button class="btn btn-success" id="button_confirm_timework_calendar" title="คลิกเพื่อยืนยันข้อมูล" data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#modal_confirm_timework_calendar">
                                        <i class="bi-check-circle"></i> ยืนยันข้อมูลตารางแพทย์ออกตรวจ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script type="text/javascript">
    const twpp_status = document.getElementById('twpp_status').value;
    const twpp_ps_id = document.getElementById('twpp_ps_id').value;
    var twpp_dp_id = <?php echo $dp_id; ?>;
    var isPublic = 0;

    var filter_start_date = '';
    var filter_end_date = '';

    const firstDayCurrentMonth = new Date('<?php echo date("Y-m-01", strtotime($timework_date_open)); ?>');
    const lastDayCurrentMonth = new Date('<?php echo date("Y-m-t", strtotime($timework_date_open)); ?>');
    const firstDayBeforeMonth = new Date('<?php echo date("Y-m-01", strtotime("-1 month", strtotime($timework_date_open))); ?>');

    let selectedEvent = null; // To store the currently selected event
    var event_calendar;
    var event_calendar_public;
    var default_show = 0;

    document.addEventListener('DOMContentLoaded', function() {
        get_eqs_building_list();
        initializeCalendar(); // Initialize the calendar

        if (default_show == 1) {
            $('#fillter_select_dp_id, #filter_select_public').on('change', function() {
                get_eqs_building_list();
                event_calendar.destroy();
                initializeCalendar();
            });
        }

        // Apply the function to both add and edit room selectors
        handleRoomSelect('#checkbox_add_rm_id', '#add_rm_id');
        handleRoomSelect('#checkbox_edit_rm_id', '#edit_rm_id');


        // จับเหตุการณ์การเปลี่ยนแท็บ
        document.querySelectorAll('.btn-tabTimework').forEach(function(tabButton) {
            tabButton.addEventListener('shown.bs.tab', function(event) {

                // ตรวจสอบแท็บที่ active
                if (event.target.id === "normal-work-tab") {
                    // แท็บ normal-work-tab active -> ทำให้ checkbox_add_is_public ถูกเลือก
                    document.getElementById("checkbox_add_is_public").checked = false;
                } else if (event.target.id === "public-work-tab") {
                    // แท็บ public-work-tab active -> ทำให้ checkbox_edit_is_public ถูกเลือก
                    document.getElementById("checkbox_add_is_public").checked = true;
                }
            });
        });


    });


    function initializeCalendar() {

        event_calendar = new EventCalendar(document.getElementById('event_calendar'), {
            view: 'dayGridMonth',
            locale: 'th',
            date: new Date('<?php echo $timework_date_open; ?>'), // Set a specific date
            headerToolbar: {
                start: 'prev,next today',
                center: 'title',
                end: 'dayGridMonth,listMonth'
            },
            buttonText: {
                today: 'วันนี้',
                dayGridMonth: 'ปฏิทิน',
                listMonth: "รายการ"
            },
            resources: getResources(),
            events: getEvents(),
            dayMaxEvents: true,
            nowIndicator: true,
            selectable: true,
            dateClick: handleDateClick,
            select: handleSelect,
            eventClick: handleEventClick,
            eventDrop: handleEventDrop,
            eventResize: handleEventResize,
            // ฟังก์ชันเพื่ออัปเดตวันที่เริ่มต้นและสิ้นสุดของเดือนที่แสดง
            datesSet: function(info) {
                // คำนวณวันที่ 1 ของเดือนที่แสดงในปฏิทินโดยตรงจากปีและเดือนของ info.view.currentStart
                var currentMonthYear = info.view.currentStart;
                var firstDayOfMonth = new Date(currentMonthYear.getFullYear(), currentMonthYear.getMonth(), 1);

                // คำนวณวันสุดท้ายของเดือนที่แสดงในปฏิทิน
                var lastDayOfMonth = new Date(currentMonthYear.getFullYear(), currentMonthYear.getMonth() + 1, 0);

                // ใช้ toLocaleDateString เพื่อแสดงวันที่ในรูปแบบ YYYY-MM-DD
                filter_start_date = firstDayOfMonth.toLocaleDateString('en-CA'); // วันที่ 1 ของเดือน
                filter_end_date = lastDayOfMonth.toLocaleDateString('en-CA'); // วันสุดท้ายของเดือน

                // ตรวจสอบว่าค่า timework_date_open อยู่ในช่วง filter_start_date และ filter_end_date
                if (new Date('<?php echo $timework_date_open; ?>') <= new Date(lastDayCurrentMonth) && new Date('<?php echo $timework_date_open; ?>') >= new Date(firstDayBeforeMonth)) {
                    // แสดง ec-container ด้วยเอฟเฟกต์ fade
                    $("#event_calendar .ec-header").fadeIn(300); // เอฟเฟกต์เฟดเข้าที่ใช้เวลา 300ms
                    $("#event_calendar .ec-body").fadeIn(300); // เอฟเฟกต์เฟดเข้าที่ใช้เวลา 300ms
                    $("#button_confirm_timework_calendar").fadeIn(300);
                } else {
                    // ซ่อน ec-container ด้วยเอฟเฟกต์ fade
                    $("#event_calendar .ec-header").fadeOut(300); // เอฟเฟกต์เฟดออกที่ใช้เวลา 300ms
                    $("#event_calendar .ec-body").fadeOut(300); // เอฟเฟกต์เฟดออกที่ใช้เวลา 300ms
                    $("#button_confirm_timework_calendar").fadeOut(300);
                }

            }
        });

        $('#add_plan_ps_id').val(twpp_ps_id);
        $('#edit_plan_ps_id').val(twpp_ps_id);
    }

    function getResources() {
        return [{
            id: <?php echo $row_profile->ps_id; ?>,
            title: '<?php echo $row_profile->pf_name_abbr . $row_profile->ps_fname . " " . $row_profile->ps_lname; ?>'
        }];
    }

    // ฟังก์ชันเพื่อดึงข้อมูลเหตุการณ์ในปฏิทิน
    function getEvents() {

        var result = [];

        // AJAX เพื่อดึงข้อมูลเหตุการณ์
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_timework_plan_person_id',
            type: 'GET',
            async: false,
            data: {
                dp_id: twpp_dp_id,
                twpp_status: twpp_status,
                ps_id: '<?php echo $encrypt_ps_id; ?>',
                isPublic: isPublic,
                actor_type: '<?php echo $actor_type; ?>',
                timework_date_open: '<?php echo $timework_date_open; ?>'
            },
            success: function(data) {
                data = JSON.parse(data);

                // map ข้อมูลเหตุการณ์ในรูปแบบที่ FullCalendar ใช้งานได้
                result = data.flatMap(function(group) {
                    return group.map(function(row) {
                        return {
                            id: row.twpp_id,
                            start: `${row.twpp_start_date} ${row.twpp_start_time}`,
                            end: `${row.twpp_end_date} ${row.twpp_end_time}`,
                            resourceId: row.twpp_ps_id,
                            title: `(${row.twac_name_th}) ${row.rm_name ? row.rm_name : ''}`,
                            color: row.twac_color,
                            extendedProps: {
                                twpp_rm_id: row.twpp_rm_id,
                                twpp_dp_id: row.twpp_dp_id,
                                twac_id: row.twpp_twac_id,
                                twpp_desc: row.twpp_desc,
                                twpp_status: row.twpp_status,
                                twpp_is_public: row.twpp_is_public
                            }
                        };
                    });
                });
            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
        return result;
    }

    function export_print_person(ps_id) {
        // เปิดหน้าต่างใหม่เพื่อส่งออกข้อมูล
        window.open('<?php echo site_url($controller_dir . 'export_print_timework_calendar'); ?>/' + ps_id + '/' + isPublic + '/medical' + '/' + twpp_dp_id + "/" + filter_start_date + "/" + filter_end_date, '_blank');
    }

    function export_excel_person(ps_id) {
        // เปิดหน้าต่างใหม่เพื่อส่งออกข้อมูล
        window.open('<?php echo site_url($controller_dir . 'export_excel_timework_calendar'); ?>/' + ps_id + '/' + isPublic + '/medical' + '/' + twpp_dp_id + "/" + filter_start_date + "/" + filter_end_date, '_blank');
    }

    function export_pdf_person(ps_id) {
        // เปิดหน้าต่างใหม่เพื่อส่งออกข้อมูล
        window.open('<?php echo site_url($controller_dir . 'export_pdf_timework_calendar'); ?>/' + ps_id + '/' + isPublic + '/medical' + '/' + twpp_dp_id + "/" + filter_start_date + "/" + filter_end_date, '_blank');
    }


    // ฟังก์ชันสำหรับจัดการการเปิด/ปิดใช้งาน select ห้อง และการเพิ่ม/ลบตัวเลือก "ไม่ระบุ"
    function handleRoomSelect(checkboxSelector, selectSelector) {
        $(checkboxSelector).on('change', function() {
            const roomSelect = $(selectSelector);
            if (this.checked) {
                // ปิดการใช้งาน select และเพิ่มตัวเลือก "ไม่ระบุ"
                roomSelect.prop('disabled', true);

                // ตรวจสอบว่าตัวเลือก "ไม่ระบุ" มีอยู่แล้วหรือไม่ เพื่อป้องกันการเพิ่มซ้ำ
                if (roomSelect.find('option[value="0"]').length === 0) {
                    roomSelect.append('<option value="0">ไม่ระบุ</option>');
                }

                roomSelect.val('0'); // เลือกตัวเลือก "ไม่ระบุ"
            } else {
                // เปิดการใช้งาน select และลบตัวเลือก "ไม่ระบุ"
                roomSelect.prop('disabled', false);
                roomSelect.find('option[value="0"]').remove();
            }
        });
    }

    // ฟังก์ชันจัดการคลิกวันที่ในปฏิทิน
    function handleDateClick(info) {

        // บันทึกวันที่ที่ถูกคลิก
        const selectedStartDate = new Date(info.dateStr);

        // ตรวจสอบวันที่ย้อนหลังก่อนแสดง modal
        // if (selectedStartDate < firstDayCurrentMonth) {
        //     dialog_error({
        //         'header': text_toast_default_error_header,
        //         'body': 'ไม่สามารถจัดการข้อมูลย้อนหลังได้'
        //     });
        //     return;
        // }

        // // ตรวจสอบวันที่ล่วงหน้าก่อนแสดง modal
        // if (selectedStartDate > lastDayCurrentMonth) {
        //     dialog_error({
        //         'header': text_toast_default_error_header,
        //         'body': 'ไม่สามารถจัดการข้อมูลล่วงหน้ามากกว่า 2 เดือนได้'
        //     });
        //     return;
        // }

        // เซ็ตค่าดีฟอลต์ใน modal ตามวันที่ที่ถูกคลิก
        const clickedDate = new Date(info.dateStr);
        const startDate = formatDateToBuddhist(clickedDate);
        // const endDate = formatDateToBuddhist(new Date(clickedDate.getTime() + 60 * 60 * 1000 * 24)); // 1 day later
        const endDate = formatDateToBuddhist(new Date(clickedDate));

        document.getElementById('add_plan_desc').value = '';
        document.getElementById('add_plan_date').value = `${startDate} ถึง ${endDate}`;

        // ตรวจสอบว่าค่า twpp_is_public เท่ากับ 0 หรือไม่
        if (isPublic == 0) {
            $('#checkbox_add_is_public').prop('checked', false); // Uncheck the checkbox

        } else {
            $('#checkbox_add_is_public').prop('checked', true); // Check the checkbox
        }


        get_timework_attendance_config_list(twpp_ps_id);

        setDefaultDate('add', startDate, endDate);
        $('#addEventModal').modal('show');
    }

    // ฟังก์ชันจัดการการเลือกช่วงเวลาในปฏิทิน
    function handleSelect(info) {

        const selectedStartDate = new Date(info.start);
        const selectedEndDate = new Date(info.end);

        // ตรวจสอบว่าช่วงเวลาที่เลือกอยู่ในเดือนย้อนหลังหรือไม่
        // if (selectedEndDate < firstDayCurrentMonth) {
        //     // หากวันที่สิ้นสุดการเลือกน้อยกว่าวันแรกของเดือนปัจจุบัน (แปลว่าย้อนหลัง)
        //     dialog_error({
        //         'header': text_toast_default_error_header,
        //         'body': 'ไม่สามารถจัดการข้อมูลย้อนหลังได้'
        //     });
        //     return;
        // }

        // // ตรวจสอบว่าช่วงเวลาที่เลือกเลยเดือนปัจจุบันหรือไม่
        // if (selectedStartDate > lastDayCurrentMonth) {
        //     dialog_error({
        //         'header': text_toast_default_error_header,
        //         'body': 'ไม่สามารถจัดการข้อมูลล่วงหน้ามากกว่า 2 เดือนได้'
        //     });
        //     return;
        // }

        // เซ็ตค่าดีฟอลต์ใน modal ตามวันที่ที่ถูกคลิก
        const startDate = formatDateToBuddhist(info.start);
        // const endDate = formatDateToBuddhist(info.end);
        const endDate = formatDateToBuddhist(new Date(info.end.getTime() - 60 * 60 * 1000 * 24)); // 1 day later

        document.getElementById('add_plan_desc').value = '';
        document.getElementById('add_plan_date').value = `${startDate} ถึง ${endDate}`;

        // ตรวจสอบว่าค่า twpp_is_public เท่ากับ 0 หรือไม่
        if (isPublic == 0) {
            $('#checkbox_add_is_public').prop('checked', false); // Uncheck the checkbox

        } else {
            $('#checkbox_add_is_public').prop('checked', true); // Check the checkbox
        }

        get_timework_attendance_config_list(twpp_ps_id);

        setDefaultDate('add', startDate, endDate);
        $('#addEventModal').modal('show');
    }

    // ฟังก์ชันจัดการคลิกเหตุการณ์
    function handleEventClick(info) {
        selectedEvent = info.event;
        const selectedStartDate = new Date(selectedEvent.start);

        // ตรวจสอบว่ามีข้อมูลที่จำเป็นครบถ้วนหรือไม่
        // if (selectedStartDate < firstDayCurrentMonth) {
        //     dialog_error({
        //         'header': text_toast_default_error_header,
        //         'body': 'ไม่สามารถจัดการข้อมูลย้อนหลังได้'
        //     });
        //     return;
        // }

        // เซ็ตค่าเริ่มต้นใน modal จากเหตุการณ์ที่ถูกคลิก
        const startDate = selectedEvent.start ? formatDateToBuddhist(new Date(selectedEvent.start)) : '';
        const startTime = selectedEvent.start ? formatTime(new Date(selectedEvent.start)) : '';
        const endDate = selectedEvent.end ? formatDateToBuddhist(new Date(selectedEvent.end)) : startDate;
        const endTime = selectedEvent.end ? formatTime(new Date(selectedEvent.end)) : startTime;

        var [twac_id, twac_start_time, twac_end_time, twac_name_th, twac_color] = selectedEvent.extendedProps.twac_id.split('<>'); // แยกด้วยตัวขีด '-'

        // เซ็ตค่าช่วงเวลา
        document.getElementById('edit_plan_start_time').value = startTime;
        document.getElementById('edit_plan_end_time').value = endTime;
        document.getElementById('edit_plan_date').value = `${startDate} ถึง ${endDate}`;
        document.getElementById('edit_twac_id').value = twac_id;
        document.getElementById('edit_plan_desc').value = selectedEvent.extendedProps.twpp_desc;
        document.getElementById('edit_twpp_id').value = selectedEvent.id;
        document.getElementById('edit_dp_id').value = selectedEvent.extendedProps.twpp_dp_id;

        // ตรวจสอบว่าค่า twpp_rm_id เท่ากับ 0 หรือไม่
        if (selectedEvent.extendedProps.twpp_rm_id == 0) {
            // ถ้า twpp_rm_id เป็น 0 ให้ติ๊กถูก checkbox และเพิ่มตัวเลือก "ไม่ระบุ" ใน select
            $('#checkbox_edit_rm_id').prop('checked', true); // Check the checkbox

            const roomSelect = $('#edit_rm_id');
            // ตรวจสอบว่ามีตัวเลือก "ไม่ระบุ" อยู่หรือไม่ ถ้าไม่มีก็เพิ่มเข้าไป
            if (roomSelect.find('option[value="0"]').length === 0) {
                roomSelect.append('<option value="0">ไม่ระบุ</option>');
            }

            // เซ็ตค่า select ให้เป็น "0"
            roomSelect.val('0').trigger('change');
            // ปิดการใช้งาน select เนื่องจาก checkbox ถูกติ๊ก
            roomSelect.prop('disabled', true);
        } else {
            // ถ้า twpp_rm_id ไม่ใช่ 0 ให้ยกเลิกการติ๊ก checkbox และเซ็ตค่าให้ select ตาม twpp_rm_id
            $('#checkbox_edit_rm_id').prop('checked', false); // Uncheck the checkbox

            const roomSelect = $('#edit_rm_id');
            // ลบตัวเลือก "ไม่ระบุ" ถ้ามี
            roomSelect.find('option[value="0"]').remove();

            // เซ็ตค่า select ให้เป็นค่า twpp_rm_id ที่ได้จาก selectedEvent
            roomSelect.val(selectedEvent.extendedProps.twpp_rm_id).trigger('change');
            // เปิดการใช้งาน select
            roomSelect.prop('disabled', false);
        }

        // ตรวจสอบว่าค่า twpp_is_public เท่ากับ 0 หรือไม่
        if (selectedEvent.extendedProps.twpp_is_public == 0) {
            $('#checkbox_edit_is_public').prop('checked', false); // Uncheck the checkbox

        } else {
            $('#checkbox_edit_is_public').prop('checked', true); // Check the checkbox
        }

        setDefaultDate('edit', startDate, endDate);

        document.getElementById('saveChangesButton').onclick = saveEventChanges;
        document.getElementById('deleteEventButton').onclick = deleteEvent;

        get_timework_attendance_config_list(selectedEvent.resourceIds[0], selectedEvent.extendedProps.twac_id);

        $('#editEventModal').modal('show');
    }


    // ฟังก์ชันจัดการการลากเหตุการณ์
    function handleEventDrop(info) {
        const event = info.event;
        const selectedStartDate = new Date(event.start);

        // ตรวจสอบว่ามีข้อมูลที่จำเป็นครบถ้วนหรือไม่
        if (!event) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'ไม่สามารถจัดการการลากข้อมูลได้ กรุณาลองใหม่อีกครั้ง'
            });
            return;
        }

        // ตรวจสอบว่ามีข้อมูลที่จำเป็นครบถ้วนหรือไม่
        // if (selectedStartDate < firstDayCurrentMonth) {
        //     dialog_error({
        //         'header': text_toast_default_error_header,
        //         'body': 'ไม่สามารถจัดการข้อมูลย้อนหลังได้'
        //     });
        //     return;
        // }

        // ดึงข้อมูลจาก info (ข้อมูลใหม่ที่ได้หลังจากลาก)
        const new_ps_id = info.newResource ? info.newResource.id : event.resourceIds[0]; // รายชื่อบุคลากรใหม่ (หรือใช้ resource เดิม)
        const select_twpp_id = event.id; // ID ของแผนงาน
        const edit_twac_id = event.extendedProps.twac_id; // รูปแบบการลงเวลาทำงาน
        const edit_desc = event.extendedProps.twpp_desc || ""; // รายละเอียดเพิ่มเติม
        const twpp_status = event.extendedProps.twpp_status; // สถานะการทำงาน
        const edit_dp_id = event.extendedProps.twpp_dp_id; // หน่วยงาน (ดึงจากข้อมูลเพิ่มเติมของ event หรือ DOM)
        const edit_rm_id = event.extendedProps.twpp_rm_id; // ห้อง/สถานที่ (ดึงจากข้อมูลเพิ่มเติมของ event หรือ DOM)
        const edit_is_public = event.extendedProps.twpp_is_public; // แสดงข้อมูลต่อสาธารณะ (ดึงจากข้อมูลเพิ่มเติมของ event หรือ DOM)

        // เวลาเริ่มต้นและเวลาสิ้นสุดใหม่หลังจากลาก
        const startDateTime = formatDateTime(info.event.start); // ใช้ฟังก์ชันช่วยในการแปลงวันที่และเวลา
        const endDateTime = info.event.end ? formatDateTime(info.event.end) : startDateTime; // ถ้าไม่มีเวลา end, ใช้ start แทน

        // ตรวจสอบว่ามีข้อมูลที่จำเป็นครบถ้วนหรือไม่
        if (!new_ps_id || !startDateTime || !endDateTime || !edit_twac_id) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'ไม่สามารถกำหนดข้อมูลได้ครบถ้วน'
            });
            return;
        }

        // ส่งข้อมูลผ่าน AJAX เพื่ออัปเดตข้อมูลการแก้ไข
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>timework_calendar_save',
            type: 'POST',
            async: false, // ทำให้เป็น synchronous (ไม่แนะนำในบางกรณีที่ข้อมูลมีขนาดใหญ่หรือการเชื่อมต่อช้า)
            data: {
                twpp_id: select_twpp_id, // ID ของแผนงานที่ถูกแก้ไข
                twpp_ps_id: new_ps_id, // รายชื่อบุคลากร
                twpp_twac_id: edit_twac_id, // รูปแบบการลงเวลาทำงาน
                twpp_desc: edit_desc, // รายละเอียดเพิ่มเติม
                twpp_start_date: startDateTime, // วันเริ่มต้นพร้อมเวลา
                twpp_end_date: endDateTime, // วันสิ้นสุดพร้อมเวลา
                twpp_dp_id: edit_dp_id, // หน่วยงาน
                twpp_rm_id: edit_rm_id, // ห้อง/สถานที่
                twpp_status: twpp_status, // สถานะการทำงาน,
                twpp_is_public: edit_is_public
            },
            success: function(data) {
                // ตรวจสอบ response จากเซิร์ฟเวอร์
                data = JSON.parse(data);

                if (data.status_response == status_response_success) {
                    // อัพเดท resourceId ของเหตุการณ์
                    event.resourceIds = [new_ps_id];
                } else {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                }
            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล'
                });
                getEvents();
            }
        });
    }


    // ฟังก์ชันจัดการการปรับขนาดเหตุการณ์
    function handleEventResize(info) {
        const event = info.event;
        const selectedStartDate = new Date(event.start);

        // ตรวจสอบว่ามีข้อมูลที่จำเป็นครบถ้วนหรือไม่
        // if (new Date(selectedStartDate) < firstDayCurrentMonth) {
        //     dialog_error({
        //         'header': text_toast_default_error_header,
        //         'body': 'ไม่สามารถจัดการข้อมูลย้อนหลังได้'
        //     });
        //     return;
        // }

        var [twac_id, twac_start_time, twac_end_time, twac_name_th, twac_color] = event.extendedProps.twac_id.split('<>'); // แยกด้วยตัวขีด '-'

        const startDateTime = formatDateTime(info.event.start); // ใช้ฟังก์ชันช่วยในการแปลงวันที่และเวลา
        const endDateTime = info.event.end ? formatDateTime(info.event.end) : startDateTime; // ถ้าไม่มีเวลา end, ใช้ start แทน

        // ดึงข้อมูลจาก info (ข้อมูลใหม่ที่ได้หลังจากลาก)
        const ps_id = info.newResource ? info.newResource.id : event.resourceIds[0]; // รายชื่อบุคลากรใหม่ (หรือใช้ resource เดิม)
        const select_twpp_id = event.id; // ID ของแผนงาน
        const edit_twac_id = twac_id; // รูปแบบการลงเวลาทำงาน
        const edit_desc = event.extendedProps.twpp_desc; // รายละเอียดเพิ่มเติม
        const edit_dp_id = event.extendedProps.twpp_dp_id; // หน่วยงาน (ดึงจากข้อมูลเพิ่มเติมของ event หรือ DOM)
        const edit_rm_id = event.extendedProps.twpp_rm_id; // ห้อง/สถานที่ (ดึงจากข้อมูลเพิ่มเติมของ event หรือ DOM)
        const twpp_status = event.extendedProps.twpp_status; // สถานะการทำงาน
        const edit_is_public = event.extendedProps.twpp_is_public; // แสดงข้อมูลต่อสาธารณะ (ดึงจากข้อมูลเพิ่มเติมของ event หรือ DOM)

        // console.log("event", event);
        // console.log("event.extendedProps", event.extendedProps);
        // console.log(edit_twac_id);
        // ตรวจสอบว่ามีข้อมูลที่จำเป็นครบถ้วนหรือไม่
        if (!ps_id || !startDateTime || !endDateTime || !edit_twac_id) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'ไม่สามารถกำหนดข้อมูลได้ครบถ้วน'
            });
            return;
        }

        // ส่งข้อมูลผ่าน AJAX เพื่ออัปเดตข้อมูลการแก้ไข
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>timework_calendar_save',
            type: 'POST',
            async: false, // ทำให้เป็น synchronous (ไม่แนะนำในบางกรณีที่ข้อมูลมีขนาดใหญ่หรือการเชื่อมต่อช้า)
            data: {
                twpp_id: select_twpp_id, // ID ของแผนงานที่ถูกแก้ไข
                twpp_ps_id: ps_id, // รายชื่อบุคลากร
                twpp_twac_id: edit_twac_id, // รูปแบบการลงเวลาทำงาน
                twpp_desc: edit_desc, // รายละเอียดเพิ่มเติม
                twpp_start_date: startDateTime, // วันเริ่มต้นพร้อมเวลา
                twpp_end_date: endDateTime, // วันสิ้นสุดพร้อมเวลา
                twpp_dp_id: edit_dp_id, // หน่วยงาน
                twpp_rm_id: edit_rm_id, // ห้อง/สถานที่
                twpp_status: twpp_status, // สถานะการทำงาน,
                twpp_is_public: edit_is_public
            },
            success: function(data) {
                // ตรวจสอบ response จากเซิร์ฟเวอร์
                data = JSON.parse(data);

                if (data.status_response == status_response_success) {
                    info.event.start = startDateTime;
                    info.event.end = endDateTime;
                } else {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                }
            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล'
                });
                getEvents();
            }
        });


    }

    // ฟังก์ชันลบเหตุการณ์
    function deleteEvent() {

        const selectedStartDate = new Date(selectedEvent.start);

        // ตรวจสอบว่ามีข้อมูลที่จำเป็นครบถ้วนหรือไม่
        // if (selectedStartDate < firstDayCurrentMonth) {
        //     dialog_error({
        //         'header': text_toast_default_error_header,
        //         'body': 'ไม่สามารถจัดการข้อมูลย้อนหลังได้'
        //     });
        //     return;
        // }

        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>timework_calendar_delete',
            type: 'POST',
            async: false, // Make the request synchronous (not recommended for large data or slow connections)
            data: {
                twpp_id: selectedEvent.id // ID ของแผนงานที่ถูกลบ
            },
            success: function(data) {
                // Parse the returned data
                data = JSON.parse(data);

                if (data.status_response == status_response_success) {
                    event_calendar.removeEventById(selectedEvent.id);
                } else {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                }
                $('#editEventModal').modal('hide');

            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }

    function setDefaultDate(type, startDate = null, endDate = null) {
        const currentDate = new Date();

        // If startDate is provided as a string, convert it to a Date object
        if (startDate && typeof startDate === 'string') {
            startDate = parseDateString(startDate); // Parses Thai Buddhist year correctly
        }

        // If endDate is provided as a string, convert it to a Date object
        if (endDate && typeof endDate === 'string') {
            endDate = parseDateString(endDate); // Parses Thai Buddhist year correctly
        }

        // Default to the first and last day of the current month if dates are not provided
        if (!startDate || isNaN(startDate.getTime())) {
            startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        }

        if (!endDate || isNaN(endDate.getTime())) {
            endDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
        }

        // Calculate the first day and the last day of the month for the provided startDate
        const firstDayOfMonth = new Date(startDate.getFullYear(), startDate.getMonth(), 1);
        const lastDayOfMonth = new Date(startDate.getFullYear(), startDate.getMonth() + 1, 0);

        // Convert dates to string format for display
        const startDateString = formatDateToBuddhist(startDate);
        const endDateString = formatDateToBuddhist(endDate);

        // Initialize Flatpickr with date range and min/max dates
        flatpickr(`#${type}_plan_date`, {
            mode: 'range',
            dateFormat: 'd/m/Y',
            locale: 'th',
            defaultDate: [startDateString, endDateString],
            minDate: formatDateToStringDefault(firstDayOfMonth), // Set minDate to the first day of the startDate's month
            maxDate: formatDateToStringDefault(lastDayOfMonth), // Set maxDate to the last day of the startDate's month
            onReady: convertYearsToThai,
            onOpen: convertYearsToThai,
            onValueUpdate: (selectedDates) => {

                convertYearsToThai();
                // Convert selectedDates to the desired format for display
                if (selectedDates[0]) {
                    document.getElementById(`${type}_plan_date`).value = formatDateToStringTH(new Date(selectedDates[0]));
                }
                if (selectedDates[1]) {
                    document.getElementById(`${type}_plan_date`).value += ' ถึง ' + formatDateToStringTH(new Date(selectedDates[1]));
                }
            },
            onMonthChange: convertYearsToThai,
            onYearChange: convertYearsToThai
        });
    }

    // Function to get the timework attendance config list and populate the select
    function get_timework_attendance_config_list(ps_id, twac_id = "") {

        var count_list = 0;
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_timework_attendance_config_list',
            type: 'GET',
            data: {
                ps_id: twpp_ps_id,
                dp_id: twpp_dp_id
            },
            success: function(data) {
                // Parse the returned data
                data = JSON.parse(data);

                // Clear old options (ใช้ class แทน id)
                $('.twac-select').empty();
                count_list = data.length;
                // Populate options and make the first one selected
                data.forEach(function(row, index) {
                    var name_th = row.twac_name_th + (row.twac_name_abbr_th ? " (" + row.twac_name_abbr_th + ")" : "");
                    const selected = index === 0 || twac_id == row.twac_id ? 'selected' : ''; // select the first option
                    const option = `<option value="${row.twac_id}<>${row.twac_start_time}<>${row.twac_end_time}<>${row.twac_name_th}<>${row.twac_color}" ${selected}>${name_th}</option>`;

                    // Initialize flatpickr for start and end time for the first option
                    if (index == 0) {
                        flatpickr(`#add_plan_start_time`, {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                            time_24hr: true,
                            defaultDate: row.twac_start_time
                        });

                        flatpickr(`#add_plan_end_time`, {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                            time_24hr: true,
                            defaultDate: row.twac_end_time
                        });
                    }

                    // Append option to both add and edit select elements
                    $('.twac-select').append(option);
                });

                // Trigger the change event to load time configs (if needed)
                $('#add_twac_id').trigger('change');
                $('#edit_twac_id').trigger('change');
            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });

        return count_list;
    }

    function get_time_attendance_config(value, type) {
        // แยกค่าจาก value ที่ส่งเข้ามา
        const [twac_id, twac_start_time, twac_end_time, twac_name_th] = value.split('<>'); // แยกด้วยตัวขีด '-'

        // Initialize flatpickr for start time
        flatpickr(`#${type}_plan_start_time`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: twac_start_time // ตั้งค่าเวลาเริ่มต้นจากข้อมูลที่ส่งเข้ามา
        });

        // Initialize flatpickr for end time
        flatpickr(`#${type}_plan_end_time`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: twac_end_time // ตั้งค่าเวลาสิ้นสุดจากข้อมูลที่ส่งเข้ามา
        });
    }


    // Function to get the building list and populate the select
    function get_eqs_building_list() {
        default_show = 1;
        var fillter_dp_id = $('#fillter_select_dp_id').val();
        var filter_public = $('#filter_select_public').val();
        twpp_dp_id = fillter_dp_id;
        isPublic = filter_public;
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_eqs_building_list',
            data: {
                dp_id: fillter_dp_id
            },
            type: 'GET',
            success: function(data) {
                // Parse the returned data
                data = JSON.parse(data);

                // Clear old options (โดยใช้ class แทน id)
                $('.building-select').empty(); // Clear both add and edit building selects

                // Populate options and make the first one selected
                data.forEach(function(row, index) {
                    const selected = index === 0 ? 'selected' : ''; // select the first option
                    const option = `<option value="${row.bd_id}" ${selected}>${row.bd_name}</option>`;
                    $('.building-select').append(option); // Append to both add and edit selects
                });

                // Trigger the change event to load rooms for the selected building (if needed)
                $('#add_bd_id').trigger('change');
                $('#edit_bd_id').trigger('change');
            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }

    // Function to get the room list based on the selected building
    function get_eqs_room_list(bd_id) {
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_eqs_room_list',
            type: 'GET',
            data: {
                bd_id: bd_id
            },
            success: function(data) {
                // Parse the returned data
                data = JSON.parse(data);

                // Clear old options (โดยใช้ class แทน id)
                $('.room-select').empty(); // Clear both add and edit room selects

                // Loop through building types
                data.building_type.forEach(function(buildingType) {
                    // สร้าง optgroup สำหรับ building type
                    const optgroup = $('<optgroup>').attr('label', buildingType.bdtype_name);

                    // กรอง rooms โดยใช้ buildingType.bdtype_id
                    const filteredRooms = data.rooms.filter(room => room.rm_bdtype_id === buildingType.bdtype_id);

                    // ถ้ามี rooms ที่ตรงกับ building type
                    if (filteredRooms.length > 0) {
                        filteredRooms.forEach(function(room) {
                            const option = `<option value="${room.rm_id}">${room.rm_name}</option>`;
                            optgroup.append(option);
                        });

                        // Append optgroup to both add and edit select elements (อ้างอิง class แทน id)
                        $('.room-select').append(optgroup);
                    }
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


    // ฟังก์ชันแปลงวันที่จาก พ.ศ. เป็น ค.ศ.
    function convertToGregorian(dateString) {
        const parts = dateString.split('/');
        const day = parts[0];
        const month = parts[1];
        let year = parseInt(parts[2], 10);

        // ถ้าเป็นปี พ.ศ. ให้ลบ 543 เพื่อแปลงเป็น ค.ศ.
        if (year > 2400) {
            year -= 543;
        }

        return `${year}-${month}-${day}`;
    }

    function convertYear(year, direction) {
        if (!year || isNaN(year)) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'เลือกปีไม่ถูกต้อง'
            });
            getEvents();
            return null;
        }

        if (direction === 'toCE') {
            return year - 543;
        } else if (direction === 'toBE') {
            return year + 543;
        } else {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'ไม่สามารถคำนวณปีได้'
            });
            getEvents();
            return null;
        }
    }

    function formatDateToStringDefault(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }

    function formatDateToStringTH(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear() + 543;
        return `${day}/${month}/${year}`;
    }

    function formatDate(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear() + 543;
        return `${year}-${month}-${day}`;
    }

    function formatTime(date) {
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${hours}:${minutes}`;
    }

    // Function to format date in 'dd/mm/yyyy' format and convert to Buddhist year
    function formatDateToDefault(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
        const year = date.getFullYear() - 543; // Convert to Buddhist year

        return `${day}/${month}/${year}`;
    }

    // Function to format date in 'dd/mm/yyyy' format and convert to Buddhist year
    function formatDateToBuddhist(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
        const year = date.getFullYear() + 543; // Convert to Buddhist year

        return `${day}/${month}/${year}`;
    }

    // Utility function to parse date strings in 'd/m/Y' format to Date objects
    function parseDateString(dateStr) {
        const [day, month, year] = dateStr.split('/');
        return new Date(year - 543, month - 1, day);
    }

    function formatDateTime(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${year}-${month}-${day} ${hours}:${minutes}`;
    }

    function saveEvent() {
        const add_desc = document.getElementById('add_plan_desc').value;
        const dateRange = document.getElementById('add_plan_date').value;
        const startTimeElement = document.getElementById('add_plan_start_time');
        const endTimeElement = document.getElementById('add_plan_end_time');
        const add_ps_id = document.getElementById('add_plan_ps_id').value;
        const add_twac_id = document.getElementById('add_twac_id').value;
        const add_dp_id = twpp_dp_id;
        const add_rm_id = document.getElementById('add_rm_id').value;

        var add_is_public = 0;

        if ($('#checkbox_add_is_public').is(':checked')) {
            add_is_public = 1;
        }

        if (!startTimeElement || !endTimeElement || !add_twac_id || !add_dp_id || !add_rm_id) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'กรุณากรอกข้อมูลให้ครบ'
            });
            return;
        }

        const startTime = startTimeElement.value;
        const endTime = endTimeElement.value;

        if (dateRange && startTime && endTime) {
            let startDate, endDate;

            // ตรวจสอบว่าค่าที่ได้รับมีเครื่องหมาย '-' หรือ 'ถึง'
            if (dateRange.includes(' - ')) {
                const dates = dateRange.split(' - ');
                startDate = dates[0];
                endDate = dates[1];
            } else if (dateRange.includes('ถึง')) {
                const dates = dateRange.split('ถึง').map(date => date.trim());
                startDate = dates[0];
                endDate = dates[1];
            } else {
                // กรณี dateRange มีค่าเป็นวันที่เดียว
                startDate = dateRange.trim();
                endDate = startDate; // ตั้งค่า endDate ให้เท่ากับ startDate
            }

            // แยกวันที่และปีจาก startDate และ endDate
            const startDateParts = startDate.split('/');
            const endDateParts = endDate.split('/');

            // แปลงปีจาก พ.ศ. เป็น ค.ศ.
            const startYearCE = convertYear(parseInt(startDateParts[2], 10), 'toCE');
            const endYearCE = convertYear(parseInt(endDateParts[2], 10), 'toCE');

            // รวมวันที่และเวลาเพื่อสร้าง timestamp ที่สมบูรณ์
            const startDateTime = `${startYearCE}-${startDateParts[1]}-${startDateParts[0]} ${startTime}`;
            const endDateTime = `${endYearCE}-${endDateParts[1]}-${endDateParts[0]} ${endTime}`;


            var select_add_rm_text = $('#add_rm_id').find(':selected').text();

            var [twac_id, twac_start_time, twac_end_time, twac_name_th, twac_color] = $('#add_twac_id').val().split('<>'); // แยกด้วยตัวขีด '-'
            select_add_rm_text = (add_rm_id == 0 ? '' : select_add_rm_text);
            var title = "(" + twac_name_th + ") " + select_add_rm_text;

            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>timework_calendar_save',
                type: 'POST',
                async: false, // Make the request synchronous (not recommended for large data or slow connections)
                data: {
                    twpp_ps_id: add_ps_id,
                    twpp_twac_id: twac_id,
                    twpp_desc: add_desc,
                    twpp_start_date: startDateTime,
                    twpp_end_date: endDateTime,
                    twpp_dp_id: add_dp_id,
                    twpp_rm_id: add_rm_id,
                    twpp_status: twpp_status,
                    twpp_is_public: add_is_public
                },
                success: function(data) {
                    // Parse the returned data
                    data = JSON.parse(data);
                    // console.log(data);
                    if (data.status_response == status_response_success) {
                        event_calendar.addEvent({
                            id: data.last_insert_twpp_id,
                            start: startDateTime,
                            end: endDateTime,
                            resourceId: add_ps_id,
                            title: title,
                            color: twac_color,
                            extendedProps: {
                                twpp_rm_id: add_rm_id,
                                twpp_dp_id: add_dp_id,
                                twac_id: add_twac_id,
                                twpp_desc: add_desc,
                                twpp_status: twpp_status,
                                twpp_is_public: add_is_public
                            }
                        });
                    } else {
                        dialog_error({
                            'header': text_toast_default_error_header,
                            'body': text_toast_default_error_body
                        });
                        getEvents();
                    }

                },
                error: function(xhr, status, error) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                    getEvents();
                }
            });



            $('#addEventModal').modal('hide');
        } else {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'กรุณากรอกข้อมูลให้ครบ'
            });
        }
    }

    // ฟังก์ชันบันทึกการเปลี่ยนแปลงเหตุการณ์
    function saveEventChanges() {
        const select_twpp_id = document.getElementById('edit_twpp_id').value; // ID ของแผนงาน
        const edit_ps_id = twpp_ps_id; // รายชื่อบุคลากร
        const dateRange = document.getElementById('edit_plan_date').value; // ช่วงวันที่
        const startTimeElement = document.getElementById('edit_plan_start_time');
        const endTimeElement = document.getElementById('edit_plan_end_time');
        const edit_twac_id = document.getElementById('edit_twac_id').value; // รูปแบบการลงเวลาทำงาน
        const edit_desc = document.getElementById('edit_plan_desc').value.trim(); // รายละเอียดเพิ่มเติม
        const edit_dp_id = document.getElementById('edit_dp_id').value; // หน่วยงาน
        const edit_rm_id = document.getElementById('edit_rm_id').value; // ห้อง/สถานที่
        var edit_is_public = 0;

        if ($('#checkbox_edit_is_public').is(':checked')) {
            edit_is_public = 1;
        }

        // console.log(startTimeElement.value, endTimeElement.value, edit_twac_id, edit_dp_id, edit_rm_id);
        // console.log("startTimeElement.value",startTimeElement.value);
        // console.log("endTimeElement.value",endTimeElement.value);
        // console.log("edit_twac_id",edit_twac_id);
        // console.log("edit_dp_id",edit_dp_id);
        // console.log("edit_rm_id",edit_rm_id);

        // ตรวจสอบว่ามีค่าเวลาเริ่มต้นและเวลาสิ้นสุด
        if (!startTimeElement || !endTimeElement || !edit_twac_id || !edit_dp_id || !edit_rm_id) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'กรุณากรอกข้อมูลให้ครบ'
            });
            return;
        }

        const startTime = startTimeElement.value;
        const endTime = endTimeElement.value;

        let startDate = null;
        let endDate = null;

        if (dateRange && startTime && endTime) {
            // ตรวจสอบว่าค่าที่ได้รับมีเครื่องหมาย '-' หรือ 'ถึง'
            if (dateRange.includes(' - ')) {
                const dates = dateRange.split(' - ');
                startDate = dates[0];
                endDate = dates[1];
            } else if (dateRange.includes('ถึง')) {
                const dates = dateRange.split('ถึง').map(date => date.trim());
                startDate = dates[0];
                endDate = dates[1];
            } else {
                // กรณี dateRange มีค่าเป็นวันที่เดียว
                startDate = dateRange.trim();
                endDate = startDate; // ตั้งค่า endDate ให้เท่ากับ startDate
            }
        }

        // ตรวจสอบว่ามีการกำหนดค่า startDate และ endDate หรือไม่
        if (!startDate || !endDate) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'ไม่สามารถกำหนดช่วงวันที่ได้'
            });
            getEvents();
            return;
        }


        // แยกวันที่และปีจาก startDate และ endDate
        const startDateParts = startDate.split('/');
        const endDateParts = endDate.split('/');

        // แปลงปีจาก พ.ศ. เป็น ค.ศ.
        const startYearCE = convertYear(parseInt(startDateParts[2], 10), 'toCE');
        const endYearCE = convertYear(parseInt(endDateParts[2], 10), 'toCE');

        // รวมวันที่และเวลาเพื่อสร้าง timestamp ที่สมบูรณ์
        const startDateTime = `${startYearCE}-${startDateParts[1]}-${startDateParts[0]} ${startTime}`;
        const endDateTime = `${endYearCE}-${endDateParts[1]}-${endDateParts[0]} ${endTime}`;

        var select_edit_rm_text = $('#edit_rm_id').find(':selected').text();

        var [twac_id, twac_start_time, twac_end_time, twac_name_th, twac_color] = $('#edit_twac_id').val().split('<>'); // แยกด้วยตัวขีด '-'
        select_edit_rm_text = (edit_rm_id == 0 ? '' : select_edit_rm_text);
        var title = "(" + twac_name_th + ") " + select_edit_rm_text;

        // console.log(startTimeElement.value, endTimeElement.value, edit_twac_id, edit_dp_id, edit_rm_id);
        // console.log("startYearCE",startYearCE);
        // console.log("startYearCE",startYearCE);
        // console.log("startDateTime",startDateTime);
        // console.log("endDateTime",endDateTime);


        // ส่งข้อมูลผ่าน AJAX เพื่ออัปเดตข้อมูลการแก้ไข
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>timework_calendar_save',
            type: 'POST',
            async: false, // ทำให้เป็น synchronous (ไม่แนะนำในบางกรณีที่ข้อมูลมีขนาดใหญ่หรือการเชื่อมต่อช้า)
            data: {
                twpp_id: select_twpp_id, // ID ของแผนงานที่ถูกแก้ไข
                twpp_ps_id: edit_ps_id, // รายชื่อบุคลากร
                twpp_twac_id: twac_id, // รูปแบบการลงเวลาทำงาน
                twpp_desc: edit_desc, // รายละเอียดเพิ่มเติม
                twpp_start_date: startDateTime, // วันเริ่มต้นพร้อมเวลา
                twpp_end_date: endDateTime, // วันสิ้นสุดพร้อมเวลา
                twpp_dp_id: edit_dp_id, // หน่วยงาน
                twpp_rm_id: edit_rm_id, // ห้อง/สถานที่
                twpp_status: twpp_status,
                twpp_is_public: edit_is_public
            },
            success: function(data) {
                // ตรวจสอบ response จากเซิร์ฟเวอร์
                data = JSON.parse(data);

                if (data.status_response == status_response_success) {
                    // ลบเหตุการณ์เก่าและเพิ่มเหตุการณ์ใหม่
                    event_calendar.removeEventById(selectedEvent.id);
                    event_calendar.addEvent({
                        id: select_twpp_id,
                        start: new Date(startDateTime),
                        end: new Date(endDateTime),
                        resourceId: edit_ps_id,
                        title: title,
                        color: twac_color,
                        extendedProps: {
                            twpp_rm_id: edit_rm_id,
                            twpp_dp_id: edit_dp_id,
                            twac_id: twac_id,
                            twpp_desc: edit_desc,
                            twpp_status: twpp_status,
                            twpp_is_public: edit_is_public
                        }
                    });

                    // ปิด modal หลังบันทึก
                    $('#editEventModal').modal('hide');
                } else {
                    // แสดงข้อผิดพลาดจากเซิร์ฟเวอร์
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': text_toast_default_error_body
                    });
                    getEvents();
                }
            },
            error: function(xhr, status, error) {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล'
                });
                getEvents();
            }
        });
    }


    // ฟังก์ชันตรวจสอบข้อมูลก่อนการบันทึก
    function validateEventInputs(resourceId, startDate, endDate, startTime, endTime, bdId, rmId, twacId) {
        if (!resourceId || !startDate || !endDate || !startTime || !endTime || !bdId || !rmId || !twacId) {
            return false; // ถ้าข้อมูลใดขาดหายไป จะส่งกลับเป็น false
        }
        return true;
    }

    function confirm_timework_calendar() {

        if (event_calendar.getEvents().length == 0) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': 'กรุณาจัดการข้อมูลให้ครบถ้วน'
            });
            return;
        }

        // สร้าง array สำหรับเก็บ id ของ events
        var eventIds = [];

        // วนลูปผ่าน events และดึง id
        event_calendar.getEvents().forEach(function(event) {
            eventIds.push(event.id);
        });

        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>timework_calendar_confirm',
            type: 'POST',
            async: false, // Make the request synchronous (not recommended for large data or slow connections)
            data: {
                event_calendar: eventIds, // ID ของแผนงานที่ถูกลบ
                event_status: 'S'
            },
            success: function(data) {
                // Parse the returned data
                data = JSON.parse(data);

                if (data.status_response == status_response_success) {
                    dialog_success({
                        'header': text_toast_save_success_header,
                        'body': data.message_dialog
                    });
                    $('#modal_confirm_timework_calendar').modal('hide');
                    // window.location.reload();
                } else {
                    dialog_error({
                        'header': text_toast_default_error_header,
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



<!-- Modal สำหรับเพิ่มเวลาการทำงาน -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">เพิ่มข้อมูลเวลาการทำงาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEventForm" class="row g-3 needs-validation">
                    <input type="hidden" id="add_plan_ps_id" name="add_plan_ps_id">
                    <div class="col-md-4">
                        <label class="form-label required" for="add_plan_date">ช่วงวันที่</label>
                        <input type="text" class="form-control" id="add_plan_date" placeholder="เลือกช่วงวันที่">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required" for="add_plan_date">รูปแบบการลงเวลาทำงาน</label>
                        <select class="form-control twac-select select2" id="add_twac_id" name="add_twac_id" onchange="get_time_attendance_config(this.value, 'add')">
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label required" for="add_plan_end_time_label">เวลา</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="add_plan_start_time" placeholder="เลือกเวลาเริ่มต้น" disabled>
                            <span class="input-group-text">ถึง</span>
                            <input type="text" class="form-control" id="add_plan_end_time" placeholder="เลือกเวลาสิ้นสุด" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required" for="add_bd_id">หน่วยงาน</label>
                        <select class="form-control building-select select2" id="add_bd_id" name="add_bd_id" onchange="get_eqs_room_list(this.value)">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required" for="add_rm_id">ห้อง/สถานที่</label>
                        <select class="form-control room-select select2" id="add_rm_id" name="add_rm_id">
                        </select>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="checkbox_add_rm_id" name="checkbox_add_rm_id">
                            <label class="form-check-label" for="checkbox_add_rm_id">
                                ไม่ระบุ
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="add_plan_desc">รายละเอียดเพิ่มเติมหรือหมายเหตุ</label>
                        <textarea class="form-control" id="add_plan_desc" placeholder="รายละเอียดเพิ่มเติมหรือหมายเหตุ"></textarea>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="checkbox_add_is_public" name="checkbox_add_is_public" disabled>
                            <label class="form-check-label ms-2" for="checkbox_add_is_public">
                                แสดงข้อมูลต่อสาธารณะ
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button> -->
                <button type="button" class="btn btn-primary" onclick="saveEvent()">บันทึก</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal สำหรับแก้ไขหรือลบเวลาการทำงาน -->
<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">แก้ไขข้อมูลเวลาการทำงาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEventForm" class="row g-3 needs-validation">
                    <input type="hidden" name="edit_twpp_id" id="edit_twpp_id" value="">
                    <input type="hidden" name="edit_dp_id" id="edit_dp_id" value="">
                    <input type="hidden" id="add_plan_ps_id" name="add_plan_ps_id">
                    <div class="col-md-4">
                        <label class="form-label required" for="edit_plan_date">ช่วงวันที่</label>
                        <input type="text" class="form-control" id="edit_plan_date" placeholder="เลือกช่วงวันที่">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required" for="edit_twac_id">รูปแบบการลงเวลาทำงาน</label>
                        <select class="form-control twac-select select2" id="edit_twac_id" name="edit_twac_id" onchange="get_time_attendance_config(this.value, 'edit')">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required" for="edit_plan_end_time_label">เวลา</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="edit_plan_start_time" placeholder="เลือกเวลาเริ่มต้น" disabled>
                            <span class="input-group-text">ถึง</span>
                            <input type="text" class="form-control" id="edit_plan_end_time" placeholder="เลือกเวลาสิ้นสุด" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required" for="edit_bd_id">หน่วยงาน</label>
                        <select class="form-control building-select select2" id="edit_bd_id" name="edit_bd_id" onchange="get_eqs_room_list(this.value)">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required" for="edit_rm_id">ห้อง/สถานที่</label>
                        <select class="form-control room-select select2" id="edit_rm_id" name="edit_rm_id">
                        </select>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="checkbox_edit_rm_id" name="checkbox_edit_rm_id">
                            <label class="form-check-label" for="checkbox_edit_rm_id">
                                ไม่ระบุ
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="edit_plan_desc">รายละเอียดเพิ่มเติมหรือหมายเหตุ</label>
                        <textarea class="form-control" id="edit_plan_desc" placeholder="รายละเอียดเพิ่มเติมหรือหมายเหตุ"></textarea>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="checkbox_edit_is_public" name="checkbox_edit_is_public" disabled>
                            <label class="form-check-label ms-2" for="checkbox_edit_is_public">
                                แสดงข้อมูลต่อสาธารณะ
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อลบข้อมูล" id="deleteEventButton">ลบ</button>
                <!-- <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อยกเลิก" data-bs-dismiss="modal">ยกเลิก</button> -->
                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อบันทึกข้อมูล" id="saveChangesButton">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_confirm_timework_calendar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ยืนยันข้อมูลตารางแพทย์ออกตรวจ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <!-- <li class="list-group-item"><i class="bi bi-exclamation-octagon me-1 text-warning"></i> หากยืนยันแล้ว สามารถแก้ไขได้ที่แท็บ "รายงานตารางแพทย์ออกตรวจ (ภาพรวม)"</li> -->
                    <li class="list-group-item"><i class="bi bi-exclamation-octagon me-1 text-warning"></i> ข้อมูลจะมีผลทันทีที่ปฏิทินทำงานของบุคลากรที่หน้าจอระบบ Personal Dashboard</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="confirm_timework_calendar()">ยืนยัน</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->