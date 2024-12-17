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

    .loading-message {
        display: flex;
        justify-content: center;
        /* จัดตำแหน่งให้อยู่ตรงกลางแนวนอน */
        align-items: center;
        /* จัดตำแหน่งให้อยู่ตรงกลางแนวตั้ง */
        height: 200px;
        /* ความสูงพื้นที่การแสดงข้อความ */
        text-align: center;
        /* จัดข้อความให้อยู่ตรงกลาง */
        font-size: 20px;
        /* ขนาดตัวอักษร */
        font-weight: bold;
        /* เพิ่มความหนา */
        color: #555;
        /* สีตัวอักษร */
        background-color: #f8f9fa;
        /* สีพื้นหลัง */
        border: 1px solid #ddd;
        /* เพิ่มเส้นขอบ */
        border-radius: 8px;
        /* มุมโค้งมน */
    }

    .action-buttons {
        gap: 10px;
        /* เพิ่มระยะห่างระหว่างปุ่ม */
    }

    .action-btn {
        padding: 10px 20px;
        /* เพิ่มความกว้างของปุ่ม */

        font-weight: bold;
        /* เน้นข้อความให้ชัดเจน */
        transition: all 0.3s ease-in-out;
        /* เพิ่มเอฟเฟกต์เมื่อโฮเวอร์ */
    }

    .action-btn:disabled {
        opacity: 0.5;
        /* ลดความชัดเจนเมื่อปุ่มถูกปิดใช้งาน */
        cursor: not-allowed;
        /* เปลี่ยน cursor เมื่อปิดใช้งาน */
    }

    .action-btn:hover:not(:disabled) {
        transform: scale(1.1);
        /* ขยายปุ่มเมื่อโฮเวอร์ */
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        /* เพิ่มเงา */
    }

    .btn-success {
        background-color: #28a745;
        /* สีพื้นหลังอนุมัติ */
        border: none;
        /* ลบขอบ */
    }

    .btn-success:hover {
        background-color: #218838;
        /* สีเมื่อโฮเวอร์ */
    }

    .btn-danger {
        background-color: #dc3545;
        /* สีพื้นหลังไม่อนุมัติ */
        border: none;
        /* ลบขอบ */
    }

    .btn-danger:hover {
        background-color: #c82333;
        /* สีเมื่อโฮเวอร์ */
    }
</style>
<div class="col-md-12">
    <div class="row">
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
        <div class="col-md-9">
            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                                <i class="bi-receipt icon-menu"></i><span> แบบฟอร์มการทำเรื่องลา</span>
                            </button>
                        </h2>
                        <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                            <div class="accordion-body">
                                <div id="show_leave_form">
                                    <!-- <iframe src="<?php echo base_url() . "index.php/hr/leaves/Leaves_report/generate_report_leaves/" . $lhis_id ?>"
                                            width="100%" 
                                            height="500px" 
                                            frameborder="0">
                                    </iframe> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="accordion">
                    <div class="accordion-item">

                        <div id="collapseShow" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <form class="row g-3">

                                    <div class="col-12">
                                        <label for="inputPassword" class="col-form-label">ความคิดเห็น</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" style="height: 100px" id="lafw-comment" name="lafw-comment" value='<?= $comment  ?>'><?= $comment  ?></textarea>
                                        </div>
                                    </div>


                                    <!-- ปุ่มการทำงาน -->
                                    <div class="col-12 d-flex justify-content-between align-items-center mt-3">
                                        <!-- ปุ่มย้อนกลับ -->
                                        <button type="button" class="btn btn-secondary" onclick="window.location.href = `<?php echo base_url() . 'index.php/hr/leaves/Leaves_approve/get_leaves_person_list/'.encrypt_id($lafw_ps_id) ?>`">
                                            ย้อนกลับ
                                        </button>

                                        <!-- ปุ่มอนุมัติและไม่อนุมัติ -->
                                        <div>

                                            <!-- ปุ่มไม่อนุมัติ -->
                                            <button id="disapprove_selected" type="button" class="btn btn-danger action-btn btn-md me-3 "
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="ไม่อนุมัติรายการที่เลือก">
                                                ไม่อนุมัติ
                                            </button>

                                            <!-- ปุ่มอนุมัติ -->
                                            <button id="approve_selected" type="button" class="btn btn-success action-btn btn-md"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="อนุมัติรายการที่เลือก">
                                                อนุมัติ
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // $('#preview_file_modal .modal-header .modal-title').html("ตัวอย่างไฟล์ " + file_name);
        // $('#preview_file_modal .modal-body #modal-iframe').attr('src', file_preview_path);
        // $('#preview_file_modal .modal-footer .download_file_btn_modal').attr('href', file_download_path);\
        showLeaveForm('<?php echo $lhis_id; ?>');
        $("#approve_selected").on("click", function() {
            save_data('<?= $lhis_id ?>', 'อนุมัติ')
        })

        $("#disapprove_selected").on("click", function() {
            save_data('<?= $lhis_id ?>', 'ไม่อนุมัติ')
        })

    });

    function showLeaveForm(item) {
        const path = `<?php echo base_url() . "index.php/hr/leaves/Leaves_report/generate_report_leaves/" . $lhis_id ?>`;
        const iframeHTML = `<iframe src="${path}" width="100%" height="650px" frameborder="0"></iframe>`;

        document.getElementById('show_leave_form').innerHTML = `
            <div class="loading-message">
                <p>กำลังโหลดข้อมูล...</p>
            </div>
         `;

        // เพิ่มการสร้าง iframe หลังจากข้อความโหลด
        setTimeout(() => {
            const path = `<?php echo base_url() . "index.php/hr/leaves/Leaves_report/generate_report_leaves/" . $lhis_id ?>`;
            document.getElementById('show_leave_form').innerHTML = `
                <iframe src="${path}" width="100%" height="650px" frameborder="0"></iframe>
            `;
        }, 300); // จำลองการโหลด 0.3 วินาที

    }

    function save_data(lhis_id, action) {
        const comments = document.getElementById("lafw-comment").value;
        $.ajax({

            url: '<?php echo base_url() . "index.php/hr/leaves/Leaves_approve/update_leave_status" ?>',
            type: 'POST',
            data: {
                ids: [lhis_id],
                action: action,
                comments: [comments]
            },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status_response == status_response_success) {
                    dialog_success({
                        'header': text_toast_save_success_header,
                        'body': data.message_dialog
                    });
                    setTimeout(() => {
                        window.location.href = `<?php echo base_url() . "index.php/hr/leaves/Leaves_approve/get_leaves_person_list/".encrypt_id($lafw_ps_id) ?>`
                    }, 2000);
                } else if (data.status_response == status_response_error) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': data.message_dialog
                    });
                }

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