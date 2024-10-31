<?php 
    $order_no = 0; 

    // permission
    $is_officer = isset($actor) && ($actor == 'officer');
    $is_doctor = isset($actor) && ($actor == 'doctor');

    // tool & draft tool
    $num = 0;
    $exr_amount = count(array_filter($exam_results, function($result) {
        return $result['exr_status'] != 'D';
    }));
    if(empty($exr_amount)) {
        if(isset($tools) && !empty($tools)) $num += count($tools);
        if(isset($tools_default) && !empty($tools_default)) $num += count($tools_default);
    }

    $num_draft = 0;
    $draft_amount = count(array_filter($exam_results, function($result) {
        return $result['exr_status'] == 'D';
    }));
    if(empty($draft_amount)) {
        if(isset($tools) && !empty($tools)) $num_draft += count($tools);
        if(isset($tools_default) && !empty($tools_default)) $num_draft += count($tools_default);
    }
?>

<style>
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 5px;
        background: #f8f9fa;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        color: #007bff;
        align-content: center;
        height: 300px;
    }

    .dropzone.dragover {
        background: #e2e6ea;
    }

    .file-list {
        margin-top: 20px;
    }

    .file-list table {
        width: 100%;
        border-collapse: collapse;
    }

    .file-list th,
    .file-list td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .file-list th {
        background-color: #f2f2f2;
    }

    /* sidebar-examination-result */
    #sidebar-examination-result {
        position: fixed;
        top: 60px;
        right: -50%;
        bottom: 0;
        width: 50%;
        z-index: 996;
        transition: all 0.3s;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #aab7cf transparent;
        box-shadow: 0px 0px 20px rgba(1, 41, 112, 0.1);
        background-color: #fff;
    }

    #sidebar-examination-result.show {
        right: 0;
    }

    .toggle-sidebar-examination-result {
        margin-right: 50%;
    }

    .center-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
        /* Full height */
    }

    .styled-div-textarea-disabled {
        width: 100%;
        height: 300px;
        border: 1px solid #ccc;
        padding: 10px;
        box-sizing: border-box;
        background-color: #f9f9f9;
        color: #333;
        font-size: 16px;
        font-family: Arial, sans-serif;
        overflow-y: auto;
    }
</style>

