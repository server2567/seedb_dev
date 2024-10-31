<style>
    /* Calendar container styling */
    #calendar {
        padding: 0 10px;
    }

    /* Calendar header and event title styling */
    .fc-daygrid-day-top a,
    .fc-col-header-cell-cushion
    ,.fc .fc-daygrid-day-number{
        color: black;
    }

    .fc-event-title,
    .fc-event-time {
        font-weight: 700;
        color: white;
    }

    .fc-event-content:hover .fc-event-title,
    .fc-event-content:hover .fc-event-time {
        color: black;
    }

    .fc-icon-chevron-left,
    .fc-icon-chevron-right {
        color: white;
    }

    .fc-theme-standard .fc-list-day-cushion {
        background-color: #fff;
    }

    /* Filter container styling */
    #filter-container {
        display: inline-flex;
        align-items: center;
        margin: 30px 10px;
    }

    /* Filter dot styling */
    .filter-dot {
        width: 1.5em;
        /* Responsive size */
        height: 1.5em;
        /* Responsive size */
        border-radius: 50%;
        /* Ensure circular shape */
        margin-right: 0.5em;
        cursor: pointer;
        border: 2px solid #fff;
        flex-shrink: 0;
        /* Prevent shrinking */
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        /* Add subtle shadow for better visibility */
    }

    /* Filter label styling */
    .filter-label {
        margin-right: 1.5em;
        margin-top: 1.5em;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: opacity 1s;
        /* Smooth transition for filter visibility */
        padding: 0.5em;
        /* Padding for better click area */
        background-color: #f8f9fa;
        /* Light background for better contrast */
        border-radius: 5px;
        /* Slightly rounded corners */
    }

    /* Hover effect for the filter labels */
    .filter-label:hover {
        background-color: #f0f0f0;
    }

    /* Filter label text styling */
    .filter-label-text {
        margin-right: 1.5em;
        display: flex;
        align-items: center;
    }

    /* Make filter container flex wrap */
    #filter-container {
        display: flex;
        flex-wrap: wrap;
        margin: 30px 10px;
    }

    /* Highlight current day in calendar */
    .fc .fc-daygrid-day.fc-day-today {
        background-color: rgba(13, 110, 253, 0.25);
    }

    /* Event content styling */
    .fc-event-content {
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .fc-event-header {
        display: flex;
        align-items: center;
        z-index: 100 !important;
    }

    .fc-event-time {
        margin-right: 5px;
    }

    .fc-event-description {
        margin-top: 2px;
    }

    /* More popover styling */
    .fc-more-popover {
        width: 400px;
        /* Width of the popover */
        max-width: 400px;
        /* Max width of the popover */
        height: 300px;
        /* Height of the popover */
        max-height: 300px;
        /* Max height of the popover */
        overflow: auto;
        /* Allow scrolling */
    }

    /* Button warning styling */
    .btn-warning {
        --bs-btn-color: #fff;
    }

    /* Tooltip container */
    .fc-event-content:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    /* Tooltip styling */
    .tooltip-text {
        visibility: hidden;
        background-color: #2c3e50;
        color: #fff;
        text-align: left;
        border-radius: 6px;
        padding: 8px;
        position: absolute;
        z-index: 9999;
        /* Ensure the tooltip is on top */
        opacity: 0;
        transition: opacity 0.3s;
        /* min-width: 300px; /* Minimum width for better display */
        /* max-width: 400px; /* Maximum width to constrain the size */
        /* min-height: 40px; /* Minimum height for better readability */
        /* max-height: 200px; /* Maximum height to constrain the size */

        word-wrap: break-word;
        /* Break long words */
        white-space: normal;
        /* Allow text to wrap to the next line */
    }

    .tooltip-text::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 5px;
        border-style: solid;
        border-color: #2c3e50 transparent transparent transparent;
    }

    /* Event animation styling */
    .fc-event {
        transition: opacity 1s ease-in-out, display 0s 1s;
    }

    .fc-event.fade-out {
        opacity: 0;
    }

    .fc-event.fade-in {
        opacity: 1;
    }

    .fc-button-primary:hover:not(.active) {
        color: #FFF !important;
    }
</style>

<h4 class="partial-name"><span>ปฏิทินการปฏิบัติงาน</span></h4>
<div id='filter-container'></div>
<div id='calendar'></div>

<!-- Modal สำหรับเพิ่มกิจกรรม -->
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มกิจกรรมส่วนตัว</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="eventForm" class="needs-validation" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="clnd_topic" class="form-label required">หัวเรื่อง</label>
                            <input type="text" class="form-control" id="clnd_topic" name="clnd_topic" placeholder="หัวเรื่อง">
                        </div>
                        <div class="col-md-12">
                            <label for="clnd_detail" class="form-label">รายละเอียด</label>
                            <textarea class="form-control" id="clnd_detail" name="clnd_detail" placeholder="รายละเอียด" style="height: 100px;"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="input_date" class="form-label required">วันที่</label>
                            <div class="input-group input_date">
                                <input type="text" class="form-control" id="clnd_start_date" name="clnd_start_date">
                                <span class="input-group-text">ถึง</span>
                                <input type="text" class="form-control" id="clnd_end_date" name="clnd_end_date">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check_all_day" name="check_all_day">
                                <label class="form-check-label" for="check_all_day">ตลอดวัน</label>
                            </div>
                        </div>
                        <div class="col-md-6" id="input_time">
                            <label for="input_time" class="form-label required">เวลา</label>
                            <div class="input-group input_time">
                                <input type="text" class="form-control" id="clnd_start_time" name="clnd_start_time">
                                <span class="input-group-text">ถึง</span>
                                <input type="text" class="form-control" id="clnd_end_time" name="clnd_end_time">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mb-3">
                            <label for="clnd_parent_id" class="form-label required">สิทธิ์ของกิจกรรม</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="clnd_parent_id" id="clnd_parent_id_1" value="N" onclick="togglePersonList('',value)" checked>
                                <label class="form-check-label" for="clnd_parent_id_1">
                                    ไม่แชร์กิจกรรม
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="clnd_parent_id" id="clnd_parent_id_2" value="Y" onclick="togglePersonList('',value)">
                                <label class="form-check-label" for="clnd_parent_id_2">
                                    แชร์กิจกรรม
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mb-3">

                        </div>

                        <div class="col-md-12 mt-3" id="div_filter_person_list">
                            <div class="row">
                                <hr>
                                <div class="col-md-5">
                                    <label for="calendar_ums_department" class="form-label">หน่วยงาน</label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="calendar_ums_department" id="calendar_ums_department">

                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="calendar_person_participate" class="form-label">ผู้เข้าร่วมกิจกรรม</label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกบุคลากร --" name="calendar_person_participate" id="calendar_person_participate">

                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end justify-content-center">
                                    <button type="button" class="btn btn-success" id="confirm_calendar_person">เลือก</button>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 mt-4 mb-4" id="div_table_person_list">
                            <table id="person_list" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">ชื่อ - นามสกุล</th>
                                        <!-- <th class="text-center">ประเภทบุคลากร</th>
                                        <th class="text-center">ตำแหน่งในการบริหารงาน</th> -->
                                        <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                        <th class="text-center">ดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อปิด">ปิด</button> -->
                <button type="button" class="btn btn-primary" id="saveEvent" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อเพิ่มกิจกรรม">เพิ่มกิจกรรม</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal สำหรับแก้ไขรายละเอียดของกิจกรรม -->
