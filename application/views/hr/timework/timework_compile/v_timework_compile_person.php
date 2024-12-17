<!-- กำหนดสไตล์ของส่วนต่าง ๆ เช่น timeline และ sidebar title -->
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
    .btn-custom {
        margin: 5px;
        padding: 10px 20px;
        border-radius: 5px;
    }
    .space-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .dashboard .filter {
        position: absolute;
        right: 0px;
        top: 15px;
    }
    .filterDetail {
        right: 20px !important;
    }

    th, td{
        align-content: center;
    }

    .badge.bg-purple {
        background-color: #6f42c1; /* สีม่วง Bootstrap-like */
        color: #ffffff; /* ตัวอักษรสีขาว */
    }
    td.bg-purple{
        background-color: #6f42c1; /* สีม่วง Bootstrap-like */
        color: #ffffff; /* ตัวอักษรสีขาว */
    }


</style>


<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            <!-- profile data / contacts -->
            <div class="section profile">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-body profile-card">
                        <div class="d-flex flex-column align-items-center">
                            <img id="profile_picture" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . ($row_profile->psd_picture != '' ? $row_profile->psd_picture : "default.png")); ?>">
                            <h2 class="mb-3 mt-4"><?php echo $row_profile->pf_name_abbr . $row_profile->ps_fname . " " . $row_profile->ps_lname; ?></h2>
                        </div>
                        <div class="card card-dashed">
                            <?php
                            if (count($person_department_topic) == 1) {
                                $head = $person_department_topic[0];
                                $row = $person_department_detail[0];
                            ?>
                                <div class="text-center mt-4">
                                    <h3 class="mb-3"><?php echo $head->dp_name_th; ?></h3>
                                </div>
                                <div class="card-body pb-2">
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
                                                                // หาก stde_name_th มีแค่ตัวเดียว
                                                                echo '<ul class="mb-0"><li>' . $position2[$stde_admin['stdp_po_id']-1] . $stde_admin['stde_name_th'][0] . '</li></ul>';
                                                            } else {
                                                                // หาก stde_name_th มีหลายตัว
                                                                echo '<ul class="mb-0"><li>' . $position[$stde_admin['stdp_po_id']] . '<br>';
                                                                $names_list = implode('<br> - ', $stde_admin['stde_name_th']);
                                                                echo '- ' . $names_list . '</li></ul>';
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo '-'; // แสดง - ถ้าไม่มีข้อมูล
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
                            <?php
                            } else {
                            ?>
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
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-hospital font-30"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">ตำแหน่งในการบริหาร</h5>
                                                        <div> <?php
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
                                                                                // หาก stde_name_th มีแค่ตัวเดียว
                                                                                echo '<ul class="mb-0"><li>' . $position2[$stde_admin['stdp_po_id'] - 1] . $stde_admin['stde_name_th'][0] . '</li></ul>';
                                                                            } else {
                                                                                // หาก stde_name_th มีหลายตัว
                                                                                echo '<ul class="mb-0"><li>' . $position[$stde_admin['stdp_po_id']] . '<br>';
                                                                                $names_list = implode('<br> - ', $stde_admin['stde_name_th']);
                                                                                echo '- ' . $names_list . '</li></ul>';
                                                                            }
                                                                        }
                                                                    }
                                                                } else {
                                                                    echo '-'; // แสดง - ถ้าไม่มีข้อมูล
                                                                }
                                                                ?></div>
                                                    </div>
                                                </div>
                                                <!-- <div class="d-flex align-items-start mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-h-square font-30"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted small mb-1">ตำแหน่งในการบริหาร</h5>
                                                        <div>
                                                            <?php
                                                            if (isset($row->admin_position) && $row->admin_position != "") {
                                                                $admin_names = [];
                                                                foreach (json_decode($row->admin_position) as $admin) {
                                                                    if (!empty($admin->admin_name)) {
                                                                        $admin_names[] = $admin->admin_name;
                                                                    }
                                                                }
                                                                if (!empty($admin_names)) {
                                                                    echo implode('<br>', $admin_names);
                                                                } else {
                                                                    echo "-";
                                                                }
                                                            } else {
                                                                echo "-";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div> -->
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
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <!-- <div class="btn-option text-center">
                            <a class="btn btn-primary" href="../Personal_dashboard/generate_CV" target="_blank"> <i class="bi-dowload"></i> Download CV </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
          
            <div class="card">
                <div class="accordion">
                    <!-- Accordion สำหรับค้นหารายชื่อบุคลากร -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-search icon-menu"></i>ค้นหารายการประมวลผลการทำงาน
                            </button>
                        </h2>
                        <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <form class="row g-3" method="get">

                                    <!-- ช่วงวันที่ -->
                                    <div class="col-md-6">
                                        <label for="compile_date" class="form-label">ช่วงวันที่</label>
                                        <div class="input-group" id="compile_date" name="compile_date">
                                            <input type="text" class="form-control" name="compile_start_date" id="compile_start_date" value="">
                                            <span class="input-group-text">ถึง</span>
                                            <input type="text" class="form-control" name="compile_end_date" id="compile_end_date" value="">
                                        </div>
                                        
                                    </div>

                                    <!-- ช่วงวันที่ -->
                                    <div class="col-md-6">
                                        <label for="compile_status" class="form-label">สถานะการประมวลผล</label>
                                        <select class="select2" name="compile_status" id="compile_status">
                                            <option value="W" selected>รอดำเนินการ</option>
                                            <option value="Y">ประมวลผลแล้ว</option>
                                            <option value="P">คำนวณเงินแล้ว</option>
                                        </select>
                                    </div>
                                   
                
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="section dashboard">
                <div class="row">
                    <!-- Left side columns -->
                    <div class="col-lg-12">
                        <div class="row">
                            <!-- Work Plan Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card work-plan-card" style="color: #4154f1; background: #f6f6fe; border-bottom: 3px solid #4154f1;">
                                    <div class="filter filterDetail">
                                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggle_timework_plan_detail" data-card-type="all" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="pt-1 pb-3">แผนการทำงาน</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #4154f1; background: #e0e0ff;">
                                                <i class="bi bi-calendar4-event"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>30 วัน</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Work Plan Card -->

                            <!-- Attendance Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card attendance-card" style="color: #4154f1; background: #e0f8e9; border-bottom: 3px solid #2eca6a;">
                                    <div class="filter filterDetail">
                                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggle_attendance_detail" data-card-type="all" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="pt-1 pb-3">เข้างาน (สแกนนิ้ว)</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #2eca6a; background: #adf2c7;">
                                                <i class="bi bi-fingerprint"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>42 ครั้ง</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Attendance Card -->

                            <!-- OFF Days Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card off-days-card" style="color: #4154f1; background: #ffecdf; border-bottom: 3px solid #ff771d;">
                                    <div class="filter filterDetail">
                                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggle_holiday_detail" data-card-type="all" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="pt-1 pb-3">วันหยุด (OFF)</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #ff771d; background: #ffd6b9;">
                                                <i class="bi bi-calendar2-day"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>8 วัน</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End OFF Days Card -->

                            <!-- Leave Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card leave-card" style="color: #4154f1; background: #ffdcef; border-bottom: 3px solid #ff0089;">
                                    <div class="filter filterDetail">
                                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggle_leave_detail" data-card-type="all" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="pt-1 pb-3">การลา</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #ff0089; background: #ffbde1;">
                                                <i class="bi bi-journal-medical"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>4 รายการ</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Leave Card -->

                            <!-- Schedule Change Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card schedule-change-card" style="color: #4154f1; background: #e0f2f2; border-bottom: 3px solid #0e809f;">
                                    <div class="filter filterDetail">
                                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggle_timework_change_detail" data-card-type="all" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="pt-1 pb-3">เปลี่ยนตารางการทำงาน</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #0e809f; background: #bfe5e5;">
                                                <i class="bi bi-calendar2-week"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>5 วัน</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Schedule Change Card -->

                            <!-- HRD Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card hrd-card" style="color: #4154f1; background: #efefef; border-bottom: 3px solid #3b393a;">
                                    <div class="filter filterDetail">
                                        <a class="bi-search btn btn-outline-primary p-1 ps-2 pe-2 font-12 toggle_hrd_detail" data-card-type="all" data-toggle="tooltip" data-placement="top" aria-label="คลิกเพื่อดูรายละเอียด" data-bs-original-title="คลิกเพื่อดูรายละเอียด"></a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="pt-1 pb-3">พัฒนาตนเอง (HRD)</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #3b393a; background: #cccbcb;">
                                                <i class="bi bi-box-arrow-up-left"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>15 รายการ</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End HRD Card -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>     
</div>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="accordion-body">
                            <h5 class="pt-1 pb-3">ชั่วโมงการทำงาน</h5>

                            <div class="row" style="border-bottom: 1px dashed #607D8B; padding-bottom: 16px;">
                                <div class="col-lg-6 label ">แผนการทำงาน</div>
                                <div class="col-lg-6">200 ชั่วโมง</div>
                            </div>
                            <div class="row" style="padding-top: 16px;">
                                <div class="col-lg-6 label ">ทำงานจริง</div>
                                <div class="col-lg-6">180 ชั่วโมง</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="accordion-body">
                            <h5 class="pt-1 pb-3">ทำงานล่วงเวลา (OT)</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-muted small mb-1">ในเวลา</h5>
                                    12 นาที
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-muted small mb-1">นอกเวลา</h5>
                                    20 นาที
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h5 class="text-muted small mb-1">วันหยุดประจำสัปดาห์</h5>
                                    0 นาที
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-muted small mb-1">วันหยุดปฏิทิน</h5>
                                    480 นาที
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="accordion-body">
                            <h5 class="pt-1 pb-3">สาย/ขาดงาน</h5>

                            <div class="row" style="border-bottom: 1px dashed #607D8B; padding-bottom: 16px;">
                                <div class="col-lg-6 label ">สาย</div>
                                <div class="col-lg-6">30 นาที</div>
                            </div>
                            <div class="row" style="padding-top: 16px;">
                                <div class="col-lg-6 label ">ขาดงาน</div>
                                <div class="col-lg-6">1 วัน</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">        
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button accordion-button-table" type="button">
                                <i class="bi-calendar icon-menu"></i><span> รายการวันประมวลผลการทำงาน
                            </button>
                        </h2>
                            
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table_timework_compile_main">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="3">วันที่</th>
                                                <th class="text-center" rowspan="3">แผน</th>
                                                <th class="text-center" rowspan="3">เข้างาน</th>
                                                <th class="text-center" rowspan="3">สาย</th>
                                                <th class="text-center" rowspan="3">ออกงาน</th>
                                                <th class="text-center" rowspan="3">OT</th>
                                                <th class="text-center" colspan="6">รวมชั่วโมงการทำงาน</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center" rowspan="2">ปกติ<br>(ชั่วโมง)</th>
                                                <th class="text-center" rowspan="2">สาย<br>(นาที)</th>
                                                <th class="text-center" colspan="4">OT (นาที)</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">ในเวลา</th>
                                                <th class="text-center">นอกเวลา</th>
                                                <th class="text-center">วันหยุดประจำสัปดาห์</th>
                                                <th class="text-center">วันหยุดตามประเพณี</th>
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
            </div>
        </div>
    </div>
    
</div>
<script>
    document.getElementById('compile_start_date').addEventListener('change', generateTableData);
    document.getElementById('compile_end_date').addEventListener('change', generateTableData);


    function generateTableData() {
        const startDate = document.getElementById('compile_start_date').value;
        const endDate = document.getElementById('compile_end_date').value;
        if (!startDate || !endDate) return;

        const tableBody = document.querySelector('#table_timework_compile_main tbody');
        tableBody.innerHTML = '';

        function calculateTimeDifference(actual, scheduled) {
            if (!actual || !scheduled) return { diffMinutes: 0, status: "none" };
            const [ah, am] = actual.split(":").map(Number);
            const [sh, sm] = scheduled.split(":").map(Number);
            const actualMinutes = ah * 60 + am, scheduledMinutes = sh * 60 + sm;
            let diff = actualMinutes - scheduledMinutes;
            if (diff < -720) diff += 1440;
            if (diff > 720) diff -= 1440;
            return { diffMinutes: Math.abs(diff), status: diff > 0 ? "late" : "early" };
        }

        function renderBadge(diffResult) {
            if (diffResult.diffMinutes === 0 || diffResult.status === "none") return "";
            const badgeColor = diffResult.status === "late" ? "bg-danger" : "bg-success";
            const sign = diffResult.status === "late" ? "-" : "+";
            return `<span class="badge rounded-pill ${badgeColor}">${sign} ${String(diffResult.diffMinutes).padStart(2, "0")}:00</span>`;
        }

        function checkWorkStatus(shift) {
            if (shift.leaveType) {
                return `<span class="badge bg-warning">ลา (${shift.leaveType})</span>`;
            }
            if (!shift.timestamps || shift.timestamps.length === 0) {
                return "<span class='badge bg-danger'>ขาดงาน</span>";
            }
            if (shift.isWeekend || shift.isHoliday) {
                return `<span class="badge bg-purple">OT (${shift.isWeekend ? 'สุดสัปดาห์' : 'วันหยุด'})</span>`;
            }
            return "<span class='badge bg-success'>มาทำงาน</span>";
        }


        function getInOutStatus(shift, type) {
            if (shift.leaveType) {
                return type === 'in' ? shift.leaveStart || "ลาเต็มวัน" : shift.leaveEnd || "ลาเต็มวัน";
            }
            if (!shift.timestamps || shift.timestamps.length === 0) {
                return "<span class='badge bg-danger'>ขาดงาน</span>";
            }
            return shift.timestamps[type === 'in' ? 0 : 1] || "-";
        }


        function checkWorkTime(shift) {
            if (shift.leaveType) {
                return shift.leaveStart && shift.leaveEnd
                    ? `<span class='badge bg-warning'>${shift.leaveStart} - ${shift.leaveEnd}</span>`
                    : "<span class='badge bg-warning'>เต็มวัน</span>";
            }
            if (!shift.timestamps) return "<span class='badge bg-danger'>เต็มวัน</span>";
            // if (shift.isWeekend || shift.isHoliday) return "<span class='badge bg-purple'>วันหยุดประจำสัปดาห์ (OFF)</span>";
            return `<span class='badge bg-primary'>${shift.scheduledIn} - ${shift.scheduledOut}</span>`;
        }

        function checkWorkDate(shifts) {
            console.log(shifts.isCalendar);
            if (shifts.isCalendar){
                
                return "<span class='badge bg-purple'>" + shifts.calendarName + "</span>";
            }
            else{
                return "";
            }
          
        }


        const workData = [
                // 1. ทำงานปกติ (กะเช้า)
                { date: "01/10/2023", plan: "เช้า", scheduledIn: "08:00", scheduledOut: "16:00", timestamps: ["08:00", "16:00"] },

                // 2. ทำงานปกติ (กะบ่าย)
                { date: "02/10/2023", plan: "บ่าย", scheduledIn: "17:00", scheduledOut: "00:00", timestamps: ["17:05", "23:55"] },

                // 3. ทำงาน OT ข้ามวัน
                { date: "03/10/2023", plan: "ดึก", scheduledIn: "00:00", scheduledOut: "08:00", timestamps: ["00:10", "09:00"], otInTime: 1.0 },

                // 4. เข้างานสาย และออกงานก่อน
                { date: "04/10/2023", plan: "เช้า", scheduledIn: "08:00", scheduledOut: "16:00", timestamps: ["08:15", "15:50"] },

                { date: "05/10/2023", plan: "เช้า", scheduledIn: "08:00", scheduledOut: "16:00", timestamps: ["08:15", "15:50"], isCalendar: true, calendarName: "วันขึ้นปีใหม่" },

                // 5. ทำงานวันหยุด (สุดสัปดาห์)
                { date: "07/10/2023", plan: "เช้า", scheduledIn: "08:00", scheduledOut: "16:00", timestamps: ["08:00", "16:30"], isWeekend: true, otInTime: 0.5 },

                // 6. ทำงานวันหยุดนักขัตฤกษ์
                { date: "13/10/2023", plan: "เช้า", scheduledIn: "08:00", scheduledOut: "16:00", timestamps: ["08:05", "17:00"], isHoliday: true, otInTime: 1.0 },

                // 7. ขาดงาน
                { date: "14/10/2023", plan: "เช้า", scheduledIn: "08:00", scheduledOut: "16:00", timestamps: [] },


                // 8. ลาป่วยเต็มวัน
                { date: "15/10/2023", plan: "ลาป่วย", leaveType: "ลาป่วย" },

                // 9. ลาพักร้อนเต็มวัน
                { date: "16/10/2023", plan: "ลาพักร้อน", leaveType: "ลาพักร้อน" },

                // 10. ลากิจเต็มวัน
                { date: "17/10/2023", plan: "ลากิจ", leaveType: "ลากิจ" },

                // 11. ลารายชั่วโมง (เช้า)
                { date: "18/10/2023", plan: "ลาพักร้อน", leaveType: "ลาพักร้อน", leaveStart: "09:00", leaveEnd: "12:00" },

                // 12. ทำงาน 3 กะในวันเดียว (เช้า + บ่าย + ดึก)
                { date: "20/10/2023", plan: "เช้า", scheduledIn: "08:00", scheduledOut: "16:00", timestamps: ["07:30", "16:00"], otInTime: 8.0 },
                { date: "20/10/2023", plan: "บ่าย", scheduledIn: "17:00", scheduledOut: "00:00", timestamps: ["17:00", "00:10"], otInTime: 8.0 },
                { date: "20/10/2023", plan: "ดึก", scheduledIn: "00:00", scheduledOut: "08:00", timestamps: ["00:05", "08:05"], otInTime: 8.0 },

                // 13. ทำงานวันหยุดของตัวเอง (OT)
                { date: "21/10/2023", plan: "เช้า", scheduledIn: "08:00", scheduledOut: "16:00", timestamps: ["08:10", "16:40"], isWeekend: true, otInTime: 0.5 },
                { date: "21/10/2023", plan: "ลากิจ", leaveType: "ลากิจ" },

                // 14. ลาหยุด แต่ทำงานบางส่วน
                { date: "22/10/2023", plan: "ลาพักร้อน", leaveType: "ลาพักร้อนบางส่วน", leaveStart: "08:00", leaveEnd: "12:00", timestamps: ["08:30", "12:00"] },

                // 15. ขาดงาน โดยไม่แจ้งล่วงหน้า
                { date: "23/10/2023", plan: "ขาดงาน", leaveType: "ขาดงาน" },

                // 16. ทำ OT หลังเลิกงานปกติ
                { date: "24/10/2023", plan: "เช้า", scheduledIn: "08:00", scheduledOut: "16:00", timestamps: ["08:00", "18:00"], otInTime: 2.0 },

                // 17. ทำงานล่วงเวลาในวันหยุดนักขัตฤกษ์ (OT เต็มวัน)
                { date: "25/10/2023", plan: "เช้า", scheduledIn: "08:00", scheduledOut: "16:00", timestamps: ["08:00", "17:00"], isHoliday: true, otInTime: 1.0 },
            ];

        const groupedData = workData.reduce((acc, row) => {
            acc[row.date] = acc[row.date] || [];
            
            acc[row.date].push(row);
            return acc;
        }, {});

        for (const [date, shifts] of Object.entries(groupedData)) {
            const rowspanCount = shifts.length + 1;
            let dailyNormal = 0, dailyLate = 0, dailyInOT = 0, dailyOutOT = 0, dailyDayOff = 0, dailyOTCalendar = 0;
            console.log(shifts.isCalendar);

            let rowHTML = `<tr><td rowspan="${rowspanCount}" class="text-center align-middle">${date}<br>${checkWorkDate(shifts)}</td>`;

            shifts.forEach((shift, index) => {
                const inTimeResult = calculateTimeDifference(getInOutStatus(shift, 'in'), shift.scheduledIn);
                const outTimeResult = calculateTimeDifference(getInOutStatus(shift, 'out'), shift.scheduledOut);

                const normalHours = shift.timestamps ? 8.0 : 0.0;
                const lateMinutes = inTimeResult.status === "late" ? inTimeResult.diffMinutes : 0;

                const otInTime = shift.otInTime || 0.0;
                const otOutTime = shift.otOutTime || 0.0;
                const otDayOff = shift.otDayOff || 0.0;
                const otCalendar = shift.otCalendar || 0.0;

                // สะสมผลรวม
                dailyNormal += normalHours;
                dailyLate += lateMinutes;
                dailyInOT += otInTime;
                dailyOutOT += otOutTime;
                dailyDayOff += otDayOff;
                dailyOTCalendar += otCalendar;

                rowHTML += `
                    ${index > 0 ? '<tr>' : ''}
                    <td class="text-center">${shift.plan}<br>${checkWorkTime(shift)}</td>
                    <td class="text-center">${getInOutStatus(shift, 'in')}<br>${renderBadge(inTimeResult)}</td>
                    <td class="text-center align-middle">
                        ${shift.isLeave ? "-" : `<input type="number" class="form-control text-center" value="${lateMinutes}" min="0" step="1">`}
                    </td>
                    <td class="text-center">${getInOutStatus(shift, 'out')}<br>${renderBadge(outTimeResult)}</td>
                    <td class="text-center"></td>
                    <td class="text-center">${normalHours.toFixed(2)}</td>
                    <td class="text-center">${lateMinutes}</td>
                    <td class="text-center">${otInTime.toFixed(2)}</td>
                    <td class="text-center">${otOutTime.toFixed(2)}</td>
                    <td class="text-center">${otDayOff.toFixed(2)}</td>
                    <td class="text-center">${otCalendar.toFixed(2)}</td>
                </tr>`;
            });

            rowHTML += `
                <tr>
                    <td class="table-warning">Timestamp</td>
                    <td colspan="4" class="text-left table-warning">
                        ${shifts.flatMap(shift => shift.timestamps || []).map(time => `<span class="badge bg-secondary mx-1">${time}</span>`).join(" ")}
                    </td>

                    <td class="text-center bg-primary"><span class="badge bg-primary">${dailyNormal}</span></td>
                    <td class="text-center bg-danger"><span class="badge bg-danger">${dailyLate}</span></td>
                    <td class="text-center bg-purple"><span class="badge bg-purple">${dailyInOT}</span></td>
                    <td class="text-center bg-info"><span class="badge bg-info">${dailyOutOT}</span></td>
                    <td class="text-center bg-secondary"><span class="badge bg-secondary">${dailyDayOff}</span></td>
                    <td class="text-center bg-warning"><span class="badge bg-warning">${dailyOTCalendar}</span></td>
                </tr>`;

            tableBody.insertAdjacentHTML('beforeend', rowHTML);
        }
    }



    // Helper: Parse Thai date to JS Date
    function parseThaiDate(dateStr) {
        const [day, month, year] = dateStr.split('/').map(Number);
        return new Date(year - 543, month - 1, day);
    }

    // Helper: Format JS Date to Thai format
    function formatThaiDate(date) {
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = (date.getFullYear() + 543).toString();
        return `${day}/${month}/${year}`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#compile_start_date", {
            plugins: [
                new rangePlugin({
                    input: "#compile_end_date"
                })
            ],
            dateFormat: 'd/m/Y',
            locale: 'th',
            defaultDate: [
                new Date(new Date().getFullYear(), new Date().getMonth() - 1, 26), // วันที่ 26 ของเดือนก่อนหน้า
                new Date(new Date().getFullYear(), new Date().getMonth(), 25)     // วันที่ 25 ของเดือนปัจจุบัน
            ],
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
                    document.getElementById('compile_start_date').value = formatDateToThai(selectedDates[0]);
                }
                if (selectedDates[1]) {
                    document.getElementById('compile_end_date').value = formatDateToThai(selectedDates[1]);
                }
            },
            onMonthChange: function(selectedDates, dateStr, instance) {
                convertYearsToThai();
            },
            onYearChange: function(selectedDates, dateStr, instance) {
                convertYearsToThai();
            }
        });

        generateTableData();
        // document.getElementById('badge-complete-26112024').style.display = 'inline';

    });
</script>