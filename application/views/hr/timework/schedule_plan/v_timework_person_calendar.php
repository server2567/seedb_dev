<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "assets/plugins/event-calendar/event-calendar.min.css"; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "assets/plugins/event-calendar/event-calendar-global.css"; ?>">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/event-calendar/event-calendar.min.js"></script>



<style>
.ec-timeline .ec-time, .ec-timeline .ec-line {
    width: 50px;
}
</style>

<div class="card">
    <div class="card-body">
        <h5 class="card-title" id="current-month">ปฏิทินการทำงาน</h5>
        <div id="calendar_show"></div>
    </div>
</div>


<script type="text/javascript">
let selectedEvent = null; // To store the currently selected event
var calendar_show;

$(document).ready(function() {
    setDefaultDate('add'); // Set default date for adding events
    initializeCalendar(); // Initialize the calendar
});

function initializeCalendar() {
    calendar_show = new EventCalendar(document.getElementById('calendar_show'), {
        view: 'resourceTimelineWeek',
        locale: 'th',
        headerToolbar: {
            start: 'prev,next today',
            center: 'title',
            end: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek resourceTimeGridWeek,resourceTimelineWeek'
        },
        buttonText: {
            today: 'วันนี้',
            dayGridMonth: 'เดือน',
            timeGridWeek: 'สัปดาห์',
            timeGridDay: 'วัน',
            listWeek: 'รายการ',
            resourceTimeGridWeek: 'แนวตั้ง',
            resourceTimelineWeek: 'แนวนอน'
        },
        resources: getResources(),
        scrollTime: '00:00:00',
        events: createEvents(),
        views: getViewSettings(),
        dayMaxEvents: true,
        nowIndicator: true,
        selectable: true,
        dateClick: handleDateClick,
        select: handleSelect,
        eventClick: handleEventClick,
        eventDrop: handleEventDrop,
        eventResize: handleEventResize
    });
}

function getResources() {
    return [
        {id: 1, title: 'John Doe'},
        {id: 2, title: 'Jane Smith'},
        {id: 3, title: 'Michael Johnson'},
        {id: 4, title: 'Emily Davis'},
        {id: 5, title: 'William Brown'},
        // Add more people as needed
    ];
}


function getViewSettings() {
    return {
        timeGridWeek: {pointer: true},
        resourceTimeGridWeek: {pointer: true},
        resourceTimelineWeek: {
            pointer: true,
            slotWidth: 50,
            resources: getResources()
        }
    };
}

function handleDateClick(info) {
    // Open modal for adding event
    openAddEventModal();

    // Set default values in the modal based on the clicked date
    const clickedDate = new Date(info.dateStr);
    const startDate = formatDate(clickedDate);
    const endDate = formatDate(new Date(clickedDate.getTime() + 60 * 60 * 1000));
    const startTime = formatTime(clickedDate);
    const endTime = formatTime(new Date(clickedDate.getTime() + 60 * 60 * 1000));

    setDefaultDate('add', startTime, endTime, startDate, endDate);

    // Set the selected resource in the modal
    if (info.resource) {
        document.getElementById('add_plan_resource').value = info.resource.id;
    } else {
        document.getElementById('add_plan_resource').value = '';
    }
}

function handleSelect(info) {
    // Open modal for adding event after selecting a time range
    openAddEventModal();

    const startDate = formatDate(info.start);
    const endDate = formatDate(info.end);
    const startTime = formatTime(info.start);
    const endTime = formatTime(info.end);

    setDefaultDate('add', startTime, endTime, startDate, endDate);

    // Set the selected resource in the modal
    if (info.resource) {
        document.getElementById('add_plan_resource').value = info.resource.id;
    } else {
        document.getElementById('add_plan_resource').value = '';
    }
}

function handleEventClick(info) {
    // Open modal for editing the event
    selectedEvent = info.event;
    $('#editEventModal').modal('show');

    // Set default values in the modal fields based on the clicked event's data
    const startDate = selectedEvent.start ? formatDate(new Date(selectedEvent.start)) : '';
    const startTime = selectedEvent.start ? formatTime(new Date(selectedEvent.start)) : '';
    const endDate = selectedEvent.end ? formatDate(new Date(selectedEvent.end)) : startDate;
    const endTime = selectedEvent.end ? formatTime(new Date(selectedEvent.end)) : startTime;

    document.getElementById('edit_plan_title').value = selectedEvent.title || '';
    document.getElementById('edit_plan_start_time').value = startTime;
    document.getElementById('edit_plan_end_time').value = endTime;
    document.getElementById('edit_plan_resource').value = selectedEvent.resourceIds[0] || '';

    document.getElementById('edit_plan_date').value = `${startDate} - ${endDate}`;

    setDefaultDate('edit', startTime, endTime, startDate, endDate);

    document.getElementById('saveChangesButton').onclick = saveEventChanges;
    document.getElementById('deleteEventButton').onclick = deleteEvent;
}