<div class="accordion">
    <?php if($is_doctor) { ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingUpdate">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUpdate" aria-expanded="true" aria-controls="collapseUpdate">
                    <i class="bi bi-card-heading icon-menu font-20"></i><span>รายละเอียดข้อมูลผลตรวจจากห้องปฏิบัติการทางการแพทย์</span>
                </button>
            </h2>
        </div>
    <?php } ?>
    <!-- <form id="updateform" class="needs-validation" novalidate method="post" enctype="multipart/form-data"> -->
        <div id="collapseUpdate" class="accordion-collapse collapse show" aria-labelledby="headingUpdate">
            <div class="accordion-body p-0">
                <div class="card" <?php echo $is_officer ? 'style="margin-bottom: 0px;"' : ''; ?>>
                    <!-- AMS patient's data -->
                    <div class="row m-3">
                        <div class="col-md-3 p-5 profile-card d-flex align-items-center justify-content-center">
                            <?php if (isset($detail->ptd_img)) { ?>
                                <img style="width:250px; height:250px; object-fit: cover;" class="profileImage avatar-img rounded-circle border border-white border-3 shadow" src="http:<?php echo $detail->ptd_img ?>" alt="">
                            <?php } else { ?>
                                <img style="width:250px; height:250px;" class="profileImage avatar-img rounded-circle border border-white border-3 shadow" src="<?php echo base_url(); ?>assets/img/default-person.png" alt="">
                                <!-- <img class="img-fluid border rounded-circle" style="border-width: 2px; border-color: black;" id="profile_picture" src="https://dev-seedb.aos.in.th/index.php/hr/getIcon?type=profile/profile_picture&image=profile_picture_4.jpg">  -->
                            <?php } ?>
                        </div>
                        <div class="col-md-9 mt-4">
                            <div class="row">
                                <h5 class="weight-600 font-20 mb-4 col-md-4"> ข้อมูลผู้ป่วย </h5>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <label class="form-label me-4"> Visit </label>
                                    <input class="form-control " value="<?php echo $detail->apm_visit ?>" type="text" disabled>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label me-4"> วันที่ </label>
                                    <input class="form-control" value="<?php echo convertToThaiYear($detail->apm_create_date, true) ?>" type="text" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <label class="form-label "> HN</label>
                                    <input class="form-control " value="<?php echo $detail->pt_member ?>" type="text" disabled>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label me-4"> ชื่อ </label>
                                    <input class="form-control" value="<?php echo $detail->pt_prefix . ' ' . $detail->pt_fname . '   ' . $detail->pt_lname ?>" type="text" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 align-item-start">
                                    <label class="form-label me-4"> ประเภท </label>
                                    <input class="form-control" value="<?php if ($detail->apm_patient_type == 'old') {
                                                                            echo "ผู้ป่วยเก่า";
                                                                        } else {
                                                                            echo "ผู้ป่วยใหม่";
                                                                        } ?>" type="text" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label me-4"> ประเภทโรค </label>
                                    <input class="form-control" value="<?php echo $detail->ds_name_disease ?>" type="text" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- DIM select examination tool -->
                    <?php 
                        $index_tool = 0;
                        
                        // if ($is_doctor && (isset($is_view) && (!$is_view))) { 
                        if ((isset($is_view) && (!$is_view)) && $is_officer) { 
                        $order_no++;
                    ?>
                        <hr>
                        <form id="toolform" class="needs-validation" novalidate method="post" enctype="multipart/form-data">
                            <input name="ntr_apm_id" value="<?php echo isset($detail->ntr_apm_id) ? $detail->ntr_apm_id : ''; ?>" type="hidden">
                            <input name="ntr_pt_id" value="<?php echo isset($detail->ntr_pt_id) ? $detail->ntr_pt_id : ''; ?>" type="hidden">
                            <input name="ntr_ps_id" value="<?php echo isset($detail->ntr_ps_id) ? $detail->ntr_ps_id : ''; ?>" type="hidden">
                            <input name="ntr_ntf_id" value="<?php echo isset($detail->ntr_ntf_id) ? $detail->ntr_ntf_id : ''; ?>" type="hidden">
                            <div class="row m-3">
                                <div class="col-md-12"><label for="is_test_with_tool" class="form-label"><?php echo $order_no; ?>. โปรดระบุเครื่องมือหัตถการที่ต้องการให้ผู้ป่วยเข้าตรวจ</label></div>
                                <?php if ($is_officer) {  ?>
                                    <div class="col-md-12 pb-2 container-tool">
                                        <button type="button" class="btn btn-primary" onclick="add_row_tool('#tool-tbody')"><i class="bi-plus"></i> เพิ่มเครื่องมือหัตถการ</button>
                                    </div>
                                <?php }  ?>
                                <div class="col-md-12 container-tool">
                                    <table class="table" width="100%">
                                        <thead class="dataTable">
                                            <tr>
                                                <th width="8%" class="text-center">#</th>
                                                <th width="30%" class="text-center">ห้องปฏิบัติการ</th>
                                                <th width="30%" class="text-center">เครื่องมือหัตถการ</th>
                                                <th width="20%" class="text-center">สถานะ</th>
                                                <th width="10%" class="text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tool-tbody">
                                            <!-- draft tool -->
                                            <?php if(!empty($draft_amount)) { 
                                                $index_tool = $exr_amount;
                                            ?>
                                                <?php 
                                                    foreach ($exam_results as $row) {
                                                        if($row['exr_status'] == 'D' && $row['exr_status'] != 'R') {
                                                ?>
                                                <tr>
                                                    <input name="exr_id[]" value="<?php echo $row['exr_id']; ?>" type="hidden">
                                                    <td class="text-center"><?php echo ($index_tool+1); ?></td>
                                                    <td>
                                                        <select class="form-select select2 rm_id" data-placeholder="-- กรุณาเลือกห้องปฏิบัติการ --" name="rm_id[]" id="rm_id_<?php echo $index_tool; ?>" onchange="trigger_select_onchange('rm_id_<?php echo $index_tool; ?>', 'eqs_id_<?php echo $index_tool; ?>')">
                                                            <option value=""></option>
                                                            <?php foreach ($rooms as $rm) {
                                                                $selected = decrypt_id($rm['rm_id']) == decrypt_id($row['rm_id']) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $rm['rm_id']; ?>" <?php echo $selected; ?>><?php echo $rm['rm_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-select select2 eqs_id" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="eqs_id[]" id="eqs_id_<?php echo $index_tool; ?>">
                                                            <option value=""></option>
                                                            <?php foreach ($equipments as $eqs) { 
                                                                if(decrypt_id($eqs['eqs_rm_id']) == decrypt_id($row['rm_id']) && $eqs['eqs_fmst_id'] == 12) { // ประเภทเครื่องมือหัตถการ
                                                                    $selected = decrypt_id($eqs['eqs_id']) == decrypt_id($row['exr_eqs_id']) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $eqs['eqs_id']; ?>" <?php echo $selected; ?>><?php echo $eqs['eqs_name']; ?></option>
                                                            <?php }} ?>
                                                        </select>
                                                        <input name="eqs_id_name[]" value="eqs_id_<?php echo $index_tool; ?>" type="hidden">
                                                    </td>
                                                    <td class="text-center">บันทึกร่าง</td>
                                                    <td class="text-center option"><button type="button" class="btn btn-danger removeElement"><i class="bi-x"></i></button></td>
                                                </tr>
                                                <?php $index_tool++; }} ?>
                                            <?php } 
                                                else if(empty($exr_amount) && empty($draft_amount)) { ?>
                                                    <?php if(empty($tools_default) && empty($tools)) { ?>
                                                        <tr class="no_row_tool">
                                                            <td class="text-center" colspan="5">ไม่มีรายการข้อมูล</td>
                                                        </tr>
                                                    <?php } 
                                                    else { ?>
                                                        <!-- tool default of stde -->
                                                        <?php 
                                                            foreach ($tools_default as $row) {
                                                        ?>
                                                        <tr>
                                                            <input name="exr_id[]" value="" type="hidden">
                                                            <td class="text-center"><?php echo ($index_tool+1); ?></td>
                                                            <td>
                                                                <select class="form-select select2 rm_id" data-placeholder="-- กรุณาเลือกห้องปฏิบัติการ --" name="rm_id[]" id="rm_id_<?php echo $index_tool; ?>" onchange="trigger_select_onchange('rm_id_<?php echo $index_tool; ?>', 'eqs_id_<?php echo $index_tool; ?>')">
                                                                    <option value=""></option>
                                                                    <?php foreach ($rooms as $rm) {
                                                                        $selected = decrypt_id($rm['rm_id']) == decrypt_id($row['eqs_rm_id']) ? 'selected' : '';
                                                                    ?>
                                                                        <option value="<?php echo $rm['rm_id']; ?>" <?php echo $selected; ?>><?php echo $rm['rm_name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2 eqs_id" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="eqs_id[]" id="eqs_id_<?php echo $index_tool; ?>">
                                                                    <option value=""></option>
                                                                    <?php foreach ($equipments as $eqs) { 
                                                                        if(decrypt_id($eqs['eqs_rm_id']) == decrypt_id($row['eqs_rm_id']) && $eqs['eqs_fmst_id'] == 12) { // ประเภทเครื่องมือหัตถการ
                                                                            $selected = decrypt_id($eqs['eqs_id']) == decrypt_id($row['ddt_eqs_id']) ? 'selected' : '';
                                                                    ?>
                                                                        <option value="<?php echo $eqs['eqs_id']; ?>" <?php echo $selected; ?>><?php echo $eqs['eqs_name']; ?></option>
                                                                    <?php }} ?>
                                                                </select>
                                                                <input name="eqs_id_name[]" value="eqs_id_<?php echo $index_tool; ?>" type="hidden">
                                                            </td>
                                                            <td class="text-center">ยังไม่ได้รับการเข้าตรวจ</td>
                                                            <td class="text-center option"><button type="button" class="btn btn-danger removeElement"><i class="bi-x"></i></button></td>
                                                        </tr>
                                                        <?php $index_tool++; } ?>
                                                        <!-- tool of disease -->
                                                        <?php 
                                                            foreach ($tools as $row) {
                                                        ?>
                                                        <tr>
                                                            <input name="exr_id[]" value="" type="hidden">
                                                            <td class="text-center"><?php echo ($index_tool+1); ?></td>
                                                            <td>
                                                                <select class="form-select select2 rm_id" data-placeholder="-- กรุณาเลือกห้องปฏิบัติการ --" name="rm_id[]" id="rm_id_<?php echo $index_tool; ?>" onchange="trigger_select_onchange('rm_id_<?php echo $index_tool; ?>', 'eqs_id_<?php echo $index_tool; ?>')">
                                                                    <option value=""></option>
                                                                    <?php foreach ($rooms as $rm) {
                                                                        $selected = decrypt_id($rm['rm_id']) == decrypt_id($row['eqs_rm_id']) ? 'selected' : '';
                                                                    ?>
                                                                        <option value="<?php echo $rm['rm_id']; ?>" <?php echo $selected; ?>><?php echo $rm['rm_name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2 eqs_id" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="eqs_id[]" id="eqs_id_<?php echo $index_tool; ?>">
                                                                    <option value=""></option>
                                                                    <?php foreach ($equipments as $eqs) { 
                                                                        if(decrypt_id($eqs['eqs_rm_id']) == decrypt_id($row['eqs_rm_id']) && $eqs['eqs_fmst_id'] == 12) { // ประเภทเครื่องมือหัตถการ
                                                                            $selected = decrypt_id($eqs['eqs_id']) == decrypt_id($row['ddt_eqs_id']) ? 'selected' : '';
                                                                    ?>
                                                                        <option value="<?php echo $eqs['eqs_id']; ?>" <?php echo $selected; ?>><?php echo $eqs['eqs_name']; ?></option>
                                                                    <?php }} ?>
                                                                </select>
                                                                <input name="eqs_id_name[]" value="eqs_id_<?php echo $index_tool; ?>" type="hidden">
                                                            </td>
                                                            <td class="text-center">ยังไม่ได้รับการเข้าตรวจ</td>
                                                            <td class="text-center option"><button type="button" class="btn btn-danger removeElement"><i class="bi-x"></i></button></td>
                                                        </tr>
                                                        <?php $index_tool++; } ?>
                                                    <?php } ?>
                                            <?php } 
                                                else { ?>
                                                    <tr class="no_row_tool">
                                                            <td class="text-center" colspan="5">ไม่มีรายการข้อมูล</td>
                                                    </tr>
                                            <?php } ?>

                                            <?php $num += $index_tool; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12 container-tool" id="container-tool-btn">
                                    <button type="button" id="submit-save-tool" class="btn btn-success ms-3 float-end">ส่งผู้ปวยตรวจเครื่องมือหัตถการ</button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>

                    <!-- DIM examination result -->
                    <div class="row m-3" id="row-examination-result-table">
                        <div class="col-md-12">
                            <h5 class="weight-600 font-20"> ผลตรวจจากเครื่องมือหัตถการ </h5>
                        </div>
                        <div class="col-md-12 container-tool">
                            <table id="examination-result-table" class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="8%" class="text-center">#</th>
                                        <th width="30%" class="text-center">ห้องปฏิบัติการ</th>
                                        <th width="30%" class="text-center">เครื่องมือหัตถการ</th>
                                        <th width="20%" class="text-center">สถานะ</th>
                                        <th width="10%" class="text-center"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <!-- AMS appointment -->
                    <?php $is_view_appointment = 'disabled';
                          $is_show_appointment = 1;
                        $order_no++;
                        $text = $order_no. ". ต้องการนัดหมายครั้งถัดไปหรือไม่";
                        // if ($is_officer || (isset($is_view) && ($is_view))) {
                        if ((isset($is_view) && ($is_view)) || $is_doctor) {
                            $is_view_appointment = 'disabled';
                            $text = "การนัดหมายครั้งถัดไป";
                        }
                        if (!empty($is_view_appointment) && empty($appointment)) {
                            $is_show_appointment = 0;
                        }
                        ?>
                    <form id="updateform" class="needs-validation" novalidate method="post" enctype="multipart/form-data">
                        <input name="ntr_apm_id" value="<?php echo isset($detail->ntr_apm_id) ? $detail->ntr_apm_id : ''; ?>" type="hidden">
                        <input name="ntr_pt_id" value="<?php echo isset($detail->ntr_pt_id) ? $detail->ntr_pt_id : ''; ?>" type="hidden">
                        <input name="ntr_ps_id" value="<?php echo isset($detail->ntr_ps_id) ? $detail->ntr_ps_id : ''; ?>" type="hidden">
                        <input name="ntr_ntf_id" value="<?php echo isset($detail->ntr_ntf_id) ? $detail->ntr_ntf_id : ''; ?>" type="hidden">
                        <input name="ap_id" value="<?php echo isset($appointment->ap_id) ? $appointment->ap_id : ''; ?>" type="hidden" <?php echo $is_view_appointment; ?>>
                        <input name="ap_ast_id" value="<?php echo isset($appointment->ap_ast_id) ? $appointment->ap_ast_id : ''; ?>" type="hidden" <?php echo $is_view_appointment; ?>>
                        <input name="is_appointment_checked" id="is_appointment_checked" value="off" type="hidden" <?php echo $is_view_appointment; ?>>
                        <?php if ($is_show_appointment) { ?>
                            <hr>
                        <?php } ?>
                        <div class="row m-3">
                            <div class="col-md-12">
                                <?php if ($is_show_appointment) { ?>
                                    <?php if ($is_doctor) { ?>
                                        <h5 class="weight-600 font-20"> <?php echo $text; ?> </h5>
                                    <?php } else { ?>
                                        <label for="is_appointment" class="form-label"><?php echo $text; ?></label>
                                    <?php } ?>
                                    <?php if ($is_view_appointment) { ?>
                                        <p class="ms-3"><?php echo !empty($appointment) ? "นัดหมาย" : 'ไม่นัดหมาย'; ?></p>
                                    <?php } else { ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_appointment" id="is_appointment">
                                            <label for="is_appointment" class="form-check-label">ต้องการ</label>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <?php if ($is_show_appointment) { ?>
                                <div class="col-md-6 container-appointment">
                                    <label for="ap_date" class="form-label required"><?php echo $order_no; ?>.1 วันที่นัดหมาย</label>
                                    <input type="text" class="form-control" name="ap_date" id="ap_date" value="" placeholder="วว/ดด/ปป" <?php echo $is_view_appointment; ?>>
                                </div>
                                <div class="col-md-6 container-appointment">
                                    <label for="ap_time" class="form-label required"><?php echo $order_no; ?>.2 เวลานัดหมาย</label>
                                    <input type="text" class="form-control" name="ap_time" id="ap_time" value="" placeholder="ชั่วโมง:นาที" <?php echo $is_view_appointment; ?>>
                                </div>
                                <div class="col-md-6 container-appointment">
                                    <label class="form-label mb-3"> <?php echo $order_no; ?>.3 บันทึกเหตุผลการนัดหมาย </label>
                                    <?php if ($is_view_appointment) { ?>
                                        <div class="styled-div-textarea-disabled">
                                            <?php if (isset($appointment->ap_detail_appointment)) {
                                                echo $appointment->ap_detail_appointment;
                                            } ?>
                                        </div>
                                    <?php } else { ?>
                                        <textarea class="tinymce-editor" id="ap_detail_appointment" style="height:100px;" name="ap_detail_appointment"><?php if (isset($appointment->ap_detail_appointment)) {
                                                                                                                                                            echo $appointment->ap_detail_appointment;
                                                                                                                                                        } ?></textarea>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6 container-appointment">
                                    <label class="form-label mb-3"> <?php echo $order_no; ?>.4 บันทึกเตรียมตัวก่อนมาพบแพทย์ </label>
                                    <?php if ($is_view_appointment) { ?>
                                        <div class="styled-div-textarea-disabled">
                                            <?php if (isset($appointment->ap_detail_prepare)) {
                                                echo $appointment->ap_detail_prepare;
                                            } ?>
                                        </div>
                                    <?php } else { ?>
                                        <textarea class="tinymce-editor" id="ap_detail_prepare" style="height:100px;" name="ap_detail_prepare"><?php if (isset($appointment->ap_detail_prepare)) {
                                                                                                                                                    echo $appointment->ap_detail_prepare;
                                                                                                                                                } ?></textarea>
                                    <?php } ?>
                                </div>
                                <?php if (!$is_view_appointment) { ?>
                                    <div class="col-md-12 pt-3 container-appointment">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_draft_tools" id="is_draft_tools">
                                            <label for="is_draft_tools" class="form-check-label"> <?php echo $order_no; ?>.5 ต้องการกำหนดเครื่องมือหัตถการที่ต้องตรวจในวันนัดหมาย</label>
                                            <input name="is_draft_tools_checked" id="is_draft_tools_checked" value="off" type="hidden" <?php echo $is_view_appointment; ?>>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-12 pt-3 container-appointment">
                                        <label for="is_draft_tools" class="form-check-label"> <?php echo $order_no; ?>.5 กำหนดเครื่องมือหัตถการที่ต้องตรวจในวันนัดหมาย</label>
                                    </div>
                                <?php } ?>
                                <div class="col-md-12 container-appointment draft-tool">
                                    <?php if ($is_officer && !$is_view_appointment) {  ?>
                                        <button type="button" class="btn btn-primary" onclick="add_row_tool('#tool-draft')"><i class="bi-plus"></i> เพิ่มเครื่องมือหัตถการ</button>
                                    <?php }  ?>
                                </div>
                                <div class="col-md-12 container-appointment draft-tool">
                                    <table class="table" width="100%">
                                        <thead class="dataTable">
                                            <tr>
                                                <th width="8%" class="text-center">#</th>
                                                <th width="30%" class="text-center">ห้องปฏิบัติการ</th>
                                                <th width="30%" class="text-center">เครื่องมือหัตถการ</th>
                                                <th width="20%" class="text-center">สถานะ</th>
                                                <?php if(empty($is_view_appointment)) { ?>
                                                    <th width="10%" class="text-center"></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody id="tool-draft">
                                            <!-- draft tool -->
                                            <?php if(empty($ap_tool_drafts) && !empty($is_view_appointment) && !empty($appointment)) { ?>
                                                <tr class="no_row_tool">
                                                    <td class="text-center" colspan="<?php echo !empty($is_view_appointment) ? 4 : 5; ?>">ไม่มีรายการข้อมูล</td>
                                                </tr>
                                            <?php } else if(empty($ap_tool_drafts) && empty($tools) && empty($tools_default)) { ?>
                                                <tr class="no_row_tool">
                                                    <td class="text-center" colspan="<?php echo !empty($is_view_appointment) ? 4 : 5; ?>">ไม่มีรายการข้อมูล</td>
                                                </tr>
                                            <?php } 
                                                else if(!empty($ap_tool_drafts) && !empty($appointment)) { 
                                                $index_tool = 0; ?>
                                                <?php 
                                                    foreach ($ap_tool_drafts as $row) {
                                                ?>
                                                <tr>
                                                    <input name="draft_exr_id[]" value="<?php echo $row['exr_id']; ?>" type="hidden">
                                                    <td class="text-center"><?php echo ($index_tool+1); ?></td>
                                                    <td>
                                                        <?php if(empty($is_view_appointment)) { ?>
                                                            <select class="form-select select2 rm_id" data-placeholder="-- กรุณาเลือกห้องปฏิบัติการ --" name="draft_rm_id[]" id="draft_rm_id_<?php echo $index_tool; ?>" onchange="trigger_select_onchange('draft_rm_id_<?php echo $index_tool; ?>', 'draft_eqs_id_<?php echo $index_tool; ?>')">
                                                                <option value=""></option>
                                                                <?php foreach ($rooms as $rm) {
                                                                    $selected = decrypt_id($rm['rm_id']) == decrypt_id($row['rm_id']) ? 'selected' : '';
                                                                ?>
                                                                    <option value="<?php echo $rm['rm_id']; ?>" <?php echo $selected; ?>><?php echo $rm['rm_name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { echo $row['rm_name']; } ?>
                                                    </td> 
                                                    <td>
                                                        <?php if(empty($is_view_appointment)) { ?>
                                                            <select class="form-select select2 eqs_id" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="draft_eqs_id[]" id="draft_eqs_id_<?php echo $index_tool; ?>">
                                                                <option value=""></option>
                                                                <?php foreach ($equipments as $eqs) { 
                                                                    if(decrypt_id($eqs['eqs_rm_id']) == decrypt_id($row['rm_id']) && $eqs['eqs_fmst_id'] == 12) { // ประเภทเครื่องมือหัตถการ
                                                                        $selected = decrypt_id($eqs['eqs_id']) == decrypt_id($row['exr_eqs_id']) ? 'selected' : '';
                                                                ?>
                                                                    <option value="<?php echo $eqs['eqs_id']; ?>" <?php echo $selected; ?>><?php echo $eqs['eqs_name']; ?></option>
                                                                <?php }} ?>
                                                            </select>
                                                            <input name="draft_eqs_id_name[]" value="draft_eqs_id_<?php echo $index_tool; ?>" type="hidden">
                                                        <?php } else { echo $row['eqs_name']; } ?>
                                                    </td>
                                                    <td class="text-center">บันทึกร่าง</td>
                                                    <?php if(empty($is_view_appointment)) { ?>
                                                        <td class="text-center option"><button type="button" class="btn btn-danger removeElement"><i class="bi-x"></i></button></td>
                                                    <?php } ?>
                                                </tr>
                                                <?php $index_tool++; } ?>
                                            <?php } 
                                                else if((empty($ap_tool_drafts) && !$is_view_appointment) || empty($appointment)) { 
                                                    $index_tool = 0; 
                                                    if(empty($tools_default) && empty($tools)) { ?>
                                                        <tr class="no_row_tool">
                                                            <td class="text-center" colspan="5">ไม่มีรายการข้อมูล</td>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <!-- tool default of stde -->
                                                        <?php 
                                                            foreach ($tools_default as $row) {
                                                        ?>
                                                        <tr>
                                                            <input name="draft_exr_id[]" value="" type="hidden">
                                                            <td class="text-center"><?php echo ($index_tool+1); ?></td>
                                                            <td>
                                                                <select class="form-select select2 rm_id" data-placeholder="-- กรุณาเลือกห้องปฏิบัติการ --" name="draft_rm_id[]" id="draft_rm_id_<?php echo $index_tool; ?>" onchange="trigger_select_onchange('draft_rm_id_<?php echo $index_tool; ?>', 'draft_eqs_id_<?php echo $index_tool; ?>')">
                                                                    <option value=""></option>
                                                                    <?php foreach ($rooms as $rm) {
                                                                        $selected = decrypt_id($rm['rm_id']) == decrypt_id($row['eqs_rm_id']) ? 'selected' : '';
                                                                    ?>
                                                                        <option value="<?php echo $rm['rm_id']; ?>" <?php echo $selected; ?>><?php echo $rm['rm_name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2 eqs_id" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="draft_eqs_id[]" id="draft_eqs_id_<?php echo $index_tool; ?>">
                                                                    <option value=""></option>
                                                                    <?php foreach ($equipments as $eqs) { 
                                                                        if(decrypt_id($eqs['eqs_rm_id']) == decrypt_id($row['eqs_rm_id']) && $eqs['eqs_fmst_id'] == 12) { // ประเภทเครื่องมือหัตถการ
                                                                            $selected = decrypt_id($eqs['eqs_id']) == decrypt_id($row['ddt_eqs_id']) ? 'selected' : '';
                                                                    ?>
                                                                        <option value="<?php echo $eqs['eqs_id']; ?>" <?php echo $selected; ?>><?php echo $eqs['eqs_name']; ?></option>
                                                                    <?php }} ?>
                                                                </select>
                                                                <input name="draft_eqs_id_name[]" value="eqs_id_<?php echo $index_tool; ?>" type="hidden">
                                                            </td>
                                                            <td class="text-center">ยังไม่ได้รับการเข้าตรวจ</td>
                                                            <td class="text-center option"><button type="button" class="btn btn-danger removeElement"><i class="bi-x"></i></button></td>
                                                        </tr>
                                                        <?php $index_tool++; } ?>
                                                        <!-- tool of disease -->
                                                        <?php 
                                                            foreach ($tools as $row) {
                                                        ?>
                                                        <tr>
                                                            <input name="draft_exr_id[]" value="" type="hidden">
                                                            <td class="text-center"><?php echo ($index_tool+1); ?></td>
                                                            <td>
                                                                <select class="form-select select2 rm_id" data-placeholder="-- กรุณาเลือกห้องปฏิบัติการ --" name="draft_rm_id[]" id="draft_rm_id_<?php echo $index_tool; ?>" onchange="trigger_select_onchange('draft_rm_id_<?php echo $index_tool; ?>', 'draft_eqs_id_<?php echo $index_tool; ?>')">
                                                                    <option value=""></option>
                                                                    <?php foreach ($rooms as $rm) {
                                                                        $selected = decrypt_id($rm['rm_id']) == decrypt_id($row['eqs_rm_id']) ? 'selected' : '';
                                                                    ?>
                                                                        <option value="<?php echo $rm['rm_id']; ?>" <?php echo $selected; ?>><?php echo $rm['rm_name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2 eqs_id" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="draft_eqs_id[]" id="draft_eqs_id_<?php echo $index_tool; ?>">
                                                                    <option value=""></option>
                                                                    <?php foreach ($equipments as $eqs) { 
                                                                        if(decrypt_id($eqs['eqs_rm_id']) == decrypt_id($row['eqs_rm_id']) && $eqs['eqs_fmst_id'] == 12) { // ประเภทเครื่องมือหัตถการ
                                                                            $selected = decrypt_id($eqs['eqs_id']) == decrypt_id($row['ddt_eqs_id']) ? 'selected' : '';
                                                                    ?>
                                                                        <option value="<?php echo $eqs['eqs_id']; ?>" <?php echo $selected; ?>><?php echo $eqs['eqs_name']; ?></option>
                                                                    <?php }} ?>
                                                                </select>
                                                                <input name="draft_eqs_id_name[]" value="draft_eqs_id_<?php echo $index_tool; ?>" type="hidden">
                                                            </td>
                                                            <td class="text-center">ยังไม่ได้รับการเข้าตรวจ</td>
                                                            <td class="text-center option"><button type="button" class="btn btn-danger removeElement"><i class="bi-x"></i></button></td>
                                                        </tr>
                                                        <?php $index_tool++; } ?>
                                                    <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="row m-3">
                            <div class="col-md-12 mb-3 end-0">
                                <?php if ((isset($is_view) && (!$is_view)) && $is_officer) { ?>
                                    <!-- <button type="button" id="submit-save" class="btn btn-success ms-3 float-end">พบแพทย์เสร็จสิ้น</button> -->
                                    <!-- <button type="button" id="submit-draft" class="btn btn-info ms-3 float-end">บันทึกฉบับร่างการนัดหมายครั้งถัดไป</button> -->
                                <?php } ?>
                                
                                <?php if ($is_doctor) { ?>
                                    <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url() ?>index.php/ams/Notification_result'">ย้อนกลับ</button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-secondary float-start" onclick="closeModal('#modal-ntr', '#notification-result-date')">ย้อนกลับ</button>
                                    <!-- <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php //echo base_url() ?>index.php/wts/Manage_queue'">ย้อนกลับ</button> -->
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- </form> -->
</div>

<!-- Modal -->
<div id="examination-result-doc"></div>
<div class="modal fade" id="modal-load" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div id="modal-content-loading"></div>
            </div>
        </div>
    </div>
</div> 
<!-- <div class="modal fade" id="modal-exr" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div id="examination-result-doc"></div>
        </div>
    </div>
</div> -->


<script>
    // let is_have_appointment = '<?php //echo !empty($appointment) ? 1 : ''; ?>';
    // let is_view_appointment = '<?php //echo (isset($is_view) && ($is_view)) ? 1 : ''; // ($is_officer || (isset($is_view) && ($is_view)) ?>';
    
    <?php if($is_doctor) { ?>
        // let exr_table = null;
        let index_tools = 0;
        let order_tools = 0;
        let index_draft_tools = 0;
        let order_draft_tools = 0;
        let is_first_load_exr = true;
        let refreshInterval_modal;
    <?php } ?>

    $(document).ready(function() {
        // init
        initTinyMCE();

        $('.select2').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: true,
        });

        <?php if($is_officer) { ?>
            index_tools = 0;
            order_tools = 0;
            index_draft_tools = 0;
            order_draft_tools = 0;
            is_first_load_exr = true;
            refreshInterval_modal;
        <?php } ?>

        // medical tools
        if(order_tools > 0) {
            $('#container-tool-btn').show();
        } 
        // else {
        //     // // case if ams_appointment.ap_date same with ams_appointment.apm_date
        //     // if (empty($appointment)) {
        //     //     $num += $draft_amount;
        //     //     $num += $exr_amount;
        //     // }
        //     let count = $('#examination-result-table tbody tr').length;
        //     console.log(count);
        //     default_tool_table();
        // }

        // Remove tools
        $('#tool-tbody').on('click', '.removeElement', function() {
            $(this).closest('tr').remove();
            
            order_tools = $('#examination-result-table tbody tr').not(':has(td.dt-empty)').length;
            if($('#tool-tbody tr').length == 0) {
                default_tool_table();
            } else {
                $('#tool-tbody tr').each(function(index) {
                    $(this).find('td').eq(0).text(order_tools + 1);
                    order_tools++;
                });
            }
        });
        // Remove draft tools
        $('#tool-draft').on('click', '.removeElement', function() {
            $(this).closest('tr').remove();

            if($('#tool-draft tr').length == 0) {
                no_row_tool('#tool-draft');
            } else {
                $('#tool-draft tr').each(function(index) {
                    $(this).find('td').eq(0).text(index + 1);
                });
            }
        });

        // next appointment
        $('.container-appointment').hide();
        if ('<?php echo !empty($appointment) ? 1 : ''; ?>') {
            $('#is_appointment').prop('checked', true);
        } else {
            $('#is_appointment').prop('checked', false);
        }
        check_is_appointment();

        $('#is_appointment').change(function() {
            check_is_appointment();
        });

        $('#is_draft_tools').change(function() {
            check_is_draft_tools();
        });

        // examination-result
        url = "<?php echo site_url('/ams/Notification_result/Notification_result_get_exrs_table'); ?>/" + '<?php echo $id; ?>',
        createDataTableServerExr('#examination-result-table', url)
        resetIntervalExr();

        init_count_row('#tool-tbody');
        init_count_row('#tool-draft');

        <?php //if($is_officer) { ?>
            // $('#modal-exr').modal({
            //     backdrop: 'static',
            //     keyboard: false
            // });
        <?php //} ?>

        // save button
        $('#submit-draft').on('click', function() {
            sendAjaxRequest('<?php echo base_url(); ?>index.php/ams/Notification_result/update_draft/<?php echo $id ?>');
        });

        $('#submit-save').on('click', function() {
            sendAjaxRequest('<?php echo base_url(); ?>index.php/ams/Notification_result/update_save/<?php echo $id ?>');
        });

        $('#submit-save-tool').on('click', function() {
            save_tools('<?php echo base_url(); ?>index.php/ams/Notification_result/Notification_result_update_tools/<?php echo $id ?>');
        });
    });

    function initTinyMCE() {
        // Destroy any existing TinyMCE instance
        if (tinymce.get('ap_detail_appointment')) {
            tinymce.get('ap_detail_appointment').remove();
        }
        if (tinymce.get('ap_detail_prepare')) {
            tinymce.get('ap_detail_prepare').remove();
        }

        // Initialize TinyMCE
        tinymce.init({
            selector: 'textarea.tinymce-editor',
            height: 300
        });
    }

    // submit form
    function getFormData(form) {
        const formData = new FormData();
        const formElements = document.getElementById(form).elements;
        tinymce.triggerSave();
        for (let i = 0; i < formElements.length; i++) {
            const element = formElements[i];
            if (element.name && element.type !== 'file') {
                formData.append(element.name, element.value);
            }
        }

        // formData.append('suggest', tinymce.get('suggest').getContent());
        // formData.append('result_physician', tinymce.get('result_physician').getContent());
        // formData.append('result_patient', tinymce.get('result_patient').getContent());

        // // Append files from the input element
        // for (let i = 0; i < fileInput.files.length; i++) {
        //     formData.append('files[]', fileInput.files[i]);
        // }

        return formData;
    }

    function sendAjaxRequest(url) {
        const formData = getFormData('updateform');
        let form = document.getElementById('updateform');

        if (form.checkValidity()) {
            clear_input_invalid();
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json', // Expect JSON from the server
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.data.status_response == status_response_success) {
                        dialog_success({ 'header': text_toast_save_success_header, 'body': text_toast_save_success_body }, data.data.returnUrl, false);
                    } else if (data.data.status_response == status_response_error) {
                        if (!is_null(data.data.error_inputs)) {
                          setInvalidInput(data.data.error_inputs);
                        }

                        if (!is_null(data.data.message_dialog))
                            dialog_error({ 'header': text_toast_save_error_header, 'body': data.data.message_dialog });
                        else
                            dialog_error({ 'header': text_toast_save_error_header, 'body': text_toast_save_error_body });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    let errorMessage = jqXHR.responseText || textStatus + ' - ' + errorThrown;
                    try {
                        // Parse the JSON error message
                        let jsonError = JSON.parse(errorMessage);
                        errorMessage = jsonError.message || errorMessage;
                    } catch (e) {
                        // If not JSON, use original message
                    }
                    dialog_error({
                        'header': 'AJAX Error',
                        'body': errorMessage
                    });
                }
            });
        }
        form.classList.add('was-validated')
    }

    function trigger_select_onchange(rm_id, eqs_id) {
        // draft_rm_id_
        // let eqs_id_index = "eqs_id_" + rm_id.split('rm_id_')[1];
        clear_select_eqs_id("#" + eqs_id);
        let url = "<?php echo base_url() ?>index.php/dim/Import_examination_result/Import_examination_result_get_equipments"
        get_select_onchange(rm_id, eqs_id, "rm_id", url);
    }

    function clear_select_rm_id(selector) {
        if (!$(selector).prop('disabled')) $(selector).val(null).trigger('change');
    }

    function clear_select_eqs_id(selector) {
        if (!$(selector).prop('disabled')) $(selector).val(null).trigger('change');
    }

    function get_select_onchange(select2Id, targetId, objName, url) {
        let select2Value = $('#' + select2Id).val();
        let target = $('#' + targetId);
        let data = {};
        data[objName] = select2Value;

        if (!is_null(select2Value)) {
            $.post(url, data)
                .done(function(responseData) {
                    target.empty();
                    target.prop('disabled', false);
                    target.html(responseData);
                })
                .fail(function() {
                    console.error("Error occurred");
                })
                .always(function() {
                    // Optional: Code to execute always after request finishes
                });
        } else {
            target.val(null);
            target.prop('disabled', true);
        }

    }

    function getCurrentDate() {
        const now = new Date();
        return now;
    }

    // Function to format Date object to 'H:i'
    function format(date) {
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${hours}:${minutes}`;
    }

    function thaiToGregorian(thaiDate) {
        const [day, month, year] = thaiDate.split('/').map(Number);
        const gregorianYear = year - 543;
        return new Date(gregorianYear, month - 1, day);
    }

    // Date, Time flatpickr
    flatpickr("#ap_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        time_24hr: true,
        minDate: format(getCurrentDate()), // Disable dates before today
        onReady: function(selectedDates, dateStr, instance) {
            let time = '<?php echo !empty($appointment) && !empty($appointment->ap_time) ? $appointment->ap_time : ""; ?>';
            console.log('ap_time', time)
            if(time)
                document.getElementById('ap_time').value = formatTime(time);
        },
        onOpen: function(selectedDates, dateStr, instance) {
            const selectedDateStr = $("#ap_date").val();
            const selectedDate = thaiToGregorian(selectedDateStr);
            if (selectedDate) {
                const now = getCurrentDate();
                if (selectedDate.toDateString() === now.toDateString()) {
                    instance.set('minDate', format(now)); // Set minDate to current time if today
                } else {
                    instance.set('minDate', '00:00'); // Set minDate to '00:00' if a future date
                }
            }
        },
    });
    flatpickr("#ap_date", {
        dateFormat: 'd/m/Y',
        locale: 'th',
        minDate: new Date().fp_incr(1), // Disable dates before today
        onReady: function(selectedDates, dateStr, instance) {
            let date = '<?php echo !empty($appointment) && !empty($appointment->ap_date) ? $appointment->ap_date : ""; ?>';
            if(date)
                document.getElementById('ap_date').value = formatDateToThai(date);
            // addMonthNavigationListeners();
            convertYearsToThai();
        },
        onOpen: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onValueUpdate: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
            if (!selectedDates || selectedDates.length === 0) { // ถ้ายังไม่ได้เลือกวันที่
                document.getElementById('ap_date').value = formatDateToThai(new Date()); // ใช้วันที่ปัจจุบัน
            } else {
                document.getElementById('ap_date').value = formatDateToThai(selectedDates[0]); // ใช้วันที่ที่เลือก
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            convertYearsToThai();
        }
    });

    // examination-result
    function createDataTableServerExr(selector, url) {
        searchParams =  {
            is_view: '<?php echo (isset($is_view) && ($is_view)) ? 1 : ''; ?>',
            actor: '<?php echo (isset($actor) && !empty($actor)) ? $actor : ''; ?>',
        };

        $(selector).DataTable({
            "processing": true,
            "serverSide": true,
            "paging": false,  // Disable paging
            "searching": false,  // Disable searching
            "lengthChange": false,  // Disable entries per page dropdown
            "info": false,  // Disable showing table info
            "ordering": false,  // Disable sorting
            "ajax": {
                "url": url,
                "type": "POST",
                "data": searchParams , 
            },
            "columns": [
                { "data": "order", "orderable": false },
                { "data": "rm_id" },
                { "data": "eqs_id" },
                { "data": "sta_text" },
                { "data": "actions" },
            ],
            "language": {
                "decimal": "",
                "emptyTable": "ไม่มีรายการในระบบ",
                "info": "แสดงรายการที่ _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                "infoEmpty": "แสดงรายการที่ _END_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "lengthMenu": "_MENU_",
                "loadingRecords": "Loading...",
                "processing": "",
                "search": "",
                "searchPlaceholder": 'ค้นหา...',
                "zeroRecords": "ไม่พบรายการ",
                "paginate": {
                    "first": "«",
                    "last": "»",
                    "next": "›",
                    "previous": "‹"
                },
                "aria": {
                    "orderable": "Order by this column",
                    "orderableReverse": "Reverse order this column"
                },
            },
            "initComplete": function() {
                var api = this.api();
                api.on('draw', function() {
                    if (api.rows({ filter: 'applied' }).data().length === 0) {
                        $('.dataTables_empty').parent().html('<tr><td colspan="100%">ไม่พบรายการ</td></tr>');
                    }
                });
            },
            "drawCallback": function(settings) {
                // Get the number of rows
                const count = settings.json.data.length;

                // row element of datatable
                let row_selector = selector;
                row_selector = row_selector.replace("#", "#row-"); // Add 'row-' after the '#'

                // Use count to determine whether to hide or show the rows
                if (count === 0) {
                    $(row_selector).hide();
                } else {
                    $(row_selector).show();
                }

                // // setTooltipDefault(); // from main.js
                // const check = $('#examination-result-table tbody tr:has(td.dt-empty)').length;
                // if(check == 0 && !is_first_load_exr) {
                //     order_tools = $('#examination-result-table tbody tr').not('.dataTables_empty').length;
                //     // index_tools = order_tools;
                // } else {
                //     is_first_load_exr = false;
                // }
            }
        });
    }

    function reloadDataTableExr() {
        $('#examination-result-table').DataTable().ajax.reload(null, false); // false to stay on the current page
    }

    function resetIntervalExr() {
        if (refreshInterval_modal) {
            clearInterval(refreshInterval_modal);
        }
        refreshInterval_modal = setInterval(function() {
            reloadDataTableExr();
        }, datatable_second_reload);
    }

    function stopIntervalExr() {
        if (refreshInterval_modal) {
            clearInterval(refreshInterval_modal);
            refreshInterval_modal = null; // Optionally, set it to null to indicate that the interval is stopped
        }
    }

    function loadModalExrs(exr_id) {
        $('#modal-load').modal('show');
        $('#modal-content-loading').html(`
            <div class="center-container">
                <div class="spinner-border text-info" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>`);
        $.ajax({
            url: "<?php echo site_url('/ams/Notification_result/Notification_result_get_docs'); ?>/" + exr_id,
            method: "GET",
            success: function(data) {
                $('#examination-result-doc').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('AJAX error:', textStatus, errorThrown);
            }
        });
    }
    
    function alertCancel(exr_id) {
        let url = "<?php echo base_url() . 'index.php/dim/Import_examination_result/Import_examination_result_cancel/'?>" + exr_id;
        Swal.fire({
                title: "ยกเลิกคำสั่งตรวจ",
                html: `ต้องการยกเลิกคำสั่งตรวจ`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#dc3545",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: { sta_id: result.value },
                        success: function (data) {
                            if (data.status_response == "<?php echo $this->config->item('status_response_success'); ?>") {
                                reloadDataTableExr();
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Something went wrong!',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                            // if (data.status_response == "<?php// echo $this->config->item('status_response_success'); ?>") {
                            //     Swal.fire({
                            //         title: 'ยืนยันการบันทึกข้อมูล',
                            //         text: 'ข้อมูลได้รับการบันทึกเรียบร้อยแล้ว',
                            //         icon: 'success',
                            //         confirmButtonText: 'ตกลง',
                            //         customClass: {
                            //         htmlContainer: 'swal2-html-line-height'
                            //         },
                            //     }).then(() => {
                            //         // location.reload();
                            //         // resetInterval();
                            //         reloadDataTable();
                            //     });
                            // } else {
                            //     Swal.fire({
                            //         title: 'Error',
                            //         text: 'Something went wrong!',
                            //         icon: 'error',
                            //         confirmButtonText: 'OK'
                            //     });
                            // }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr);
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred while processing your request.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
    }

    // is_appointment
    function check_is_appointment() {
        if('<?php echo (isset($is_view) && ($is_view)) ? 1 : ''; // ($is_officer || (isset($is_view) && ($is_view)) ?>' != 1) {
            if ($('#is_appointment').is(':checked')) {
                $('#is_appointment_checked').val("on");
                $('.container-appointment').show();
                
                // draft tool
                // $('.draft-tool').hide();
                // if ('<?php //echo !empty($appointment) ? 1 : ''; ?>') {
                if (false) {
                    $('#is_draft_tools').prop('checked', true);
                } else {
                    $('#is_draft_tools').prop('checked', false);
                }
                check_is_draft_tools();
            } else {
                // $('#is_appointment_checked').val("off");
                // $('.container-appointment').hide();

                if('<?php echo !empty($is_view_appointment) && !empty($is_show_appointment) ? 1 : ''; ?>' == 1) {
                    $('.container-appointment').show();
                } else {
                    $('.container-appointment').hide();
                }
            }
        } else {
            $('.container-appointment').show();

            // draft tool
            // $('.draft-tool').hide();
            // if ('<?php //echo !empty($appointment) ? 1 : ''; ?>') {
            if (false) {
                $('#is_draft_tools').prop('checked', true);
            } else {
                $('#is_draft_tools').prop('checked', false);
            }
            check_is_draft_tools();
        }
    }

    // draft tool
    function check_is_draft_tools() {
        if('<?php echo (isset($is_view) && ($is_view)) ? 1 : ''; ?>' != 1) {
            if ($('#is_draft_tools').is(':checked')) {
                $('#is_draft_tools_checked').val("on");
                $('.draft-tool').show();
            } else {
                // $('#is_draft_tools_checked').val("off");
                // $('.draft-tool').hide();

                if('<?php echo !empty($is_view_appointment) && !empty($is_show_appointment) ? 1 : ''; ?>' == 1) {
                    $('.draft-tool').show();
                } else {
                    $('.draft-tool').hide();
                }
            }
        } else {
            $('.draft-tool').show();
        }
    }
    
    // tools
    function add_row_tool(selector) {
        let rm_id = '';
        let eqs_id = '';
        let rm_id_name = '';
        let eqs_id_name = '';
        let exr_id_name = '';
        let order = 0;
        let index = 0;

        if(selector == '#tool-tbody') {
            // $('#submit-draft').hide();
            // $('#submit-save').html("ส่งตัวผู้ป่วยเข้าห้องปฏิบัติการ");
            // $('#is_test_with_tool_checked').val("on");
            
            if ($(selector + ' .no_row_tool').length) 
                $(selector + ' .no_row_tool').remove();

            order_tools = $('#examination-result-table tbody tr').not(':has(td.dt-empty)').length;
            order_tools += $('#tool-tbody tr').not(':has(td.dt-empty)').length;
            order_tools++;
            index_tools++;
            order = order_tools;
            index = index_tools;

            rm_id = 'rm_id_';
            eqs_id = 'eqs_id_';
            rm_id_name = 'rm_id[]';
            eqs_id_name = 'eqs_id[]';
            eqs_id_name_name = 'eqs_id_name[]';
            exr_id_name = 'exr_id[]';
        } else {
            if ($(selector + ' .no_row_tool').length) 
                $(selector + ' .no_row_tool').remove();

            // order = $('tbody#tool-draft tr').length + 1;
            // index = order;

            order_draft_tools = $('#tool-draft tr').not(':has(td.dt-empty)').length;
            order_draft_tools++;
            index_draft_tools++;
            order = order_draft_tools;
            index = index_draft_tools;

            rm_id = 'draft_rm_id_';
            eqs_id = 'draft_eqs_id_';
            rm_id_name = 'draft_rm_id[]';
            eqs_id_name = 'draft_eqs_id[]';
            eqs_id_name_name = 'draft_eqs_id_name[]';
            exr_id_name = 'draft_exr_id[]';
        }

        
        let btn = `     <button type="button" title="ลบรายการ" class="btn btn-danger removeElement"><i class="bi-x-lg"></i></button>`;
        let newElement = `
        <tr>
            <input name="${exr_id_name}" value="" type="hidden">
            <td class="text-center">${order}</td>
            <td>
                <select class="form-select select2 rm_id" data-placeholder="-- กรุณาเลือกห้องปฏิบัติการ --" name="${rm_id_name}" id="${rm_id}${index}" onchange="trigger_select_onchange('${rm_id}${index}', '${eqs_id}${index}')">
                    <option value=""></option>
                    <?php foreach ($rooms as $row) { ?>
                        <option value="<?php echo $row['rm_id']; ?>"><?php echo $row['rm_name']; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <select class="form-select select2 eqs_id" data-placeholder="-- กรุณาเลือกเครื่องมือหัตถการ --" name="${eqs_id_name}" id="${eqs_id}${index}" disabled>
                    <option value=""></option>
                </select>
                <input name="${eqs_id_name_name}" value="${eqs_id}${index}" type="hidden">
            </td>
            <td class="text-center text-success"><i class="bi-plus-lg"></i> เพิ่มใหม่</td>
            <td class="text-center option">${btn}</td>
        </tr>`;

        $(selector).append(newElement);

        // Reinitialize select2 for new elements
        $(`#${rm_id}${index}, #${eqs_id}${index}`).select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: true,
        });

        // add div invalid-feedback for alert validate
        let div = document.createElement("div");
        div.classList.add('invalid-feedback')
        div.append(text_invalid_default);
        let element1 = document.querySelector(`#${rm_id}${index}`).nextElementSibling.closest('.select2-container');
        let element2 = document.querySelector(`#${eqs_id}${index}`).nextElementSibling.closest('.select2-container');
        element1.insertAdjacentElement('afterend', div);
        element2.insertAdjacentElement('afterend', div);

        if(selector == '#tool-tbody') 
            $('#container-tool-btn').show();
    }

    function init_count_row(selector) {
        if(selector == '#tool-tbody') {
            order_tools = $('#examination-result-table tbody tr').not(':has(td.dt-empty)').length;
            order_tools += $('#tool-tbody tr').not(':has(td.dt-empty)').length;
            index_tools = order_tools;
        } else {
            order_draft_tools = $('#tool-draft tr').not(':has(td.dt-empty)').length;
            index_draft_tools = order_draft_tools;
        }

    }

    function no_row_tool(selector) {
        let newElement = `
        <tr class="no_row_tool">
            <td class="text-center" colspan="5">ไม่มีรายการข้อมูล</td>
        </tr>`;

        $(selector).append(newElement);
    }

    function save_tools(url) {
        const formData = getFormData('toolform');
        let form = document.getElementById('toolform');

        if (form.checkValidity()) {
            clear_input_invalid();
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json', // Expect JSON from the server
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.data.status_response == status_response_success) {
                        reloadDataTableExr();
                        $('#tool-tbody').empty();
                        default_tool_table();
                        dialog_success({ 'header': text_toast_save_success_header, 'body': text_toast_save_success_body }, null, false);
                    } else if (data.data.status_response == status_response_error) {
                        if (!is_null(data.data.error_inputs)) {
                          setInvalidInput(data.data.error_inputs);
                        }

                        if (!is_null(data.data.message_dialog))
                            dialog_error({ 'header': text_toast_save_error_header, 'body': data.data.message_dialog });
                        else
                            dialog_error({ 'header': text_toast_save_error_header, 'body': text_toast_save_error_body });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    let errorMessage = jqXHR.responseText || textStatus + ' - ' + errorThrown;
                    try {
                        // Parse the JSON error message
                        let jsonError = JSON.parse(errorMessage);
                        errorMessage = jsonError.message || errorMessage;
                    } catch (e) {
                        // If not JSON, use original message
                    }
                    dialog_error({
                        'header': 'AJAX Error',
                        'body': errorMessage
                    });
                }
            });
        }
        form.classList.add('was-validated')
        reload_que(); // from wts v_manage_trello_show
    }

    function default_tool_table() {
        no_row_tool('#tool-tbody');
        // order_tools = 0;
        $('#container-tool-btn').hide();
    }

    function closeModal(selector, content) {
        $(selector).modal('hide');
        $(content).empty();
        stopIntervalExr();
    }
</script>