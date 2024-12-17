<?php
/*
	* v_leaves_form_input_4
	* หน้าจอแบบฟอร์มการลากิจไม่รับค่าจ้าง
	* @input lhis_leave_id = 4
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

    .table,
    tr,
    td,
    th {
        vertical-align: middle;
    }
</style>
<!-- <div class="col-md-4 mt-5">
    <section class="section dashboard"> -->
        <?php
        foreach ($leave_type_list as $key => $ctrl) {
            $text_class = "";
            $text_bg_color = "";
            $text_color = "";


            // Calculate total remaining time in minutes, considering 1 day = 8 hours
            $total_remain_minutes = ($ctrl->lsum_remain_day * 8 * 60) + ($ctrl->lsum_remain_hour * 60) + $ctrl->lsum_remain_minute;
            $total_per_minutes = ($ctrl->lsum_per_day * 8 * 60) + ($ctrl->lsum_per_hour * 60) + $ctrl->lsum_per_minute;

            // Calculate the remaining percentage
            $remain_percentage = $total_per_minutes > 0 ? ($total_remain_minutes / $total_per_minutes) * 100 : 0;

            // Determine the color class based on the percentage
            if ($remain_percentage > 50) {
                $text_class = "success";
                $text_color = "#2eca6a";
                $text_bg_color = "#e0f8e9";
            } else if ($remain_percentage >= 21 && $remain_percentage <= 49) {
                $text_class = "warning";
                $text_color = "#ff771d";
                $text_bg_color = "#ffecdf";
            } else {
                $text_class = "danger";
                $text_color = "#fa5278";
                $text_bg_color = "#ffe0e7";
            }

            $text_remain = "";
            if ($ctrl->lsum_remain_day == 0) {
                $text_remain .= "คงเหลือ ";
            } else {
                $text_remain .= "คงเหลือ " . $ctrl->lsum_remain_day . " วัน ";
            }
            if ($ctrl->lsum_remain_hour != 0) {
                $text_remain .= $ctrl->lsum_remain_hour . " ชั่วโมง ";
            }
            if ($ctrl->lsum_remain_minute != 0) {
                $text_remain .= $ctrl->lsum_remain_minute . " นาที ";
            }

            $text_per = "";
            if ($ctrl->lsum_per_day != 0) {
                $text_per .= $ctrl->lsum_per_day . " วัน ";
            }
            if ($ctrl->lsum_per_hour != 0) {
                $text_per .= $ctrl->lsum_per_hour . " ชั่วโมง ";
            }
            if ($ctrl->lsum_per_minute != 0) {
                $text_per .= $ctrl->lsum_per_minute . " นาที ";
            }
        ?>

            <!-- <div class="card info-card">
                <div class="card-body">
                    <h6 class="card-title"><?php echo $ctrl->leave_name; ?></h6>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: <?php echo $text_color; ?>; background: <?php echo $text_bg_color; ?>;">
                            <i class="bi bi-calendar2-heart-fill"></i>
                        </div>
                        <div class="ps-3 mt-3">
                            <h5><span class="text-<?php echo $text_class; ?> fw-bold"><?php echo $text_remain; ?></span></h5>
                            <span class="text-dark small">จำนวนสิทธิ์การลาที่ได้รับ <?php echo $text_per; ?></span>
                        </div>
                    </div>
                </div>
            </div> -->
            
        <?php
        }
        ?>

    <!-- </section>
</div>
<div class="col-md-8"></div> -->

<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-receipt icon-menu"></i><span> แบบฟอร์มขออนุมัติ<?php echo $ctrl->leave_name . "ประจำปีปฏิทิน พ.ศ. " . ($year+543); ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show mb-3">
                <div class="accordion-body">

                    <!-- Start Leaves Form -->
                    <form id="leaves_form_input" class="needs-validation" method="post" action="<?php echo site_url() . "/" . $controller; ?>leaves_save">

                        <input type="hidden" name="lhis_leave_id" id="lhis_leave_id" value="<?php echo $lhis_leave_id; ?>">
                        <input type="hidden" name="leaves_count_select" id="leaves_count_select" value="">
                        <input type="hidden" name="lhis_ps_id" id="lhis_ps_id" value="<?php echo $row_profile->ps_id; ?>">
                        <input type="hidden" name="lhis_year" id="lhis_year" value="<?php echo $year; ?>">

                        <div class="row mt-3">
                            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                                <h5><span class="text-<?php echo $text_class; ?> fw-bold"><?php echo $text_remain; ?></span></h5>
                                <span class="text-dark small">จำนวนสิทธิ์การลาที่ได้รับ <?php echo $text_per; ?></span>
                            </div>
                            <div class="col-md-3 text-end"><label for="leaves_location_create" class="form-label">เขียนที่<span class="text-danger"> *</span></label></div>
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
                                ขอ<?php echo $ctrl->leave_name; ?>
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
                               
                                echo "ข้าพเจ้า " . $row_profile->pf_name_abbr . $row_profile->ps_fname . " " . $row_profile->ps_lname . " ";
                                echo $stde_group;
                                ?>
                            </div>
                        </div>
                        <!-- ชื่อผู้ดำเนินการ -->

                        <div class="row mt-4">
                            <div class="col-md-2"><label for="leaves_detail" class="form-label">ขอ<?php echo $ctrl->leave_name; ?>เนื่องจาก<span class="text-danger"> *</span></label></div>
                            <div class="col-md-10">
                                <textarea class="form-control" name="leaves_detail" id="leaves_detail" style="height: 100px" placeholder="รายละเอียดการ<?php echo $ctrl->leave_name; ?>"></textarea>
                            </div>
                        </div>
                        <!-- ขอลากิจไม่รับค่าจ้างเนื่องจาก -->

                        <div class="row mt-3">
                            <div class="col-md-2"><label class="form-label">ตั้งแต่วันที่<span class="text-danger"> *</span></label></div>
                            <div class="col-md-4">
                                <div class="input-group" id="leaves_date" name="leaves_date">
                                    <input type="text" class="form-control" name="leaves_start_date" id="leaves_start_date" value="">
                                    <span class="input-group-text">ถึง</span>
                                    <input type="text" class="form-control" name="leaves_end_date" id="leaves_end_date" value="">
                                </div>
                            </div>
                            <div class="col-md-6" id="text_warning_balance_leave">

                            </div>
                        </div>
                        <!-- ตั้งแต่วันที่ -->

                        <div class="row mt-3">
                            <div class="col-md-2"></div>
                            <div class="col-md-10" id="output_leaves_table">
                                <table id="result_leaves_table" class="table table-bordered table-hover" width="100%">

                                </table>
                            </div>
                        </div>
                        <!-- ตารางรายละเอียดการลา -->

                        <div class="row mt-3">
                            <div class="col-md-2"><label class="form-label"></label></div>
                            <div class="col-md-10">
                                <?php

                                if(isset($lastest_leave_id)){
                                echo "ข้าพเจ้าได้" . $lastest_leave_id->leave_name . " ครั้งสุดท้ายตั้งแต่วันที่ " . abbreDate2($lastest_leave_id->lhis_start_date) . " ถึงวันที่ " . abbreDate2($lastest_leave_id->lhis_end_date) . " มีกำหนด ";
                                if ($lastest_leave_id->lhis_num_day > 0) {
                                    echo $lastest_leave_id->lhis_num_day . " วัน ";
                                }
                                if ($lastest_leave_id->lhis_num_hour > 0) {
                                    echo $lastest_leave_id->lhis_num_hour . " ชั่วโมง ";
                                }
                                if ($lastest_leave_id->lhis_num_minute > 0) {
                                    echo $lastest_leave_id->lhis_num_minute . " นาที";
                                }
                                }
                               
                                ?>
                            </div>
                        </div>
                        <!-- ประวัติการลากิจไม่รับค่าจ้างครั้งล่าสุด -->
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
                                        <option value="<?php echo $ps->ps_id; ?>"><?php echo $ps->pf_name . $ps->ps_fname . " " . $ps->ps_lname; ?></option>
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
                                    (.pdf, .png และ .jpg เท่านั้น ขนาดไม่เกิน <?php echo $this->config->item('hr_upload_size') / 1024 ?> MB )<br>
                                    <!-- <b><u>หมายเหตุ</u></b> <b style="color:red">***</b> ทำเรื่องการ<?php echo $ctrl->leave_name; ?> ตั้งแต่ 3 วัน ต้องแนบใบรับรองแพทย์ และส่งใบลาในวันมาทำงานวันแรก -->
                                </label>
                            </div>
                        </div>
                        <!-- แนบใบรับรองแพทย์, หมายเหตุ -->

                        <?php
                        if ($this->session->userdata('leaves_by_pass') == "show") {
                        ?>

                            <div class="row mt-5">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <div class="form-check float-start">
                                        <input class="form-check-input" type="checkbox" id="by_pass_leave" name="by_pass_leave" value="">
                                        <label class="form-check-label text-success fw-bold" for="by_pass_leave">
                                            สิ้นสุดการอนุมัติ
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- สิ้นสุดการอนุมัติ -->

                        <?php
                        }
                        ?>

                        <div class="row mt-5">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo site_url() . '/' . $controller . 'leaves_type' . '/' . encrypt_id($row_profile->ps_id); ?>'"> ย้อนกลับ</button>
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

<!-- Modal -->
<div class="modal fade" id="timework_detail_modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- modal-lg for a larger modal -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">รายละเอียดข้อมูลตารางวันทำงาน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBodyContent" style="max-height: 400px; overflow-y: auto;">
        <!-- Content will be injected here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>





<script>
    var isValid = true;
    var text_valid = "";
    var Global_timework_plan_data;

    $(document).ready(function() {
        // Set default end date
        const defaultEndDate = new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()); // Set default end date as 7 days ahead
        document.getElementById('leaves_end_date').value = formatDateToThai(defaultEndDate);
        // generate_leaves_table();
    });

    function leaves_save_form() {
        var formData = new FormData($('#leaves_form_input')[0]); // Capture the form including files
        var isValid = true;
        var startDate = buddhistToGregorian(document.getElementById("leaves_start_date").value);
        var endDate = buddhistToGregorian(document.getElementById("leaves_end_date").value);
        // var diffDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));

        var leaves_summary_value = $("#leaves_summary_value").val();
        var [day, hour, minute] = leaves_summary_value.split('-');

        

        // $('#leaves_form_input .form-control').each(function() {
        //     var fieldName = $(this).attr('name');

        //     if (fieldName === "leaves_upload_file" && day >= 3 && $(this).val() === '') {
        //         isValid = false;
        //         text_valid = "ทำเรื่องการ<?php echo $ctrl->leave_name; ?> ตั้งแต่ 3 วัน ต้องแนบใบรับรองแพทย์<br>";
        //         $(this).removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
        //     } else if (fieldName === "leaves_detail" && $(this).val() === '') {
        //         isValid = false;
        //         text_valid = "กรุณากรอกข้อมูลให้ครบถ้วน<br>";
        //         $(this).removeClass('is-valid').addClass('is-invalid').siblings('.invalid-feedback').show();
        //     } else {
        //         $(this).removeClass('is-invalid').addClass('is-valid').siblings('.invalid-feedback').hide();
        //     }
        // });

        if(day == 0 && hour == 0 && minute == 0){
            isValid = false;
            text_valid = "ผลรวมจำนวนต้องมากกว่า 1 ชั่วโมง<br>";
        }
        else if(day == 0 && hour < 1){
            isValid = false;
            text_valid = "ผลรวมจำนวนต้องมากกว่า 1 ชั่วโมง<br>";
        }

        if (isValid) {
            // All fields are filled, proceed with AJAX request
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller; ?>leaves_save',
                type: 'POST',
                data: formData,
                processData: false, // Important for file uploads
                contentType: false, // Important for file uploads
                success: function(response) {
                    // console.log(response);
                    data = JSON.parse(response);
                    console.log(data);
                    if (data.status_response == status_response_success) {
                        // Swal.fire({
                        //     icon: "success",
                        //     title: "ดำเนินการเสร็จสิ้น",
                        //     showConfirmButton: false,
                        //     timer: 1500
                        // });
                        const url = '<?php echo base_url(); ?>index.php/hr/leaves/Leaves_report/generate_report_leaves/' + `${data.lhis_last_insert_id}`;
                        window.open(url, '_blank');
                        Swal.fire({
                            icon: "success",
                            title: "ดำเนินการเสร็จสิ้น",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.return_url; // เปลี่ยน URL ไปยังเป้าหมายใหม่
                        });

                    } else if (data.status_response == status_response_error) {
                        // Handle error response
                        Swal.fire({
                            icon: "error",
                            title: "ดำเนินการไม่สำเร็จ<br>" + data.message_dialog,
                            showConfirmButton: true
                        });
                        $("#text_warning_balance_leave").html(
                            "<p><font color='red'><b>" +
                            data.message_dialog +
                            "</b></font></p>"
                        );
                    }
                    // Handle success response

                },
                error: function(xhr, status, error) {
                    // Handle error response
                    Swal.fire({
                        icon: "error",
                        title: "ดำเนินการไม่สำเร็จ",
                        showConfirmButton: true
                    });
                }
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "ดำเนินการไม่สำเร็จ<br>" + text_valid,
                showConfirmButton: true
            });
            text_valid = '';
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
        
        if(!startDateValue && !endDateValue){
            startDateValue = getCurrentDateInBuddhistYear();
            endDateValue = getCurrentDateInBuddhistYear();

        }

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
            "<th class='text-center' scope='col' rowspan='2' width='5%'>#</th>" +
            "<th class='text-center' scope='col' rowspan='2' width='15%'>วันที่</th>" +
            "<th class='text-center' scope='col' colspan='2' width='15%'>ประเภทเวลา</th>" +
            "<th class='text-center' scope='col' rowspan='2' width='10%'>รวม</th>" +
            "</tr>" +
            "<tr>" +
            "<th class='text-center' scope='col' width='10%'>ลาเต็มวัน</th>" +
            "<th class='text-center' scope='col' width='20%'>ลารายชั่วโมง</th>" +
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
                "<td>" +
                    "<div class='text-center'>" + 
                        "<a href='#' data-bs-toggle='modal' data-bs-target='#timework_detail_modal' onclick='showTimeworkModalData(\"" + formattedDate + "\")'>" + 
                            formattedDate + 
                        "</a>" + 
                    "</div>" +
                "<div class='text-center' id='show_warning_timework_plan_work_" + i + "' style='display: none;'></div>" +
                // "<div class='text-center' id='show_warning_timework_plan_work_" + i + "' style='display: none;'><span class='badge bg-primary text-white'><i class='bi bi-briefcase me-1 font-16'></i>วันทำงาน</span></div>" +
                "<div class='text-center' id='show_warning_timework_plan_holiday_" + i + "' style='display: none;'><span class='badge bg-success text-white'><i class='bi bi-calendar-check me-1 font-16'></i>วันหยุดประจำสัปดาห์</span></div>" +
                "<div class='text-center' id='show_warning_timework_plan_empty_" + i + "' style='display: none;'><span class='badge bg-danger text-white'><i class='bi bi-exclamation-octagon me-1 font-16'></i>ยังไม่ได้จัดตารางการปฏิบัติงาน</span></div>" +
                "</td>" +
                "<td id='td_leaves_time_type_" + i + "'><div class='form-check' id='div_form_check_" + i + "'>" +
                "<input class='form-check-input' type='radio' name='leaves_time_type_" + i + "' id='leaves_time_type_" + i + "_1' value='1' onchange='calculate_leaves_summary()' checked>" +
                "</div></td>" +
                "<td id='td_group_leave_time_" + i + "'>" +
                "<div class='input-group' id='group_leaves_time_" + i + "' name='group_leaves_time_" + i + "'>" +
                "<span class='input-group-text'><input class='form-check-input' type='radio' name='leaves_time_type_" + i + "' id='leaves_time_type_" + i + "_2' value='2' onchange='calculate_leaves_summary()'></span>" +
                "<input type='text' id='leaves_start_time_" + i + "' name='leaves_start_time_" + i + "' class='form-control leaves_start_time' onchange='calculate_leaves_summary()'>" +
                "<span class='input-group-text'>ถึง</span>" +
                "<input type='text' id='leaves_end_time_" + i + "' name='leaves_end_time_" + i + "' class='form-control leaves_end_time' onchange='calculate_leaves_summary()'>" +
                "</div>" +
                "<div class='text-center' id='show_warning_time_type_2_" + i + "' style='display: none;'><span class='badge bg-warning text-dark'><i class='bi bi-exclamation-triangle me-1 font-16'></i> 8 ชั่วโมง มีค่าเท่ากับ 1 วัน</span></div>" +
                "<div class='text-center' id='show_warning_break_type_2_" + i + "' style='display: none;'><span class='badge bg-success text-white'><i class='bi bi-check-circle me-1 font-16'></i> คำนวณเวลารวมพักระหว่างวัน</span></div>" +
                "</td>" +
                "<td>" +
                "<div class='text-center' id='leaves_summary_" + i + "' name='leaves_summary_" + i + "'></div>" +
                "<div class='text-center' id='show_warning_time_summary_" + i + "' style='display: none;'><span class='badge bg-warning text-white'><i class='bi bi-exclamation-triangle me-1 font-16'></i>คำนวณไม่ถูกต้อง</span></div>" +
                "<input type='hidden' id='leaves_date_" + i + "' name='leaves_date_" + i + "' class='form-control' value='" + formattedDate + "'>" +
                "<input type='hidden' id='leaves_timework_break_" + i + "' name='leaves_timework_break_" + i + "' class='form-control' value=''>" +
                "<input type='hidden' id='leaves_timework_plan_" + i + "' name='leaves_timework_plan_" + i + "' class='form-control' value=''>" +
                "<input type='hidden' id='leaves_summary_day_" + i + "' name='leaves_summary_day_" + i + "' class='form-control' value=''>" +
                "<input type='hidden' id='leaves_summary_hour_" + i + "' name='leaves_summary_hour_" + i + "' class='form-control' value=''>" +
                "<input type='hidden' id='leaves_summary_minute_" + i + "' name='leaves_summary_minute_" + i + "' class='form-control' value=''>"
            "</td>" +
            "</tr>";
        }

        table += "</tbody>" +
            "<tfoot>" +
            "<tr>" +
            "<td colspan='4'><div class='text-center'>รวม </div></td>" +
            "<td><div class='text-center' id='leaves_summary_text' name='leaves_summary_text'></div><input type='hidden' id='leaves_summary_value' name='leaves_summary_value' class='form-control' value=''></td>" +
            "</tr>" +
            "</tfoot>" +
            "</table>" +
            '<p><font color="red"> * หมายเหตุ : ทั้งนี้หากท่านคิดว่าข้อมูลของท่านไม่ถูกต้อง กรุณาประสานงานเจ้าหน้าที่ทรัพยากรบุคคล</font><br><font color="red"><i class="bi bi-exclamation-circle"></i> 60 นาที มีค่าเท่ากับ 1 ชั่วโมง</font><br><font color="red"><i class="bi bi-exclamation-circle"></i> 8 ชั่วโมง มีค่าเท่ากับ 1 วัน</font></p>';

        document.getElementById("output_leaves_table").innerHTML = table;

        $("#leaves_count_select").val(count_day);

        flatpickr(".leaves_start_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: "08:00",
            // minuteIncrement: 60 // ปิดการเลือกนาที
        });
        $(".leaves_start_time").attr("disabled", true);

        flatpickr(".leaves_end_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: "09:00",
            // minuteIncrement: 60 // ปิดการเลือกนาที
        });

        $(".leaves_end_time").attr("disabled", true);

        calculate_leaves_summary();

    }

    // ฟังก์ชันเพื่อแสดงวันที่ปัจจุบันในรูปแบบ DD/MM/YYYY (ปี พ.ศ.)
    function getCurrentDateInBuddhistYear() {
        const today = new Date(); // วันที่ปัจจุบัน
        const day = String(today.getDate()).padStart(2, '0'); // วัน (เติม 0 ข้างหน้า)
        const month = String(today.getMonth() + 1).padStart(2, '0'); // เดือน (เริ่มจาก 0 ต้อง +1)
        const buddhistYear = today.getFullYear() + 543; // ปี ค.ศ. + 543 เป็นปี พ.ศ.

        return `${day}/${month}/${buddhistYear}`; // รูปแบบ DD/MM/YYYY (ปี พ.ศ.)
    }

    function buddhistThToGregorian(dateStr) {

        // Split the input date (day/month/year) format
        let [day, month, year] = dateStr.split('/').map(Number);

        // Convert Buddhist year to Gregorian year by subtracting 543
        year -= 543;

        // Format the Gregorian date as YYYY-MM-DD
        return `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    }

    // Function to display the date and details in the modal
    function showTimeworkModalData(date) {
        
        let modalContent = `
        <p><strong>วันที่ที่เลือก:</strong> ${date}</p>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">ชื่อรูปแบบ</th>
                    <th class="text-center">เวลาเริ่ม</th>
                    <th class="text-center">เวลาสิ้นสุด</th>
                    <th class="text-center">คำนวณเวลารวมพักระหว่างวัน (กรณีลามากกว่า 4 ชม.)</th>
                </tr>
            </thead>
            <tbody>`;

        date = buddhistThToGregorian(date);
        var num = 0;
        let matchedData = Global_timework_plan_data.filter(item => item.twpp_display_date === date);
        if (matchedData.length > 0) {
            matchedData.forEach(item => {
                num++;
                modalContent += `
                <tr>
                    <td class="text-center">${num}</td>
                    <td class="text-center">${item.twpp_is_holiday == "0" ? item.twac_name_th : "วันหยุด (OFF)"} ${item.twac_is_ot == '1' ? "<br><p class='text-secondary font-14'>OT</p>" : ''}</td>
                    <td class="text-center">${item.twpp_start_time.substring(0, 5)}</td>
                    <td class="text-center">${item.twpp_end_time.substring(0, 5)}</td>
                    <td class="text-center">${item.twac_is_break == "0" ? '<i class="bi bi-check-circle text-success font-26"></i>' : ''}</td>
                </tr>`;
            });
        } else {
            modalContent += `
                <tr>
                    <td colspan="5" class="text-center">ไม่พบข้อมูลสำหรับวันที่นี้</td>
                </tr>`;
        }

        // Inject content into modal body
        document.getElementById("modalBodyContent").innerHTML = modalContent;
    }


    function check_timework_plan(callback) {
        var startDateValue = document.getElementById("leaves_start_date").value;
        var endDateValue = document.getElementById("leaves_end_date").value;

        if(!startDateValue && !endDateValue){
            startDateValue = getCurrentDateInBuddhistYear();
            endDateValue = getCurrentDateInBuddhistYear();
        }

        let startDate = buddhistThToGregorian(startDateValue);
        let endDate = buddhistThToGregorian(endDateValue);

        $.ajax({
            url: '<?php echo site_url() . "/" . $controller; ?>check_timework_plan_for_leave',
            type: 'POST',
            data: {
                start_date: startDate,
                end_date: endDate,
                ps_id: "<?php echo encrypt_id($row_profile->ps_id); ?>"
            },
            success: function(response) {
                data = JSON.parse(response);

                Global_timework_plan_data = data;

                // Calculate the difference in days
                let startDateLeave = buddhistToGregorian(startDateValue);
                let endDateLeave = buddhistToGregorian(endDateValue);

                let diffTime = new Date(endDateLeave) - new Date(startDateLeave);
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                for (var i = 0; i <= diffDays; i++) {

                    var leaves_date = buddhistThToGregorian($("#leaves_date_" + i).val());
                    // Show the holiday warning by default
                    $("#show_warning_timework_plan_work_" + i).show();
                    $("#show_warning_timework_plan_holiday_" + i).hide();
                    $("#show_warning_timework_plan_empty_" + i).hide();

                    // Loop through data to determine if it is a work or holiday
                    for (let j = 0; j < data.length; j++) {
                        let item = data[j];
                        // console.log(leaves_date);

                        if(item.twpp_display_date === leaves_date && item.twac_is_break == 0){
                            $("#leaves_timework_break_" + i).val('empty');
                        }
                        else if(item.twpp_display_date === leaves_date && item.twac_is_break == 1){
                            $("#leaves_timework_break_" + i).val('break');
                        }
                        
                        if (item.twpp_display_date === leaves_date && item.twpp_is_holiday == 0) {
                            // If date matches, show work warning, hide holiday warning, set as work
                            $("#show_warning_timework_plan_work_" + i).show();
                            $("#show_warning_timework_plan_holiday_" + i).hide();
                            $("#show_warning_timework_plan_empty_" + i).hide();
                            
                            $("#leaves_timework_plan_" + i).val('work');
                            break;
                        } 
                        else if (item.twpp_display_date === leaves_date && item.twpp_is_holiday == 1) {
                            // If no match, set as holiday
                            $("#show_warning_timework_plan_work_" + i).hide();
                            $("#show_warning_timework_plan_holiday_" + i).show();
                            $("#show_warning_timework_plan_empty_" + i).hide();
                            $("#leaves_timework_plan_" + i).val('holiday');
                            break;
                        }
                        else {
                            // If no match, set as holiday
                            $("#show_warning_timework_plan_work_" + i).hide();
                            $("#show_warning_timework_plan_holiday_" + i).hide();
                            $("#show_warning_timework_plan_empty_" + i).show();
                            $("#leaves_timework_plan_" + i).val('empty');
                            
                        }
                      
                    }
                }
                // Once AJAX completes, run the provided callback (calculate_leaves_summary logic)
                if (typeof callback === "function") {
                    callback(data);
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

    function calculate_leaves_summary() {
        check_timework_plan(function(data) {
            // The summary calculation logic now runs only after AJAX completes
            var totalDays = 0;
            var totalHours = 0;
            var totalMinutes = 0;

            var startDateValue = document.getElementById("leaves_start_date").value;
            var endDateValue = document.getElementById("leaves_end_date").value;

            let startDate = buddhistToGregorian(startDateValue);
            let endDate = buddhistToGregorian(endDateValue);

            let diffTime = endDate - startDate;
            let diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

            for (var i = 0; i <= diffDays; i++) {
                var radioValue = document.querySelector("input[name='leaves_time_type_" + i + "']:checked").value;
                var dayCounter = 0;
                var hourCounter = 0;
                var minuteCounter = 0;

                // Hide warnings by default
                $("#show_warning_time_type_2_" + i).hide();
                $("#show_warning_break_type_2_" + i).hide();
                $("#show_warning_time_summary_" + i).hide();
                $("#show_warning_timework_plan_work_" + i).hide();
                $("#show_warning_timework_plan_holiday_" + i).hide();
                $("#show_warning_timework_plan_empty_" + i).hide();

                var status_work_date = $("#leaves_timework_plan_" + i).val();
                var status_break = $("#leaves_timework_break_" + i).val();

                if (status_work_date == "holiday") {
                    document.getElementById("leaves_summary_day_" + i).value = 0;
                    document.getElementById("leaves_summary_hour_" + i).value = 0;
                    document.getElementById("leaves_summary_minute_" + i).value = 0;

                } else if (status_work_date == "work" && radioValue === '1') {
                    dayCounter = 1;
                    totalDays += 1;
                    $("#leaves_start_time_" + i).attr("disabled", true);
                    $("#leaves_end_time_" + i).attr("disabled", true);

                    document.getElementById("leaves_summary_day_" + i).value = dayCounter;
                    document.getElementById("leaves_summary_hour_" + i).value = 0;
                    document.getElementById("leaves_summary_minute_" + i).value = 0;
                } else if (status_work_date == "work" && radioValue === '2') {
                    var startTimeValue = document.getElementById("leaves_start_time_" + i).value;
                    var endTimeValue = document.getElementById("leaves_end_time_" + i).value;

                    $("#leaves_start_time_" + i).attr("disabled", false);
                    $("#leaves_end_time_" + i).attr("disabled", false);

                    var startTime = new Date("2000-01-01T" + startTimeValue + ":00");
                    var endTime = new Date("2000-01-01T" + endTimeValue + ":00");

                    let timeDiff = endTime - startTime;

                    // Default break times
                    const lunchStartHour = 4; // 4th hour of work
                    const lunchEndHour = 5;   // 5th hour of work

                    // Calculate hours and minutes difference
                    let hoursDiff = Math.floor(timeDiff / (1000 * 60 * 60));
                    let minutesDiff = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));

                    // Adjust for dynamic lunch break
                    if (status_break === "empty" && hoursDiff >= lunchStartHour) {
                        hoursDiff -= 1; // Subtract 1 hour for the lunch break
                        console.log("Lunch break deducted: 1 hour");
                        $("#show_warning_break_type_2_" + i).show();
                    } else {
                        $("#show_warning_break_type_2_" + i).hide();
                    }

                    // Handling 8-hour day logic
                    if (hoursDiff >= 8) {
                        dayCounter += Math.floor(hoursDiff / 8);
                        hoursDiff %= 8;
                        $("#show_warning_time_type_2_" + i).show();
                    } else {
                        $("#show_warning_time_type_2_" + i).hide();
                    }

                    // Update counters
                    hourCounter = hoursDiff;
                    minuteCounter = minutesDiff;
                    totalDays += dayCounter;
                    totalHours += hourCounter;
                    totalMinutes += minuteCounter;

                    // Update the DOM elements
                    document.getElementById("leaves_summary_day_" + i).value = dayCounter;
                    document.getElementById("leaves_summary_hour_" + i).value = hourCounter;
                    document.getElementById("leaves_summary_minute_" + i).value = minuteCounter;

                    // Time validation
                    if (startTimeValue === endTimeValue || totalHours < 0 || totalMinutes < 0) {
                        $("#show_warning_time_summary_" + i).show();
                        isValid = false;
                    } else {
                        $("#show_warning_time_summary_" + i).hide();
                        isValid = true;
                    }


                }

                if (status_work_date == "work") {
                    $("#show_warning_timework_plan_work_" + i).show();
                    $("#show_warning_timework_plan_holiday_" + i).hide();
                    $("#show_warning_timework_plan_empty_" + i).hide();
                    updateLeaveTypeRow(i, false);
                    document.getElementById("leaves_summary_" + i).innerText = generateSummaryText(dayCounter, hourCounter, minuteCounter);
                } else if (status_work_date == "holiday") {
                    $("#show_warning_timework_plan_work_" + i).hide();
                    $("#show_warning_timework_plan_holiday_" + i).show();
                    $("#show_warning_timework_plan_empty_" + i).hide();
                    updateLeaveTypeRow(i, true);
                    document.getElementById("leaves_summary_" + i).innerText = " 0 วัน";
                }
                else{
                    $("#show_warning_timework_plan_work_" + i).hide();
                    $("#show_warning_timework_plan_holiday_" + i).hide();
                    $("#show_warning_timework_plan_empty_" + i).show();
                    updateLeaveTypeRow(i, true);
                    document.getElementById("leaves_summary_" + i).innerHTML = "<font color='red'>0 วัน</font>";
                    text_valid = "ยังไม่ได้จัดตารางการปฏิบัติงาน";
                    isValid = false;
                }
            }

            totalHours += Math.floor(totalMinutes / 60);
            totalMinutes %= 60;

            totalDays += Math.floor(totalHours / 8);
            totalHours %= 8;

            let finalSummaryText = generateSummaryText(totalDays, totalHours, totalMinutes);
            document.getElementById("leaves_summary_text").innerText = finalSummaryText;
            document.getElementById("leaves_summary_value").value = totalDays + "-" + totalHours + "-" + totalMinutes;
        });
    }

    function updateLeaveTypeRow(i, isHoliday) {
        let tdLeavesTimeType = document.getElementById("td_leaves_time_type_" + i);
        let divFormCheck = document.getElementById("div_form_check_" + i);
        let tdGroupLeaveTime = document.getElementById("td_group_leave_time_" + i);

        if (isHoliday) {
            // Set colspan to 2 for the leave time type cell
            tdLeavesTimeType.setAttribute("colspan", "2");

            // Hide the form check and leave time group elements
            divFormCheck.style.display = "none";
            tdGroupLeaveTime.style.display = "none";
        } else {
            // Remove colspan if it's not a holiday
            tdLeavesTimeType.removeAttribute("colspan");

            // Show the form check and leave time group elements
            divFormCheck.style.display = "";
            tdGroupLeaveTime.style.display = "";
        }
    }


    // Helper function to generate summary text
    function generateSummaryText(days, hours, minutes) {
        let summaryText = "";
        if (days > 0) {
            summaryText += days + " วัน";
        }
        if (hours > 0) {
            summaryText += (summaryText ? ", " : "") + hours + " ชั่วโมง";
        }
        if (minutes > 0) {
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
        minDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ห้ามเลือกวันก่อนหน้า
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