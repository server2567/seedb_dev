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
                    <i class="bi-search icon-menu"></i><span> ค้นหาข้อมูลสิทธิ์การลาบุคคลกร</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3" method="post" action="<?php echo base_url(); ?>index.php/ums/SyncHRsingle">
                        <div class="col-3">
                            <label for="SearchLastName" class="form-label">ปีปฏิทิน</label>
                            <!-- <script>
                                $('#select_budget_year').select2({});
                            </script> -->
                            <select class="select2" name="select_budget_year" id="select_budget_year">
                                <option value="-1" disabled>-- เลือกปีปฏิทิน --</option>
                                <!-- <option value="all" selected>ทั้งหมด</option> -->
                                <?php 
                                $i = 1;
                                foreach ($filter_options["lsum_year"] as $y) { ?>
                                    <option id="select_budget_year_<?php echo $i; ?>" <?php if($i==2) echo 'selected="selected"';?>value="<?php echo $y; ?>"><?= $y+543?></option>
                                <?php $i++; } ?>
                            </select>
                        </div>
                        <!-- <script>
                            let max_year_in_array = `${<?php// echo $filter_options["lsum_year"][0]; ?>}`;
                            console.log('select_budget_year_1: ', document.getElementById(`select_budget_year_1`).value);
                            console.log(`max_year_in_array: ${max_year_in_array}`);
                            // $('#select_budget_year').select2('val', [""+max_year_in_array]);
                            $('#select_budget_year').select2('val', max_year_in_array);
                        </script> -->
                        <div class="col-3">
                            <label for="SearchLastName" class="form-label">สายปฏิบัติงาน</label>
                            <select class="select2" name="select_hire_is_medical" id="select_hire_is_medical">
                                <!-- <option value="-1" disabled>-- เลือกสายปฏิบัติงาน --</option>
                                <option value="-99" selected>ทั้งหมด</option>
                                <?php foreach ($filter_options["hire_is_medical"] as $h) { ?>
                                    <option value="<?= $h['code'] ?>"><?= $h['detail'] ?></option>
                                <?php } ?> -->
                                <?php
                                    // Assuming $hire_is_medical is already available as an array
                                    $medical_types = [
                                        'M'  => 'สายการแพทย์',
                                        'N'  => 'สายการพยาบาล',
                                        'SM' => 'สายสนับสนุนทางการแพทย์',
                                        'T'  => 'สายเทคนิคและบริการ',
                                        'A'  => 'สายบริหาร'
                                    ];
                                    echo '<option value="-99">ทั้งหมด</option>';
                                    // Loop through hire_is_medical and display corresponding options
                                    foreach ($this->session->userdata('hr_hire_is_medical') as $value) {
                                        $type = $value['type'];
                                        if (isset($medical_types[$type])) {
                                            echo '<option value="' . $type . '">' . $medical_types[$type] . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="SearchLastName" class="form-label">ประเภทการทำงาน</label>
                            <select class="select2" name="select_hire_type" id="select_hire_type">
                                <option value="-1" disabled>-- เลือกประเภทการปฏิบัติงาน --</option>
                                <option value="-99" selected>ทั้งหมด</option>
                                <option value="1">ปฏิบัติงานเต็มเวลา (Full-Time)</option>
                                <option value="2">ปฏิบัติงานบางเวลา (Part-Time)</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="SearchLastName" class="form-label">สถานะการทำงาน</label>
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
                    <i class="bi-people icon-menu"></i><span>ข้อมูลรายชื่อบุคคลกร</span><span class="badge bg-success" id="leave_summary_table_row_amount">0</span>
                </button>
            </h2>
            <?php // print_r($all_user_leave_summary) ?>
            <?php // echo ($all_user_leave_summary["ps_fname"]) ?>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <table id="leave_summary_table" class="table datatable" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" width="2%">#</th>
                                <th class="text-center" scope="col" width="15%">ชื่อ-นามสกุล</th>
                                <th class="text-center" scope="col" width="10%">ประเภทบุคลากร</th>
                                <!-- <th class="text-center" scope="col" width="10%">ประเภทสายงาน</th> -->
                                <!-- <th class="text-center" scope="col" width="5%">ประเภทการปฏิบัติงาน</th> -->
                                <th class="text-center" scope="col" width="10%">อายุงาน</th>
                                <th class="text-center" scope="col" width="10%">ประเภทการคำนวณอายุงาน</th>
                                <th class="text-center" scope="col" width="10%">วันเริ่มต้นการคำนวณ</th>
                                <th class="text-center" scope="col" width="10%">วันสิ้นสุดการคำนวณ</th>
                                <!-- <th class="text-center" scope="col">lsum_year</th> -->
                                <th class="text-center" scope="col" width="5%">สถานะการดำเนินการ</th>
                                <th class="text-center" scope="col" width="5%">ดำเนินการ</th>
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
                // return "มีข้อมูลแล้ว";
                // return "ดำเนินการแล้ว";
                return `<div class="text-center option"><span class="badge rounded-pill bg-success">ดำเนินการแล้ว</span></div>`;
            } else {
                // return "ยังไม่มีข้อมูล";
                // return "รอดำเนินการ";
                return `<div class="text-center option"><span class="badge rounded-pill bg-warning">รอดำเนินการ</span></div>`;
            }
        }

        // function calWorkAgeLegacy(data, workAgeDays) {
        //     if (data == "YES") {
        //         // return "แสดงข้อมูล";
                
        //         days = workAgeDays;

        //         years_remaining = parseInt(days / 365); //divide by 365 and throw away the remainder
        //         minused = (years_remaining * 365); 

        //         days -= minused;

                // months_remaining = parseInt(days / 30); //divide by 365 and throw away the remainder
        //         minused = (months_remaining * 30); 

        //         days -= minused;

        //         days_remaining = days % 365;    //divide by 365 and *return* the remainder

        //         return `${years_remaining} ปี ${months_remaining} เดือน ${days_remaining} วัน`;
        //     } else {
        //         return "-";
        //     }
        // }

        function calWorkAge(data, workAgeDays) {
            if (data == "YES") {
                // return "แสดงข้อมูล";
                
                days = workAgeDays;

                years_remaining = parseInt(days / 365); //divide by 365 and throw away the remainder
                minused = (years_remaining * 365); 

                days -= minused;

                if (days >= 360) {
                    days -= 5;
                }

                months_remaining = parseInt(days / 30); //divide by 365 and throw away the remainder
                // if ((days / 30) <= (11.0)) {
                //     months_remaining = parseInt(days / 30); //divide by 365 and throw away the remainder
                //     minused = (months_remaining * 30); 
                    
                // } else {
                //     months_remaining = 11;
                //     minused = (months_remaining * 30); 
                //     minused += 5;
                    
                //     // console.log(`my minused, ${minused}`)
                //     // mount_is_more_than_11 = true;
                    
                //     // days_remaining += (days - minused);
                    
                // }
                
                minused = (months_remaining * 30); 

                if (months_remaining >= 12) {
                    years_remaining += 1;
                    months_remaining = 0;

                    // console.log('******');
                    // console.log(`refreshed.... years_remaining = ${years_remaining}, months_remaining = ${months_remaining}`)
                    // console.log('******');
                }

                days -= minused;

                days_remaining = days % 365;    //divide by 365 and *return* the remainder

                

                if (years_remaining < 1 && months_remaining < 1 && days_remaining < 1) {
                    return `0 วัน`;
                } else {
                    return `${(years_remaining > 0) ? ' '+years_remaining+' ปี' : '' }${(months_remaining > 0) ? ' '+months_remaining+' เดือน' : ''}${(days_remaining > 0) ? ' '+days_remaining+' วัน' : '' }`.substring(1);
                }
            } else {
                return "-";
            }
        }

        function checkDateCalType(data) {
            if (data == "carlendar_year") {
                return "ปีปฏิทิน";
            } else if (data == "custom_year") {
                return "กำหนดเอง";
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

        function warning_existing_in_hr_person_position() {
            dialog_error({
                    'header': 'ไม่พบข้อมูลของบุคลากรนี้',
                    'body': 'ไม่พบข้อมูลตำแหน่งงานใดๆของบุคลากรนี้ โปรดตรวจสอบข้อมูลตำแหน่งงานของบุคลากรนี้อีกครั้ง'
                });
        }

        // function splitDateForm1($date,$sp="-") {
        //     list($dd, $mm, $yy) = preg_split("[/|-]", $date);
        //     // $yy -= 543;
        //     return $yy.'-'.$mm.'-'.$dd;
        // }

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

                    if (item['T1.pos_ps_id'] != null && item['T1.pos_ps_id'] != undefined) {
                        // link = `window.location.href='<?php echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/?select_budget_year=${select_budget_year}&user_id=${item['T1.pos_ps_id']}'`
                        link = `<?php echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/${item['T1.pos_ps_id']}/${select_budget_year}`;
                        button = `
                            <div class="text-center option">
                                <a class="btn btn-warning" target="_blank" href=${link}><i class="bi-pencil-square"></i></a>
                            </div>
                        `;
                    } else {    
                        button = `
                            <div class="text-center option">
                                <a class="btn btn-warning" onclick=" dialog_error({
                                                                            'header': 'ไม่พบข้อมูลของบุคลากรนี้',
                                                                            'body': 'ไม่พบข้อมูลตำแหน่งงานใดๆของบุคลากรนี้ โปรดตรวจสอบข้อมูลตำแหน่งงานของบุคลากรนี้อีกครั้ง'
                                                                        });">
                                    <i class="bi-pencil-square"></i>
                                </a>
                            </div>
                        `;
                    }
                    

                    let displayEndDateCalResult = displayEndDateCal(item.lsum_date_cal_type, item.lsum_end_date_cal, Number(select_budget_year));

                    // Add new row to DataTable
                    dataTable.row.add([
                            ++index,
                            (`${item.pf_name}${item.ps_fname} ${item.ps_lname}`) ,
                            item.hire_name,
                            // (item.hire_type == 1) ? "เต็มเวลา" : ((item.hire_type == 2) ? "บางเวลา" : "ไม่มีข้อมูล"),
                            '<div class="text-center">' + calWorkAge(item.final_found, item.work_experience_days) + '</div>',
                            '<div class="text-center">' + checkDateCalType(item.lsum_date_cal_type) + '</div>',
                            // checkDataShowDash(item.pos_work_start_date),
                            '<div class="text-center">' + checkDataShowDash((item.pos_work_start_date != null && item.pos_work_start_date != undefined && item.pos_work_start_date?.length > 0) ? (abbreDate2(item.pos_work_start_date)) : item.pos_work_start_date),
                            (displayEndDateCalResult != null && displayEndDateCalResult != undefined && displayEndDateCalResult?.length > 0 && displayEndDateCalResult != '-') ? abbreDate2(displayEndDateCalResult) : displayEndDateCalResult + '</div>',
                            // item.lsum_year,
                            checkData(item.final_found),
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