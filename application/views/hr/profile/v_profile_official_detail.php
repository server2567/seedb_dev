<style>
    .form-switch .form-check-input {
        width: 3em;
    }
</style>
<form method="post" class="needs-validation" id="profile_official_form_<?php echo $dp_id; ?>" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="ps_id" id="ps_id" value="<?php echo encrypt_id($ps_id); ?>">
    <input type="hidden" name="pos_id" id="pos_id" value="<?php echo encrypt_id($pos_id); ?>">
    <input type="hidden" name="dp_id" id="dp_id" value="<?php echo encrypt_id($dp_id); ?>">
    <!-- <input type="hidden" name="pos_active_<?php echo $dp_id; ?>" id="pos_active_<?php echo $dp_id; ?>" value="<?php echo (isset($row_position[$dp_id]) ? encrypt_id($row_position[$dp_id]->pos_active) : ""); ?>">    -->

    <div class="row">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="bi bi-briefcase icon-menu font-20"></i>จัดการข้อมูลการทำงาน<?php echo $dp_name; ?>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <a href="javascript:void(0);" class="float-end" id="btn_position_history" onclick="show_position_history_modal('<?php echo encrypt_id($ps_id); ?>')">ประวัติการเปลี่ยนข้อมูลการทำงาน </a>
                                </div>
                                <div class="col-md-12 mb-3 mt-3">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_ps_code_<?php echo $dp_id; ?>" class="form-label required">รหัสประจำตัวบุคลากร</label></div>
                                        <div class="col-md-8">
                                            <input type="text" id="pos_ps_code_<?php echo $dp_id; ?>" name="pos_ps_code_<?php echo $dp_id; ?>" class="form-control" value="<?php echo (isset($row_position[$dp_id]) ? $row_position[$dp_id]->pos_ps_code : ""); ?>">
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 mt-3">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_work_start_date_<?php echo $dp_id; ?>" class="form-label required">วันที่เริ่มปฏิบัติงาน</label></div>
                                        <div class="col-md-8">
                                            <input type="text" id="pos_work_start_date_<?php echo $dp_id; ?>" name="pos_work_start_date_<?php echo $dp_id; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 text-danger" id="check_status_<?= $dp_id ?>"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_hire_id_<?php echo $dp_id; ?>" class="form-label required">ประเภทบุคลากร</label></div>
                                        <div class="col-md-8">
                                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกประเภทบุคลากร --" onchange="changeHire(value,<?= $dp_id ?>)" name="pos_hire_id_<?php echo $dp_id; ?>" id="pos_hire_id_<?php echo $dp_id; ?>" required>
                                                <option value="">-- เลือกประเภทบุคลากร --</option>
                                                <?php
                                                foreach ($base_hire_list as $key => $row) {
                                                ?>
                                                    <option value="<?php echo $row->hire_id; ?>" <?php echo (isset($row_position[$dp_id]) && $row_position[$dp_id]->pos_hire_id == $row->hire_id ? "selected" : ""); ?>><?php echo $row->hire_name . " " . $row->hire_is_medical_label; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4" id="div_pos_trial_day_<?= $dp_id ?>">
                                    <div class="row">
                                        <div class="col-md-3 col-3 text-end"> <label for="pos_hire_id_<?php echo $dp_id; ?>" class="form-label required">จำนวนวันทดลองงาน</label></div>
                                        <div class="col-md-8 col-9">
                                            <select class="form-select" data-placeholder="-- กรุณาเลือกประเภทบุคลากร --" name="pos_trial_day_<?php echo $dp_id; ?>" id="pos_trial_day_<?php echo $dp_id; ?>" required>
                                                <option value="90"  <?php echo (isset($row_position[$dp_id]) && $row_position[$dp_id]->pos_trial_day == 90 ? "selected" : ""); ?>>90 วัน</option>
                                                <option value="119" <?php echo (isset($row_position[$dp_id]) && $row_position[$dp_id]->pos_trial_day == 119 ? "selected" : ""); ?>>119 วัน</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_admin_id_<?php echo $dp_id; ?>" class="form-label">ตำแหน่งในการบริหาร</label></div>
                                        <div class="col-md-8">
                                            <select class="form-select select2 multi1" multiple data-placeholder="-- กรุณาเลือกตำแหน่งในการบริหาร --" name="pos_admin_id_<?php echo $dp_id; ?>" id="pos_admin_id_<?php echo $dp_id; ?>" required>
                                                <option value="" disabled>-- เลือกตำแหน่งในการบริหาร --</option>
                                                <?php
                                                foreach ($base_admin_position_list as $key => $row) {
                                                ?>
                                                    <?php if (count($row_position[$dp_id]->admin_po) > 0) : ?>
                                                        <?php $index = 1 ?>
                                                        <?php foreach ($row_position[$dp_id]->admin_po as $admin_po) { ?>
                                                            <?php
                                                            if ($admin_po->psap_admin_id == $row->admin_id) : ?>
                                                                <option value="<?php echo $row->admin_id; ?>" <?php echo ($admin_po->psap_admin_id == $row->admin_id ? "selected" : ""); ?>><?php echo $row->admin_name; ?></option>
                                                                <?php break; ?>
                                                            <?php elseif ($index == count($row_position[$dp_id]->admin_po)) : ?>
                                                                <option value="<?php echo $row->admin_id; ?>"><?php echo $row->admin_name; ?></option>
                                                            <?php endif; ?>
                                                            <?php $index++ ?>
                                                        <?php } ?>
                                                    <?php else : ?>
                                                        <option value="<?php echo $row->admin_id; ?>"><?php echo $row->admin_name; ?></option>
                                                    <?php endif; ?>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_alp_id_<?php echo $dp_id; ?>" class="form-label required">ตำแหน่งปฏิบัติงาน</label></div>
                                        <div class="col-md-8">
                                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกตำแหน่งปฏิบัติงาน --" name="pos_alp_id_<?php echo $dp_id; ?>" id="pos_alp_id_<?php echo $dp_id; ?>" required>
                                                <option value="">-- เลือกตำแหน่งปฏิบัติงาน --</option>
                                                <?php
                                                foreach ($base_adline_position_list as $key => $row) {
                                                ?>
                                                    <option value="<?php echo $row->alp_id; ?>" <?php echo (isset($row_position[$dp_id]) && $row_position[$dp_id]->pos_alp_id == $row->alp_id ? "selected" : ""); ?>><?php echo $row->alp_name; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_spcl_id_<?php echo $dp_id; ?>" class="form-label">ตำแหน่งงานเฉพาะทาง</label></div>
                                        <div class="col-md-8">
                                            <select class="form-select select2 multi2" multiple data-placeholder="-- กรุณาเลือกตำแหน่งงานเฉพาะทาง --" name="pos_spcl_id_<?php echo $dp_id; ?>" id="pos_spcl_id_<?php echo $dp_id; ?>" required>
                                                <option value="" disabled>-- เลือกตำแหน่งงานเฉพาะทาง --</option>
                                                <?php
                                                foreach ($base_special_position_list as $key => $row) {
                                                ?>
                                                    <?php if (count($row_position[$dp_id]->spcl_po) > 0) : ?>
                                                        <?php $index = 1 ?>
                                                        <?php foreach ($row_position[$dp_id]->spcl_po as $spcl_po) { ?>
                                                            <?php
                                                            if ($spcl_po->pssp_spcl_id == $row->spcl_id) : ?>
                                                                <option value="<?php echo $row->spcl_id; ?>" <?php echo ($spcl_po->pssp_spcl_id == $row->spcl_id ? "selected" : ""); ?>><?php echo $row->spcl_name; ?></option>
                                                                <?php break; ?>
                                                            <?php elseif ($index == count($row_position[$dp_id]->spcl_po)) : ?>
                                                                <option value="<?php echo $row->spcl_id; ?>"><?php echo $row->spcl_name; ?></option>
                                                            <?php endif; ?>
                                                            <?php $index++ ?>
                                                        <?php } ?>
                                                    <?php else : ?>
                                                        <option value="<?php echo $row->spcl_id; ?>"><?php echo $row->spcl_name; ?></option>
                                                    <?php endif; ?>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_stuc_id_<?php echo $dp_id; ?>" class="form-label">ตำแหน่งในโครงสร้าง</label></div>
                                        <div class="col-md-9"></div>
                                        <div class="col-md-12 text-center">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <div class="accordion" id="accordionExample2" style="width: 80%;">
                                                    <!-- โครงสร้างปัจจุบัน -->
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingCurrent">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCurrent" aria-expanded="true" aria-controls="collapseCurrent">
                                                                โครงสร้างปัจจุบัน
                                                            </button>
                                                        </h2>
                                                        <div id="collapseCurrent" class="accordion-collapse collapse show" aria-labelledby="headingCurrent" data-bs-parent="#accordionExample2">
                                                            <div class="accordion-body">
                                                                <table class="table mx-auto" id="currentTable" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center">#</th>
                                                                            <th class="text-center" width="25%">โครงสร้างหน่วยงาน</th>
                                                                            <th class="text-center">หน่วยงานที่สังกัด</th>
                                                                            <th class="text-center">ดำเนินการ</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php if (count($stuc_info[$dp_id]) > 0) : ?>
                                                                            <?php foreach ($stuc_info[$dp_id] as $key => $value): ?>
                                                                                <?php if ($value->stuc_status == 1): // โครงสร้างปัจจุบัน 
                                                                                ?>
                                                                                    <?php
                                                                                    $stde_list = json_decode($value->stde_list);
                                                                                    $rowCount = count($stde_list) == 0 ? 1 : count($stde_list);
                                                                                    ?>

                                                                                    <tr>
                                                                                        <td rowspan="<?= $rowCount + 1 ?>" class="text-center" id="key_column"><?= $key + 1 ?></td>
                                                                                        <td rowspan="<?= $rowCount + 1 ?>" class="text-center" id="confirm_stuc"><?= fullDateTH3($value->stuc_confirm_date) ?> (โครงสร้างปัจจุบัน)</td>
                                                                                        <?php if (count($stde_list) > 0) : ?>
                                                                                            <td class="text-center">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12 font-12 pos-<?= $dp_id ?>-0"><?= $stde_list[0]->stde_pos ?></div>
                                                                                                    <div class="col-md-12 stde-<?= $dp_id ?>-0"><?= $stde_list[0]->stde_name ?></div>
                                                                                                </div>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <button class="btn btn-warning editStuc btn-sm"
                                                                                                    data-bs-toggle="modal"
                                                                                                    type="button"
                                                                                                    data-bs-target="#editModal"
                                                                                                    data-id="<?= $stde_list[0]->stdp_id ?>"
                                                                                                    data-stde="<?= $stde_list[0]->stdp_stde_id ?>"
                                                                                                    data-dp="<?= $dp_id ?>"
                                                                                                    data-pos="<?= $stde_list[0]->stdp_po_id ?>"
                                                                                                    data-status="<?= $stde_list[0]->stdp_active ?>"
                                                                                                    data-index="0"
                                                                                                    data-check="old">
                                                                                                    <i class="bi bi-pencil"></i>
                                                                                                </button>

                                                                                                <button class="btn btn-danger delete-btn  btn-sm" type="button" data-check="old" data-id="<?= $stde_list[0]->stdp_id ?>" data-stde="<?= $stde_list[0]->stdp_stde_id ?>" data-index="0"><i class="bi bi-trash"></i></button>
                                                                                            </td>
                                                                                        <?php endif; ?>
                                                                                    </tr>
                                                                                    <?php for ($i = 1; $i < $rowCount; $i++): ?>
                                                                                        <tr>
                                                                                            <td class="text-center">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12 font-12 pos-<?= $dp_id . '-' . $i ?>"><?= $stde_list[$i]->stde_pos ?></div>
                                                                                                    <div class="col-md-12 stde-<?= $dp_id . '-' . $i ?>"><?= $stde_list[$i]->stde_name ?></div>
                                                                                                </div>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <button class="btn btn-warning editStuc btn-sm"
                                                                                                    type="button"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#editModal"
                                                                                                    data-id="<?= $stde_list[$i]->stdp_id ?>"
                                                                                                    data-stde="<?= $stde_list[$i]->stdp_stde_id ?>"
                                                                                                    data-dp="<?= $dp_id ?>"
                                                                                                    data-pos="<?= $stde_list[$i]->stdp_po_id ?>"
                                                                                                    data-status="<?= $stde_list[$i]->stdp_active ?>"
                                                                                                    data-index="<?= $i ?>"
                                                                                                    data-check="old">
                                                                                                    <i class="bi bi-pencil"></i>
                                                                                                </button>
                                                                                                <button class="btn btn-danger delete-btn  btn-sm" type="button" data-check="old" data-id="<?= $stde_list[$i]->stdp_id ?>" data-stde="<?= $stde_list[$i]->stdp_stde_id ?>" data-index="<?= $i ?>"><i class="bi bi-trash"></i></button>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php endfor; ?>
                                                                                    <tr>
                                                                                        <td colspan="2" class="text-center">
                                                                                            <button class="btn btn-success addStuc btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editModal" data-dp="<?= $dp_id ?>" data-id="<?= $value->stuc_id ?>" data-index="<?= $rowCount ?>"><i class="bi bi-plus"></i></button>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- โครงสร้างเก่า -->
                                                    <?php if (count($stuc_info[$dp_id]) > 0) : ?>
                                                        <?php $found = array_filter($stuc_info[$dp_id], function ($item) {
                                                            return isset($item->stuc_status) && $item->stuc_status == 0;
                                                        }); ?>
                                                        <?php if ($found) : ?>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingOld">
                                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOld" aria-expanded="false" aria-controls="collapseOld">
                                                                        โครงสร้างเก่า
                                                                    </button>
                                                                </h2>
                                                                <div id="collapseOld" class="accordion-collapse collapse" aria-labelledby="headingOld" data-bs-parent="#accordionExample2">
                                                                    <div class="accordion-body">
                                                                        <table class="table mx-auto" style="width: 100%;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">#</th>
                                                                                    <th class="text-center">โครงสร้างหน่วยงาน</th>
                                                                                    <th class="text-center">หน่วยงานที่สังกัด</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($stuc_info[$dp_id] as $key => $value): ?>
                                                                                    <?php if ($value->stuc_status == 0): // โครงสร้างเก่า 
                                                                                    ?>
                                                                                        <?php
                                                                                        $stde_list = json_decode($value->stde_list);
                                                                                        $rowCount = count($stde_list);
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td rowspan="<?= $rowCount ?>" class="text-center"><?= $key + 1 ?></td>
                                                                                            <td rowspan="<?= $rowCount ?>" class="text-center"><?= fullDateTH3($value->stuc_confirm_date) ?> (โครงสร้างเก่า)</td>
                                                                                            <td class="text-center">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12 font-12"><?= $stde_list[0]->stde_pos ?></div>
                                                                                                    <div class="col-md-12"><?= $stde_list[0]->stde_name ?></div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php for ($i = 1; $i < $rowCount; $i++): ?>
                                                                                            <tr>
                                                                                                <td class="text-center">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-12 font-12"><?= $stde_list[$i]->stde_pos ?></div>
                                                                                                        <div class="col-md-12"><?= $stde_list[$i]->stde_name ?></div>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        <?php endfor; ?>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <!-- HTML Bootstrap Accordion -->
                                        </div>
                                        <!-- <div class="col-md-6 text-end"> <label for="pos_spcl_id_<?php echo $dp_id; ?>" class="form-label">โครงสร้างหน่วยงาน</label></div>
                                        <div class="col-md-6">
                                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกตำแหน่งงานเฉพาะทาง --" name="pos_stuc_id_<?php echo $dp_id; ?>" id="pos_stuc_id_<?php echo $dp_id; ?>" required>
                                                <option value="" disabled>-- เลือกวันที่บังคับใช้โครงสร้าง --</option>
                                                <?php
                                                foreach ($base_stucture_list as $key => $row) {
                                                ?>
                                                    <option value="<?php echo $row->stuc_id; ?>"><?php echo fullDateTH3($row->stuc_confirm_date) . ($row->stuc_status == 1 ? ' (โครงสร้างปัจจุบัน) </p>' : ' (โครงสร้างเก่า)'); ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div> -->
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <!-- <div class="col-md- mb-4">
                                    <div class="row">
                                        <div class="col-md-4 text-end"> <label for="pos_spcl_id_<?php echo $dp_id; ?>" class="form-label">หน่วยงานที่สังกัด</label></div>
                                        <div class="col-md-6">
                                            <select class="form-select select2" data-placeholder="-- กรุณาเลือกตำแหน่งงานเฉพาะทาง --" name="pos_stde_id_<?php echo $dp_id; ?>" id="pos_stde_id_<?php echo $dp_id; ?>" required>
                                                <option value="" disabled>-- เลือกหน่วยงานที่สังกัด --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div> -->
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_desc_<?php echo $dp_id; ?>" class="form-label">รายละเอียดความชำนาญเฉพาะทาง</label></div>
                                        <div class="col-md-8">
                                            <textarea class="form-control" name="pos_desc_<?php echo $dp_id; ?>" id="pos_desc_<?php echo $dp_id; ?>" placeholder="กรอกรายละเอียดความชำนาญเฉพาะทาง" rows="4"><?php echo (isset($row_position[$dp_id]) ? $row_position[$dp_id]->pos_desc : ""); ?></textarea>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_status_<?php echo $dp_id; ?>" class="form-label required">สถานะการทำงาน</label></div>
                                        <div class="col-md-8">
                                            <select class="form-select select2" onchange="changeStatus(<?php echo $dp_id; ?>, value, <?= isset($row_position[$dp_id]) ? $row_position[$dp_id]->retire_ps_status : null ?>)" data-placeholder="-- กรุณาเลือกสถานะการทำงาน --" name="pos_status_<?php echo $dp_id; ?>" id="pos_status_<?php echo $dp_id; ?>" required>
                                                <option value="">-- เลือกสถานะการทำงาน --</option>
                                                <?php
                                                foreach ($base_retire_list as $key => $row) {
                                                ?>
                                                    <option value="<?php echo $row->retire_id . "," . $row->retire_ps_status; ?>" <?php echo (isset($row_position[$dp_id]) && $row_position[$dp_id]->pos_retire_id == $row->retire_id ? "selected" : ""); ?>><?php echo $row->retire_name; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3" id="div_pos_work_end_date_<?php echo $dp_id; ?>">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_work_end_date_<?php echo $dp_id; ?>" class="form-label required">วันที่ออกจาการปฏิบัติงาน</label></div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="pos_work_end_date_<?php echo $dp_id; ?>" name="pos_work_end_date_<?php echo $dp_id; ?>">
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4" id="div_pos_attach_file_<?php echo $dp_id; ?>">
                                    <div class="row">
                                        <div class="col-md-3 text-end">
                                            <label for="pos_attach_file_<?php echo $dp_id; ?>" class="form-label">แนบไฟล์เอกสารหลักฐาน</label><br>
                                            <small>(.jpg, .png และ .pdf เท่านั้น)</small>
                                        </div>
                                        <div class="col-md-6" id="div_file_md_6">
                                            <div id="show_file_name_pos_<?php echo $dp_id; ?>" class="me-3" style="margin-bottom: 16px;">
                                                <?php if (isset($row_position[$dp_id]->pos_attach_file)) { ?>
                                                    <a class="btn btn-link" data-file-name="<?php echo $row_position[$dp_id]->pos_attach_file; ?>"
                                                        href="<?php echo site_url($this->config->item('hr_dir') . 'Getdoc?path=' . $this->config->item('hr_upload_profile_official') . '&doc=' . $row_position[$dp_id]->pos_attach_file) . '&rename=' . $row_position[$dp_id]->pos_attach_file; ?>"
                                                        data-preview-path="<?php echo site_url($this->config->item('hr_dir') . 'Getpreview?path=' . $this->config->item('hr_upload_profile_official') . '&doc='); ?><?php echo $row_position[$dp_id]->pos_attach_file; ?>"
                                                        data-download-path="<?php echo site_url($this->config->item('hr_dir') . 'Getdoc?path=' . $this->config->item('hr_upload_profile_official') . '&doc='); ?><?php echo $row_position[$dp_id]->pos_attach_file; ?>"
                                                        data-bs-toggle="modal" id="btn_preview_file" data-bs-target="#preview_file_modal" title="คลิกเพื่อดูไฟล์เอกสารหลักฐาน">
                                                        <?php echo $row_position[$dp_id]->pos_attach_file; ?>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-md" id="btn_remove_file_<?php echo $dp_id; ?>"><i class="bi bi-trash"></i></button>
                                                    <button type="button" class="btn btn-secondary btn-md d-none" id="btn_undo_file_<?php echo $dp_id; ?>"><i class="bi bi-arrow-counterclockwise"></i></button>
                                                <?php } ?>
                                            </div>
                                            <input class="form-control input-bs-file <?php if (isset($row_position[$dp_id]->pos_attach_file)) {
                                                                                            echo 'd-none';
                                                                                        } ?>" type="file" id="pos_attach_file_<?php echo $dp_id; ?>" name="pos_attach_file_<?php echo $dp_id; ?>" accept=".png,.jpg,.pdf">
                                            <input type="hidden" id="file_action_<?php echo $dp_id; ?>" name="file_action_<?php echo $dp_id; ?>" value="none"> <!-- Hidden input -->
                                            <input type="hidden" id="file_name_<?php echo $dp_id; ?>" name="file_name_<?php echo $dp_id; ?>" value="<?php echo $row_position[$dp_id]->pos_attach_file; ?>"> <!-- Hidden input -->
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4" id="div_pos_out_desc_<?php echo $dp_id; ?>">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_out_desc_<?php echo $dp_id; ?>" class="form-label">เหตุผลการลาออกจากการปฏิบัติงาน</label></div>
                                        <div class="col-md-6">
                                            <textarea class="form-control" name="pos_out_desc_<?php echo $dp_id; ?>" id="pos_out_desc_<?php echo $dp_id; ?>" placeholder="กรอกเหตุผลการลาออกจากการปฏิบัติงาน" rows="4"><?php echo (isset($row_position[$dp_id]) ? $row_position[$dp_id]->pos_out_desc : ""); ?></textarea>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-3 text-end"> <label for="pos_active_<?php echo $dp_id; ?>" class="form-label">สถานะการใช้งาน</label></div>
                                        <div class="col-md-6 form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="pos_active_<?php echo $dp_id; ?>" name="pos_active_<?php echo $dp_id; ?>" title="<?php echo (isset($row_position[$dp_id]) && $row_position[$dp_id]->pos_active == "Y" ? "คลิกเพื่อเปิดใช้งาน" : "คลิกเพื่อปิดใช้งาน"); ?>" data-toggle="tooltip" data-bs-placement="top" onclick="change_text_active(<?php echo $dp_id; ?>)" <?php echo (isset($row_position[$dp_id]) && $row_position[$dp_id]->pos_active == "Y" ? "checked" : ""); ?>>
                                            <label class="form-check-label" for="pos_active_<?php echo $dp_id; ?>" id="text_pos_active_<?php echo $dp_id; ?>"><?php echo (isset($row_position[$dp_id]) && $row_position[$dp_id]->pos_active == "Y" ? "เปิดใช้งาน" : "ปิดใช้งาน"); ?></label>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                <div class="mt-3 mb-3 col-md-12">
                                    <a type="button" class="btn btn-secondary float-start" href="<?php echo site_url() . "/" . $controller_dir; ?>" title="คลิกเพื่อย้อนกลับ" data-toggle="tooltip" data-bs-placement="top">ย้อนกลับ</a>
                                    <button type="button" class="btn btn-success float-end" id="button_profile_save_form" onclick="profile_save_form(<?php echo $dp_id; ?>)" title="คลิกเพื่อบันทึกข้อมูล" data-toggle="tooltip" data-bs-placement="top">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Bootstrap 5 Modal HTML -->
<div class="modal fade" id="editModal" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">แก้ไขข้อมูล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="profile_official_form" method="post">
                    <div class="mb-3">
                        <label for="inputPos" class="form-label">ตำแหน่งในโครงสร้าง <span class="text-danger">*</span></label>
                        <select name="" class="select2" id="inputPos">
                            <option value="new">กรุณาเลือก</option>
                            <option value="0">ไม่ระบุ</option>
                            <?php foreach ($base_structure_position as $key => $value) : ?>
                               <option value="<?= $value->stpo_id ?>"><?= $value->stpo_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="inputName" class="form-label">ชื่อหน่วยงานที่สังกัด <span class="text-danger">*</span></label>
                        <select name="" class="select2" id="inputName">
                            <option value="new">กรุณาเลือก</option>
                        </select>
                    </div>
                    <input type="hidden" id="editDataId" name="id">
                    <input type="hidden" id="editStdeId" name="stdeId">
                    <input type="hidden" id="editIndex" name="index">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-success" id="saveChanges">บันทึก</button>
            </div>
        </div>
    </div>
</div>




<script>
    // เก็บชื่อไฟล์เดิมที่แนบมาจากฐานข้อมูล
    var originalFileName = "<?php echo isset($row_position[$dp_id]) ? $row_position[$dp_id]->pos_attach_file : ''; ?>";
    var datasetSelect = {};
    var method = ''
    document.getElementById('pos_attach_file_<?php echo $dp_id; ?>').addEventListener('change', function() {
        // Update hidden input to indicate a new file is selected
        document.getElementById('file_action_<?php echo $dp_id; ?>').value = 'new';
    });

    // ตรวจสอบว่ามีไฟล์แนบอยู่แล้วหรือไม่ ถ้ามีให้เพิ่มฟังก์ชันจัดการการลบไฟล์
    <?php if (isset($row_position[$dp_id]->pos_attach_file)) { ?>

        // ฟังก์ชันสำหรับจัดการการลบไฟล์
        document.getElementById('btn_remove_file_<?php echo $dp_id; ?>').addEventListener('click', function() {

            // ซ่อนลิงก์และปุ่มลบ
            document.querySelector('#show_file_name_pos_<?php echo $dp_id; ?> a').classList.add('d-none');
            this.classList.add('d-none');

            // แสดง input สำหรับการอัปโหลดไฟล์ใหม่
            document.getElementById('pos_attach_file_<?php echo $dp_id; ?>').classList.remove('d-none');

            // แสดงปุ่ม undo
            document.getElementById('btn_undo_file_<?php echo $dp_id; ?>').classList.remove('d-none');

            // อัปเดตค่าใน hidden input เพื่อระบุว่ามีการลบไฟล์
            document.getElementById('file_action_<?php echo $dp_id; ?>').value = 'remove';

            // เพิ่มคลาส d-flex align-items-center ไปยัง div ที่มี id="div_file_md_6"
            document.getElementById('div_file_md_6').classList.add('d-flex', 'align-items-center');
        });


        // ฟังก์ชันสำหรับจัดการการย้อนกลับการลบไฟล์
        document.getElementById('btn_undo_file_<?php echo $dp_id; ?>').addEventListener('click', function() {

            // แสดงลิงก์และปุ่มลบไฟล์อีกครั้ง
            document.querySelector('#show_file_name_pos_<?php echo $dp_id; ?> a').classList.remove('d-none');
            this.classList.remove('d-none');

            document.getElementById('btn_remove_file_<?php echo $dp_id; ?>').classList.remove('d-none');

            // ซ่อน input สำหรับการอัปโหลดไฟล์ใหม่
            document.getElementById('pos_attach_file_<?php echo $dp_id; ?>').classList.add('d-none');

            // ซ่อนปุ่ม undo
            this.classList.add('d-none');

            // อัปเดตค่าใน hidden input เพื่อระบุว่ามีการย้อนกลับการลบไฟล์
            document.getElementById('file_action_<?php echo $dp_id; ?>').value = 'undo';

            // ลบคลาส d-flex align-items-center จาก div ที่มี id="div_file_md_6"
            document.getElementById('div_file_md_6').classList.remove('d-flex', 'align-items-center');
        });

    <?php } ?>

    // ฟังก์ชันสำหรับเพิ่ม event listener ให้กับปุ่มลบไฟล์
    function addRemoveButtonListener() {
        var removeButton = document.getElementById('btn_remove_file_<?php echo $dp_id; ?>');
        removeButton.addEventListener('click', function() {
            var inputFile = document.getElementById('pos_attach_file_<?php echo $dp_id; ?>');
            inputFile.value = ''; // ล้างค่าใน input file
            var displayDiv = document.getElementById('show_file_name_pos_<?php echo $dp_id; ?>');
            displayDiv.querySelector('a').classList.add('d-none'); // ซ่อนลิงก์ชื่อไฟล์
            removeButton.classList.add('d-none'); // ซ่อนปุ่มลบ

            // อัปเดตค่าใน hidden input เพื่อระบุว่ามีการลบไฟล์
            document.getElementById('file_action_<?php echo $dp_id; ?>').value = 'remove';

            // แสดงปุ่ม undo
            var undoButton = document.getElementById('btn_undo_file_<?php echo $dp_id; ?>');
            if (undoButton) {
                undoButton.classList.remove('d-none');
            }
        });
    }

    // ฟังก์ชันสำหรับเพิ่ม event listener ให้กับปุ่ม undo การลบไฟล์
    function addUndoButtonListener() {
        var undoButton = document.getElementById('btn_undo_file_<?php echo $dp_id; ?>');
        var new_file_name = $("#file_name_<?php echo $dp_id; ?>").val();

        undoButton.addEventListener('click', function() {
            var displayDiv = document.getElementById('show_file_name_pos_<?php echo $dp_id; ?>');
            var linkElement = displayDiv.querySelector('a');

            // แสดงลิงก์ชื่อไฟล์เดิม
            linkElement.classList.remove('d-none');

            // ตรวจสอบว่ามีชื่อไฟล์เดิมอยู่หรือไม่ ถ้าไม่มีให้แสดงข้อความเริ่มต้น
            if (originalFileName) {
                linkElement.textContent = originalFileName;
            } else {
                linkElement.textContent = new_file_name; // กรณีที่ไม่มีชื่อไฟล์เดิม ให้แสดงข้อความอื่น
            }

            // แสดงปุ่มลบ
            var removeButton = document.getElementById('btn_remove_file_<?php echo $dp_id; ?>');
            removeButton.classList.remove('d-none');

            // ซ่อนปุ่ม undo
            undoButton.classList.add('d-none');

            // อัปเดตค่าใน hidden input เพื่อระบุว่ามีการ undo การลบไฟล์
            document.getElementById('file_action_<?php echo $dp_id; ?>').value = 'undo';
        });
    }

    // เพิ่ม event listener ให้กับปุ่มลบและ undo ถ้ามีไฟล์แนบอยู่แล้ว
    <?php if (isset($row_position[$dp_id]->pos_attach_file)) { ?>
        addRemoveButtonListener();
        addUndoButtonListener(); // เพิ่มเพื่อให้ปุ่ม undo ทำงานถ้าจำเป็น
    <?php } ?>

    $(document).ready(function() {
        <?php
        if (isset($row_position[$dp_id]) && $row_position[$dp_id]->pos_status == 2) {
        ?>
            $("#div_pos_work_end_date_" + <?php echo $dp_id; ?>).show();
            $("#div_pos_attach_file_" + <?php echo $dp_id; ?>).show();
            $("#div_pos_out_desc_" + <?php echo $dp_id; ?>).show();
        <?php
        } else {
        ?>
            $("#div_pos_work_end_date_" + <?php echo $dp_id; ?>).hide();
            $("#div_pos_attach_file_" + <?php echo $dp_id; ?>).hide();
            $("#div_pos_out_desc_" + <?php echo $dp_id; ?>).hide();
        <?php
        }
        if (isset($row_position[$dp_id]) && $row_position[$dp_id]->pos_hire_id == 23) {
        ?>
            $("#div_pos_trial_day_" + <?php echo $dp_id; ?>).show();
        <?php
        } else {
        ?>
            $("#div_pos_trial_day_" + <?php echo $dp_id; ?>).hide()
        <?php }
        ?>
        $('#pos_stuc_id_' + <?php echo $dp_id; ?>).on('change', function() {
            format_dept_option();
        });
        document.querySelectorAll('.editStuc').forEach(button => {
            button.addEventListener('click', function() {
                // Extract data from button attributes
                datasetSelect = this.dataset;
                $('#inputPos').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#editModal'),
                    allowClear: true
                });
                get_stucture_detail_option(datasetSelect.dp, datasetSelect.stde)
                $('#inputPos').val(datasetSelect.pos).trigger('change');
                method = datasetSelect.stde
            });
        });
        document.querySelectorAll('.addStuc').forEach(button => {
            button.addEventListener('click', function() {
                // Extract data from button attributes
                datasetSelect = this.dataset;

                $('#inputPos').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#editModal'),
                    allowClear: true
                });
                get_stucture_detail_option(datasetSelect.dp, null)
                method = 'add'
                $('#inputName').val('new').trigger('change');
                $('#inputPos').val('new').trigger('change');
            });
        });
        $('#saveChanges').off('click').on('click', function() {
            // Get values from modal inputs
            let pos = $('#inputPos').val();
            let posText = $('#inputPos option:selected').text();
            let name = $('#inputName').val();
            let nameText = $('#inputName option:selected').text();

            if (pos === 'new' || name === 'new') {
                dialog_error({
                    header: text_toast_default_error_header,
                    body: 'กรุณากรอกข้อมูลให้ครบถ้วน'
                });
                return 0;
            }

            // Check if the name exists and is different from method
            if (name !== method) {
                let isNameExists = dataArray.some(item => item.stde === parseInt(name));
                if (isNameExists) {
                    dialog_error({
                        header: text_toast_default_error_header,
                        body: 'กรุณาเลือกหน่วยงานที่สังกัดใหม่อีกครั้ง'
                    });
                    return 0;
                }
            }

            // Use values from datasetSelect
            let dpId = datasetSelect.dp;
            let index = datasetSelect.index;

            // Find the row with the addStuc button
            let $addRow = $(`.addStuc[data-dp="${dpId}"]`).closest('tr');

            if (name === method) {
                // Update existing row
                let $rowToUpdate = $(`.stde-${dpId}-${index}`).closest('tr');

                // Update dataArray
                let rowIndex = dataArray.findIndex(item => item.stde == method);
                if (rowIndex !== -1) {
                    dataArray[rowIndex] = {
                        stdp_id: dataArray[rowIndex].stdp_id,
                        stde: parseInt(name),
                        check: 'old',
                        pos: parseInt(pos),
                        status: dataArray[rowIndex].status // Keep the existing status
                    };
                }

                // Update table row
                $rowToUpdate.find(`.pos-${dpId}-${index}`).text(posText);
                $rowToUpdate.find(`.stde-${dpId}-${index}`).text(nameText);

                // Update data-set attributes for the edit button

                $rowToUpdate.find('.editStuc').each(function() {
                    $(this).attr({
                        'data-pos': pos,
                        'data-stde': name,
                        'data-dp': dpId,
                        'data-active': 1,
                        'data-check': 'old',
                        'data-index': index
                    });
                });
            } else {
                // Add new row
                dataArray.push({
                    stdp_id: parseInt(index),
                    stde: parseInt(name),
                    check: 'new',
                    pos: parseInt(pos),
                    status: 1 // New items should have status 1
                });

                const newRow = `
                    <tr>
                        <td class="text-center">
                            <div class="row">
                                <div class="col-md-12 font-12 pos-${dpId}-${index}">${posText}</div>
                                <div class="col-md-12 stde-${dpId}-${index}">${nameText}</div>
                            </div>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning editStuc btn-sm"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal"
                                data-pos="${pos}"
                                data-stde="${name}"
                                data-dp="${dpId}"
                                data-active="1"
                                data-check="new"
                                data-index="${index}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-danger delete-btn btn-sm" data-check="new" data-id="${index}" data-stde="${name}" data-index="${index}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                // Insert new row before the row with the addStuc button
                $addRow.before(newRow);

                // Update rowspan for column1 and column2
                let $keyColumn = $('#key_column');
                let $confirmStucColumn = $('#confirm_stuc');

                let newRowspan = parseInt($keyColumn.attr('rowspan')) + 1;

                // Update rowspan values
                $keyColumn.attr('rowspan', newRowspan);
                $confirmStucColumn.attr('rowspan', newRowspan);

                // Change the addStuc button to a new button
                $addRow.find('td').attr('colspan', 2).html(`
            <button class="btn btn-success addStuc btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editModal" data-dp="${dpId}" data-id="${index + 1}">
                <i class="bi bi-plus"></i>
            </button>
        `);
            }
            $('#editModal').modal('hide');
        });


        initializeDataArray();

        $(document).on('click', '.delete-btn', function() {
            let $button = $(this);
            let datastdeId = $button.data('stde');
            let dataIndex = $button.data('index');
            let checkType = $button.data('check'); // 'new' or 'old'

            if (dataIndex === 0) {
                // ถ้า index == 0 ให้ลบเฉพาะคอลัมน์ที่ 2 และ 3
                let $row = $button.closest('tr');

                // ลบเฉพาะคอลัมน์ที่ 2 และ 3 ของแถว index 0
                $row.find('td:nth-child(3), td:nth-child(4)').remove();

                // ตรวจสอบว่ามีแถวถัดไปหรือไม่
                let $nextRow1 = $row.next(); // Row index 1
                if ($nextRow1.length) {
                    // ย้ายคอลัมน์ที่ 2 และ 3 ของแถว index 1 มาแทนแถว index 0
                    $row.append($nextRow1.find('td:nth-child(3)').detach());
                    $row.append($nextRow1.find('td:nth-child(4)').detach());

                    // ตรวจสอบว่าแถวถัดไป (index 2) มีอยู่หรือไม่
                    let $nextRow2 = $nextRow1.next(); // Row index 2 (ถ้ามี)
                    if ($nextRow2.length) {
                        // ย้ายคอลัมน์ที่ 2 และ 3 ของแถว index 2 มาแทนแถว index 1
                        $nextRow1.append($nextRow2.find('td:nth-child(3)').detach());
                        $nextRow1.append($nextRow2.find('td:nth-child(4)').detach());
                    }
                }
                dataArray = dataArray.map(item => {
                    if (item.stde === datastdeId) {
                        item.status = 0; // ตั้งค่า status เป็น 0
                    }
                    return item;
                });
            } else {
                if (checkType === 'new') {
                    // สำหรับ new items ลบแถวและข้อมูลจาก dataArray
                    dataArray = dataArray.filter(item => item.stde !== datastdeId);
                    $button.closest('tr').remove();
                } else if (checkType === 'old') {
                    // สำหรับ old items อัปเดต status เป็น 0 ก่อนลบแถว
                    let row = $button.closest('tr');
                    dataArray = dataArray.map(item => {
                        if (item.stde === datastdeId) {
                            item.status = 0; // ตั้งค่า status เป็น 0
                        }
                        return item;
                    });

                    // ลบแถวออกจากตาราง
                    row.remove();
                }
            }
        });



    });

    function initializeDataArray() {
        dataArray = []; // Clear previous dataArray

        $('#currentTable tbody tr').each(function() {
            let $tr = $(this);
            let dataId = $tr.find('.editStuc').data('id');
            let dataIndex = $tr.find('.editStuc').data('index');
            let checkType = $tr.find('.editStuc').data('check'); // 'new' or 'old'
            let stdeName = $tr.find('.editStuc').data('stde');
            let pos = $tr.find('.editStuc').data('pos');
            let status = $tr.find('.editStuc').data('status'); // Set status to 0 for 'old' items
            if (stdeName) {
                dataArray.push({
                    stdp_id: dataId,
                    stde: stdeName,
                    pos: pos,
                    check: 'old',
                    status: status
                });
            }
        });
    }

    function format_dept_option() {
        // Get the selected data from Select2
        var selectedData = $('#pos_stuc_id_<?php echo $dp_id; ?>').select2('data')[0]; // Get the first selected data object
        function getIndentation(seq) {
            // Count the number of periods in the sequence to determine the depth
            const depth = (seq.match(/\./g) || []).length;

            // Return a string of non-breaking spaces for indentation
            // Using `\u00A0` for non-breaking space (HTML entity &nbsp; equivalent)
            return '\u00A0'.repeat(depth * 4); // 4 non-breaking spaces per depth level
        }
        if (selectedData) {
            $.ajax({
                url: '<?php echo site_url() . "/" . $controller_dir; ?>get_structure_detail_by_stuc_id',
                type: 'POST',
                data: {
                    stuc_id: selectedData.id
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.length > 0) {
                        $('#poc_stde_id_<?php echo $dp_id; ?>').empty();
                        var newOption = new Option('-- เลือกหน่วยงานที่สังกัดasd --', '', true, false);
                        $('#poc_stde_id_<?php echo $dp_id; ?>').append(newOption);
                        data.forEach(element => {
                            // if (stde_id_select == element.stde_id) {
                            //     selected = true
                            //     stde_id_select = element.stde_id
                            // } else {
                            //     selected = false
                            // }
                            newOption = new Option(getIndentation(element.stde_seq) + element.stde_name_th, element.stde_id, false, 'false');
                            $('#poc_stde_id_<?php echo $dp_id; ?>').append(newOption)
                        });
                        const $selectedOption = $('#poc_stde_id_<?php echo $dp_id; ?> option:selected');
                        const selectedText = $selectedOption.text().trim();
                        console.log($selectedOption);

                        // Update the displayed value (if needed)
                        $selectedOption.text(selectedText);
                    }
                },
                error: function(xhr, status, error) {
                    dialog_error({
                        header: text_toast_default_error_header,
                        body: text_toast_default_error_body
                    });
                }
            });
        }
    }

    function get_stucture_detail_option(dp_id, stde) {
        $.ajax({
            url: '<?php echo site_url() . "/" . $controller_dir; ?>get_structure_detail_by_stuc_id',
            type: 'POST',
            data: {
                dp_id: dp_id
            },
            success: function(data) {
                data = JSON.parse(data);
                let options = data.map(item => {
                    return {
                        id: item.stde_id, // หรือใช้ item.id ถ้า key คือ id
                        text: item.stde_name_th // หรือใช้ item.name ถ้า key คือ name
                    };
                });
                $('#inputName').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#editModal'),
                    allowClear: true,
                    default: stde,
                    data: options
                });
                if (stde) {
                    $('#inputName').val(stde).trigger('change');
                }
            },
            error: function(xhr, status, error) {
                dialog_error({
                    header: text_toast_default_error_header,
                    body: text_toast_default_error_body
                });
            }
        });
    }

    function change_text_active(dp_id) {
        var checkbox = document.getElementById("pos_active_" + dp_id);
        var label = document.getElementById("text_pos_active_" + dp_id);

        if (checkbox.checked) {
            label.textContent = "เปิดใช้งาน";
            checkbox.setAttribute("title", "คลิกเพื่อปิดใช้งาน");
        } else {
            label.textContent = "ปิดใช้งาน";
            checkbox.setAttribute("title", "คลิกเพื่อเปิดใช้งาน");
        }

        // Reinitialize the tooltip to update its content
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Manually show tooltip with updated title
        var tooltipInstance = bootstrap.Tooltip.getInstance(checkbox);
        if (tooltipInstance) {
            tooltipInstance.setContent({
                '.tooltip-inner': checkbox.getAttribute('title')
            });
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#pos_work_start_date_<?php echo $dp_id; ?>", {
            dateFormat: 'd/m/Y',
            locale: 'th',
            // defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
            defaultDate: "<?php echo $pos_work_start_date = isset($row_position[$dp_id]->pos_work_start_date)
                                ? date('d/m/Y', strtotime($row_position[$dp_id]->pos_work_start_date . ' +543 years'))
                                : date('d/m/Y', strtotime('+543 years')); ?>",
            onReady: function(selectedDates, dateStr, instance) {
                addMonthNavigationListeners2();
                convertYearsToThai2();
                formatDateToThai2(new Date());
            },
            onOpen: function(selectedDates, dateStr, instance) {
                convertYearsToThai2();
            },
            onValueUpdate: function(selectedDates, dateStr, instance) {
                convertYearsToThai2();
                if (!selectedDates || selectedDates.length === 0) { // ถ้ายังไม่ได้เลือกวันที่
                    document.getElementById('pos_work_start_date_<?php echo $dp_id; ?>').value = formatDateToThai2(new Date()); // ใช้วันที่ปัจจุบัน
                } else {
                    document.getElementById('pos_work_start_date_<?php echo $dp_id; ?>').value = formatDateToThai2(selectedDates[0]); // ใช้วันที่ที่เลือก
                }
            },
            onMonthChange: function(selectedDates, dateStr, instance) {
                convertYearsToThai2();
            },
            onYearChange: function(selectedDates, dateStr, instance) {
                convertYearsToThai2();
            }
        });

        flatpickr("#pos_work_end_date_<?php echo $dp_id; ?>", {
            dateFormat: 'd/m/Y',
            locale: 'th',
            // defaultDate: new Date(new Date().getFullYear() + 543, new Date().getMonth(), new Date().getDate()), // ตั้งค่าเป็นวันที่ปัจจุบันของปฎิทิน พ.ศ.
            defaultDate: "<?php echo $pos_work_end_date = isset($row_position[$dp_id]->pos_work_end_date)
                                ? date('d/m/Y', strtotime($row_position[$dp_id]->pos_work_end_date . ' +543 years'))
                                : date('d/m/Y', strtotime('+543 years')); ?>",
            onReady: function(selectedDates, dateStr, instance) {
                addMonthNavigationListeners2();
                convertYearsToThai2();
            },
            onOpen: function(selectedDates, dateStr, instance) {
                convertYearsToThai2();
            },
            onValueUpdate: function(selectedDates, dateStr, instance) {
                convertYearsToThai2();
                if (!selectedDates || selectedDates.length === 0) { // ถ้ายังไม่ได้เลือกวันที่
                    document.getElementById('pos_work_end_date_<?php echo $dp_id; ?>').value = formatDateToThai2(new Date()); // ใช้วันที่ปัจจุบัน
                } else {
                    document.getElementById('pos_work_end_date_<?php echo $dp_id; ?>').value = formatDateToThai2(selectedDates[0]); // ใช้วันที่ที่เลือก
                }
            },
            onMonthChange: function(selectedDates, dateStr, instance) {
                convertYearsToThai2();
            },
            onYearChange: function(selectedDates, dateStr, instance) {
                convertYearsToThai2();
            }
        });
    });
</script>