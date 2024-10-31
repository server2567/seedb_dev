<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-search icon-menu"></i><span> ค้นหาประวัติการใช้งาน</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="log_agent" class="form-label">ช่องทาง</label>
                            <select class="select2" name="log_agent" id="log_agent" placeholder="เลือกข่องทาง"> 
                                <option value="all">ทั้งหมด</option>
                                <?php
                                    foreach($log_agent as $key=>$row){
                                ?>
                                <option value="<?php echo $row->log_agent; ?>"><?php echo $row->log_agent; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label ">ระหว่าง วันที่</label>
                            <div class="input-group date input-daterange">
                                <input type="text" class="form-control" name="log_start_date" id="log_start_date">
                                <span class="input-group-text">ถึง</span>
                                <input type="text" class="form-control" name="log_end_date" id="log_end_date">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary float-end" onclick="updateDataTable()" title="คลิกเพื่อค้นหาข้อมูล" data-toggle="tooltip" data-bs-placement="top">ค้นหา</button>
                        </div>
                    </div>
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
                    <i class="bi-server icon-menu"></i><span> ตารางข้อมูลประวัติการใช้งาน</span><span class="summary_log badge bg-success"></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <!-- <a class="btn btn-info" href="Systemlog_hr/generate_pdf" target="_blank">
                        test
                    </a> -->
                    <table class="table datatable" width="100%" id="log_table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="text-center">#</div>
                                </th>
                                <th class="text-center" scope="col">ชื่อผู้ใช้งาน</th>
                                <th class="text-center" scope="col">รายการ</th>
                                <th class="text-center" scope="col">วันที่</th>
                                <th class="text-center" scope="col">IP Address</th>
                                <th class="text-center" scope="col">ช่องทาง</th>
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

<script>
 $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();

    // Set default end date to the first day of the current month
    const now = new Date();
    const defaultStartDate = new Date(now.getFullYear(), now.getMonth(), 1); // First day of the current month

    // Set the formatted date to the input field
    document.getElementById('log_start_date').value = formatDateToThaiDefault(defaultStartDate);


    const defaultEndDate = new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()); // Set default end date as 7 days ahead
    document.getElementById('log_end_date').value = formatDateToThai(defaultEndDate);

    updateDataTable();
});

// Function to update DataTable based on select dropdown values
function updateDataTable() {
    // Initialize DataTable
    var dataTable = $('#log_table').DataTable();

    var log_agent = $('#log_agent').val();
    var log_start_date = $('#log_start_date').val();
    var log_end_date = $('#log_end_date').val();

    // Make AJAX request to fetch updated data
    $.ajax({
        url: '<?php echo site_url()."/".$controller_dir; ?>get_log_list',
        type: 'GET',
        data: { 
            log_agent: log_agent, 
            log_start_date: log_start_date,
            log_end_date: log_end_date
        },
        success: function(data) {
            // Clear existing DataTable data
            data = JSON.parse(data);
            dataTable.clear().draw();

            $(".summary_log").text(data.length);
            data.forEach(function(row, index) {
                // Create an array to hold the data for the row
                var rowData = [
                    (index+1),
                    row.pf_name + row.ps_fname + " " + row.ps_lname,
                    row.log_changed,
                    row.log_date,
                    row.log_ip,
                    row.log_agent
                ];

                // Add each item to the row with a class for center alignment
                var $rowNode = dataTable.row.add(rowData).draw().node();
                $('td', $rowNode).addClass('text-center'); // Center aligning other columns
                $('td:eq(1)', $rowNode).addClass('text-start'); // Selecting second column (index 1) and adding class
               
            });
        },
        error: function(xhr, status, error) {
            dialog_error({'header':text_toast_default_error_header, 'body': text_toast_default_error_body});
        }
    });
}

function formatDate(date) {
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear() + 543;

    // Add leading zeros if day or month is single digit
    let dayString = day < 10 ? '0' + day : day.toString();
    let monthString = month < 10 ? '0' + month : month.toString();

    return `${dayString}/${monthString}/${year}`;
}

flatpickr("#log_start_date", {
    plugins: [
        new rangePlugin({
            input: "#log_end_date"
        })
    ],
    dateFormat: 'd/m/Y',
    locale: 'th',
    defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
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
            document.getElementById('log_start_date').value = formatDateToThai(selectedDates[0]);
        }
        if (selectedDates[1]) {
            document.getElementById('log_end_date').value = formatDateToThai(selectedDates[1]);
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

function formatDateToThaiDefault(date) {
    const d = new Date(date);
    const year = d.getFullYear() + 543;
    const month = ('0' + (d.getMonth() + 1)).slice(-2);
    const day = ('0' + d.getDate()).slice(-2);
    return `${day}/${month}/${year}`;
}
</script>