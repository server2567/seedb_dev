<?php
// dev
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));

    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
?>
<style>
    .disabled-text {
        color: #6c757d;
        /* Text color for disabled state */
        opacity: 0.65;
        /* Optional: Add some transparency */
        /* cursor: not-allowed; */
    }
    .text-highlight {
        color: white;
    }

    /* สีแดงสำหรับสถานะเกินเวลา */
    .card-danger {
        background-color: #f48a8a !important;
        border: 2px solid #dc3545 !important;
        color: black !important; /* สีตัวอักษรขาว */
    }

    /* สีส้มสำหรับสถานะใกล้ถึงเวลา */
    .card-warning {
        background-color: #ffc74d !important;
        border: 2px solid #ffc107 !important;
        color: black !important; /* สีตัวอักษรขาว */
    }

    /* สีเขียวสำหรับสถานะปกติ */
    .card-success {
        background-color: #7ed957 !important;
        border: 2px solid #28a745 !important;
        color: black !important; /* สีตัวอักษรขาว */
    }

    /* จัดการสีพื้นหลังและสีตัวอักษรของ header และ body ภายในการ์ด */
    #cardsContainer .card-que-header,
    #cardsContainer .card-que-body {
        background-color: inherit !important; /* ให้ตามการ์ดแม่ */
        color: inherit !important; /* ให้ตามการ์ดแม่ */
    }

    /* ตัวเลขเวลาใหญ่และอยู่ตรงกลาง */
    .card-que .display-4 {
        font-size: 3rem;
        font-weight: bold;
        text-align: center;
        margin-bottom: 1rem;
    }

    /* กำหนดกรอบการ์ด */
    .card-que {
        border-radius: 12px;
        overflow: hidden;
    }

    /* ขยายระยะระหว่างการ์ด */
    #cardsContainer {
        margin-bottom: 20px;
    }

    /* การจัดเรียงข้อมูลภายในการ์ด */
    .card-que-body {
        padding: 1rem;
    }

    .card-que-header {
        font-weight: bold;
        text-align: center;
        font-size: 1.2rem;
    }

    /* ข้อความชื่อผู้ป่วยซ้ายสุด */
    .card-que-body p.text-start {
        text-align: left;
        font-size: 1rem;
        margin-top: 0.5rem;
    }

    .card-que-header p {
        margin-top: 1rem;
        /* margin-bottom: 1rem !important; */
    }

</style>

