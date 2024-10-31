<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<style>
    .card-header {
        background-color: #cfe2ff;
        border-color: #cfe2ff;
    }

    .card-tabs ul.nav-tabs {
        border-top-right-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
        border-top-left-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
    }

    .card-tabs li button.nav-link,
    .card-tabs .nav-item-left {
        padding: 14px 1.25rem;
    }

    .card-tabs .nav-tabs {
        font-weight: bold;
    }

    .card-tabs .card-body {
        padding: 0 1.25rem var(--bs-card-spacer-y) 1.25rem;
    }

    .card form button.accordion-button:not(.collapsed) {
        color: var(--bs-primary);
    }

    .card {
        margin-bottom: 15px;
    }

    .badge-number {
        position: absolute;
        top: 0;
        right: 0;
        transform: translate(0%, -50%);
    }

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


    .card-icon {
        font-size: 32px;
        line-height: 0;
        width: 70px;
        /* height: 70px; */
        flex-shrink: 0;
        flex-grow: 0;
    }

    .card-solid.border-primary-subtle {
        border: 2px dashed;
    }

    .small {
        font-size: 14px;
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

    .dataTable th {
        color: var(--tp-font-color);
        text-align: center !important;
    }

    .modal {
        color: #000;
    }
</style>
<!-- <div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span> จัดการข้อมูลพัฒนาบุคลากร</span><span class="badge bg-success">6</span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <div class="text-center"><img src="https://surateyehospital.com/wp-content/uploads/2023/01/S__64995330-e1674529006351.jpg" width="200px" height="200px"></div>
                            <b>ผู้ดำเนินการ : </b><?= $name ?> <br>
                            <b>ตำแหน่งในการบริหาร </b><?= $position ?><br><b> ตำแหน่งในสายงาน</b> <?= $affiliation ?> <br> <b> ตำแหน่งเฉพาะทาง</b> <?= $special ?><br><br>
                        </div>
                        <div class="col-md-4 ">
                            <b>ระหว่างวันที่ :</b>
                            <div class="input-group date input-daterange">
                                <input type="date" class="form-control" name="StartDate" id="StartDate" placeholder="" value="">
                                <span class="input-group-text">ถึง</span>
                                <input type="date" class="form-control" name="EndDate" id="EndDate" placeholder="" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <b>ประเภท :</b>
                            <select type="text" class="form-select select2"> </select>
                        </div>
                        <div class="col-md-4">
                            <b>ด้านการพัฒนา :</b>
                            <select type="text" class="form-select select2"> </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="card p-3">
                                    <div class="row">
                                        <div class="col-12"> <b>งบประมาณพัฒนาที่ใช้ไปทั้งหมด&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></div>
                                        <div class="col-6" style="color:#bb9f39;"><i class="bi bi-currency-dollar" style="font-size: 55px;"></i></div>
                                        <div class="col-6 text-end">
                                            <h1>0.00</h1>บาท
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card p-3">
                                    <div class="row">
                                        <div class="col-12"> <b>งบประมาณพัฒนาตามความต้องการของตนเองที่ได้รับ</b></div>
                                        <div class="col-6" style="color:#a00686;"><i class="bi bi-bar-chart" style="font-size: 55px;"></i></div>
                                        <div class="col-6 text-end">
                                            <h1>0.00</h1>บาท
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card p-3">
                                    <div class="row">
                                        <div class="col-12"> <b>งบประมาณพัฒนาตามความต้องการของตนเองที่ใช้ไป</b></div>
                                        <div class="col-6" style="color:#168214;"><i class="bi bi-cash" style="font-size: 55px;"></i></div>
                                        <div class="col-6 text-end">
                                            <h1>0.00</h1>บาท
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card p-3">
                                    <div class="row">
                                        <div class="col-12"> <b>งบประมาณพัฒนาตามความต้องการของตนเองคงเหลือ</b></div>
                                        <div class="col-6" style="color:#245dc1;"><i class="bi bi-cash" style="font-size: 55px;"></i></div>
                                        <div class="col-6 text-end">
                                            <h1>0.00</h1>บาท
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12 text-end"><button class="btn btn-secondary"><i class="bi bi-x-lg"></i> เคลียข้อมูล</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary"><i class="bi bi-search"></i> ค้นหา</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="col-md-12">
    <div class="row">
        <!-- <div class="col-md-3">
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
                                            $position = [];
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
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="card-icon me-3">
                                            <i class="bi-clipboard2-pulse font-34"></i>
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
                                                        <div><?php
                                                                // $position = ['', 'หัวหน้าฝ่าย', 'รองหัวหน้าฝ่าย', 'หัวหน้าแผนก', 'รองหัวหน้าแผนก', 'เจ้าหน้าที่'];
                                                                $position = [];
                                                                $position[] = '';
                                                                foreach ($base_structure_position as $stpo_key => $value) {
                                                                    $position[] = $value->stpo_name;
                                                                    $position2[] = $value->stpo_used;
                                                                }
                                                                // $position2 = ['', 'หัวหน้า', 'รองหัวหน้า', 'หัวหน้า', 'รองหัวหน้า', 'เจ้าหน้าที่'];
                                                                if (!empty($person_department_detail[$key]->stde_admin_position)) {

                                                                    foreach ($person_department_detail[$key]->stde_admin_position as $key2 => $stde_admin) {
                                                                        if ($stde_admin['stdp_po_id'] == 0) {
                                                                            echo '<ul class="mb-0"><li>' . implode('<br>', $stde_admin['stde_name_th']) . '</li></ul>';
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
        <!-- <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-clipboard2-pulse font-34"></i>
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
                        </div> -->
        <!-- <div class="btn-option text-center">
                            <a class="btn btn-primary" href="../Personal_dashboard/generate_CV" target="_blank"> <i class="bi-dowload"></i> Download CV </a>
                        </div> -->
        <!-- </div>
                </div>
            </div>
        </div>  -->
        <div class="col-12">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-search icon-menu"></i><span> ค้นหารายชื่อบุคลากร</span>
                            </button>
                        </h2>
                        <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <form class="row g-3" method="get">
                                    <div class="col-md-3">
                                        <label for="select_dp_id" class="form-label">ปีปฏิทิน</label>
                                        <select class="form-select  filter" onchange="filter_dev()" data-placeholder="-- กรุณาเลือกหน่วยงาน --" name="filter[]" id="filter_year">
                                            <?php
                                            foreach ($year_filter as $key => $row) {
                                            ?>
                                                <option value="<?php echo $row->year + 543; ?>" <?php echo ($key == 0 ? "selected" : ""); ?>><?php echo $row->year + 543; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="select_adline_id" class="form-label">รูปแบบการไปพัฒนาบุคลากร</label>
                                        <select class="form-select  filter" onchange="filter_dev()" name="filter[]" id="filter_org_type">
                                            <option value="all" selected>ทั้งหมด</option>
                                            <option value="1">ภายใน</option>
                                            <option value="2">ภายนอก</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="select_admin_id" class="form-label">ประเภทการพัฒนา</label>
                                        <select class="form-select  filter" onchange="filter_dev()" name="filter[]" id="filter_dev_type">
                                            <option value="all" selected>ทั้งหมด</option>
                                            <option value="1">พัฒนาตามความต้องการของตนเอง</option>
                                            <option value="2">พัฒนาตามนโยบายของโรงพยาบาลจักษุสุราษฏร์</option>
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="select_status_id" class="form-label">ประเภทการอบรม</label>
                                        <select class="form-select  filter" onchange="filter_dev()" class="form-select" id="filter_devb_type" name="filter[]">
                                            <option value="all" selected>ทั้งหมด</option>
                                            <?php foreach ($base_develop_type_list as $key => $value) : ?>
                                                <option value="<?= $value->devb_id ?>"><?= $value->devb_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <!-- <div class="col-12">
                            <button type="reset" class="btn btn-secondary float-start">เคลียร์ข้อมูล</button>
                            <button type="submit" class="btn btn-primary float-end">ค้นหา</button>
                        </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button accordion-button-table" type="button">
                                <i class="bi-server icon-menu"></i><span> ตารางข้อมูลพัฒนาบุลากร</span><span class="badge bg-success">6</span>
                            </button>
                        </h2>
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/develop/Develop_meeting/get_Develop_meeting_add'"><i class="bi-plus"></i> บันทึกข้อมูลพัฒนาบุคลกร </button>
                                    </div>
                                </div>
                                <div class="col-12">
                                </div>
                                <table class="table datatable" width="100%" id="itemList">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <div class="text-center" class="text-center">#</div>
                                            </th>
                                            <th scope="col" width="25%" class="text-center">เรื่องที่ไปร่วมประชุม/อบรม</th>
                                            <!-- <th scope="col">ตัวย่อภาษาไทย</th>-->
                                            <th scope="col">รูปแบบการไปพัฒนาบุคลากร</th>
                                            <th scope="col" class="text-center">ประเภทการพัฒนา</th>
                                            <th scope="col" class="text-center">ประเภท</th>
                                            <th scope="col" class="text-center">วันที่เข้าร่วม</th>
                                            <th scope="col" class="text-center" width="15%">ดำเนินการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($develop_list): ?>
                                            <?php
                                            $develop_type = ['พัฒนาตามความต้องการของตนเอง', 'พัฒนาตามนโยบายของโรงพยาบาลจักษุสุราษฏร์'];
                                            $service_type = ['ประชุม/อบรม/สัมมนา', 'ประชุมราชการ', 'นิเทศงาน', 'การอบรมหลักสูตระยะั้น', 'ศึกษาดูงาน'];
                                            ?>
                                            <?php foreach ($develop_list as $key => $value) : ?>
                                                <tr>
                                                    <td>
                                                        <div class="text-center">1</div>
                                                    </td>
                                                    <td><?= $value->devh_name_th ?></td>
                                                    <td><?= $develop_type[$value->dev_type - 1] ?> </td>
                                                    <td><?= $service_type[$value->dev_go_service_type - 1] ?></td>
                                                    <td><?= $value->dev_organized_type == 1 ? 'ภายใน' : 'ภายนอก'  ?></td>
                                                    <td><?= fullDateTH3($value->dev_start_date) ?></td>
                                                    <!-- <td><div class="text-center"></div></td> -->
                                                    <td>
                                                        <div class="text-center option">
                                                            <a class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/develop/Develop_meeting/get_Develop_meeting_edit/<?= $value->dev_id ?>'"><i class="bi bi-pencil"></i></a>
                                                            <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-file-arrow-down"></i></a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <form action="<?php echo base_url() ?>index.php/hr/develop/Develop_meeting/generate_pdf/<?= $value->dev_id ?>" method="GET" target="_blank" style="display: inline;">
                                                                        <button type="submit" class="dropdown-item" style="border: none; background: none;">
                                                                            <i class="bi bi-printer-fill"></i> พิมพ์
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                            <a class="btn btn-danger" href="#" onclick="delete_develop(<?= $value->dev_id ?>)"><i class="bi bi-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    function delete_develop(dev_id) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการลบข้อมูลพัฒนาบุคลากรนี้ ใช่หรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "post",
                    url: '<?php echo site_url() . "/" . $controller_dir; ?>delete_develop_form',
                    data: {
                        dev_id: dev_id
                    }
                }).done(function(data) {
                    data = JSON.parse(data)
                    if (data.data.status_response == 1) {
                        dialog_success({
                            'header': text_toast_default_success_header,
                            'body': 'ลบข้อมูลสำเร็จ'
                        });
                    } else {
                        dialog_error({
                            'header': text_toast_default_error_header,
                            'body': 'ลบข้อมูลไม่สำเร็จ'
                        });
                    }
                })
            }
        });
    }

    function filter_dev() {
        var filter = {};
        $('[name^="filter"]').each(function() {
            filter[this.id] = this.value;
        });

        $.ajax({
            method: "POST",
            url: '<?php echo site_url() . "/" . $controller_dir; ?>filter_dev_list',
            data: filter
        }).done(function(response) {
            const data = JSON.parse(response);
            result = data.data.result
            // Clear the existing table body
            $('#itemList tbody').empty();
            console.log(data.data);
            
            if (data.data.result.length > 0) {
                result.forEach((item, index) => {
                    // Generate new row HTML
                    const row = `
                    <tr>
                        <td><div class="text-center">${index + 1}</div></td>
                        <td>${item.devh_name_th}</td>
                        <td>${item.dev_type === 1 ? 'พัฒนาตามความต้องการของตนเอง' : 'พัฒนาตามนโยบายของโรงพยาบาลจักษุสุราษฏร์'}</td>
                        <td>${['ประชุม/อบรม/สัมมนา', 'ประชุมราชการ', 'นิเทศงาน', 'การอบรมหลักสูตรระยะสั้น', 'ศึกษาดูงาน'][item.dev_go_service_type - 1]}</td>
                        <td>${item.dev_organized_type == 1 ? 'ภายใน' : 'ภายนอก'}</td>
                        <td>${item.dev_start_date}</td>
                        <td>
                            <div class="text-center option">
                                <a class="btn btn-warning" onclick="window.location.href='<?php echo base_url() ?>index.php/hr/develop/Develop_meeting/get_Develop_meeting_edit/${item.dev_id}'"><i class="bi bi-pencil"></i></a>
                                <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-file-arrow-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="<?php echo base_url() ?>index.php/hr/develop/Develop_meeting/generate_pdf/${item.dev_id}" method="GET" target="_blank" style="display: inline;">
                                            <button type="submit" class="dropdown-item" style="border: none; background: none;">
                                                <i class="bi bi-printer-fill"></i> พิมพ์
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                                <a class="btn btn-danger" href="#" onclick="delete_develop(${item.dev_id})"><i class="bi bi-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                `;
                
                    // Append the new row to the table body
                    $('#itemList tbody').append(row);
                });
            } else {
                // Display a message if no data is available
                $('#itemList tbody').append('<tr><td colspan="7" class="text-center">ไม่พบข้อมูล</td></tr>');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error fetching data:", textStatus, errorThrown);
        });
    }
</script>