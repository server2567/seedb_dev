<style>
    .selected-color-box {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid #9fb4bf;
        display: inline-block;
        cursor: pointer;
        background-color: #fff;
    }

    .color-options {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    .color-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid #9fb4bf;
        cursor: pointer;
        transition: border 0.3s;
    }

    .color-circle:hover {
        border: 2px solid #000;
    }

    .modal-dialog-centered {
        max-width: 580px;
    }

    .btn-outline-secondary {
        padding: 6px 12px;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($twag_data) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลกลุ่มรูปแบบการลงเวลางาน<?php echo $hire_is_medical; ?></span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
                    <form class="row g-3 needs-validation" id="attendange_form" novalidate>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="twag_id" id="twag_id" value="<?php echo !empty($twag_data) ? encrypt_id($twag_data->twag_id) : "" ?>">
                                    <div class="col-md-6 mt-3">
                                        <label for="twac_name_th" class="form-label required">ชื่อกลุ่มรูปแบบการลงเวลางาน (ภาษาไทย) </label>
                                        <input type="text" class="form-control mb-1" name="twag_name_th" id="twag_name_th" placeholder="ชื่อรูปแบบการลงเวลางาน (ภาษาไทย)" value="<?php echo !empty($twag_data) ? $twag_data->twag_name_th : ""; ?>" required>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="twac_name_abbr_th" class="form-label required">ชื่อย่อกลุ่มรูปแบบการลงเวลางาน (ภาษาไทย) </label>
                                        <input type="text" class="form-control mb-1" name="twag_name_abbr_th" id="twag_name_abbr_th" placeholder="ชื่อย่อรูปแบบการลงเวลางาน (ภาษาไทย)" value="<?php echo !empty($twag_data) ? $twag_data->twag_name_abbr_th : ""; ?>" required>
                                    </div>


                                    <?php
                                    // Available options
                                    $medical_types = [
                                        'M'  => 'สายการแพทย์',
                                        'N'  => 'สายการพยาบาล',
                                        'SM' => 'สายสนับสนุนทางการแพทย์',
                                        'A'  => 'สายบริหาร'
                                    ];

                                    // Fetch available options from session
                                    $available_types = $this->session->userdata('hr_hire_is_medical');
                                    $available_types_array = array_column($available_types, 'type'); // Extract types from session

                                    ?>
                                    <div class="col-md-3 mt-4">
                                        <label for="option_twac_is_medical" class="form-label required">สายงาน</label>
                                        <div class="form-check">
                                            <?php $first = true; // Flag to check the first option 
                                            ?>
                                            <?php foreach ($medical_types as $key => $label) : ?>
                                                <?php if (in_array($key, $available_types_array)) : // Only show the options that exist in session 
                                                ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="option_twag_is_medical" value="<?php echo $key; ?>"
                                                            id="twag_is_medical_<?php echo $key; ?>"
                                                            <?php
                                                            // Check if the current option should be checked
                                                            echo !empty($twag_data) && $twag_data->twag_is_medical == $key
                                                                ? 'checked'
                                                                : ($first && empty($twag_data->twag_is_medical) ? 'checked' : '');
                                                            ?>>
                                                        <label for="twag_is_medical_<?php echo $key; ?>" class="form-check-label"><?php echo $label; ?></label>
                                                    </div>
                                                    <?php $first = false; // After the first iteration, this will be set to false 
                                                    ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>


                                    <div class="col-md-3 mt-4">
                                        <label for="option_twac_type" class="form-label required">ประเภทการทำงาน</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="option_twag_type" value="1" id="twac_type" <?php echo !empty($twag_data) && $twag_data->twag_type == 1 ? 'checked' :  'checked' ?>>
                                            <label for="option_twag_type" class="form-check-label mb-2">ปฏิบัติงานเต็มเวลา (Full Time)</label> <br>
                                            <input class="form-check-input" type="radio" name="option_twag_type" value="2" id="twac_type2" <?php echo !empty($twag_data) && $twag_data->twag_type == 2 ? 'checked' :  '' ?>>
                                            <label for="option_twag_type" class="form-check-label">ปฏิบัติงานบางส่วนเวลา (Part Time)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-success" id="addAccordionButton">
                                <i class="bi bi-plus"></i> เพิ่มรูปแบบ
                            </button>
                        </div>
                        <?php if (!isset($twag_data)) : ?>
                            <div class="col-md-12">
                                <div class="accordion" id="approach">
                                    <div class="accordion-item approach_list ">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccordion_1" aria-expanded="true" aria-controls="collapseAccordion_1">
                                                <i class="bi-window-dock icon-menu"></i><span>รูปแบบการลงเวลาทำงาน รูปแบบที่ 1</span>
                                            </button>
                                        </h2>
                                        <div id="collapseAccordion_1" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                                            <div class="col-md-12">
                                                <div class="accordion-body">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <input type="hidden" name="twac_info[]" id="twac_id_1" value="twac_ap">
                                                                <div class="col-md-6 mt-3">
                                                                    <label for="twac_name_th" class="form-label required">ชื่อรูปแบบการลงเวลางาน (ภาษาไทย) </label>
                                                                    <input type="text" class="form-control mb-1" name="twac_info[]" id="twac_name_th_1" placeholder="ชื่อรูปแบบการลงเวลางาน (ภาษาไทย)" value="<?php echo !empty($row_twac) ? $row_twac->twac_name_th : ""; ?>" required>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <label for="twac_name_abbr_th" class="form-label required">ชื่อย่อรูปแบบการลงเวลางาน (ภาษาไทย) </label>
                                                                    <input type="text" class="form-control mb-1" name="twac_info[]" id="twac_name_abbr_th_1" placeholder="ชื่อย่อรูปแบบการลงเวลางาน (ภาษาไทย)" value="<?php echo !empty($row_twac) ? $row_twac->twac_name_abbr_th : ""; ?>" required>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <label for="twac_time_work" class="form-label required">เวลาเข้า-ออกงาน</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" class="form-control set_start_time" placeholder="เวลาเข้างาน" aria-label="เวลาเข้างาน" id="twac_start_time_1" name="twac_info[]" value="">
                                                                        <span class="input-group-text">ถึง</span>
                                                                        <input type="text" class="form-control set_end_time" placeholder="เวลาออกงาน" aria-label="เวลาออกงาน" id="twac_end_time_1" name="twac_info[]" value="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3 mt-3">
                                                                    <label for="twac_late_time" class="form-label required">เวลาเข้างานสาย</label>
                                                                    <input type="text" class="form-control setTime" placeholder="เวลาเข้างานสาย" aria-label="เวลาเข้างานสาย" id="twac_late_time_1" name="twac_info[]" value="">
                                                                </div>
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="twac_time_color" class="form-label required">สี</label>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="selected-color-box" id="selectedColorBox_1" onclick="color_select('twac_color_1','selectedColorBox_1')" style="background-color: <?php echo !empty($row_twac) ? $row_twac->twac_color : "#1B5E20"; ?>;" data-bs-toggle="modal" data-bs-target="#colorPickerModal"></div>
                                                                        <input type="hidden" id="twac_color_1" name="twac_info[]" value="<?php echo !empty($row_twac) ? $row_twac->twac_color : "#1B5E20"; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mt-4">
                                                                    <label for="twac_is_ot" class="form-label">เวลางาน OT </label>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input m-1" id="twac_is_ot_1" name="twac_info[]" <?php echo !empty($row_twac) && $row_twac->twac_is_ot == '1' ? 'checked' : '' ?>>
                                                                        <label for="twac_is_ot" class="form-check-label"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mt-4">
                                                                    <label for="twac_is_ot" class="form-label">รวมเวลาพักระหว่างวัน</label>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input m-1" id="twac_is_break_1" name="twac_info[]" <?php echo !empty($row_twac) && $twac_data->twac_is_break == '1' ? 'checked' : '' ?>>
                                                                        <label for="twac_is_break" class="form-check-label"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mt-4">
                                                                    <label for="twac_is_ot" class="form-label">คำนวณช่วงเวลาจากวันก่อนหน้า</label>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input m-1" id="twac_is_pre_cal_1" name="twac_info[]" <?php echo !empty($row_twac) && $twac_data->twac_is_pre_cal == '1' ? 'checked' : '' ?>>
                                                                        <label for="twac_is_pre_cal" class="form-check-label"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mt-4">
                                                                    <label for="twac_active" class="form-label">สถานะการใช้งาน</label>
                                                                    <div class="form-check">
                                                                        <?php if (!empty($row_twac->twac_id)) { ?>
                                                                            <input class="form-check-input m-1" type="checkbox" name="twac_info[]" id="twac_active_1" value="<?php echo !empty($row_twac) ? $row_twac->twac_active : '' ?>" <?php echo !empty($row_twac) && $row_twac->twac_active == '1' ? 'checked' : '' ?>>
                                                                        <?php } else { ?>
                                                                            <input type="checkbox" id="twac_active" name="twac_active_1" class="form-check-input m-1" checked disabled>
                                                                        <?php } ?>
                                                                        <label for="twac_active" class="form-check-label">เปิดใช้งาน</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddPerson" aria-expanded="true" aria-controls="collapseAddPerson">
                                                                    <i class="bi-window-dock icon-menu"></i><span>ผู้เข้าร่วม</span>
                                                                </button>
                                                            </h2>
                                                            <div id="collapseAddPerson" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                                                                <div class="accordion-body">
                                                                    <button class="btn btn-primary mb-2" id="addP" type="button" onclick="getpersonlist($('#departmentName').val(),'paticipate_1',$('#twac_id_1').val())" data-bs-toggle="modal" data-bs-target="#addPersonModal"><i class="bi bi-plus"></i> เพิ่มผู้เข้าร่วม</button>
                                                                    <table class="table paticipate" id="paticipate_1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">
                                                                                    <div class="text-center">ลำดับ</div>
                                                                                </th>
                                                                                <th class="text-center">รหัสบุคลากร</th>
                                                                                <th scope="col" width="20%" class="text-center">ชื่อ-นามสกุล</th>
                                                                                <th scope="col" class="text-center">ประเภทบุคลากร</th>
                                                                                <th scope="col" class="text-center">ดำเนินการ</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php if (isset($row_twac) && $row_twac->twac_person != null) : ?>
                                                                                <?php foreach ($row_twac->twac_person as $key => $person_list) : ?>
                                                                                    <tr>
                                                                                        <td class="text-center">
                                                                                            <?= $key + 1 ?>
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            <?= $person_list['pos_ps_code'] ?>
                                                                                        </td>
                                                                                        <td class="text-start">
                                                                                            <?= $person_list['ps_name'] ?>
                                                                                        </td>
                                                                                        <td class="text-start">
                                                                                            <?= $person_list['hire_name'] ?>
                                                                                        </td>
                                                                                        <td width="10%" class="text-center">
                                                                                            <button class="btn btn-sm btn-danger delPerson" type="button" data-table-id='paticipate_1' data-id="<?= $person_list['ps_id'] ?>"><i class="bi bi-trash delPerson" data-table-id='paticipate_1' data-id="<?= $person_list['ps_id'] ?>"></i></button>
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
                                </div>
                            </div>
                        <?php else: ?>
                            <?php if (!empty($row_twac)) : ?>
                                <div class="col-md-12">
                                    <div class="accordion" id="approach">
                                        <?php foreach ($row_twac as $key => $twac_data) : ?>
                                            <div class="accordion-item mt-3 approach_list ">
                                                <h2 class="accordion-header d-flex align-items-center justify-content-between" id="headingAccordion<?= $key + 1 ?>">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccordion_<?= $key + 1 ?>" aria-expanded="true" aria-controls="collapseAccordion_<?= $key + 1 ?>">
                                                        <i class="bi-window-dock icon-menu me-2"></i>
                                                        <span>รูปแบบการลงเวลาทำงาน รูปแบบที่ <?= $key + 1 ?></span>
                                                    </button>
                                                    <span class="btn btn-danger btn-lg accordion-delete-btn" onclick="deleteAccordion(<?= $key + 1 ?>); event.stopPropagation();">
                                                        <i class="bi-trash"></i>
                                                    </span>
                                                </h2>
                                                <div id="collapseAccordion_<?= $key + 1 ?>" class="accordion-collapse collapse <?= $key == 0 ? 'show' : '' ?>" aria-labelledby="headingAdd">
                                                    <div class="col-md-12">
                                                        <div class="accordion-body">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <input type="hidden" name="twac_info[]" id="twac_id_<?= $key + 1 ?>" value="<?= $twac_data->twac_id ?>">
                                                                        <div class="col-md-6 mt-3">
                                                                            <label for="twac_name_th" class="form-label required">ชื่อรูปแบบการลงเวลางาน (ภาษาไทย) </label>
                                                                            <input type="text" class="form-control mb-1" name="twac_info[]" id="twac_name_th_<?= $key + 1 ?>" placeholder="ชื่อรูปแบบการลงเวลางาน (ภาษาไทย)" value="<?php echo !empty($row_twac) ? $twac_data->twac_name_th : ""; ?>" required>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label for="twac_name_abbr_th" class="form-label required">ชื่อย่อรูปแบบการลงเวลางาน (ภาษาไทย) </label>
                                                                            <input type="text" class="form-control mb-1" name="twac_info[]" id="twac_name_abbr_th_<?= $key + 1 ?>" placeholder="ชื่อย่อรูปแบบการลงเวลางาน (ภาษาไทย)" value="<?php echo !empty($row_twac) ? $twac_data->twac_name_abbr_th : ""; ?>" required>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label for="twac_time_work" class="form-label required">เวลาเข้า-ออกงาน</label>
                                                                            <div class="input-group mb-3">
                                                                                <input type="text" class="form-control set_start_time" placeholder="เวลาเข้างาน" aria-label="เวลาเข้างาน" id="twac_start_time_<?= $key + 1 ?>" name="twac_info[]" value="<?php echo !empty($row_twac) ? $twac_data->twac_start_time : ""; ?>">
                                                                                <span class="input-group-text">ถึง</span>
                                                                                <input type="text" class="form-control set_end_time" placeholder="เวลาออกงาน" aria-label="เวลาออกงาน" id="twac_end_time_<?= $key + 1 ?>" name="twac_info[]" value="<?php echo !empty($row_twac) ? $twac_data->twac_end_time : ""; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3 mt-3">
                                                                            <label for="twac_late_time" class="form-label required">เวลาเข้างานสาย</label>
                                                                            <input type="text" class="form-control setTime" placeholder="เวลาเข้างานสาย" aria-label="เวลาเข้างานสาย" id="twac_late_time_<?= $key + 1 ?>" name="twac_info[]" value="<?php echo !empty($row_twac) ? $twac_data->twac_late_time : ""; ?>">
                                                                        </div>
                                                                        <div class="col-md-3 mt-3">
                                                                            <label for="twac_time_color" class="form-label required">สี</label>
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="selected-color-box" id="selectedColorBox_<?= $key + 1 ?>" onclick="color_select('twac_color_<?= $key + 1 ?>','selectedColorBox_<?= $key + 1 ?>')" style="background-color: <?php echo !empty($row_twac) ? $twac_data->twac_color : "#1B5E20"; ?>;" data-bs-toggle="modal" data-bs-target="#colorPickerModal"></div>
                                                                                <input type="hidden" id="twac_color_<?= $key + 1 ?>" name="twac_info[]" value="<?php echo !empty($row_twac) ? $twac_data->twac_color : "#1B5E20"; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="twac_is_ot" class="form-label">เวลางาน OT </label>
                                                                            <div class="form-check">
                                                                                <input type="checkbox" class="form-check-input m-1" id="twac_is_ot_<?= $key + 1 ?>" name="twac_info[]" <?php echo !empty($row_twac) && $twac_data->twac_is_ot == '1' ? 'checked' : '' ?>>
                                                                                <label for="twac_is_ot" class="form-check-label"></label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="twac_is_ot" class="form-label">รวมเวลาพักระหว่างวัน</label>
                                                                            <div class="form-check">
                                                                                <input type="checkbox" class="form-check-input m-1" id="twac_is_break_<?= $key + 1 ?>" name="twac_info[]" <?php echo !empty($row_twac) && $twac_data->twac_is_break == '1' ? 'checked' : '' ?>>
                                                                                <label for="twac_is_break" class="form-check-label"></label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="twac_is_ot" class="form-label">คำนวณช่วงเวลาจากวันก่อนหน้า</label>
                                                                            <div class="form-check">
                                                                                <input type="checkbox" class="form-check-input m-1" id="twac_is_pre_cal_<?= $key + 1 ?>" name="twac_info[]" <?php echo !empty($row_twac) && $twac_data->twac_is_pre_cal == '1' ? 'checked' : '' ?>>
                                                                                <label for="twac_is_pre_cal" class="form-check-label"></label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-4">
                                                                            <label for="twac_active" class="form-label">สถานะการใช้งาน</label>
                                                                            <div class="form-check">
                                                                                <?php if (!empty($twac_data->twac_id)) { ?>
                                                                                    <input class="form-check-input m-1" type="checkbox" name="twac_info[]" id="twac_active_<?= $key + 1 ?>" value="<?php echo !empty($twac_data->twac_id) ? $twac_data->twac_active : '' ?>" <?php echo !empty($row_twac) && $twac_data->twac_active == '1' ? 'checked' : '' ?>>
                                                                                <?php } else { ?>
                                                                                    <input type="checkbox" id="twac_active" name="twac_active_<?= $key + 1 ?>" class="form-check-input m-1" checked disabled>
                                                                                <?php } ?>
                                                                                <label for="twac_active" class="form-check-label">เปิดใช้งาน</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="accordion">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header">
                                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddPerson" aria-expanded="true" aria-controls="collapseAddPerson">
                                                                            <i class="bi-window-dock icon-menu"></i><span>ผู้เข้าร่วม</span>
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseAddPerson" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                                                                        <div class="accordion-body">
                                                                            <button class="btn btn-primary mb-2" id="addP" type="button" onclick="getpersonlist($('#departmentName').val(),'paticipate_<?= $key + 1 ?>',$('#twac_id_<?= $key + 1 ?>').val())" data-bs-toggle="modal" data-bs-target="#addPersonModal"><i class="bi bi-plus"></i> เพิ่มผู้เข้าร่วม</button>
                                                                            <table class="table paticipate" id="paticipate_<?= $key + 1 ?>">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th scope="col">
                                                                                            <div class="text-center">ลำดับ</div>
                                                                                        </th>
                                                                                        <th class="text-center">รหัสบุคลากร</th>
                                                                                        <th scope="col" width="20%" class="text-center">ชื่อ-นามสกุล</th>
                                                                                        <th scope="col" class="text-center">ประเภทบุคลากร</th>
                                                                                        <th scope="col" class="text-center">ดำเนินการ</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php if (isset($row_twac) && $twac_data->twac_person != null) : ?>
                                                                                        <?php foreach ($twac_data->twac_person as $key_person => $person_list) : ?>
                                                                                            <tr>
                                                                                                <td class="text-center">
                                                                                                    <?= $key_person + 1 ?>
                                                                                                </td>
                                                                                                <td class="text-center">
                                                                                                    <?= $person_list['pos_ps_code'] ?>
                                                                                                </td>
                                                                                                <td class="text-start">
                                                                                                    <?= $person_list['ps_name'] ?>
                                                                                                </td>
                                                                                                <td class="text-start">
                                                                                                    <?= $person_list['hire_name'] ?>
                                                                                                </td>
                                                                                                <td width="10%" class="text-center">
                                                                                                    <button class="btn btn-sm btn-danger delPerson" type="button" data-table-id='paticipate_<?= $key + 1 ?>' data-id="<?= $person_list['ps_id'] ?>"><i class="bi bi-trash delPerson" data-table-id='paticipate_<?= $key + 1 ?>' data-id="<?= $person_list['ps_id'] ?>"></i></button>
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
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="col-md-12">
                                    <div class="accordion" id="approach">
                                        <div class="accordion-item approach_list ">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccordion_1" aria-expanded="true" aria-controls="collapseAccordion_1">
                                                    <i class="bi-window-dock icon-menu"></i><span>รูปแบบการลงเวลาทำงาน รูปแบบที่ 1</span>
                                                </button>
                                            </h2>
                                            <div id="collapseAccordion_1" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                                                <div class="col-md-12">
                                                    <div class="accordion-body">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <input type="hidden" name="twac_info[]" id="twac_id_1" value="new">
                                                                    <div class="col-md-6 mt-3">
                                                                        <label for="twac_name_th" class="form-label required">ชื่อรูปแบบการลงเวลางาน (ภาษาไทย) </label>
                                                                        <input type="text" class="form-control mb-1" name="twac_info[]" id="twac_name_th_1" placeholder="ชื่อรูปแบบการลงเวลางาน (ภาษาไทย)" value="" required>
                                                                    </div>
                                                                    <div class="col-md-6 mt-3">
                                                                        <label for="twac_name_abbr_th" class="form-label required">ชื่อย่อรูปแบบการลงเวลางาน (ภาษาไทย) </label>
                                                                        <input type="text" class="form-control mb-1" name="twac_info[]" id="twac_name_abbr_th_1" placeholder="ชื่อย่อรูปแบบการลงเวลางาน (ภาษาไทย)" value="" required>
                                                                    </div>
                                                                    <div class="col-md-6 mt-3">
                                                                        <label for="twac_time_work" class="form-label required">เวลาเข้า-ออกงาน</label>
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" class="form-control set_start_time" placeholder="เวลาเข้างาน" aria-label="เวลาเข้างาน" id="twac_start_time_1" name="twac_info[]" value="">
                                                                            <span class="input-group-text">ถึง</span>
                                                                            <input type="text" class="form-control set_end_time" placeholder="เวลาออกงาน" aria-label="เวลาออกงาน" id="twac_end_time_1" name="twac_info[]" value="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3 mt-3">
                                                                        <label for="twac_late_time" class="form-label required">เวลาเข้างานสาย</label>
                                                                        <input type="text" class="form-control setTime" placeholder="เวลาเข้างานสาย" aria-label="เวลาเข้างานสาย" id="twac_late_time_1" name="twac_info[]" value="">
                                                                    </div>
                                                                    <div class="col-md-3 mt-3">
                                                                        <label for="twac_time_color" class="form-label required">สี</label>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="selected-color-box" id="selectedColorBox_1" onclick="color_select('twac_color_1','selectedColorBox_1')" style="background-color:#1B5E20" data-bs-toggle="modal" data-bs-target="#colorPickerModal"></div>
                                                                            <input type="hidden" id="twac_color_1" name="twac_info[]" value="#1B5E20">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 mt-4">
                                                                        <label for="twac_is_ot" class="form-label">เวลางาน OT </label>
                                                                        <div class="form-check">
                                                                            <input type="checkbox" class="form-check-input m-1" id="twac_is_ot_1" name="twac_info[]">
                                                                            <label for="twac_is_ot" class="form-check-label"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 mt-4">
                                                                        <label for="twac_is_ot" class="form-label">รวมเวลาพักระหว่างวัน</label>
                                                                        <div class="form-check">
                                                                            <input type="checkbox" class="form-check-input m-1" id="twac_is_break_1" name="twac_info[]" <?php echo !empty($row_twac) && $twac_data->twac_is_break == '1' ? 'checked' : '' ?>>
                                                                            <label for="twac_is_break" class="form-check-label"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 mt-4">
                                                                        <label for="twac_is_ot" class="form-label">คำนวณช่วงเวลาจากวันก่อนหน้า</label>
                                                                        <div class="form-check">
                                                                            <input type="checkbox" class="form-check-input m-1" id="twac_is_pre_cal_1" name="twac_info[]" <?php echo !empty($row_twac) && $twac_data->twac_is_pre_cal == '1' ? 'checked' : '' ?>>
                                                                            <label for="twac_is_pre_cal" class="form-check-label"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 mt-4">
                                                                        <label for="twac_active" class="form-label">สถานะการใช้งาน</label>
                                                                        <div class="form-check">
                                                                            <input type="checkbox" id="twac_active" name="twac_active_1" class="form-check-input m-1" checked disabled>
                                                                            <label for="twac_active" class="form-check-label">เปิดใช้งาน</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header">
                                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddPerson" aria-expanded="true" aria-controls="collapseAddPerson">
                                                                        <i class="bi-window-dock icon-menu"></i><span>ผู้เข้าร่วม</span>
                                                                    </button>
                                                                </h2>
                                                                <div id="collapseAddPerson" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                                                                    <div class="accordion-body">
                                                                        <button class="btn btn-primary mb-2" id="addP" type="button" onclick="getpersonlist($('#departmentName').val(),'paticipate_1',$('#twac_id_1').val())" data-bs-toggle="modal" data-bs-target="#addPersonModal"><i class="bi bi-plus"></i> เพิ่มผู้เข้าร่วม</button>
                                                                        <table class="table paticipate" id="paticipate_1">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col">
                                                                                        <div class="text-center">ลำดับ</div>
                                                                                    </th>
                                                                                    <th class="text-center">รหัสบุคลากร</th>
                                                                                    <th scope="col" width="20%" class="text-center">ชื่อ-นามสกุล</th>
                                                                                    <th scope="col" class="text-center">ประเภทบุคลากร</th>
                                                                                    <th scope="col" class="text-center">ดำเนินการ</th>
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
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="location.href='<?php echo site_url($controller_dir); ?>'">ย้อนกลับ</button>
                            <?php if (!empty($row_twac->twac_id)) { ?>
                                <button type="button" onclick="submitForm('insert')" class="btn btn-success float-end">บันทึก</button>
                            <?php } else { ?>
                                <button type="button" onclick="submitForm('update')" class="btn btn-success float-end">บันทึก</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal สำหรับเลือกสี -->
<div class="modal fade" id="colorPickerModal" tabindex="-1" aria-labelledby="colorPickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="colorPickerModalLabel">เลือกสี</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="color-options d-flex flex-wrap">
                    <!-- Dark Greens -->
                    <button class="color-circle" style="background-color: #1B5E20;" data-color="#1B5E20"></button> <!-- Dark Forest Green -->
                    <button class="color-circle" style="background-color: #2E7D32;" data-color="#2E7D32"></button> <!-- Emerald Green -->
                    <button class="color-circle" style="background-color: #00796B;" data-color="#00796B"></button> <!-- Teal Green -->

                    <!-- Dark Blues -->
                    <button class="color-circle" style="background-color: #0D47A1;" data-color="#0D47A1"></button> <!-- Navy Blue -->
                    <button class="color-circle" style="background-color: #1A237E;" data-color="#1A237E"></button> <!-- Indigo -->
                    <button class="color-circle" style="background-color: #1565C0;" data-color="#1565C0"></button> <!-- Ocean Blue -->

                    <!-- Dark Purples -->
                    <button class="color-circle" style="background-color: #4A148C;" data-color="#4A148C"></button> <!-- Deep Violet -->
                    <button class="color-circle" style="background-color: #6A1B9A;" data-color="#6A1B9A"></button> <!-- Grape Purple -->
                    <button class="color-circle" style="background-color: #7B1FA2;" data-color="#7B1FA2"></button> <!-- Plum Purple -->

                    <!-- Dark Reds -->
                    <button class="color-circle" style="background-color: #B71C1C;" data-color="#B71C1C"></button> <!-- Blood Red -->
                    <button class="color-circle" style="background-color: #C62828;" data-color="#C62828"></button> <!-- Crimson Red -->
                    <button class="color-circle" style="background-color: #880E4F;" data-color="#880E4F"></button> <!-- Burgundy -->

                    <!-- Dark Oranges -->
                    <button class="color-circle" style="background-color: #BF360C;" data-color="#BF360C"></button> <!-- Burnt Orange -->
                    <button class="color-circle" style="background-color: #D84315;" data-color="#D84315"></button> <!-- Rustic Red-Orange -->
                    <button class="color-circle" style="background-color: #F4511E;" data-color="#F4511E"></button> <!-- Clay Orange -->

                    <!-- Dark Browns -->
                    <button class="color-circle" style="background-color: #3E2723;" data-color="#3E2723"></button> <!-- Espresso Brown -->
                    <button class="color-circle" style="background-color: #4E342E;" data-color="#4E342E"></button> <!-- Cocoa Brown -->
                    <button class="color-circle" style="background-color: #5D4037;" data-color="#5D4037"></button> <!-- Mahogany Brown -->

                    <!-- Dark Grays and Blacks -->
                    <button class="color-circle" style="background-color: #212121;" data-color="#212121"></button> <!-- Jet Black -->
                    <button class="color-circle" style="background-color: #424242;" data-color="#424242"></button> <!-- Charcoal Gray -->
                    <button class="color-circle" style="background-color: #616161;" data-color="#616161"></button> <!-- Graphite Gray -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal สำหรับเลือกคน -->
<div class="modal fade" id="addPersonModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addPersonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPersonModalLabel">เพิ่มรายชื่อผู้เข้าร่วม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPersonForm">
                    <div class="mb-3">
                        <div>
                            <label for="personName" class="form-label">หน่วยงาน :</label>
                            <select class="form-control select2 " id="departmentName" onchange="getpersonlist(value)" name="personName" style="width: 100%;">
                                <option value="none" selected disabled>-- เลือกหน่วยงาน --</option>
                                <?php foreach ($base_ums_department_list as $key => $dp) : ?>
                                    <option value="<?= $dp->dp_id ?>" <?= $key == 0 ? 'selected' : '' ?>><?= $dp->dp_name_th ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="" class="form-label">แผนก :</label>
                            <select name="" id="stde_option" class="form-control select2" onchange="getpersonlist($('#departmentName').val())">
                                <option value="all" selected>ทั้งหมด</option>
                            </select>
                        </div>
                        <div>
                            <label for="" class="form-label">รูปแบบ :</label>
                            <select name="" id="add_type" class="form-control select2" onchange="getpersonlist($('#departmentName').val())">
                                <option value="1" selected>รายบุคคล</option>
                                <option value="2">รายกลุ่ม</option>
                            </select>
                        </div>
                        <div class="mt-2" id="div_person">
                            <label for="personName" class="form-label">ชื่อผู้เข้าร่วม :</label>
                            <select class="form-control select2" id="personName" onchange="getpersonInfo(value)" name="personName" style="width: 100%;">
                                <option value="none" selected disabled>-- เลือกผู้เข้าร่วม --</option>
                            </select>
                        </div>
                        <div id="person_info">
                        </div>
                    </div>
                    <!-- Add more fields as needed -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="submit" id="savePerson" class="btn btn-success">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<script>
    // ฟังก์ชันสำหรับจัดการการเลือกสี
    var twac_color_id = 'twac_color_1'
    var selectedColorBox = 'selectedColorBox_1'
    var add_group_list = []
    document.querySelectorAll('.color-circle').forEach(function(button) {
        button.addEventListener('click', function() {
            const twac_color = this.getAttribute('data-color');

            // เปลี่ยนสีของกล่องที่แสดงสีที่เลือก
            document.getElementById(selectedColorBox).style.backgroundColor = twac_color;
            // กำหนดค่าสีที่เลือกลงใน hidden input เพื่อใช้งานในฟอร์ม
            document.getElementById(twac_color_id).value = twac_color;

            // ปิด Modal หลังจากเลือกสี
            var modal = bootstrap.Modal.getInstance(document.getElementById('colorPickerModal'));
            modal.hide();
        });
    });


    function color_select(id, box) {
        twac_color_id = id
        selectedColorBox = box
    }
    $('#addAccordionButton').click(function() {
        let approach_list = document.querySelectorAll('.approach_list');
        let accordionCounter = approach_list.length + 1;
        count_twac = accordionCounter;
        console.log(count_twac);

        let approach_div = document.getElementById('approach');

        // สร้างโครงสร้าง Accordion ใหม่
        const newAccordion = document.createElement('div');
        newAccordion.className = 'accordion-item mt-3 approach_list ';

        newAccordion.innerHTML = `
        <h2 class="accordion-header d-flex align-items-center justify-content-between" id="headingAccordion${accordionCounter}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccordion_${accordionCounter}" aria-expanded="false" aria-controls="collapseAccordion${accordionCounter}">
                <i class="bi-window-dock icon-menu me-2"></i>
                <span>รูปแบบการลงเวลาทำงาน รูปแบบที่ ${accordionCounter}</span>
            </button>
            <span class="btn btn-danger btn-lg accordion-delete-btn" onclick="deleteAccordion(${accordionCounter}); event.stopPropagation();">
                <i class="bi-trash"></i> 
            </span>
        </h2>
        <div id="collapseAccordion_${accordionCounter}" class="accordion-collapse collapse" aria-labelledby="headingAccordion${accordionCounter}" data-bs-parent="#accordionContainer">
            <div class="accordion-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <input type="hidden" name="twac_id" id="twac_id" value="new">
                            <div class="col-md-6 mt-3">
                                <label for="twac_name_th" class="form-label required">ชื่อรูปแบบการลงเวลางาน (ภาษาไทย)</label>
                                <input type="text" class="form-control mb-1" name="twac_info[]" id="twac_name_th_${accordionCounter}" placeholder="ชื่อรูปแบบการลงเวลางาน (ภาษาไทย)" required>
                            </div>
                             <div class="col-md-6 mt-3">
                                <label for="twac_name_th" class="form-label required">ชื่อย่อรูปแบบการลงเวลางาน (ภาษาไทย)</label>
                                <input type="text" class="form-control mb-1" name="twac_info[]" id="twac_name_abbr_th_${accordionCounter}" placeholder="ชื่อย่อรูปแบบการลงเวลางาน (ภาษาไทย)" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="twac_time" class="form-label required">เวลาเข้า-ออกงาน</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="twac_info[]" id="twac_start_time_${accordionCounter}" placeholder="เวลาเข้างาน">
                                    <span class="input-group-text">ถึง</span>
                                    <input type="text" class="form-control" name="twac_info[]" id="twac_end_time_${accordionCounter}" placeholder="เวลาออกงาน">
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <label for="twac_late_time" class="form-label required">เวลาเข้างานสาย </label>
                                    <input type="text" class="form-control" name="twac_info[]" id="twac_late_time_${accordionCounter}" placeholder="เวลาเข้างานสาย">
                            </div>
                            <div class="col-md-3 mt-3">
                                <label for="twac_color" class="form-label">สี</label>
                                <div class="d-flex align-items-center">
                                    <div class="selected-color-box" id="selectedColorBox_${accordionCounter}" onclick="color_select('twac_color_${accordionCounter}','selectedColorBox_${accordionCounter}')" data-bs-toggle="modal" data-bs-target="#colorPickerModal"></div>
                                    <input type="hidden" name="twac_info[]" id="twac_color_${accordionCounter}" value="#1B5E20">
                                </div>
                            </div>
                              <div class="col-md-3 mt-4">
                                 <label for="twac_is_ot" class="form-label">เวลางาน OT </label>
                                 <div class="form-check">
                                    <input type="checkbox" class="form-check-input m-1" id="twac_is_ot_${accordionCounter}" name="twac_info[]" >
                                         <label for="twac_is_ot" class="form-check-label"></label>
                                 </div>
                              </div>
                                <div class="col-md-3 mt-4">
                                     <label for="twac_is_ot" class="form-label">รวมเวลาพักระหว่างวัน</label>
                                     <div class="form-check">
                                      <input type="checkbox" class="form-check-input m-1" id="twac_is_break_${accordionCounter}" name="twac_info[]" >
                                       <label for="twac_is_break" class="form-check-label"></label>
                                     </div>
                                </div>
                                <div class="col-md-3 mt-4">
                                   <label for="twac_is_ot" class="form-label">คำนวณช่วงเวลาจากวันก่อนหน้า</label>
                                    <div class="form-check">
                                    <input type="checkbox" class="form-check-input m-1" id="twac_is_pre_cal_${accordionCounter}" name="twac_info[]" >
                                    <label for="twac_is_pre_cal" class="form-check-label"></label>
                                     </div>
                                  </div>
                               <div class="col-md-3 mt-4">
                                   <label for="twac_active" class="form-label">สถานะการใช้งาน</label>
                                         <div class="form-check">
                                             <input type="checkbox" id="twac_active_${accordionCounter}" name="twac_info[]" class="form-check-input m-1" checked disabled>
                                             <label for="twac_active" class="form-check-label">เปิดใช้งาน</label>
                                          </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="accordion">
                          <div class="accordion-item">
                                   <h2 class="accordion-header">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddPerson" aria-expanded="true" aria-controls="collapseAddPerson">
                                                                <i class="bi-window-dock icon-menu"></i><span>ผู้เข้าร่วม</span>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseAddPerson" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                                                            <div class="accordion-body">
                                                                <button class="btn btn-primary mb-2" id="addP" type="button" onclick="getpersonlist($('#departmentName').val(),'paticipate_${accordionCounter}',$('#twac_id_${accordionCounter}').val())" data-bs-toggle="modal" data-bs-target="#addPersonModal"><i class="bi bi-plus"></i> เพิ่มผู้เข้าร่วม</button>
                                                                <table class="table paticipate" id="paticipate_${accordionCounter}">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">
                                                                                <div class="text-center">ลำดับ</div>
                                                                            </th>
                                                                            <th class="text-center">รหัสบุคลากร</th>
                                                                            <th scope="col" width="20%" class="text-center">ชื่อ-นามสกุล</th>
                                                                            <th scope="col" class="text-center">ประเภทบุคลากร</th>
                                                  <th scope="col" class="text-center">ดำเนินการ</th>
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
        </div>`;

        // เพิ่ม Accordion ใหม่เข้าไปใน DOM
        approach_div.appendChild(newAccordion);

        // กำหนด flatpickr สำหรับฟิลด์เวลา
        flatpickr(`#twac_start_time_${accordionCounter}`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: "08:00", // ค่าเริ่มต้น
        });

        flatpickr(`#twac_end_time_${accordionCounter}`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: "17:00", // ค่าเริ่มต้น
        });
        flatpickr(`#twac_late_time_${accordionCounter}`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: "08:01", // ค่าเริ่มต้น
        });
    });

    function deleteAccordion(accordionCounter) {
        // หยุดการทำงานของ Bootstrap accordion
        // ลบ Accordion Header และ Content
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการลบรูปแบบการทำงานนี้ ใช่หรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                if (person_list[`paticipate_${accordionCounter}`] && person_list[`paticipate_${accordionCounter}`].length > 0) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': 'มีการใช้งานรูปแบบการทำงานนี้'
                    });
                    return
                }
                const accordionHeader = document.getElementById(`headingAccordion${accordionCounter}`);
                const accordionContent = document.getElementById(`collapseAccordion_${accordionCounter}`);

                if (accordionHeader) {
                    // หา approach_list ที่ใกล้ที่สุดกับ accordionHeader
                    const closestApproachList = accordionHeader.closest('.approach_list');

                    // ลบ approach_list หากพบ
                    if (closestApproachList) {
                        closestApproachList.remove();
                    } else {
                        // หากไม่พบ ให้ลบ accordionHeader ตามปกติ
                        accordionHeader.remove();
                    }
                }
                if (accordionContent) accordionContent.remove();
            }
        })

        console.log(`ลบ Accordion ID: ${accordionCounter}`);
    }
    var person_list = []
    var add_groupPerson_list = []
    var count_twac = 0
    var paticipate_table = 'paticipate_1'
    var twac_id = 0
    var twag_id = '<?php echo isset($twag_data->twag_id) ? $twag_data->twag_id : 'new' ?>';
    <?php if (isset($row_twac)) { ?>
        // ใช้ json_encode เพื่อแปลง array PHP เป็น JSON
        <?php foreach ($row_twac as $key => $value) { ?>
            var key = 'paticipate_<?= $key + 1; ?>'
            person_list[key] = <?php echo json_encode($value->twac_person); ?>;
            if (person_list == null) {
                person_list = []
            }
        <?php } ?>
    <?php } ?>

    $(document).ready(function() {
        // Initialize flatpickr for start, end, and late time fields
        flatpickr(`.set_start_time`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
           
        });

        flatpickr(`.set_end_time`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
           
        });

        flatpickr(`.setTime`, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
           
        });

    });

    function getpersonlist(dp_id, table, tid) {
        $('#personName').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#addPersonModal')
        });
        $('#departmentName').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#addPersonModal')
        });

        if (tid) {
            twac_id = tid
        }
        if (table) {
            paticipate_table = table
        }
        let checkHire = document.getElementsByName('option_twag_type');
        let checkPart = document.getElementsByName('option_twag_is_medical');
        let stde_id = $('#stde_option').val()

        let add_type = $('#add_type').val()
        let hire_type = null;
        let hire_is_medical = null;
        checkHire.forEach((checkbox) => {
            if (checkbox.checked) {
                hire_type = checkbox.value;
            }
        });
        checkPart.forEach((checkbox) => {
            if (checkbox.checked) {
                hire_is_medical = checkbox.value;
            }
        });
        $.ajax({
            method: "post",
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_person_list_dp_id',
            data: {
                dp_id: dp_id,
                stde_id,
                hire_type: hire_type,
                hire_is_medical: hire_is_medical
            }
        }).done(function(data) {
            data = JSON.parse(data);
            let dropdown = $('#personName');
            dropdown.empty(); // Clear any existing options
            add_groupPerson_list = []
            // ปิดการทำงานของ event change ชั่วคราว

            $('#stde_option').empty();
            if (data.name_stde_th.length > 0) {
                $('#div_person').show()
                $('#stde_option').append(`<option value="all" ${stde_id =='all' ? 'slected':''}>ทั้งหมด</option>`);
                data.name_stde_th.forEach(function(option) {
                    $('#stde_option').append(`<option value="${option.stde_id}" ${stde_id == option.stde_id ? 'selected' : ''}>${option.stde_name_th}</option>`);
                });
            } else {
                $('#stde_option').append(`<option value="all" selected>ทั้งหมด</option>`);
            }

            if (add_type == 1 && data.person_option.length > 0) {
                data.person_option.forEach(function(option) {
                    dropdown.append(`<option value="${option.ps_id}">${option.ps_name}</option>`);
                });
            } else {
                $('#div_person').hide()
                data.person_option.forEach(function(option) {
                    var newPerson = {
                        'ps_id': option.person_id,
                        'twap_status': 1,
                        'pos_dp_id': option.pos_dp_id,
                        'check': 'new',
                        "pos_ps_code": option.pos_ps_code,
                        "ps_name": option.ps_list,
                        "hire_name": option.hire_abbr
                    };
                    add_groupPerson_list.push(newPerson);
                });
            }
        });
    }

    function getpersonInfo(ps_id) {
        var person_div = document.getElementById('person_info');
        $.ajax({
            method: "post",
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_person_info',
            data: {
                ps_id: ps_id,
                dp_id: $('#departmentName').val()
            }
        }).done(function(data) {
            data = JSON.parse(data);
            const div_person = document.getElementById('person_info')
            div_person.innerHTML = ``
            // Update your person_div with the returned data if necessary
        });
    }
    document.getElementById('savePerson').addEventListener('click', function() {
        var ps_id = $('#personName').val()
        let add_type = $('#add_type').val()
        let found = false;
        if (add_type == 1) {
            if (twac_id != 'new') {
                $.ajax({
                    method: "post",
                    url: '<?php echo site_url() . "/" . $controller_dir; ?>check_person',
                    data: {
                        ps_id: ps_id,
                        twac_id: twac_id,
                    }
                }).done(function(data) {
                    data = JSON.parse(data)
                    if (data.data.status_response == 2) {
                        dialog_error({
                            'header': text_toast_default_error_header,
                            'body': 'เลือกผู้เข้าร่วมซ้ำในโครงการ'
                        });
                        return 0;
                    } else {
                        $.ajax({
                            method: "post",
                            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_person_info',
                            data: {
                                ps_id: ps_id,
                                dp_id: $('#departmentName').val()
                            }
                        }).done(function(data_info) {
                            data_info = JSON.parse(data_info)
                            if (person_list[paticipate_table]) {
                                if (person_list[paticipate_table].length > 0) {
                                    person_list[paticipate_table].forEach(function(person) {
                                        if (person.ps_id == parseInt(data_info.person.ps_id)) {
                                            found = true;
                                        }
                                    });
                                }
                            } else {
                                person_list[paticipate_table] = []
                            }
                            if (found) {
                                dialog_error({
                                    'header': text_toast_default_error_header,
                                    'body': 'เลือกผู้เข้าร่วมซ้ำในโครงการ'
                                });
                                return 0;
                            }

                            var table = document.getElementById(paticipate_table);
                            var rowCount = table.getElementsByTagName("tr").length;
                            var row = table.insertRow(-1); // Insert new row at the end
                            var cell1 = row.insertCell(0); // Insert cell for name
                            var cell2 = row.insertCell(1); // Insert cell for age
                            var cell3 = row.insertCell(2); // Insert cell for age
                            // var cell4 = row.insertCell(3); // Insert cell for age
                            // var cell5 = row.insertCell(4); // Insert cell for age
                            // var cell6 = row.insertCell(5); // Insert cell for cell
                            var cell7 = row.insertCell(3);
                            var cell8 = row.insertCell(4);
                            cell1.innerHTML = rowCount;
                            cell1.style.textAlign = "center";
                            cell2.innerHTML = data_info.person.detail.pos_ps_code;
                            cell2.style.textAlign = "center";
                            cell3.innerHTML = data_info.person.pf_name_abbr + ' ' + data_info.person.ps_fname + ' ' + data_info.person.ps_lname
                            // cell4.innerHTML = ''
                            // cell5.innerHTML = ''
                            // cell6.innerHTML = ''
                            cell7.innerHTML = data_info.person.detail.hire_name
                            cell8.innerHTML = `<button class="btn btn-sm btn-danger delPerson" data-table-id ="${paticipate_table}" data-id="${data_info.person.ps_id}"><i class="bi bi-trash delPerson"  data-table-id ="${paticipate_table}" data-id="${data_info.person.ps_id}"> </i> </button>`
                            cell8.style.textAlign = "center";

                            var newPerson = {
                                'ps_id': parseInt(data_info.person.ps_id),
                                'twap_status': 1,
                                'pos_dp_id': data_info.person.pos_dp_id,
                                'check': 'new',
                                "pos_ps_code": data_info.person.pos_ps_code,
                                "ps_name": data_info.person.ps_fname + ' ' + data_info.person.ps_lname,
                                "hire_name": data_info.person.detail.hire_name
                            };
                            person_list[paticipate_table].push(newPerson);
                            dialog_success({
                                'header': text_toast_default_success_header,
                                'body': 'เพิ่มผู้เข้าร่วมสำเร็จ'
                            });
                            $('#addPersonModal').modal('hide');

                        })
                    }
                })
            } else {
                $.ajax({
                    method: "post",
                    url: '<?php echo site_url() . "/" . $controller_dir; ?>get_person_info',
                    data: {
                        ps_id: ps_id,
                        dp_id: $('#departmentName').val()
                    }
                }).done(function(data) {
                    data = JSON.parse(data)
                    person_list.forEach(function(person) {
                        if (person.ps_id == parseInt(data.person.ps_id)) {
                            found = true;
                        }
                    });
                    if (found) {
                        dialog_error({
                            'header': text_toast_default_error_header,
                            'body': 'เลือกผู้เข้าร่วมซ้ำในโครงการ'
                        });
                        return 0;
                    }

                    var table = document.getElementById(paticipate_table);

                    var rowCount = table.getElementsByTagName("tr").length;
                    var row = table.insertRow(-1); // Insert new row at the end
                    var cell1 = row.insertCell(0); // Insert cell for name
                    var cell2 = row.insertCell(1); // Insert cell for age
                    var cell3 = row.insertCell(2); // Insert cell for age
                    // var cell4 = row.insertCell(3); // Insert cell for age
                    // var cell5 = row.insertCell(4); // Insert cell for age
                    // var cell6 = row.insertCell(5); // Insert cell for cell
                    var cell7 = row.insertCell(3);
                    var cell8 = row.insertCell(4);
                    cell1.innerHTML = rowCount;
                    cell1.style.textAlign = "center";
                    cell2.innerHTML = data.person.pos_ps_code;
                    cell3.innerHTML = data.person.pf_name_abbr + ' ' + data.person.ps_fname + ' ' + data.person.ps_lname
                    // cell4.innerHTML = ''
                    // cell5.innerHTML = ''
                    // cell6.innerHTML = ''
                    cell7.innerHTML = data.person.detail.hire_name
                    cell8.innerHTML = `<button class="btn btn-sm btn-danger delPerson" type="button" data-table-id ="${paticipate_table}" data-id="${data.person.ps_id}"><i class="bi bi-trash delPerson" data-id="${data.person.ps_id}" data-table-id ="${paticipate_table}"> </i> </button>`
                    cell8.style.textAlign = "center";
                    var newPerson = {
                        'ps_id': parseInt(data.person.ps_id),
                        'twap_status': 1,
                        'pos_dp_id': data.person.pos_dp_id,
                        'check': 'new',
                        "pos_ps_code": data.person.pos_ps_code,
                        "ps_name": data.person.ps_fname + ' ' + data.person.ps_lname,
                        "hire_name": data.person.detail.hire_name
                    };
                    if (!person_list[paticipate_table]) {
                        person_list[paticipate_table] = []
                    }
                    person_list[paticipate_table].push(newPerson);
                    dialog_success({
                        'header': text_toast_default_success_header,
                        'body': 'เพิ่มผู้เข้าร่วมสำเร็จ'
                    });
                    $('#addPersonModal').modal('hide');

                })
            }
        } else {
            if (person_list[paticipate_table]) {
                add_groupPerson_list.forEach(function(person) {
                    let found = person_list[paticipate_table].some(item => item.ps_id == person.ps_id);
                    if (found == false) {
                        var table = document.getElementById(paticipate_table);
                        var rowCount = table.getElementsByTagName("tr").length;
                        var row = table.insertRow(-1); // Insert new row at the end
                        var cell1 = row.insertCell(0); // Insert cell for name
                        var cell2 = row.insertCell(1); // Insert cell for age
                        var cell3 = row.insertCell(2); // Insert cell for age
                        // var cell4 = row.insertCell(3); // Insert cell for age
                        // var cell5 = row.insertCell(4); // Insert cell for age
                        // var cell6 = row.insertCell(5); // Insert cell for cell
                        var cell7 = row.insertCell(3);
                        var cell8 = row.insertCell(4);
                        cell1.innerHTML = rowCount;
                        cell1.style.textAlign = "center";
                        cell2.innerHTML = person.pos_ps_code;
                        cell2.style.textAlign = "center";
                        cell3.innerHTML = person.ps_name
                        cell7.innerHTML = person.hire_name
                        cell8.innerHTML = `<button class="btn btn-sm btn-danger delPerson" data-table-id ="${paticipate_table}" data-id="${person.ps_id}"><i class="bi bi-trash delPerson"  data-table-id ="${paticipate_table}" data-id="${person.ps_id}"> </i> </button>`
                        cell8.style.textAlign = "center";
                        var newPerson = {
                            'ps_id': person.ps_id,
                            'twap_status': 1,
                            'pos_dp_id': person.pos_dp_id,
                            'check': 'new',
                            "pos_ps_code": person.pos_ps_code,
                            "ps_name": person.ps_name,
                            "hire_name": person.hire_name
                        };
                        person_list[paticipate_table].push(newPerson);
                    }
                   console.log(person_list);
                   
                });
                $('#addPersonModal').modal('hide');
            } else {
                add_groupPerson_list.forEach(function(person) {
                    var table = document.getElementById(paticipate_table);
                    var rowCount = table.getElementsByTagName("tr").length;
                    var row = table.insertRow(-1); // Insert new row at the end
                    var cell1 = row.insertCell(0); // Insert cell for name
                    var cell2 = row.insertCell(1); // Insert cell for age
                    var cell3 = row.insertCell(2); // Insert cell for age
                    // var cell4 = row.insertCell(3); // Insert cell for age
                    // var cell5 = row.insertCell(4); // Insert cell for age
                    // var cell6 = row.insertCell(5); // Insert cell for cell
                    var cell7 = row.insertCell(3);
                    var cell8 = row.insertCell(4);
                    cell1.innerHTML = rowCount;
                    cell1.style.textAlign = "center";
                    cell2.innerHTML = person.pos_ps_code;
                    cell2.style.textAlign = "center";
                    cell3.innerHTML = person.ps_name
                    cell7.innerHTML = person.hire_name
                    cell8.innerHTML = `<button class="btn btn-sm btn-danger delPerson" data-table-id ="${paticipate_table}" data-id="${person.ps_id}"><i class="bi bi-trash delPerson"  data-table-id ="${paticipate_table}" data-id="${person.ps_id}"> </i> </button>`
                    cell8.style.textAlign = "center";
                    var newPerson = {
                        'ps_id': person.ps_id,
                        'twap_status': 1,
                        'pos_dp_id': person.pos_dp_id,
                        'check': 'new',
                        "pos_ps_code": person.pos_ps_code,
                        "ps_name": person.ps_name,
                        "hire_name": person.hire_name
                    };
                    person_list[paticipate_table].push(newPerson);
                });
                $('#addPersonModal').modal('hide');
            }
        }
    })
    document.getElementById('approach').addEventListener('click', function(event) {
        if (event.target.classList.contains('delPerson')) {
            const button = event.target;
            const dataId = button.getAttribute('data-id'); // ID ของแถว
            const tableId = button.getAttribute('data-table-id'); // ID ของตาราง
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณต้องการลบผู้เข้าร่วมคนนี้ ใช่หรือไม่!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ลบข้อมูลจากตัวแปร
                    var index = person_list[tableId].findIndex(item => item.ps_id == dataId);
                    if (index !== -1) {
                        if (person_list[tableId][index].check === 'new') {
                            person_list[tableId].splice(index, 1);
                        } else {
                            person_list[tableId][index].twap_status = 0;
                        }
                    }
                    // ลบแถวออกจาก DOM
                    const row = button.closest('tr');
                    if (row) row.remove();
                }
            });
        }
    });

    function submitForm(actionType) {
        var form = $('#attendange_form')[0];
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        var sumbmitData = {}
        var form_attendance_config = new FormData(form);
        for (let [key, value] of form_attendance_config.entries()) {
            if (key.includes('twag')) {
                sumbmitData[key] = value
            }
        }
        let approach_list = document.querySelectorAll('.approach_list');
        sumbmitData['twac_data'] = {};
        let key = ['twac_id', 'twac_name_th', 'twac_name_abbr_th', 'twac_start_time', 'twac_end_time', 'twac_late_time', 'twac_color', 'twac_is_ot', 'twac_active', 'twac_is_break', 'twac_is_pre_cal']
        let arr_index = 0;
        $('.approach_list').each(function() {
            sumbmitData['twac_data'][arr_index] = {}; // สร้างออบเจกต์ใหม่สำหรับแต่ละ approach_list
            let person_id_list = ''
            $(this).find('[name^="twac_info"]').each(function() {
                // หา key ที่ id มีค่าเป็นส่วนหนึ่ง
                const key_id = key.find(k => this.id.includes(k));
                if (key_id) { // หาก id มี key ที่ตรงกัน
                    // if(key_id == '')
                    if (key_id == 'twac_active' || key_id == 'twac_is_ot' || key_id == 'twac_is_break' || key_id == 'twac_is_pre_cal') {
                        console.log(this.id);
                        var checkbox = document.getElementById(this.id);
                        if (checkbox.checked) {
                            sumbmitData['twac_data'][arr_index][key_id] = 1
                        }
                    } else {
                        sumbmitData['twac_data'][arr_index][key_id] = $(this).val(); // เก็บค่าลงใน key_id ที่เจอ
                    }
                }
            });
            $(this).find('.paticipate').each(function() {
                person_id_list = this.id;
            })
            sumbmitData['twac_data'][arr_index]['twap_data'] = person_list[person_id_list]
            arr_index++;
        });

        // for (let index = 1; index <= approach_list.length; index++) {
        //     sumbmitData['twac_info'][index - 1] = {
        //         twac_id: $(`#twac_id_${index}`).val(),
        //         twac_name_th: $(`#twac_name_th_${index}`).val(),
        //         twac_name_abbr_th: $(`#twac_name_abbr_th_${index}`).val(),
        //         twac_start_time: $(`#twac_start_time_${index}`).val(),
        //         twac_end_time: $(`#twac_end_time_${index}`).val(),
        //         twac_late_time: $(`#twac_late_time_${index}`).val(),
        //         twac_color: $(`#twac_color_${index}`).val(),
        //         twac_is_ot: $(`#twac_is_ot_${index}`).val()
        //     };
        // }
        // console.log(sumbmitData);
        // return 0;
        form_attendance_config.append('action', actionType);
        form_attendance_config.append('twac_person', JSON.stringify(person_list));
        $.ajax({
            url: '<?php echo site_url($controller_dir . "attendance_config_save"); ?>',
            type: 'POST',
            data: sumbmitData,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status_response == status_response_success) {
                    dialog_success({
                        'header': text_toast_save_success_header,
                        'body': data.message_dialog
                    }, data.return_url, false);
                } else if (data.status_response == status_response_error) {
                    dialog_error({
                        'header': text_toast_default_error_header,
                        'body': data.message_dialog
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
</script>