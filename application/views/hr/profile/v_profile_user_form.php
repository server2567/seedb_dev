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

<script>
    $(document).ready(function() {
        $(".list-group-item").click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 0);
        });
        $('[data-toggle="tooltip"]').tooltip();

    });

    function modal_confirm_delete(elements) {
        var id = elements.getAttribute("data-id");
        var tab = elements.getAttribute("data-tab");
        var table = elements.getAttribute("data-table");
        var topic = elements.getAttribute("data-topic");
        var index = elements.getAttribute("data-index");
        var detail = elements.getAttribute("data-detail");

        // Change modal title
        $('#modal_confirm_delete_data .modal-title').html("ยืนยันการลบข้อมูล" + topic + " (#" + index + ")");
        $('#modal_confirm_delete_data .modal-body .modal_detail').html(detail);

        // set input hidden value
        $('#modal_delete_id').val(id);
        $('#modal_table_name').val(table);
        $('#modal_tab_active').val(tab);

        // Show modal
        var myModal = new bootstrap.Modal(document.getElementById('modal_confirm_delete_data'));
        myModal.show();
    }

    function confirm_profile_delete_data() {
        var delete_id = $('#modal_delete_id').val();
        var table_name = $('#modal_table_name').val();
        var tab_active = $('#modal_tab_active').val();
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>delete_' + table_name + '_data_by_param',
            type: 'POST',
            data: {
                delete_id: delete_id,
                tab_active: tab_active
            },
            success: function(data) {
                data = JSON.parse(data);

                // Hide the modal before making the AJAX call
                var myModalEl = document.getElementById('modal_confirm_delete_data');
                var myModal = bootstrap.Modal.getInstance(myModalEl);
                myModal.hide();

                // console.log(data.data.status_response)
                if (data.data.status_response == status_response_success) {
                    dialog_success({
                        'header': text_toast_delete_success_header,
                        'body': text_toast_delete_success_body
                    }, data.data.return_url, false);
                } else if (data.data.status_response == status_response_error) {
                    dialog_error({
                        'header': text_toast_delete_error_header,
                        'body': text_toast_delete_error_body
                    });
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

    function replaceQuotes(str) {
        // Check if str is null or undefined, and return an empty string or original value
        if (str === null || str === undefined) {
            return '';
        }

        // Replace straight double quotes with curly double quotes
        str = str.replace(/"([^"]*)"/g, '“$1”');

        // Replace straight single quotes with curly single quotes
        str = str.replace(/'([^']*)'/g, '‘$1’');

        return str;
    }
</script>


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
                                                        <div> <?php
                                                                $position[] = '';
                                                                foreach ($base_structure_position as $stpo_key => $value) {
                                                                    $position[] = $value->stpo_name;
                                                                    $position2[] = $value->stpo_used;
                                                                }
                                                                if (!empty($person_department_detail[$key]->stde_admin_position)) {

                                                                    foreach ($person_department_detail[$key]->stde_admin_position as $key2 => $stde_admin) {

                                                                        if ($stde_admin['stdp_po_id'] == 0) {
                                                                            echo '<ul class="mb-0"><li>'  . implode('</li><li>', $stde_admin['stde_name_th']) . '</li></ul>';
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
                        </div>
                        <!-- <div class="btn-option text-center">
                            <a class="btn btn-primary" href="../Personal_dashboard/generate_CV" target="_blank"> <i class="bi-dowload"></i> Download CV </a>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="list-group list-group-alternate mb-n">
                <a href="#" role="tab" data-bs-toggle="tab" data-bs-target="#tab-resume" class="list-group-item <?php echo ($tab_active == 1 ? "active" : "") ?>">
                    <i class="bi-file-person icon-menu font-20"></i> ข้อมูลส่วนตัว
                </a>
                <a href="#" role="tab" data-bs-toggle="tab" data-bs-target="#tab_address" class="list-group-item <?php echo ($tab_active == 2 ? "active" : "") ?>">
                    <i class="ri-map-pin-line icon-menu font-20"></i> ที่อยู่
                </a>
                <a href="#" role="tab" data-bs-toggle="tab" data-bs-target="#tab_education" class="list-group-item <?php echo ($tab_active == 3 ? "active" : "") ?>">
                    <i class="bi bi-mortarboard icon-menu font-20"></i> ประวัติการศึกษา
                </a>
                <a href="#" role="tab" data-bs-toggle="tab" data-bs-target="#tab_license" class="list-group-item <?php echo ($tab_active == 4 ? "active" : "") ?>">
                    <i class="bi bi-postcard icon-menu font-20"></i> ใบประกอบวิชาชีพ
                </a>
                <a href="#" role="tab" data-bs-toggle="tab" data-bs-target="#tab_experience" class="list-group-item <?php echo ($tab_active == 5 ? "active" : "") ?>">
                    <i class="bi bi-briefcase icon-menu font-20"></i> ประสบการณ์ทำงาน
                </a>
                <a href="#" role="tab" data-bs-toggle="tab" data-bs-target="#tab_expert" class="list-group-item <?php echo ($tab_active == 6 ? "active" : "") ?>">
                    <i class="bi bi-emoji-laughing icon-menu font-20"></i> ความเชี่ยวชาญ/ความชำนาญ
                </a>
                <a href="#" role="tab" data-bs-toggle="tab" data-bs-target="#tab_external_service" class="list-group-item <?php echo ($tab_active == 8 ? "active" : "") ?>">
                    <i class="bi bi-box-arrow-up-left icon-menu font-20"></i> บริการหน่วยงานภายนอก
                </a>
                <a href="#" role="tab" data-bs-toggle="tab" data-bs-target="#tab_award" class="list-group-item <?php echo ($tab_active == 7 ? "active" : "") ?>">
                    <i class="bx bx-award icon-menu font-22"></i> รางวัล
                </a>
            </div>

        </div>

        <div class="col-md-9">
            <div class="tab-content" id="profile_user_type">
                <div class="tab-pane fade row g-1 <?php echo ($tab_active == 1 ? " show active" : "") ?>" id="tab-resume" role="tabpanel">
                    <?php echo $this->load->view($view_dir . 'v_profile_user_resume', '', TRUE); ?>
                </div>
                <div class="tab-pane fade row <?php echo ($tab_active == 2 ? " show active" : "") ?>" id="tab_address" role="tabpanel">
                    <?php echo $this->load->view($view_dir . 'v_profile_user_address', '', TRUE); ?>
                </div>
                <div class="tab-pane fade row <?php echo ($tab_active == 3 ? " show active" : "") ?>" id="tab_education" role="tabpanel">
                    <?php echo $this->load->view($view_dir . 'v_profile_user_education', '', TRUE); ?>
                </div>
                <div class="tab-pane fade row <?php echo ($tab_active == 4 ? " show active" : "") ?>" id="tab_license" role="tabpanel">
                    <?php echo $this->load->view($view_dir . 'v_profile_user_license', '', TRUE); ?>
                </div>
                <div class="tab-pane fade row <?php echo ($tab_active == 5 ? " show active" : "") ?>" id="tab_experience" role="tabpanel">
                    <?php echo $this->load->view($view_dir . 'v_profile_user_experience', '', TRUE); ?>
                </div>
                <div class="tab-pane fade row <?php echo ($tab_active == 6 ? " show active" : "") ?>" id="tab_expert" role="tabpanel">
                    <?php echo $this->load->view($view_dir . 'v_profile_user_expert', '', TRUE); ?>
                </div>
                <div class="tab-pane fade row <?php echo ($tab_active == 7 ? " show active" : "") ?>" id="tab_award" role="tabpanel">
                    <?php echo $this->load->view($view_dir . 'v_profile_user_reward', '', TRUE); ?>
                </div>
                <div class="tab-pane fade row <?php echo ($tab_active == 8 ? " show active" : "") ?>" id="tab_external_service" role="tabpanel">
                    <?php echo $this->load->view($view_dir . 'v_profile_user_external_service', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_confirm_delete_data" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ยืนยันการลบข้อมูล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal_detail">

                </div>
                <input type="hidden" name="modal_delete_id" id="modal_delete_id">
                <input type="hidden" name="modal_table_name" id="modal_table_name">
                <input type="hidden" name="modal_tab_active" id="modal_tab_active">

            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="confirm_profile_delete_data()">ยืนยัน</button>
            </div>
        </div>
    </div>
</div><!-- End Modal-->