<?php
	/*
	* v_leaves_form_input_1
	* หน้าจอแบบฟอร์มการลาป่วย
	* @input lhis_leave_id = 1
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
<?php  
$row = $person_department_detail[0];
?>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-receipt icon-menu"></i><span> แบบฟอร์มทำเรื่องการลาป่วย</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show mb-3">
                <div class="accordion-body">

                    <!-- Start Leaves Form -->
                    <form id="leaves_form_input" class="needs-validation" method="post" action="<?php echo site_url()."/".$controller; ?>leaves_save">

                        <input type="hidden" name="lhis_leave_id" id="lhis_leave_id" value="<?php echo $lhis_leave_id; ?>">
                        <input type="hidden" name="leaves_count_select" id="leaves_count_select" value="">
                        <input type="hidden" name="lhis_ps_id" id="lhis_ps_id" value="<?php echo $row_profile->ps_id; ?>">

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
                                ขอลาป่วย
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
                                
                                <?php 
                                    echo "ข้าพเจ้า " . $row_profile->pf_name_abbr . $row_profile->ps_fname . " " . $row_profile->ps_lname; 
                                    echo "   <b>ประเภทบุคลากร</b>" . (isset($row->hire_name) ? $row->hire_name : "-"); 
                                    echo "   <b>ตำแหน่งปฏิบัติงาน</b>" . (isset($row->alp_name) ? $row->alp_name : "-"); 
                                
                                ?>
                            </div> 
                        </div>
                        <!-- ชื่อผู้ดำเนินการ -->

                        <div class="row mt-4">
                            <div class="col-md-2"><label for="leaves_detail" class="form-label">ขอลาป่วยเนื่องจาก<span class="text-danger"> *</span></label></div>
                            <div class="col-md-10">
                                <textarea class="form-control" name="leaves_detail" id="leaves_detail" style="height: 100px" placeholder="รายละเอียดการลาป่วย"></textarea>
                            </div> 
                        </div>
                        <!-- ขอลาป่วยเนื่องจาก -->

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
                                <?php 
                                    echo "ข้าพเจ้าได้".$lastest_leave_id->leave_name." ครั้งสุดท้ายตั้งแต่วันที่ ". abbreDate2($lastest_leave_id->lhis_start_date) . " ถึงวันที่ " . abbreDate2($lastest_leave_id->lhis_end_date) . " มีกำหนด "; 
                                    if($lastest_leave_id->lhis_num_day > 0){
                                        echo $lastest_leave_id->lhis_num_day." วัน ";
                                    }
                                    if($lastest_leave_id->lhis_num_hour > 0){
                                        echo $lastest_leave_id->lhis_num_hour." ชั่วโมง ";
                                    }
                                    if($lastest_leave_id->lhis_num_minute > 0){
                                        echo $lastest_leave_id->lhis_num_minute." นาที";
                                    }
                                ?>
                            </div> 
                        </div>
                        <!-- ประวัติการลาป่วยครั้งล่าสุด -->
                        <?php
                            $address_text = "";
                        ?>

                        <?php 
                            $address_text = !empty($row_profile->psd_addcur_no) ? $row_profile->psd_addcur_no . ' ' : '';
                            $address_text .= !empty($row_profile->psd_addcur_dist_id) ? ($row_profile->psd_addcur_pv_id != 1 ? "ต." : "แขวง") . $row_profile->dist_name . ' ' : '';
                            $address_text .= !empty($row_profile->psd_addcur_amph_id) ? "อ." . $row_profile->amph_name . ' ' : '';
                            $address_text .= !empty($row_profile->psd_addcur_pv_id) ? "จ." . $row_profile->pv_name . ' ' : '';
                            $address_text .= !empty($row_profile->psd_addcur_zipcode) ? $row_profile->psd_addcur_zipcode : '';

                        ?>


                        <div class="row mt-3">
                            <div class="col-md-2"><label for="leaves_address" class="form-label">ที่อยู่ที่สามารถติดต่อได้</label></div>
                            <div class="col-md-6">
                                <textarea class="form-control" id="leaves_address" name="leaves_address" rows="10" cols="100" placeholder="ที่อยู่ที่สามารถติดต่อได้"><?php echo htmlspecialchars(trim($address_text)); ?></textarea>
                            </div> 
                            <div class="col-md-4">
                            </div>
                        </div>
                        <!-- ที่อยู่ที่สามารถติดต่อได้ -->

                        <div class="row mt-3">
                            <div class="col-md-2"><label for="leaves_replace_id" class="form-label">มอบหมายงานให้กับ</label></div>
                            <div class="col-md-6">
                                <select class="form-select select2" data-placeholder="-- กรุณาเลือกรายชื่อบุคลากร --" name="leaves_replace_id" id="leaves_replace_id">
                                    <option value="0" selected>-- เลือกรายชื่อบุคลากร --</option>
                                    <?php foreach ($person_replace_list as $key => $ps) { ?>
                                        <option value="<?php echo $ps->ps_id; ?>"><?php echo $ps->pf_name.$ps->ps_fname." ".$ps->ps_lname; ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                            <div class="col-md-4">
                            </div>
                        </div>
                        <!-- มอบหมายงานให้กับ -->

                        <div class="row mt-4">
                            <div class="col-md-2"><label for="leaves_upload_file" class="form-label">อัพโหลดไฟล์</label></div>
                            <div class="col-md-4">
                                <input class="form-control" type="file" id="leaves_upload_file" name="leaves_upload_file" accept=".pdf,.png,.jpg">
                            </div> 
                        </div>
                        <!-- อัพโหลดไฟล์ -->

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <label class="col-md-12 control-label" style="text-align:left;">
                                    <b><u>แนบใบรับรองแพทย์</u></b><br>
                                    (.pdf, .png และ .jpg เท่านั้น ขนาดไม่เกิน <?php echo $this->config->item('hr_upload_size')/1024 ?> MB )<br>
                                    <b><u>หมายเหตุ</u></b> <b style="color:red">***</b> ทำเรื่องการลาป่วย ตั้งแต่ 3 วัน	ต้องแนบใบรับรองแพทย์ และส่งใบลาในวันมาทำงานวันแรก 
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
                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url().'/'.$controller.'leaves_type'.'/'.encrypt_id($row_profile->ps_id); ?>'"> ย้อนกลับ</button>
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
    var formData = new FormData($('#leaves_form_input')[0]); // Capture the form including files
    var isValid = true;

    var startDate = buddhistToGregorian(document.getElementById("leaves_start_date").value);
    var endDate = buddhistToGregorian(document.getElementById("leaves_end_date").value);
    // var diffDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));

    var leaves_summary_value = $("#leaves_summary_value").val();
    var [day, hour, minute] = leaves_summary_value.split('-');

    $('#leaves_form_input .form-control').each(function() {
        var fieldName = $(this).attr('name');

        if (fieldName === "leaves_upload_file" && day >= 3 && $(this).val() === '') {
            isValid = false;
            $(this).removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid').siblings('.invalid-feedback').hide();
        }

        if (fieldName === "leaves_detail" && $(this).val() === '') {
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
            processData: false, // Important for file uploads
            contentType: false, // Important for file uploads
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
    let count_day = 0;

    var table = "<table class='table table-bordered' width='100%'>" +
                    "<thead class='table-primary'>" +
                        "<tr>" +
                            "<th class='text-center' scope='col' rowspan='2'>#</th>" +
                            "<th class='text-center' scope='col' rowspan='2'>วันที่</th>" +
                            "<th class='text-center' scope='col' colspan='2'>ประเภทเวลา</th>" +
                            "<th class='text-center' scope='col' rowspan='2'>รวม</th>" +
                        "</tr>" +
                        "<tr>" +
                            "<th class='text-center' scope='col'>ลาเต็มวัน</th>" +
                            "<th class='text-center' scope='col'>ลารายชั่วโมง</th>" +
                        "</tr>" +
                    "</thead>" +
                    "<tbody>";

    for (var i = 0; i <= diffDays; i++) {
        let currentDate = new Date(startDate);
        currentDate.setDate(currentDate.getDate() + i);
        var formattedDate = formatDate(currentDate);
        count_day++;
        table += "<tr>" +
                    "<td><div class='text-center'>" + (i + 1) + "</div></td>" +
                    "<td><div class='text-center'>" + formattedDate + "</div></td>" +
                    "<td><div class='form-check'>" +
                        "<input class='form-check-input' type='radio' name='leaves_time_type_" + i + "' id='leaves_time_type_" + i + "_1' value='1' onchange='calculate_leaves_summary()' checked>" +
                    "</div></td>" +
                    "<td>" +
                    "<div class='input-group' id='group_leaves_time_" + i + "' name='group_leaves_time_" + i + "'>" +
                        "<span class='input-group-text'><input class='form-check-input' type='radio' name='leaves_time_type_" + i + "' id='leaves_time_type_" + i + "_2' value='2' onchange='calculate_leaves_summary()'></span>" + 
                        "<input type='text' id='leaves_start_time_" + i + "' name='leaves_start_time_" + i + "' class='form-control leaves_start_time' onchange='calculate_leaves_summary()'>" +
                        "<span class='input-group-text'>ถึง</span>" +
                        "<input type='text' id='leaves_end_time_" + i + "' name='leaves_end_time_" + i + "' class='form-control leaves_end_time' onchange='calculate_leaves_summary()'>" +
                    "</div>" +
                    "</td>" +
                    "<td>" +
                        "<div class='text-center' id='leaves_summary_" + i + "' name='leaves_summary_" + i + "'></div>" + 
                        "<input type='hidden' id='leaves_date_" + i + "' name='leaves_date_" + i + "' class='form-control' value='"+ formattedDate +"'>" + 
                        "<input type='hidden' id='leaves_summary_day_" + i + "' name='leaves_summary_day_" + i + "' class='form-control' value=''>" +
                        "<input type='hidden' id='leaves_summary_hour_" + i + "' name='leaves_summary_hour_" + i + "' class='form-control' value=''>" +
                        "<input type='hidden' id='leaves_summary_minute_" + i + "' name='leaves_summary_minute_" + i + "' class='form-control' value=''>"
                    "</td>" +
                "</tr>";
    }

    table += "</tbody>" +
                "<tfoot>" +
                    "<tr>" +
                        "<td colspan='4'><div class='text-center'>รวม</div></td>" +
                        "<td><div class='text-center' id='leaves_summary_text' name='leaves_summary_text'></div><input type='hidden' id='leaves_summary_value' name='leaves_summary_value' class='form-control' value=''></td>" +
                    "</tr>" +
                "</tfoot>" +
            "</table>";

    document.getElementById("output_leaves_table").innerHTML = table;

    $("#leaves_count_select").val(count_day);

    flatpickr(".leaves_start_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        defaultDate: "08:00"
    });
    $(".leaves_start_time").attr("disabled", true);

    flatpickr(".leaves_end_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        defaultDate: "09:00"
    });
    $(".leaves_end_time").attr("disabled", true);
    calculate_leaves_summary();
}

function calculate_leaves_summary() {
    var totalDays = 0; // Initialize total days counter
    var totalHours = 0; // Initialize total hours counter
    var totalMinutes = 0; // Initialize total minutes counter

    var startDateValue = document.getElementById("leaves_start_date").value;
    var endDateValue = document.getElementById("leaves_end_date").value;

    // Convert Buddhist dates to Gregorian dates
    let startDate = buddhistToGregorian(startDateValue);
    let endDate = buddhistToGregorian(endDateValue);

    // Calculate the difference in days
    let diffTime = endDate - startDate;
    let diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

    // Loop through each day in the date range
    for (var i = 0; i <= diffDays; i++) {
        var radioValue = document.querySelector("input[name='leaves_time_type_" + i + "']:checked").value;
        var dayCounter = 0;
        var hourCounter = 0;
        var minuteCounter = 0;

        if (radioValue === '1') {
            dayCounter = 1;
            totalDays += 1;
            $("#leaves_start_time_" + i).attr("disabled", true);
            $("#leaves_end_time_" + i).attr("disabled", true);

            document.getElementById("leaves_summary_day_" + i).value = dayCounter;
            document.getElementById("leaves_summary_hour_" + i).value = 0;
            document.getElementById("leaves_summary_minute_" + i).value = 0;
        } else if (radioValue === '2') {
            // Enable time input fields
            var startTimeValue = document.getElementById("leaves_start_time_" + i).value;
            var endTimeValue = document.getElementById("leaves_end_time_" + i).value;
            $("#leaves_start_time_" + i).attr("disabled", false);
            $("#leaves_end_time_" + i).attr("disabled", false);

            // Calculate time difference in hours and minutes
            var startTime = new Date("2000-01-01T" + startTimeValue + ":00");
            var endTime = new Date("2000-01-01T" + endTimeValue + ":00");
            let timeDiff = endTime - startTime;

            let hoursDiff = Math.floor(timeDiff / (1000 * 60 * 60));
            let minutesDiff = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));

            // Update counters for this row
            hourCounter = hoursDiff;
            minuteCounter = minutesDiff;

            // Add row counters to total counters
            totalHours += hoursDiff;
            totalMinutes += minutesDiff;

            document.getElementById("leaves_summary_day_" + i).value = 0;
            document.getElementById("leaves_summary_hour_" + i).value = hourCounter;
            document.getElementById("leaves_summary_minute_" + i).value = minuteCounter;

            // Convert excess minutes to hours for this row
            if (minuteCounter >= 60) {
                hourCounter += Math.floor(minuteCounter / 60);
                minuteCounter %= 60;
            }

            // Convert hours to days if they exceed 8 in this row
            if (hourCounter >= 8) {
                dayCounter += Math.floor(hourCounter / 8);
                hourCounter %= 8;
            }
        }

        // Display individual summary text for each row
        document.getElementById("leaves_summary_" + i).innerText = generateSummaryText(dayCounter, hourCounter, minuteCounter);
    }

    // Final conversion for accumulated total minutes to hours
    totalHours += Math.floor(totalMinutes / 60);
    totalMinutes %= 60;

    // Final conversion for accumulated total hours to days
    totalDays += Math.floor(totalHours / 8);
    totalHours %= 8;

    // Generate and display the final summary
    let finalSummaryText = generateSummaryText(totalDays, totalHours, totalMinutes);
    document.getElementById("leaves_summary_text").innerText = finalSummaryText;
    document.getElementById("leaves_summary_value").value = totalDays + "-" + totalHours + "-" + totalMinutes;
}

// Helper function to generate summary text
function generateSummaryText(days, hours, minutes) {
    let summaryText = "";
    if (days !== 0) {
        summaryText += days + " วัน";
    }
    if (hours !== 0) {
        summaryText += (summaryText ? ", " : "") + hours + " ชั่วโมง";
    }
    if (minutes !== 0) {
        summaryText += (summaryText ? ", " : "") + minutes + " นาที";
    }
    return summaryText;
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
    defaultDate: [
                    new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()),
                    new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate())
                ], // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
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

</script>