function handleEventDrop(info) {
    const event = info.event;
    const localStart = event.start;
    const localEnd = event.end;
    const newResourceId = info.newResource ? info.newResource.id : event.resourceIds[0];

    // Update the event's resourceId
    event.resourceIds = [newResourceId];
}

function handleEventResize(info) {
    const newStart = new Date(info.event.start.getTime());
    const newEnd = new Date(info.event.end.getTime());
    info.event.start = formatDateTime(newStart);
    info.event.end = formatDateTime(newEnd);
}

function saveEventChanges() {
    const newTitle = document.getElementById('edit_plan_title').value.trim();
    const dateRange = document.getElementById('edit_plan_date').value.split(' - ');
    let newStartDate = dateRange[0];
    let newEndDate = dateRange[1] || newStartDate;
    const newStartTime = document.getElementById('edit_plan_start_time').value;
    const newEndTime = document.getElementById('edit_plan_end_time').value;
    const newResourceId = document.getElementById('edit_plan_resource').value;

    newStartDate = convertToGregorian(newStartDate);
    newEndDate = convertToGregorian(newEndDate);

    const newStart = new Date(`${newStartDate}T${newStartTime}`);
    const newEnd = new Date(`${newEndDate}T${newEndTime}`);

    if (!validateEventInputs(newTitle, newStart, newEnd)) {
        return;
    }

    // Remove the old event and add a new one with the updated details
    calendar_show.removeEventById(selectedEvent.id);
    calendar_show.addEvent({
        start: newStart,
        end: newEnd,
        resourceId: newResourceId,
        title: newTitle,
        color: selectedEvent.backgroundColor,
    });

    $('#editEventModal').modal('hide');
}

function validateEventInputs(title, start, end) {
    if (!title) {
        alert('กรุณากรอกชื่อกิจกรรม');
        return false;
    }
    if (isNaN(start.getTime())) {
        alert('กรุณากรอกวันที่และเวลาเริ่มต้นที่ถูกต้อง');
        return false;
    }
    if (isNaN(end.getTime())) {
        alert('กรุณากรอกวันที่และเวลาสิ้นสุดที่ถูกต้อง');
        return false;
    }
    if (end <= start) {
        alert('เวลาสิ้นสุดต้องอยู่หลังเวลาเริ่มต้น');
        return false;
    }
    return true;
}

function deleteEvent() {
    calendar_show.removeEventById(selectedEvent.id);
    $('#editEventModal').modal('hide');
}

function createEvents() {
    let days = [];
    for (let i = 0; i < 7; ++i) {
        let day = new Date();
        let diff = i - day.getDay();
        day.setDate(day.getDate() + diff);
        days[i] = day.getFullYear() + "-" + _pad(day.getMonth() + 1) + "-" + _pad(day.getDate());
    }

    // Sample event data with unique IDs
    return [
        {id: 'event-001', start: days[0] + " 00:00", end: days[0] + " 09:00", resourceId: 1, display: "background"},
        {id: 'event-002', start: days[1] + " 12:00", end: days[1] + " 14:00", resourceId: 2, display: "background"},
        {id: 'event-003', start: days[2] + " 17:00", end: days[2] + " 24:00", resourceId: 1, display: "background"},
        {id: 'event-004', start: days[0] + " 10:00", end: days[0] + " 14:00", resourceId: 1, title: "ปฏิทินสามารถแสดงกิจกรรมพื้นหลังและกิจกรรมปกติได้", color: "#FE6B64"},
        {id: 'event-005', start: days[1] + " 16:00", end: days[2] + " 08:00", resourceId: 2, title: "กิจกรรมอาจครอบคลุมวันถัดไป", color: "#B29DD9"},
        {id: 'event-006', start: days[2] + " 09:00", end: days[2] + " 13:00", resourceId: 2, title: "สามารถกำหนดกิจกรรมให้กับทรัพยากรได้ และปฏิทินมีมุมมองทรัพยากรในตัว", color: "#779ECB"},
        {id: 'event-007', start: days[3] + " 14:00", end: days[3] + " 20:00", resourceId: 1, title: "", color: "#FE6B64"},
        {id: 'event-008', start: days[3] + " 15:00", end: days[3] + " 18:00", resourceId: 1, title: "กิจกรรมที่ซ้อนกันจะถูกจัดตำแหน่งอย่างถูกต้อง", color: "#779ECB"},
        {id: 'event-009', start: days[5] + " 10:00", end: days[5] + " 16:00", resourceId: 2, title: {html: "คุณสามารถควบคุมการ <i><b>แสดงผล</b></i> ของกิจกรรมได้อย่างสมบูรณ์…"}, color: "#779ECB"},
        {id: 'event-010', start: days[5] + " 14:00", end: days[5] + " 19:00", resourceId: 2, title: "…และคุณสามารถลากและวางกิจกรรมได้!", color: "#FE6B64"},
        {id: 'event-011', start: days[5] + " 18:00", end: days[5] + " 21:00", resourceId: 2, title: "", color: "#B29DD9"},
        {id: 'event-012', start: days[1], end: days[3], resourceId: 1, title: "สามารถแสดงกิจกรรมทั้งวันได้ที่ด้านบน", color: "#B29DD9", allDay: true}
    ];
}


