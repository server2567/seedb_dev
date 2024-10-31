<style>
    .card form button.accordion-button:not(.collapsed) {
        color: var(--bs-primary);
    }
    /* เดี๋ยวกลับมาแก้ */
    .card form .accordion-item:first-of-type {
        border-top-left-radius: var(--bs-accordion-border-radius);
        border-top-right-radius: var(--bs-accordion-border-radius);
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .card form .accordion-item:last-of-type {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: var(--bs-accordion-border-radius);
        border-bottom-right-radius: var(--bs-accordion-border-radius);
    }
    .card form .accordion-item:not(:first-of-type):not(:last-of-type) {
        border-radius: 0 !important;
    }
</style>
<div class="card">
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd" aria-expanded="true" aria-controls="collapseAdd">
                    <i class="bi-window-dock icon-menu"></i><span><?php echo !empty($bg_id) ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูลกลุ่มผู้ใช้</span>
                </button>
            </h2>
            <div id="collapseAdd" class="accordion-collapse collapse show" aria-labelledby="headingAdd">
                <div class="accordion-body">
				    <form class="row g-3 needs-validation" novalidate method="post" action="<?php echo base_url()."index.php/ums/System_base_group/"; ?><?php echo !empty($bg_id) ? "base_group_update/".$bg_id : "base_group_insert"; ?>">
                        <div class="col-md-6">
                            <label for="bg_name_th" class="form-label required">ชื่อกลุ่มผู้ใช้(ท)</label>
                            <input type="text" class="form-control" name="bg_name_th" id="bg_name_th" placeholder="ชื่อกลุ่มผู้ใช้ภาษาไทย" value="<?php echo !empty($edit) ? $edit['bg_name_th'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="bg_name_en" class="form-label required">ชื่อกลุ่มผู้ใช้(E)</label>
                            <input type="text" class="form-control" name="bg_name_en" id="bg_name_en" placeholder="ชื่อกลุ่มผู้ใช้ภาษาอังกฤษ" value="<?php echo !empty($edit) ? $edit['bg_name_en'] : "" ;?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="bg_active" class="form-label">สถานะ</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="bg_active" id="bg_active" <?php echo !empty($edit) && $edit['bg_active'] == 1 ? "checked" : "" ;?>>
                                <label for="bg_active" class="form-check-label">เปิดใช้งาน</label>
                            </div>
                        </div>
                        
                        <div class="col-md-12 mt-3 mb-3 d-flex justify-content-center">
                            <div class="col-md-8">
                                <label for="" class="form-label">สิทธิ์การใช้งาน</label>
                                <input type="hidden" name="user_group_permission">  <!-- for show error -->
                                <div class="accordion mt-3">
                                <?php 
                                    $i=0;
                                    foreach ($systems as $sys) {
                                        $count_group = 0;
                                        foreach ($groups as $grp) { 
                                            if($sys['st_id'] == $grp['gp_st_id'])
                                            $count_group++;
                                        }
                                ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading<?php echo $i+1; ?>">
                                            <button class="accordion-button bg-warning-subtle collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i+1; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i+1; ?>">
                                            <?php echo $sys['st_name_th']; ?>
                                            </button>
                                        </h2>
                                        <div id="collapse<?php echo $i+1; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $i+1; ?>" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <?php
                                                    if($count_group == 0) {
                                                ?>
                                                    <div class="text-center"><?php echo $this->config->item('text_table_no_data'); ?></div>
                                                <?php } else { ?>
                                                <?php
                                                    foreach ($groups as $grp) { 
                                                        if($sys['st_id'] == $grp['gp_st_id']) {
                                                            $gp_id = encrypt_id($grp['gp_id']);
                                                            $is_checked = ""; //$menu['gpn_active'] == 1 ? "checked" : 
                                                            if(!empty($edit_bg_permissions)) {
                                                                foreach ($edit_bg_permissions as $bgp) { 
                                                                    if($bgp['ugp_gp_id'] == $grp['gp_id'])
                                                                    $is_checked = "checked";
                                                                }
                                                            }
                                                ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="is_active-<?php echo $gp_id; ?>" id="is_active-<?php echo $gp_id; ?>" <?php echo $is_checked; ?>>
                                                        <input type="hidden" name="checkbox_id[]" value="is_active-<?php echo $gp_id; ?>">
                                                        <label class="form-check-label" for="<?php echo $gp_id; ?>"><?php echo $grp['gp_name_th']; ?></label>
                                                    </div>
                                                <?php
                                                    } } }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php 
                                    $i++; } 
                                ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-start" onclick="window.location.href='<?php echo base_url()?>index.php/ums/System_base_group'">ย้อนกลับ</button>
                            <button type="submit" class="btn btn-success float-end">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>