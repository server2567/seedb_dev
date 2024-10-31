<!-- ลิงก์ไปยังสไตล์ชีทและไฟล์สคริปต์ -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "assets/plugins/event-calendar/event-calendar.min.css"; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "assets/plugins/event-calendar/event-calendar-global.css"; ?>">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/event-calendar/event-calendar.min.js"></script>

<!-- กำหนดสไตล์ของส่วนต่าง ๆ เช่น timeline และ sidebar title -->
<style>
    .ec-timeline .ec-time, .ec-timeline .ec-line {
        width: 50px;
    }

    .ec-sidebar-title {
        display: flex;
        justify-content: center; /* จัดกึ่งกลางในแนวนอน */
        align-items: center; /* จัดกึ่งกลางในแนวตั้ง */
        height: 100%; /* กำหนดความสูงเพื่อให้ Flexbox ทำงาน */
        text-align: center; /* จัดข้อความให้อยู่ตรงกลาง */
    }
    .nav-pills .nav-link {
        border: 1px dashed #607D8B;
        color: #012970;
        background-color: #fff;
    }

</style>

<input type="hidden" id="twpp_status" name="twpp_status" value="<?php echo $twpp_status; ?>">
<!-- Default Tabs -->
<ul class="nav nav-pills" id="tabTimework" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link w-100 active" id="form-tab" data-bs-toggle="tab" data-bs-target="#form-timework" type="button" role="tab" aria-controls="home" aria-selected="true">ลงเวลาทำงาน</button>
    </li>
    <li class="nav-item ms-1" role="presentation">
        <button class="nav-link w-100" id="setting-tab" data-bs-toggle="tab" data-bs-target="#setting-timework" type="button" role="tab" aria-controls="profile" aria-selected="false">กำหนดเวลาการลงเวลาทำงาน</button>
    </li>
    <li class="nav-item ms-1" role="presentation">
        <button class="nav-link w-100" id="history-tab" data-bs-toggle="tab" data-bs-target="#history-timework" type="button" role="tab" aria-controls="contact" aria-selected="false">รายงานลงเวลาทำงาน (ภาพรวม)</button>
    </li>