<div class="modal fade" id="eventDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียดกิจกรรมส่วนตัว</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="eventDetailForm" class="needs-validation" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="update_clnd_id" id="update_clnd_id">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="detail_clnd_topic" class="form-label required">หัวเรื่อง</label>
                            <input type="text" class="form-control" id="detail_clnd_topic" name="detail_clnd_topic" placeholder="หัวเรื่อง">
                        </div>
                        <div class="col-md-12">
                            <label for="detail_clnd_detail" class="form-label">รายละเอียด</label>
                            <textarea class="form-control" id="detail_clnd_detail" name="detail_clnd_detail" placeholder="รายละเอียด" style="height: 100px;"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="detail_input_date" class="form-label required">วันที่</label>
                            <div class="input-group input_date">
                                <input type="text" class="form-control" id="detail_clnd_start_date" name="detail_clnd_start_date">
                                <span class="input-group-text">ถึง</span>
                                <input type="text" class="form-control" id="detail_clnd_end_date" name="detail_clnd_end_date">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="detail_check_all_day" name="detail_check_all_day">
                                <label class="form-check-label" for="detail_check_all_day">ตลอดวัน</label>
                            </div>
                        </div>
                        <div class="col-md-6" id="detail_input_time">
                            <label for="detail_input_time" class="form-label required">เวลา</label>
                            <div class="input-group input_time">
                                <input type="text" class="form-control" id="detail_clnd_start_time" name="detail_clnd_start_time">
                                <span class="input-group-text">ถึง</span>
                                <input type="text" class="form-control" id="detail_clnd_end_time" name="detail_clnd_end_time">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mb-3">
                            <label for="detail_clnd_parent_id" class="form-label required">สิทธิ์ของกิจกรรม</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="detail_clnd_parent_id" id="detail_clnd_parent_id_1" value="N" onclick="togglePersonList('detail_', value)" checked>
                                <label class="form-check-label" for="clnd_parent_id_1">
                                    ไม่แชร์กิจกรรม
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="detail_clnd_parent_id" id="detail_clnd_parent_id_2" value="Y" onclick="togglePersonList('detail_', value)">
                                <label class="form-check-label" for="detail_clnd_parent_id_2">
                                    แชร์กิจกรรม
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mb-3">
                            <label for="detail_create_clnd_by" class="form-label">สร้างโดย</label><br>
                            <span id="detail_create_clnd_by">
                                <?php
                                echo $profile_person['person_detail']->pf_name_abbr . $profile_person['person_detail']->ps_fname . " " . $profile_person['person_detail']->ps_lname;
                                ?>
                            </span>
                        </div>

                        <div class="col-md-12 mt-3" id="detail_div_filter_person_list">
                            <div class="row">
                                <hr>
                                <div class="col-md-5">
                                    <label for="detail_calendar_ums_department" class="form-label">หน่วยงาน</label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="detail_calendar_ums_department" id="detail_calendar_ums_department">

                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="detail_calendar_person_participate" class="form-label">ผู้เข้าร่วมกิจกรรม</label>
                                    <select class="form-select select2" data-placeholder="-- กรุณาเลือกบุคลากร --" name="detail_calendar_person_participate" id="detail_calendar_person_participate">

                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end justify-content-center">
                                    <button type="button" class="btn btn-success" id="detail_confirm_calendar_person">เลือก</button>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 mt-4 mb-4" id="detail_div_table_person_list">
                            <table id="detail_person_list" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">ชื่อ - นามสกุล</th>
                                        <!-- <th class="text-center">ประเภทบุคลากร</th>
                                        <th class="text-center">ตำแหน่งในการบริหารงาน</th> -->
                                        <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                                        <th class="text-center">ดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                <!-- <div class="d-grid gap-2 col-2 mx-auto">
                    <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อลบลบกิจกรรม" id="deleteEvent">ลบกิจกรรม</button>
                </div> -->
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <!-- <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อปิด" data-bs-dismiss="modal">ปิด</button> -->
                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อลบลบกิจกรรม" id="deleteEvent">ลบกิจกรรม</button>
                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อบันทึกลบกิจกรรม" id="updateEvent">บันทึกกิจกรม</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal สำหรับดูรายละเอียดของกิจกรรม -->
<div class="modal fade" id="eventViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียดกิจกรรม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <h6>ประเภทปฏิทิน</h6>
                    <div class="filter-label-text">
                        <div class="filter-dot-text" id="view_clnd_category_color"></div>
                        <span id="view_clnd_category"></span>
                    </div>

                </div>
                <div class='pt-2 mt-3'>
                    <h6>หัวเรื่อง</h6>
                    <span id="view_clnd_topic"></span>
                </div>
                <div class='pt-2 mt-3'>
                    <h6>รายละเอียด</h6>
                    <span id="view_clnd_detail"></span>
                </div>
                <div class='pt-2 mt-3'>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>วันที่</h6>
                            <span id="view_clnd_date"></span>
                        </div>
                        <div class="col-md-6">
                            <h6>เวลา</h6>
                            <span id="view_clnd_time"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อปิด" data-bs-dismiss="modal">ปิด</button>
            </div> -->
        </div>
    </div>
</div>

