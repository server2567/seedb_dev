<style>
    #menu-tab button:hover:not(.active) {
        /* , a[data-bs-target="#work-timeline-modal"]:hover */
        /* , .card-body:hover > h5 */
        color: #717ff5;
        /* text-decoration: none; */
        transition: all 0.3s;
    }

    .card {
        margin-bottom: 15px;
    }

    #main {
        margin-left: 0px !important;
    }

    .nav-pills .nav-link {
        /* box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1); */
        border: 1px dashed #607D8B;
        color: #012970;
    }

    .card-dashed {
        box-shadow: none;
        border: 1px dashed #607D8B;
        color: #012970;
    }

    .card-solid {
        box-shadow: none;
    }

    /* .nav-pills .nav-link:not(.active) {
        background: 
    } */
    a.instagram i {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
    }

    .card-icon {
        font-size: 2rem;
    }

    .partial-name {
        width: 70%;
        text-align: left;
        border-bottom: 3px solid var(--bs-primary);
        line-height: 0.1em;
        margin: 10px 0 20px;
    }

    .partial-name span {
        background: #fff;
        padding: 0 10px;
    }

    a.bi-search {
        cursor: pointer;
    }

    .datatable .option button.btn {
        --bs-btn-padding-y: 0.25rem;
        --bs-btn-padding-x: 0.5rem;
        --bs-btn-font-size: 0.875rem;
        --bs-btn-border-radius: var(--bs-border-radius-sm);
        color: #fff;
    }

    .alert-success .form-select.form-control {
        margin-bottom: 0;
    }

    #profile_picture {
        margin-top: -115px;
        border-radius: 5px;
        max-width: 100%;
        max-height: 260px;
        object-fit: cover;
        height: auto;
        box-shadow: 0px 2px 20px rgba(1, 41, 112, 0.1);
    }


    .pulsating-circle {
        animation: pulse-ring 1.25s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }

    @keyframes pulse-ring {
        100% {
            transform: scale(2.5);
        }

        70%,
        100% {
            opacity: 0;
        }
    }

    .noti-card-license {
        right: 20px !important;
    }

    .card-license {
        transition: all 0.3s ease, transform 0.3s ease;
        /* เพิ่ม transition สำหรับ transform */
        opacity: 0;
        transform: translateY(40px);
        animation: fadeInUp 0.7s forwards;
        /* เพิ่มระยะเวลา animation */
        animation-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1);
        /* ทำให้ลื่นไหลมากขึ้น */
    }

    .card-license:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        transform: translateY(-5px);
        /* เพิ่ม effect เลื่อนขึ้นเมื่อ hover */
    }

    .text-orange {
        --bs-text-opacity: 1;
        color: #FF9800 !important;
    }