</ul>
<div class="tab-content pt-2" id="tabTimeworkContent">
    <div class="tab-pane fade show active" id="form-timework" role="tabpanel" aria-labelledby="form-tab">
        <div class="card mt-2">
            <div class="accordion">
                <!-- Accordion สำหรับค้นหารายชื่อบุคลากร -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                            <i class="bi-search icon-menu"></i><span> ค้นหารายชื่อบุคลากร<?php echo $hire_is_medical; ?></span>
                        </button>
                    </h2>
                    <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                        <div class="accordion-body">
                            <!-- ฟอร์มการค้นหาแบบฟิลเตอร์ -->
                            <form class="row g-3" method="get">

                            <?php if($actor_type == "approver" || $actor_type == "medical"){ ?>

                                    <!-- หน่วยงาน -->
                                    <div class="col-md-3">
                                        <label for="fillter_select_dp_id" class="form-label">หน่วยงาน</label>
                                        <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="fillter_select_dp_id" id="fillter_select_dp_id">
                                            <?php foreach ($base_ums_department_list as $key => $row) { ?>
                                                <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    
                                    <!-- ประเภทบุคลากร -->
                                    <div class="col-md-3">
                                        <label for="fillter_select_hire_id" class="form-label">ประเภทบุคลากร</label>
                                        <select class="form-select select2" name="fillter_select_hire_id" id="fillter_select_hire_id">
                                            <option value="all" selected>ทั้งหมด</option>
                                            <option value="none">ไม่ระบุ</option>
                                            <?php foreach ($base_hire_list as $key => $row) { ?>
                                                <option value="<?php echo $row->hire_id; ?>"><?php echo $row->hire_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <!-- ตำแหน่งในการบริหารงาน -->
                                    <div class="col-md-3">
                                        <label for="fillter_select_admin_id" class="form-label">ตำแหน่งในการบริหารงาน</label>
                                        <select class="form-select select2" name="fillter_select_admin_id" id="fillter_select_admin_id">
                                            <option value="all" selected>ทั้งหมด</option>
                                            <option value="none">ไม่ระบุ</option>
                                            <?php foreach ($base_admin_position_list as $key => $row) { ?>
                                                <option value="<?php echo $row->admin_id; ?>"><?php echo $row->admin_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <!-- สถานะการทำงาน -->
                                    <div class="col-md-3">
                                        <label for="fillter_select_status_id" class="form-label">สถานะการทำงาน</label>
                                        <select class="form-select select2" id="fillter_select_status_id" name="fillter_select_status_id">
                                            <option value="all" selected>ทั้งหมด</option>
                                            <option value="1">ปฏิบัติงานอยู่</option>
                                            <option value="2">ออกจากการปฏิบัติงาน</option>
                                        </select>
                                    </div>
                                <?php }else{ ?>
                                    <!-- หน่วยงาน -->
                                    <div class="col-md-3">
                                        <label for="fillter_select_dp_id" class="form-label">หน่วยงาน</label>
                                        <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="fillter_select_dp_id" id="fillter_select_dp_id" onchange="get_stucture_detail(value)">
                                            <?php foreach ($base_ums_department_list as $key => $row) { ?>
                                                <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <!-- โครงสร้างองค์กร -->
                                    <div class="col-md-3">
                                        <label for="fillter_select_stde_id" class="form-label">โครงสร้างองค์กร</label>
                                        <select class="form-select select2" name="fillter_select_stde_id" id="fillter_select_stde_id">
                                            
                                        </select>
                                    </div>

                                    <!-- สายปฏิบัติงาน -->
                                    <div class="col-md-3">
                                        <label for="fillter_select_twpp_is_medical" class="form-label">สายปฏิบัติงาน</label>
                                        <select class="form-select select2" name="fillter_select_twpp_is_medical" id="fillter_select_twpp_is_medical">
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

                                    <!-- สถานะการทำงาน -->
                                    <div class="col-md-3">
                                        <label for="fillter_select_status_id" class="form-label">สถานะการทำงาน</label>
                                        <select class="form-select select2" id="fillter_select_status_id" name="fillter_select_status_id">
                                            <option value="all" selected>ทั้งหมด</option>
                                            <option value="1">ปฏิบัติงานอยู่</option>
                                            <option value="2">ออกจากการปฏิบัติงาน</option>
                                        </select>
                                    </div>
                                <?php }?>
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
                            <i class="bi-people icon-menu"></i><span> รายชื่อบุคลากร<?php echo $hire_is_medical; ?></span><span class="summary_person badge bg-success"></span>
                        </button>
                    </h2>
                        
                    <div id="collapseShow" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <!-- ปุ่มยืนยันการลงเวลาการทำงาน -->
                            <button class="btn btn-success float-right mb-3" onclick="location.href='<?php echo site_url($controller_dir . 'attendance_config_form'); ?>'">
                                <i class="bi-check-circle"></i> ยืนยันการลงเวลาการทำงาน
                            </button>
                            <!-- พื้นที่สำหรับปฏิทิน -->
                            <div id="event_calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane fade" id="setting-timework" role="tabpanel" aria-labelledby="setting-tab">
        <?php echo $this->load->view($view_dir . 'v_timework_setting_form', '', TRUE); ?>
    </div>
    <div class="tab-pane fade" id="history-timework" role="tabpanel" aria-labelledby="history-tab">
    <?php echo $this->load->view($view_dir . 'v_timework_preview_report', '', TRUE); ?>
    </div>
</div><!-- End Default Tabs -->



<script type="text/javascript">
const twpp_status = document.getElementById('twpp_status').value;
const actor_type = '<?php echo $actor_type; ?>';
let selectedEvent = null; // To store the currently selected event
var event_calendar;
var default_show = 0;

document.addEventListener('DOMContentLoaded', function() {
    // setDefaultDate('add'); // Set default date for adding events
    get_eqs_building_list();
    get_stucture_detail($('#fillter_select_dp_id').val());
    initializeCalendar(); // Initialize the calendar
    

    if(default_show == 1){

        <?php if($actor_type == "approver" || $actor_type == "medical"){ ?>
            // Event listeners for select dropdowns
            $('#fillter_select_dp_id, #fillter_select_hire_id, #fillter_select_admin_id, #fillter_select_status_id').on('change', function() {
                event_calendar.destroy();
                initializeCalendar()
            });
        <?php }else {?>
            // Event listeners for select dropdowns
            $('#fillter_select_dp_id, #fillter_select_stde_id, #fillter_select_twpp_is_medical, #fillter_select_status_id').on('change', function() {
                event_calendar.destroy();
                initializeCalendar();
            });
        <?php }?>
    }

   

    // Apply the function to both add and edit room selectors
    handleRoomSelect('#checkbox_add_rm_id', '#add_rm_id');
    handleRoomSelect('#checkbox_edit_rm_id', '#edit_rm_id');


});

function initializeCalendar() {

    event_calendar = new EventCalendar(document.getElementById('event_calendar'), {
        view: 'resourceTimelineMonth',
        locale: 'th',
        date: new Date('2024-09-01'),  // Set a specific date
        headerToolbar: {
            start: 'prev,next today',
            center: 'title',
            end: 'resourceTimelineMonth,resourceTimelineWeek,dayGridMonth'
        },
        buttonText: {
            today: 'วันนี้',
            resourceTimelineMonth: 'เดือน',
            resourceTimelineWeek: 'สัปดาห์',
            dayGridMonth: 'ปฏิทิน'
        },
        resources: getResources(),
        resourceLabelContent: function(arg) {
            let customResourceHtml = document.createElement('div');
            customResourceHtml.innerHTML = arg.resource.title;
            return { domNodes: [customResourceHtml] };
        },
        events: getEvents(),
        views: getViewSettings(),
        dayMaxEvents: true,
        nowIndicator: true,
        selectable: true,
        dateClick: handleDateClick,
        select: handleSelect,
        eventClick: handleEventClick,
        eventDrop: handleEventDrop,
        eventResize: handleEventResize,
        eventDidMount: getTooltipEvents
    });
    

    $(".ec-sidebar-title").html("รายชื่อบุคลากร");
}

function getTooltipEvents(info){
    
}

function getResources() {
    var dataFilter;
    <?php if($actor_type == "approver" || $actor_type == "medical"){ ?>
        // Get filter values
        var fillter_dp_id = $('#fillter_select_dp_id').val();
        var fillter_hire_id = $('#fillter_select_hire_id').val();
        var fillter_admin_id = $('#fillter_select_admin_id').val();
        var fillter_status_id = $('#fillter_select_status_id').val();
        dataFilter = {
            admin_id: fillter_admin_id,
            hire_id: fillter_hire_id,
            status_id: fillter_status_id,
            dp_id: fillter_dp_id,
            actor_type : '<?php echo $actor_type; ?>'
        }
    <?php }else {?>
        // Get filter values
        
        var fillter_dp_id = $('#fillter_select_dp_id').val();
        var fillter_stde_id = $('#fillter_select_stde_id').val() ? $('#fillter_select_stde_id').val() : 0;
        var fillter_twpp_is_medical_id = $('#fillter_select_twpp_is_medical').val();
        var fillter_status_id = $('#fillter_select_status_id').val();
        dataFilter = {
            status_id: fillter_status_id,
            stde_id: fillter_stde_id,
            twpp_is_medical: fillter_twpp_is_medical_id,
            dp_id: fillter_dp_id,
            actor_type : '<?php echo $actor_type; ?>'
        }
        
    <?php }?>

    var result = [];
    

    // Make the AJAX request to fetch data
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_profile_user_list',
        type: 'GET',
        async: false, // Make the request synchronous (not recommended for large data or slow connections)
        data: dataFilter,
        success: function(data) {
            // Parse the returned data
            data = JSON.parse(data);

            $(".summary_person").text(data.length);

            // Clear existing options in the select fields
            $('#add_plan_ps_id, #edit_plan_ps_id').empty();

            // Add options to add_plan_ps_id and edit_plan_ps_id
            data.forEach(function(person) {
                const option = `<option value="${person.ps_id}">${person.pf_name}${person.ps_fname} ${person.ps_lname}</option>`;
                $('#add_plan_ps_id').append(option);
                $('#edit_plan_ps_id').append(option);
            });

            // map ข้อมูล
            result = data.map(function(person) {
                return { 
                    id: person.ps_id, 
                    title: `<a href="<?php echo site_url() . "/" . $controller_dir; ?>get_timework_user/${person.ps_id_encrypt}/${fillter_dp_id}/${twpp_status}/${actor_type}" title="${person.pf_name}${person.ps_fname} ${person.ps_lname}" data-bs-toggle="tooltip" data-bs-placement="top">
                                ${person.pf_name}${person.ps_fname} ${person.ps_lname}
                            </a>`
                };
            });

           
        },
        error: function(xhr, status, error) {
            // dialog_error({
            //     'header': text_toast_default_error_header,
            //     'body': text_toast_default_error_body
            // });
        }
    });

    // Return the populated data
    return result;
}

function get_stucture_detail(fillter_dp_id){
    
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_structure_detail_by_dpid_psid',
        type: 'GET',
        data: {
            dp_id: fillter_dp_id
        },
        success: function(data) {
            // Parse the returned data
            data = JSON.parse(data);

            $('#fillter_select_stde_id').empty();

            // Populate options and make the first one selected
            data.forEach(function(row, index) {
               
                const selected = index === 0 ? 'selected' : ''; // select the first option
                const option = `<option value="${row.stde_id}" ${selected}>${row.stde_name_th}</option>`;
                
                // Append option to both add and edit select elements
                $('#fillter_select_stde_id').append(option);
            });

            // Trigger the change event to load time configs (if needed)

            $('#fillter_select_stde_id').trigger('change');

        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


// ฟังก์ชันเพื่อดึงข้อมูลเหตุการณ์ในปฏิทิน
function getEvents() {
    var dataFilter;
    <?php if($actor_type == "approver" || $actor_type == "medical"){ ?>
        // Get filter values
        var fillter_dp_id = $('#fillter_select_dp_id').val();
        var fillter_hire_id = $('#fillter_select_hire_id').val();
        var fillter_admin_id = $('#fillter_select_admin_id').val();
        var fillter_status_id = $('#fillter_select_status_id').val();
        dataFilter = {
            admin_id: fillter_admin_id,
            hire_id: fillter_hire_id,
            status_id: fillter_status_id,
            dp_id: fillter_dp_id,
            actor_type : '<?php echo $actor_type; ?>',
            twpp_status: twpp_status
        }
    <?php }else {?>
        // Get filter values
        var fillter_dp_id = $('#fillter_select_dp_id').val();
        var fillter_stde_id = $('#fillter_select_stde_id').val();
        var fillter_twpp_is_medical_id = $('#fillter_select_twpp_is_medical').val();
        var fillter_status_id = $('#fillter_select_status_id').val();
        dataFilter = {
            status_id: fillter_status_id,
            stde_id: fillter_stde_id,
            twpp_is_medical: fillter_twpp_is_medical_id,
            dp_id: fillter_dp_id,
            actor_type : '<?php echo $actor_type; ?>',
            twpp_status: twpp_status
        }
    <?php }?>

    var result = [];

    // AJAX เพื่อดึงข้อมูลเหตุการณ์
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_timework_plan_person_list',
        type: 'GET',
        async: false,
        data: dataFilter,
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
                        title: `(${row.twac_name_th}) ${row.rm_name}`,
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

// ฟังก์ชันเพื่อกำหนดมุมมองของปฏิทิน
function getViewSettings() {
    return {
        timeGridWeek: { pointer: true },
        resourceTimelineWeek: {
            pointer: true,
            slotWidth: 50,
            slotHeight: 100
        },
        resourceTimelineMonth: {
            pointer: true,
            slotWidth: 50,
            slotHeight: 100
        }
    };
}

// ฟังก์ชันจัดการคลิกวันที่ในปฏิทิน
function handleDateClick(info) {

    // เซ็ตค่าดีฟอลต์ใน modal ตามวันที่ที่ถูกคลิก
    const clickedDate = new Date(info.dateStr);
    const startDate = formatDateToBuddhist(clickedDate);
    // const endDate = formatDateToBuddhist(new Date(clickedDate.getTime() + 60 * 60 * 1000 * 24)); // 1 day later
    const endDate = formatDateToBuddhist(new Date(clickedDate));

    document.getElementById('add_plan_desc').value = '';
    document.getElementById('add_plan_date').value = `${startDate} ถึง ${endDate}`;

    // กำหนด resource ที่ถูกเลือกใน modal
    if (info.resource) {
        $('#add_plan_ps_id').val(info.resource.id).trigger('change');
    } else {
        $('#add_plan_ps_id').val('').trigger('change');
    }

    get_timework_attendance_config_list(info.resource.id);

    setDefaultDate('add', startDate, endDate);
    $('#addEventModal').modal('show');
}

// ฟังก์ชันจัดการการเลือกช่วงเวลาในปฏิทิน
function handleSelect(info) {

    // เซ็ตค่าดีฟอลต์ใน modal ตามวันที่ที่ถูกคลิก
    const startDate = formatDateToBuddhist(info.start);
    const endDate = formatDateToBuddhist(info.end);

    document.getElementById('add_plan_desc').value = '';
    document.getElementById('add_plan_date').value = `${startDate} ถึง ${endDate}`;

    if (info.resource) {
        $('#add_plan_ps_id').val(info.resource.id).trigger('change');
    } else {
        $('#add_plan_ps_id').val('').trigger('change');
    }

    get_timework_attendance_config_list(info.resource.id);

    setDefaultDate('add', startDate, endDate);
    $('#addEventModal').modal('show');
}

// ฟังก์ชันจัดการคลิกเหตุการณ์
function handleEventClick(info) {
    selectedEvent = info.event;
    // console.log(selectedEvent);
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
    

    // เซ็ตค่าบุคลากรที่ถูกเลือกใน Select2
    if (selectedEvent.resourceIds && selectedEvent.resourceIds.length > 0) {
        $('#edit_plan_ps_id').val(selectedEvent.resourceIds[0]).trigger('change');
    } else {
        $('#edit_plan_ps_id').val('').trigger('change');
    }

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

    // ตรวจสอบว่ามีข้อมูลที่จำเป็นครบถ้วนหรือไม่
    if (!event) {
        dialog_error({
            'header': text_toast_default_error_header,
            'body': 'ไม่สามารถจัดการการลากข้อมูลได้ กรุณาลองใหม่อีกครั้ง'
        });
        return;
    }
  
    // ดึงข้อมูลจาก info (ข้อมูลใหม่ที่ได้หลังจากลาก)
    const new_ps_id = info.newResource ? info.newResource.id : event.resourceIds[0]; // รายชื่อบุคลากรใหม่ (หรือใช้ resource เดิม)
    const select_twpp_id = event.id; // ID ของแผนงาน
    const edit_twac_id = event.extendedProps.twac_id; // รูปแบบการลงเวลาทำงาน
    const edit_desc = event.extendedProps.twpp_desc || ""; // รายละเอียดเพิ่มเติม
    const twpp_status = event.extendedProps.twpp_status; // สถานะการทำงาน
    const edit_dp_id = event.extendedProps.twpp_dp_id; // หน่วยงาน (ดึงจากข้อมูลเพิ่มเติมของ event หรือ DOM)
    const edit_rm_id = event.extendedProps.twpp_rm_id; // ห้อง/สถานที่ (ดึงจากข้อมูลเพิ่มเติมของ event หรือ DOM)
    const edit_is_public = event.extendedProps.twpp_is_public; // เผยแพร่ข้อมูลสู่สาธารณะ (ดึงจากข้อมูลเพิ่มเติมของ event หรือ DOM)

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
    const edit_is_public = event.extendedProps.twpp_is_public; // เผยแพร่ข้อมูลสู่สาธารณะ (ดึงจากข้อมูลเพิ่มเติมของ event หรือ DOM)

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
        startDate = parseDateString(startDate);  // Parses Thai Buddhist year correctly
    }

    // If endDate is provided as a string, convert it to a Date object
    if (endDate && typeof endDate === 'string') {
        endDate = parseDateString(endDate);  // Parses Thai Buddhist year correctly
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
        maxDate: formatDateToStringDefault(lastDayOfMonth),  // Set maxDate to the last day of the startDate's month
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
function get_timework_attendance_config_list(ps_id, twac_id=""){
    
    var fillter_dp_id = $('#fillter_select_dp_id').val();
    var count_list = 0;
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_timework_attendance_config_list',
        type: 'GET',
        data: {
            ps_id: ps_id,
            dp_id: fillter_dp_id
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
                if(index == 0){
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
function get_eqs_building_list(){
    default_show = 1;
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_eqs_building_list',
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
function get_eqs_room_list(bd_id){
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
        dialog_error({'header': text_toast_default_error_header, 'body': 'เลือกปีไม่ถูกต้อง'});
        getEvents();
        return null;
    }

    if (direction === 'toCE') {
        return year - 543;
    } else if (direction === 'toBE') {
        return year + 543;
    } else {
        dialog_error({'header': text_toast_default_error_header, 'body': 'ไม่สามารถคำนวณปีได้'});
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
    const year = date.getFullYear() -543; // Convert to Buddhist year

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
    const add_dp_id = document.getElementById('fillter_select_dp_id').value;
    const add_rm_id = document.getElementById('add_rm_id').value;
    var add_is_public = 0;

    if ($('#checkbox_add_is_public').is(':checked')) {
        add_is_public = 1;
    }
    
    if (!startTimeElement || !endTimeElement || !add_twac_id || !add_dp_id || !add_rm_id) {
        dialog_error({'header': text_toast_default_error_header, 'body': 'กรุณากรอกข้อมูลให้ครบ'});
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
                twpp_is_public : add_is_public
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
        dialog_error({'header': text_toast_default_error_header, 'body': 'กรุณากรอกข้อมูลให้ครบ'});
    }
}

// ฟังก์ชันบันทึกการเปลี่ยนแปลงเหตุการณ์
function saveEventChanges() {
    const select_twpp_id = document.getElementById('edit_twpp_id').value; // ID ของแผนงาน
    const edit_ps_id = document.getElementById('edit_plan_ps_id').value; // รายชื่อบุคลากร
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
        dialog_error({'header': text_toast_default_error_header, 'body': 'กรุณากรอกข้อมูลให้ครบ'});
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
                    <div class="col-md-12">
                        <label class="form-label" for="add_plan_ps_id">รายชื่อบุคลากร</label>
                        <select class="form-control select2" id="add_plan_ps_id" name="add_plan_ps_id">
                        </select>
                    </div>
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
                            <input class="form-check-input" type="checkbox" id="checkbox_add_is_public" name="checkbox_add_is_public">
                            <label class="form-check-label ms-2" for="checkbox_add_is_public">
                            เผยแพร่ข้อมูลสู่สาธารณะ
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
                <div class="col-md-12">
                    <label class="form-label" for="edit_plan_ps_id">รายชื่อบุคลากร</label>
                    <select class="form-control select2" id="edit_plan_ps_id" name="edit_plan_ps_id">
                    </select>
                </div>
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
                        <input class="form-check-input" type="checkbox" id="checkbox_edit_is_public" name="checkbox_edit_is_public">
                        <label class="form-check-label ms-2" for="checkbox_edit_is_public">
                            เผยแพร่ข้อมูลสู่สาธารณะ
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