<!-- Modal สำหรับดูรายละเอียดของกิจกรรมสำหรับผู้เข้าร่วม -->
<div class="modal fade" id="eventShareModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียดกิจกรรม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <h6>ประเภทปฏิทิน</h6>
                    <div class="filter-label-text">
                        <div class="filter-dot-text" id="share_clnd_category_color"></div>
                        <span id="share_clnd_category"></span>
                    </div>

                </div>
                <div class='pt-2 mt-3'>
                    <h6>หัวเรื่อง</h6>
                    <span id="share_clnd_topic"></span>
                </div>
                <div class='pt-2 mt-3'>
                    <h6>รายละเอียด</h6>
                    <span id="share_clnd_detail"></span>
                </div>
                <div class='pt-2 mt-3'>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>วันที่</h6>
                            <span id="share_clnd_date"></span>
                        </div>
                        <div class="col-md-6">
                            <h6>เวลา</h6>
                            <span id="share_clnd_time"></span>
                        </div>
                    </div>
                </div>
                <div class='pt-2 mt-3'>
                    <h6>สร้างโดย</h6>
                    <span id="share_create_by"></span>
                </div>

                <div class="col-md-12 mt-4 mb-4" id="share_div_table_person_list">
                    <table id="share_person_list" class="table table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ชื่อ - นามสกุล</th>
                                <!-- <th class="text-center">ประเภทบุคลากร</th>
                                <th class="text-center">ตำแหน่งในการบริหารงาน</th> -->
                                <th class="text-center">ตำแหน่งปฏิบัติงาน</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <div class="d-grid gap-2 col-4 mx-auto">
                    <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อลบแท็กกิจกรรม" id="deleteEventShare">ลบแท็กกิจกรรม</button>
                </div>
            </div>
            <!-- <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อปิด" data-bs-dismiss="modal">ปิด</button>
            </div> -->
        </div>
    </div>
</div>

