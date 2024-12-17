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
    // echo "target_user_leave_summary:<br> "; 
    // print_r($target_user_leave_summary);
    // echo "<br><hr>";
    // echo "base_info:<br> "; 
    // print_r($base_info);

    $target_user_leave_summary = $target_user_leave_summary[0];
?>

<!-- profile card -->
<style>
        .nav-pills .nav-link {
        /* box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1); */
        border: 1px dashed #607D8B;
        color: #012970;
        margin: 8px;
    }


    .card-dashed {
        box-shadow: none;
        border: 1px dashed #607D8B;
        color: #012970;
    }

    .card-solid {
        box-shadow: none;
    }

    #profile_picture {
        margin-top: -115px;
        border-radius: 5px;
        max-width: 100%;
        /* ปรับให้ขนาดของภาพไม่เกินขนาด container */
        max-height: 200px;
        /* จำกัดความสูงสูงสุด */
        object-fit: cover;
        /* ปรับให้ภาพพอดีกรอบและคงอัตราส่วน */
        height: auto;
        /* ให้ความสูงปรับตามความกว้างโดยอัตโนมัติ */
        box-shadow: 0px 2px 20px rgba(1, 41, 112, 0.1);
    }
</style>

<style>
                                    .box {
                                        position: relative;
                                    }
                                    
                                    .live-absolute {
                                        color: white;
                                        /* background-color: red; */
                                        font-size: 20px;
                                        padding: 0px 0px;
                                        
                                        
                                        position: absolute;
                                        top: 0px;
                                        width: 100%;
                                        text-align: center;
                                        visibility: visible;
                                        
                                    }

                                    .live-original {
                                        color: white;
                                        /* background-color: red; */
                                        font-size: 20px;
                                        padding: 0px 0px;
                                        visibility: hidden;

                                        height: 0;
                                        width: 0;
                                    }

                                    .box {
                                        /* background-color: yellow; */
                                    }

                                    #infinity-sign {
                                        width: 100%;
                                    }

                                    .dp-none {
                                        display: none;
                                    }

                                    .dp-block {
                                        display: block;
                                    }
