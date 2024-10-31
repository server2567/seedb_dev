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
                                <i class="bi-search icon-menu"></i>ค้นหารายการลงเวลาทำงาน
                            </button>
                        </h2>
                        <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <form class="row g-3" method="get">

                                   
                                   
                
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
                                <i class="bi-reception-4 icon-menu"></i><span> รายการลงเวลาทำงาน
                            </button>
                        </h2>
                            
                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <!-- <div class="d-flex justify-content-end mb-2 mt-2">
                                    <button class="btn btn-secondary me-2" title="คลิกเพื่อ Print" data-bs-toggle="tooltip" data-bs-placement="top"  onclick="export_print_person('<?php echo encrypt_id($row_profile->ps_id); ?>','0')">
                                        <span><i class="bi-printer"></i> Print</span>
                                    </button>
                                    <button class="btn btn-success me-2" title="คลิกเพื่อส่งออกเอกสาร Excel" data-bs-toggle="tooltip" data-bs-placement="top"  onclick="export_excel_person('<?php echo encrypt_id($row_profile->ps_id); ?>','0')">
                                        <span><i class="bi-file-earmark-excel-fill"></i> Excel</span>
                                    </button>
                                    <button class="btn btn-danger" title="คลิกเพื่อส่งออกเอกสาร PDF" data-bs-toggle="tooltip" data-bs-placement="top"  onclick="export_pdf_person('<?php echo encrypt_id($row_profile->ps_id); ?>','0')">
                                        <span><i class="bi-file-earmark-pdf-fill"></i> PDF</span>
                                    </button>
                                </div> -->
                                <table id="timework_compile_list" class="table table-striped table-bordered table-hover datatables" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="10%">#</th>
                                            <th class="text-center" width="25%">ชื่อ - นามสกุล</th>
                                            <th class="text-center" width="20%">รหัสบุคลากร</th>
                                            <th class="text-center" width="20%">รหัสจับคู่เครื่องลงเวลาทำงาน</th>
                                            <th class="text-center" width="10%">วันที่</th>
                                            <th class="text-center" width="15%">เวลา</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <!-- ข้อมูลจะถูกเติมด้วย DataTable -->
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
    
    });
</script>