function _pad(num) {
    return String(num).padStart(2, '0');
}

function setDefaultDate(type, startTime = null, endTime = null, startDate = null, endDate = null) {
    const currentDate = new Date();
    const firstDayOfMonth = new Date(currentDate.getFullYear() + 543, currentDate.getMonth(), 1);
    const lastDayOfMonth = new Date(currentDate.getFullYear() + 543, currentDate.getMonth() + 1, 0);

    if (startDate && typeof startDate === 'string') {
        startDate = parseDateString(startDate);
    }

    if (endDate && typeof endDate === 'string') {
        endDate = parseDateString(endDate);
    }

    if (!startDate || isNaN(startDate.getTime())) {
        startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    }

    if (!endDate || isNaN(endDate.getTime())) {
        endDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    }

    const startDateString = formatDateToString(startDate);
    const endDateString = formatDateToString(endDate);

    // Initialize flatpickr for date range
    flatpickr(`#${type}_plan_date`, {
        mode: 'range',
        dateFormat: 'd/m/Y',
        locale: 'th',
        defaultDate: [startDateString, endDateString],
        minDate: formatDateToString(firstDayOfMonth),
        maxDate: formatDateToString(lastDayOfMonth),
        onReady: convertYearsToThai,
        onOpen: convertYearsToThai,
        onValueUpdate: (selectedDates) => {
            convertYearsToThai();
            if (selectedDates[0]) document.getElementById(`${type}_plan_date`).value = formatDateToString(selectedDates[0]);
            if (selectedDates[1]) document.getElementById(`${type}_plan_date`).value += ' ถึง ' + formatDateToString(selectedDates[1]);
        },
        onMonthChange: convertYearsToThai,
        onYearChange: convertYearsToThai
    });

    // Initialize flatpickr for start time
    flatpickr(`#${type}_plan_start_time`, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        defaultDate: startTime
    });

    // Initialize flatpickr for end time
    flatpickr(`#${type}_plan_end_time`, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        defaultDate: endTime
    });
}

function convertToGregorian(dateString) {
    const parts = dateString.split('/');
    const day = parts[0];
    const month = parts[1];
    let year = parseInt(parts[2], 10);

    if (year > 2400) {
        year -= 543;
    }

    return `${year}-${month}-${day}`;
}

function convertYear(year, direction) {
    if (!year || isNaN(year)) {
        alert('เลือกปีไม่ถูกต้อง');
        return null;
    }

    if (direction === 'toCE') {
        return year - 543;
    } else if (direction === 'toBE') {
        return year + 543;
    } else {
        alert('ไม่สามารถคำนวณปีได้');
        return null;
    }
}

