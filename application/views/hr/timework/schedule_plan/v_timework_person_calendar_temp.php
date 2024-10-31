<style>
    .opt-tools {
    height: 100%;
    width: 25px;
    right: -21px;
    position: absolute;
    border: 1px solid #e8e8e8;
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}

.opt-edit,
.opt-trash {
    height: 50%;
    line-height: 25px;
    text-align: center;
    font-size: 13px;
    cursor: pointer;
}

.opt-edit {
    border-bottom: 1px solid #e8e8e8;
    border-top-right-radius: 8px;
    background-color: #fff;
    color: #ff8e00;
}

.opt-edit:hover {
    color: #fff;
    background-color: #ff8e00;
}

.opt-trash {
    border-bottom-right-radius: 8px;
    background-color: #fff;
    color: #cc0000;
}

.opt-trash:hover {
    color: #fff;
    background-color: #cc0000;
}

/* LOCK HEADER AND FIRST COLUMN */
.table td,
.table th {
    padding: 5px !important;
}

/* Background color for the hovered cell */
.ui-droppable.cal-cell:hover {
    /* background-color: #f6f4b6; */
}

th:first-child,
td:first-child {
    position: sticky;
    left: 0;
}

th:first-child {
    z-index: 100;
}

td:first-child {
    z-index: 100;
}

thead th {
    position: sticky;
    top: 0;
    z-index: 100;
}

/* DateTime Picker */
.datetimepicker {
    width: 70% !important;
    height: 70% !important;
}

/* Calendar Container */
.cal-container {
    max-width: 900px;
    max-height: 500px;
    overflow: auto;
    margin: auto;
}

.cal-table {
    position: relative;
    border: solid #ebebeb;
    border-width: 0 1px 0 0;
    overscroll-behavior: contain;
}

/* Calendar Table Header */
.cal-thead {
    top: 0;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.04);
}

.cal-viewmonth {
    font-size: 16px;
    background: #fdfdfd;
    width: 150px;
    height: 50px;
    font-weight: 700;
    text-align: center;
    vertical-align: middle;
    position: sticky !important; /* ทำให้ cal-viewmonth ยึดติด */
    top: 0; /* ระบุตำแหน่งจากด้านบนของหน้าจอ */
    z-index: 150 !important; /* ตั้งค่า z-index เพื่อให้ชั้นของมันอยู่บนสุด */
    background-color: #fdfdfd; /* สีพื้นหลังเพื่อให้แน่ใจว่าไม่มีส่วนใดของตารางมาบัง */
    padding: 10px; /* เพิ่ม padding ถ้าจำเป็น */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* เพิ่มเงาให้เห็นความแตกต่างเมื่อเลื่อน */
    background-color: #6c757d !important;
    color: #fff !important;
}

.cal-toprow {
    width: 182px;
    min-width: 182px;
    color: #3e5569;
    background-color: #f7f9fb;
    border: 1px solid #ebebeb !important;
    font-weight: 700 !important;
    text-align: center;
    vertical-align: middle !important;
}

.cal-userinfo {
    vertical-align: top; /* Align content to the top of the cell */
    min-height: 100px; /* Set a minimum height for the user info cell */
    display: flex;
    align-items: center;
    white-space: nowrap; /* Prevent content from wrapping */
    overflow: hidden; /* Hide overflow if content is too large */
}

.cal-userinfo img {
    width: 70px; /* Adjust image size */
    height: 70px;
    border-radius: 50%; /* Circular image */
    margin-right: 10px; /* Space between image and text */
    margin-left: 10px;
}

.cal-userinfo span {
    display: inline-block; /* Ensure the span adjusts according to content */
    font-weight: 500;
    color: #333;
}



/* Weekend Style */
.weekend {
    background-color: #b5b5b5;
}

/* Draggable Tasks */
.drag {
    z-index: 10;
    /* cursor: pointer; */
    margin-bottom: 5px; /* Add some space between draggable elements */
}

.ui-draggable-dragging {
    z-index: 9999 !important;
    transform: rotate(-5deg);
}

/* Task Details */
.details {
    border-radius: 4px;
    background: #fff;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid #ebecee;
    padding: 5px 10px;
    margin: 2px;
    z-index: 1;
    /* transition: transform 0.2s ease, box-shadow 0.2s ease; */
}

.details:hover {
    /* transform: scale(1.1); */
    /* box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15); */
}

.details-uren {
    font-size: 12px;
    color: #333;
    font-weight: 500;
    text-align: right;
}

.details-task {
    font-size: 12px;
    padding: 5px;
    font-weight: 600;
    line-height: 1.4;
    border-radius: 2px;
    margin-bottom: 5px;
}

/* Timeline */
.timeline-header,
.timeline-row {
    display: flex;
    min-width: 800px;
}

.timeline-header .cell,
.timeline-row .cell {
    width: 100px;
    padding: 5px;
    text-align: center;
    border: 1px solid #ccc;
}

.timeline-row .resource {
    width: 150px;
    padding: 5px;
    text-align: left;
    font-weight: bold;
    background-color: #e6f2ff;
    border: 1px solid #ccc;
}

/* Datepicker */
.datepicker-container {
    position: relative;
}

.datepicker {
    display: none;
    position: absolute;
    top: 25px;
}

