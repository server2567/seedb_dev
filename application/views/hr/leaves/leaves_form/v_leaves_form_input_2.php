<?php
	/*
	* v_leaves_form_input_2
	* หน้าจอแบบฟอร์มการลากิจส่วนตัว
	* @input leave_type_id = 2
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-16
	*/
?>
<style>
    .form-check {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .table, tr, td, th{
        vertical-align: middle;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-receipt icon-menu"></i><span> แบบฟอร์มทำเรื่องการลากิจส่วนตัว</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show mb-3">
                <div class="accordion-body">

                    <!-- Start Leaves Form -->
                    <form id="leaves_form_input" class="needs-validation" method="post" action="<?php echo site_url()."/".$controller; ?>leaves_save">

                        <input type="hidden" name="leave_type_id" id="leave_type_id" value="<?php echo $leave_type_id; ?>">

                        <div class="row mt-3">
                            <div class="col-md-9 text-end"><label for="leaves_location_create" class="form-label">เขียนที่<span class="text-danger"> *</span></label></div>
                            <div class="col-md-3">
                                <input type="text" id="leaves_location_create" name="leaves_location_create" class="form-control" value="<?php echo $this->config->item('site_name_th'); ?>">
                            </div> 
                        </div>
                        <!-- เขียนที่ -->

                        <div class="row mt-3">
                            <div class="col-md-9 text-end"><label for="leaves_create_date" class="form-label">วันที่<span class="text-danger"> *</span></label></div>
                            <div class="col-md-3">
                                <input type="text" id="leaves_create_date" name="leaves_create_date" class="form-control" value="">
                            </div> 
                        </div>
                        <!-- วันที่ -->

                        <div class="row mt-3">
                            <div class="col-md-2"><label for="leaves_type_name" class="form-label">เรื่องการลา</label></div>
                            <div class="col-md-10">
                                ขอลากิจส่วนตัว
                            </div> 
                        </div>
                        <!-- เรื่อง -->

                        <div class="row mt-3">
                            <div class="col-md-2"><label for="leaves_from" class="form-label">เรียน<span class="text-danger"> *</span></label></div>
                            <div class="col-md-10">
                                <input type="text" id="leaves_from" name="leaves_from" class="form-control" value="ผู้อำนวยการ<?php echo $this->config->item('site_name_th'); ?>">
                            </div> 
                        </div>
                        <!-- เรียน -->

                        <div class="row mt-3">
                            <div class="col-md-2"><label for="leaves_person_text" class="form-label"></label></div>
                            <div class="col-md-10">
                                ข้าพเจ้า นพ.บรรยง ขินกุลกิจนิวัฒน์ <b>ตำแหน่งในการบริหาร</b> ผู้อำนวยการ <b>ตำแหน่งในสายงาน</b> จักษุแพทย์ รักษาโรคตาทั่วไป
                            </div> 
                        </div>
                        <!-- ชื่อผู้ดำเนินการ -->

                        <div class="row mt-4">
                            <div class="col-md-2"><label for="leaves_detail" class="form-label">ขอลากิจส่วนตัวเนื่องจาก<span class="text-danger"> *</span></label></div>
                            <div class="col-md-10">
                                <textarea class="form-control" name="leaves_detail" id="leaves_detail" style="height: 100px" placeholder="รายละเอียดการลากิจส่วนตัว">รายละเอียดขอลากิจส่วนตัว</textarea>
                            </div> 
                        </div>
                        <!-- ขอลากิจส่วนตัวเนื่องจาก -->

                        <div class="row mt-3">
                            <div class="col-md-2"><label class="form-label">ตั้งแต่วันที่<span class="text-danger"> *</span></label></div>
                            <div class="col-md-4">
                                <div class="input-group" id="leaves_date" name="leaves_date">
                                    <input type="text" class="form-control" name="leaves_start_date" id="leaves_start_date" value="">
                                    <span class="input-group-text">ถึง</span>
                                    <input type="text" class="form-control" name="leaves_end_date" id="leaves_end_date" value="">
                                </div>
                            </div> 
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                        <!-- ตั้งแต่วันที่ -->

                        <div class="row mt-3">
                            <div class="col-md-2"></div>
                            <div  class="col-md-10" id="output_leaves_table">
                                <table id="result_leaves_table" class="table table-bordered table-hover" width="100%">
                                    
                                </table>
                            </div>
                        </div>
                        <!-- ตารางรายละเอียดการลา -->

                        <div class="row mt-3">
                            <div class="col-md-2"><label class="form-label"></label></div>
                            <div class="col-md-10">
                                ข้าพเจ้าได้ลากิจส่วนตัว ครั้งสุดท้ายตั้งแต่วันที่ 8 ธันวาคม พ.ศ. 2566 ถึงวันที่ 13 ธันวาคม พ.ศ. 2566 มีกำหนด 3 วัน
                            </div> 
                        </div>
                        <!-- ประวัติการลากิจส่วนตัวครั้งล่าสุด -->

                        <div class="row mt-3">
                            <div class="col-md-2"><label for="leaves_address" class="form-label">ที่อยู่ที่สามารถติดต่อได้</label></div>
                            <div class="col-md-4">
                                <textarea class="form-control" id="leaves_address" name="leaves_address" style="height: 100px" placeholder="ที่อยู่ที่สามารถติดต่อได้">79/6 ถ.กาแป๊ะกอตอ 1 ตำบลเบตง อำเภอเบตง จังหวัดยะลา 95110 เบอร์โทรศัพท์ 0895984407</textarea>
                            </div> 
                            <div class="col-md-6">
                            </div>
                        </div>
                        <!-- ที่อยู่ที่สามารถติดต่อได้ -->

                        <div class="row mt-3">
                            <div class="col-md-2"><label for="leaves_upload_file" class="form-label">อัพโหลดไฟล์</label></div>
                            <div class="col-md-4">
                                <input class="form-control" type="file" id="leaves_upload_file" name="leaves_upload_file" accept=".pdf,.png,.jpg">
                            </div> 
                        </div>
                        <!-- อัพโหลดไฟล์ -->

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-6">
                                <label class="col-md-12 control-label" style="text-align:left;">
                                    (.pdf, .png และ .jpg เท่านั้น ขนาดไม่เกิน <?php echo $this->config->item('hr_upload_size')/1024 ?> MB )
                                </label>	
                            </div> 
                        </div> 	
                        <!-- แนบใบรับรองแพทย์, หมายเหตุ -->

                        <div class="row mt-5">
                            <div class="col-md-2"></div>
                            <div class="col-md-10">			
                                <div class="form-check float-start">
                                    <input class="form-check-input" type="checkbox" id="by_pass_leave" name="by_pass_leave" value="Y">
                                    <label class="form-check-label text-success fw-bold" for="by_pass_leave">
                                        สิ้นสุดการอนุมัติ
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- สิ้นสุดการอนุมัติ -->

                        <div class="row mt-5">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url().'/'.$controller.'leaves_type' ; ?>'"> ย้อนกลับ</button>
                                <button type="button" class="btn btn-success float-end" onclick="leaves_save_form()">บันทึก</button>
                            </div>
                        </div>
                        <!-- button action form -->
                    </form>
                    <!-- End Leaves Form -->
                   
                </div>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {
    // Set default end date
    const defaultEndDate = new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()); // Set default end date as 7 days ahead
    document.getElementById('leaves_end_date').value = formatDateToThai(defaultEndDate);
    generate_leaves_table();
});