</style>
<div class="col-md-12">
    <div class="row">
        <?php 
        // echo $data['person_department_detail'];
        ?>
        
        <div class="col-md-3">
            <div class="section profile">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-body profile-card">
                        <div class="d-flex flex-column align-items-center">
                            <img id="profile_picture" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . ($row_profile->psd_picture != '' ? $row_profile->psd_picture : "default.png")); ?>">
                            <h2 class="mb-3 mt-4"><?php echo $row_profile->pf_name_abbr . $row_profile->ps_fname . " " . $row_profile->ps_lname; ?></h2>
                        </div>
                        <div class="card card-dashed">
                            <?php if (count($person_department_topic) == 1) {
                                $head = $person_department_topic[0];
                                $row = $person_department_detail[0];
                            ?>
                                <div class="text-center mt-4">
                                    <h3 class="mb-3"><?php echo $head->dp_name_th; ?></h3>
                                </div>
                                <div class="card-body pb-2">
                                    <!-- Personnel Details Section -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="card-icon me-3">
                                            <i class="bi-credit-card-2-front font-30"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-muted small mb-1">รหัสประจำตัวบุคลากร</h5>
                                            <div><?php echo (isset($row->pos_ps_code) ? $row->pos_ps_code : "-"); ?></div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="card-icon me-3">
                                            <i class="bi-person-square font-30"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-muted small mb-1">ประเภทบุคลากร</h5>
                                            <div><?php echo (isset($row->hire_name) ? $row->hire_name : "-"); ?></div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="card-icon me-3">
                                            <i class="bi-hospital font-30"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="text-muted small mb-1">ตำแหน่งในการบริหาร</h5>
                                            <div>
                                                <?php
                                                $position[] = '';
                                                foreach ($base_structure_position as $stpo_key => $value) {
                                                    $position[] = $value->stpo_name;
                                                    $position2[] = $value->stpo_used;
                                                }
                                                if (!empty($person_department_detail[0]->stde_admin_position)) {
                                                    foreach ($person_department_detail[0]->stde_admin_position as $key2 => $stde_admin) {
                                                        if ($stde_admin['stdp_po_id'] == 0) {
                                                            echo '<ul class="mb-0"><li>' . implode('</li><li>', $stde_admin['stde_name_th']) . '</li></ul>';
                                                        } else {
                                                            if (count($stde_admin['stde_name_th']) == 1) {
                                                                echo '<ul class="mb-0"><li>' . $position2[$stde_admin['stdp_po_id'] - 1] . $stde_admin['stde_name_th'][0] . '</li></ul>';
                                                            } else {
                                                                echo '<ul class="mb-0"><li>' . $position[$stde_admin['stdp_po_id']] . '<br>';
                                                                $names_list = implode('<br> - ', $stde_admin['stde_name_th']);
                                                                echo '- ' . $names_list . '</li></ul>';
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="card-icon me-3">
                                            <i class="bi-clipboard2-pulse font-30"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-muted small mb-1">ตำแหน่งปฏิบัติงาน</h5>
                                            <div><?php echo (isset($row->alp_name) ? $row->alp_name : "-"); ?></div>
                                        </div>
                                    </div>
                                    <?php if ($row->hire_is_medical == "M") { ?>
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="card-icon me-3">
                                                <i class="bi-journal-medical font-30"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="text-muted small mb-1">ตำแหน่งงานเฉพาะทาง</h5>
                                                <div>
                                                    <?php
                                                    if (isset($row->spcl_position) && !empty($row->spcl_position)) {
                                                        $spcl_names = [];
                                                        $spcl_positions = json_decode($row->spcl_position);
                                                        if (json_last_error() == JSON_ERROR_NONE && is_array($spcl_positions)) {
                                                            foreach ($spcl_positions as $special) {
                                                                if (!empty($special->spcl_name)) {
                                                                    $spcl_names[] = $special->spcl_name;
                                                                }
                                                            }
                                                        }
                                                        if (!empty($spcl_names)) {
                                                            echo implode(', ', $spcl_names);
                                                        } else {
                                                            echo "-";
                                                        }
                                                    } else {
                                                        echo "-";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <!-- Multiple Departments -->
                                <ul class="nav nav-pills mb-3" id="department-tab" role="tablist">
                                    <?php foreach ($person_department_topic as $key => $row) { ?>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link <?php echo ($key == 0 ? "active" : ""); ?>" id="department-<?php echo $row->dp_id; ?>-tab" data-bs-toggle="tab" data-bs-target="#department-<?php echo $row->dp_id; ?>" type="button" role="tab" aria-controls="department-<?php echo $row->dp_id; ?>" aria-selected="<?php echo ($key == 0 ? "true" : "false"); ?>">
                                                <?php echo $row->dp_name_th; ?>
                                            </button>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <div class="tab-content" id="department-tab-content">
                                    <?php foreach ($person_department_detail as $key => $row) { ?>
                                        <div class="tab-pane fade <?php echo ($key == 0 ? "show active" : ""); ?>" id="department-<?php echo $row->pos_dp_id; ?>" role="tabpanel" aria-labelledby="department-<?php echo $row->pos_dp_id; ?>-tab">
                                            <div class="card-body pb-2">
                                                <!-- Department Detail Content -->
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-credit-card-2-front font-30"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">รหัสประจำตัวบุคลากร</h5>
                                                        <div><?php echo (isset($row->pos_ps_code) ? $row->pos_ps_code : "-"); ?></div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-person-square font-30"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">ประเภทบุคลากร</h5>
                                                        <div><?php echo (isset($row->hire_name) ? $row->hire_name : "-"); ?></div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-hospital font-30"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted small mb-1">ตำแหน่งในการบริหาร</h5>
                                                        <div>
                                                            <?php
                                                            $position[] = '';
                                                            foreach ($base_structure_position as $stpo_key => $value) {
                                                                $position[] = $value->stpo_name;
                                                                $position2[] = $value->stpo_used;
                                                            }
                                                            if (!empty($person_department_detail[$key]->stde_admin_position)) {
                                                                foreach ($person_department_detail[$key]->stde_admin_position as $key2 => $stde_admin) {
                                                                    if ($stde_admin['stdp_po_id'] == 0) {
                                                                        echo '<ul class="mb-0"><li>' . implode('</li><li>', $stde_admin['stde_name_th']) . '</li></ul>';
                                                                    } else {
                                                                        if (count($stde_admin['stde_name_th']) == 1) {
                                                                            echo '<ul class="mb-0"><li>' . $position2[$stde_admin['stdp_po_id'] - 1] . $stde_admin['stde_name_th'][0] . '</li></ul>';
                                                                        } else {
                                                                            echo '<ul class="mb-0"><li>' . $position[$stde_admin['stdp_po_id']] . '<br>';
                                                                            $names_list = implode('<br> - ', $stde_admin['stde_name_th']);
                                                                            echo '- ' . $names_list . '</li></ul>';
                                                                        }
                                                                    }
                                                                }
                                                            } else {
                                                                echo '-';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-clipboard2-pulse font-30"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">ตำแหน่งปฏิบัติงาน</h5>
                                                        <div><?php echo (isset($row->alp_name) ? $row->alp_name : "-"); ?></div>
                                                    </div>
                                                </div>
                                                <?php if ($row->hire_is_medical == "M") { ?>
                                                    <div class="d-flex align-items-start mb-3">
                                                        <div class="card-icon me-3">
                                                            <i class="bi-journal-medical font-30"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="text-muted small mb-1">ตำแหน่งงานเฉพาะทาง</h5>
                                                            <div>
                                                                <?php
                                                                if (isset($row->spcl_position)) {
                                                                    $spcl_names = array_map(function ($special) {
                                                                        return $special->spcl_name;
                                                                    }, json_decode($row->spcl_position));
                                                                    echo implode(', ', $spcl_names);
                                                                } else {
                                                                    echo "-";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // */ 
        ?>
        <div class="col-md-9">
            <div class="text-end">
                    <!-- <p id="final_data_display_new"></p> -->
                    <span class="badge bg-success" id="final_data_display_new" style="font-size: 16px;"></span><br>
                    <span class="badge bg-primary mt-3 mb-3" id="work_age_display" style="font-size: 16px;"></span>
            </div>
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
                                    <div class="col-3" id="div_show_budget_year">
                                        <!-- <label for="SearchLastName" class="form-label">ปีงบประมาณ</label> -->
                                        <label for="SearchLastName" class="form-label">ปีปฏิทิน</label>
                                        <div class="row">
                                            <p><?php echo $budget_year + 543; ?></p>
                                            <!-- <input type="hidden" value="<?php echo $budget_year + 543; ?>"> -->
                                        </div>
                                    </div>
                                    <div class="col-3" id="div_select_dp_id">
                                        <label for="SearchLastName" class="form-label">เลือกหน่วยงาน</label>
                                        <select class="select2" name="select_dp_id" id="select_dp_id">
                                            <option value="-1" disabled>-- เลือกหน่วยงาน --</option>
                                            <?php 
                                            // $i = 1;
                                            foreach ($base_info["pos_work_start_date_with_dp_id"] as $item) { 
                                                ?>
                                                <option value="<?php echo $item["pos_dp_id"]; ?>"><?php echo $item["dp_name_th"] ?></option>
                                            <?php 
                                            // $i++; 
                                            } 
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-3" id="div_select_date_cal_type">
                                        <label for="SearchLastName" class="form-label">เลือกประเภทการคำนวณอายุงาน</label>
                                        <select class="select2" name="select_date_cal_type" id="select_date_cal_type">
                                            <option value="-1" disabled>-- เลือกประเภทการคำนวณอายุงาน --</option>
                                            <option value="carlendar_year">ปีปฏิทิน</option>
                                            <option value="custom_year">กำหนดเอง</option>
                                            <?php /*
                                            <?php $i = 1;
                                            foreach ($filter_options["lsum_year"] as $y) { ?>
                                                <option <?php  ?>value="<?php echo $y; ?>"><?php echo $y+543 ?></option>
                                            <?php $i++; } ?>
                                            */ ?>
                                        </select>
                                    </div>
                                    <div class="col-3" id="div_select_end_date_cal">
                                        <label for="SearchLastName" class="form-label">เลือกวันที่สิ้นสุดการคำนวณอายุงาน</label>
                                        <!-- <input name="select_end_date_cal" id="select_end_date_cal" class="flatpickr flatpickr-input active" type="text" placeholder="Select Date.." readonly="readonly"> -->
                                        <!-- <input type="input" class="form-control" name="select_end_date_cal" id="select_end_date_cal" placeholder="" /> -->
                                        <!-- <input type="input" class="flatpickr flatpickr-input active form-control" name="select_end_date_cal" id="select_end_date_cal" value="" placeholder="เลือกวันที่" /> -->
                                        <input type="text" class="form-control" name="select_end_date_cal" id="select_end_date_cal" value="" placeholder="เลือก">
                                        <!-- <input type="input" class="flatpickr flatpickr-input active form-control" name="select_end_date_cal" id="select_end_date_cal" value="" data-locale="th" placeholder="เลือกวันที่" /> -->
                                        <!-- <select class="select2" name="select_date_cal_type" id="select_date_cal_type">
                                            <option value="-1" disabled>-- เลือกประเภทการคำนวณอายุงาน --</option>
                                            <option value="carlendar_year">ปีปฏิทิน</option>
                                            <option selected value="custom_year">กำหนดวันที่คำนวณอายุงาน</option>
                                            <?php /*
                                            <?php $i = 1;
                                            foreach ($filter_options["lsum_year"] as $y) { ?>
                                                <option <?php  ?>value="<?php echo $y; ?>"><?php echo $y+543 ?></option>
                                            <?php $i++; } ?>
                                            */ ?>
                                        </select> -->
                                    </div>
                                    <div class="col-6 mt-5" id="div_start_date_display">
                                        <!-- <label for="SearchLastName" class="form-label">ปีงบประมาณ</label> -->
                                        <label for="SearchLastName" class="form-label">ช่วงวันที่คำนวณอายุงาน</label>
                                       
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="start_date_display" readonly="readonly">
                                            <span class="input-group-text">ถึง</span>
                                            <input type="text" class="form-control" id="end_date_display" readonly="readonly">
                                        </div>
                                    </div>
                                   
                                    <div class="col-6 mt-5" id="div_work_age_cal_result_display">
                                        <!-- <label for="SearchLastName" class="form-label">ปีงบประมาณ</label> -->
                                        <label for="SearchLastName" class="form-label">จำลองผลลัพธ์การคำนวณอายุงาน</label>
                                        <div class="row">
                                            <!-- <input id="work_age_cal_result_display" type="text" readonly="readonly" class="form-control"> -->
                                            <p id="work_age_cal_result_display"></p>
                                        </div>
                                    </div>
                                    <!-- <input type="text" class="form-control" name="psd_birthdate" id="psd_birthdate" value="" placeholder="วันเกิด"> -->
                                    
                                    <!-- <div class="card mb-3 mt-4 mx-2 pt-2" style="width:49%">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label">วันที่เริ่มต้นการคำนวณอายุงาน</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label id="start_date_display" class="form-label"></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label">วันที่สิ้นสุดการคำนวณอายุงาน</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label id="end_date_display" class="form-label">-</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label">จำลองผลลัพธ์การคำนวณอายุงาน</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label id="work_age_cal_result_display" class="form-label">-</label>
                                                </div>
                                            </div> 
                                        </div>
                                    </div> -->
                                    <div class="col-md-6 text-start mt-5">
                                        <a href="<?php echo base_url().'index.php/hr/leaves/leaves_user'; ?>" class="btn btn-secondary" name="exit" id="exit">ย้อนกลับ</a>
                                    </div>
                                    <div class="col-md-6 text-end mt-5">
                                        <button class="btn btn-primary" name="save-lsum" id="save-lsum">บันทึก</button>
                                    </div>
                                    <!-- <div class="col-4" id="div_select_date_cal_type">
                                        <label for="SearchLastName" class="form-label">วันที่เริ่มต้นการคำนวณอายุงาน</label>
                                        <br>
                                        <label for="SearchLastName" class="form-label">วันที่สิ้นสุดการคำนวณอายุงาน</label>
                                    </div> -->
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--
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
                                            <div class="col-md-4">
                                                <label id="ps_name_display" for="" class="form-label"><?php echo $target_user_leave_summary['pf_name'].$target_user_leave_summary['ps_fname']." ".$target_user_leave_summary['ps_lname']; ?></label>
                                                
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-end">
                                                <label for="" class="form-label">ประเภทบุคลากร</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label id="hire_abbr_display" for="" class="form-label"><?php echo $target_user_leave_summary['hire_abbr']; ?></label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-end">
                                                <label for="" class="form-label">ประเภทสายงาน</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label id="detail_display" for="" class="form-label"><?php echo $target_user_leave_summary['detail']; ?></label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-end">
                                                <label for="" class="form-label">อายุงาน</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label id="work_age_display" for="" class="form-label"></label>
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
            -->
            
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                        <i class="bi-search icon-menu"></i><span> ข้อมูลวันลา</span><span class="badge bg-success" id="leave_summary_table_row_amount">0</span>
                    </button>
                </h2>
                <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                    <div class="accordion-body">
                        <table id="leave_summary_table" class="table datatable text-center" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" scope="col" width="2%" rowspan="2">#</th>
                                    <th class="text-center align-middle" scope="col" width="6%" rowspan="2">ประเภทการลา</th>
                                    <th class="text-center" scope="col" width="26.6%" colspan="3">จำนวนที่ลาได้</th>
                                    <th class="text-center" scope="col" width="26.6%" colspan="3">จำนวนลาที่ใช้ไป</th>
                                    <th class="text-center" scope="col" width="26.6%" colspan="3">จำนวนวันลาคงเหลือ</th>
                                    <th class="text-center align-middle" width="6%" scope="col" rowspan="2">จำนวนวันลาสะสมที่ยกมาจากปีที่แล้ว</th>
                                    <th class="text-center align-middle" width="6%" scope="col" rowspan="2">ตั้งค่าลาแบบไม่จำกัด</th>
                                </tr>
                                <tr>
                                    <!-- <th class="text-center" scope="col" width="2%">#</th> -->
                                    <!-- <th class="text-center" scope="col">ประเภทการลา</th> -->
                                    <th class="text-center" width="6.6%" scope="col">วัน</th>
                                    <th class="text-center" width="6.6%" scope="col">ชั่วโมง</th>
                                    <th class="text-center" width="6.6%" scope="col">นาที</th>
                                    <th class="text-center" width="6.6%" scope="col">วัน</th>
                                    <th class="text-center" width="6.6%" scope="col">ชั่วโมง</th>
                                    <th class="text-center" width="6.6%" scope="col">นาที</th>
                                    <th class="text-center" width="6.6%" scope="col">วัน</th>
                                    <th class="text-center" width="6.6%" scope="col">ชั่วโมง</th>
                                    <th class="text-center" width="6.6%" scope="col">นาที</th>
                                    <!-- <th class="text-center" scope="col">จำนวนวันลาสะสมที่ยกมาจากปีที่แล้ว</th> -->
                                    <!-- <th class="text-center" scope="col">ตั้งค่าลาแบบไม่จำกัด</th> -->
                                    <!-- <th class="text-center" scope="col" width="2%">จำนวนครั้งที่ลาไปแล้ว</th>
                                    <th class="text-center" scope="col" width="15%">จำนวนครั้งคงเหลือ</th>
                                    <th class="text-center" scope="col">จำนวนวันที่ลาไปแล้วนอกระบบ</th>
                                    <th class="text-center" scope="col">จำนวนวันคงเหลือ</th>
                                    <th class="text-center" scope="col">จำนวนยอดสะสม</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                /*
                                for ($i = 0; $i < 5; $i++) { ?>
                                    <?php if ($i < 4) { ?>
                                        <tr>
                                            <td hidden>
                                                <div class="text-center"><?php echo $i + 1; ?></div>
                                            </td>
                                            <td>
                                                <div class="text-start">ลาป่วย</div>
                                            </td>
                                            <!-- <td>
                                                <div class="text-start">เหตุปฏิบัติราชการ</div>
                                            </td> -->
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
                                <?php } 
                                */
                                ?>
                            </tbody>
                        </table>
                        <div class="mt-5">
                            <p class="text-danger mb-1">
                                <strong>* หมายเหตุ :</strong>
                                <i class="bi bi-exclamation-circle"></i> 60 นาที มีค่าเท่ากับ 1 ชั่วโมง
                            </p>
                            <p class="text-danger mb-0 ms-4">
                                <i class="bi bi-exclamation-circle"></i> 8 ชั่วโมง มีค่าเท่ากับ 1 วัน
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- auto change ui when checkbox is checked -->
<script>
    // initial
    function checkIsSettedUnlimited(targetInputElementIdArray, targetCheckboxElementId, lsum_count_limit) {
        let checkboxElement = document.getElementById(targetCheckboxElementId);
        
        // console.log(inputElement.value);
        // console.log(checkboxElement.checked);
        
        targetInputElementIdArray.forEach((targetInputElementId, index) => {
            // console.log('checkIsSettedUnlimited(), targetInputElementId: ', targetInputElementId);

            let inputElement = document.getElementById(targetInputElementId);
            // console.log(inputElement);

            // input_lsum_remain_day
            let textInputLsumRemainDay = null;
            let divInputLsumRemainDay = null;
            let currentColumnIsRemainDay = false;
            if (targetInputElementId.length >= 21) {
                if (targetInputElementId.substring(0, targetInputElementId.lastIndexOf("_")) == "input_lsum_remain_day") {
                    currentColumnIsRemainDay = true;
                    textInputLsumRemainDay = document.getElementById(`text_${targetInputElementId}`);
                    divInputLsumRemainDay = document.getElementById(`div_${targetInputElementId}`);
                }
            }

            // input_lsum_remain_hour
            let textInputLsumRemainHour = null;
            let divInputLsumRemainHour = null;
            let currentColumnIsRemainHour = false;
            if (targetInputElementId.length >= 21) {
                if (targetInputElementId.substring(0, targetInputElementId.lastIndexOf("_")) == "input_lsum_remain_hour") {
                    currentColumnIsRemainHour = true;
                    textInputLsumRemainHour = document.getElementById(`text_${targetInputElementId}`);
                    divInputLsumRemainHour = document.getElementById(`div_${targetInputElementId}`);
                }
            }

            // input_lsum_remain_minute
            let textInputLsumRemainMinute = null;
            let divInputLsumRemainMinute = null;
            let currentColumnIsRemainMinute = false;
            if (targetInputElementId.length >= 21) {
                if (targetInputElementId.substring(0, targetInputElementId.lastIndexOf("_")) == "input_lsum_remain_minute") {
                    currentColumnIsRemainMinute = true;
                    textInputLsumRemainMinute = document.getElementById(`text_${targetInputElementId}`);
                    divInputLsumRemainMinute = document.getElementById(`div_${targetInputElementId}`);
                }
            }
            // let isUnlimited = (currentColumnIsRemainDay == true && lsum_count_limit == "Y") ? true : (Number(inputElement.value) == -99);
            // let isUnlimited = false;

            // if (currentColumnIsRemainDay == true) {
            //     if (lsum_count_limit == "Y") {
            //         isUnlimited = true;
            //     } else {
            //         isUnlimited = false;
            //     }
            // } else {
            //     isUnlimited = (Number(inputElement.value) == -99);
            // }

            if (lsum_count_limit == "Y") {
            // if (Number(inputElement.value) == -99) {
            // if (isUnlimited) {
            // if (Number(inputElement.value) == `&#8734;`) {
                checkboxElement.checked = true;
                changeInputUISingle(targetInputElementId, `box_${targetInputElementId}`, `live_${targetInputElementId}`, true);
            } else {
                checkboxElement.checked = false;
            }
        });
        
    }

    function changeInputUISingle(targetInputElementId, boxId, liveId, checked) {
        // console.log(`changeInputUISingle(), textInputLsumRemainDay: text_${targetInputElementId}`);
        let element = document.getElementById(targetInputElementId);
        // console.log(targetInputElementId);
        // console.log(checked);
        // console.log(element.style.color);

        // const box = document.getElementById(boxId);
        const live = document.getElementById(liveId);
        
        // input_lsum_remain_day
        let textInputLsumRemainDay = null;
        let divInputLsumRemainDay = null;
        let currentColumnIsRemainDay = false;
        if (targetInputElementId.length >= 21) {
            if (targetInputElementId.substring(0, targetInputElementId.lastIndexOf("_")) == "input_lsum_remain_day") {
                currentColumnIsRemainDay = true;
                textInputLsumRemainDay = document.getElementById(`text_${targetInputElementId}`);
                divInputLsumRemainDay = document.getElementById(`div_${targetInputElementId}`);
            }
        }
        
        // input_lsum_remain_hour
        let textInputLsumRemainHour = null;
        let divInputLsumRemainHour = null;
        let currentColumnIsRemainHour = false;
        if (targetInputElementId.length >= 21) {
            if (targetInputElementId.substring(0, targetInputElementId.lastIndexOf("_")) == "input_lsum_remain_hour") {
                currentColumnIsRemainHour = true;
                textInputLsumRemainHour = document.getElementById(`text_${targetInputElementId}`);
                divInputLsumRemainHour = document.getElementById(`div_${targetInputElementId}`);
            }
        }
        
        // input_lsum_remain_minute
        let textInputLsumRemainMinute = null;
        let divInputLsumRemainMinute = null;
        let currentColumnIsRemainMinute = false;
        if (targetInputElementId.length >= 21) {
            if (targetInputElementId.substring(0, targetInputElementId.lastIndexOf("_")) == "input_lsum_remain_minute") {
                currentColumnIsRemainMinute = true;
                textInputLsumRemainMinute = document.getElementById(`text_${targetInputElementId}`);
                divInputLsumRemainMinute = document.getElementById(`div_${targetInputElementId}`);
            }
        }

        // lsum_remain_day
        // const text_lsum_remain_day = document.getElementById(`text_lsum_remain_day_${targetIndexNumber}`);
        // const div_lsum_remain_day = document.getElementById(`div_lsum_remain_day_${targetIndexNumber}`);
        // const live_lsum_remain_day = document.getElementById(`live_lsum_remain_day_${targetIndexNumber}`);

        if (checked) {
            element.style.color = "transparent";
            element.value = -99;
            // element.value = '&#8734;';
            element.disabled = true;
            // console.log(element.value);
            live.classList.remove('live-original');
            live.classList.remove('live-absolute');
            live.classList.add('live-absolute');

            if (currentColumnIsRemainDay == true) {
                textInputLsumRemainDay.classList.remove('dp-block');
                textInputLsumRemainDay.classList.remove('dp-block');
                textInputLsumRemainDay.classList.add('dp-none');

                divInputLsumRemainDay.classList.remove('dp-none');
                divInputLsumRemainDay.classList.remove('dp-none');
                divInputLsumRemainDay.classList.add('dp-block');
            }
            
            if (currentColumnIsRemainHour == true) {
                //
                textInputLsumRemainHour.classList.remove('dp-block');
                textInputLsumRemainHour.classList.remove('dp-block');
                textInputLsumRemainHour.classList.add('dp-none');

                divInputLsumRemainHour.classList.remove('dp-none');
                divInputLsumRemainHour.classList.remove('dp-none');
                divInputLsumRemainHour.classList.add('dp-block');
            }

            if (currentColumnIsRemainMinute == true) {
                //
                textInputLsumRemainMinute.classList.remove('dp-block');
                textInputLsumRemainMinute.classList.remove('dp-block');
                textInputLsumRemainMinute.classList.add('dp-none');

                divInputLsumRemainMinute.classList.remove('dp-none');
                divInputLsumRemainMinute.classList.remove('dp-none');
                divInputLsumRemainMinute.classList.add('dp-block');
            }
        } else {
            

            element.style.color = "#212529";
            element.value = 0;
            element.disabled = false;
            // console.log(element.value);
            live.classList.remove('live-absolute');
            live.classList.remove('live-original');
            live.classList.add('live-original');

            if (currentColumnIsRemainDay == true) {
                textInputLsumRemainDay.classList.remove('dp-none');
                textInputLsumRemainDay.classList.remove('dp-none');
                textInputLsumRemainDay.classList.add('dp-block');

                divInputLsumRemainDay.classList.remove('dp-block');
                divInputLsumRemainDay.classList.remove('dp-block');
                divInputLsumRemainDay.classList.add('dp-none');
            }
            if (currentColumnIsRemainHour == true) {
                //
                textInputLsumRemainHour.classList.remove('dp-none');
                textInputLsumRemainHour.classList.remove('dp-none');
                textInputLsumRemainHour.classList.add('dp-block');

                divInputLsumRemainHour.classList.remove('dp-block');
                divInputLsumRemainHour.classList.remove('dp-block');
                divInputLsumRemainHour.classList.add('dp-none');
            }
            if (currentColumnIsRemainMinute == true) {
                //
                textInputLsumRemainMinute.classList.remove('dp-none');
                textInputLsumRemainMinute.classList.remove('dp-none');
                textInputLsumRemainMinute.classList.add('dp-block');

                divInputLsumRemainMinute.classList.remove('dp-block');
                divInputLsumRemainMinute.classList.remove('dp-block');
                divInputLsumRemainMinute.classList.add('dp-none');
            }
        }
    }

    function changeInputUI(targetInputElementIdArray, checked) {
    // function changeInputUI(targetInputElementId, checked) {
        // ['1','2','3'].forEach((targetInputElementId) => {
            // console.log(targetInputElementId);

        /* test element value when checkbox is clicked */
        targetInputElementIdArray.forEach((targetInputElementId) => {
            //console.log(`changeInputUI(), ${targetInputElementId} value: ${document.getElementById(targetInputElementId).value}`);
        });
        /** */

        targetInputElementIdArray.forEach((targetInputElementId) => {
            
            let element = document.getElementById(targetInputElementId);
            // console.log(targetInputElementId);
            // console.log(checked);
            // console.log(element.style.color);
            

            // const box = document.getElementById(`box_${targetInputElementId}`);
            const live = document.getElementById(`live_${targetInputElementId}`);

            // console.log('Hello!!!!, targetInputElementId.substring(0, targetInputElementId.lastIndexOf("_")):',targetInputElementId.substring(0, targetInputElementId.lastIndexOf("_")));

            // input_lsum_remain_day
            let textInputLsumRemainDay = null;
            let divInputLsumRemainDay = null;
            let currentColumnIsRemainDay = false;
            if (targetInputElementId.length >= 21) {
                if (targetInputElementId.substring(0, targetInputElementId.lastIndexOf("_")) == "input_lsum_remain_day") {
                    currentColumnIsRemainDay = true;
                    textInputLsumRemainDay = document.getElementById(`text_${targetInputElementId}`);
                    divInputLsumRemainDay = document.getElementById(`div_${targetInputElementId}`);
                } else {
                    currentColumnIsRemainDay = false;
                }
            }
            
            // input_lsum_remain_hour
            let textInputLsumRemainHour = null;
            let divInputLsumRemainHour = null;
            let currentColumnIsRemainHour = false;
            if (targetInputElementId.length >= 21) {
                if (targetInputElementId.substring(0, targetInputElementId.lastIndexOf("_")) == "input_lsum_remain_hour") {
                    currentColumnIsRemainHour = true;
                    textInputLsumRemainHour = document.getElementById(`text_${targetInputElementId}`);
                    divInputLsumRemainHour = document.getElementById(`div_${targetInputElementId}`);
                } else {
                    currentColumnIsRemainHour = false;
                }
            }
            
            // input_lsum_remain_minute
            let textInputLsumRemainMinute = null;
            let divInputLsumRemainMinute = null;
            let currentColumnIsRemainMinute = false;
            if (targetInputElementId.length >= 21) {
                if (targetInputElementId.substring(0, targetInputElementId.lastIndexOf("_")) == "input_lsum_remain_minute") {
                    currentColumnIsRemainMinute = true;
                    textInputLsumRemainMinute = document.getElementById(`text_${targetInputElementId}`);
                    divInputLsumRemainMinute = document.getElementById(`div_${targetInputElementId}`);
                } else {
                    currentColumnIsRemainMinute = false;
                }
            }


            if (checked) {
                // console.log('checked: ', checked);
                element.style.color = "transparent";
                element.value = -99;
                // element.value = '&#8734;';
                element.disabled = true;
                // console.log(element.value);
                live.classList.toggle('live-original');
                live.classList.toggle('live-absolute');

                // console.log('currentColumnIsRemainDay ', currentColumnIsRemainDay);
                // console.log('currentColumnIsRemainHour ', currentColumnIsRemainHour);
                // console.log('currentColumnIsRemainMinute ', currentColumnIsRemainMinute);

                if (currentColumnIsRemainDay == true) {
                    
                    textInputLsumRemainDay.classList.remove('dp-block');
                    textInputLsumRemainDay.classList.remove('dp-block');
                    textInputLsumRemainDay.classList.add('dp-none');

                    divInputLsumRemainDay.classList.remove('dp-none');
                    divInputLsumRemainDay.classList.remove('dp-none');
                    divInputLsumRemainDay.classList.add('dp-block');
                }
                if (currentColumnIsRemainHour == true) {
                    //
                    
                    textInputLsumRemainHour.classList.remove('dp-block');
                    textInputLsumRemainHour.classList.remove('dp-block');
                    textInputLsumRemainHour.classList.add('dp-none');

                    divInputLsumRemainHour.classList.remove('dp-none');
                    divInputLsumRemainHour.classList.remove('dp-none');
                    divInputLsumRemainHour.classList.add('dp-block');
                }
                if (currentColumnIsRemainMinute == true) {
                    //
                    textInputLsumRemainMinute.classList.remove('dp-block');
                    textInputLsumRemainMinute.classList.remove('dp-block');
                    textInputLsumRemainMinute.classList.add('dp-none');

                    divInputLsumRemainMinute.classList.remove('dp-none');
                    divInputLsumRemainMinute.classList.remove('dp-none');
                    divInputLsumRemainMinute.classList.add('dp-block');
                }
            } else {
                //updateDataTable
                // updateDataTable();

                // console.log('checked: ', checked);
                element.style.color = "#212529";

                /* restore input value after click de-unlimited checkbox*/
                // element.value = 0;

                let text = targetInputElementId;
                let startCharIndex = text.indexOf("_");
                let endCharIndex = text.lastIndexOf("_");
                let textSubstringResult = text.substring(startCharIndex + 1, endCharIndex);

                let indexNumberOfTargetInputElementId = text.substring(endCharIndex + 1, text.length);


                let value;
                
                if (dataForRenderDataTable != null && dataForRenderDataTable != undefined) {
                    if (dataForRenderDataTable.length > 0) {
                        value = dataForRenderDataTable[indexNumberOfTargetInputElementId - 1][textSubstringResult];
                    } else {
                        value = 0;
                    }
                } else {
                    value = 0;
                }
                
                element.value = (value != -99) ? value : 0;

                // console.log(`
                // text: ${text},
                // startCharIndex: ${startCharIndex},
                // endCharIndex: ${endCharIndex},
                // textSubstringResult: ${textSubstringResult}.
                // element.value: ${element.value}
                // `);

                /* */

                element.disabled = false;
                // console.log(element.value);
                live.classList.toggle('live-original');
                live.classList.toggle('live-absolute');

                // console.log('currentColumnIsRemainDay ', currentColumnIsRemainDay);
                // console.log('currentColumnIsRemainHour ', currentColumnIsRemainHour);
                // console.log('currentColumnIsRemainMinute ', currentColumnIsRemainMinute);

                if (currentColumnIsRemainDay == true) {
                    textInputLsumRemainDay.classList.remove('dp-none');
                    textInputLsumRemainDay.classList.remove('dp-none');
                    textInputLsumRemainDay.classList.add('dp-block');

                    divInputLsumRemainDay.classList.remove('dp-block');
                    divInputLsumRemainDay.classList.remove('dp-block');
                    divInputLsumRemainDay.classList.add('dp-none');
                }
                if (currentColumnIsRemainHour == true) {
                    //
                    textInputLsumRemainHour.classList.remove('dp-none');
                    textInputLsumRemainHour.classList.remove('dp-none');
                    textInputLsumRemainHour.classList.add('dp-block');

                    divInputLsumRemainHour.classList.remove('dp-block');
                    divInputLsumRemainHour.classList.remove('dp-block');
                    divInputLsumRemainHour.classList.add('dp-none');
                }
                if (currentColumnIsRemainMinute == true) {
                    
                    //
                    textInputLsumRemainMinute.classList.remove('dp-none');
                    textInputLsumRemainMinute.classList.remove('dp-none');
                    textInputLsumRemainMinute.classList.add('dp-block');

                    divInputLsumRemainMinute.classList.remove('dp-block');
                    divInputLsumRemainMinute.classList.remove('dp-block');
                    divInputLsumRemainMinute.classList.add('dp-none');
                }
            }
        });
    }

    
</script>

<!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> -->
<script>

    // v0
    // If using flatpickr in a framework, its recommended to pass the element directly
    // flatpickr($("#select_end_date_cal"), {});

    // v1
    // var leap=3;
    // var dayWeek=["พฤ.", "ศ.", "ส.", "อา.","จ.", "อ.", "พ."];
    // var yearL=new Date().getFullYear()-543;
    // leap=(((yearL % 4 == 0) && (yearL % 100 != 0)) || (yearL % 400 == 0))?2:3;
    // if(leap==2){
    //     dayWeek=["ศ.", "ส.", "อา.", "จ.","อ.", "พ.", "พฤ."];
    // }        
    // // $("#select_end_date_cal").datetimepicker({
    //     flatpickr("#select_end_date_cal", {
    //     timepicker:false,
    //     lang:'th',  // แสดงภาษาไทย
    //     onChangeMonth:function( ct ){
    //         var leap=3;
    //         var dayWeek=["พฤ.", "ศ.", "ส.", "อา.","จ.", "อ.", "พ."];
    //         if(ct){
    //             var yearL=new Date(ct).getFullYear()-543;
    //             leap=(((yearL % 4 == 0) && (yearL % 100 != 0)) || (yearL % 400 == 0))?2:3;
    //             if(leap==2){
    //                 dayWeek=["ศ.", "ส.", "อา.", "จ.","อ.", "พ.", "พฤ."];
    //             }
    //         }            
    //         this.setOptions({
    //             i18n:{ th:{dayOfWeek:dayWeek}},dayOfWeekStart:leap,
    //         })        
    //     },          
    //     i18n:{ th:{dayOfWeek:dayWeek}},dayOfWeekStart:leap,               
    //     yearOffset:543,  // ใช้ปี พ.ศ. บวก 543 เพิ่มเข้าไปในปี ค.ศ
    //     inline:true
    // });         

    
    // v3

    // function convertYearsToThai() {
    //     const calendar = document.querySelector('.flatpickr-calendar');
    //     if (!calendar) return;

    //     const years = calendar.querySelectorAll('.cur-year, .numInput');
    //     years.forEach(function(yearInput) {
    //         convertToThaiYear(yearInput);
    //     });

    //     const yearDropdowns = calendar.querySelectorAll('.flatpickr-monthDropdown-months');
    //     yearDropdowns.forEach(function(monthDropdown) {
    //         if (monthDropdown) {
    //             monthDropdown.querySelectorAll('option').forEach(function(option) {
    //                 convertToThaiYearDropdown(option);
    //             });
    //         }
    //     });

    //     const currentYearElement = calendar.querySelector('.flatpickr-current-year');
    //     if (currentYearElement) {
    //         const currentYear = parseInt(currentYearElement.textContent);
    //         if (currentYear < 2400) {
    //             currentYearElement.textContent = currentYear + 543;
                
    //         }
    //     }
    // }

    // function convertToThaiYear(yearInput) {
    //     const currentYear = parseInt(yearInput.value);
    //     if (currentYear < 2400) { // Convert to B.E. only if not already converted
    //         yearInput.value = currentYear + 543;
    //     }

    // }

    // function convertToThaiYearDropdown(option) {
    //     const year = parseInt(option.textContent);
    //     if (year < 2400) { // Convert to B.E. only if not already converted
    //         option.textContent = year + 543;
    //     }
    // }

    // function formatDateToThai(date) {
    //     let d = new Date(date);
    //     let year = d.getFullYear();
    //     let month = ('0' + (d.getMonth() + 1)).slice(-2);
    //     let day = ('0' + d.getDate()).slice(-2);

    //     if (year < 2400) { // Convert to B.E. only if not already converted
    //         year = year + 543;
    //     }

    //     return `${day}/${month}/${year}`;
    // } 

    // function addMonthNavigationListeners() {
    //     const calendar = document.querySelector('.flatpickr-calendar');
    //     if (calendar) {
    //         const prevButton = calendar.querySelector('.flatpickr-prev-month');
    //         const nextButton = calendar.querySelector('.flatpickr-next-month');
    //         if (prevButton && nextButton) {
    //             prevButton.addEventListener('click', function() {
    //                 setTimeout(convertYearsToThai, 0);
    //             });
    //             nextButton.addEventListener('click', function() {
    //                 setTimeout(convertYearsToThai, 0);
    //             });
    //         }
    //     }
    // }

    flatpickr("#select_end_date_cal", {
        dateFormat: 'd/m/Y',
        // lang: 'th',
        locale: 'th',
        // defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
        // defaultDate: "<?php // echo isset($row_profile) ? date('d/m/Y', strtotime($row_profile->psd_birthdate . ' +543 years')) : date('d/m/Y'); ?>",
        onReady: function(selectedDates, dateStr, instance) {
            // addMonthNavigationListeners();
            // convertYearsToThai();
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
            if (!selectedDates || selectedDates.length === 0) { // ถ้ายังไม่ได้เลือกวันที่
                document.getElementById('select_end_date_cal').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('select_end_date_cal').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });


    // flatpickr("#psd_birthdate", {
    //     dateFormat: 'd/m/Y',
    //     locale: 'th',
    //     // defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
    //     // defaultDate: "<?php// echo isset($row_profile) ? date('d/m/Y', strtotime($row_profile->psd_birthdate . ' +543 years')) : date('d/m/Y'); ?>",
    //     onReady: function(selectedDates, dateStr, instance) {
    //         // addMonthNavigationListeners();
    //         // convertYearsToThai();
    //     },
    //     onOpen: function(selectedDates, dateStr, instance) {
    //         convertYearsToThai();
    //     },
    //     onValueUpdate: function(selectedDates, dateStr, instance) {
    //         convertYearsToThai();
    //         if (!selectedDates || selectedDates.length === 0) { // ถ้ายังไม่ได้เลือกวันที่
    //             document.getElementById('psd_birthdate').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
    //         } else {
    //             document.getElementById('psd_birthdate').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
    //         }
    //     },
    //     onMonthChange: function(selectedDates, dateStr, instance) {
    //         convertYearsToThai();
    //     },
    //     onYearChange: function(selectedDates, dateStr, instance) {
    //         convertYearsToThai();
    //     }
    // });

    // // $(".selector").flatpickr(optional_config);

    // flatpickr("#start_time", {
    //     enableTime: true,
    //     noCalendar: true,
    //     dateFormat: "H:i",
    //     time_24hr: true
    // });
</script>
<script>

    // function calWorkAgeLegacyBeta0(data, workAgeDays, alertMessage = "-") {
    //     if (data == "YES") {
    //         // return "แสดงข้อมูล";
            
    //         days = workAgeDays;

    //         years_remaining = parseInt(days / 365); //divide by 365 and throw away the remainder
    //         minused = (years_remaining * 365); 

    //         days -= minused;

    //         months_remaining = parseInt(days / 30); //divide by 365 and throw away the remainder
    //         minused = (months_remaining * 30); 

    //         days -= minused;

    //         days_remaining = days % 365;    //divide by 365 and *return* the remainder

    //         return `${years_remaining} ปี ${months_remaining} เดือน ${days_remaining} วัน`;
    //     } else {
    //         return alertMessage;
    //     }
    // }

    // function calWorkAgeLegacy(data, workAgeDays, alertMessage = "-") {
    //     if (data == "YES") {
    //         // return "แสดงข้อมูล";
            
    //         days = workAgeDays;

    //         years_remaining = parseInt(days / 365); //divide by 365 and throw away the remainder
    //         // console.log(`years_remaining = ${years_remaining} (years_remaining = parseInt(${days} / 365)) `)

    //         minused = (years_remaining * 365); 
    //         // console.log(`minused = ${minused} (minused = ${years_remaining} * 365)`)

    //         // console.log(`days = ${days - minused} (days = (${days} -= ${minused}))`);
    //         days -= minused;

    //         months_remaining = parseInt(days / 30); //divide by 365 and throw away the remainder
    //         // if ((days / 30) <= (11.0)) {
    //         //     months_remaining = parseInt(days / 30); //divide by 365 and throw away the remainder
    //         //     minused = (months_remaining * 30); 
                
    //         // } else {
    //         //     months_remaining = 11;
    //         //     minused = (months_remaining * 30); 
    //         //     minused += 5;
                
    //         //     // console.log(`my minused, ${minused}`)
    //         //     // mount_is_more_than_11 = true;
                
    //         //     // days_remaining += (days - minused);
                
    //         // }

    //         console.log(`months_remaining = ${months_remaining} (months_remaining = parseInt(${days} / 30)) `);


    //         minused = (months_remaining * 30); 

    //         //
    //         if (months_remaining >= 12) {
    //             years_remaining += 1;
    //             months_remaining = 0;

    //             // console.log('******');
    //             // console.log(`refreshed.... years_remaining = ${years_remaining}, months_remaining = ${months_remaining}`)
    //             // console.log('******');
    //         }

    //         days -= minused;

    //         days_remaining = days % 365;    //divide by 365 and *return* the remainder

    //         console.log(`*********`);
    //         console.log(`workAgeDays ${workAgeDays}`);
    //         console.log(`years_remaining: ${years_remaining}, months_remaining: ${months_remaining}, days_remaining: ${days_remaining}`);

    //         if (years_remaining < 1 && months_remaining < 1 && days_remaining < 1) {
    //             return `0 วัน`;
    //         } else {
    //             return `${(years_remaining > 0) ? ' '+years_remaining+' ปี' : '' }${(months_remaining > 0) ? ' '+months_remaining+' เดือน' : ''}${(days_remaining > 0) ? ' '+days_remaining+' วัน' : '' }`.substring(1);
    //         }
            
    //     } else {
    //         return alertMessage;
    //     }

    //     /*
    //         beta:
    //         months_remaining_pure = (days / 30);
    //         text = months_remaining_pure.toString();
    //         result = Number(text.substring(text.indexOf('.')+1));
            
    //         console.log(`result ${result}`);

    //     */
    // }

    function calWorkAge(data, workAgeDays, alertMessage = "-") {
        if (data == "YES") {
            // return "แสดงข้อมูล";
            
            days = workAgeDays;

            years_remaining = parseInt(days / 365); //divide by 365 and throw away the remainder
            // console.log(`years_remaining = ${years_remaining} (years_remaining = parseInt(${days} / 365)) `)

            minused = (years_remaining * 365); 
            // console.log(`minused = ${minused} (minused = ${years_remaining} * 365)`)

            // console.log(`days = ${days - minused} (days = (${days} -= ${minused}))`);
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

            // console.log(`months_remaining = ${months_remaining} (months_remaining = parseInt(${days} / 30)) `);


            minused = (months_remaining * 30); 

            //
            if (months_remaining >= 12) {
                years_remaining += 1;
                months_remaining = 0;

                // console.log('******');
                // console.log(`refreshed.... years_remaining = ${years_remaining}, months_remaining = ${months_remaining}`)
                // console.log('******');
            }

            days -= minused;

            days_remaining = days % 365;    //divide by 365 and *return* the remainder

            // console.log(`*********`);
            // console.log(`workAgeDays ${workAgeDays}`);
            // console.log(`years_remaining: ${years_remaining}, months_remaining: ${months_remaining}, days_remaining: ${days_remaining}`);

            if (years_remaining < 1 && months_remaining < 1 && days_remaining < 1) {
                return `0 วัน`;
            } else {
                return `${(years_remaining > 0) ? ' '+years_remaining+' ปี' : '' }${(months_remaining > 0) ? ' '+months_remaining+' เดือน' : ''}${(days_remaining > 0) ? ' '+days_remaining+' วัน' : '' }`.substring(1);
            }
            
        } else {
            return alertMessage;
        }

        /*
            beta:
            months_remaining_pure = (days / 30);
            text = months_remaining_pure.toString();
            result = Number(text.substring(text.indexOf('.')+1));
            
            console.log(`result ${result}`);

        */
    }

    function calWorkAge(data, workAgeDays, alertMessage = "-") {
        if (data == "YES") {
            // return "แสดงข้อมูล";
            
            days = workAgeDays;

            years_remaining = parseInt(days / 365); //divide by 365 and throw away the remainder
            // console.log(`years_remaining = ${years_remaining} (years_remaining = parseInt(${days} / 365)) `)

            minused = (years_remaining * 365); 
            // console.log(`minused = ${minused} (minused = ${years_remaining} * 365)`)

            // console.log(`days = ${days - minused} (days = (${days} -= ${minused}))`);
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

            // console.log(`months_remaining = ${months_remaining} (months_remaining = parseInt(${days} / 30)) `);


            minused = (months_remaining * 30); 

            //
            if (months_remaining >= 12) {
                years_remaining += 1;
                months_remaining = 0;

                // console.log('******');
                // console.log(`refreshed.... years_remaining = ${years_remaining}, months_remaining = ${months_remaining}`)
                // console.log('******');
            }

            days -= minused;

            days_remaining = days % 365;    //divide by 365 and *return* the remainder

            // console.log(`*********`);
            // console.log(`workAgeDays ${workAgeDays}`);
            // console.log(`years_remaining: ${years_remaining}, months_remaining: ${months_remaining}, days_remaining: ${days_remaining}`);

            if (years_remaining < 1 && months_remaining < 1 && days_remaining < 1) {
                return `0 วัน`;
            } else {
                return `${(years_remaining > 0) ? ' '+years_remaining+' ปี' : '' }${(months_remaining > 0) ? ' '+months_remaining+' เดือน' : ''}${(days_remaining > 0) ? ' '+days_remaining+' วัน' : '' }`.substring(1);
            }
            
        } else {
            return alertMessage;
        }

        /*
            beta:
            months_remaining_pure = (days / 30);
            text = months_remaining_pure.toString();
            result = Number(text.substring(text.indexOf('.')+1));
            
            console.log(`result ${result}`);

        */
    }

    function calWorkAgePure(workAgeDays) {
            days = workAgeDays;

            years_remaining = parseInt(days / 365); //divide by 365 and throw away the remainder
            minused = (years_remaining * 365); 

            days -= minused;

            if (days >= 360) {
                days -= 5;
            }

            months_remaining = parseInt(days / 30); //divide by 365 and throw away the remainder
            minused = (months_remaining * 30); 

            days -= minused;

            days_remaining = days % 365;    //divide by 365 and *return* the remainder


            // return `${years_remaining} ปี ${months_remaining} เดือน ${days_remaining} วัน`;
            return [years_remaining, months_remaining, days_remaining]
    }


    ///

    function renderWorkAgeCalSettingUI(calType) {
        if (calType === "custom_year") {
                $("#div_select_end_date_cal").show();

                $("#div_show_budget_year").removeClass("col-4");
                $("#div_select_dp_id").removeClass("col-4");
                $("#div_select_date_cal_type").removeClass("col-4");

                $("#div_show_budget_year").addClass("col-3");
                $("#div_select_dp_id").addClass("col-3");
                $("#div_select_date_cal_type").addClass("col-3");
        } else {
                $("#div_select_end_date_cal").hide();

                $("#div_show_budget_year").removeClass("col-3");
                $("#div_select_dp_id").removeClass("col-3");
                $("#div_select_date_cal_type").removeClass("col-3");

                $("#div_show_budget_year").addClass("col-4");
                $("#div_select_dp_id").addClass("col-4");
                $("#div_select_date_cal_type").addClass("col-4");
        }

        // if (calType === "custom_year") {
        //         $("#div_select_end_date_cal").show();
        //         $("#div_select_dp_id").removeClass("col-6");
        //         $("#div_select_date_cal_type").removeClass("col-6");
        //         $("#div_select_dp_id").addClass("col-4");
        //         $("#div_select_date_cal_type").addClass("col-4");
        // } else {
        //         $("#div_select_end_date_cal").hide();
        //         $("#div_select_dp_id").removeClass("col-4");
        //         $("#div_select_date_cal_type").removeClass("col-4");
        //         $("#div_select_dp_id").addClass("col-6");
        //         $("#div_select_date_cal_type").addClass("col-6");
        // }

        // if (switchingMode) {
        //     if (calType === "custom_year") {
        //         $("#div_select_dp_id").removeClass("col-6");
        //         $("#div_select_date_cal_type").removeClass("col-6");
        //         $("#div_select_dp_id").addClass("col-3");
        //         $("#div_select_date_cal_type").addClass("col-3");
        //         } else { // carlendar_year
        //             if ($("#div_select_dp_id").hasClass("col-3") && $("#div_select_date_cal_type").hasClass("col-3")) {
        //                 $("#div_select_dp_id").removeClass("col-3");
        //                 $("#div_select_date_cal_type").removeClass("col-3");
        //                 $("#div_select_dp_id").addClass("col-6");
        //                 $("#div_select_date_cal_type").addClass("col-6");
        //             }
        //     }
        // } else {
        //     if (calType === "custom_year") {
        //         $("#div_select_dp_id").removeClass("col-6");
        //         $("#div_select_date_cal_type").removeClass("col-6");
        //         $("#div_select_dp_id").addClass("col-3");
        //         $("#div_select_date_cal_type").addClass("col-3");
        //     } else { // carlendar_year
        //         // if ($("#div_select_dp_id").hasClass("col-3") && $("#div_select_date_cal_type").hasClass("col-3")) {
        //         $("#div_select_dp_id").removeClass("col-3");
        //         $("#div_select_date_cal_type").removeClass("col-3");
        //         $("#div_select_dp_id").addClass("col-6");
        //         $("#div_select_date_cal_type").addClass("col-6");
        //         // }
        //     }
            
        // }
        
    }

    function checkData(data) {
        if (data == "YES") {
            // return "มีข้อมูลแล้ว";
            // return "<p class='text-success'>ดำเนินการแล้ว</p><p id='display-last-updated-date'></p>";
            return "ดำเนินการแล้ว";
        } else {
            // return "ยังไม่มีข้อมูล (กดปุ่มบันทึกเพื่อบันทึกข้อมูล)";
            return "รอดำเนินการ";
        }
    }

    function textIsEmpty(data, displayText = "") {
        if (data?.length > 0) {
            return convertToThaiDateDisplayFormat(data);
        } else {
            return `ไม่พบข้อมูล${displayText}`;
        }
    }

    function convertToThaiDateDisplayFormat(data) {
        if (data?.length < 1 || data?.length != 10) {
            return data;
        } else {
            return `${data.substring(8)}/${data.substring(5, 7)}/${Number(data.substring(0, 4)) + 543}`;
        }
        // 2020-08-01
        // 01/08/2563
    }

    function emptyToNull(data) {
        if (data?.length < 1) {
            return null;
        } else {
            return data;
        }
    }

    // declare global variables

    let data = null; // use for store data from getData() func
    let selected_start_date_by_dp_id = null; // use for store data from getData() func
    let selected_end_date_cal = null; // use for store data from refreshDateCalResult() func
    let targetIndex = null; // use for store targetIndex from getData() func
    let dateCalResult = null; // use for store value from refreshDateCalResult() func
    
    let dateCalResultFromDb = null; // use for store value from refreshDateCalResult() func
    let dataForRenderDataTable = null; // use for store value from getDataForRenderDataTable() func

    let updatedDateDisplayText = '';

    function get_current_selected_base_info_checker(keyName, defaultReturnValue = null) {
        let get_current_selected_base_info = this.data?.base_info?.get_current_selected_base_info;
        
        // let get_current_selected_base_info = data?.base_info?.get_current_selected_base_info;
        // console.log(`********************************** get_current_selected_base_info`, get_current_selected_base_info);
        
        return get_current_selected_base_info.length > 0 
                // ? get_current_selected_base_info[0]?[keyName]
                ? get_current_selected_base_info[0][keyName]
                : defaultReturnValue;

    }

    function initialAutoSelect() {
        /* auto select */
                // select_dp_id
                // $(`#select_dp_id option[value=${data?.base_info.get_current_selected_base_info[0].lsum_dp_id}]`).attr('selected', true);
                // $(`#select_dp_id option[value=${data?.base_info.get_current_selected_base_info[0].lsum_dp_id}]`).attr('selected', true);

                // $('[id=select_dp_id]').val(`${data?.base_info.get_current_selected_base_info[0].lsum_dp_id}`);
                // $('[id=select_dp_id]').val(data?.base_info.get_current_selected_base_info[0].lsum_dp_id);
                // console.log(`${$("#select_dp_id").val()}`);
                // document.getElementById('select_dp_id').value = data?.base_info.get_current_selected_base_info[0].lsum_dp_id;

                // $("#select_dp_id").select2("val", `${data?.base_info.get_current_selected_base_info[0].lsum_dp_id}`);
                // $("#select_dp_id").select2("val", data?.base_info.get_current_selected_base_info[0].lsum_dp_id);

                // select_date_cal_type
                // $(`#select_date_cal_type option[value=${data?.base_info.get_current_selected_base_info[0].lsum_date_cal_type}]`).attr('selected', true);

                
                

                // console.log("HI: ",data?.base_info.get_current_selected_base_info[0].lsum_dp_id);
                // $("#select_dp_id").select2("val", data?.base_info.get_current_selected_base_info[0].lsum_dp_id);

                // $("#select_dp_id").select2("val", 2);

                // console.log("HI (data): ", this.data?.base_info.get_current_selected_base_info[0].lsum_dp_id);




                //console.log("HI (data)A: ", this.data);
                // $("#select_dp_id").select2("val", this.data?.base_info.get_current_selected_base_info[0].lsum_dp_id);
                $("#select_dp_id").select2("val", this.get_current_selected_base_info_checker('lsum_dp_id'));
                //console.log("HI B: ", $("#select_dp_id").val());
                
                //console.log("HI C: ", $("#select_date_cal_type").val());
                // console.log("HI (data) D: ", this.data?.base_info.get_current_selected_base_info[0].lsum_date_cal_type);
                //console.log("HI (data) D: ", this.get_current_selected_base_info_checker('lsum_date_cal_type'));
                
                
                // $("#select_date_cal_type").select2("val", ""+`${(this.data?.base_info.get_current_selected_base_info[0].lsum_date_cal_type).toString()}`);
                // $("#select_date_cal_type").select2("val", 2);
                // $('#select_date_cal_type').select2("val", null);
                // $("#select_date_cal_type").select2("val", "custom_year");
                // $("#select_date_cal_type").select2("val", ['custom_year']);
                $("#select_date_cal_type").select2("val", [this.get_current_selected_base_info_checker('lsum_date_cal_type', 'carlendar_year')]);
                //console.log("HI E: ", $("#select_date_cal_type").val());



                // set default date (fetch end_date_cal from db) (when date_cal_type = "custom_year")
                // div_select_end_date_cal


                // $("#select_end_date_cal").flatpickr({
                //     lang: th,
                //     defaultDate: "10/02/2024",
                //     dateFormat: "dd/mm/yyyy"
                // });


                // let lsum_end_date_cal = this.data?.base_info?.get_current_selected_base_info[0]?.lsum_end_date_cal;

                // let get_current_selected_base_info = this.data?.base_info?.get_current_selected_base_info;
                // let lsum_end_date_cal = get_current_selected_base_info.length > 0 
                //                         ? get_current_selected_base_info[0]?.lsum_end_date_cal
                //                         : null;

                let lsum_end_date_cal = this.get_current_selected_base_info_checker('lsum_end_date_cal');

                let defaultDate = null;

                
                if (lsum_end_date_cal != null) {
                    let year = (Number(lsum_end_date_cal.substring(0, 4)) + 543).toString();
                    if (year.length < 4) {
                        year = `0${year}`.toString();
                        // alert('x');
                    }

                    let month = lsum_end_date_cal.substring(5, 7);
                    let day = lsum_end_date_cal.substring(8);

                    // alert(`${year}-${month}-${day}`);

                    defaultDate = new Date(`${year}-${month}-${day}`);
                }
                // else if (lsum_end_date_cal != null && lsum_end_date_cal == '0000-00-00') {
                //     defaultDate = new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate());
                // }
                

                $("#select_end_date_cal").flatpickr({
                    dateFormat: 'd/m/Y',
                    locale: 'th',
                    defaultDate: defaultDate, // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
                    // defaultDate: new Date(`${2024 + 543}-03-25`), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
                    // defaultDate: <?php //echo $date; ?>, // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
                    // defaultDate: new Date(2024 + 543, 2 - 1, 31), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
                    // defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
                    
                });
    }

    // $(document).ready(function() {
    $(document).ready(async function() {
        // Initial DataTable update
        // getData();
        renderWorkAgeCalSettingUI($('#select_date_cal_type').val());
        // getData();
        await getData();
        //console.log('(document ready) this.data: ', this.data);
        initialAutoSelect();
        await refreshDateCalResult();
        dateCalResultFromDb = dateCalResult;
        await getData(); // call again after fetch data from getData() in first time (purpose: re-render #work_age_display element )
        
        await getDataForRenderDataTable();
        // await updateDataTable();

        //checkIsSettedUnlimited
        await takeCheckIsSettedUnlimited();
        // for (let i = 1; i <= dataForRenderDataTable?.length; i++) {
        //     console.log(`input_lsum_per_day_${i}`, `input_lsum_per_hour_${i}`, `input_lsum_per_minute_${i}`, `set_unlimited_leave_${i}`);
        //     checkIsSettedUnlimited([`input_lsum_per_day_${i}`, `input_lsum_per_hour_${i}`, `input_lsum_per_minute_${i}`], `set_unlimited_leave_${i}`);
        // }
        
    });

    function takeCheckIsSettedUnlimited() {
        //checkIsSettedUnlimited
        // console.log(`takeCheckIsSettedUnlimited()`);
        
        // let d = [...dataForRenderDataTable];
        // console.log('d', d);
        // console.log('d[0]', d[0]);
        // console.log('d[0].lsum_count_limit ', d[0].lsum_count_limit );

        if (dataForRenderDataTable?.length > 0 ){
            dataForRenderDataTable?.forEach((item, index) => {
                let i = index + 1;
                checkIsSettedUnlimited([`input_lsum_per_day_${i}`, `input_lsum_per_hour_${i}`, `input_lsum_per_minute_${i}`, `input_lsum_remain_day_${i}`, `input_lsum_remain_hour_${i}`, `input_lsum_remain_minute_${i}`], `set_unlimited_leave_${i}`, item.lsum_count_limit);
            });
        }
        
        
        // for (let i = 1; i <= dataForRenderDataTable?.length; i++) { // if dataForRenderDataTable?.length == 0, loop will be not run
        //     // console.log(`input_lsum_per_day_${i}`, `input_lsum_per_hour_${i}`, `input_lsum_per_minute_${i}`, `set_unlimited_leave_${i}`);
        //     checkIsSettedUnlimited([`input_lsum_per_day_${i}`, `input_lsum_per_hour_${i}`, `input_lsum_per_minute_${i}`, `input_lsum_remain_day_${i}`], `set_unlimited_leave_${i}`, d[i].lsum_count_limit);
        // }
    }

    <?php
    //
    ?>
    
    // Event listeners for select dropdowns
    $('#save-lsum').on('click', async function(event) {
        event.preventDefault();
        // console.log('welcome to save-lsum function, final_found: ', data?.target_user_leave_summary[0]?.final_found);
        // let final_found = data?.target_user_leave_summary[0].final_found;

        let final_found = getFinalFound();
        // console.log('welcome to save-lsum function, final_found: ');
        // console.log(final_found);
        // console.log(getFinalFound());
        let lsum_id = getLsumId();
        let us_id = <?php echo $us_id; ?>;
        let pos_ps_id = getPosPsId();
        let lsum_ps_id = <?php echo $user_id; ?>;

        let response_operation_status = null; // keep response status from backend

        // if ($('#select_date_cal_type').val() == "custom_year") {
            if (dateCalResult < 0 || dateCalResult === null) { // selected date is less than started work date or selected date is incorrect
                dialog_error({
                    'header': text_toast_default_error_header,
                    'body': 'ข้อมูลวันที่เริ่มต้นการคำนวณอายุงานหรือวันที่สิ้นสุดการคำนวณอายุงานไม่ถูกต้อง กรุณาตรวจสอบข้อมูลอีกครั้ง'
                    // 'body': 'กรุณาเลือกวันที่สิ้นสุดการคำนวณอายุงานให้ถูกต้อง'
                });
            } else {
                <?php
                //
                ?>

                // let final_found = data?.target_user_leave_summary[0].final_found;
                // console.log('*************** check final_found again: ', final_found);
                
                
                // if (final_found === "YES") {
                    // console.log('**********final_found : ', final_found);
                    /* update */

                    // let lsum_id = getLsumId();
                    // console.log('welcome to save-lsum function, lsum_id: ', lsum_id);
                    // console.log('welcome to save-lsum function, pos_ps_id: ', pos_ps_id);
                    // console.log('welcome to save-lsum function, lsum_ps_id: ', lsum_ps_id);

                   

                // } else {
                    // console.log('**********final_found : ', final_found);
                    // insert

                    // console.log('welcome to save-lsum function, lsum_id: ', lsum_id);
                    // console.log('welcome to save-lsum function, pos_ps_id: ', pos_ps_id);
                    // console.log('welcome to save-lsum function, lsum_ps_id: ', lsum_ps_id);
                    /*
                    // let lsum_id
                    let lsum_ps_id = this.data?.target_user_leave_summary?.pos_ps_id;
                    let lsum_leave_id = 
                    let lsum_year = <?php// echo $budget_year; ?>;
                    let lsum_date_cal_type = $('#select_date_cal_type').val();
                    let lsum_dp_id = $('#select_dp_id').val();
                    let lsum_start_date_cal = $('#start_date_display').val();
                    let lsum_end_date_cal = (lsum_date_cal_type == 'custom_year') ? $('#select_end_date_cal').val() : $('#end_date_display').val();
                    // let lsum_update_date
                    let lsum_update_user = us_id;
                    let lsum_work_age = dateCalResult;


                    // let lsum_id
                    let lsum_ps_id = this.data?.target_user_leave_summary?.pos_ps_id;
                    let work_age = dateCalResult;

                    // Make AJAX request to fetch updated data
                    await $.ajax({
                        url: '<?php //echo site_url() . "/" . $controller_dir ?>' + "leaves_user/insert_leave_summary/",
                        type: 'POST',
                        data: {
                            // lsum_id,
                            lsum_ps_id,
                            lsum_leave_id,
                            lsum_year,
                            lsum_date_cal_type,
                            lsum_dp_id,
                            lsum_start_date_cal,
                            lsum_end_date_cal,
                            // lsum_update_date,
                            lsum_update_user,
                            lsum_work_age
                        },
                        success: function(response) {
                            console.log('response: ');
                            response = JSON.parse(response);
                            response = response[0];
                            console.log(response);
                            key = `${Object.keys(response)[0]}`;
                            console.log(key);
                            console.log(response[key]);

                            result = response[key];

                            if (result !== null) {
                                $("#work_age_cal_result_display").html(calWorkAge("YES", result));
                            } else {
                                $("#work_age_cal_result_display").html(calWorkAge("NO", result));
                            }

                            // console.log(`!!!!!!!!!!!!!!!!!!!!!!!!!!!!! this.dateCalResult: ${this.dateCalResult}`); // don't use this command
                            setDateCalResult(result);
                            console.log(`!!!!!!!!!!!!!!!!!!!!!!!!!!!!! result: ${result}`);
                            // console.log(`!!!!!!!!!!!!!!!!!!!!!!!!!!!!! this.dateCalResult: ${this.dateCalResult}`); // don't use this command
                            console.log(`!!!!!!!!!!!!!!!!!!!!!!!!!!!!! dateCalResult: ${dateCalResult}`);
                            console.log(`!!!!!!!!!!!!!!!!!!!!!!!!!!!!! getDateCalResult: ${getDateCalResult()}`);
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            dialog_error({
                                'header': text_toast_default_error_header,
                                'body': text_toast_default_error_body
                            });
                        }
                    });

                    */
                    // get list

                    // let lsum_id
                    // let lsum_ps_id = this.data?.target_user_leave_summary?.pos_ps_id;
                    
                    let work_age = calWorkAgePure(dateCalResult);
                    let budget_year = `${<?php echo $budget_year; ?>}`;
                    let date_cal_type = $('#select_date_cal_type').val();
                    let dp_id = $('#select_dp_id').val();

                    

                    // console.log(`hi test: ${lsum_ps_id}, ${work_age}, ${budget_year}, ${date_cal_type}, ${dp_id}, ${selected_start_date_by_dp_id}, ${selected_end_date_cal}`);

                    // alert(lsum_ps_id +", "+ work_age);

                    //console.log('save-lsum, selected_start_date_by_dp_id: ',selected_start_date_by_dp_id);

                    let leave_summary_usage_data = [];

                    countRow = document.getElementById("leave_summary_table_row_amount").innerHTML;

                    //v1
                    
                    // for (let i = 1; i <= countRow; i++) {
                    //     let l = [];
                        
                    //     l["lsum_id"] = document.getElementById(`lsum_id_${i}`).innerHTML;
                    //     l["leave_id"] = document.getElementById(`leave_id_${i}`).innerHTML;

                    //     let set_unlimited_leave = document.getElementById(`set_unlimited_leave_${i}`).checked;
                    //     l["set_unlimited_leave"] = set_unlimited_leave; 

                    //     let input_lsum_per_day =  (Number.isInteger(Number(document.getElementById(`input_lsum_per_day_${i}`).value))) ? (document.getElementById(`input_lsum_per_day_${i}`).value) : 0
                    //     let input_lsum_per_hour =  (Number.isInteger(Number(document.getElementById(`input_lsum_per_hour_${i}`).value))) ? (document.getElementById(`input_lsum_per_hour_${i}`).value) : 0
                    //     let input_lsum_per_minute =  (Number.isInteger(Number(document.getElementById(`input_lsum_per_minute_${i}`).value))) ? (document.getElementById(`input_lsum_per_minute_${i}`).value) : 0
                    //     l["input_lsum_per_day"] = (set_unlimited_leave == true) ? -99 : input_lsum_per_day;
                    //     l["input_lsum_per_hour"] = (set_unlimited_leave == true) ? -99 : input_lsum_per_hour;
                    //     l["input_lsum_per_minute"] = (set_unlimited_leave == true) ? -99 : input_lsum_per_minute;
                        
                    //     l["lsum_num_day"] = (Number.isInteger(Number(document.getElementById(`lsum_num_day_${i}`).innerHTML))) ? (document.getElementById(`lsum_num_day_${i}`).innerHTML) : 0;
                    //     l["lsum_num_hour"] = (Number.isInteger(Number(document.getElementById(`lsum_num_hour_${i}`).innerHTML))) ? (document.getElementById(`lsum_num_hour_${i}`).innerHTML) : 0;
                    //     l["lsum_num_minute"] = (Number.isInteger(Number(document.getElementById(`lsum_num_minute_${i}`).innerHTML))) ? (document.getElementById(`lsum_num_minute_${i}`).innerHTML) : 0;
                        
                    //     let text_input_lsum_remain_day = (Number.isInteger(Number(document.getElementById(`text_input_lsum_remain_day_${i}`).innerHTML))) ? (document.getElementById(`text_input_lsum_remain_day_${i}`).innerHTML) : 0;
                    //     let text_input_lsum_remain_hour = (Number.isInteger(Number(document.getElementById(`text_input_lsum_remain_hour_${i}`).innerHTML))) ? (document.getElementById(`text_input_lsum_remain_hour_${i}`).innerHTML) : 0;    
                    //     let text_input_lsum_remain_minute = (Number.isInteger(Number(document.getElementById(`text_input_lsum_remain_minute_${i}`).innerHTML))) ? (document.getElementById(`text_input_lsum_remain_minute_${i}`).innerHTML) : 0;        
                    //     l["text_input_lsum_remain_day"] = (set_unlimited_leave == true) ? -99 : text_input_lsum_remain_day;  
                    //     l["text_input_lsum_remain_hour"] = (set_unlimited_leave == true) ? -99 : text_input_lsum_remain_hour; 
                    //     l["text_input_lsum_remain_minute"] = (set_unlimited_leave == true) ? -99 : text_input_lsum_remain_minute;

                        

                    //     leave_summary_usage_data.push(l);

                    //     // console.log('HHHHHHI: ', document.getElementById(`text_input_lsum_remain_day_${index}`).innerHTML);
                    //     // console.log('HHHHHHI: ', document.getElementById(`text_input_lsum_remain_hour_${index}`).innerHTML);
                    //     // console.log('HHHHHHI: ', document.getElementById(`text_input_lsum_remain_minute_${index}`).innerHTML);

                    // }


                    //v2

                    for (let i = 1; i <= countRow; i++) {
                        

                        let set_unlimited_leave = document.getElementById(`set_unlimited_leave_${i}`).checked;


                        let input_lsum_per_day =  (Number.isInteger(Number(document.getElementById(`input_lsum_per_day_${i}`).value))) ? (document.getElementById(`input_lsum_per_day_${i}`).value) : 0;
                        let input_lsum_per_hour =  (Number.isInteger(Number(document.getElementById(`input_lsum_per_hour_${i}`).value))) ? (document.getElementById(`input_lsum_per_hour_${i}`).value) : 0;
                        let input_lsum_per_minute =  (Number.isInteger(Number(document.getElementById(`input_lsum_per_minute_${i}`).value))) ? (document.getElementById(`input_lsum_per_minute_${i}`).value) : 0;

                        // let text_input_lsum_remain_day = (Number.isInteger(Number(document.getElementById(`input_lsum_remain_day_${i}`).value))) ? (document.getElementById(`input_lsum_remain_day_${i}`).value) : 0;
                        // let text_input_lsum_remain_hour = (Number.isInteger(Number(document.getElementById(`input_lsum_remain_hour_${i}`).value))) ? (document.getElementById(`input_lsum_remain_hour_${i}`).value) : 0;    
                        // let text_input_lsum_remain_minute = (Number.isInteger(Number(document.getElementById(`input_lsum_remain_minute_${i}`).value))) ? (document.getElementById(`input_lsum_remain_minute_${i}`).value) : 0;       

                        // console.log('text_input_lsum_remain_day: ', text_input_lsum_remain_day);
                        // console.log('text_input_lsum_remain_hour: ', text_input_lsum_remain_hour);
                        // console.log('text_input_lsum_remain_minute: ', text_input_lsum_remain_minute);
                        

                        // เรียกใช้ฟังก์ชันเพื่อคำนวณนาทีทั้งหมด
                        let total_per_minutes = convertToMinutes({
                            lsum_per_day: Number(input_lsum_per_day),  
                            lsum_per_hour: Number(input_lsum_per_hour), 
                            lsum_per_minute: Number(input_lsum_per_minute)
                        });

                        // เรียกใช้ฟังก์ชันเพื่อคำนวณนาทีทั้งหมด
                        // let sum_minutes = convertToMinutes({
                        //     lsum_per_day: Number((Number.isInteger(Number(document.getElementById(`lsum_num_day_${i}`).innerHTML)))) ? Number(document.getElementById(`lsum_num_day_${i}`).innerHTML) : 0,  
                        //     lsum_per_hour: Number((Number.isInteger(Number(document.getElementById(`lsum_num_hour_${i}`).innerHTML)))) ? Number(document.getElementById(`lsum_num_hour_${i}`).innerHTML) : 0, 
                        //     lsum_per_minute: Number((Number.isInteger(Number(document.getElementById(`lsum_num_minute_${i}`).innerHTML)))) ? Number(document.getElementById(`lsum_num_minute_${i}`).innerHTML) : 0
                        // });
                        let sum_minutes = Number(document.getElementById(`input_lsum_sum_minutes_${i}`).value);
                        // console.log('total_per_minutes: ', total_per_minutes);
                       
                        total_per_minutes = total_per_minutes - sum_minutes;
                    
                        let calLsumNumResultRemain = calLsumNum(total_per_minutes);
                        calLsumNumResultRemain = calLsumNum(total_per_minutes);

                        
                        
                        // console.log('sum_minutes: ', sum_minutes);
                        // console.log('total_per_minutes: ', Number(total_per_minutes));
                        
                        let text_input_lsum_remain_day;
                        let text_input_lsum_remain_hour;
                        let text_input_lsum_remain_minute;

                        if(sum_minutes){
                            // console.log('text_input_lsum_remain_day: ', calLsumNumResultRemain[0]);
                            // console.log('text_input_lsum_remain_hour: ', calLsumNumResultRemain[1]);
                            // console.log('text_input_lsum_remain_minute: ', calLsumNumResultRemain[2]);
                            text_input_lsum_remain_day = (set_unlimited_leave == true) ? -99 : calLsumNumResultRemain[0];
                            text_input_lsum_remain_hour = (set_unlimited_leave == true) ? -99 : calLsumNumResultRemain[1];
                            text_input_lsum_remain_minute = (set_unlimited_leave == true) ? -99 : calLsumNumResultRemain[2];
                        }
                        else{
                            
                            text_input_lsum_remain_day = (set_unlimited_leave == true) ? -99 : input_lsum_per_day;
                            text_input_lsum_remain_hour = (set_unlimited_leave == true) ? -99 : input_lsum_per_hour;
                            text_input_lsum_remain_minute = (set_unlimited_leave == true) ? -99 : input_lsum_per_minute;
                        }

                        leave_summary_usage_data.push({
                            lsum_id: document.getElementById(`lsum_id_${i}`).innerHTML,
                            leave_id: document.getElementById(`leave_id_${i}`).innerHTML,
                            set_unlimited_leave: (set_unlimited_leave == true) ? "Y" : "N",
                            input_lsum_per_day: (set_unlimited_leave == true) ? -99 : input_lsum_per_day,
                            input_lsum_per_hour: (set_unlimited_leave == true) ? -99 : input_lsum_per_hour,
                            input_lsum_per_minute: (set_unlimited_leave == true) ? -99 : input_lsum_per_minute,
                            lsum_num_day: (Number.isInteger(Number(document.getElementById(`lsum_num_day_${i}`).innerHTML))) ? (document.getElementById(`lsum_num_day_${i}`).innerHTML) : 0,
                            lsum_num_hour: (Number.isInteger(Number(document.getElementById(`lsum_num_hour_${i}`).innerHTML))) ? (document.getElementById(`lsum_num_hour_${i}`).innerHTML) : 0,
                            lsum_num_minute: (Number.isInteger(Number(document.getElementById(`lsum_num_minute_${i}`).innerHTML))) ? (document.getElementById(`lsum_num_minute_${i}`).innerHTML) : 0,
                            text_input_lsum_remain_day: (set_unlimited_leave == true) ? -99 : text_input_lsum_remain_day,  
                            text_input_lsum_remain_hour: (set_unlimited_leave == true) ? -99 : text_input_lsum_remain_hour, 
                            text_input_lsum_remain_minute: (set_unlimited_leave == true) ? -99 : text_input_lsum_remain_minute
                        });

                        

                    }
                    //console.log('clicked');
                    //console.log('countRow: ', countRow);
                    // console.log('leave_summary_usage_data: ', leave_summary_usage_data);
                    //console.log('leave_summary_usage_data[0]["input_lsum_per_day"]: ', leave_summary_usage_data[0]["input_lsum_per_day"]);
                    

                    // Make AJAX request to fetch updated data
                    await $.ajax({
                        url: '<?php echo site_url() . "/" . $controller_dir ?>' + "leaves_user/leave_summary_insertor_updator_engine/",
                        type: 'POST',
                        data: {
                            mode: (final_found === "YES") ? "update" : "insert",
                            lsum_ps_id,
                            work_age,
                            budget_year,
                            date_cal_type,
                            dp_id,
                            selected_start_date_by_dp_id,
                            selected_end_date_cal,
                            leave_summary_usage_data
                        },
                        success: function(response) {
                            // console.log('(ajax) response(raw) is: ', response);
                            response = JSON.parse(response);
                            // console.log('(ajax) response is: ', response);
                            // console.log('(ajax) response.operation_status is: ', response.operation_status);

                            
                            if (response.operation_status === "10" || response.operation_status === "11") {
                                dialog_success({'header': "บันทึกข้อมูลสำเร็จ", 'body': "ดำเนินการกำหนดสิทธิ์วันลาสำเร็จ"});
                                // location.reload();
                            } else {
                                dialog_error({
                                    'header': "ไม่สามารถบันทึกข้อมูลได้",
                                    'body': "ไม่พบข้อมูลควบคุมวันลาที่เข้ากันได้กับบุคลากรนี้ โปรดตรวจสอบข้อมูลควบคุมวันลาอีกครั้ง"
                                });
                            }

                            response_operation_status = response.operation_status;
                            // alert(`A: response_operation_status ${response_operation_status}`);

                            // if (response.operation_status === "not inserted") {
                            //     dialog_error({
                            //         'header': "ไม่สามารถบันทึกข้อมูลได้",
                            //         'body': "ไม่พบข้อมูลควบคุมวันลาที่เข้ากันได้กับบุคลากรนี้ โปรดตรวจสอบข้อมูลควบคุมวันลาอีกครั้ง"
                            //     });
                            // } else {
                            //     dialog_success({'header': "บันทึกข้อมูลสำเร็จ", 'body': "กำหนดสิทธิ์วันลาให้แก่บุคลากรนี้เสร็จเรียบร้อย"});
                            // }

                            updateDataTable();
                            
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            dialog_error({
                                'header': text_toast_default_error_header,
                                'body': text_toast_default_error_body
                            });
                        }
                    });
                // }
                //console.log("select_dp_id: ", $('#select_dp_id').val());
                //console.log("select_date_cal_type: ", $('#select_date_cal_type').val());
                //console.log("start_date_display: ", $('#start_date_display').html());  // 01/12/2567
                //console.log("select_end_date_cal: ", $('#select_end_date_cal').val());  // 01/12/2567


                <?php
                /**/
                ?>
            }
            
        // } else if ($('#select_date_cal_type').val() == "carlendar_year") {

        // }

        
        // console.log('ok');

        // function(xhr, status, error) {
        //         // Handle errors
        //         dialog_error({
        //             'header': text_toast_default_error_header,
        //             'body': text_toast_default_error_body
        //         });
        //     }

        // refresh final_found data
        getData(); 

        // alert(`B: response_operation_status ${response_operation_status}`);
        if (response_operation_status != "01") {
            dateCalResultFromDb = dateCalResult; // re-render #work_age_display element
        }

        await getDataForRenderDataTable();
    });


    /* function for get data for render datatable */
    async function getDataForRenderDataTable(event) {
        // event.preventDefault();

        //console.log(`dateCalResult: ${dateCalResult} (from getDataForRenderDataTable)`);

        let final_found = getFinalFound();
        let lsum_id = getLsumId();
        let us_id = <?php echo $us_id; ?>;
        let pos_ps_id = getPosPsId();
        let lsum_ps_id = <?php echo $user_id; ?>;

        // let response_operation_status = null; // keep response status from backend

        // console.log(`selected_start_date_by_dp_id: ${selected_start_date_by_dp_id}, selected_end_date_cal: ${selected_end_date_cal}`);

            if (dateCalResult < 0 || dateCalResult === null) { // selected date is less than started work date or selected date is incorrect
                // dialog_error({
                //     'header': text_toast_default_error_header,
                //     'body': 'ข้อมูลวันที่เริ่มต้นการคำนวณอายุงานหรือวันที่สิ้นสุดการคำนวณอายุงานไม่ถูกต้อง กรุณาตรวจสอบข้อมูลอีกครั้ง'
                // });
                dataForRenderDataTable = {
                    checkResult: [],
                    filtered_pre_list: [],
                    leave_summary_datatable: [],
                    lsum_leave_id_set: "",
                    operation_status_text: "",
                    pre_list: []
                }
            } else {
                
                    let work_age = calWorkAgePure(dateCalResult);
                    let budget_year = `${<?php echo $budget_year; ?>}`;
                    let date_cal_type = $('#select_date_cal_type').val();
                    let dp_id = $('#select_dp_id').val();

                    // Make AJAX request to fetch updated data
                    await $.ajax({
                        
                        url: '<?php echo site_url() . "/" . $controller_dir ?>' + "leaves_user/get_leave_summary_datatable/",
                        type: 'POST',
                        data: {
                            lsum_ps_id,
                            work_age,
                            budget_year,
                            date_cal_type,
                            dp_id,
                            selected_start_date_by_dp_id,
                            selected_end_date_cal
                        },
                        success: function(response) {
                            response = JSON.parse(response);
                            // console.log('(from getDataForRenderDataTable), response is: ', response);

                            dataForRenderDataTable = response.leave_summary_datatable;
                            // if (response.operation_status === "10" || response.operation_status === "11") {
                            //     dialog_success({'header': "บันทึกข้อมูลสำเร็จ", 'body': "กำหนดสิทธิ์วันลาให้แก่บุคลากรนี้เสร็จเรียบร้อย"});
                                
                            // } else {
                            //     dialog_error({
                            //         'header': "ไม่สามารถบันทึกข้อมูลได้",
                            //         'body': "ไม่พบข้อมูลควบคุมวันลาที่เข้ากันได้กับบุคลากรนี้ โปรดตรวจสอบข้อมูลควบคุมวันลาอีกครั้ง"
                            //     });
                            // }

                            // response_operation_status = response.operation_status;
                            
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
            
        // getData();
        // if (response_operation_status != "01") {
        //     dateCalResultFromDb = dateCalResult; // re-render #work_age_display element
        // }

        await updateDataTable();
    }

    <?php
    //
    ?>


    // Event listeners for select dropdowns
    $('#select_date_cal_type').on('change', function() {
        // getData();
        renderWorkAgeCalSettingUI($('#select_date_cal_type').val());
    });

    // Event listeners for select dropdowns
    // $('#select_dp_id, #select_date_cal_type , #select_end_date_cal').on('change', function() {
    $('#select_dp_id, #select_date_cal_type , #select_end_date_cal').on('change', async function() {
        // Update DataTable when a select dropdown changes
        // alert(`Hi ${$('#select_budget_year').val()}`);
        //console.log('select_end_date_cal: ', $('#select_end_date_cal').val());
        await getData();
        await refreshDateCalResult();
        // datePickerResetor();
        //console.log('changed, dateCalResult: ' , dateCalResult);
        incorrectDateDetector();

        //console.log(`select_dp_id: `, $("#select_dp_id").val());
        //console.log(`select_date_cal_type: `, $("#select_date_cal_type").val());

        await getDataForRenderDataTable();
        // await updateDataTable();
    });

    // Function to update DataTable based on select dropdown values
    async function updateDataTable() {
        
        // Initialize DataTable
        var dataTable = $('#leave_summary_table').DataTable();

        // select_budget_year = Number(select_budget_year) - 543;
        // var select_budget_year = $('#select_budget_year').val() - 543;
        // var select_budget_year = $('#select_budget_year').val();

        // let select_budget_year = document.getElementById("select_budget_year").value;
        // var select_hire_is_medical = $('#select_hire_is_medical').val();
        // var select_hire_type = $('#select_hire_type').val();
        // var select_work_status = $('#select_work_status').val();

        // alert(`detect ${select_budget_year}`);

        // function checkData(data) {
        //     if (data == "YES") {
        //         return "มีข้อมูลแล้ว";
        //     } else {
        //         return "ยังไม่มีข้อมูล";
        //     }
        // }

        // function calWorkAge(data, workAgeDays) {
        //     if (data == "YES") {
        //         // return "แสดงข้อมูล";
                
        //         days = workAgeDays;

        //         years_remaining = parseInt(days / 365); //divide by 365 and throw away the remainder
        //         minused = (years_remaining * 365); 

        //         days -= minused;

        //         months_remaining = parseInt(days / 30); //divide by 365 and throw away the remainder
        //         minused = (months_remaining * 30); 

        //         days -= minused;

        //         days_remaining = days % 365;    //divide by 365 and *return* the remainder

        //         return `${years_remaining} ปี ${months_remaining} เดือน ${days_remaining} วัน`;
        //     } else {
        //         return "-";
        //     }
        // }

        // function checkDateCalType(data) {
        //     if (data == "carlendar_year") {
        //         return "ปีปฏิทิน";
        //     } else if (data == "custom_year") {
        //         return "วันที่ที่เจ้าหน้าที่กำหนด";
        //     } else {
        //         return "-";
        //     }
        // }

        // function checkDataShowDash(data) {
        //     if (data !== null) {
        //         return data;
        //     } else {
        //         return "-";
        //     }
        // }

        // function displayEndDateCal(dateCalType, endDateCal, year) {
        //     if (dateCalType == 'carlendar_year') {
        //         return `${year}-01-01`
        //     } else if (dateCalType == 'custom_year') {
        //         if (endDateCal != null) {
        //             return endDateCal;
        //         } else {
        //             return "-";
        //         }
        //     } else {
        //         return '-';
        //     }
            
        // }

        // let lsum_ps_id = <?php //echo $user_id; ?>;
        // let budget_year = `${<?php //echo $budget_year; ?>}`;

        //console.log('dataForRenderDataTable: ', dataForRenderDataTable);
        // Clear existing DataTable data
        dataTable.clear().draw();

        // // Update summary count
        $("#leave_summary_table_row_amount").text(dataForRenderDataTable?.length);

        function checkData(data) {
            if (data === null || data === undefined) {
                return 'ไม่มีข้อมูล';
            } else {
                return data;
            }
        }

        function setClassToLiveElement (data, key = "") {
            // if (data == "-99") {
            // console.log("setClassToLiveElement: ", data)
            if (data == "Y") {
                // console.log('live-absolute');
                return 'live-absolute';
            } else {
                // console.log('live-original');
                return 'live-original';
            }
        }

        function setClassToTextElement (data, key = "") {
            // if (data == "-99") {
            // console.log("setClassToTextElement: ", data)
            if (data == "Y") { // is unlimited
                // console.log('dp-none');
                return 'dp-none'; //hide
            } else {
                // console.log('dp-block');
                return 'dp-block'; //show
            }
        }

        function setClassToDivElement (data, key = "") {
            // if (data == "-99") {
            // console.log("setClassToDivElement: ", data)
            if (data == "N") { // is not unlimited
                // console.log('dp-none');
                return 'dp-none'; //hide
            } else {
                // console.log('dp-block');
                return 'dp-block'; //show
            }
        }

        function setClassToCheckboxElement (data, key = "") {
            // if (data == "-99") {
            // console.log("setClassToCheckboxElement: ", data);
            if (data == "N") { // is not unlimited
                // console.log("setClassToCheckboxElement: ''");
                return 'false'; //hide
            } else {
                // console.log("setClassToCheckboxElement: checked");
                return 'true'; //show
            }
        }

        

        function minusChecker(a, b) {
            if (a > b) {
                return a - b;
            } else {
                return 0;
            }
        }

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

        // ui tuner for column lsum_remain_day, lsum_remain_hour, lsum_remain_minute

        index = 1;

        if (dataForRenderDataTable?.length > 0) {

            // display-last-updated-date (display lsum updated date)
            if (dataLocalVar?.target_user_leave_summary[0].final_found == "YES") {
                // console.log(dataForRenderDataTable);
                let updatedDateTime = dataForRenderDataTable[0]['lsum_update_date'];
                let updatedDate = updatedDateTime.substring(0, 10);
                let updatedTime = updatedDateTime.substring(11);

                // document.getElementById('display-last-updated-date').innerHTML = `(ข้อมูลอัพเดทเมื่อวันที่ ${(updatedDate != null && updatedDate != undefined && updatedDate?.length > 0) ? abbreDate2(updatedDate) : updatedDate} เวลา ${updatedTime} น. )`;
                let my_final_data_display_new = document.getElementById('final_data_display_new').value;
                // let my_final_data_display_new = document.getElementById('final_data_display_new').value;
                // console.log(my_final_data_display_new);
                // document.getElementById('final_data_display_new').innerHTML = my_final_data_display_new+` (ข้อมูลอัพเดทเมื่อวันที่ ${(updatedDate != null && updatedDate != undefined && updatedDate?.length > 0) ? abbreDate2(updatedDate) : updatedDate} เวลา ${updatedTime} น. )`;
                // updatedDateDisplayText = 
                
                // $("#final_data_display_new").val(checkData(data?.target_user_leave_summary[0].final_found)+` (ข้อมูลอัพเดทเมื่อวันที่ ${(updatedDate != null && updatedDate != undefined && updatedDate?.length > 0) ? abbreDate2(updatedDate) : updatedDate} เวลา ${updatedTime} น. )`);
                updatedDateDisplayText = ` (ข้อมูลอัพเดทเมื่อวันที่ ${(updatedDate != null && updatedDate != undefined && updatedDate?.length > 0) ? abbreDate2(updatedDate) : updatedDate} เวลา ${updatedTime} น.)`;
                // console.log('my data', this.data);
                // console.log('my final found', this.data?.target_user_leave_summary[0].final_found);

                $("#final_data_display_new").text(((this.data?.target_user_leave_summary[0].final_found == "YES") ? "ดำเนินการแล้ว" : "รอดำเนินการ")+ updatedDateDisplayText);
                // console.log('B:',(this.data?.target_user_leave_summary[0].final_found));
                
                if(this.data?.target_user_leave_summary[0].final_found == "YES") {
                    $("#final_data_display_new").removeClass("bg-warning");
                    $("#final_data_display_new").removeClass("bg-success");
                    $("#final_data_display_new").addClass("bg-success");
                } else {
                    $("#final_data_display_new").removeClass("bg-success");
                    $("#final_data_display_new").removeClass("bg-warning");
                    $("#final_data_display_new").addClass("bg-warning");
                }
            }

            dataForRenderDataTable?.forEach((item, index) => {
            // console.log(item);
            // console.log(Number.isInteger(123));

            let calLsumNumResult = calLsumNum(item.sum_minutes);
            let calLsumNumResultRemain = 0;
            let lsum_num_day_calculated = calLsumNumResult[0];
            let lsum_num_hour_calculated = calLsumNumResult[1];
            let lsum_num_minute_calculated = calLsumNumResult[2];
            let total_per_minutes = 0;
            if(item.lsum_count_limit == "N"){

               // เรียกใช้ฟังก์ชันเพื่อคำนวณนาทีทั้งหมด
                total_per_minutes = convertToMinutes({
                    lsum_per_day: Number(item.lsum_per_day),  
                    lsum_per_hour: Number(item.lsum_per_hour), 
                    lsum_per_minute: Number(item.lsum_per_minute)
                });
                // console.log("table total_per_minutes", total_per_minutes);
                // console.log("table item.sum_minutes", item.sum_minutes);
                total_per_minutes = total_per_minutes - item.sum_minutes;
                // console.log("table total_per_minutes", total_per_minutes);
                calLsumNumResultRemain = calLsumNum(total_per_minutes);
                
            }
            else{
                item.lsum_remain_day = "-99";
                item.lsum_remain_hour = "-99";
                item.lsum_remain_minute = "-99";
            }

            // Add new row to DataTable
            dataTable.row.add([
                    ++index,
                    `
                    <td>
                        ${checkData(item.leave_name)}
                        <p hidden id="lsum_id_${index}">${item.lsum_id}</p>
                        <p hidden id="leave_id_${index}">${item.leave_id}</p>
                    </td>
                    `,
                    `<td>
                        <div id="box_input_lsum_per_day_${index}" class="box" style="position: relative;">
                            <div class="text-center">
                                <input type="number" min="0" id="input_lsum_per_day_${index}" class="form-control text-center" value="${checkData(item.lsum_per_day)}">
                            </div>
                            <div id="live_input_lsum_per_day_${index}" class="${setClassToLiveElement(item.lsum_count_limit, 'lsum_count_limit')}">
                                <button style="opacity: 100%" id="infinity-sign" type="button" onclick="event.preventDefault();" disabled class="btn btn-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-infinity" viewBox="0 0 16 16">
                                        <path d="M5.68 5.792 7.345 7.75 5.681 9.708a2.75 2.75 0 1 1 0-3.916ZM8 6.978 6.416 5.113l-.014-.015a3.75 3.75 0 1 0 0 5.304l.014-.015L8 8.522l1.584 1.865.014.015a3.75 3.75 0 1 0 0-5.304l-.014.015zm.656.772 1.663-1.958a2.75 2.75 0 1 1 0 3.916z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </td>`,
                    `<td>
                        <div id="box_input_lsum_per_hour_${index}" class="box" style="position: relative;">
                            <div class="text-center">
                                <input type="number" min="0" id="input_lsum_per_hour_${index}" class="form-control text-center" value="${checkData(item.lsum_per_hour)}">
                                <input type="hidden" min="0" id="input_lsum_sum_minutes_${index}" class="form-control text-center" value="${checkData(item.sum_minutes)}">
                            </div>
                            <div id="live_input_lsum_per_hour_${index}" class="${setClassToLiveElement(item.lsum_count_limit, 'lsum_count_limit')}">
                                <button style="opacity: 100%" id="infinity-sign" type="button" onclick="event.preventDefault();" disabled class="btn btn-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-infinity" viewBox="0 0 16 16">
                                        <path d="M5.68 5.792 7.345 7.75 5.681 9.708a2.75 2.75 0 1 1 0-3.916ZM8 6.978 6.416 5.113l-.014-.015a3.75 3.75 0 1 0 0 5.304l.014-.015L8 8.522l1.584 1.865.014.015a3.75 3.75 0 1 0 0-5.304l-.014.015zm.656.772 1.663-1.958a2.75 2.75 0 1 1 0 3.916z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </td>`,
                    `<td>
                        <div id="box_input_lsum_per_minute_${index}" class="box" style="position: relative;">
                            <div class="text-center">
                                <input type="number" min="0" id="input_lsum_per_minute_${index}" class="form-control text-center" value="${checkData(item.lsum_per_minute)}">
                            </div>
                            <div id="live_input_lsum_per_minute_${index}" class="${setClassToLiveElement(item.lsum_count_limit, 'lsum_count_limit')}">
                                <button style="opacity: 100%" id="infinity-sign" type="button" onclick="event.preventDefault();" disabled class="btn btn-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-infinity" viewBox="0 0 16 16">
                                        <path d="M5.68 5.792 7.345 7.75 5.681 9.708a2.75 2.75 0 1 1 0-3.916ZM8 6.978 6.416 5.113l-.014-.015a3.75 3.75 0 1 0 0 5.304l.014-.015L8 8.522l1.584 1.865.014.015a3.75 3.75 0 1 0 0-5.304l-.014.015zm.656.772 1.663-1.958a2.75 2.75 0 1 1 0 3.916z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </td>`,
                    `<td>
                        <div id="lsum_num_day_${index}">${checkData(lsum_num_day_calculated)}</div>
                    </td>`,
                    `<td>
                        <div id="lsum_num_hour_${index}">${checkData(lsum_num_hour_calculated)}</div>
                    </td>`,
                    `<td>
                        <div id="lsum_num_minute_${index}">${checkData(lsum_num_minute_calculated)}</div>
                    </td>`,
                    // checkData(item.lsum_remain_day) 
                    // + 
                    `
                        <div id="box_input_lsum_remain_day_${index}" class="box" style="position: relative;">
                            <div id="text_input_lsum_remain_day_${index}" class="${setClassToTextElement(item.lsum_count_limit)}">${checkData(calLsumNumResultRemain[0])}</div>
                            <div id="div_input_lsum_remain_day_${index}" class="${setClassToDivElement(item.lsum_count_limit)}">
                                <input type="number" min="0" id="input_lsum_remain_day_${index}" class="form-control text-center" value="${checkData(calLsumNumResultRemain[0])}">
                            </div>
                            <div id="live_input_lsum_remain_day_${index}" class="${setClassToLiveElement(item.lsum_count_limit, 'lsum_count_limit')}">
                                <button style="opacity: 100%" id="infinity-sign" type="button" onclick="event.preventDefault();" disabled class="btn btn-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-infinity" viewBox="0 0 16 16">
                                        <path d="M5.68 5.792 7.345 7.75 5.681 9.708a2.75 2.75 0 1 1 0-3.916ZM8 6.978 6.416 5.113l-.014-.015a3.75 3.75 0 1 0 0 5.304l.014-.015L8 8.522l1.584 1.865.014.015a3.75 3.75 0 1 0 0-5.304l-.014.015zm.656.772 1.663-1.958a2.75 2.75 0 1 1 0 3.916z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `
                    ,
                    `
                        <div id="box_input_lsum_remain_hour_${index}" class="box" style="position: relative;">
                            <div id="text_input_lsum_remain_hour_${index}" class="${setClassToTextElement(item.lsum_count_limit)}">${checkData(calLsumNumResultRemain[1])}</div>
                            <div id="div_input_lsum_remain_hour_${index}" class="${setClassToDivElement(item.lsum_count_limit)}">
                                <input type="number" min="0" id="input_lsum_remain_hour_${index}" class="form-control text-center" value="${checkData(calLsumNumResultRemain[1])}">
                            </div>
                            <div id="live_input_lsum_remain_hour_${index}" class="${setClassToLiveElement(item.lsum_count_limit, 'lsum_count_limit')}">
                                <button style="opacity: 100%" id="infinity-sign" type="button" onclick="event.preventDefault();" disabled class="btn btn-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-infinity" viewBox="0 0 16 16">
                                        <path d="M5.68 5.792 7.345 7.75 5.681 9.708a2.75 2.75 0 1 1 0-3.916ZM8 6.978 6.416 5.113l-.014-.015a3.75 3.75 0 1 0 0 5.304l.014-.015L8 8.522l1.584 1.865.014.015a3.75 3.75 0 1 0 0-5.304l-.014.015zm.656.772 1.663-1.958a2.75 2.75 0 1 1 0 3.916z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `
                    ,
                    `
                        <div id="box_input_lsum_remain_minute_${index}" class="box" style="position: relative;">
                            <div id="text_input_lsum_remain_minute_${index}" class="${setClassToTextElement(item.lsum_count_limit)}">${checkData(calLsumNumResultRemain[2])}</div>
                            <div id="div_input_lsum_remain_minute_${index}" class="${setClassToDivElement(item.lsum_count_limit)}">
                                <input type="number" min="0" id="input_lsum_remain_minute_${index}" class="form-control text-center" value="${checkData(calLsumNumResultRemain[2])}">
                            </div>
                            <div id="live_input_lsum_remain_minute_${index}" class="${setClassToLiveElement(item.lsum_count_limit, 'lsum_count_limit')}">
                                <button style="opacity: 100%" id="infinity-sign" type="button" onclick="event.preventDefault();" disabled class="btn btn-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-infinity" viewBox="0 0 16 16">
                                        <path d="M5.68 5.792 7.345 7.75 5.681 9.708a2.75 2.75 0 1 1 0-3.916ZM8 6.978 6.416 5.113l-.014-.015a3.75 3.75 0 1 0 0 5.304l.014-.015L8 8.522l1.584 1.865.014.015a3.75 3.75 0 1 0 0-5.304l-.014.015zm.656.772 1.663-1.958a2.75 2.75 0 1 1 0 3.916z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `
                    ,
                    (item.lsum_leave_id == 2 || item.lsum_leave_id == 3) 
                    ? `<td>
                        <div class="text-center">
                            <input type="number" min="0" id="input_lsum_per_day_${index}" class="form-control text-center" value="${item.lsum_leave_old}">
                        </div>
                    </td>` 
                    : "-"
                    ,
                    // (item.lsum_count_limit == "Y") 
                    // ? 
                    // `<input type="checkbox" checked class="form-check-input" id="set_unlimited_leave_${index}" onclick="changeInputUI(['input_lsum_per_day_${index}', 'input_lsum_per_hour_${index}', 'input_lsum_per_minute_${index}', 'input_lsum_remain_day_${index}'], this.checked);" >
                    // <label for="set_unlimited_leave_${index}" class="form-label">ไม่จำกัด</label>`
                    // :
                    `<input type="checkbox" class="form-check-input" id="set_unlimited_leave_${index}" onclick="changeInputUI(['input_lsum_per_day_${index}', 'input_lsum_per_hour_${index}', 'input_lsum_per_minute_${index}', 'input_lsum_remain_day_${index}', 'input_lsum_remain_hour_${index}', 'input_lsum_remain_minute_${index}'], this.checked);" >
                    <label for="set_unlimited_leave_${index}" class="form-label">ไม่จำกัด</label>`
                ]).draw();
            });
        }
        

        // Initialize tooltips for new buttons
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Make AJAX request to fetch updated data
        // await $.ajax({url: '<?php// site_url() . "/" . $controller_dir ?>' + "leaves_user/get_leave_summary_datatable/",
        //     type: 'POST',
        //     data: {
        //         lsum_ps_id,
        //         budget_year

        //     },
        //     success: function(response) {
        //         response = JSON.parse(response);
        //         console.log('response is: ', response);

        //         // Clear existing DataTable data
        //         dataTable.clear().draw();

        //         // // Update summary count
        //         // $("#leave_summary_table_row_amount").text(data.result.length);

        //         // index = 1;
        //         // data.result.forEach((item, index) => {
                    
        //         //     // button = `
        //         //     //     <div class="text-center option">
        //         //     //         <button class="btn btn-warning" onclick="window.location.href='<?php// echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/<?php// echo 1 ?>'"><i class="bi-pencil-square"></i></button>
        //         //     //     </div>
        //         //     // `;

        //         //     button = `
        //         //         <div class="text-center option">
        //         //             <button class="btn btn-warning" onclick="window.location.href='<?php //echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/?select_budget_year=${select_budget_year}&user_id=${item['T1.pos_ps_id']}'"><i class="bi-pencil-square"></i></button>
        //         //         </div>
        //         //     `;

                    

        //         //     // Add new row to DataTable
        //         //     dataTable.row.add([
        //         //             ++index,
        //         //             (`${item.ps_fname} ${item.ps_lname}`) ,
        //         //             item.hire_abbr,
        //         //             item.detail,
        //         //             (item.hire_type == 1) ? "เต็มเวลา" : ((item.hire_type == 2) ? "บางเวลา" : "ไม่มีข้อมูล"),
        //         //             checkData(item.final_found),
        //         //             calWorkAge(item.final_found, item.work_experience_days),
        //         //             checkDateCalType(item.lsum_date_cal_type),
        //         //             // checkDataShowDash(item.pos_work_start_date),
        //         //             checkDataShowDash(item.pos_work_start_date),
        //         //             displayEndDateCal(item.lsum_date_cal_type, item.lsum_end_date_cal, Number(select_budget_year)),
        //         //             // item.lsum_year,
        //         //             button
        //         //         ]).draw();
        //         // });

        //         // Initialize tooltips for new buttons
        //         $('[data-bs-toggle="tooltip"]').tooltip();
        //     },
        //     error: function(xhr, status, error) {
        //         // Handle errors
        //         dialog_error({
        //             'header': text_toast_default_error_header,
        //             'body': text_toast_default_error_body
        //         });
        //     }
        // });

        takeCheckIsSettedUnlimited();
    }

    // cal lsum_num
    function calLsumNum(sum_minutes_param) {
            let sum_minutes = sum_minutes_param;
            let day;
            let hour;
            let min;

            if (sum_minutes > 0) {

                let oneDayUnit = 480; //480 min
                let oneHourUnit = 60; //60 min

                day = Math.floor(sum_minutes / (60 * 8)); // 1hr = 60 min, 1 day = 8hr
                sum_minutes -= oneDayUnit * day;


                hour = Math.floor(sum_minutes / 60); // 1hr = 60 min, 1 day = 8hr
                sum_minutes -= oneHourUnit * hour;

                min = sum_minutes;

            } else {
                day = 0;
                hour = 0;
                min = 0;
            }

            return [day, hour, min];

        }

    function convertToMinutes(item) {
        // console.log(item);
        // แปลงวันเป็นนาที (1 วัน = 8 * 60 = 480 นาที)
        let daysInMinutes = (item.lsum_per_day || 0) * 8 * 60;
        let hoursInMinutes = (item.lsum_per_hour || 0) * 60;   // ชั่วโมงเป็นนาที
        let minutes = item.lsum_per_minute || 0;               // นาทีปกติ

        // รวมจำนวนนาทีทั้งหมด
        let totalMinutes = daysInMinutes + hoursInMinutes + minutes;

        return totalMinutes;
    }

    function incorrectDateDetector() {
        // refreshDateCalResult();
        //console.log('(from incorrectDateDetector), dateCalResult: ', dateCalResult);
        if ($('#select_date_cal_type').val() == "custom_year") {
            if (dateCalResult < 0) {
                datePickerResetor();
            }
        }
    }

    function datePickerResetor() {
        if ($('#select_date_cal_type').val() == "custom_year") {
            // let value = $("#select_end_date_cal").val();
            // if(value.length < 1) {

            // console.log('##### (datePickerResetor): ', dateCalResult);
            // if(this.dateCalResult?.length < 0) {
            // if(dateCalResult?.length < 0) {
            if(dateCalResult < 0) {
                
                // force set thai year 
                
                $("#select_end_date_cal").flatpickr({
                    dateFormat: 'd/m/Y',
                    locale: 'th',
                    defaultDate: new Date(`${Number(<?php echo $budget_year; ?>) + 543}-01-01`)
                });

                // reset
                $("#select_end_date_cal").val(null);

                $("#end_date_display").val(`กรุณาเลือกวันที่`);

                // refreshDateCalResult();
                // $("#work_age_cal_result_display").html(calWorkAge("NO", dateCalResult));
                $("#work_age_cal_result_display").text(calWorkAge("NO", dateCalResult));
            }
        }
        //console.log('lastest $("#select_end_date_cal").val: ', $("#select_end_date_cal").val());
        //console.log('===================');
        //console.log(`dateCalResult: ${dateCalResult} (from datePickerResetor())`);
    }

    function setDateCalResult(value) {
        // console.log('accessable');
        // console.log('accessable , this.data: ', this.data);
        // console.log('accessable, dataLocalVar: ', dataLocalVar);
        if (value === undefined) {
            value = null;
        }
        // this.dateCalResult = value;
        dateCalResult = value;
        // console.log('accessable , this.data: ', this.data);
    }

    function getDateCalResult() {
        // return this.dateCalResult;
        return dateCalResult;
        // console.log('accessable , this.data: ', this.data);
    }

    async function refreshDateCalResult() {
        //console.log('refreshDateCalResult() => targetIndex: ', targetIndex);
        let start_date_cal = emptyToNull(this.data?.base_info.pos_work_start_date_with_dp_id[targetIndex].pos_work_start_date);

        let end_date_cal = exe_end_date_cal();
        selected_end_date_cal = end_date_cal;

        //console.log('start_date_cal', start_date_cal);
        //console.log('end_date_cal', end_date_cal);
        
        function exe_end_date_cal() {
            if ($('#select_date_cal_type').val() == "custom_year") {
                let end_date_cal = $('#select_end_date_cal').val();
                if (end_date_cal?.length > 0) {
                    return emptyToNull(`${(Number(end_date_cal.substring(6, 10)) - 543)}-${end_date_cal.substring(3, 5)}-${end_date_cal.substring(0, 2)}`);
                } else {
                    return null;
                }

                // if (data?.target_user_leave_summary[0].final_found == "NO") {
                //     return null;
                // } else {    // final_found == "YES"
                //     return 
                // }

                // ถ้ามีข้อมูล ต้องดึง end_date_cal ใน db มาใช้
                
            } else if ($('#select_date_cal_type').val() == "carlendar_year") {
                return emptyToNull(`<?php echo $budget_year; ?>-01-01`);
            } else {
                return null;
            }
        }

        // Make AJAX request to fetch updated data
        await $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir ?>' + "leaves_user/get_refreshed_date_cal_result/",
            type: 'POST',
            data: {
                start_date_cal,
                end_date_cal

            },
            success: function(response) {
                //console.log('response: (from function refreshDateCalResult())');
                response = JSON.parse(response);
                response = response[0];
                //console.log(response);
                key = `${Object.keys(response)[0]}`;
                //console.log(key);
                //console.log(response[key]);

                result = response[key];

                if (result !== null) {
                    // $("#work_age_cal_result_display").html(calWorkAge("YES", result));
                    $("#work_age_cal_result_display").text(calWorkAge("YES", result));
                } else {
                    // $("#work_age_cal_result_display").html(calWorkAge("NO", result));
                    $("#work_age_cal_result_display").text(calWorkAge("NO", result));
                }

                // console.log(`!!!!!!!!!!!!!!!!!!!!!!!!!!!!! this.dateCalResult: ${this.dateCalResult}`); // don't use this command
                setDateCalResult(result);
                //console.log(`!!!!!!!!!!!!!!!!!!!!!!!!!!!!! result: ${result}`);
                // console.log(`!!!!!!!!!!!!!!!!!!!!!!!!!!!!! this.dateCalResult: ${this.dateCalResult}`); // don't use this command
                //console.log(`!!!!!!!!!!!!!!!!!!!!!!!!!!!!! dateCalResult: ${dateCalResult}`);
                //console.log(`!!!!!!!!!!!!!!!!!!!!!!!!!!!!! getDateCalResult: ${getDateCalResult()}`);
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

    function setData(dataLocalVar) {
        // console.log('accessable');
        // console.log('accessable , this.data: ', this.data);
        // console.log('accessable, dataLocalVar: ', dataLocalVar);
        this.data = dataLocalVar;
        // console.log('accessable , this.data: ', this.data);
    }

    function getFinalFound(){
       return this.data?.target_user_leave_summary[0].final_found;
    }

    function getLsumId(){
       return this.data?.target_user_leave_summary[0].lsum_id;
    }

    function getPosPsId(){
       return this.data?.target_user_leave_summary[0].pos_ps_id;
    }

    //Function to update DataTable based on select dropdown values
    async function getData() {
        //console.log('getData() run');

        // Make AJAX request to fetch updated data
        await $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir ?>' + "leaves_user/get_data_for_edit_page/",
            type: 'POST',
            data: {
                budget_year: <?php echo $budget_year; ?>,
                user_id: <?php echo $user_id; ?>
            },
            success: async function(response) {
                // data = response;
                
                // console.log('response: ', response);
                dataLocalVar = JSON.parse(response);
                // console.log('data: ', dataLocalVar);

                // this.data = dataLocalVar;
                // console.log('this.data: ', this.data);

                // data = dataLocalVar;
                // console.log('data: ', data);
                setData(dataLocalVar);

                // find data index of target dp_id
                let targetIndexLocalVar = dataLocalVar?.base_info.pos_work_start_date_with_dp_id.findIndex((item) => {
                    return item.pos_dp_id == $('#select_dp_id').val();
                });
                //console.log(`findIndex Result: (index: ${targetIndexLocalVar})`, dataLocalVar?.base_info.pos_work_start_date_with_dp_id[targetIndexLocalVar]);
                targetIndex = targetIndexLocalVar;
                // checkData(data);

                // $("#final_data_display").html(`${checkData(dataLocalVar?.target_user_leave_summary[0].final_found)}`);

                // final_data_display_new_raw_element = document.createElement(checkData(dataLocalVar?.target_user_leave_summary[0].final_found))
                // final_data_display_new_raw = checkData(dataLocalVar?.target_user_leave_summary[0].final_found); 
                // console.log(final_data_display_new_raw);
                // final_data_display_new_value = document.createElement((final_data_display_new_raw));
                // console.log(final_data_display_new_value);
                $("#final_data_display_new").text(checkData(dataLocalVar?.target_user_leave_summary[0].final_found)+updatedDateDisplayText);
                
                if(dataLocalVar?.target_user_leave_summary[0].final_found == "YES") {
                    $("#final_data_display_new").removeClass("bg-warning");
                    $("#final_data_display_new").removeClass("bg-success");
                    $("#final_data_display_new").addClass("bg-success");
                } else {
                    $("#final_data_display_new").removeClass("bg-success");
                    $("#final_data_display_new").removeClass("bg-warning");
                    $("#final_data_display_new").addClass("bg-warning");
                }

                // console.log('A:',checkData(dataLocalVar?.target_user_leave_summary[0].final_found));

                // document.getElementById("final_data_display_new").value = `${checkData(dataLocalVar?.target_user_leave_summary[0].final_found)}`; 
                // $("#start_date_display").html(`${textIsEmpty(dataLocalVar?.base_info.pos_work_start_date_with_dp_id[targetIndex].pos_work_start_date, "วันเริ่มงาน")}`);
                $("#start_date_display").val(`${textIsEmpty(dataLocalVar?.base_info.pos_work_start_date_with_dp_id[targetIndex].pos_work_start_date, "วันเริ่มงาน")}`);
                
                selected_start_date_by_dp_id = dataLocalVar?.base_info.pos_work_start_date_with_dp_id[targetIndex].pos_work_start_date;

                // force set thai year (ui)
                if ($('#select_date_cal_type').val() == "custom_year") {
                    let value = $("#select_end_date_cal").val();
                    if(value.length < 1) {
                        
                        $("#select_end_date_cal").flatpickr({
                            dateFormat: 'd/m/Y',
                            locale: 'th',
                            defaultDate: new Date(`${Number(<?php echo $budget_year; ?>) + 543}-01-01`)
                        });

                        // reset
                        $("#select_end_date_cal").val(null);

                        $("#end_date_display").val(`กรุณาเลือกวันที่`);
                        
                    } else {
                        $("#end_date_display").val(`${value}`);
                    }
                } else {
                    $("#end_date_display").val(convertToThaiDateDisplayFormat(`${<?php echo $budget_year; ?>}-01-01`));
                }
                
                // $("#work_age_cal_result_display").html(`-`);
                $("#work_age_cal_result_display").text(`-`);
                

                $("#ps_name_display").html(`${dataLocalVar?.target_user_leave_summary[0].pf_name}${dataLocalVar?.target_user_leave_summary[0].ps_fname} ${dataLocalVar?.target_user_leave_summary[0].ps_lname}`);
                $("#hire_abbr_display").html(`${dataLocalVar?.base_info.pos_work_start_date_with_dp_id[targetIndex].hire_abbr}`);
                $("#detail_display").html(`${dataLocalVar?.base_info.pos_work_start_date_with_dp_id[targetIndex].detail}`);
                
                //console.log('work from here, finalFound: ', getFinalFound());
                //console.log('work from here, dateCalResult: ', dateCalResult);
                // $("#work_age_display").html(calWorkAge(`<?php// echo $target_user_leave_summary['final_found'] ?>`, <?php// echo $target_user_leave_summary['work_experience_days'] ?>, "ไม่มีข้อมูล") + ' (ข้อมูลที่ได้บันทึกไว้จากการตั้งค่าการคำนวณอายุงานครั้งล่าสุด)');
                // $("#work_age_display").html(calWorkAge(getFinalFound(), dateCalResult, "ไม่มีข้อมูล") + ' (ข้อมูลที่ได้บันทึกไว้จากการตั้งค่าการคำนวณอายุงานครั้งล่าสุด)');
                
                // $("#work_age_display").html(calWorkAge(getFinalFound(), dateCalResultFromDb, "ไม่มีข้อมูล") + ' (ข้อมูลที่ได้บันทึกไว้จากการตั้งค่าการคำนวณอายุงานครั้งล่าสุด)');
                $("#work_age_display").text("อายุงาน " + calWorkAge(getFinalFound(), dateCalResultFromDb, "ไม่มีข้อมูล") + ' (ข้อมูลที่ได้บันทึกไว้จากการตั้งค่าการคำนวณอายุงานครั้งล่าสุด)');
                $("#work_age_display").text("อายุงาน " + calWorkAge(getFinalFound(), dateCalResultFromDb, "ไม่มีข้อมูล") + ' (ข้อมูลที่ได้บันทึกไว้จากการตั้งค่าการคำนวณอายุงานครั้งล่าสุด)');
                
                $("#budget_year_display").html(<?php echo $budget_year + 543; ?>);

                

                // call refreshDateCalResult()
                await refreshDateCalResult();

                // initialAutoSelect();

                // document.getElementById("work_age_display").innerHTML = calWorkAge(`<?php// echo $target_user_leave_summary['final_found'] ?>`, <?php// echo $target_user_leave_summary['work_experience_days'] ?>);



                // Clear existing DataTable data
                // dataTable.clear().draw();

                // // // Update summary count
                // $("#leave_summary_table_row_amount").text(data?.result.length);

                // index = 1;
                // data?.result.forEach((item, index) => {
                    
                //     // button = `
                //     //     <div class="text-center option">
                //     //         <button class="btn btn-warning" onclick="window.location.href='<?php// echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/<?php// echo 1 ?>'"><i class="bi-pencil-square"></i></button>
                //     //     </div>
                //     // `;

                //     button = `
                //         <div class="text-center option">
                //             <button class="btn btn-warning" onclick="window.location.href='<?php // echo base_url() ?>index.php/hr/leaves/leaves_user/leaves_user_edit/?select_budget_year=${select_budget_year}&user_id=${item['T1.pos_ps_id']}'"><i class="bi-pencil-square"></i></button>
                //         </div>
                //     `;

                    

                //     // Add new row to DataTable
                //     dataTable.row.add([
                //             ++index,
                //             (`${item.ps_fname} ${item.ps_lname}`) ,
                //             item.hire_abbr,
                //             item.detail,
                //             checkData(item.final_found),
                //             calWorkAge(item.final_found, item.work_experience_days),
                //             checkDateCalType(item.lsum_date_cal_type),
                //             // checkDataShowDash(item.pos_work_start_date),
                //             checkDataShowDash(item.pos_work_start_date),
                //             displayEndDateCal(item.lsum_date_cal_type, item.lsum_end_date_cal, Number(select_budget_year)),
                //             // item.lsum_year,
                //             button
                //         ]).draw();
                // });

                // // Initialize tooltips for new buttons
                // $('[data-bs-toggle="tooltip"]').tooltip();
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