</style>
<main id="main" class="main">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Data / Contacts -->
            <div class="section profile">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-body profile-card">
                        <div class="d-flex flex-column align-items-center">
                            <img id="profile_picture" src="<?php echo site_url($this->config->item('hr_dir') . "getIcon?type=" . $this->config->item('hr_profile_dir') . "profile_picture&image=" . (!empty($profile_person['person_detail']->psd_picture) ? $profile_person['person_detail']->psd_picture : "default.png")); ?>">
                            <h2 class="mb-3 mt-4"><?php echo $profile_person['person_detail']->pf_name_abbr . $profile_person['person_detail']->ps_fname . " " . $profile_person['person_detail']->ps_lname; ?></h2>
                        </div>

                        <div class="card card-dashed">
                            <?php
                            if (count($profile_person['person_department_topic']) == 1) {
                                $head = $profile_person['person_department_topic'][0];
                                $row = $profile_person['person_department_detail'][0];
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
                                            <div><?php echo (!empty($row->pos_ps_code) ? $row->pos_ps_code : "-"); ?></div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="card-icon me-3">
                                            <i class="bi-person-square font-30"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-muted small mb-1">ประเภทบุคลากร</h5>
                                            <div><?php echo (!empty($row->hire_name) ? $row->hire_name : "-"); ?></div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <div class="card-icon me-3">
                                            <i class="bi-hospital font-30"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-muted small mb-1">ตำแหน่งในการบริหาร</h5>
                                            <div>
                                                <?php
                                                $position[] = '';
                                                foreach ($base_structure_position as $key => $value) {
                                                    $position[] = $value->stpo_name;
                                                    $position2[] = $value->stpo_used;
                                                }
                                                if (!empty($row->stde_admin_position)) {
                                                    foreach ($row->stde_admin_position as $key => $stde_admin) {
                                                        if ($stde_admin['stdp_po_id'] == 0) {
                                                            echo '<ul class="mb-0"><li>' . implode('<br>', array_map('htmlspecialchars', $stde_admin['stde_name_th'])) . '</li></ul>';
                                                        } else {
                                                            if (count($stde_admin['stde_name_th']) == 1) {
                                                                echo '<ul class="mb-0"><li>' . htmlspecialchars($position2[$stde_admin['stdp_po_id']-1]) . htmlspecialchars($stde_admin['stde_name_th'][0]) . '</li></ul>';
                                                            } else {
                                                                echo '<ul class="mb-0"><li>' . htmlspecialchars($position[$stde_admin['stdp_po_id']]) . '<br>- ' . implode('<br> - ', array_map('htmlspecialchars', $stde_admin['stde_name_th'])) . '</li></ul>';
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
                                            <i class="bi-clipboard2-pulse font-34"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-muted small mb-1">ตำแหน่งปฏิบัติงาน</h5>
                                            <div><?php echo (!empty($row->alp_name) ? $row->alp_name : "-"); ?></div>
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
                                                    if (!empty($row->spcl_position)) {
                                                        $spcl_positions = json_decode($row->spcl_position);
                                                        if (json_last_error() == JSON_ERROR_NONE && is_array($spcl_positions)) {
                                                            $spcl_names = array_map(fn($special) => $special->spcl_name ?? "-", $spcl_positions);
                                                            echo implode(', ', array_filter($spcl_names));
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
                                    <?php foreach ($profile_person['person_department_topic'] as $key => $row) { ?>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link <?php echo ($key == 0 ? "active" : ""); ?>" id="department-<?php echo htmlspecialchars($row->dp_id); ?>-tab" data-bs-toggle="tab" data-bs-target="#department-<?php echo htmlspecialchars($row->dp_id); ?>" type="button" role="tab" aria-controls="department-<?php echo htmlspecialchars($row->dp_id); ?>" aria-selected="<?php echo ($key == 0 ? "true" : "false"); ?>">
                                                <?php echo htmlspecialchars($row->dp_name_th); ?>
                                            </button>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <div class="tab-content" id="department-tab-content">
                                    <?php foreach ($profile_person['person_department_detail'] as $key => $row) { ?>
                                        <div class="tab-pane fade <?php echo ($key == 0 ? "show active" : ""); ?>" id="department-<?php echo htmlspecialchars($row->pos_dp_id); ?>" role="tabpanel" aria-labelledby="department-<?php echo htmlspecialchars($row->pos_dp_id); ?>-tab">
                                            <div class="card-body pb-2">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-credit-card-2-front font-30"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">รหัสประจำตัวบุคลากร</h5>
                                                        <div><?php echo (!empty($row->pos_ps_code) ? $row->pos_ps_code : "-"); ?></div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-person-square font-30"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">ประเภทบุคลากร</h5>
                                                        <div><?php echo (!empty($row->hire_name) ? $row->hire_name : "-"); ?></div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="card-icon me-3">
                                                        <i class="bi-hospital font-30"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">ตำแหน่งในการบริหาร</h5>
                                                        <div>
                                                            <?php
                                                            $position[] = '';
                                                            foreach ($base_structure_position as $key => $value) {
                                                                $position[] = $value->stpo_name;
                                                                $position2[] = $value->stpo_used;
                                                            }
                                                            if (!empty($row->stde_admin_position)) {
                                                                foreach ($row->stde_admin_position as $key => $stde_admin) {
                                                                    if ($stde_admin['stdp_po_id'] == 0) {
                                                                        echo '<ul class="mb-0"><li>' . implode('<br>', array_map('htmlspecialchars', $stde_admin['stde_name_th'])) . '</li></ul>';
                                                                    } else {
                                                                        if (count($stde_admin['stde_name_th']) == 1) {
                                                                            echo '<ul class="mb-0"><li>' . htmlspecialchars($position2[$stde_admin['stdp_po_id']-1]) . htmlspecialchars($stde_admin['stde_name_th'][0]) . '</li></ul>';
                                                                        } else {
                                                                            echo '<ul class="mb-0"><li>' . htmlspecialchars($position[$stde_admin['stdp_po_id']]) . '<br>- ' . implode('<br> - ', array_map('htmlspecialchars', $stde_admin['stde_name_th'])) . '</li></ul>';
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
                                                        <i class="bi-clipboard2-pulse font-34"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-muted small mb-1">ตำแหน่งปฏิบัติงาน</h5>
                                                        <div><?php echo (!empty($row->alp_name) ? $row->alp_name : "-"); ?></div>
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
                                                                if (!empty($row->spcl_position)) {
                                                                    $spcl_positions = json_decode($row->spcl_position);
                                                                    if (json_last_error() == JSON_ERROR_NONE && is_array($spcl_positions)) {
                                                                        $spcl_names = array_map(fn($special) => htmlspecialchars($special->spcl_name ?? "-"), $spcl_positions);
                                                                        echo implode(', ', array_filter($spcl_names));
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
                    </div>
                </div>
                <?php if ($profile_person['person_department_detail']) : ?>
                    <?php foreach ($profile_person['person_department_detail'] as $key => $row): ?>
                        <?php if ($row->pos_hire_id == 23) : ?>
                            <div class="card" style="min-height: 150px; max-height: 250px;">
                                <div class="card-body">
                                    <section class="section dashboard">
                                        <div class="row">
                                            <br>
                                            <?php $data['trail_info'] = ['start_date' => $row->pos_work_start_date, 'trail_date' => $row->pos_trial_day] ?>
                                            <?php $this->load->view($this->config->item('pd_dir') . 'resume/v_progress_bar', $data['trail_info']); ?>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($profile_person['person_license_list']) : ?>
                    <div class="card">
                        <div class="card-body">
                            <section class="section dashboard">
                                <div class="row">
                                    <?php foreach ($profile_person['person_license_list'] as $entry) {
                                        list($textColor, $iconStyle) = getCardColor($entry->licn_end_date);
                                        $formattedStartDate = abbreDate2($entry->licn_start_date);
                                        $formattedEndDate = ($entry->licn_end_date == "9999-12-31" ? "ตลอดชีพ" : abbreDate2($entry->licn_end_date));
                                    ?>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card info-card card-license">
                                                        <?php if ($textColor === 'text-danger') { ?>
                                                            <div class="filter noti-card-license pulsating-circle">
                                                                <i class="bi-bell-fill font-24" style="color: #dc3545;"></i>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="card-body">
                                                            <h5 class="card-title">ใบประกอบวิชาชีพ <span>| <?php echo htmlspecialchars($entry->voc_name); ?></span></h5>
                                                            <div class="d-flex align-items-center">
                                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" <?php echo $iconStyle; ?>>
                                                                    <i class="bx bx-plus-medical"></i>
                                                                </div>
                                                                <div class="ps-3">
                                                                    <h6><?php echo htmlspecialchars($entry->licn_code); ?></h6>
                                                                    <span class="<?php echo $textColor; ?> small pt-1 fw-bold">
                                                                        <?php
                                                                        if ($formattedEndDate != "ตลอดชีพ") {
                                                                            echo "หมดอายุวันที่ " . htmlspecialchars($formattedEndDate);
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </section>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- col-md-3 -->

        <div class="col-md-9" id="menu-tab">
            <div class="row">
                <!-- Profile Tab Navigation -->
                <div class="col-md-12">
                    <div class="card p-2 float-start" style="margin-bottom: 20px;">
                        <ul class="nav nav-pills nav-pills-2 nav-menu" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-column active" id="dashboard-calendar-tab" data-bs-toggle="tab" data-bs-target="#dashboard-calendar" type="button" role="tab">
                                    <i class="font-24 bi-calendar"></i>
                                    <div>ปฏิทินการปฏิบัติงาน</div>
                                </button>
                            </li>
                            <li class="nav-item ms-2" role="presentation">
                                <button class="nav-link d-column" id="dashboard-profile-tab" data-bs-toggle="tab" data-bs-target="#dashboard-profile" type="button" role="tab">
                                    <i class="font-24 bi-person-fill"></i>
                                    <div>ข้อมูลส่วนตัว</div>
                                </button>
                            </li>
                            <li class="nav-item ms-2" role="presentation">
                                <button class="nav-link d-column" id="dashboard-dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard-dashboard" type="button" role="tab">
                                    <i class="font-24 bi-bar-chart-line-fill"></i>
                                    <div>Personal Dashboard</div>
                                </button>
                            </li>
                            <li class="nav-item ms-2" role="presentation">
                                <button class="nav-link d-column" id="dashboard-new-tab" data-bs-toggle="tab" data-bs-target="#dashboard-new" type="button" role="tab">
                                    <i class="font-24 bi-newspaper"></i>
                                    <div>ข้อมูลข่าวสาร</div>
                                </button>
                            </li>
                            <?php if ($this->session->userdata('us_his_id') != 0) { ?>
                                <li class="nav-item ms-2" role="presentation">
                                    <button class="nav-link d-column" id="dashboard-website-tab" type="button" onclick="window.location.href='myapp://launch?us_his_id=<?php echo $this->session->userdata('us_his_id'); ?>';">
                                        <img src="<?php echo base_url(); ?>/assets/img/his_img.png" style="width: 28%;" alt="HIS Program Image" />
                                        <div>เปิดโปรแกรม HIS</div>
                                    </button>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <!-- Profile Tab Content -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="tab-content p-3">
                            <div class="tab-pane fade show active" id="dashboard-calendar" role="tabpanel" aria-labelledby="dashboard-calendar-tab">
                                <?php $this->load->view($this->config->item('pd_dir') . 'v_home_partial_calendar'); ?>
                            </div>
                            <div class="tab-pane fade" id="dashboard-profile" role="tabpanel" aria-labelledby="dashboard-profile-tab">
                                <?php $this->load->view($this->config->item('pd_dir') . 'v_home_partial_profile'); ?>
                            </div>
                            <div class="tab-pane fade" id="dashboard-dashboard" role="tabpanel" aria-labelledby="dashboard-dashboard-tab">
                                <?php $this->load->view($this->config->item('pd_dir') . 'v_home_partial_dashboard'); ?>
                            </div>
                            <div class="tab-pane fade" id="dashboard-new" role="tabpanel" aria-labelledby="dashboard-news-tab">
                                <?php $this->load->view($this->config->item('pd_dir') . 'v_home_partial_news', $news_d, $news_n); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- col-md-9 -->
    </div>
    <!-- row -->

    <!-- Modal Sections -->
    <div class="modal fade" id="preview_file_modal" style="width:100%; height:100%;" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="modal-iframe" style="width:100%; height: 70vh;" frameborder="0"></iframe>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <a href="#" class="btn btn-primary download_file_btn_modal" target="_blank" data-original-title="คลิกปุ่มเพื่อดาวน์โหลดไฟล์">ดาวน์โหลดไฟล์</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Modal System -->
    <div class="modal fade" id="modal-system" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-header-label-system"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-content">
                    <!-- Content loaded via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Modal -->
    <div class="modal fade bd-example-modal-xl" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document" id='modalSize'>
            <div class="modal-content">
                <div id="mainModalTitle" class="modal-header" style="background-color:#cfe2ff;">
                    <h5 class="modaltitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mainModalBody">
                    ...
                </div>
                <div id="mainModalFooter" class="modal-footer">
                    <div class="col-12">
                        <div class="row" style="float: right;">
                            <div class="col-10">
                                <div class="d-flex justify-content-end">
                                    <div class="form-check me-2">
                                        <input id="flexCheckDefault" class="form-check-input" type="checkbox" value="">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            ไม่แสดงการแจ้งเตือนวันนี้อีก
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2" style="float: right;">
                                <div id="ck"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Load Modal Detail Partial Views -->
    <?php
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_profile_address_his_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_profile_salary_his_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_work_work_timeline_detail_show');

    // Dashboard Tab
    // - Paragraph 1
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_dashboard_work_detail_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_dashboard_leave_detail_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_dashboard_learn_detail_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_dashboard_late_detail_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_dashboard_chart1_detail_show');

    // - Paragraph 2
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_dashboard_appointment_detail_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_dashboard_chart2_detail_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_dashboard_chart3_detail_show');

    // - Paragraph 3
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_dashboard_accessing_system_detail_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_dashboard_accessing_system2_detail_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_detail/v_modal_dashboard_chart4_detail_show');
    ?>

    <!-- Load Modal System Views -->
    <?php
    $this->load->view($this->config->item('pd_dir') . 'modal_system/v_modal_ums_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_system/v_modal_dim_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_system/v_modal_ams_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_system/v_modal_hr_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_system/v_modal_pms_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_system/v_modal_que_show');
    $this->load->view($this->config->item('pd_dir') . 'modal_system/v_modal_wts_show');
    ?>
</main>

<?php
// ฟังก์ชันสำหรับตรวจสอบวันหมดอายุและกำหนดสีของการ์ด
function getCardColor($endDate)
{
    // ตรวจสอบว่าหากเป็น "9999-12-31"
    if ($endDate === '9999-12-31') {
        return array('text-success', 'style="color: #198754; background: #d6f1da;"'); // สีเขียวสำหรับตลอดชีพ
    }

    $currentDate = new DateTime(); // รับวันที่ปัจจุบัน
    $endDateObj = new DateTime($endDate); // แปลงวันหมดอายุเป็น DateTime

    // คำนวณจำนวนเดือนที่เหลือจนถึงวันหมดอายุ
    $interval = $currentDate->diff($endDateObj);
    $monthsLeft = ($interval->y * 12) + $interval->m;

    // ตรวจสอบว่าหมดอายุแล้ว
    if ($endDateObj < $currentDate) {
        return array('text-danger', 'style="color: #dc3545; background: #f1d6d6;"'); // สีแดงสำหรับวันหมดอายุที่ผ่านไปแล้ว
    }
    // ตรวจสอบว่ายังเหลือไม่เกิน 6 เดือน
    elseif ($monthsLeft <= 6) {
        return array('text-orange', 'style="color: #FF9800; background: #fff5e8;"'); // สีเหลืองสำหรับวันหมดอายุภายใน 6 เดือน
    } else {
        return array('text-success', 'style="color: #198754; background: #d6f1da;"'); // สีเขียวสำหรับวันหมดอายุที่เหลือมากกว่า 6 เดือน
    }
}
?>

<link href="<?php echo base_url(); ?>assets/vendor/simple-datatables/style.css" rel="stylesheet">
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/simple-datatables/simple-datatables.js"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/dataTables/datatables.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2-bootstrap-5-theme-1.3.0/css/select2.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2-bootstrap-5-theme-1.3.0/css/select2-bootstrap-5-theme.min.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2-bootstrap-5-theme-1.3.0/js/select2.min.js"></script>

<script>
    $(document).ready(function() {

        function view(id) {
            $.ajax({
                method: "POST",
                url: 'Home/getmodal',
                data: {
                    id: id
                }
            }).done(function(returnData) {
                if (returnData.status == 1) {
                    $('.modaltitle').html(returnData.title);
                    console.log(returnData.title);
                    $('#mainModalBody').html(returnData.body);
                    $('#ck').html(returnData.footer);
                    $('#mainModal').modal('show');
                    $('#print').prop('disabled', false);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX request failed: ' + textStatus, errorThrown);
            });
        }
        $.ajax({
            method: "POST",
            url: 'Home/checkuser',
        }).done(function(returnData) {
            if (returnData == 0) {
                view(1);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {});
        // Example call to the function with a specific id; // Replace 1 with the actual ID you want to pass
    });

    document.addEventListener("DOMContentLoaded", function(event) {
        /**
         * Event nav menu
         */
        // const navpills1 = [...document.querySelectorAll('.nav-menu.nav-pills.nav-pills-1 button.nav-link')]
        // const navpills2 = [...document.querySelectorAll('.nav-menu.nav-pills.nav-pills-2 button.nav-link')]
        // // check nav-tabs แนวนอน to set active nav-pills แนวตั้ง
        // Array.prototype.slice.call(navpills2).forEach(function(navpill2) {
        //     // on click some nav-tab
        //     navpill2.addEventListener('click', function(event) {
        //         navpills1.forEach(navpill1 => {
        //             // remove active all nav-tabs
        //             navpill1.classList.remove('active');

        //             // if this nav-pill have equal data-bs-target with nav-tab
        //             if (navpill1.getAttribute('data-bs-target') == navpill2.getAttribute('data-bs-target'))
        //                 navpill1.classList.add('active');
        //         });
        //     });
        // });

        // // check nav-tabs แนวนอน to set active nav-pills แนวตั้ง
        // Array.prototype.slice.call(navpills1).forEach(function(navpill1) {
        //     // on click some nav-pill
        //     navpill1.addEventListener('click', function(event) {
        //         navpills2.forEach(navpill2 => {
        //             // remove active all nav-pills
        //             navpill2.classList.remove('active');

        //             // if this nav-tab have equal data-bs-target with nav-pill
        //             if (navpill1.getAttribute('data-bs-target') == navpill2.getAttribute('data-bs-target'))
        //                 navpill2.classList.add('active');
        //         });
        //     });
        // });

        /**
         * Event button/modal profile contacts
         */
        const contacts = [...document.querySelectorAll('.profile-contacts')]
        Array.prototype.slice.call(contacts).forEach(function(contact) {
            // on click some nav-pill
            contact.addEventListener('click', function(event) {
                document.querySelector('#profile-contacts-modal .modal-title').innerHTML = contact.getAttribute('data-name');
                document.querySelector('#profile-contacts-modal .modal-body').innerHTML = contact.getAttribute('data-value');

                // if (contact.hasAttribute('data-is-link') && contact.getAttribute('data-is-link') == "true") {
                //     document.querySelector('.modal-body a').href = contact.getAttribute('data-value');
                //     document.querySelector('.modal-body a').innerHTML = contact.getAttribute('data-value');
                // } else {
                //     if (contact.hasAttribute('data-value'))
                //         document.querySelector('.modal-body').innerHTML = contact.getAttribute('data-value');
                // }
            });
        });
    });
</script>

<script>
    /**
     * Initiate Datatables
     */
    // document.addEventListener("DOMContentLoaded", function(event) {
    //     var datatables = [...document.querySelectorAll('.datatable')];
    //     datatables.forEach(datatable => {
    //         var table = new simpleDatatables.DataTable(datatable);
    //         // Update language options
    //         var updatedOptions = {
    //             labels: {
    //                 info: "แสดงรายการที่ {start} - {end} จากทั้งหมด {rows} รายการ",
    //                 noResults: "ไม่พบรายการ",
    //                 noRows: "ไม่มีรายการในระบบ",
    //                 perPage: " ",
    //                 placeholder: "ค้นหา...",
    //                 searchTitle: "Search within table"
    //             },
    //             // Add other options here
    //         };

    //         // Destroy the existing instance and reinitialize with updated options
    //         table.destroy();
    //         new simpleDatatables.DataTable(datatable, updatedOptions);
    //     })
    // });
    new DataTable('.datatable', {
        // responsive: true,
        language: {
            decimal: "",
            emptyTable: "ไม่มีรายการในระบบ",
            info: "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "_MENU_",
            loadingRecords: "Loading...",
            processing: "",
            search: "",
            searchPlaceholder: 'ค้นหา...',
            zeroRecords: "ไม่พบรายการ",
            paginate: {
                first: "«",
                last: "»",
                next: "›",
                previous: "‹"
            },
            aria: {
                orderable: "Order by this column",
                orderableReverse: "Reverse order this column"
            },
        }
    });

    /**
     * Initiate Default Tooltips
     */
    // document.addEventListener("DOMContentLoaded", function(event) {
    //     const td_options = [...document.querySelectorAll('.datatable td.option button')];
    //     Array.from(td_options).forEach(btn => {
    //         const title = btn.getAttribute('title');
    //         btn.setAttribute('data-bs-toggle', 'tooltip');
    //         btn.setAttribute('data-bs-placement', 'top');
    //         // title case
    //         if (!is_null(title)) btn.setAttribute('title', title);
    //         else btn.setAttribute('title', "test");
    //         new bootstrap.Tooltip(btn);
    //     });
    // });

    /**
     * is_null(value) : Function to check if a value is null, empty, or undefined
     */
    function is_null(value) {
        if (value !== null && value !== '' && value !== undefined) return false
        else return true
    }
</script>

</body>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        var checkbox = document.getElementById("flexCheckDefault");
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                $.ajax({
                    method: "POST",
                    url: 'Home/setuser',
                }).done(function(returnData) {
                    $('#mainModal').modal('hide');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX request failed: ' + textStatus, errorThrown);
                });
                // Example: Show an element
            }
        });
    });
    $(document).ready(function() {
        $('.select2').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: true,
        });

        $('.select2-multiple').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: true,
            closeOnSelect: false,
        });
    });
</script>