function leaves_save_form() {
    var formData = $('#leaves_form_input').serialize(); // Serialize form data
    var isValid = true;

    var startDate = buddhistToGregorian(document.getElementById("leaves_start_date").value);
    var endDate = buddhistToGregorian(document.getElementById("leaves_end_date").value);
    var diffDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));

    $('#leaves_form_input .form-control').each(function() {
        var fieldName = $(this).attr('name');
        
        if (fieldName !== "leaves_upload_file" && $(this).val() === '') {
            isValid = false;
            $(this).removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid').siblings('.invalid-feedback').hide();
        }
    });


    if (isValid) {
        // All fields are filled, proceed with AJAX request
        $.ajax({
            url: '<?php echo site_url()."/".$controller; ?>leaves_save',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response)
                // Handle success response
                Swal.fire({
                    icon: "success",
                    title: "ดำเนินการเสร็จสิ้น",
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function(xhr, status, error) {
                // Handle error response
                Swal.fire({
                    icon: "error",
                    title: "ดำเนินการไม่สำเร็จ",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
    else{
        Swal.fire({
            icon: "error",
            title: "ดำเนินการไม่สำเร็จ<br>กรุณากรอกข้อมูลให้ครบถ้วน",
            showConfirmButton: false,
            timer: 1500
        });
    }
}


// Function to convert Buddhist Era date to Gregorian date
function buddhistToGregorian(buddhistDate) {
    let parts = buddhistDate.split('/');
    let year = parseInt(parts[2], 10) - 543;
    let month = parseInt(parts[1], 10) - 1; // Month in JS Date is 0-indexed
    let day = parseInt(parts[0], 10);
    return new Date(year, month, day);
}

function generate_leaves_table() {
    var startDateValue = document.getElementById("leaves_start_date").value;
    var endDateValue = document.getElementById("leaves_end_date").value;

    // Convert Buddhist dates to Gregorian dates
    let startDate = buddhistToGregorian(startDateValue);
    let endDate = buddhistToGregorian(endDateValue);

    // Calculate the difference in milliseconds
    let diffTime = endDate - startDate;

    // Calculate the difference in days
    let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    var table = "<table class='table table-bordered' width='100%'>" +
                    "<thead class='table-primary'>" +
                        "<tr>" +
                            "<th class='text-center' scope='col' rowspan='2'>#</th>" +
                            "<th class='text-center' scope='col' rowspan='2'>วันที่</th>" +
                            "<th class='text-center' scope='col' colspan='3'>ประเภทเวลา</th>" +
                            "<th class='text-center' scope='col' rowspan='2'>รวม</th>" +
                        "</tr>" +
                        "<tr>" +
                            "<th class='text-center' scope='col'>ลาเต็มวัน</th>" +
                            "<th class='text-center' scope='col'>ลาครึ่งวัน</th>" +
                            "<th class='text-center' scope='col'>ลาเป็นชั่วโมง</th>" +
                        "</tr>" +
                    "</thead>" +
                    "<tbody>";

    for (var i = 0; i <= diffDays; i++) {
        let currentDate = new Date(startDate);
        currentDate.setDate(currentDate.getDate() + i);
        var formattedDate = formatDate(currentDate);

        table += "<tr>" +
                    "<td><div class='text-center'>" + (i + 1) + "</div></td>" +
                    "<td><div class='text-center'>" + formattedDate + "</div></td>" +
                    "<td><div class='form-check'>" +
                        "<input class='form-check-input' type='radio' name='leaves_time_type_" + i + "' id='leaves_time_type_" + i + "_1' value='1' onchange='calculate_leaves_summary()' checked>" +
                    "</div></td>" +
                    "<td><div class='form-check'>" +
                        "<input class='form-check-input' type='radio' name='leaves_time_type_" + i + "' id='leaves_time_type_" + i + "_2' value='2' onchange='calculate_leaves_summary()'>" +
                        "<label class='form-check-label' for='leaves_time_type_" + i + "_2' value='1'>ครึ่งเช้า</label>" +
                    "</div>" +
                    "<div class='form-check'>" +
                        "<input class='form-check-input' type='radio' name='leaves_time_type_" + i + "' id='leaves_time_type_" + i + "_3' value='3' onchange='calculate_leaves_summary()'>" +
                        "<label class='form-check-label' for='leaves_time_type_" + i + "_3' value='1'>ครึ่งบ่าย</label>" +
                    "</div></td>" +
                    "<td>" +
                    "<div class='input-group' id='group_leaves_time_" + i + "' name='group_leaves_time_" + i + "'>" +
                        "<span class='input-group-text'><input class='form-check-input' type='radio' name='leaves_time_type_" + i + "' id='leaves_time_type_" + i + "_4' value='4' onchange='calculate_leaves_summary()'></span>" + 
                        "<input type='text' id='leaves_start_time_" + i + "' name='leaves_start_time_" + i + "' class='form-control leaves_time' onchange='calculate_leaves_summary()'>" +
                        "<span class='input-group-text'>ถึง</span>" +
                        "<input type='text' id='leaves_end_time_" + i + "' name='leaves_end_time_" + i + "' class='form-control leaves_time' onchange='calculate_leaves_summary()'>" +
                    "</div>" +
                    "</td>" +
                    "<td><div class='text-center' id='leaves_summary_" + i + "' name='leaves_summary_" + i + "'></div></td>" +
                "</tr>";
    }

    table += "</tbody>" +
                "<tfoot>" +
                    "<tr>" +
                        "<td colspan='5'><div class='text-center'>รวม</div></td>" +
                        "<td><div class='text-center' id='leaves_summary' name='leaves_summary'></div></td>" +
                    "</tr>" +
                "</tfoot>" +
            "</table>";

    document.getElementById("output_leaves_table").innerHTML = table;

    flatpickr(".leaves_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        defaultDate: "08:00"
    });
    $(".leaves_time").attr("disabled", true);
    calculate_leaves_summary();
}

function calculate_leaves_summary(){
    var totalDays = 0; // Initialize total days counter
    var totalHours = 0; // Initialize total hours counter
    var totalMinutes = 0; // Initialize total minutes counter

    var startDateValue = document.getElementById("leaves_start_date").value;
    var endDateValue = document.getElementById("leaves_end_date").value;

    // Convert Buddhist dates to Gregorian dates
    let startDate = buddhistToGregorian(startDateValue);
    let endDate = buddhistToGregorian(endDateValue);

    // Calculate the difference in milliseconds
    let diffTime = endDate - startDate;

    // Calculate the difference in days
    let diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

    // Loop through each row in the table
    for (var i = 0; i <= diffDays; i++) {
        // Get the selected radio button value for each row
        var radioValue = document.querySelector("input[name='leaves_time_type_" + i + "']:checked").value;
        var totalDay = 0; // Initialize total day counter
        var totalHour = 0; // Initialize total hour counter
        var totalMinute = 0; // Initialize total minute counter

        // Increment totalDays based on the radio button value
        if (radioValue === '1') {
            totalDays += 1;
            totalDay += 1;
            $("#leaves_start_time_" + i).attr("disabled", true);
            $("#leaves_end_time_" + i).attr("disabled", true);
        } else if (radioValue === '2' || radioValue === '3') {
            totalDays += 0.5;
            totalDay += 0.5;
            $("#leaves_start_time_" + i).attr("disabled", true);
            $("#leaves_end_time_" + i).attr("disabled", true);
        } else if (radioValue === '4') {
            // If radio value is 4, calculate the hours and minutes from the start and end time inputs
            var startTimeValue = document.getElementById("leaves_start_time_" + i).value;
            var endTimeValue = document.getElementById("leaves_end_time_" + i).value;
            $("#leaves_start_time_" + i).attr("disabled", false);
            $("#leaves_end_time_" + i).attr("disabled", false);

            // Parse start and end time strings to Date objects
            var startTime = new Date("2000-01-01T" + startTimeValue + ":00");
            var endTime = new Date("2000-01-01T" + endTimeValue + ":00");

            // Calculate the difference in milliseconds
            let timeDiff = endTime - startTime;

            // Calculate the difference in hours and minutes
            let hoursDiff = Math.floor(timeDiff / (1000 * 60 * 60));
            let minutesDiff = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));

            // Increment totalHours and totalMinutes
            totalHours += hoursDiff;
            totalMinutes += minutesDiff;

            // Increment totalHour and totalMinute
            totalHour = hoursDiff;
            totalMinute += minutesDiff;
        }

        // Convert excess minutes to hours if it's 60 or more
        if (totalMinute >= 60) {
            totalHour += Math.floor(totalMinute / 60);
            totalMinute = totalMinute % 60;
        }

        // Generate the summary text based on non-zero values
        var summaryText = "";
        if (totalDay !== 0) {
            summaryText += totalDay + " วัน";
        }
        if (totalHour !== 0) {
            summaryText += (summaryText ? ", " : "") + totalHour + " ชั่วโมง";
        }
        if (totalMinute !== 0) {
            summaryText += (summaryText ? ", " : "") + totalMinute + " นาที";
        }

        document.getElementById("leaves_summary_" + i).innerText = summaryText;
    }

    // Convert excess minutes to hours if it's 60 or more
    if (totalMinutes >= 60) {
        totalHours += Math.floor(totalMinutes / 60);
        totalMinutes = totalMinutes % 60;
    }

    // Generate the summary text based on non-zero values
    var summaryText = "";
    if (totalDays !== 0) {
        summaryText += totalDays + " วัน";
    }
    if (totalHours !== 0) {
        summaryText += (summaryText ? ", " : "") + totalHours + " ชั่วโมง";
    }
    if (totalMinutes !== 0) {
        summaryText += (summaryText ? ", " : "") + totalMinutes + " นาที";
    }

    document.getElementById("leaves_summary").innerText = summaryText;
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

flatpickr("#leaves_start_date", {
    plugins: [
        new rangePlugin({
            input: "#leaves_end_date"
        })
    ],
    dateFormat: 'd/m/Y',
    locale: 'th',
    defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
    onReady: function(selectedDates, dateStr, instance) {
        addMonthNavigationListeners();
        convertYearsToThai();
        generate_leaves_table();
    },
    onOpen: function(selectedDates, dateStr, instance) {
        convertYearsToThai();
    },
    onValueUpdate: function(selectedDates, dateStr, instance) {
        convertYearsToThai();
        if (selectedDates[0]) {
            document.getElementById('leaves_start_date').value = formatDateToThai(selectedDates[0]);
        }
        if (selectedDates[1]) {
            document.getElementById('leaves_end_date').value = formatDateToThai(selectedDates[1]);
        }
        generate_leaves_table();
    },
    onMonthChange: function(selectedDates, dateStr, instance) {
        convertYearsToThai();
    },
    onYearChange: function(selectedDates, dateStr, instance) {
        convertYearsToThai();
    }
});

flatpickr("#leaves_create_date", {
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
        if (!selectedDates || selectedDates.length === 0) { // ถ้ายังไม่ได้เลือกวันที่
            document.getElementById('leaves_create_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
        } else {
            document.getElementById('leaves_create_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
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
</script>