<!-- <div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button " type="button"  data-bs-toggle="collapse" data-bs-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
                    <i class="bi-search icon-menu"></i><span> ค้นหาข้อมูลผู้ป่วย</span><span class="badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseCard" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <div class="row">
                        
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label ">วัน/เดือน/ปี ที่นัดหมายแพทย์</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control datepicker_th" name="year-bh" id="year-bh" value="" placeholder="เลือกวันที่นัดหมาย">
                                <span class="input-group-text btn btn-secondary" onclick="$('#year-bh').val(null);" title="clear" data-clear><i class="bi-x"></i></span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="" class="form-label ">ชื่อแผนก</label><br>
                          <select class="form-control select2" name="department">
                            <option value="" disabled selected>กรุณาเลือกแผนก</option>
                            <?php foreach ($get_structure_detail as $dp) { ?>
                                <option value="<?php echo $dp['stde_id'] ?> "><?= $dp['stde_name_th'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                          <label for="" class="form-label ">ชื่อแพทย์</label><br>
                          <select class="form-select select2" data-placeholder="-- กรุณาเลือกชื่อแพทย์ --" name="doctor">
                              <option value=""></option>
                              <?php foreach ($get_doctors as $ps) { ?>
                                <option value="<?php echo $ps['ps_id'] ?> "><?= $ps['pf_name'] . '' . $ps['ps_fname'] . ' ' . $ps['ps_lname']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label ">HN</label>
                            <input type="number" class="form-control" name="" id="patient-id" step=""  placeholder="HN" value="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label ">ชื่อ-นามสกุล ผู้ป่วย</label>
                            <input type="text" class="form-control" name="" id="patient-name" step=""  placeholder="ชื่อ-นามสกุลผู้ป่วย" value="">
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="" class="form-label ">สถานะ</label><br>
                          <select class="form-select select2" data-placeholder="-- กรุณาเลือกสถานะ --" name="sta">
                              <option value="" ></option>
                              <?php foreach ($get_status as $ps) { ?>
                                <option value="<?php echo $ps['sta_id'] ?> "><?php echo $ps['sta_name']; ?> </option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" id="search" class="btn btn-primary float-end me-5"><i class="bi-search icon-menu"></i>&nbsp;ค้นหา&emsp;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div id="cardsContainer" class="row"></div>
<div class="card" style="background-color: transparent;">
    <div class="nav nav-tabs d-flex justify-content-start" role="tablist">
        <button class="nav-link w-20 active" id="nav_wait"
            data-bs-toggle="tab" data-bs-target="#wait_content"
            type="button" role="tab" aria-controls="wait_content" aria-selected="true">
            รอดำเนินการ
        </button>
        <button class="nav-link w-20" id="nav_completed"
            data-bs-toggle="tab" data-bs-target="#completed_content"
            type="button" role="tab" aria-controls="completed_content" aria-selected="false">
            พบแพทย์เสร็จสิ้น
        </button>
    </div>

    <div class="tab-content" id="nav-tabcontent">
        <!-- Tab รอดำเนินการ -->
        <div class="tab-pane fade active show" id="wait_content" role="tabpanel" aria-labelledby="nav_wait">
            <div class="card">
                <div class="accordion" id="accordion-wait">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-wait">
                            <button class="accordion-button" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse-wait"
                                aria-expanded="true" aria-controls="collapse-wait">
                                <i class="bi-newspaper icon-menu"></i>
                                <span> ข้อมูลผู้ป่วยที่นัดหมายแพทย์ </span>
                                <span class="span-date pe-1">
                                    ประจำวันที่ <?php echo formatShortDateThai(date("Y-m-d H:i:s")); ?>
                                </span>
                                <span class="badge-wait badge bg-success font-14"> ผู้ป่วยที่ทำเรื่องนัดหมายแพทย์</span>
                            </button>
                        </h2>
                        <div id="collapse-wait" class="accordion-collapse collapse show"
                            aria-labelledby="heading-wait" data-bs-parent="#accordion-wait">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table" id="wait-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">เลขคิว</th>
                                                <th class="text-center">Visit</th>
                                                <th class="text-center">HN</th>
                                                <th class="text-center w-15">ชื่อ - นามสกุลผู้ป่วย</th>
                                                <th class="text-center">วันที่นัดหมายแพทย์</th>
                                                <th class="text-center">ช่วงเวลา</th>
                                                <th class="text-center w-15">ลำดับความสำคัญ</th>
                                                <th class="text-center w-15">แผนก</th>
                                                <th class="text-center w-10">สถานะ</th>
                                                <th class="text-center w-15">ดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab พบแพทย์เสร็จสิ้น -->
        <div class="tab-pane fade" id="completed_content" role="tabpanel" aria-labelledby="nav_completed">
            <div class="card">
                <div class="accordion" id="accordion-completed">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-completed">
                            <button class="accordion-button" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse-completed"
                                aria-expanded="true" aria-controls="collapse-completed">
                                <i class="bi-newspaper icon-menu"></i>
                                <span> ข้อมูลผู้ป่วยที่นัดหมายแพทย์ </span>
                                <span class="span-date pe-1">
                                    ประจำวันที่ <?php echo formatShortDateThai(date("Y-m-d H:i:s")); ?>
                                </span>
                                <span class="badge-completed badge bg-success font-14"> ผู้ป่วยที่พบแพทย์เสร็จแล้ว</span>
                            </button>
                        </h2>
                        <div id="collapse-completed" class="accordion-collapse collapse show"
                            aria-labelledby="heading-completed" data-bs-parent="#accordion-completed">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table" id="completed-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">เลขคิว</th>
                                                <th class="text-center w-10">Visit</th>
                                                <th class="text-center w-5">HN</th>
                                                <th class="text-center w-15">ชื่อ - นามสกุลผู้ป่วย</th>
                                                <th class="text-center w-10">วันที่นัดหมายแพทย์</th>
                                                <th class="text-center">ช่วงเวลา</th>
                                                <th class="text-center w-15">ลำดับความสำคัญ</th>
                                                <th class="text-center w-15">แผนก</th>
                                                <th class="text-center w-10">สถานะ</th>
                                                <th class="text-center w-10">ดำเนินการ</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-ntr" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-card-heading icon-menu font-20"></i>
                    <span>รายละเอียดข้อมูลผลตรวจจากห้องปฏิบัติการทางการแพทย์</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="notification-result-data"></div>
            </div>
        </div>
    </div>
</div>

<script>
    let refreshInterval;
    var patients_by_doctors = [];

    $(document).ready(function() {
        // โหลดข้อมูลเริ่มต้นในแต่ละ Tab
        updateDataTable('wait-table', 'waiting'); // Tab รอดำเนินการ
        updateDataTable('completed-table', 'completed'); // Tab พบแพทย์เสร็จแล้ว
    });

    function navigateToAddAppointmentStep2(data) {
        localStorage.setItem('previousPage', window.location.href);
        window.location.href = '<?php echo site_url(); ?>/que/Appointment/add_appointment_step2/' + data;
    }

    function updateBadge(count, status) {
        const badgeClass = status === 'completed' ? '.badge-completed' : '.badge-wait';
        const badge = document.querySelector(`${badgeClass}.badge.bg-success.font-14`);

        if (badge) {
            const oldText = badge.textContent.replace(/^\d+/, '').trim(); // ลบเลขเก่าออก แต่คงข้อความไว้
            badge.innerHTML = `${count} ${oldText}`;
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
        let d = new Date(date);
        let year = d.getFullYear();
        let month = ('0' + (d.getMonth() + 1)).slice(-2);
        let day = ('0' + d.getDate()).slice(-2);

        if (year < 2500) { // Convert to B.E. only if not already converted
            year = year + 543;
        }

        return `${day}/${month}/${year}`;
    }

    function updateDatepickerValues(selectedDates) {
        if (selectedDates.length > 0) {
            var date = selectedDates[0];
            var day = ('0' + date.getDate()).slice(-2);
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var yearBE = date.getFullYear(); // Get year in BE (Buddhist Era)
            var yearTH = yearBE + 543; // Convert to Buddhist year
            var formattedDate = day + '/' + month + '/' + yearTH;
            $(".datepicker_th").val(formattedDate);
        }
    }

    var today = new Date();
    var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    var maxDate = new Date();
    maxDate.setDate(maxDate.getDate() + 500);
    flatpickr(".datepicker_th", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        // defaultDate: today, // Set to current Gregorian date
        //   minDate: minDate, // Minimum date is today
        //   maxDate: maxDate, // Maximum date is today + 500 days

        onReady: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates); // Display the default date in Buddhist year format
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai(instance);
            updateDatepickerValues(selectedDates);
        },
    });

    function abbreDate2(date) {
        const dateParts = date.split('-');
        let [yy, mm, dd] = dateParts;

        dd = dd.replace(/^0+/, ''); // Remove leading zeros

        const months = {
            '01': 'ม.ค.',
            '02': 'ก.พ.',
            '03': 'มี.ค.',
            '04': 'เม.ย.',
            '05': 'พ.ค.',
            '06': 'มิ.ย.',
            '07': 'ก.ค.',
            '08': 'ส.ค.',
            '09': 'ก.ย.',
            '10': 'ต.ค.',
            '11': 'พ.ย.',
            '12': 'ธ.ค.'
        };

        mm = months[mm] || mm;
        yy = parseInt(yy) + 543; // Convert year to Buddhist Era

        return `${dd} ${mm} ${yy}`;
    }

    function abbreDate4(datetime) {
        const [date, time] = datetime.split(' ');
        const dateParts = date.split('-');
        let [yy, mm, dd] = dateParts;

        dd = dd.replace(/^0+/, ''); // Remove leading zeros

        const months = {
            '01': 'ม.ค.',
            '02': 'ก.พ.',
            '03': 'มี.ค.',
            '04': 'เม.ย.',
            '05': 'พ.ค.',
            '06': 'มิ.ย.',
            '07': 'ก.ค.',
            '08': 'ส.ค.',
            '09': 'ก.ย.',
            '10': 'ต.ค.',
            '11': 'พ.ย.',
            '12': 'ธ.ค.'
        };

        mm = months[mm] || mm;
        yy = parseInt(yy) + 543; // Convert year to Buddhist Era

        return `${dd} ${mm} ${yy} เวลา ${time} น.`;
    }

    function addClassToTableCells() {
        $('#dataTable tbody tr').each(function() {
            $(this).children('td').addClass('text-center');
        });
    }

    function searchDataTable() {
        const searchParams = getSearchParams(); // Function to get search parameters

        $('#dataTable').DataTable().destroy();
        // Initialize DataTable with server-side processing and search parameters
        var table = $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('wts/Manage_queue/queue_list_doctor'); ?>",
                "type": "POST",
                "data": searchParams,
                "data": function(d) {
                    // Merge search parameters with the default DataTable parameters
                    return $.extend({}, d, searchParams);
                },
                "dataSrc": function(json) {
                    updateBadge(json.recordsTotal);
                    if (json.badge) updateBadgeText(json.badge);
                    return json.data;
                }
            },
            "columns": [{
                    "data": "row_number",
                    "orderable": false
                },
                {
                    "data": "apm_ql_code"
                },
                {
                    "data": "apm_visit"
                },
                {
                    "data": "pt_member"
                },
                {
                    "data": "pt_name"
                },
                {
                    "data": "apm_date"
                },
                {
                    "data": "apm_time"
                },
                {
                    "data": "apm_pri_id"
                },
                {
                    "data": "stde_name_th"
                },
                {
                    "data": "status"
                },
                {
                    "data": "actions"
                }
            ],
            // "order": [
            //     [1, 'asc']
            // ], // Default sorting
            "language": {
                "decimal": "",
                "emptyTable": "ไม่มีรายการในระบบ",
                "info": "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                "infoEmpty": "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "lengthMenu": "_MENU_",
                "loadingRecords": "Loading...",
                "processing": "",
                "search": "",
                "searchPlaceholder": 'ค้นหา...',
                "zeroRecords": "ไม่พบรายการ",
                "paginate": {
                    "first": "«",
                    "last": "»",
                    "next": "›",
                    "previous": "‹"
                },
                "aria": {
                    "orderable": "Order by this column",
                    "orderableReverse": "Reverse order this column"
                },
            },
            "dom": 'lBfrtip',
            "buttons": [{
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
                    customize: function(doc) {
                        doc.defaultStyle = {
                            font: 'THSarabun'
                        };
                    }
                }
            ],
            "initComplete": function() {
                var api = this.api();
                api.on('draw', function() {
                    if (api.rows({
                            filter: 'applied'
                        }).data().length === 0) {
                        $('.dataTables_empty').parent().html('<tr><td colspan="100%">ไม่พบรายการ</td></tr>');
                    }
                });
            },
            "drawCallback": function(settings) {
                // $('[data-toggle="tooltip"]').tooltip('dispose');
                // setTooltipDefault(); // from main.js
                set_bg_clor_td('#dataTable');
            }
        });

        // Show loading spinner while DataTable is being processed
        $('#loadingSpinner').show();
        table.on('preXhr.dt', function(e, settings, data) {
            // Show loading spinner while DataTable is fetching data
            $('#loadingSpinner').show();
        });

        table.on('xhr.dt', function(e, settings, json, xhr) {
            // Hide loading spinner once data is loaded
            $('#loadingSpinner').hide();
        });

        table.on('error.dt', function(e, settings, techNote, message) {
            // Handle errors and hide loading spinner
            console.error('Error fetching data:', message);
            $('#loadingSpinner').hide();
        });

        resetInterval(); // Initial call to set the interval
    }

    function set_bg_clor_td(selector) {
        var table = $(selector).DataTable();

        table.rows().every(function() {
            var $row = $(this.node()); // Get the jQuery object for the row
            $row.find('td').each(function() {
                var color = $(this).find('[data-color-pr]').attr('data-color-pr');
                if (color) {
                    $(this).css('background-color', color);
                }
            });
        });
    }

    function DateThai(strDate) {
        let thaiMonths = ["", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
        let date = new Date(strDate);
        let year = date.getFullYear() + 543;
        let month = thaiMonths[date.getMonth() + 1];
        let day = date.getDate();
        return `${day} ${month} ${year}`;
    }

    function checkForUpdates() {
        const searchParams = getSearchParams();
        if (!hasSearchParams(searchParams)) {
            updateDataTable().then(() => {});
        }
    }

    function getSearchParams() {
        return {
            date: document.getElementById('year-bh').value,
            // department: document.querySelector('select[name="department"]').value,
            doctor: document.querySelector('select[name="doctor"]').value,
            sta: document.querySelector('select[name="sta"]').value,
            patientId: document.getElementById('patient-id').value,
            patientName: document.getElementById('patient-name').value,
        };
    }

    function hasSearchParams(searchParams) {
        return Object.values(searchParams).some(value => value !== '');
    }

    function updateBadgeText(text) {
        const badges = document.querySelectorAll('.span-date');
        badges.forEach(badge => {
            badge.innerHTML = `${text}`;
        });
    }

    function resetInterval() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
        refreshInterval = setInterval(function() {
            reloadDataTable();
        }, datatable_second_reload);
    }

    function reloadDataTable() {
        // Check if the "รอดำเนินการ" tab is active, then reload the corresponding table
        if ($('#nav_wait').hasClass('active')) {
            $('#wait-table').DataTable().ajax.reload(null, false); // false to stay on the current page
        }

        // Check if the "พบแพทย์เสร็จสิ้น" tab is active, then reload the corresponding table
        if ($('#nav_completed').hasClass('active')) {
            $('#completed-table').DataTable().ajax.reload(null, false); // false to stay on the current page
        }
    }


    let index_tools = 0;
    let order_tools = 0;
    let index_draft_tools = 0;
    let order_draft_tools = 0;
    let refreshInterval_modal;
    let url_temp = '';
    let is_first_load_exr = true;

    function showModalNtr(url) {
        url_temp = url;

        // Clear the modal content
        clearModalContent();

        // Show the modal
        $('#modal-ntr').modal('show');

        // Display the loading spinner
        showLoadingSpinner();

        // Use setTimeout to ensure the spinner is displayed before loading new content
        setTimeout(function() {
            $('#notification-result-data').load(url, function(response, status, xhr) {
                if (status === "error") {
                    console.log('AJAX error:', xhr.status, xhr.statusText);
                    showErrorMessage();
                } else {
                    // Clear spinner after content is loaded
                    clearLoadingSpinner();
                }
            });
        }, 100); // Adjust the delay if needed
    }

    function showLoadingSpinner() {
        const spinnerHTML = `
            <div class="center-container text-center">
                <div class="spinner-border text-info" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        $('#notification-result-data').append(spinnerHTML);
    }

    function clearLoadingSpinner() {
        $('#notification-result-data .spinner-border').remove();
    }

    function showErrorMessage() {
        const errorMessageHTML = `
            <div class="alert alert-danger" role="alert">
                An error occurred while loading the content. Please try again later.
            </div>
        `;
        $('#notification-result-data').empty(); // Clear the spinner or any existing content
        $('#notification-result-data').append(errorMessageHTML);
    }

    function clearModalContent(selector) {
        $(selector).empty();
    }

    let timerIntervals = {}; // Object เพื่อเก็บ intervalId สำหรับแต่ละการ์ด
    function updateDataTable(tableId, status) {
        if ($.fn.DataTable.isDataTable(`#${tableId}`)) {
            $(`#${tableId}`).DataTable().destroy();
        }
        $(`#${tableId}`).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('wts/Manage_queue/queue_list_doctor'); ?>",
                "type": "POST",
                "data": {
                    status: status
                }, // ส่งพารามิเตอร์ status
                "dataSrc": function(json) {
                    updateBadge(json.recordsTotal, status);
                    if (json.badge) updateBadgeText(json.badge);
                    // console.log("data : ",json.data)
                    return json.data;
                }
            },
            "columns": [
                { "data": "row_number", "orderable": false },
                { "data": "apm_ql_code" },
                { "data": "apm_visit" },
                { "data": "pt_member" },
                { "data": "pt_name" },
                { "data": "apm_date" },
                { "data": "apm_time" },
                { "data": "apm_pri_id" },
                { "data": "stde_name_th" },
                { "data": "status" },
                { "data": "actions" }
            ],
            "language": {
                "decimal": "",
                "emptyTable": "ไม่มีรายการในระบบ",
                "info": "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                "infoEmpty": "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "lengthMenu": "_MENU_",
                "loadingRecords": "Loading...",
                "processing": "",
                "search": "",
                "searchPlaceholder": 'ค้นหา...',
                "zeroRecords": "ไม่พบรายการ",
                "paginate": {
                    "first": "«",
                    "last": "»",
                    "next": "›",
                    "previous": "‹"
                },
                "aria": {
                    "orderable": "Order by this column",
                    "orderableReverse": "Reverse order this column"
                }
            },
            "dom": 'lBfrtip',
            "buttons": [{
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
                    customize: function(doc) {
                        doc.defaultStyle = {
                            font: 'THSarabun'
                        };
                    }
                }
            ],
            "initComplete": function() {
                var api = this.api();
                api.on('draw', function() {
                    if (api.rows({
                            filter: 'applied'
                        }).data().length === 0) {
                        $('.dataTables_empty').parent().html('<tr><td colspan="100%">ไม่พบรายการ</td></tr>');
                    }
                });
            },
            "drawCallback": function(settings) {
                set_bg_clor_td(`#${tableId}`);
                var table = $(`#${tableId}`).DataTable();
                var now = new Date(); // เวลาปัจจุบัน
                // เก็บการ์ดที่มีอยู่
                let existingCards = {};

                $('#cardsContainer .card-que').each(function() {
                    let cardId = $(this).attr('id').replace('card-', '');
                    existingCards[cardId] = true;
                });
                table.rows().every(function() {
                    var rowData = this.data(); // ดึงข้อมูลของแถวปัจจุบัน
                    var $row = $(this.node()); // ดึง node ของแถว
                    if (rowData.time_end) {
                        // แยกเวลาออกจาก string และใช้เวลาปัจจุบันเป็นพื้นฐาน
                        var timeParts = rowData.time_end.split(':');
                        var timeEnd = new Date(now.getFullYear(), now.getMonth(), now.getDate(), timeParts[0], timeParts[1], timeParts[2]);
                        if (rowData.status.includes('กำลังพบแพทย์')) {
                            var timeDiff = timeEnd - now;
                            $row.find('td').each(function(index) {
                                if (index !== 7) { // ข้ามคอลัมน์ "ลำดับความสำคัญ"
                                    if (timeDiff <= 2 * 60 * 1000 && timeDiff > 0) {
                                        // ถ้าเหลือเวลา 2 นาทีให้เป็นสีส้ม
                                        $(this).css('background-color', '#ffc74d');
                                    } else if (timeDiff <= 0) {
                                        // ถ้าถึงหรือเกินเวลา time_end ให้เป็นสีแดง
                                        $(this).css('background-color', '#f48a8a');
                                    } else {
                                        // ยังคงเป็นสถานะ "กำลังพบแพทย์" และยังไม่ใกล้ถึง time_end
                                        $(this).css('background-color', '#7ed957');
                                    }
                                }
                            });

                            let qlCode = $(rowData.apm_ql_code).text().trim(); // ดึงข้อความ
                            let visit = $(rowData.apm_visit).text().trim();
                            // ตรวจสอบว่าการ์ดถูกสร้างไปแล้วหรือยัง
                            if (!existingCards[qlCode]) {
                                var card = $(`
                                    <div class="col-3 mb-2 test">
                                        <div class="card-que" id="card-${qlCode}" style="border-radius: 12px; overflow: hidden;">
                                            <div class="card-que-header text-center" id="header-${qlCode}">
                                                <p class="fw-bold mb-1" style="text-align: left; padding-left: 15px;">
                                                    เวลาที่เข้าพบแพทย์: <span id="status-text-${qlCode}">หมดเวลาแล้ว</span>
                                                </p>
                                                <hr style="margin-bottom: 0px; margin-top: 0px;">
                                                <p id="timer-${qlCode}" class="display-5 fw-bold mb-0">00:00</p>
                                                <p style="text-align: right; margin-top: 0px; margin-bottom: 0px; padding-right: 15px; font-size: 1.5rem;">/${rowData.loc_time} นาที</p>
                                                <hr style="margin-bottom: 0px; margin-top: 0px;">
                                            </div>
                                            <div class="card-que-body bg-light text-dark">
                                                <div class="d-flex justify-content-between fw-bold">
                                                    <span>คิว: ${qlCode}</span>
                                                    <span>Visit: ${visit}</span>
                                                </div>
                                                <p class="text-start mb-0">${rowData.pt_name}</p>
                                            </div>
                                        </div>
                                    </div>
                                `);
                                $('#cardsContainer').append(card);
                                startTimer(qlCode, rowData.time_end, rowData.loc_time);
                            }
                        }
                    }
                });
                // ฟังก์ชันเริ่มจับเวลาสำหรับการ์ด
                function startTimer(qlCode, timeEndInput, loc_time) {
                    if (!timerIntervals[qlCode]) {
                        let timeParts = timeEndInput.split(':'); // แยกชั่วโมง นาที และวินาที
                        let timeEnd = new Date(now.getFullYear(), now.getMonth(), now.getDate(), timeParts[0], timeParts[1], timeParts[2]); 
                        timerIntervals[qlCode] = setInterval(() => {
                            let currentTime = new Date(); // เวลาปัจจุบัน
                            let elapsedMinutes = Math.floor((currentTime - timeEnd + (loc_time * 60 * 1000)) / 60000); // นับเวลาเป็นนาที
                            let elapsedSeconds = Math.floor(((currentTime - timeEnd + (loc_time * 60 * 1000)) % 60000) / 1000); // นับเวลาเป็นวินาที
                            
                            $(`#timer-${qlCode}`).text(
                                `${elapsedMinutes.toString().padStart(2, '0')}:${elapsedSeconds.toString().padStart(2, '0')}`
                            );

                            let cardElement = $(`#card-${qlCode}`);
                            let statusText = $(`#status-text-${qlCode}`);
                            if (elapsedMinutes >= loc_time) {
                                cardElement.removeClass('card-success card-warning').addClass('card-danger');
                                statusText.text("หมดเวลาแล้ว");
                            } else if (elapsedMinutes >= (loc_time - 2)) {
                                cardElement.removeClass('card-success card-danger').addClass('card-warning');
                                statusText.text("ใกล้หมดเวลา");
                            } else {
                                cardElement.removeClass('card-warning card-danger').addClass('card-success');
                                statusText.text("ปกติ");
                            }
                        }, 1000);
                    }
                }
            }
        });

        resetInterval(); // Initial call to set the interval
    }

    function goto_see_doctor(url, sta_id = 2) {
        let title = 'เรียกพบแพทย์แล้ว';
        let text = '';
        if (sta_id == 10) {
            title = 'พบแพทย์เสร็จสิ้นแล้ว';
            text = '';
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                sta_id: sta_id
            },
            success: function(response) {
                // var data = JSON.parse(response);
                if (response.status_response == "<?php echo $this->config->item('status_response_success'); ?>") {
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                        customClass: {
                            htmlContainer: 'swal2-html-line-height'
                        },
                    }).then(() => {
                        // if change status => success / cancel
                        if (response.appointment != undefined && response.appointment != null) {
                            let is_break = false;
                            for (let i = 0; i < patients_by_doctors.length; i++) {
                                if (is_break) break;
                                let doctorRecord = patients_by_doctors[i];
                                if (doctorRecord.ps_id === response.appointment.apm_ps_id) {
                                    for (let j = 0; j < doctorRecord.patient_ques.length; j++) {
                                        if (is_break) break;
                                        let que = doctorRecord.patient_ques[j];
                                        if (que.apm_ql_code === response.appointment.apm_ql_code) {
                                            let apm_sta_id = parseInt(response.appointment.apm_sta_id);
                                            if (apm_sta_id === 10 || apm_sta_id === 9) {
                                                // Remove the que from doctorRecord.patient_ques
                                                doctorRecord.patient_ques.splice(j, 1);

                                                // Find and remove the corresponding sortable-item from the DOM
                                                $(`.sortable-list[data-ps-id="${response.appointment.apm_ps_id}"] .sortable-item[data-task-id="${response.appointment.apm_ql_code}"]`).remove();

                                                // Exit both loops
                                                is_break = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        console.log("Reloading the page now...");
                        location.reload();
                    });
                } else {
                    console.log("Status response is not successful");
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error in AJAX request:", error);
                alert("Error in AJAX request: " + error);
            }
        });
    }

    function rollback_status(apm_id) {
        $.ajax({
            url: "<?php echo base_url() ?>index.php/wts/Manage_queue_trello/rollback_process",
            type: 'POST',
            data: {
                apm_id: apm_id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'ย้อนกลับเสร็จแล้ว',
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                        customClass: {
                            htmlContainer: 'swal2-html-line-height'
                        },
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }
</script>