/* View Toggle */
.view-toggle {
    margin-bottom: 10px;
}

/* Table Controls */
.table-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.search-container {
    flex: 1;
    max-width: 300px;
}

.search-container input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s ease;
}

.search-container input:focus {
    border-color: #007bff;
}

.view-buttons {
    display: flex;
    align-items: center;
}

.view-buttons button,
.view-buttons i {
    margin-left: 5px;
    padding: 8px 16px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.view-buttons button:hover,
.view-buttons i:hover {
    background-color: #0056b3;
}

.view-buttons i {
    padding: 8px;
    font-size: 18px;
    border-radius: 50%;
}

.view-buttons i.disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

/* Card */
.card {
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin: 20px auto;
    padding: 20px;
}

.card-title {
    font-size: 24px;
    font-weight: 600;
    color: #007bff;
    margin-bottom: 20px;
    text-align: center;
}

/* Calendar Table Styles */
.timeline-container {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
    overflow-x: auto;
    margin-top: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.table th,
.table td {
    padding: 10px;
    text-align: center;
    vertical-align: middle;
    /* background-color: #fff; */
}

.cal-thead th {
    background-color: #f7f9fb;
    font-weight: 700;
    color: #3e5569;
}
/* Style the placeholder to indicate the drop position */
.ui-sortable-placeholder {
    background-color: #f7f9fb; /* Light background color to match the hover */
    border: 2px dashed #ccc;  /* Dashed border to indicate it's a placeholder */
    visibility: visible !important;
    height: 50px; /* Ensure it has the same height as your sortable items */
    margin: 2px 0; /* Add some margin to match other items */
    border-radius: 4px; /* Rounded corners for a consistent look */
}

/* Add a shadow to the placeholder for a more pronounced effect */
.ui-sortable-placeholder {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.search-container {
    position: relative;
    display: flex;
    align-items: center;
}

.filter-icon {
    margin-right: 10px;
    cursor: pointer;
    color: #fff;
    float: right;
    transition: color 0.3s ease, transform 0.3s ease; /* เพิ่ม transition สำหรับการเปลี่ยนสีและขนาด */
}


.filter-icon:hover {
    color: #fff;
    transform: scale(1.3); /* เพิ่มการขยายขนาดเล็กน้อยเมื่อ hover */
}
/* Additional styling for modal and other elements */

td.ui-droppable {
    vertical-align: top; /* Ensure that the content is aligned to the top of the cell */
    padding: 5px; /* Optional: Add padding to the cells */
    min-height: 50px; /* Set a minimum height for the cells */
    white-space: nowrap; /* Prevent content from wrapping */
}

.records-per-page {
    vertical-align: middle;
}
.records-per-page label {
    margin-right: 10px;
    font-weight: 600;
}
.records-per-page select {
    display: inline-block;
    width: auto;
    border-radius: 4px;
}
.drag.ui-resizable {
    resize: both;
    overflow: hidden;
}

.drag .ui-resizable-e {
    width: 10px;
    right: -5px;
    cursor: e-resize;
    position: absolute;
    top: 0;
    height: 100%;
}

.drag .ui-resizable-w {
    width: 10px;
    left: -5px;
    cursor: w-resize;
    position: absolute;
    top: 0;
    height: 100%;
}

</style>
<div class="card">
    <div class="card-body">
        <h5 class="card-title" id="current-month"></h5>
        <div class="table-controls">
            <div class="search-container">
                <input type="text" id="search-input" placeholder="ค้นหา...">
            </div>
            <div class="view-buttons">
                <i id="left-arrow" class="bi bi-chevron-left disabled"></i>
                <button id="week-view">สัปดาห์</button>
                <button id="month-view">เดือน</button>
                <i id="right-arrow" class="bi bi-chevron-right"></i>
            </div>
        </div>
        <div class="records-per-page">
            <select class="form-control" id="recordsPerPage"  name="recordsPerPage">
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="all">ทั้งหมด</option>
            </select>
        </div>
        <div class="timeline-container">
            <table class="table table-bordered">
                <thead class="cal-thead">
                    <!-- Header cells will be dynamically generated here -->
                </thead>
                <tbody class="cal-tbody">
                    <!-- Timeline rows will be dynamically generated here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>

var obj_data = [];
const monthsInThai = [
    'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 
    'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 
    'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
];

const daysOfWeek = ['จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.', 'อา.'];

$(document).ready(function() {
   

//     obj_data = [
//     {
//         name: 'สมชาย กิจเจริญ',
//         hours: '160:00',
//         tasks: [
//             { date: '2024-08-01', name: 'อบรม', time: '09:00 - 12:00', color: '#51FF00' },
//             { date: '2024-08-02', name: 'กะเช้า', time: '08:00 - 16:00', color: '#792020' },
//             { date: '2024-08-03', name: 'ป่วย', time: '00:00 - 00:00', color: '#AF0000' },
//             { date: '2024-08-04', name: 'กะบ่าย', time: '14:00 - 22:00', color: '#2473AB' },
//             { date: '2024-08-15', name: 'ประชุม', time: '09:00 - 11:00', color: '#FFC107' },
//             { date: '2024-08-21', name: 'ตรวจสุขภาพ', time: '10:00 - 12:00', color: '#FF5722' },
//             { date: '2024-08-28', name: 'ออกบูธ', time: '08:00 - 17:00', color: '#03A9F4' },
//         ]
//     },
//     {
//         name: 'สมหญิง กุลศรี',
//         hours: '140:30',
//         tasks: [
//             { date: '2024-08-05', name: 'ลาพักร้อน', time: '00:00 - 00:00', color: '#1E895A' },
//             { date: '2024-08-06', name: 'กะดึก', time: '22:00 - 06:00', color: '#FFA500' },
//             { date: '2024-08-07', name: 'สัมมนา', time: '09:00 - 16:00', color: '#673AB7' },
//             { date: '2024-08-14', name: 'อบรม', time: '13:00 - 15:00', color: '#009688' },
//             { date: '2024-08-22', name: 'ดูงาน', time: '09:00 - 12:00', color: '#795548' },
//             { date: '2024-08-30', name: 'เลี้ยงส่ง', time: '18:00 - 21:00', color: '#FF4081' },
//         ]
//     },
//     {
//         name: 'สมปอง ศรีสุข',
//         hours: '120:45',
//         tasks: [
//             { date: '2024-08-08', name: 'ตรวจสอบ', time: '10:00 - 12:00', color: '#9C27B0' },
//             { date: '2024-08-16', name: 'ประชุมผู้บริหาร', time: '14:00 - 16:00', color: '#8BC34A' },
//             { date: '2024-08-18', name: 'สัมมนา', time: '09:00 - 16:00', color: '#00BCD4' },
//             { date: '2024-08-23', name: 'สัมมนา', time: '09:00 - 16:00', color: '#673AB7' },
//         ]
//     },
//     {
//         name: 'สมบัติ ทองแท้',
//         hours: '180:30',
//         tasks: [
//             { date: '2024-08-09', name: 'ตรวจสุขภาพ', time: '09:00 - 12:00', color: '#FF5722' },
//             { date: '2024-08-12', name: 'อบรมการจัดการ', time: '10:00 - 15:00', color: '#795548' },
//             { date: '2024-08-19', name: 'สัมมนา', time: '09:00 - 16:00', color: '#607D8B' },
//             { date: '2024-08-25', name: 'ตรวจสุขภาพ', time: '10:00 - 12:00', color: '#FF9800' },
//         ]
//     },
//     {
//         name: 'สมคิด ใจดี',
//         hours: '150:15',
//         tasks: [
//             { date: '2024-08-01', name: 'ประชุมทีม', time: '09:00 - 11:00', color: '#03A9F4' },
//             { date: '2024-08-03', name: 'ประชุมผู้บริหาร', time: '13:00 - 15:00', color: '#8BC34A' },
//             { date: '2024-08-07', name: 'อบรมการบริหาร', time: '08:00 - 12:00', color: '#FFC107' },
//             { date: '2024-08-10', name: 'ตรวจสอบเอกสาร', time: '10:00 - 12:00', color: '#9C27B0' },
//             { date: '2024-08-14', name: 'สัมมนา', time: '09:00 - 16:00', color: '#00BCD4' },
//         ]
//     },
//     {
//         name: 'สมพงษ์ มั่นคง',
//         hours: '170:45',
//         tasks: [
//             { date: '2024-08-04', name: 'ประชุมโครงการ', time: '10:00 - 12:00', color: '#795548' },
//             { date: '2024-08-08', name: 'ดูงาน', time: '08:00 - 17:00', color: '#FF4081' },
//             { date: '2024-08-12', name: 'กะบ่าย', time: '14:00 - 22:00', color: '#2473AB' },
//             { date: '2024-08-16', name: 'ตรวจสอบสถานที่', time: '13:00 - 15:00', color: '#FF5722' },
//             { date: '2024-08-20', name: 'สัมมนา', time: '09:00 - 16:00', color: '#673AB7' },
//         ]
//     },
//     {
//         name: 'สมจิตร วงศ์ดี',
//         hours: '190:00',
//         tasks: [
//             { date: '2024-08-02', name: 'ประชุมทีม', time: '09:00 - 12:00', color: '#51FF00' },
//             { date: '2024-08-05', name: 'กะดึก', time: '22:00 - 06:00', color: '#FFA500' },
//             { date: '2024-08-11', name: 'ลาพักร้อน', time: '00:00 - 00:00', color: '#1E895A' },
//             { date: '2024-08-17', name: 'สัมมนา', time: '09:00 - 16:00', color: '#009688' },
//             { date: '2024-08-22', name: 'ดูงาน', time: '10:00 - 15:00', color: '#FF4081' },
//             { date: '2024-08-29', name: 'อบรม', time: '13:00 - 16:00', color: '#FFC107' },
//         ]
//     }
// ];


    get_person_list();

   
    $('#week-view').on('click', function() {
        viewMode = 'week';
        currentWeekOffset = 0;
        updateMonthOrWeekDisplay();
        generateCalendarHeader();
        generateCalendar(obj_data);
        updateArrowButtons();
    });

    $('#month-view').on('click', function() {
        viewMode = 'month';
        currentWeekOffset = 0;
        updateMonthOrWeekDisplay();
        generateCalendarHeader();
        generateCalendar(obj_data);
        updateArrowButtons();
    });

    $('#left-arrow').on('click', function() {
        if (currentWeekOffset > 0) {
            currentWeekOffset--;
            updateMonthOrWeekDisplay();
            generateCalendarHeader();
            generateCalendar(obj_data);
            updateArrowButtons();
        }
    });

    $('#right-arrow').on('click', function() {
        if (currentWeekOffset < weekRanges.length - 1) {
            currentWeekOffset++;
            updateMonthOrWeekDisplay();
            generateCalendarHeader();
            generateCalendar(obj_data);
            updateArrowButtons();
        }
    });

     // Debounce for search input to optimize performance
     const debounce = (func, delay) => {
        let debounceTimer;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(context, args), delay);
        };
    };

    $('#search-input').on('keyup keydown', debounce(function() {
        const searchText = $(this).val().toLowerCase();
        $('.cal-tbody tr').each(function() {
            const personName = $(this).find('.ui-droppable').text().toLowerCase();
            if (personName.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }, 300));  // 300ms debounce delay

    // Initialize sortable on the table rows
    // $('.cal-tbody').sortable({
    //     items: 'tr',
    //     handle: '.drag',
    //     placeholder: 'ui-sortable-placeholder',
    //     helper: 'clone',
    //     revert: true,
    //     update: function(event, ui) {
    //         const sortedIDs = $(this).sortable('toArray');
    //         console.log('New order:', sortedIDs);
    //         // Handle the updated order here, maybe send it to the server.
    //     },
    //     start: function(event, ui) {
    //         ui.placeholder.height(ui.helper.outerHeight());
    //     }
    // });

    $('#applyFilter').on('click', function() {
        get_person_list();
        $('#filterModal').modal('hide');
    });


    // // Show modal to edit task
    // $(document).on("click", ".opt-edit", function () {
        
    //     // Get task ID and DATE from DATA attribute
    //     var taskid = $(this).parent().parent().data("taskid"),
    //         userid = $(this).parent().parent().data("userid");
    //     // Get DATE
    //     var date = $(this).closest("td").data("date");
    //     // insert data to Modal
    //     $("#ktxt")[0].jscolor.fromString("FFFFFF");
    //     $("#kbg")[0].jscolor.fromString("8E8E8E");
    //     $("#demotaak2").css("color", "#FFFFFF");
    //     $("#demotaak1").css("border-left-color", "#8E8E8E");
    //     $("#demotaak2").css("background-color", "#8E8E8E");
    //     $("#edittask").modal("show");
    // });

    // // Modal remove task ?
    // $(document).on("click", ".opt-trash", function () {
    //     var taskid = $(this).parent().parent().data("taskid");

    //     $("#taskdelid").val(taskid);
    //     $("#modal-delete").html(
    //         "Are you sure you want to delete task ID <b>" + taskid + "</b>?"
    //     );
    //     $("#deletetask").modal("show");
    // });

    // // Remove task after conformation
    // $(document).on("click", "#confdelete", function () {
    //     var taskid = $("#taskdelid").val();
    //     $("div")
    //         .find("[data-taskid=" + taskid + "]")
    //         .remove();
    //     $("#deletetask").modal("hide");
    // });
    // ฟังก์ชันนี้จะทำการแสดงข้อมูลตามจำนวนที่เลือก
   
   

    // จัดการเมื่อมีการเปลี่ยนจำนวนรายการที่จะแสดง
    $('#recordsPerPage').change(function() {
        const limit = $(this).val() === 'all' ? 'all' : parseInt($(this).val(), 10);
        updateTableDisplay(limit);
    });

    updateTableDisplay(10);
    updateMonthOrWeekDisplay();
    generateCalendarHeader();
    updateArrowButtons();
   
});

$(document).on('mouseenter', '.ui-droppable.cal-cell', function() {
    const personIndex = $(this).data('person-index');
    const dayIndex = $(this).data('day-index');

    // Highlight the corresponding user info
    $(`#userinfo-${personIndex}`).css('background-color', '#f6f4b6');

    // Highlight the corresponding header (date)
    const nthChildIndex = dayIndex + 1; // หรือปรับเป็น 1 หรือ 2 ขึ้นอยู่กับโครงสร้าง HTML
    $(`.cal-thead th:nth-child(${nthChildIndex})`).css('background-color', '#f6f4b6');


});

$(document).on('mouseleave', '.ui-droppable.cal-cell', function() {
    const personIndex = $(this).data('person-index');
    const dayIndex = $(this).data('day-index');

    // Remove highlight from user info
    $(`#userinfo-${personIndex}`).css('background-color', '');

    // Remove highlight from header (date)
    const nthChildIndex = dayIndex + 1; // หรือปรับเป็น 1 หรือ 2 ขึ้นอยู่กับโครงสร้าง HTML
    $(`.cal-thead th:nth-child(${nthChildIndex})`).css('background-color', '#f7f9fb');

});

let viewMode = 'month'; // Default view mode
    let currentWeekOffset = 0;
    const today = new Date();
    const currentDay = today.getDate();
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear() + 543; // Convert to Buddhist year
    
    const firstDayOfMonth = new Date(today.getFullYear(), currentMonth, 1);
    const lastDayOfMonth = new Date(today.getFullYear(), currentMonth + 1, 0);
    const daysInMonth = lastDayOfMonth.getDate();

    const weekRanges = [
        { start: 1, end: 7 },
        { start: 8, end: 14 },
        { start: 15, end: 21 },
        { start: 22, end: 29 },
        { start: 30, end: daysInMonth },
    ];

    function getWeekRange(weekOffset) {
        return weekRanges[weekOffset] || { start: 1, end: 7 };
    }

    function updateMonthOrWeekDisplay() {
        const $leftArrow = $('#left-arrow');
        const $rightArrow = $('#right-arrow');

        if (viewMode === 'week') {
            const { start, end } = getWeekRange(currentWeekOffset);
            $('#current-month').text(`สัปดาห์ ${start} - ${end} ${monthsInThai[currentMonth]} ${currentYear}`);
            $leftArrow.show();
            $rightArrow.show();
        } else {
            $('#current-month').text(`${monthsInThai[currentMonth]} ${currentYear}`);
            $leftArrow.hide();
            $rightArrow.hide();
        }
    }

    function updateTableDisplay(limit) {
        const $rows = $('.cal-tbody tr');
        $rows.show();

        if (limit !== 'all') {
            $rows.slice(limit).hide();
        }
    }

    function generateCalendarHeader() {
        const $thead = $('.cal-thead');
        $thead.empty();
        
        let headerRow = '<tr>';
        headerRow += '<th class="cal-viewmonth">รายชื่อบุคลากร <i id="filter-icon" class="bi bi-filter-square filter-icon font-20" data-bs-toggle="modal" data-bs-target="#filterModal"></i></th>';

        if (viewMode === 'week') {
            const { start, end } = getWeekRange(currentWeekOffset);
            for (let i = start; i <= end; i++) {
                const day = new Date(today.getFullYear(), currentMonth, i);
                headerRow += `<th class="cal-toprow">${daysOfWeek[day.getDay()]} ${i}</th>`;
            }
        } else if (viewMode === 'month') {
            for (let i = 1; i <= daysInMonth; i++) {
                const day = new Date(today.getFullYear(), currentMonth, i);
                headerRow += `<th class="cal-toprow">${daysOfWeek[day.getDay()]} ${i}</th>`;
            }
        }

        headerRow += '</tr>';
        $thead.append(headerRow);
    }

    function generateCalendar(data) {
        const $tbody = $('.cal-tbody');
        $tbody.empty();

        let { start, end } = viewMode === 'week' ? getWeekRange(currentWeekOffset) : { start: 1, end: daysInMonth };

        data.forEach((person, personIndex) => {
            let profilePictureUrl = '<?php echo site_url($this->config->item("hr_dir") . "getIcon?type=" . $this->config->item("hr_profile_dir") . "profile_picture&image="); ?>' + 
                (person.psd_picture != null ? person.psd_picture : 'default.png');

            let userRow = `<tr id="user-row-${personIndex}">
                <td id="userinfo-${personIndex}" class="cal-userinfo">
                    <img src="${profilePictureUrl}" alt="User Image">
                    <span>${person.pf_name} ${person.ps_fname} ${person.ps_lname}</span>
                    <div class="cal-usercounter">
                        <span class="cal-userbadge badge badge-light">${person.hours || '0:00'}</span>
                    </div>
                </td>`;

            for (let i = start; i <= end; i++) {
                const date = new Date(today.getFullYear(), currentMonth, i);
                const formattedDate = formatDate(date);

                let cellContent = '';
                if (person.tasks && Array.isArray(person.tasks)) {
                    const tasksForTheDay = person.tasks.filter(task => {
                        const taskStartDate = new Date(task.start_date);
                        const taskEndDate = new Date(task.end_date);
                        return date >= taskStartDate && date <= taskEndDate;
                    });

                    tasksForTheDay.forEach(task => {
                        const rgbColor = hexToRgb(task.color);
                        const bgColor = convertRGBtoRGBA(rgbColor, 0.1);

                        const isStart = task.start_date === formattedDate;
                        const isEnd = task.end_date === formattedDate;

                        cellContent += `
                        <div class="drag details ui-draggable ui-resizable" 
                            style="background-color: ${bgColor}; border: 2px solid ${task.color}; border-radius: 8px; padding: 5px; position: relative; z-index: 0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 6px;"
                            data-task-id="${task.id}" 
                            data-task-name="${task.name}" 
                            data-task-time="${task.time}" 
                            data-task-start-date="${task.start_date}" 
                            data-task-end-date="${task.end_date}">

                            ${isStart ? '<div class="extend-task-left ui-resizable-handle ui-resizable-w" onclick="extendTaskLeft(\'' + task.id + '\')"><i class="bi bi-arrow-left-circle"></i></div>' : ''}
                            
                            <div class="task-content">
                                <h3 class="details-task" style="border-radius: 4px; padding: 5px; font-size: 14px;">
                                    ${task.name}
                                </h3>
                                <div class="details-uren" style="font-size: 12px; color: #333; margin-top: 2px;">
                                    ${task.time}
                                </div>
                            </div>
                            
                            ${isEnd ? '<div class="extend-task-right ui-resizable-handle ui-resizable-e" onclick="extendTaskRight(\'' + task.id + '\')"><i class="bi bi-arrow-right-circle"></i></div>' : ''}
                        </div>`;
                    });

                    if (tasksForTheDay.length === 0) {
                        // cellContent = '<div style="color: #ccc; font-size: 12px; text-align: center;">ไม่มีงาน</div>';
                    }
                } else {
                    // cellContent = '<div style="color: #ccc; font-size: 12px; text-align: center;">ไม่มีงาน</div>';
                }

                const cellId = `day-${i}-user-${personIndex}`;
                userRow += `
                <td id="${cellId}" class="ui-droppable cal-cell" data-date="${formattedDate}" data-person-index="${personIndex}" data-day-index="${i}" onclick="handleAddTask('${formattedDate}', '${person.ps_fname} ${person.ps_lname}')">
                    ${cellContent}
                </td>`;
            }

            userRow += '</tr>';
            $tbody.append(userRow);
        });

        initializeDragAndDrop(); // Call to enable drag-and-drop
    }

    function initializeDragAndDrop() {
        // $(".drag").draggable({
        //     revert: "invalid",
        //     start: function (e, ui) {
        //         const oldDate = $(this).parent().data("date");
        //         $(this).data("oldDate", oldDate);
        //     }
        // });

        $("td[data-date]").droppable({
            accept: ".drag",
            hoverClass: "ui-state-hover",
            over: function(event, ui) {
                $(this).addClass("ui-state-highlight");
            },
            out: function(event, ui) {
                $(this).removeClass("ui-state-highlight");
            },
            drop: function (e, ui) {
                const drag = ui.draggable,
                    drop = $(this),
                    oldDate = drag.data("oldDate"),
                    newDate = drop.data("date");

                if (oldDate !== newDate) {
                    $(drag).detach().css({ top: 0, left: 0 }).appendTo(drop);
                    $(drag).attr("data-task-date", newDate);
                    $(drag).data("userid", drop.data("userid"));
                    $(drag).parent().data("person-index", drop.data("person-index"));
                    $(drag).parent().data("day-index", drop.data("day-index"));

                    adjustCellHeight(drop);
                    adjustUserInfoHeight();
                } else {
                    $(drag).css({ top: 0, left: 0 });
                }

                drop.removeClass("ui-state-highlight");
            }
        });

        $(".drag").resizable({
            handles: "e, w",
            stop: function(event, ui) {
                const taskId = $(this).data('task-id');
                const oldStartDate = $(this).data('task-start-date');
                const oldEndDate = $(this).data('task-end-date');
                
                // Calculate the new start and end dates based on the resized width
                const startDate = calculateNewStartDate($(this), oldStartDate);
                const endDate = calculateNewEndDate($(this), oldEndDate);

                // Update the data attributes with the new start and end dates
                $(this).data('task-start-date', startDate);
                $(this).data('task-end-date', endDate);

                // Update your data model here with the new dates (e.g., send to server)
                console.log(`Task ${taskId} resized from ${oldStartDate}-${oldEndDate} to ${startDate}-${endDate}`);
            }
        });

        $("td[data-date]").sortable({
            connectWith: "td[data-date]",
            placeholder: "ui-sortable-placeholder",
            helper: "clone",
            revert: true,
            start: function(event, ui) {
                ui.placeholder.height(ui.helper.outerHeight());
                ui.placeholder.width(ui.helper.outerWidth());
            },
            update: function(event, ui) {
                const sortedIDs = $(this).sortable('toArray');
            },
            over: function(event, ui) {
                $(this).addClass("ui-state-highlight");
            },
            out: function(event, ui) {
                $(this).removeClass("ui-state-highlight");
            }
        }).disableSelection();

        $("td[data-date]").each(function() {
            adjustCellHeight($(this));
        });

        adjustUserInfoHeight();
    }


    function updateArrowButtons() {
        const $leftArrow = $('#left-arrow');
        const $rightArrow = $('#right-arrow');

        if (viewMode === 'month') {
            $leftArrow.hide();
            $rightArrow.hide();
        } else {
            $leftArrow.show();
            $rightArrow.show();
            if (currentWeekOffset === 0) {
                $leftArrow.addClass('disabled');
            } else {
                $leftArrow.removeClass('disabled');
            }

            if (currentWeekOffset >= weekRanges.length - 1) {
                $rightArrow.addClass('disabled');
            } else {
                $rightArrow.removeClass('disabled');
            }
        }
    }

function get_person_list(){
    var fillter_dp_id = $('#fillter_select_dp_id').val();
    var fillter_hire_id = $('#fillter_select_hire_id').val();
    var fillter_admin_id = $('#fillter_select_admin_id').val();
    var fillter_status_id = $('#fillter_select_status_id').val();

    $.ajax({
        url: '<?php echo site_url() . "/" . $controller_dir; ?>get_profile_user_list',
        type: 'GET',
        data: {
            admin_id: fillter_admin_id,
            hire_id: fillter_hire_id,
            status_id: fillter_admin_id,
            dp_id: fillter_dp_id
        },
        success: function(data) {
            data = JSON.parse(data);
            obj_data = data;

            // รีเฟรชการแสดงผลหลังจากอัปเดตข้อมูลแล้ว
            generateCalendarHeader();
            generateCalendar(obj_data);
        },
        error: function(xhr, status, error) {
            dialog_error({
                'header': text_toast_default_error_header,
                'body': text_toast_default_error_body
            });
        }
    });
}


// Function to convert RGB to RGBA with the desired opacity
function convertRGBtoRGBA(rgb, opacity) {
    return rgb.replace('rgb', 'rgba').replace(')', `, ${opacity})`);
}

// Convert hex to RGB
function hexToRgb(hex) {
    const bigint = parseInt(hex.slice(1), 16);
    const r = (bigint >> 16) & 255;
    const g = (bigint >> 8) & 255;
    const b = bigint & 255;
    return `rgb(${r}, ${g}, ${b})`;
}


function calculateNewStartDate($element, oldStartDate) {
    const cellWidth = $element.parent().outerWidth();
    const offsetLeft = $element.position().left;
    const daysMoved = Math.round(offsetLeft / cellWidth);

    const newStartDate = new Date(oldStartDate);
    newStartDate.setDate(newStartDate.getDate() + daysMoved);
    return formatDate(newStartDate);
}

function calculateNewEndDate($element, oldEndDate) {
    const cellWidth = $element.parent().outerWidth();
    const elementWidth = $element.outerWidth();
    const daysCovered = Math.round(elementWidth / cellWidth);

    const newEndDate = new Date(oldEndDate);
    newEndDate.setDate(newEndDate.getDate() + (daysCovered - 1));
    return formatDate(newEndDate);
}


function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}


function adjustCellHeight(cell) {
    const contentHeight = cell.find(".drag").length * 60;
    cell.css("height", contentHeight + "px");
}

// Function to adjust the height of cal-userinfo to match the tallest cell in the row
function adjustUserInfoHeight() {
    $(".cal-userinfo").each(function() {
        const row = $(this).closest("tr");
        const maxHeight = Math.max.apply(null, row.find("td").map(function() {
            return $(this).height();
        }).get());

        $(this).css("height", maxHeight + "px"); // Set the height of cal-userinfo
    });
}


function handleAddTask(date, name) {
    // Show the modal or perform another action
    $('#addWorkModal').modal('show');
    // Optionally, you can set the modal title or pre-fill some inputs
    // $('#addWorkModal .modal-title').text(`เพิ่มข้อมูลสำหรับ ${name} วันที่ ${date}`);
}

function handleEditTask(element) {
    event.stopPropagation();
    const taskElement = $(element).closest('.drag');
    const date = taskElement.parent().data('date');
    const name = taskElement.closest('tr').find('.cal-userinfo span').text();
    const taskName = taskElement.find('.details-task').text();

    $('#editTaskModal').modal('show');
    $('#editTaskModal .modal-title').text(`Edit Task for ${name} on ${date}`);
    $('#editTaskModal #taskNameInput').val(taskName);
    $('#editTaskModal #taskDateInput').val(date);
}

function handleDeleteTask(element) {
    event.stopPropagation();
    const taskElement = $(element).closest('.drag');
    const date = taskElement.parent().data('date');
    const name = taskElement.closest('tr').find('.cal-userinfo span').text();
    const taskName = taskElement.find('.details-task').text();

    $('#deleteTaskModal').modal('show');
    $('#deleteTaskModal .modal-body').text(`Are you sure you want to delete the task "${taskName}" for ${name} on ${date}?`);

    $('#confirmDeleteBtn').off('click').on('click', function() {
        console.log(`Task "${taskName}" for ${name} on ${date} deleted.`);
        $('#deleteTaskModal').modal('hide');
    });
}

</script>

<!-- Add Work Data Modal -->
<div class="modal fade" id="addWorkModal" tabindex="-1" role="dialog" aria-labelledby="addWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addWorkModalLabel">เพิ่มข้อมูลการทำงาน</h5>
        </div>
        <div class="modal-body">
            <div class="d-flex align-items-center">
            <img src="https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" alt="" class="rounded-circle" style="width: 50px; height: 50px; margin-right: 15px;">
            <div>
                <h5 class="modal-title" id="addWorkModalLabel">เพิ่มข้อมูลการทำงาน</h5>
                <p class="mb-0"><strong>ชื่อ-นามสกุล:</strong> สมชาย กิจเจริญ</p>
                <p class="mb-0"><strong>รหัสบุคลากร:</strong> 12345</p>
                <p class="mb-0"><strong>ตำแหน่ง:</strong> แพทย์</p>
            </div>
            </div>
            <form>
            <!-- Work Type -->
            <div class="form-group">
                <label for="workType">รูปแบบการทำงาน</label>
                <select class="form-control" id="workType">
                <option value="1">กะเช้า</option>
                <option value="2">กะบ่าย</option>
                <option value="3">กะดึก</option>
                <option value="4">อบรม</option>
                <option value="5">อื่นๆ</option>
                </select>
            </div>

            <!-- Work Date -->
            <div class="form-group">
                <label for="workDate">วันที่การทำงาน</label>
                <input type="date" class="form-control" id="workDate">
            </div>

            <!-- Work Time -->
            <div class="form-group">
                <label for="workTime">เวลาการทำงาน</label>
                <input type="time" class="form-control" id="workStartTime">
                <input type="time" class="form-control mt-2" id="workEndTime">
            </div>

            <!-- Department -->
            <div class="form-group">
                <label for="department">แผนกที่ทำงาน</label>
                <select class="form-control" id="department">
                <option value="1">แผนกอายุรกรรม</option>
                <option value="2">แผนกศัลยกรรม</option>
                <option value="3">แผนกสูติศาสตร์</option>
                <option value="4">แผนกกุมารเวชศาสตร์</option>
                <option value="5">อื่นๆ</option>
                </select>
            </div>

            <!-- Room -->
            <div class="form-group">
                <label for="room">ห้องที่ทำงาน</label>
                <input type="text" class="form-control" id="room" placeholder="ระบุห้องที่ทำงาน">
            </div>

            <!-- Location -->
            <div class="form-group">
                <label for="location">สถานที่ทำงาน</label>
                <input type="text" class="form-control" id="location" placeholder="ระบุสถานที่ทำงาน">
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label for="notes">หมายเหตุการทำงาน</label>
                <textarea class="form-control" id="notes" rows="3" placeholder="ระบุหมายเหตุการทำงาน"></textarea>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            <button type="button" class="btn btn-primary">บันทึกข้อมูล</button>
        </div>
        </div>
    </div>
</div>




<!-- DISPLAY MODAL: EDIT -->
<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal-edit" class="modal-body">
        <div class="input-group mb-2 text-center">
          <i style="color:red">Edit box is only for preview purposes and does not save any data.</i>
        </div>
        <div class="input-group mb-2">
          <label for="cono1" class="col-sm-2 text-left control-label col-form-label">Task:</label>
          <input type="text" class="form-control" id="taak" placeholder="Taak">
        </div>
        <div class="input-group mb-2">
          <label for="cono1" class="col-sm-2 text-left control-label col-form-label">Date:</label>
          <input id="date" class="form-control taskstart" placeholder="dd/mm/yyyy" type="text">
        </div>
        <div class="input-group">
          <div class="form-group" style="width:125px; margin-left:15px; margin-right:5px;">
            <label for="cono1" class="col-sm-3 text-left control-label col-form-label" style="padding-left: 0px;">Text:</label>
            <input type="text" id="ktxt" data-jscolor="" class="form-control" name="ctxt" value="" onchange="changeColor('ctxt', this.value);">
          </div>
          <div class="form-group" style="width:125px; margin-left:5px; margin-right:5px;">
            <label for="cono1" class="col-sm-3 text-left control-label col-form-label" style="padding-left: 0px;">Background:</label>
            <input type="text" id="kbg" data-jscolor="" class="form-control" name="cbg" value="" onchange="changeColor('cbg', this.value);">
          </div>
          <div class="form-group" style="width:175px; margin-left:5px;">
            <label for="cono1" class="col-sm-5 text-left control-label col-form-label" style="padding-left: 0px;">Preview:</label>
            <div id="demotaak1" data-taskid="3" class="form-control details" style="border-left:5px solid #959595; position:relative; height: 50px;">
              <h3 id="demotaak2" class="details-task" style="background:#959595; color:#FFFFFF">Example</h3>
              <p class="details-uren">08:00 - 16:30</p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>

<!-- DISPLAY MODAL: DELETE -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div id="modal-delete" class="modal-body" style="text-align: center;">
      </div>
      <div class="modal-footer">
        <input id="taskdelid" type="hidden" value="">
        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
        <button id="confdelete" type="button" class="btn btn-danger">Yes</button>

      </div>
    </div>
  </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">ค้นหาข้อมูลบุคลากร</h5>
      </div>
      <div class="modal-body">
        <form class="row g-3" method="get">
            <div class="col-md-6">
                <label for="fillter_select_dp_id" class="form-label required">หน่วยงาน</label>
                <select class="form-select select2" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="fillter_select_dp_id" id="fillter_select_dp_id">
                    <?php
                    foreach ($base_ums_department_list as $key => $row) {
                    ?>
                        <option value="<?php echo $row->dp_id; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->dp_name_th; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="fillter_select_adline_id" class="form-label">ประเภทบุคลากร</label>
                <select class="form-select select2" name="fillter_select_hire_id" id="fillter_select_hire_id">
                    <option value="all" selected>ทั้งหมด</option>
                    <option value="none">ไม่ระบุ</option>
                    <?php
                    foreach ($base_hire_list as $key => $row) {
                    ?>
                        <option value="<?php echo $row->hire_id; ?>"><?php echo $row->hire_name; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="fillter_select_admin_id" class="form-label">ตำแหน่งในการบริหารงาน</label>
                <select class="form-select select2" name="fillter_select_admin_id" id="fillter_select_admin_id">
                    <option value="all" selected>ทั้งหมด</option>
                    <option value="none">ไม่ระบุ</option>
                    <?php
                    foreach ($base_admin_position_list as $key => $row) {
                    ?>
                        <option value="<?php echo $row->admin_id; ?>"><?php echo $row->admin_name; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="fillter_select_status_id" class="form-label">สถานะการทำงาน</label>
                <select class="form-select select2" class="form-select" id="fillter_select_status_id" name="fillter_select_status_id">
                    <option value="all" selected>ทั้งหมด</option>
                    <option value="1">ปฏิบัติงานอยู่</option>
                    <option value="2">ออกจากการปฏิบัติงาน</option>
                </select>
            </div>
            <!-- <div class="col-12">
                <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
                <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
            </div> -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" id="applyFilter">ค้นหา</button>
      </div>
    </div>
  </div>
</div>