function formatDateToString(date) {
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
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

function openAddEventModal() {
    const currentDate = new Date();
    const startDate = formatDate(currentDate);
    const endDate = formatDate(new Date(currentDate.getTime() + 60 * 60 * 1000));
    const startTime = formatTime(currentDate);
    const endTime = formatTime(new Date(currentDate.getTime() + 60 * 60 * 1000));

    document.getElementById('add_plan_title').value = '';
    document.getElementById('add_plan_date').value = `${startDate} - ${endDate}`;
    document.getElementById('add_plan_start_time').value = startTime;
    document.getElementById('add_plan_end_time').value = endTime;

    $('#addEventModal').modal('show');
}

function parseDateString(dateStr) {
    const timestamp = Date.parse(dateStr);
    if (isNaN(timestamp)) {
        return null;
    }
    return new Date(timestamp);
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
    const title = document.getElementById('add_plan_title').value;
    const dateRange = document.getElementById('add_plan_date').value;
    const startTimeElement = document.getElementById('add_plan_start_time');
    const endTimeElement = document.getElementById('add_plan_end_time');
    const personID = document.getElementById('add_plan_resource').value;

    if (!startTimeElement || !endTimeElement) {
        return;
    }

    const startTime = startTimeElement.value;
    const endTime = endTimeElement.value;

    if (title && dateRange && startTime && endTime) {
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
        
        calendar_show.addEvent({
            start: startDateTime,
            end: endDateTime,
            resourceId: personID,
            title: title,
            color: '#FE6B64',
        });

        $('#addEventModal').modal('hide');
    } else {
        alert('กรุณากรอกข้อมูลให้ครบ');
    }
}

</script>



<!-- Modal สำหรับเพิ่มกิจกรรม -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEventModalLabel">เพิ่มกิจกรรม</h5>
      </div>
      <div class="modal-body">
        <form id="addEventForm">
          <div class="form-group">
            <label for="add_plan_title">ชื่อกิจกรรม</label>
            <input type="text" class="form-control" id="add_plan_title" placeholder="ใส่ชื่อกิจกรรม">
          </div>
          <div class="form-group">
            <label for="add_plan_date">ช่วงวันที่</label>
            <input type="text" class="form-control" id="add_plan_date" placeholder="เลือกช่วงวันที่">
          </div>
          <div class="form-group">
            <label for="add_plan_start_time_label">เวลาเริ่มต้น</label>
            <input type="text" class="form-control" id="add_plan_start_time" placeholder="เลือกเวลาเริ่มต้น">
          </div>
          <div class="form-group">
            <label for="add_plan_end_time_label">เวลาสิ้นสุด</label>
            <input type="text" class="form-control" id="add_plan_end_time" placeholder="เลือกเวลาสิ้นสุด">
          </div>
          <div class="form-group">
            <label for="add_plan_resource">เลือกทรัพยากร</label>
            <select class="form-control" id="add_plan_resource">
              <option value="1">ทรัพยากร A</option>
              <option value="2">ทรัพยากร B</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn btn-primary" onclick="saveEvent()">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal สำหรับแก้ไขหรือลบกิจกรรม -->
<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editEventModalLabel">แก้ไขข้อมูลกิจกรรม</h5>
        </div>
        <div class="modal-body">
            <form id="editEventForm">
            <div class="form-group">
                <label for="edit_plan_title">ชื่อกิจกรรม</label>
                <input type="text" class="form-control" id="edit_plan_title" name="edit_plan_title">
            </div>
            <div class="form-group">
                <label for="edit_plan_date">ช่วงวันที่</label>
                <input type="text" class="form-control" id="edit_plan_date" placeholder="เลือกช่วงวันที่">
            </div>
            <div class="form-group">
                <label for="edit_plan_start_time">เวลาเริ่มต้น</label>
                <input type="text" class="form-control" id="edit_plan_start_time" name="edit_plan_start_time">
            </div>
            <div class="form-group">
                <label for="edit_plan_end_time">เวลาสิ้นสุด</label>
                <input type="text" class="form-control" id="edit_plan_end_time" name="edit_plan_end_time">
            </div>
            <div class="form-group">
                <label for="edit_plan_resource">ทรัพยากร</label>
                <select class="form-control" id="edit_plan_resource" name="edit_plan_resource">
                    <!-- เพิ่มตัวเลือกทรัพยากรที่มีในระบบของคุณ -->
                    <option value="1">ทรัพยากร A</option>
                    <option value="2">ทรัพยากร B</option>
                    <!-- ตัวเลือกทรัพยากรเพิ่มเติม -->
                </select>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="deleteEventButton">ลบ</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
            <button type="button" class="btn btn-primary" id="saveChangesButton">บันทึก</button>
        </div>
        </div>
    </div>
</div>




