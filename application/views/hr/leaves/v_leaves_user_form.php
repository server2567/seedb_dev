<?php
/*
	* v_leaves_user_form
	* หน้าจอแสดงข้อมูลกฏการลา
	* @input leave_type_id = 1
	* $output -
	* @author Patcharapol  Sirimaneechot
	* @Create Date 2567-10-07
	*/
    
?>
<?php 
    echo "target_user_leave_summary:<br> "; 
    print_r($target_user_leave_summary);
    echo "<br><hr>";
    echo "base_info:<br> "; 
    print_r($base_info);

    $target_user_leave_summary = $target_user_leave_summary[0];
?>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ตั้งค่าการคำนวณอายุงาน</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                        <div class="col-6" id="div_select_dp_id">
                            <label for="SearchLastName" class="form-label">เลือกหน่วยงาน</label>
                            <select class="select2" name="select_dp_id" id="select_dp_id">
                                <option value="-1" disabled>-- เลือกหน่วยงาน --</option>
                                
                                
                                <?php $i = 1;
                                foreach ($base_info["pos_work_start_date_with_dp_id"] as $item) { ?>
                                    <option value="<?php echo $item["pos_dp_id"]; ?>"><?php echo $item["dp_name_th"] ?></option>
                                <?php $i++; } ?>
                            </select>
                        </div>
                        <div class="col-6" id="div_select_date_cal_type">
                            <label for="SearchLastName" class="form-label">เลือกประเภทการคำนวณอายุงาน</label>
                            <select class="select2" name="select_date_cal_type" id="select_date_cal_type">
                                <option value="-1" disabled>-- เลือกประเภทการคำนวณอายุงาน --</option>
                                <option value="carlendar_year">ปีปฏิทิน</option>
                                <option selected value="custom_year">กำหนดวันที่คำนวณอายุงาน</option>
                                <?php /*
                                <?php $i = 1;
                                foreach ($filter_options["lsum_year"] as $y) { ?>
                                    <option <?php  ?>value="<?php echo $y; ?>"><?php echo $y+543 ?></option>
                                <?php $i++; } ?>
                                */ ?>
                            </select>
                        </div>
                        
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
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <span> ข้อมูลบุคลากร</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                        <div class="col-md-7">
                            <div class="row mb-2">
                                <div class="col-md-4 text-end">
                                    <label for="" class="form-label">ชื่อ-นามสกุล</label>
                                </div>
                                <!-- <div class="col-md-3"> -->
                                <div class="col-md-4">
                                    <label for="" class="form-label"><?php echo $target_user_leave_summary['pf_name'].$target_user_leave_summary['ps_fname']." ".$target_user_leave_summary['ps_lname']; ?></label>
                                    <!-- <label for="" class="form-label">นพ.บรรยง ชินกุลกิจนิวัฒน์</label> -->
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 text-end">
                                    <label for="" class="form-label">ประเภทบุคลากร</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label"><?php echo $target_user_leave_summary['hire_abbr']; ?></label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 text-end">
                                    <label for="" class="form-label">ประเภทสายงาน</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label"><?php echo $target_user_leave_summary['detail']; ?></label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 text-end">
                                    <label for="" class="form-label">อายุงาน</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label" id="work-age"></label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 text-end">
                                    <label for="" class="form-label">ปีงบประมาณ</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label"><?php echo $budget_year + 543; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 p-2" style="background-color: #ffecb3;">
                            <span>
                                <u><b>วีธีกำหนดและตั้งค่าสิทธิ์วันลา</b></u><br>
                                <b>1.</b> กดปุ่ม <b>"บันทึก"</b> เพื่อเพิ่มสิทธิ์การลาที่บุคลากรควรจะได้รับในแต่ละปี และคำนวณวันลาพักผ่อนคงเหลือจากปีก่อนหน้า <br>
                                <b>2.</b> กดปุ่ม <b>"ตั้งค่าสิทธิ์วันลาใหม่"</b> เพื่อคำนวณและประมวลผลจำนวนวันลาที่บุคลากรควรจะได้รับจริง โดยจะคำนวณวันลาพักผ่อนคงเหลือจากปีงบประมาณ
                                ก่อนหน้ามารวมกับจำนวนวันลาที่ได้รับ ในปีงบประมาณปัจจุบัน และคำนวณตามข้อมูลจำนวน "วันลาสะสมสูงสุด"<br>
                                <u><b>หมายเหตุ</b></u> กรุณาทำตามขั้นตอนทุกครั้ง
                            </span>
                        </div>
                        <div class="col-md-12 text-end mt-2">
                            <button class="btn btn-primary">ตั้งค่าสิทธิ์วันลาใหม่</button>
                        </div>
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
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ข้อมูลวันลา</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <table class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" hidden>#</th>
                                <th class="text-center" scope="col">ประเภทการลา</th>
                                <th class="text-center" scope="col">ชนิดการลา</th>
                                <th class="text-center" scope="col" width="2%">จำนวนครั้งที่ลาไปแล้ว</th>
                                <th class="text-center" scope="col" width="15%">จำนวนครั้งคงเหลือ</th>
                                <th class="text-center" scope="col">จำนวนวันที่ได้รับ (รวมสะสม)</th>
                                <th class="text-center" scope="col">จำนวนวันที่ลาไปแล้ว</th>
                                <th class="text-center" scope="col">จำนวนวันที่ลาไปแล้วนอกระบบ</th>
                                <th class="text-center" scope="col">จำนวนวันคงเหลือ</th>
                                <th class="text-center" scope="col">จำนวนยอดสะสม</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <?php if ($i < 4) { ?>
                                    <tr>
                                        <td hidden>
                                            <div class="text-center"><?php echo $i + 1; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start">ลาป่วย</div>
                                        </td>
                                        <td>
                                            <div class="text-start">เหตุปฏิบัติราชการ</div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="ไม่ระบุ" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="99" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0"></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="99" disabled></div>
                                        </td>
                                        <td>
                                         
                                        </td>
                                    </tr>
                                <?php } else { ?>
                                    <!-- <tr>
                                        <td hidden>
                                            <div class="text-center"><?php echo $i + 1; ?></div>
                                        </td>
                                        <td>
                                            <div class="text-start">ลาพักผ่อน</div>
                                        </td>
                                        <td>
                                            <div class="text-start">เหตุปฏิบัติราชการ</div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="ไม่ระบุ" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="99" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0"></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="99" disabled></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><input type="text" class="fomr-control text-center" value="0" ></div>
                                        </td>
                                    </tr> -->
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function calWorkAge(data, workAgeDays) {
        if (data == "YES") {
            // return "แสดงข้อมูล";
            
            days = workAgeDays;

            years_remaining = parseInt(days / 365); //divide by 365 and throw away the remainder
            minused = (years_remaining * 365); 

            days -= minused;

            months_remaining = parseInt(days / 30); //divide by 365 and throw away the remainder
            minused = (months_remaining * 30); 

            days -= minused;

            days_remaining = days % 365;    //divide by 365 and *return* the remainder

            return `${years_remaining} ปี ${months_remaining} เดือน ${days_remaining} วัน`;
        } else {
            return "-";
        }
    }

    document.getElementById("work-age").innerHTML = calWorkAge(`<?= $target_user_leave_summary['final_found'] ?>`, <?= $target_user_leave_summary['work_experience_days'] ?>);



    ///

    
    $(document).ready(function() {
        // Initial DataTable update
        updateDataTable();
        renderWorkAgeCalSettingUI($('#select_date_cal_type').val());
    });

    function renderWorkAgeCalSettingUI(calType, switchUI = false) {
        if (calType === "custom_year") {
                $("#div_select_dp_id").removeClass("col-6");
                $("#div_select_date_cal_type").removeClass("col-6");
                $("#div_select_dp_id").addClass("col-3");
                $("#div_select_date_cal_type").addClass("col-3");
        } else {
                $("#div_select_dp_id").removeClass("col-3");
                $("#div_select_date_cal_type").removeClass("col-3");
                $("#div_select_dp_id").addClass("col-6");
                $("#div_select_date_cal_type").addClass("col-6");
            }

        // if (switchUI) {
        //     if (calType === "custom_year") {
        //         $("#div_select_dp_id").removeClass("col-6");
        //         $("#div_select_date_cal_type").removeClass("col-6");
        //         $("#div_select_dp_id").addClass("col-3");
        //         $("#div_select_date_cal_type").addClass("col-3");
        //         } else {
        //             if ($("#div_select_dp_id").hasClass("col-3") && $("#div_select_date_cal_type").hasClass("col-3")) {
        //                 $("#div_select_dp_id").removeClass("col-3");
        //                 $("#div_select_date_cal_type").removeClass("col-3");
        //                 $("#div_select_dp_id").addClass("col-6");
        //                 $("#div_select_date_cal_type").addClass("col-6");
        //             }
        //     }
        // } else {
        //     if (calType === "custom_year") {
        //         if (calType === "custom_year") {
        //         $("#div_select_dp_id").removeClass("col-6");
        //         $("#div_select_date_cal_type").removeClass("col-6");
        //         $("#div_select_dp_id").addClass("col-3");
        //         $("#div_select_date_cal_type").addClass("col-3");
        //         } else {
        //             if ($("#div_select_dp_id").hasClass("col-3") && $("#div_select_date_cal_type").hasClass("col-3")) {
        //                 $("#div_select_dp_id").removeClass("col-3");
        //                 $("#div_select_date_cal_type").removeClass("col-3");
        //                 $("#div_select_dp_id").addClass("col-6");
        //                 $("#div_select_date_cal_type").addClass("col-6");
        //             }
        //         }
        //     }
        // }
        
    }

    // Event listeners for select dropdowns
    $('#select_date_cal_type').on('change', function() {
        // updateDataTable();
        renderWorkAgeCalSettingUI($('#select_date_cal_type').val(), true);
        
    });

    // Event listeners for select dropdowns
    // $('#select_dp_id, #select_date_cal_type , #select_hire_type, #select_work_status').on('change', function() {
    //     // Update DataTable when a select dropdown changes
    //     // alert(`Hi ${$('#select_budget_year').val()}`);
    //     updateDataTable();
    // });

    // Function to update DataTable based on select dropdown values
    // function updateDataTable() {
        
    //     // Initialize DataTable
    //     var dataTable = $('#leave_summary_table').DataTable();

    //     // select_budget_year = Number(select_budget_year) - 543;
    //     // var select_budget_year = $('#select_budget_year').val() - 543;
    //     // var select_budget_year = $('#select_budget_year').val();
    //     let select_budget_year = document.getElementById("select_budget_year").value;
    //     var select_hire_is_medical = $('#select_hire_is_medical').val();
    //     var select_hire_type = $('#select_hire_type').val();
    //     var select_work_status = $('#select_work_status').val();

    //     // alert(`detect ${select_budget_year}`);

    //     function checkData(data) {
    //         if (data == "YES") {
    //             return "มีข้อมูลแล้ว";
    //         } else {
    //             return "ยังไม่มีข้อมูล";
    //         }
    //     }

    //     function calWorkAge(data, workAgeDays) {
    //         if (data == "YES") {
    //             // return "แสดงข้อมูล";
                
    //             days = workAgeDays;

    //             years_remaining = parseInt(days / 365); //divide by 365 and throw away the remainder
    //             minused = (years_remaining * 365); 

    //             days -= minused;

    //             months_remaining = parseInt(days / 30); //divide by 365 and throw away the remainder
    //             minused = (months_remaining * 30); 

    //             days -= minused;

    //             days_remaining = days % 365;    //divide by 365 and *return* the remainder

    //             return `${years_remaining} ปี ${months_remaining} เดือน ${days_remaining} วัน`;
    //         } else {
    //             return "-";
    //         }
    //     }

    //     function checkDateCalType(data) {
    //         if (data == "carlendar_year") {
    //             return "ปีปฏิทิน";
    //         } else if (data == "custom_year") {
    //             return "วันที่ที่เจ้าหน้าที่กำหนด";
    //         } else {
    //             return "-";
    //         }
    //     }

    //     function checkDataShowDash(data) {
    //         if (data !== null) {
    //             return data;
    //         } else {
    //             return "-";
    //         }
    //     }

    //     function displayEndDateCal(dateCalType, endDateCal, year) {
    //         if (dateCalType == 'carlendar_year') {
    //             return `${year}-01-01`
    //         } else if (dateCalType == 'custom_year') {
    //             if (endDateCal != null) {
    //                 return endDateCal;
    //             } else {
    //                 return "-";
    //             }
    //         } else {
    //             return '-';
    //         }
            
    //     }

    //     // Make AJAX request to fetch updated data
    //     $.ajax({
    //         url: '<?php //site_url() . "/" . $controller_dir ?>' + "leaves_user/get_leave_summary_by_condition/",
    //         type: 'POST',
    //         data: {
    //             select_budget_year: Number(select_budget_year),
    //             // select_budget_year: Number(select_budget_year) - 543,
    //             select_hire_is_medical,
    //             select_hire_type,
    //             select_work_status
    //         },
    //         success: function(response) {
    //             data = JSON.parse(response)
    //             // console.log('data: ', data);

    //             // Clear existing DataTable data
    //             dataTable.clear().draw();

    //             // // Update summary count
    //             $("#leave_summary_table_row_amount").text(data.result.length);

    //             index = 1;
    //             data.result.forEach((item, index) => {
                    
    //                 // button = `
    //                 //     <div class="text-center option">
    //                 //         <button class="btn btn-warning" onclick="window.location.href='<?php// echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
    //                 //     </div>
    //                 // `;

    //                 button = `
    //                     <div class="text-center option">
    //                         <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/?select_budget_year=${select_budget_year}&user_id=${item['T1.pos_ps_id']}'"><i class="bi-pencil-square"></i></button>
    //                     </div>
    //                 `;

                    

    //                 // Add new row to DataTable
    //                 dataTable.row.add([
    //                         ++index,
    //                         (`${item.ps_fname} ${item.ps_lname}`) ,
    //                         item.hire_abbr,
    //                         item.detail,
    //                         checkData(item.final_found),
    //                         calWorkAge(item.final_found, item.work_experience_days),
    //                         checkDateCalType(item.lsum_date_cal_type),
    //                         // checkDataShowDash(item.pos_work_start_date),
    //                         checkDataShowDash(item.pos_work_start_date),
    //                         displayEndDateCal(item.lsum_date_cal_type, item.lsum_end_date_cal, Number(select_budget_year)),
    //                         // item.lsum_year,
    //                         button
    //                     ]).draw();
    //             });

    //             // Initialize tooltips for new buttons
    //             $('[data-bs-toggle="tooltip"]').tooltip();
    //         },
    //         error: function(xhr, status, error) {
    //             // Handle errors
    //             dialog_error({
    //                 'header': text_toast_default_error_header,
    //                 'body': text_toast_default_error_body
    //             });
    //         }
    //     });
    // }
</script>