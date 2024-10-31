<?php
/*
	* v_leaves_user_list
	* หน้าจอกำหนดสิทธิ์การลารายบุคคล
	* @input leave_type_id = 1
	* $output -
	* @author Patcharapol  Sirimaneechot
	* @Create Date 2567-10-07
	*/
    
?>
<?php // print_r($all_user_leave_summary[0]); ?>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-search icon-menu"></i><span> ค้นหาข้อมูลสิทธิ์ลารายบุคคล</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                        <div class="col-3">
                            <label for="SearchLastName" class="form-label">เลือกปีงบประมาณ</label>
                            <select class="select2" name="select_budget_year" id="select_budget_year">
                                <option value="-1" disabled>-- เลือกปีงบประมาณ --</option>
                                <!-- <option value="all" selected>ทั้งหมด</option> -->
                                <?php $i = 1;
                                foreach ($filter_options["lsum_year"] as $y) { ?>
                                    <option <?php  ?>value="<?php echo $y; ?>"><?= $y+543 ?></option>
                                <?php $i++; } ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="SearchLastName" class="form-label">เลือกสายปฏิบัติงาน</label>
                            <select class="select2" name="select_hire_is_medical" id="select_hire_is_medical">
                                <option value="-1" disabled>-- เลือกสายปฏิบัติงาน --</option>
                                <option value="-99" selected>ทั้งหมด</option>
                                <?php foreach ($filter_options["hire_is_medical"] as $h) { ?>
                                    <option value="<?= $h['code'] ?>"><?= $h['detail'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="SearchLastName" class="form-label">เลือกประเภทการปฏิบัติงาน</label>
                            <select class="select2" name="select_hire_type" id="select_hire_type">
                                <option value="-1" disabled>-- เลือกประเภทการปฏิบัติงาน --</option>
                                <option value="-99" selected>ทั้งหมด</option>
                                <option value="1">เต็มเวลา</option>
                                <option value="2">บางเวลา</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="SearchLastName" class="form-label">เลือกสถานะการทำงาน</label>
                            <select class="select2" name="select_work_status" id="select_work_status">
                                <option value="-1" disabled>-- เลือกสถานะการทำงาน --</option>
                                <option value="-99" selected>ทั้งหมด</option>
                                <option value="1">ปฏิบัติงานอยู่</option>
                                <option value="2">ลาออกแล้ว</option>
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
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-people icon-menu"></i><span> ข้อมูลสิทธิ์ลารายบุคคล</span><span class="badge bg-success" id="leave_summary_table_row_amount">0</span>
                </button>
            </h2>
            <?php // print_r($all_user_leave_summary) ?>
            <?php // echo ($all_user_leave_summary["ps_fname"]) ?>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table id="leave_summary_table" class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">ชื่อ-นามสกุล</th>
                                <th class="text-center" scope="col">ประเภทบุคลากร</th>
                                <th class="text-center" scope="col" width="15%">ประเภทสายงาน</th>
                                <th class="text-center" scope="col">สถานะข้อมูลสิทธิ์ลารายบุคคล</th>
                                <th class="text-center" scope="col">อายุงาน</th>
                                <th class="text-center" scope="col">ประเภทการคำนวณอายุงาน</th>
                                <th class="text-center" scope="col">วันเริ่มต้นการคำนวณ</th>
                                <th class="text-center" scope="col">วันสิ้นสุดการคำนวณ</th>
                                <!-- <th class="text-center" scope="col">lsum_year</th> -->
                                <th class="text-center" scope="col">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php /*
                                $i = 1;
                                foreach($all_user_leave_summary as $ls) {
                            ?>
                                <tr>
                                    <?php // print_r($ls); ?>
                                    <td>
                                        <!-- <div class="text-center"><?php // echo $i++; ?></div> -->
                                    </td>
                                    <td>
                                        <!-- <div class="text-start"><?php // echo $ls['ps_fname'] . " " . $ls['ps_lname']; ?></div> -->
                                    </td>
                                    <td>
                                        <!-- <div class="text-start"><?php // echo $ls['hire_abbr'] ?></div> -->
                                    </td>
                                    <td>
                                        <!-- <div class="text-start"><?php // echo $ls['detail'] ?></div> -->
                                    </td>
                                    <td>
                                        <!-- <div class="text-start"><?php // if ($ls['l_sum_match_hr_person'] == "IS_NULL") { echo "ไม่มีข้อมูล"; } else { echo "มีข้อมูล"; } ?></div> -->
                                    </td>
                                    <td>
                                        <!-- <div class="text-start"><?php // if ($ls['l_sum_match_hr_person'] == "IS_NULL") { echo "-"; } else { echo "แสดงข้อมูล"; } ?></div> -->
                                    </td>
                                    <td>
                                        <!-- <div class="text-start"><?php // echo $ls['lsum_year'] ?></div> -->
                                    </td>
                                    <td>
                                        <!-- <div class="text-center option">
                                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/<?php echo 1 ?>'"><i class="bi-pencil-square"></i></button>
                                            <button class="btn btn-danger"><i class="bi-trash"></i></button>
                                        </div> -->
                                    </td>
                                </tr>
                            <?php } */ ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Initial DataTable update
        updateDataTable();
    });

     // Event listeners for select dropdowns
     $('#select_budget_year, #select_hire_is_medical , #select_hire_type, #select_work_status').on('change', function() {
        // Update DataTable when a select dropdown changes
        // alert(`Hi ${$('#select_budget_year').val()}`);
        updateDataTable();
    });

    // Function to update DataTable based on select dropdown values
    function updateDataTable() {
        
        // Initialize DataTable
        var dataTable = $('#leave_summary_table').DataTable();

        // select_budget_year = Number(select_budget_year) - 543;
        // var select_budget_year = $('#select_budget_year').val() - 543;
        // var select_budget_year = $('#select_budget_year').val();
        let select_budget_year = document.getElementById("select_budget_year").value;
        var select_hire_is_medical = $('#select_hire_is_medical').val();
        var select_hire_type = $('#select_hire_type').val();
        var select_work_status = $('#select_work_status').val();

        // alert(`detect ${select_budget_year}`);

        function checkData(data) {
            if (data == "YES") {
                return "มีข้อมูลแล้ว";
            } else {
                return "ยังไม่มีข้อมูล";
            }
        }

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

        function checkDateCalType(data) {
            if (data == "carlendar_year") {
                return "ปีปฏิทิน";
            } else if (data == "custom_year") {
                return "วันที่ที่เจ้าหน้าที่กำหนด";
            } else {
                return "-";
            }
        }

        function checkDataShowDash(data) {
            if (data !== null) {
                return data;
            } else {
                return "-";
            }
        }

        function displayEndDateCal(dateCalType, endDateCal, year) {
            if (dateCalType == 'carlendar_year') {
                return `${year}-01-01`
            } else if (dateCalType == 'custom_year') {
                if (endDateCal != null) {
                    return endDateCal;
                } else {
                    return "-";
                }
            } else {
                return '-';
            }
            
        }

        // Make AJAX request to fetch updated data
        $.ajax({url: '<?php site_url() . "/" . $controller_dir ?>' + "leaves_user/get_leave_summary_by_condition/",
            type: 'POST',
            data: {
                select_budget_year: Number(select_budget_year),
                // select_budget_year: Number(select_budget_year) - 543,
                select_hire_is_medical,
                select_hire_type,
                select_work_status
            },
            success: function(response) {
                data = JSON.parse(response)
                // console.log('data: ', data);

                // Clear existing DataTable data
                dataTable.clear().draw();

                // // Update summary count
                $("#leave_summary_table_row_amount").text(data.result.length);

                index = 1;
                data.result.forEach((item, index) => {
                    
                    // button = `
                    //     <div class="text-center option">
                    //         <button class="btn btn-warning" onclick="window.location.href='<?php// echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/<?php// echo 1 ?>'"><i class="bi-pencil-square"></i></button>
                    //     </div>
                    // `;

                    button = `
                        <div class="text-center option">
                            <button class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/?select_budget_year=${select_budget_year}&user_id=${item['T1.pos_ps_id']}'"><i class="bi-pencil-square"></i></button>
                        </div>
                    `;

                    

                    // Add new row to DataTable
                    dataTable.row.add([
                            ++index,
                            (`${item.ps_fname} ${item.ps_lname}`) ,
                            item.hire_abbr,
                            item.detail,
                            checkData(item.final_found),
                            calWorkAge(item.final_found, item.work_experience_days),
                            checkDateCalType(item.lsum_date_cal_type),
                            // checkDataShowDash(item.pos_work_start_date),
                            checkDataShowDash(item.pos_work_start_date),
                            displayEndDateCal(item.lsum_date_cal_type, item.lsum_end_date_cal, Number(select_budget_year)),
                            // item.lsum_year,
                            button
                        ]).draw();
                });

                // Initialize tooltips for new buttons
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            error: function(xhr, status, error) {
                // Handle errors
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': text_toast_default_error_body
                });
            }
        });
    }
</script>