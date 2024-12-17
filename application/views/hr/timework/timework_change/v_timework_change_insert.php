<style>

</style>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
        <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button accordion-button-table" type="button">
                                <i class="bi-table icon-menu"></i><span> เลือกตารางการทำงานเดิมที่ต้องการเปลี่ยน
                            </button>
                        </h2>
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <form id="oldEventForm" class="row g-3 needs-validation">
                                    <div class="col-md-4">
                                        <label class="form-label required" for="old_plan_date">ช่วงวันที่</label>
                                        <input type="text" id="old_plan_date" name="old_plan_date" class="form-control" value="" onchange="get_timework_attendance_config_list('old')">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label required" for="old_plan_date">รูปแบบการลงเวลาทำงาน</label>
                                        <select class="form-control twac-select select2" id="old_select_twac_id" name="old_select_twac_id" onchange="get_time_attendance_detail(value)">
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label" for="old_plan_end_time_label">เวลา</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="old_plan_start_time" placeholder="เวลาเริ่มต้น" disabled>
                                            <span class="input-group-text">ถึง</span>
                                            <input type="text" class="form-control" id="old_plan_end_time" placeholder="เวลาสิ้นสุด" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="old_bd_id">หน่วยงาน</label>
                                        <p id="old_bd_id"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="old_rm_id">ห้อง/สถานที่</label>
                                        <p id="old_rm_id"></p>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="old_plan_desc">รายละเอียดเพิ่มเติมหรือหมายเหตุ</label>
                                        <p id="old_plan_desc"></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-5">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button accordion-button-table" type="button">
                                <i class="bi-table icon-menu"></i><span> เลือกตารางการทำงานใหม่ที่ต้องการเปลี่ยน
                            </button>
                        </h2>
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <form id="newEventForm" class="row g-3 needs-validation">
                                    
                                    <div class="col-md-4">
                                        <label class="form-label required" for="new_plan_date">ช่วงวันที่</label>
                                        <input type="text" class="form-control" id="new_plan_date" placeholder="เลือกช่วงวันที่" onchange="get_timework_attendance_config_list('new')">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label required" for="new_plan_date">รูปแบบการลงเวลาทำงาน</label>
                                        <select class="form-control twac-select select2" id="new_twac_id" name="new_twac_id" onchange="get_time_attendance_detail(value)">
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label required" for="new_plan_end_time_label">เวลา</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="new_plan_start_time" placeholder="เลือกเวลาเริ่มต้น" disabled>
                                            <span class="input-group-text">ถึง</span>
                                            <input type="text" class="form-control" id="new_plan_end_time" placeholder="เลือกเวลาสิ้นสุด" disabled>
                                        </div>
                                    </div>                                                      
                                    <div class="col-md-6">
                                        <label for="new_bd_id" class="form-label">หน่วยงาน</label>
                                        <select class="form-control building-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="new_bd_id" id="new_bd_id" onchange="get_eqs_room_list(this.value)">
                                            <?php foreach ($base_ums_department_list as $key => $row) { ?>
                                                <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required" for="new_rm_id">ห้อง/สถานที่</label>
                                        <select class="form-control room-select select2" id="new_rm_id" name="new_rm_id">
                                        </select>
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" id="checkbox_new_rm_id" name="checkbox_new_rm_id">
                                            <label class="form-check-label" for="checkbox_new_rm_id">
                                                ไม่ระบุ
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label required" for="new_plan_desc">หมายเหตุที่ต้องการเปลี่ยนตารางวันทำงาน</label>
                                        <textarea class="form-control" id="new_plan_desc" placeholder="หมายเหตุที่ต้องการเปลี่ยนตารางวันทำงาน"></textarea>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อลบข้อมูล" id="deleteEventButton">ลบ</button>
                                        <!-- <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อยกเลิก" data-bs-dismiss="modal">ยกเลิก</button> -->
                                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อบันทึกข้อมูล" id="saveChangesButton">บันทึก</button>
                                    </div>
                                </form>
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
    flatpickr("#old_plan_date", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
        // defaultDate: new Date(new Date().getFullYear() + 543, 0, 1),
        // minDate: "today",
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
                document.getElementById('old_plan_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('old_plan_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    flatpickr("#new_plan_date", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        // defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
        // defaultDate: new Date(new Date().getFullYear() + 543, 0, 1),
        minDate: "today",
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
                document.getElementById('new_plan_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('new_plan_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    get_eqs_room_list();
    handleRoomSelect('#checkbox_new_rm_id', '#new_rm_id');
    get_timework_attendance_config_list('new');
    get_timework_attendance_config_list('old');
});

// Function to get the timework attendance config list and populate the select
function get_timework_attendance_config_list(action="", date=""){
    
    if(date==""){
        var date = $("#".action."_plan_date").val();
    }
    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_timework_attendance_config_list',
        type: 'GET',
        data: {
            date: date
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
                    flatpickr("#".action."_plan_date", {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        time_24hr: true,
                        defaultDate: row.twac_start_time
                    });

                    flatpickr("#".action."_plan_date", {
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

function get_time_attendance_config(value="") {
    if(bd_id == ""){
        var bd_id = $("#new_bd_id").val();
    }
    
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


// Function to get the room list based on the selected building
function get_eqs_room_list(bd_id=""){
    if(bd_id == ""){
        var bd_id = $("#new_bd_id").val();
    }
    
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
</script>