<script>
    let calendar;
    let categories = [];
    let nodeCategories = [];
    var newRender = true
    let activeCategories = new Set();
    let selectedParticipants = {};
    var last_month_check = '';
    var start_date_public = '';
    var end_date_public = '';
    var sucallback_pubic = '';
    let isViewDetail = false;
    const session_us_ps_id = <?php echo $this->session->userdata('us_ps_id'); ?>;

    $(document).ready(function() {
        $('#div_table_person_list').hide();
        $('#div_filter_person_list').hide();

        function renderFilters() {
            if (localStorage.getItem('calendarFilters') == null) {
                activeCategories.add(2)
                activeCategories.add(3)
                activeCategories.add(6)
                activeCategories.add(8)
            }
            const filterContainer = document.getElementById('filter-container');
            filterContainer.innerHTML = '';
            categories.forEach(category => {
                const filterLabel = document.createElement('div');
                filterLabel.className = 'filter-label';
                filterLabel.dataset.id = category.id; // เก็บ id ของ category ใน data-id
                filterLabel.innerHTML = `<div class="filter-dot" style="background-color: #${category.color};"></div><span>${category.name}</span>`;
                filterLabel.style.opacity = activeCategories.has(category.id) ? '1' : '0.5'; // กำหนดค่า opacity ตาม activeCategories
                filterLabel.addEventListener('click', () => toggleCategoryFilter(category.id, filterLabel));
                filterContainer.appendChild(filterLabel);
            });
            // Load saved filter settings
            // loadFilterSettings();
        }

        function toggleCategoryFilter(categoryId, filterLabel) {
            if (activeCategories.has(categoryId)) {
                activeCategories.delete(categoryId);
                filterLabel.style.opacity = "0.5";
            } else {
                activeCategories.add(categoryId);
                filterLabel.style.opacity = "1";
            }
            saveFilterSettings(); // บันทึกการเปลี่ยนแปลงฟิลเตอร์
            newRender = false
            calendar.destroy();
            renderCalendar()
        }

        function loadFilterSettings() {
            if (localStorage.getItem('calendarFilters') == null) {
                const currentCategories = []
                let filterLabel = document.querySelectorAll(`.filter-label`);
                if (filterLabel) {
                    filterLabel.forEach(element => {
                        currentCategories.push(element.dataset.id)
                    });
                }
                // ใช้ filter เพื่อหาค่าที่มีใน array2 แต่ไม่มีใน array1
                nodeCategories = currentCategories.map(item => Number(item)).filter(item => !activeCategories.has(item));
            } else {
                let filters = JSON.parse(localStorage.getItem('calendarFilters')) || [];
                filters.forEach(filter => {
                    let filterLabel = document.querySelector(`.filter-label[data-id="${filter.id}"]`);
                    activeCategories.add(parseInt(filter.id));
                    if (filterLabel) {
                        filterLabel.style.opacity = filter.opacity;
                        // if (filter.opacity == "1") {
                        //     if (nodeCategories.includes(filter.id)) {
                        //         const index = nodeCategories.indexOf(filter.id);
                        //         nodeCategories.splice(index, 1); // ลบค่าออกจาก array
                        //     }
                        // } 
                        // // else {
                        //     if (filter.opacity == '0.5' && !nodeCategories.includes(filter.id)) {
                        //         nodeCategories.push(filter.id); // เพิ่มค่าเข้าไปถ้าไม่มี
                        //     }
                        //     activeCategories.delete(parseInt(filter.id));
                        // }
                    }
                    // else {
                    //     if (filter.opacity == '0.5' && !nodeCategories.includes(filter.id)) {
                    //         nodeCategories.push(filter.id); // เพิ่มค่าเข้าไปถ้าไม่มี
                    //     }
                    // }
                });

            }
            // filterEventsByActiveCategories();
        }

        function saveFilterSettings() {
            const filters = Array.from(activeCategories)
                .map(filterLabel => ({
                    id: filterLabel,
                    opacity: 1
                }))
            localStorage.setItem('calendarFilters', JSON.stringify(filters));
        }


        function fetchEvents(start, end, callback) {
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_calendar_person",
                type: 'POST',
                data: {
                    start_date: start.toISOString(),
                    end_date: end.toISOString()
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    categories = data.category.map(cat => ({
                        id: parseInt(cat.id),
                        name: cat.category,
                        color: cat.color
                    }));
                    renderFilters();
                    loadFilterSettings()

                    function return_id(id) {
                        if (localStorage.getItem('calendarFilters') == null) {
                            return parseInt(id, 10)
                        } else {
                            return parseInt(id)
                        }
                    }                    
                    const events = data.data.filter(event => activeCategories.has(return_id(event.id)))
                        .map(event => ({
                            id: event.clnd_id,
                            title: event.clnd_topic,
                            start: `${event.clnd_start_date}T${event.clnd_start_time || '00:00:00'}`,
                            end: `${event.clnd_end_date}T${event.clnd_end_time || '23:59:59'}`,
                            allDay: (event.clnd_start_time == "00:00:00" && event.clnd_end_time == "00:00:00" ? true : false),
                            createUser: parseInt(event.clnd_ps_id),
                            createUserName: event.create_calender_by,
                            extendedProps: {
                                category: parseInt(event.id),
                                detail: event.clnd_detaid,
                                parent_id: event.clnd_parent_id,
                                count_parent: event.count_parent
                            },
                            backgroundColor: `#${event.color}`,
                            borderColor: `#${event.color}`,
                            description: event.clnd_detail,
                            categoryName: event.category
                        }))
                    callback(events);
                },
                error: function() {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'Error fetching events'
                    });
                }
            });
        }

        function renderCalendar() {
            calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                locale: 'th',
                initialView: 'dayGridMonth', // มุมมองเริ่มต้น
                initialDate: last_month_check == '' ? new Date().toISOString().split('T')[0] : last_month_check,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                navLinks: true,
                selectable: true,
                selectMirror: true,
                select: function(arg) {
                    const startDateSelect = moment(arg.start).add(543, 'years').format('DD/MM/YYYY');
                    const endDateSelect = moment(arg.end).subtract(1, 'days').add(543, 'years').format('DD/MM/YYYY');
                    document.getElementById('clnd_parent_id_1').checked = true;
                    $('#div_table_person_list').hide();
                    $('#div_filter_person_list').hide();
                    $(`#person_list tbody`).empty()
                    $('#eventModal').modal('show');
                    selectedParticipants = {};
                    document.getElementById('clnd_start_date').value = startDateSelect;
                    document.getElementById('clnd_end_date').value = endDateSelect;

                    document.getElementById('saveEvent').onclick = function() {
                        handleEventSaveOrUpdate('insert_calendar_person', 'eventForm');
                    };
                    calendar.unselect();
                },
                eventClick: function(arg) {
                    const selectedEvent = arg.event;
                    isViewDetail = false;
                    selectedParticipants = {};

                    if (parseInt(selectedEvent.extendedProps.category) != 1) {

                        if (session_us_ps_id == selectedEvent.extendedProps.createUser) {
                            setModalView(selectedEvent);
                            $('#eventViewModal').modal('show');
                        } else {
                            dialog_error({
                                'header': text_toast_default_error_header,
                                'body': 'ไม่ดูรายละเอียดได้'
                            });
                        }

                    } else {

                        if (selectedEvent.extendedProps.parent_id === null) {
                            $('#updateEvent').show();
                            $('#deleteEvent').show();
                            $('#update_clnd_id').val(selectedEvent.id);

                            setModalValues(selectedEvent);
                            loadDepartments('detail_', selectedEvent.id);

                            $('#eventDetailModal').modal('show');

                        } else {
                            $('#updateEvent').hide();
                            $('#deleteEvent').hide();

                            setModalShare(selectedEvent);
                            $('#eventShareModal').modal('show');
                            renderParticipantsTable('share_', 0, selectedEvent.extendedProps.parent_id, {});

                        }

                        $('#deleteEvent').off('click').on('click', function() {
                            handleEventDelete(selectedEvent, 0);
                        });

                        $('#deleteEventShare').off('click').on('click', function() {
                            handleEventDelete(selectedEvent, 1);
                        });

                        $('#updateEvent').off('click').on('click', function() {
                            handleEventSaveOrUpdate('update_calendar_person', 'eventDetailForm', selectedEvent.id);
                        });


                    }


                },
                editable: true,
                dayMaxEvents: true,
                events: function(info, successCallback, failureCallback) {
                    if (newRender) {
                        start_date_public = info.start
                        end_date_public = info.end
                        sucallback_pubic = successCallback
                        fetchEvents(info.start, info.end, successCallback);
                    } else {
                        fetchEvents(start_date_public, end_date_public, successCallback);
                        newRender = true
                    }
                },
                eventContent: function(arg) {
                    let category = arg.event.extendedProps.category;
                    let title = arg.event.title;
                    let description = arg.event.extendedProps.detail;
                    let startTime = !arg.event.allDay ? arg.event.start.toLocaleTimeString('th-TH', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }) : '';
                    let customHtml;

                    if (arg.view.type !== 'dayGridMonth') {
                        customHtml = `
                        <div class="fc-event-content" data-detail="${description}">
                            <div class="fc-event-header">
                                ${startTime ? `<span class="fc-event-time">${startTime}</span>` : ''}
                                <span class="fc-event-title">${title}</span>
                            </div>
                        </div>`;
                    } else {
                        customHtml = `
                        <div class="fc-event-content" data-detail="${description}">
                            <div class="fc-event-header">
                                ${startTime ? `<span class="fc-event-time">${startTime}</span>` : ''}
                                <span class="fc-event-title">${title}</span>
                            </div>
                        </div>`;
                    }
                    return {
                        html: customHtml
                    };
                },
                eventDidMount: function(info) {

                    const color = info.event.backgroundColor;
                    if (color) {
                        info.el.style.backgroundColor = color;
                        info.el.style.borderColor = color;
                    }

                    const endDate = info.event.end ? info.event.end : info.event.start;
                    var detail = info.event.extendedProps.description;
                    const startTime = info.event.allDay ?
                        'ตลอดวัน' :
                        `${info.event.start.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit', hour12: false })} - ${endDate.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit', hour12: false })}`;

                    if (detail == "" || detail == null) {
                        detail = "ไม่ระบุ";
                    }

                    if (detail.length > 50) {
                        detail = detail.substring(0, 50) + '...';
                    }

                    const tooltip = document.createElement('div');
                    tooltip.className = 'tooltip-text';
                    tooltip.innerHTML = `<strong>เวลา:</strong> ${startTime}<br><strong>รายละเอียด:</strong> ${detail}`;

                    document.body.appendChild(tooltip);

                    info.el.addEventListener('mouseenter', function() {
                        const rect = info.el.getBoundingClientRect();
                        tooltip.style.top = `${rect.top + window.scrollY - tooltip.offsetHeight}px`;
                        tooltip.style.left = `${rect.left + window.scrollX + (rect.width / 2) - (tooltip.offsetWidth / 2)}px`;
                        tooltip.style.visibility = 'visible';
                        tooltip.style.opacity = '1';
                    });

                    info.el.addEventListener('mouseleave', function() {
                        tooltip.style.visibility = 'hidden';
                        tooltip.style.opacity = '0';
                    });
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                datesSet: function(info) {
                    last_month_check = info.view.currentEnd.toISOString().split('T')[0]; // the end date of the view
                }
            });

            calendar.render();
            renderFilters();
        }

        function validateForm(formId, eventId) {
            const form = document.getElementById(formId);
            var topic = "";
            var checkAllDay = "";
            var startTime = "";
            var endTime = "";
            if (eventId) {
                topic = form.querySelector('[name="detail_clnd_topic"]').value.trim();
                checkAllDay = form.querySelector('[name="detail_check_all_day"]').checked;
                startTime = form.querySelector('[name="detail_clnd_start_time"]');
                endTime = form.querySelector('[name="detail_clnd_end_time"]');
            } else {
                topic = form.querySelector('[name="clnd_topic"]').value.trim();
                checkAllDay = form.querySelector('[name="check_all_day"]').checked;
                startTime = form.querySelector('[name="clnd_start_time"]');
                endTime = form.querySelector('[name="clnd_end_time"]');
            }
            if (topic === '') {
                form.querySelector('[name="clnd_topic"]').classList.add('is-invalid');
                // dialog_error({'header':text_toast_default_error_header, 'body': 'กรุณากรอกหัวเรื่อง' });
                return false;
            } else {
                // topic.classList.remove('is-invalid');
            }

            if (!checkAllDay) {
                if (startTime.value === '') {
                    startTime.classList.add('is-invalid');
                    $("div.invalid-feedback").hide();
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'กรุณากรอกเวลาเริ่มต้น'
                    });
                    return false;
                } else {
                    startTime.classList.remove('is-invalid');
                }

                if (endTime.value === '') {
                    endTime.classList.add('is-invalid');
                    $("div.invalid-feedback").hide();
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'กรุณากรอกเวลาสิ้นสุด'
                    });
                    return false;
                } else {
                    endTime.classList.remove('is-invalid');
                }

                const [startHour, startMinute] = startTime.value.split(':').map(Number);
                const [endHour, endMinute] = endTime.value.split(':').map(Number);

                const startDate = new Date();
                startDate.setHours(startHour, startMinute);

                const endDate = new Date();
                endDate.setHours(endHour, endMinute);

                if (startDate >= endDate) {
                    startTime.classList.add('is-invalid');
                    endTime.classList.add('is-invalid');
                    $("div.invalid-feedback").hide();
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'เวลาเริ่มต้นต้องน้อยกว่าเวลาสิ้นสุด'
                    });
                    return false;
                } else {
                    startTime.classList.remove('is-invalid');
                    endTime.classList.remove('is-invalid');
                }
            }

            return true;
        }

        function collectEventData(formId, eventId = null) {
            const form = document.getElementById(formId);
            var checkAllDay = "";
            var startTime = "";
            var endTime = "";
            var topic = "";
            var detail = "";
            var startDate = "";
            var endDate = "";
            var clnd_parent_id = "";
            if (eventId) {
                checkAllDay = form.querySelector('[name="detail_check_all_day"]').checked;
                startTime = form.querySelector('[name="detail_clnd_start_time"]').value;
                endTime = form.querySelector('[name="detail_clnd_end_time"]').value;
                topic = form.querySelector('[name="detail_clnd_topic"]').value.trim();
                detail = form.querySelector('[name="detail_clnd_detail"]').value.trim();
                startDate = form.querySelector('[name="detail_clnd_start_date"]').value;
                endDate = form.querySelector('[name="detail_clnd_end_date"]').value;
                clnd_parent_id = form.querySelector('input[name="detail_clnd_parent_id"]:checked').value;
            } else {
                checkAllDay = form.querySelector('[name="check_all_day"]').checked;
                startTime = form.querySelector('[name="clnd_start_time"]').value;
                endTime = form.querySelector('[name="clnd_end_time"]').value;
                topic = form.querySelector('[name="clnd_topic"]').value.trim();
                detail = form.querySelector('[name="clnd_detail"]').value.trim();
                startDate = form.querySelector('[name="clnd_start_date"]').value;
                endDate = form.querySelector('[name="clnd_end_date"]').value;
                clnd_parent_id = form.querySelector('input[name="clnd_parent_id"]:checked').value;
            }

            let eventData = {
                clnd_topic: topic,
                clnd_detail: detail,
                clnd_start_date: startDate,
                clnd_end_date: endDate,
                clnd_start_time: checkAllDay ? '' : startTime,
                clnd_end_time: checkAllDay ? '' : endTime,
                check_all_day: checkAllDay,
                category: 1,
                isShare: clnd_parent_id,
                person_list: selectedParticipants
            };

            if (eventId) {
                eventData.clnd_id = eventId;
            }

            return eventData;
        }

        function createEventObject(data) {
            const startDateISO = convertToCalendarType(data.clnd_start_date, !data.clnd_start_time && !data.clnd_end_time ? '00:00' : data.clnd_start_time);
            const endDateISO = convertToCalendarType(data.clnd_end_date, !data.clnd_start_time && !data.clnd_end_time ? '23:59' : data.clnd_end_time);
            return {
                id: data.clnd_id,
                title: data.clnd_topic,
                start: startDateISO,
                end: endDateISO,
                allDay: !data.clnd_start_time && !data.clnd_end_time,
                createUser: parseInt(data.clnd_ps_id),
                createUserName: $("#detail_create_clnd_by").text(),
                extendedProps: {
                    category: parseInt(data.category),
                    detail: data.clnd_detail,
                    parent_id: data.clnd_parent_id,
                    count_parent: event.count_parent
                },
                backgroundColor: '#3498DB',
                borderColor: '#3498DB',
                description: data.clnd_detail,
                categoryName: "กิจกรรมส่วนตัว"
            };
        }

        function setModalValues(event) {
            $('#detail_clnd_topic').val(event.title);
            $('#detail_clnd_detail').val(event.extendedProps.description);
            $('#detail_clnd_start_date').val(event.start.toLocaleDateString('th-TH', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }));

            const endDate = event.end ? event.end : event.start;
            $('#detail_clnd_end_date').val(endDate.toLocaleDateString('th-TH', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }));

            $('#detail_clnd_start_time').val(event.allDay ? '' : event.start.toLocaleTimeString('th-TH', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }));
            $('#detail_clnd_end_time').val(event.allDay ? '' : endDate.toLocaleTimeString('th-TH', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }));
            $('#detail_check_all_day').prop('checked', event.allDay);
            $('#detail_create_clnd_by').text(event.createUserName);

            if (event.extendedProps.count_parent == 0) {
                $('#detail_clnd_parent_id_1').prop('checked', true);
                togglePersonList('detail_', 'N');
            } else {
                $('#detail_clnd_parent_id_2').prop('checked', true);
                togglePersonList('detail_', 'Y');
            }

            const inputStartTime = document.getElementById('detail_clnd_start_time');
            const inputEndTime = document.getElementById('detail_clnd_end_time');
            inputStartTime.disabled = event.allDay;
            inputEndTime.disabled = event.allDay;
        }

        function setModalView(event) {
            let endDate = event.end ? event.end : event.start;
            let dayStartView = event.start.toLocaleDateString('th-TH', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
            let dayEndView = endDate.toLocaleDateString('th-TH', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
            let dayView = dayStartView + " ถึง " + dayEndView;

            let timeStartView = event.allDay ? '' : event.start.toLocaleTimeString('th-TH', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
            let timeEndView = event.allDay ? '' : endDate.toLocaleTimeString('th-TH', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
            let timeView = timeStartView + " ถึง " + timeEndView;
            if (timeStartView == "" && timeEndView == "") {
                timeView = "ตลอดวัน";
            }
            $('#view_clnd_category_color').css('background-color', event.backgroundColor);
            $('#view_clnd_category').text(event.extendedProps.categoryName);
            $('#view_clnd_topic').text(event.title);
            $('#view_clnd_detail').text(event.extendedProps.description);
            $('#view_clnd_date').text(dayView);
            $('#view_clnd_time').text(timeView);

            $('#view_create_clnd_by').text(event.extendedProps.createUserName);

        }

        function setModalShare(event) {
            let endDate = event.end ? event.end : event.start;
            let dayStartView = event.start.toLocaleDateString('th-TH', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
            let dayEndView = endDate.toLocaleDateString('th-TH', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
            let dayView = dayStartView + " ถึง " + dayEndView;

            let timeStartView = event.allDay ? '' : event.start.toLocaleTimeString('th-TH', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
            let timeEndView = event.allDay ? '' : endDate.toLocaleTimeString('th-TH', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
            let timeView = timeStartView + " ถึง " + timeEndView;
            if (timeStartView == "" && timeEndView == "") {
                timeView = "ตลอดวัน";
            }
            $('#share_clnd_category_color').css('background-color', event.backgroundColor);
            $('#share_clnd_category').text(event.extendedProps.categoryName);
            $('#share_clnd_topic').text(event.title);
            $('#share_clnd_detail').text(event.extendedProps.description);
            $('#share_clnd_date').text(dayView);
            $('#share_clnd_time').text(timeView);

            $('#share_create_by').text(event.extendedProps.createUserName);

        }

        function resetForm(formId) {
            const form = document.getElementById(formId);
            form.reset();
            form.querySelectorAll('.form-control').forEach(input => input.classList.remove('is-valid', 'is-invalid'));
        }

        function convertToCalendarType(dateString, timeString) {
            let [day, month, year] = dateString.split('/');
            year = (parseInt(year, 10) - 543).toString();
            month = month.padStart(2, '0');
            day = day.padStart(2, '0');
            return `${year}-${month}-${day}T${timeString}`;
        }

        document.getElementById('check_all_day').addEventListener('change', function() {
            const inputStartTime = document.getElementById('clnd_start_time');
            const inputEndTime = document.getElementById('clnd_end_time');
            inputStartTime.disabled = this.checked;
            inputEndTime.disabled = this.checked;
            if (this.checked) {
                inputStartTime.value = '';
                inputEndTime.value = '';
            }
        });

        document.getElementById('detail_check_all_day').addEventListener('change', function() {
            const inputStartTime = document.getElementById('detail_clnd_start_time');
            const inputEndTime = document.getElementById('detail_clnd_end_time');
            inputStartTime.disabled = this.checked;
            inputEndTime.disabled = this.checked;
            if (this.checked) {
                inputStartTime.value = '';
                inputEndTime.value = '';
            }
        });

        function setDefaultDate(type) {
            flatpickr(`#${type}clnd_start_date`, {
                plugins: [new rangePlugin({
                    input: `#${type}clnd_end_date`
                })],
                dateFormat: 'd/m/Y',
                locale: 'th',
                onReady: () => {
                    convertYearsToThai();
                },
                onOpen: () => convertYearsToThai(),
                onValueUpdate: (selectedDates) => {
                    convertYearsToThai();
                    if (selectedDates[0]) document.getElementById(`${type}clnd_start_date`).value = formatDateToThai(selectedDates[0]);
                    if (selectedDates[1]) document.getElementById(`${type}clnd_end_date`).value = formatDateToThai(selectedDates[1]);
                },
                onMonthChange: convertYearsToThai,
                onYearChange: convertYearsToThai
            });

            flatpickr(`#${type}clnd_start_time`, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                defaultDate: "12:00"
            });
            flatpickr(`#${type}clnd_end_time`, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                defaultDate: "13:00"
            });
        }

        function loadDepartments(action = '', clnd_id = '') {
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_all_ums_department",
                method: 'GET',
                success: function(data) {
                    data = JSON.parse(data);
                    populateDepartments(action, clnd_id, data);
                }
            });
        }

        function populateDepartments(action, clnd_id, data) {
            let departmentOptions = '';
            data.forEach(function(department) {
                departmentOptions += `<option value="${department.dp_id}">${department.dp_name_th}</option>`;
            });
            $('#' + action + 'calendar_ums_department').html(departmentOptions).trigger('change');
            $('#' + action + 'calendar_ums_department option:eq(0)').prop('selected', true).trigger('change');
        }

        function loadParticipants(action = '', clnd_id = '', departmentId) {
            if (departmentId) {
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_person_all_by_ums_department",
                    data: {
                        dp_id: departmentId
                    },
                    method: 'GET',
                    success: function(data) {
                        data = JSON.parse(data);
                        populateParticipants(action, clnd_id, data);
                    }
                });
            } else {
                $('#calendar_person_participate').html('<option></option>').trigger('change');
            }
        }

        function renderParticipantsTable(action, isView, clnd_id, person) {
            if (!isViewDetail) {
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_parent_ums_calendar_by_id",
                    data: {
                        clnd_id: clnd_id,
                        isView: isView
                    },
                    method: 'GET',
                    success: function(response) {
                        const participants = JSON.parse(response).data;
                        $(`#${action}person_list tbody`).empty()

                        if (action == 'detail_') {
                            participants.forEach(participant => {
                                const {
                                    ps_id,
                                    fullname,
                                    hire_name,
                                    admin_name,
                                    alp_name
                                } = participant;
                                const rowCount = $(`#${action}person_list tbody tr`).length + 1;
                                // const td = `
                                //     <tr data-id="${ps_id}">
                                //         <td class="text-center">${rowCount}</td>
                                //         <td class="text-start">${fullname}</td>
                                //         <td class="text-center">${hire_name || ''}</td>
                                //         <td class="text-center">${admin_name || ''}</td>
                                //         <td class="text-center">${alp_name || ''}</td>
                                //         <td class="text-center">
                                //             <button type="button" class="btn btn-danger delete-participant" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อลบกิจกรรม">
                                //                 <i class="bi-trash"></i>
                                //             </button>
                                //         </td>
                                //     </tr>
                                // `;
                                const td = `
                                <tr data-id="${ps_id}">
                                    <td class="text-center">${rowCount}</td>
                                    <td class="text-start">${fullname}</td>
                                    <td class="text-center">${alp_name || ''}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger delete-participant" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อลบกิจกรรม">
                                            <i class="bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;

                                $(`#${action}person_list tbody`).append(td);

                                selectedParticipants[ps_id] = {
                                    id: ps_id
                                };
                            });

                            let participantOptions = '';
                            person.forEach(participant => {
                                const {
                                    ps_id,
                                    fullname,
                                    hire_name,
                                    admin_name,
                                    alp_name
                                } = participant;
                                if (!selectedParticipants[ps_id]) {
                                    participantOptions += `<option value="${ps_id}" data-name="${fullname}" data-type="${hire_name || ''}" data-admin-position="${admin_name || ''}" data-work-position="${alp_name || ''}">${fullname}</option>`;
                                }
                            });

                            $(`#${action}calendar_person_participate`).html(participantOptions).trigger('change');

                            $(`#${action}calendar_person_participate option:eq(0)`).prop('selected', true).trigger('change');

                            $('[data-bs-toggle="tooltip"]').tooltip();

                            isViewDetail == true;
                        } else {
                            participants.forEach(participant => {
                                const {
                                    ps_id,
                                    fullname,
                                    hire_name,
                                    admin_name,
                                    alp_name
                                } = participant;
                                const rowCount = $(`#${action}person_list tbody tr`).length + 1;

                                const td = `
                                <tr data-id="${ps_id}">
                                    <td class="text-center">${rowCount}</td>
                                    <td class="text-start">${fullname}</td>
                                    <td class="text-center">${alp_name || ''}</td>
                                </tr>
                            `;

                                $(`#${action}person_list tbody`).append(td);

                                // Apply the background color using --bs-table-bg after appending
                                if (participants.length > 1 && session_us_ps_id == ps_id) {
                                    $(`#${action}person_list tbody tr[data-id="${ps_id}"]`).css({
                                        "--bs-table-bg": "#fff8254f"
                                    });
                                }
                            });

                        }


                    }
                });
            }


        }

        function populateParticipants(action, clnd_id, data) {

            if (action === 'detail_') {
                renderParticipantsTable(action, 1, clnd_id, data);
            } else {
                let participantOptions = '';
                data.forEach(participant => {
                    const {
                        ps_id,
                        fullname,
                        hire_name,
                        admin_name,
                        alp_name
                    } = participant;
                    if (!selectedParticipants[ps_id]) {
                        participantOptions += `<option value="${ps_id}" data-name="${fullname}" data-type="${hire_name || ''}" data-admin-position="${admin_name || ''}" data-work-position="${alp_name || ''}">${fullname}</option>`;
                    }
                });

                $(`#${action}calendar_person_participate`).html(participantOptions).trigger('change');
                $(`#${action}calendar_person_participate option:eq(0)`).prop('selected', true).trigger('change');
            }



        }

        function addSelectedParticipantToTable() {
            const selectedParticipant = $('#calendar_person_participate option:selected');
            if (selectedParticipant.val()) {
                const participantId = selectedParticipant.val();
                const participantName = selectedParticipant.data('name');
                const participantType = selectedParticipant.data('type');
                const adminPosition = selectedParticipant.data('admin-position');
                const workPosition = selectedParticipant.data('work-position');

                if (selectedParticipants[participantId]) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'ไม่สามารถเลือกผู้เข้าร่วมซ้ำได้'
                    });
                    return;
                }

                const rowCount = $('#person_list tbody tr').length + 1;
                // $('#person_list tbody').append(`
                //     <tr data-id="${participantId}">
                //         <td class="text-center">${rowCount}</td>
                //         <td class="text-start">${participantName}</td>
                //         <td class="text-center">${participantType}</td>
                //         <td class="text-center">${adminPosition}</td>
                //         <td class="text-center">${workPosition}</td>
                //         <td class="text-center">
                //             <button type="button" class="btn btn-danger delete-participant" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อลบกิจกรรม">
                //                 <i class="bi-trash"></i>
                //             </button>
                //         </td>
                //     </tr>
                // `);
                $('#person_list tbody').append(`
                <tr data-id="${participantId}">
                    <td class="text-center">${rowCount}</td>
                    <td class="text-start">${participantName}</td>
                    <td class="text-center">${workPosition}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger delete-participant" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อลบกิจกรรม">
                            <i class="bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `);

                selectedParticipants[participantId] = {
                    id: participantId
                };

                $('#calendar_person_participate').val(null).trigger('change');
                loadParticipants('', '', $('#calendar_ums_department').val());
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        }

        function updateSelectedParticipantToTable() {
            const selectedClnd_id = $('#update_clnd_id').val();
            const selectedParticipant = $('#detail_calendar_person_participate option:selected');

            if (selectedParticipant.val()) {
                const participantId = selectedParticipant.val();
                const participantName = selectedParticipant.data('name');
                const participantType = selectedParticipant.data('type');
                const adminPosition = selectedParticipant.data('admin-position');
                const workPosition = selectedParticipant.data('work-position');

                if (selectedParticipants[participantId]) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'ไม่สามารถเลือกผู้เข้าร่วมซ้ำได้'
                    });
                    return;
                }

                const rowCount = $('#detail_person_list tbody tr').length + 1;
                $('#detail_person_list tbody').append(`
                <tr data-id="${participantId}">
                    <td class="text-center">${rowCount}</td>
                    <td class="text-start">${participantName}</td>
                    <td class="text-center">${workPosition}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger delete-participant-detail" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อลบกิจกรรม">
                            <i class="bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `);

                selectedParticipants[participantId] = {
                    id: participantId
                };
                let departmentId = $("#detail_calendar_ums_department").val();
                $.ajax({
                    url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "get_person_all_by_ums_department",
                    data: {
                        dp_id: departmentId
                    },
                    method: 'GET',
                    success: function(data) {
                        person = JSON.parse(data);
                        let participantOptions = '';
                        person.forEach(participant => {
                            const {
                                ps_id,
                                fullname,
                                hire_name,
                                admin_name,
                                alp_name
                            } = participant;
                            if (!selectedParticipants[ps_id]) {
                                participantOptions += `<option value="${ps_id}" data-name="${fullname}" data-type="${hire_name || ''}" data-admin-position="${admin_name || ''}" data-work-position="${alp_name || ''}">${fullname}</option>`;
                            }
                        });

                        $(`#detail_calendar_person_participate`).html(participantOptions).trigger('change');

                        $(`#detail_calendar_person_participate option:eq(0)`).prop('selected', true).trigger('change');
                        // loadParticipants('detail_', selectedClnd_id, $('#detail_calendar_ums_department').val());
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    }
                });

            }
        }

        $('#calendar_ums_department').on('change', function() {
            let departmentId = $(this).val();
            loadParticipants('', '', departmentId);
        });

        $('#detail_calendar_ums_department').on('change', function() {
            let departmentId = $(this).val();
            let selectedClnd_id = $('#update_clnd_id').val();
            loadParticipants('detail_', selectedClnd_id, departmentId);
        });

        $('#confirm_calendar_person').on('click', function() {
            addSelectedParticipantToTable();
        });

        $('#detail_confirm_calendar_person').on('click', function() {
            updateSelectedParticipantToTable();
        });

        $(document).on('click', '.delete-participant', function() {
            const row = $(this).closest('tr');
            const participantId = row.data('id');

            delete selectedParticipants[participantId];
            row.remove();
            reindexTable();
            loadParticipants('', '', $('#calendar_ums_department').val());
        });

        $(document).on('click', '.delete-participant-detail', function() {
            const selectedClnd_id = $('#update_clnd_id').val();
            const row = $(this).closest('tr');
            const participantId = row.data('id');

            delete selectedParticipants[participantId];
            row.remove();
            reindexTable('detail_');
            // loadParticipants('detail_', selectedClnd_id, $('#detail_calendar_ums_department').val());
        });

        function reindexTable(action = "") {
            $('#' + action + 'person_list tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }

        function handleEventSaveOrUpdate(apiEndpoint, formId, eventId = null) {

            if (validateForm(formId, eventId)) {

                const eventData = collectEventData(formId, eventId);
                if (eventData.category == 1) {

                    $.ajax({
                        url: `<?php echo site_url() . "/" . $controller_dir; ?>${apiEndpoint}`,
                        type: 'POST',
                        data: eventData,
                        success: function(data) {
                            data = JSON.parse(data);
                            const event = createEventObject(data.data);

                            if (apiEndpoint === 'insert_calendar_person') {
                                calendar.addEvent(event);
                            } else {
                                const existingEvent = calendar.getEventById(eventId);
                                if (existingEvent) {
                                    existingEvent.remove();
                                }
                                calendar.addEvent(event);
                            }

                            resetForm(formId);
                            $(`#${apiEndpoint === 'insert_calendar_person' ? 'eventModal' : 'eventDetailModal'}`).modal('hide');
                            dialog_success({
                                'header': text_toast_save_success_header,
                                'body': data.data.message_dialog
                            });
                        },
                        error: function() {
                            dialog_error({
                                'header': text_toast_default_error_header,
                                'body': 'Error saving or updating event'
                            });
                        }
                    });
                } else {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'ไม่สามารถเพิ่มกิจกรรมในหมวดหมู่นี้ได้'
                    });
                }
            } else {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': 'กรุณากรอกกิจกรรมให้ครบถ้วน'
                });
            }
        }

        function handleEventDelete(selectedEvent, isShare) {
            let text_confirm = "";
            if (isShare == 0) {
                text_confirm = "ต้องการลบกิจกรรมนี้หรือไม่";
            } else {
                text_confirm = "ต้องการลบแท็กกิจกรรมนี้หรือไม่";
            }
            if (parseInt(selectedEvent.extendedProps.category) == 1) {
                Swal.fire({
                    title: "ยืนยันการลบกิจกรรม",
                    text: text_confirm,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "ลบ",
                    cancelButtonText: "ยกเลิก"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?php echo site_url() . "/" . $controller_dir; ?>' + "delete_calendar_person",
                            type: 'POST',
                            data: {
                                clnd_id: selectedEvent.id
                            },
                            success: function(data) {
                                data = JSON.parse(data);
                                selectedEvent.remove();
                                $('#eventDetailModal').modal('hide');
                                dialog_success({
                                    'header': text_toast_save_success_header,
                                    'body': data.data.message_dialog
                                });
                            },
                            error: function() {
                                dialog_error({
                                    'header': text_toast_default_error_header,
                                    'body': 'Error deleting event'
                                });
                            }
                        });
                    }
                });
            } else {
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': 'ไม่สามารถลบกิจกรรมในหมวดหมู่นี้ได้'
                });
            }
        }

        setDefaultDate('');
        setDefaultDate('detail_');
        renderCalendar();

        loadDepartments();
    });

    function togglePersonList(action = '', value) {

        if (value == 'N') {
            $('#' + action + 'div_table_person_list').slideUp();
            $('#' + action + 'div_filter_person_list').slideUp();
        } else {
            $('#' + action + 'div_table_person_list').slideDown();
            $('#' + action + 'div_filter_person_list').slideDown();
        }
    }
</script>